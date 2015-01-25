<?php

namespace Eye3\CaminosBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 *
 * @ORM\Table(name="usuario", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_2265B05D92FC23A8", columns={"username_canonical"}), @ORM\UniqueConstraint(name="UNIQ_2265B05DA0D96FBF", columns={"email_canonical"})})
 * @ORM\Entity
 */
class Usuario extends BaseUser
{
	 /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
	
	/**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=200, nullable=false)
     */
    private $nombre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="genero", type="boolean", nullable=false)
     */
    private $genero;

    /**
     * @var string
     *
     */
    private $tipo;

	
	public function __construct()
	{
		parent::__construct();
		
		
	}
	
	/**
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get tipo
     * //variable fake para poder ocupar los roles como unicos (no multi roles)
     * @return string 
     */
    public function getTipo()
    {
		
		if (in_array("ROLE_DIOS", $this->roles)) 	 $fulano = 'dios';
		elseif (in_array("ROLE_ADMIN", $this->roles)) $fulano = 'admin';
		elseif (in_array("ROLE_PLAN", $this->roles)) $fulano = 'plan';
		elseif (in_array("ROLE_SYNC", $this->roles)) $fulano = 'sync';
		else									  	 $fulano = 'user';
		
        return $fulano;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Usuario
     */
    public function setTipo($tipo)
    {
        if ($tipo == 'user') 		$this->setRoles(array());
        elseif ($tipo == 'sync') 		$this->setRoles(array("ROLE_SYNC"));
        elseif ($tipo == 'plan') 		$this->setRoles(array("ROLE_PLAN"));
        elseif ($tipo == 'admin') 	$this->setRoles(array("ROLE_ADMIN"));
        elseif ($tipo == 'dios') 	$this->setRoles(array("ROLE_DIOS"));

        return $this;
    }
	
    /**
     * Set genero
     *
     * @param boolean $genero
     * @return Usuario
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return boolean 
     */
    public function getGenero()
    {
        return $this->genero;
    }	
}
