<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tramomapa
 *
 * @ORM\Table(name="tramoMapa", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})}, indexes={@ORM\Index(name="zonaid", columns={"zonaid"})})
 * @ORM\Entity
 */
class Tramomapa
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
     * @var string
     *
     * @ORM\Column(name="NombreTramo", type="string", length=60, nullable=false)
     */
    private $nombretramo;

    /**
     * @var \Zonamapa
     *
     * @ORM\ManyToOne(targetEntity="Zonamapa")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="zonaid", referencedColumnName="id")
     * })
     */
    private $zonaid;



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
     * @return Tramomapa
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
     * Set zonaid
     *
     * @param \Eye3\CaminosBundle\Entity\Zonamapa $zonaid
     * @return Tramomapa
     */
    public function setZonaid(\Eye3\CaminosBundle\Entity\Zonamapa $zonaid = null)
    {
        $this->zonaid = $zonaid;

        return $this;
    }

    /**
     * Get zonaid
     *
     * @return \Eye3\CaminosBundle\Entity\Zonamapa 
     */
    public function getZonaid()
    {
        return $this->zonaid;
    }
}
