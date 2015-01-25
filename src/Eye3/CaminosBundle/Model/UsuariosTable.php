<?php
namespace Eye3\CaminosBundle\Model;

use Brown298\DataTablesBundle\MetaData as DataTable;
use Brown298\DataTablesBundle\Model\DataTable\QueryBuilderDataTableInterface;
use Brown298\DataTablesBundle\Test\DataTable\QueryBuilderDataTable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class UsuariosTable
 *
 * @package Eye3\CaminosBundle\Model
 *
 * @DataTable\Table(id="usuariosTable",displayLength=10)
 */
class UsuariosTable extends QueryBuilderDataTable implements QueryBuilderDataTableInterface
{

    /**
     * @var datetime
     * @DataTable\Column(source="usuario.last_login", name="Último Acceso")
	 * @DataTable\Format(dataFields={"dato":"usuario.last_login"}, template="Eye3CaminosBundle:Registro:fecha.html.twig")
     */
    public $fecha; 
	
    /**
     * @var string
     * @DataTable\Column(source="usuario.username",name="Usuario" )
	 * @DataTable\DefaultSort()
     */
    public $nombre;

   /**
     * @var string
     * @DataTable\Column(source="usuario.nombre",name="Nombre")
     */
    public $login;
	
   /**
     * @var string
     * @DataTable\Column(source="usuario.email",name="Email")
     */
    public $email;
	
   /**
     * @var string
     * @DataTable\Column(source="usuario.groups.name",name="Permisos")
	 * @DataTable\Format(dataFields={"dato":"usuario.roles"}, template="Eye3CaminosBundle:Acceso:roles.html.twig")
     */
    public $rol;

	/**
     * @var int
     * @DataTable\Column(source="usuario.id", name="",sortable=false,searchable=false)
	 * @DataTable\Format(dataFields={"id":"usuario.id"}, template="Eye3CaminosBundle:Acceso:modifica.html.twig")
     */
    public $id;



    /**
     * @var bool hydrate results to doctrine objects
     */
    public $hydrateObjects = false;

    /**
     * getQueryBuilder
     *
     * @param Request $request
     *
     * @return null
     */
    public function getQueryBuilder(Request $request = null)
    {
        $userRepository = $this->container->get('doctrine.orm.entity_manager')
            ->getRepository('Eye3\CaminosBundle\Entity\Usuario');
        $qb = $userRepository->createQueryBuilder('usuario');
		
		if (!$this->container->get('security.context')->isGranted('ROLE_DIOS'))
			$qb->add('where', "usuario.locked = false and usuario.roles not like '%dios%'");

        return $qb;
    }
}