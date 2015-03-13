<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Graficarmapa
 *
 * @ORM\Table(name="graficarMapa")
 * @ORM\Entity
 */
class Graficarmapa
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
     * @ORM\Column(name="NombreTramo", type="string", length=60, nullable=false)
     */
    private $nombretramo;

    /**
     * @var linestring
     *
     * @ORM\Column(name="tramo", type="linestring", nullable=false)
     */
    private $tramo;

    /**
     * @var polygon
     *
     * @ORM\Column(name="zona", type="polygon", nullable=true)
     */
    private $zona;

    /**
     * @var float
     *
     * @ORM\Column(name="largoTramo", type="float", precision=18, scale=6, nullable=true)
     */
    private $largotramo;




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
     * Set nombretramo
     *
     * @param string $nombretramo
     * @return Graficarmapa
     */
    public function setNombretramo($nombretramo)
    {
        $this->nombretramo = $nombretramo;

        return $this;
    }

    /**
     * Get nombretramo
     *
     * @return string 
     */
    public function getNombretramo()
    {
        return $this->nombretramo;
    }

    /**
     * Set tramo
     *
     * @param linestring $tramo
     * @return Graficarmapa
     */
    public function setTramo($tramo)
    {
        $this->tramo = $tramo;

        return $this;
    }

    /**
     * Get tramo
     *
     * @return linestring 
     */
    public function getTramo()
    {
        return $this->tramo;
    }

    /**
     * Set zona
     *
     * @param polygon $zona
     * @return Graficarmapa
     */
    public function setZona($zona)
    {
        $this->zona = $zona;

        return $this;
    }

    /**
     * Get zona
     *
     * @return polygon 
     */
    public function getZona()
    {
        return $this->zona;
    }

    /**
     * Set largotramo
     *
     * @param float $largotramo
     * @return Graficarmapa
     */
    public function setLargotramo($largotramo)
    {
        $this->largotramo = $largotramo;

        return $this;
    }

    /**
     * Get largotramo
     *
     * @return float 
     */
    public function getLargotramo()
    {
        return $this->largotramo;
    }
}
