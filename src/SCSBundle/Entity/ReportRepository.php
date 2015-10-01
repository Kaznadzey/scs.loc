<?php

/**
 * @author Nazar Kaznadzey
 * @copyright 2015-10-01 22:30:23
 */

namespace SCSBundle\Entity;

use Doctrine\ORM\EntityManager;

class ReportRepository 
{
	/**
	 * ID групи для звіту
	 */
 	protected $_iCompanyGroupId = 0;
 	
 	/**
 	 * Entyty manager
 	 */
 	protected $_oDoctine;
 	
 	protected $_aParams = array();
 	
 	private $_aQuarterConfig = array(
 		1 => array(
 			'monthes' => array(12, 1, 2),
 			'start'		=> '12-01'
	 	),
	 	2 => array(
 			'monthes' => array(3, 4, 5),
 			'start'		=> '03-01'
	 	),
	 	3 => array(
 			'monthes' => array(6, 7, 8),
 			'start'		=> '06-01'
	 	),
	 	4 => array(
 			'monthes' => array(9, 10, 11),
 			'start'		=> '09-01'
	 	),
 	);
 	
 	/**
 	 * ініціалізуємо систему, передав їй всі необхідні параметри
 	 */
	public function __construct($aParams = array(), $oDoctrine)
	{
		if(isset($aParams['group_type']) && $aParams['group_type'] > 0)
			$this->_iCompanyGroupId = intval($aParams['group_type']);
			
		$this->_aParams 	= $aParams;			
		$this->_oDoctine 	= $oDoctrine;
			
		return null;
	}
	
	/**
	 * метод, за допомогою якого ми отримаємо всю інформацію для нашого звіту
	 */
	public function getActualReportsAccordingParams()
	{
		$aMessages = array();
		if($this->_iCompanyGroupId <= 0)
			return $aMessages;
		
		$aReports = $this->_getAllCompanyGroupReports();
		
		if(!empty($aReports))
			$aMessages = $this->_prepareActualMessages($aReports);
		
		return $aMessages;
	}
	
	/**
	 * метод повертає всі звіти, які потрібно здати компанії за кожен
	 */
	private function _getAllCompanyGroupReports()
	{
		$oEM 			= $this->_oDoctine->getEntityManager();
		$oReports = $oEM->createQuery('SELECT arc FROM SCSBundle\Entity\ActualReportsConfig arc WHERE arc.cg_id = :id')->setParameter('id', $this->_iCompanyGroupId)->getResult();
		
		$aReports = array();
		foreach($oReports as $oReport)
		{
			$aReports[] = array(
				'id'					=> $oReport->getArcId(),
				'report_id'		=> $oReport->getArId(),
				'period_id'		=> $oReport->getRpId(),
				'days_qty'		=> $oReport->getArcDaysQty(),
				'next_period'	=> $oReport->getArcNextPeriod(),
				'next_day'		=> $oReport->getArcNextDay()
			);
		}
		
		unset($oReports);
		unset($oReport);
		
		return $aReports;
	}
	
	/**
	 * функція, яка уже поверне готові повідомлення для виведення
	 */
	private function _prepareActualMessages($aReports = array())
	{
		$iYear = 0;
		if(isset($this->_aParams['year']))
			$iYear = intval($this->_aParams['year']);
			
		$iPFrom = 0;
		if(isset($this->_aParams['date_from']))
			$iPFrom = strtotime($this->_aParams['date_from']);
		
		$iPTo = 0;
		if(isset($this->_aParams['date_to']))
			$iPTo = strtotime($this->_aParams['date_to']);

		if($iYear == 0 || $iPFrom == 0 || $iPTo == 0)
			return array();
			
		$aMessages = array();
		
		/**
		 * тут зберігаємо масив з місяцями, по який потрібно показати результат.
		 * рік у нас один, тому тут простіше
		 */
		$aPeriodMonthes = array();
		$iStartMonth 	= intval(date('m', $iPFrom));
		$iEndMonth 		= intval(date('m', $iPTo));
		if($iStartMonth == $iEndMonth)
			$aPeriodMonthes[] = $iStartMonth;
		else
		{
			for($i = $iStartMonth; $i <= $iEndMonth; $i++)
				$aPeriodMonthes[] = $i;
		}
		
		$aQuarters = array();
		foreach($aPeriodMonthes as $k => $v)
		{
			foreach($this->_aQuarterConfig as $key => $val)
			{
				if(!in_array($key, $aQuarters))
				{
					if(in_array($v, $val['monthes']))
					{
						$aQuarters[] = $key;
					}
				}
			}
		}
		
		foreach($aReports as $k => $v)
		{
			//єдиний налог. користувач сам обирає як йому платити
			if($v['report_id'] == 2)
			{
				if($v['period_id'] == 2 && $this->_aParams['report_type'] == 3)
					continue;
				elseif($v['period_id'] == 3 && $this->_aParams['report_type'] == 2)
					continue;
			}
			
			//повідомлення, які потрібно подавати раз в рік
			if($v['period_id'] == 1)
			{
				$iExpiridDate = strtotime('+' . $v['days_qty'] . ' days', strtotime($iYear . '-01-01'));
				
				if($iExpiridDate >= $iPFrom)
					$aMessages[] = $this->_prepareMessage($v['report_id'], $iExpiridDate, ($iYear - 1), $v['next_day']);
			}
			elseif($v['period_id'] == 2)
			{
				foreach($aQuarters as $key => $val)
				{
					$iExpiridDate = strtotime('+' . $v['days_qty'] . ' days', strtotime($iYear . '-' . $this->_aQuarterConfig[$val]['start']));
					if($iExpiridDate >= $iPFrom)
					{
						if($v['next_period'] == 1)
							$sPeriod = $val - 1;
						else
							$sPeriod = $val;
						$sPeriod = intval($sPeriod);
						if($sPeriod <= 0)
							$sPeriod = 4;
							
						$sPeriod .= '-й квартал';
						
						$aMessages[] = $this->_prepareMessage($v['report_id'], $iExpiridDate, $sPeriod, $v['next_day']);	
					}
				}
			}
			//собираємо повідомлення, які потрібно виводити помісячно
			elseif($v['period_id'] == 3)
			{
				foreach($aPeriodMonthes as $key => $val)
				{
					$iExpiridDate = strtotime($iYear . '-' . (strlen($val) == 1 ? '0' : '') . $val . '-' . $v['days_qty']);
					if($iExpiridDate >= $iPFrom)
					{
						if($v['next_period'] == 1)
							$iMonth = date('m', strtotime('-1 month', $iExpiridDate));
						else
							$iMonth = date('m', $iExpiridDate);
						$iMonth = intval($iMonth);
						
						$aMessages[] = $this->_prepareMessage($v['report_id'], $iExpiridDate, $this->_getMonthName($iMonth), $v['next_day']);	
					}
				}
			}
		}
		
		return $aMessages;
	}
	
	/**
	 * готуэмо повідомлення для виведення
	 */
	private function _prepareMessage($iReportId, $iExpiration, $sMessageEnd = '', $iNextDay = 0)
	{
		$oEM 			= $this->_oDoctine->getEntityManager();
		$aReport = $oEM->createQuery('SELECT ard.ard_name FROM SCSBundle\Entity\ActualReportsData ard WHERE ard.ar_id = :id AND ard.l_id = :l_id')->setParameter('id', $iReportId)->setParameter('l_id', $this->_aParams['language_id'])->getSingleResult();
		
		$iExpiration = $this->_prepareExpiration($iExpiration, $iNextDay);
		
		if($this->_aParams['language_id'] == 1)
			return 'Необходимо подать ' . $aReport['ard_name'] . ' до ' . date('Y-m-d', $iExpiration) . ' за ' . $sMessageEnd;
		else
			return 'Необхідно подати ' . $aReport['ard_name'] . ' до ' . date('Y-m-d', $iExpiration) . ' за ' . $sMessageEnd;
	}
	
	/**
	 * готуємо коректну дату з усіма переносами
	 */
	private function _prepareExpiration($iExpiration, $iNextDay = 0)
	{
		$oEM 			= $this->_oDoctine->getEntityManager();
		$aHoladay = $oEM->createQuery('SELECT nh.nh_id FROM SCSBundle\Entity\NationalHolidays nh WHERE nh.nh_day = :d AND nh.nh_month = :m')->setParameter('d', intval(date('d', $iExpiration)))->setParameter('m', intval(date('m', $iExpiration)))->getResult();
		
		if(!empty($aHoladay))
		{
			if($iNextDay == 0)
				$iExpiration = strtotime('-1 day', $iExpiration);
			else
				$iExpiration = strtotime('+1 day', $iExpiration);
				
			return $this->_prepareExpiration($iExpiration, $iNextDay);
		}
		else
		{
			$sWeekDay = date('D', $iExpiration);
			if($sWeekDay == 'Sat' || $sWeekDay == 'Sun')
			{
				if($iNextDay == 0)
				{
					if($sWeekDay == 'Sat')
						$iExpiration = strtotime('-1 day', $iExpiration);
					else
						$iExpiration = strtotime('-2 days', $iExpiration);
				}
				else
				{
					if($sWeekDay == 'Sat')
						$iExpiration = strtotime('+2 days', $iExpiration);
					else
						$iExpiration = strtotime('+1 day', $iExpiration);
				}
				
				return $this->_prepareExpiration($iExpiration, $iNextDay);
			}
		}
		
		return $iExpiration;
	}
	
	private function _getMonthName($iNumber = 0)
	{
		$aConfig = array(
			1 => array(
				1 	=> 'Январь',
				2 	=> 'Февраль',
				3 	=> 'Март',
				4 	=> 'Апрель',
				5 	=> 'Май',
				6 	=> 'Июнь',
				7 	=> 'Июль',
				8 	=> 'Август',
				9 	=> 'Сентябрь',
				10	=> 'Октябрь',
				11 	=> 'Ноябрь',
				12 	=> 'Декабрь',
			),
			2 => array(
				1 	=> 'Січень',
				2 	=> 'Лютий',
				3 	=> 'Березень',
				4 	=> 'Квітень',
				5 	=> 'Травень',
				6 	=> 'Червень',
				7 	=> 'Липень',
				8 	=> 'Серпень',
				9 	=> 'Вересень',
				10	=> 'Жовтень',
				11 	=> 'Листопад',
				12 	=> 'Грудень',
			)
		);
	
		return $aConfig[$this->_aParams['language_id']][intval($iNumber)];
	}
}

?>