<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gpsdata
 *
 * @ORM\Table(name="gpsdata", indexes={@ORM\Index(name="tramoid", columns={"tramoid"})})
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=1, nullable=true)
     */
    private $status;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float", precision=10, scale=6, nullable=true)
     */
    private $latitud;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float", precision=10, scale=6, nullable=true)
     */
    private $longitud;

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
     * @ORM\Column(name="magnetic_variation", type="string", length=10, nullable=true)
     */
    private $magneticVariation;

    /**
     * @var string
     *
     * @ORM\Column(name="course", type="string", length=10, nullable=true)
     */
    private $course;

    /**
     * @var string
     *
     * @ORM\Column(name="altitude", type="string", length=10, nullable=true)
     */
    private $altitude;


    /**
     * @var string
     *
     * @ORM\Column(name="gprmc", type="string", length=82, nullable=true)
     */
    private $gprmc;

    /**
     * @var string
     *
     * @ORM\Column(name="gpgga", type="string", length=82, nullable=true)
     */
    private $gpgga;


    /**
     * @var \Eye3\CaminosBundle\Entity\Graficarmapa
     *
     * @ORM\ManyToOne(targetEntity="Eye3\CaminosBundle\Entity\Graficarmapa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tramoid", referencedColumnName="id")
     * })
     */
    private $tramoid;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Gpsdata
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
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
     * Set latitud
     *
     * @param float $latitud
     * @return Gpsdata
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get latitud
     *
     * @return float 
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud
     *
     * @param float $longitud
     * @return Gpsdata
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get longitud
     *
     * @return float 
     */
    public function getLongitud()
    {
        return $this->longitud;
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
     * Set magneticVariation
     *
     * @param string $magneticVariation
     * @return Gpsdata
     */
    public function setMagneticVariation($magneticVariation)
    {
        $this->magneticVariation = $magneticVariation;

        return $this;
    }

    /**
     * Get magneticVariation
     *
     * @return string 
     */
    public function getMagneticVariation()
    {
        return $this->magneticVariation;
    }

    /**
     * Set course
     *
     * @param string $course
     * @return Gpsdata
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string 
     */
    public function getCourse()
    {
        return $this->course;
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

    /**
     * Set gprmc
     *
     * @param string $gprmc
     * @return Gpsdata
     */
    public function setGprmc($gprmc)
    {
        $this->gprmc = $gprmc;

        return $this;
    }

    /**
     * Get gprmc
     *
     * @return string 
     */
    public function getGprmc()
    {
        return $this->gprmc;
    }

    /**
     * Set gpgga
     *
     * @param string $gpgga
     * @return Gpsdata
     */
    public function setGpgga($gpgga)
    {
        $this->gpgga = $gpgga;

        return $this;
    }

    /**
     * Get gpgga
     *
     * @return string 
     */
    public function getGpgga()
    {
        return $this->gpgga;
    }

    /**
     * Set tramoid
     *
     * @param \Eye3\CaminosBundle\Entity\Graficarmapa $tramoid
     * @return Gpsdata
     */
    public function setTramoid(\Eye3\CaminosBundle\Entity\Graficarmapa $tramoid = null)
    {
        $this->tramoid = $tramoid;

        return $this;
    }

    /**
     * Get tramoid
     *
     * @return \Eye3\CaminosBundle\Entity\Graficarmapa 
     */
    public function getTramoid()
    {
        return $this->tramoid;
    }
}
