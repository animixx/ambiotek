<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gpsdata
 *
 * @ORM\Table(name="gpsdata")
 * @ORM\Entity(repositoryClass="Eye3\CaminosBundle\Entity\GpsdataRepository")
 */
class Gpsdata
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
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=9, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="ns", type="string", length=1, nullable=true)
     */
    private $ns;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=10, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="ew", type="string", length=1, nullable=true)
     */
    private $ew;

    /**
     * @var string
     *
     * @ORM\Column(name="speed", type="string", length=10, nullable=true)
     */
    private $speed;

    /**
     * @var string
     *
     * @ORM\Column(name="fix", type="string", length=1, nullable=true)
     */
    private $fix;

    /**
     * @var string
     *
     * @ORM\Column(name="satellites", type="string", length=2, nullable=true)
     */
    private $satellites;

    /**
     * @var string
     *
     * @ORM\Column(name="altitude", type="string", length=10, nullable=true)
     */
    private $altitude;



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
     * Set utctime
     *
     * @param string $utctime
     * @return Gpsdata
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
     * @return Gpsdata
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
     * Set status
     *
     * @param string $status
     * @return Gpsdata
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Gpsdata
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set ns
     *
     * @param string $ns
     * @return Gpsdata
     */
    public function setNs($ns)
    {
        $this->ns = $ns;

        return $this;
    }

    /**
     * Get ns
     *
     * @return string 
     */
    public function getNs()
    {
        return $this->ns;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Gpsdata
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set ew
     *
     * @param string $ew
     * @return Gpsdata
     */
    public function setEw($ew)
    {
        $this->ew = $ew;

        return $this;
    }

    /**
     * Get ew
     *
     * @return string 
     */
    public function getEw()
    {
        return $this->ew;
    }

    /**
     * Set speed
     *
     * @param string $speed
     * @return Gpsdata
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;

        return $this;
    }

    /**
     * Get speed
     *
     * @return string 
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set fix
     *
     * @param string $fix
     * @return Gpsdata
     */
    public function setFix($fix)
    {
        $this->fix = $fix;

        return $this;
    }

    /**
     * Get fix
     *
     * @return string 
     */
    public function getFix()
    {
        return $this->fix;
    }

    /**
     * Set satellites
     *
     * @param string $satellites
     * @return Gpsdata
     */
    public function setSatellites($satellites)
    {
        $this->satellites = $satellites;

        return $this;
    }

    /**
     * Get satellites
     *
     * @return string 
     */
    public function getSatellites()
    {
        return $this->satellites;
    }

    /**
     * Set altitude
     *
     * @param string $altitude
     * @return Gpsdata
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;

        return $this;
    }

    /**
     * Get altitude
     *
     * @return string 
     */
    public function getAltitude()
    {
        return $this->altitude;
    }
}
