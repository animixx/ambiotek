<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Graficarmapa
 *
 * @ORM\Table(name="graficarMapa", indexes={@ORM\Index(name="tramoid", columns={"tramoid"})})
 * @ORM\Entity
 */
class Graficarmapa
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var linestring
     *
     * @ORM\Column(name="tramo", type="linestring", nullable=false)
     */
    private $tramo;

    /**
     * @var polygon
     *
     * @ORM\Column(name="zona", type="polygon", nullable=false)
     */
    private $zona;

    /**
     * @var \Tramomapa
     *
     * @ORM\ManyToOne(targetEntity="Tramomapa")
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
     * Set tramoid
     *
     * @param \Eye3\CaminosBundle\Entity\Tramomapa $tramoid
     * @return Graficarmapa
     */
    public function setTramoid(\Eye3\CaminosBundle\Entity\Tramomapa $tramoid = null)
    {
        $this->tramoid = $tramoid;

        return $this;
    }

    /**
     * Get tramoid
     *
     * @return \Eye3\CaminosBundle\Entity\Tramomapa 
     */
    public function getTramoid()
    {
        return $this->tramoid;
    }
}
