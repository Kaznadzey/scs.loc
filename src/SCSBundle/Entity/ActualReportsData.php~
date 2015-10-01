<?php

/**
 * @author Nazar Kaznadzey
 * @copyright 2015
 */

namespace SCSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="actual_reports_data")
 */
class ActualReportsData
{
  /**
   * @ORM\Id
   * @ORM\Column(type="integer", length=3)
   */
  protected $ar_id;
  
  /**
   * @ORM\Column(type="integer", length=2)
   */
  protected $l_id;
  
  /**
   * @ORM\Column(type="string", length=50)
   */
  protected $ard_name;

    /**
     * Set arId
     *
     * @param integer $arId
     *
     * @return ActualReportsData
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
     * Set lId
     *
     * @param integer $lId
     *
     * @return ActualReportsData
     */
    public function setLId($lId)
    {
        $this->l_id = $lId;

        return $this;
    }

    /**
     * Get lId
     *
     * @return integer
     */
    public function getLId()
    {
        return $this->l_id;
    }

    /**
     * Set ardName
     *
     * @param string $ardName
     *
     * @return ActualReportsData
     */
    public function setArdName($ardName)
    {
        $this->ard_name = $ardName;

        return $this;
    }

    /**
     * Get ardName
     *
     * @return string
     */
    public function getArdName()
    {
        return $this->ard_name;
    }
}
