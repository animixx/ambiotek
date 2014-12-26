<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sightdata
 *
 * @ORM\Table(name="sightdata", indexes={@ORM\Index(name="id_gps", columns={"id_gps"})})
 * @ORM\Entity(repositoryClass="Eye3\CaminosBundle\Entity\SightdataRepository")
 */
class Sightdata
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255, nullable=false)
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="utctime", type="string", length=10, nullable=true)
     */
    private $utctime;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=6, nullable=true)
     */
    private $date;

    /**
     * @var \Eye3\CaminosBundle\Entity\Gpsdata
     *
     * @ORM\ManyToOne(targetEntity="Eye3\CaminosBundle\Entity\Gpsdata")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_gps", referencedColumnName="id")
     * })
     */
    private $idGps;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Sightdata
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set utctime
     *
     * @param string $utctime
     * @return Sightdata
     */
    public function setUtctime($utctime)
    {
        $this->utctime = $utctime;

        return $this;
    }

    /**
     * Get utctime
     *
     * @return string 
     */
    public function getUtctime()
    {
        return $this->utctime;
    }

    /**
     * Set date
     *
     * @param string $date
     * @return Sightdata
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set idGps
     *
     * @param \Eye3\CaminosBundle\Entity\Gpsdata $idGps
     * @return Pmdata
     */
    public function setIdGps(\Eye3\CaminosBundle\Entity\Gpsdata $idGps = null)
    {
        $this->idGps = $idGps;

        return $this;
    }

    /**
     * Get idGps
     *
     * @return \Eye3\CaminosBundle\Entity\Gpsdata 
     */
    public function getIdGps()
    {
        return $this->idGps;
    }
}
