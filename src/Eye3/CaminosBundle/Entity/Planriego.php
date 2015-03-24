<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planriego
 *
 * @ORM\Table(name="planRiego")
 * @ORM\Entity(repositoryClass="Eye3\CaminosBundle\Entity\PlanriegoRepository")
 */
class Planriego
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=20)
     */
    private $tipo;

    /**
     * @var integer
     *
     * @ORM\Column(name="tasa_final", type="integer")
     */
    private $tasaFinal;

    /**
     * @var integer
     *
     * @ORM\Column(name="tasa_riego", type="integer")
     */
    private $tasaRiego;

    /**
     * @var integer
     *
     * @ORM\Column(name="dilucion", type="integer")
     */
    private $dilucion;

    /**
     * @var integer
     *
     * @ORM\Column(name="superficie", type="bigint")
     */
    private $superficie;

    /**
     * @var integer
     *
     * @ORM\Column(name="ancho", type="integer")
     */
    private $ancho;

    /**
     * @var array
     *
     * @ORM\Column(name="tramos", type="simple_array")
     */
    private $tramos;

    /**
     * @var integer
     *
     * @ORM\Column(name="volumen", type="integer")
     */
    private $volumen;

    /**
     * @var integer
     *
     * @ORM\Column(name="estanque", type="integer")
     */
    private $estanque;


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
     * Set tipo
     *
     * @param string $tipo
     * @return Planriego
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set tasaFinal
     *
     * @param integer $tasaFinal
     * @return Planriego
     */
    public function setTasaFinal($tasaFinal)
    {
        $this->tasaFinal = $tasaFinal;

        return $this;
    }

    /**
     * Get tasaFinal
     *
     * @return integer 
     */
    public function getTasaFinal()
    {
        return $this->tasaFinal;
    }

    /**
     * Set tasaRiego
     *
     * @param integer $tasaRiego
     * @return Planriego
     */
    public function setTasaRiego($tasaRiego)
    {
        $this->tasaRiego = $tasaRiego;

        return $this;
    }

    /**
     * Get tasaRiego
     *
     * @return integer 
     */
    public function getTasaRiego()
    {
        return $this->tasaRiego;
    }

    /**
     * Set dilucion
     *
     * @param integer $dilucion
     * @return Planriego
     */
    public function setDilucion($dilucion)
    {
        $this->dilucion = $dilucion;

        return $this;
    }

    /**
     * Get dilucion
     *
     * @return integer 
     */
    public function getDilucion()
    {
        return $this->dilucion;
    }

    /**
     * Set superficie
     *
     * @param integer $superficie
     * @return Planriego
     */
    public function setSuperficie($superficie)
    {
        $this->superficie = $superficie;

        return $this;
    }

    /**
     * Get superficie
     *
     * @return integer 
     */
    public function getSuperficie()
    {
        return $this->superficie;
    }

    /**
     * Set ancho
     *
     * @param integer $ancho
     * @return Planriego
     */
    public function setAncho($ancho)
    {
        $this->ancho = $ancho;

        return $this;
    }

    /**
     * Get ancho
     *
     * @return integer 
     */
    public function getAncho()
    {
        return $this->ancho;
    }

    /**
     * Set tramos
     *
     * @param array $tramos
     * @return Planriego
     */
    public function setTramos($tramos)
    {
        $this->tramos = $tramos;

        return $this;
    }

    /**
     * Get tramos
     *
     * @return array 
     */
    public function getTramos()
    {
        return $this->tramos;
    }

    /**
     * Set volumen
     *
     * @param integer $volumen
     * @return Planriego
     */
    public function setVolumen($volumen)
    {
        $this->volumen = $volumen;

        return $this;
    }

    /**
     * Get volumen
     *
     * @return integer 
     */
    public function getVolumen()
    {
        return $this->volumen;
    }

    /**
     * Set estanque
     *
     * @param integer $estanque
     * @return Planriego
     */
    public function setEstanque($estanque)
    {
        $this->estanque = $estanque;

        return $this;
    }

    /**
     * Get estanque
     *
     * @return integer 
     */
    public function getEstanque()
    {
        return $this->estanque;
    }
}
