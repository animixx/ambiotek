<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pmdata
 *
 * @ORM\Table(name="pmdata", indexes={@ORM\Index(name="id_tramo", columns={"id_tramo"})})
 * @ORM\Entity
 */
class Pmdata
{
    /**
     * @var float
     *
     * @ORM\Column(name="tsplat", type="float", precision=10, scale=0, nullable=true)
     */
    private $tsplat;

    /**
     * @var float
     *
     * @ORM\Column(name="pm10lat", type="float", precision=10, scale=0, nullable=true)
     */
    private $pm10lat;

    /**
     * @var float
     *
     * @ORM\Column(name="pm25lat", type="float", precision=10, scale=0, nullable=true)
     */
    private $pm25lat;

    /**
     * @var float
     *
     * @ORM\Column(name="pm1lat", type="float", precision=10, scale=0, nullable=true)
     */
    private $pm1lat;

    /**
     * @var float
     *
     * @ORM\Column(name="tspavg", type="float", precision=10, scale=0, nullable=true)
     */
    private $tspavg;

    /**
     * @var float
     *
     * @ORM\Column(name="pm10avg", type="float", precision=10, scale=0, nullable=true)
     */
    private $pm10avg;

    /**
     * @var float
     *
     * @ORM\Column(name="pm25avg", type="float", precision=10, scale=0, nullable=true)
     */
    private $pm25avg;

    /**
     * @var float
     *
     * @ORM\Column(name="pm1avg", type="float", precision=10, scale=0, nullable=true)
     */
    private $pm1avg;

    /**
     * @var \Gpsdata
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Gpsdata")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_gps", referencedColumnName="id")
     * })
     */
    private $idGps;

	 /**
     * @var \Eye3\CaminosBundle\Entity\Graficarmapa
     *
     * @ORM\ManyToOne(targetEntity="Eye3\CaminosBundle\Entity\Graficarmapa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tramo", referencedColumnName="id")
     * })
     */
	
    private $idTramo;

	/**
     * @var float
     *
     * @ORM\Column(name="recorrido", type="float", precision=10, scale=0, nullable=true)
     */
    private $recorrido;

    /**
     * Set tsplat
     *
     * @param float $tsplat
     * @return Pmdata
     */
    public function setTsplat($tsplat)
    {
        $this->tsplat = $tsplat;

        return $this;
    }

    /**
     * Get tsplat
     *
     * @return float 
     */
    public function getTsplat()
    {
        return $this->tsplat;
    }

    /**
     * Set pm10lat
     *
     * @param float $pm10lat
     * @return Pmdata
     */
    public function setPm10lat($pm10lat)
    {
        $this->pm10lat = $pm10lat;

        return $this;
    }

    /**
     * Get pm10lat
     *
     * @return float 
     */
    public function getPm10lat()
    {
        return $this->pm10lat;
    }

    /**
     * Set pm25lat
     *
     * @param float $pm25lat
     * @return Pmdata
     */
    public function setPm25lat($pm25lat)
    {
        $this->pm25lat = $pm25lat;

        return $this;
    }

    /**
     * Get pm25lat
     *
     * @return float 
     */
    public function getPm25lat()
    {
        return $this->pm25lat;
    }

    /**
     * Set pm1lat
     *
     * @param float $pm1lat
     * @return Pmdata
     */
    public function setPm1lat($pm1lat)
    {
        $this->pm1lat = $pm1lat;

        return $this;
    }

    /**
     * Get pm1lat
     *
     * @return float 
     */
    public function getPm1lat()
    {
        return $this->pm1lat;
    }

    /**
     * Set tspavg
     *
     * @param float $tspavg
     * @return Pmdata
     */
    public function setTspavg($tspavg)
    {
        $this->tspavg = $tspavg;

        return $this;
    }

    /**
     * Get tspavg
     *
     * @return float 
     */
    public function getTspavg()
    {
        return $this->tspavg;
    }

    /**
     * Set pm10avg
     *
     * @param float $pm10avg
     * @return Pmdata
     */
    public function setPm10avg($pm10avg)
    {
        $this->pm10avg = $pm10avg;

        return $this;
    }

    /**
     * Get pm10avg
     *
     * @return float 
     */
    public function getPm10avg()
    {
        return $this->pm10avg;
    }

    /**
     * Set pm25avg
     *
     * @param float $pm25avg
     * @return Pmdata
     */
    public function setPm25avg($pm25avg)
    {
        $this->pm25avg = $pm25avg;

        return $this;
    }

    /**
     * Get pm25avg
     *
     * @return float 
     */
    public function getPm25avg()
    {
        return $this->pm25avg;
    }

    /**
     * Set pm1avg
     *
     * @param float $pm1avg
     * @return Pmdata
     */
    public function setPm1avg($pm1avg)
    {
        $this->pm1avg = $pm1avg;

        return $this;
    }

    /**
     * Get pm1avg
     *
     * @return float 
     */
    public function getPm1avg()
    {
        return $this->pm1avg;
    }

    /**
     * Set idGps
     *
     * @param \Eye3\CaminosBundle\Entity\Gpsdata $idGps
     * @return Pmdata
     */
    public function setIdGps(\Eye3\CaminosBundle\Entity\Gpsdata $idGps)
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

    /**
     * Set idTramo
     *
     * @param \Eye3\CaminosBundle\Entity\Tramomapa $idTramo
     * @return Pmdata
     */
    public function setIdTramo(\Eye3\CaminosBundle\Entity\Tramomapa $idTramo = null)
    {
        $this->idTramo = $idTramo;

        return $this;
    }

    /**
     * Get idTramo
     *
     * @return \Eye3\CaminosBundle\Entity\Tramomapa 
     */
    public function getIdTramo()
    {
        return $this->idTramo;
    }
	
	 /**
     * Set recorrido
     *
     * @param float $recorrido
     * @return Pmdata
     */
    public function setRecorrido($recorrido)
    {
        $this->recorrido = $recorrido;

        return $this;
    }

    /**
     * Get recorrido
     *
     * @return float 
     */
    public function getRecorrido()
    {
        return $this->recorrido;
    }
}
