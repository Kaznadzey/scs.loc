<?php

/**
 * @author Nazar Kaznadzey
 * @copyright 2015
 */

namespace SCSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="actual_reports_config")
 */
class ActualReportsConfig
{
	/**
	 * @ORM\Id
   * @ORM\Column(type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $arc_id;

  /**
   * @ORM\Column(type="integer", length=3)
   */
  protected $ar_id;
  
  /**
   * @ORM\Column(type="integer", length=2)
   */
  protected $cg_id;
  
  /**
   * @ORM\Column(type="integer", length=2)
   */
  protected $rp_id;
  
  /**
   * @ORM\Column(type="integer", length=2)
   */
  protected $arc_days_qty;
  
  /**
   * @ORM\Column(type="integer", length=1)
   */
  protected $arc_next_period;
  
  /**
   * @ORM\Column(type="integer", length=1)
   */
  protected $arc_next_day;

    /**
     * Set arcId
     *
     * @param integer $arcId
     *
     * @return ActualReportsConfig
     */
    public function setArcId($arcId)
    {
        $this->arc_id = $arcId;

        return $this;
    }

    /**
     * Get arcId
     *
     * @return integer
     */
    public function getArcId()
    {
        return $this->arc_id;
    }

    /**
     * Set arId
     *
     * @param integer $arId
     *
     * @return ActualReportsConfig
     */
    public function setArId($arId)
    {
        $this->ar_id = $arId;

        return $this;
    }

    /**
     * Get arId
     *
     * @return integer
     */
    public function getArId()
    {
        return $this->ar_id;
    }

    /**
     * Set cgId
     *
     * @param integer $cgId
     *
     * @return ActualReportsConfig
     */
    public function setCgId($cgId)
    {
        $this->cg_id = $cgId;

        return $this;
    }

    /**
     * Get cgId
     *
     * @return integer
     */
    public function getCgId()
    {
        return $this->cg_id;
    }

    /**
     * Set rpId
     *
     * @param integer $rpId
     *
     * @return ActualReportsConfig
     */
    public function setRpId($rpId)
    {
        $this->rp_id = $rpId;

        return $this;
    }

    /**
     * Get rpId
     *
     * @return integer
     */
    public function getRpId()
    {
        return $this->rp_id;
    }

    /**
     * Set arcDaysQty
     *
     * @param integer $arcDaysQty
     *
     * @return ActualReportsConfig
     */
    public function setArcDaysQty($arcDaysQty)
    {
        $this->arc_days_qty = $arcDaysQty;

        return $this;
    }

    /**
     * Get arcDaysQty
     *
     * @return integer
     */
    public function getArcDaysQty()
    {
        return $this->arc_days_qty;
    }

    /**
     * Set arcNextPeriod
     *
     * @param integer $arcNextPeriod
     *
     * @return ActualReportsConfig
     */
    public function setArcNextPeriod($arcNextPeriod)
    {
        $this->arc_next_period = $arcNextPeriod;

        return $this;
    }

    /**
     * Get arcNextPeriod
     *
     * @return integer
     */
    public function getArcNextPeriod()
    {
        return $this->arc_next_period;
    }

    /**
     * Set arcNextDay
     *
     * @param integer $arcNextDay
     *
     * @return ActualReportsConfig
     */
    public function setArcNextDay($arcNextDay)
    {
        $this->arc_next_day = $arcNextDay;

        return $this;
    }

    /**
     * Get arcNextDay
     *
     * @return integer
     */
    public function getArcNextDay()
    {
        return $this->arc_next_day;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
