<?php
namespace Eye3\CaminosBundle\Model;

use Brown298\DataTablesBundle\MetaData as DataTable;
use Brown298\DataTablesBundle\Model\DataTable\QueryBuilderDataTableInterface;
use Brown298\DataTablesBundle\Test\DataTable\QueryBuilderDataTable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class ActividadesTable
 *
 * @package Eye3\CaminosBundle\Model
 *
 * @DataTable\Table(id="actividadesTable",displayLength=10, serverSideProcessing = false)
 */
class ActividadesTable extends QueryBuilderDataTable implements QueryBuilderDataTableInterface
{
	
    /**
     * @var date
     * @DataTable\Column(source="actividad.fecha", name="Fecha")
	 * @DataTable\Format(dataFields={"dato":"actividad.fecha"}, template="Eye3CaminosBundle:Actividades:fecha.html.twig")
     * @DataTable\DefaultSort()
     */
    public $cuando; 
	
	 /**
     * @var time
     * @DataTable\Column(source="actividad.hora", name="Hora" )
	 * @DataTable\Format(dataFields={"dato":"actividad.hora"}, template="Eye3CaminosBundle:Actividades:hora.html.twig")
     */
    public $hora; 

   /**
     * @var string
     * @DataTable\Column(source="actividad.usuario", name="Usuario")
     */
    public $usuario;

	
    /**
     * @var string
     * @DataTable\Column(source="actividad.actividad", name="Actividad")
     */
    public $accion;
	
	/**
     * @var int
     * @DataTable\Column(source="actividad.id", name="",sortable=false,searchable=false)
	 * @DataTable\Format(dataFields={"id":"actividad.id"}, template="Eye3CaminosBundle:Actividades:modifica.html.twig")
     */
    public $id;

    /**
     * @var bool hydrate results to doctrine objects
     */
    public $hydrateObjects = true;

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
            ->getRepository('Eye3\CaminosBundle\Entity\Actividades');
        $qb = $userRepository->createQueryBuilder('actividad');

        return $qb;
    }
}