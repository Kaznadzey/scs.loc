<?php

namespace SCSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use SCSBundle\Entity\ReportRepository;

class ReportController extends Controller
{
	/**
	 * метод за допомогою якого ми будуэмо форму
	 * параметрів не потрібно, так як робимо мінімальний функціонал, і самий простий
	 */
  public function homeAction()
  {
  	/**
  	 * форму можна було б створити через спеціальний Symfony2 component (Form)
  	 * але через те що хочу зробити швидко і якісно
  	 * вирішив поки що зробити примітивно через шаблонізатор
  	 */
    return $this->render('ReportBundle:Report:home.html.twig', $this->_getReportFiltersParams());
  }
  
  /**
   * метод за допомогою якого ми формуємо параметри для форми
   * зараз просто все забиваю вручну, так як це тестове завдання
   * на живому проекті всі ці налаштування будемо виносити звідси в БД
   */
  private function _getReportFiltersParams()
  {
  	$aParams = array();
  	
  	/**
  	 * можливі групи підприємств
  	 */
  	$aParams['group_types'] = array();
  	$aParams['group_types'][] = array(
  		'id'		=> 1,
  		'name'	=> 'ФОП 1 група'
		);
		$aParams['group_types'][] = array(
  		'id'		=> 2,
  		'name'	=> 'ФОП 2 група'
		);
		$aParams['group_types'][] = array(
  		'id'		=> 3,
  		'name'	=> 'ФОП 3 група'
		);
		$aParams['group_types'][] = array(
  		'id'		=> 4,
  		'name'	=> 'Юр.особа 4 група'
		);
		$aParams['group_types'][] = array(
  		'id'		=> 5,
  		'name'	=> 'ФОП 5 група'
		);
		$aParams['group_types'][] = array(
  		'id'		=> 6,
  		'name'	=> 'Юр.особа 6 група'
		);
		
		/**
		 * конфігурація допустимих років
		 * минулий рік вибрати не можна
		 */
		$aParams['years'] = array();
		$iCurrenctYear = date('Y', time());
		$aParams['years']['current'] = $iCurrenctYear;
		$aParams['years']['list'] = array();
		for($i = $iCurrenctYear; $i <= $iCurrenctYear + 10; $i++)
			$aParams['years']['list'][] = $i;
			
		/**
		 * конфігурація періодичності оплати
		 */
		$aParams['report_types'] = array();
		$aParams['report_types'][] = array(
			'id'		=> 3,
			'name'	=> 'Місяць'
		);
		$aParams['report_types'][] = array(
			'id'		=> 2,
			'name'	=> 'Квартал'
		);
		
		$aParams['languages'] = array();
		$aParams['languages'][] = array(
			'id'		=> 1,
			'name'	=> 'Русский'
		);
		$aParams['languages'][] = array(
			'id'		=> 2,
			'name'	=> 'Українська'
		);
			
  	return $aParams;
  }
  
  /**
   * функція відповідає за обробку результатів виборки і повернення її кінцевому користувачеві
   */
  public function loadReportsAction()
  {
  	$aResult = array(
  		'content' => ''
		);
		
		$oRequest = Request::createFromGlobals();
		
		/**
		 * приймаємо і формуємо до нормального вигляду всі параметри
	   */
		$aParams = array(
			'group_type'		=> $oRequest->request->get('group_type'),
			'year'					=> $oRequest->request->get('year'),
			'report_type'		=> $oRequest->request->get('report_type'),
			'date_from'			=> $oRequest->request->get('date_from'),
			'date_to'				=> $oRequest->request->get('date_to'),
			'language_id'		=> $oRequest->request->get('report_language')
		);
		
		$aDate 								= explode('.', $aParams['date_from']);
		$aParams['date_from'] = $aParams['year'] . '-' . $aDate[1] . '-' . $aDate[0];
		$aDate 								= explode('.', $aParams['date_to']);
		$aParams['date_to'] 	= $aParams['year'] . '-' . $aDate[1] . '-' . $aDate[0];
		
		$oRR = new ReportRepository($aParams, $this->getDoctrine());
		$aActions = $oRR->getActualReportsAccordingParams();
		
		$aResult['content'] = $this->render('ReportBundle:Report:actions.html.twig', array('actions' => $aActions))->getContent();
		
		$oResponse = new Response();
  	
  	return $oResponse->setContent(json_encode($aResult));
  }
}