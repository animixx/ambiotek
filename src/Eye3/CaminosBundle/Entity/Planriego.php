<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Planriego
 *
 * @ORM\Table(name="planRiego", indexes={@ORM\Index(name="quien", columns={"quien"})})
 * @ORM\Entity(repositoryClass="Eye3\CaminosBundle\Entity\PlanriegoRepository")
 */
class Planriego
{
    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=20, nullable=false)
     */
    private $tipo;

    /**
     * @var integer
     *
     * @ORM\Column(name="tasa_final", type="integer", nullable=false)
     */
    private $tasaFinal;

    /**
     * @var integer
     *
     * @ORM\Column(name="tasa_riego", type="integer", nullable=false)
     */
    private $tasaRiego;

    /**
     * @var integer
     *
     * @ORM\Column(name="dilucion", type="integer", nullable=false)
     */
    private $dilucion;

    /**
     * @var integer
     *
     * @ORM\Column(name="superficie", type="bigint", nullable=false)
     */
    private $superficie;

    /**
     * @var integer
     *
     * @ORM\Column(name="ancho", type="integer", nullable=false)
     */
    private $ancho;

    /**
     * @var simple_array
     *
     * @ORM\Column(name="tramos", type="simple_array", nullable=true)
     */
    private $tramos;

    /**
     * @var integer
     *
     * @ORM\Column(name="volumen", type="integer", nullable=false)
     */
    private $volumen;

    /**
     * @var integer
     *
     * @ORM\Column(name="estanque", type="integer", nullable=false)
     */
    private $estanque;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cuando", type="datetime", nullable=true)
     */
    private $cuando;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validado", type="boolean", nullable=false)
     */
    private $validado;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Eye3\CaminosBundle\Entity\Usuario
     *
     * @ORM\ManyToOne(targetEntity="Eye3\CaminosBundle\Entity\Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quien", referencedColumnName="id")
     * })
     */
    private $quien;



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
     * @param \simple_array $tramos
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
     * @return \simple_array 
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

    /**
     * Set cuando
     *
     * @param \DateTime $cuando
     * @return Planriego
     */
    public function setCuando()
    {
        $this->cuando = new \DateTime('now');

        return $this;
    }

    /**
     * Get cuando
     *
     * @return \DateTime 
     */
    public function getCuando()
    {
        return $this->cuando;
    }

    /**
     * Set validado
     *
     * @param boolean $validado
     * @return Planriego
     */
    public function setValidado($validado)
    {
        $this->validado = $validado;

        return $this;
    }

    /**
     * Get validado
     *
     * @return boolean 
     */
    public function getValidado()
    {
        return $this->validado;
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
	
	/**
     * Clear id
     *
     * @return Planriego 
     */
    public function clearId()
    {
		$this->id = null ;
		
        return $this;
    }

    /**
     * Set quien
     *
     * @param \Eye3\CaminosBundle\Entity\Usuario $quien
     * @return Planriego
     */
    public function setQuien(\Eye3\CaminosBundle\Entity\Usuario $quien = null)
    {
        $this->quien = $quien;

        return $this;
    }

    /**
     * Get quien
     *
     * @return \Eye3\CaminosBundle\Entity\Usuario 
     */
    public function getQuien()
    {
        return $this->quien;
    }
}
