<?php

/**
 * @author Nazar Kaznadzey
 * @copyright 2015
 */

namespace SCSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="national_holidays")
 */
class NationalHolidays
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer", length=3)
   */
  protected $nh_id;
  
  /**
   * @ORM\Column(type="integer", length=2)
   */
  protected $nh_day;
  
  /**
   * @ORM\Column(type="integer", length=2)
   */
  protected $nh_month;

    /**
     * Set nhId
     *
     * @param integer $nhId
     *
     * @return NationalHolidays
     */
    public function setNhId($nhId)
    {
        $this->nh_id = $nhId;

        return $this;
    }

    /**
     * Get nhId
     *
     * @return integer
     */
    public function getNhId()
    {
        return $this->nh_id;
    }

    /**
     * Set nhDay
     *
     * @param integer $nhDay
     *
     * @return NationalHolidays
     */
    public function setNhDay($nhDay)
    {
        $this->nh_day = $nhDay;

        return $this;
    }

    /**
     * Get nhDay
     *
     * @return integer
     */
    public function getNhDay()
    {
        return $this->nh_day;
    }

    /**
     * Set nhMonth
     *
     * @param integer $nhMonth
     *
     * @return NationalHolidays
     */
    public function setNhMonth($nhMonth)
    {
        $this->nh_month = $nhMonth;

        return $this;
    }

    /**
     * Get nhMonth
     *
     * @return integer
     */
    public function getNhMonth()
    {
        return $this->nh_month;
    }
}
