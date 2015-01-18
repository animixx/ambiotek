<?php

namespace Eye3\CaminosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zonamapa
 *
 * @ORM\Table(name="zonaMapa", uniqueConstraints={@ORM\UniqueConstraint(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Zonamapa
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
     * @ORM\Column(name="NombreZona", type="string", length=60, nullable=false)
     */
    private $nombrezona;

    /**
     * @var polygon
     *
     * @ORM\Column(name="validez", type="polygon", nullable=false)
     */
    private $validez;



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
     * Set nombrezona
     *
     * @param string $nombrezona
     * @return Zonamapa
     */
    public function setNombrezona($nombrezona)
    {
        $this->nombrezona = $nombrezona;

        return $this;
    }

    /**
     * Get nombrezona
     *
     * @return string 
     */
    public function getNombrezona()
    {
        return $this->nombrezona;
    }

    /**
     * Set validez
     *
     * @param polygon $validez
     * @return Zonamapa
     */
    public function setValidez($validez)
    {
        $this->validez = $validez;

        return $this;
    }

    /**
     * Get validez
     *
     * @return polygon 
     */
    public function getValidez()
    {
        return $this->validez;
    }
}
