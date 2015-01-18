<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aditivo
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Eye3\CaminosBundle\Entity\AditivoRepository")
 */
class Aditivo
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="agua", type="integer")
     */
    private $agua;

    /**
     * @var integer
     *
     * @ORM\Column(name="aditivo", type="integer")
     */
    private $aditivo;

    /**
     * @var integer
     *
     * @ORM\Column(name="usuario", type="integer")
     */
    private $usuario;


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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Aditivo
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
     * Set agua
     *
     * @param integer $agua
     * @return Aditivo
     */
    public function setAgua($agua)
    {
        $this->agua = $agua;

        return $this;
    }

    /**
     * Get agua
     *
     * @return integer 
     */
    public function getAgua()
    {
        return $this->agua;
    }

    /**
     * Set aditivo
     *
     * @param integer $aditivo
     * @return Aditivo
     */
    public function setAditivo($aditivo)
    {
        $this->aditivo = $aditivo;

        return $this;
    }

    /**
     * Get aditivo
     *
     * @return integer 
     */
    public function getAditivo()
    {
        return $this->aditivo;
    }

    /**
     * Set usuario
     *
     * @param integer $usuario
     * @return Aditivo
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return integer 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}
