<?php
namespace Eye3\CaminosBundle\Model;

use Brown298\DataTablesBundle\MetaData as DataTable;
use Brown298\DataTablesBundle\Model\DataTable\QueryBuilderDataTableInterface;
use Brown298\DataTablesBundle\Test\DataTable\QueryBuilderDataTable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class ObservacionesTable
 *
 * @package Eye3\CaminosBundle\Model
 *
 * @DataTable\Table(id="observacionesTable",displayLength=10)
 */
class ObservacionesTable extends QueryBuilderDataTable implements QueryBuilderDataTableInterface
{

    /**
     * @var datetime
     * @DataTable\Column(source="sightdata.idGps.fecha",name="Fecha Ingreso", stype="date-euro" )
	 * @DataTable\Format(dataFields={"dato":"sightdata.idGps.fecha"}, template="Eye3CaminosBundle:Registro:fecha.html.twig")
	 * @DataTable\DefaultSort()
     */
    public $cuando; 
	
   /**
     * @var string
     */
    public $usuario;
	
   /**
     * @var string
     * @DataTable\Column(source="sightdata.value",name="Observación")
     */
    public $observacion;
	
   /**
     * @var string
     * @DataTable\Column(source="sightdata.idGps.latitud",name="Latitud" )
     */
    public $latitud;
	
	 /**
     * @var string
     * @DataTable\Column(source="sightdata.idGps.longitud",name="Longitud" )
     */
    public $longitud;

	/**
     * @var string
     * @DataTable\Column(source="sightdata.idGps.idTramo.nombretramo",name="Tramo" )
	 * @DataTable\Format(dataFields={"dato":"sightdata.idGps.tramoid.nombretramo"}, template="Eye3CaminosBundle:Planificacion:tramo.html.twig")
     */
    public $tramo;

	/**
     * @var int
     * @DataTable\Column(source="sightdata.id", name="",sortable=false,searchable=false)
	 * @DataTable\Format(dataFields={"id":"sightdata.id","obs":"sightdata.value","latitud":"sightdata.idGps.latitud","longitud":"sightdata.idGps.longitud"}, template="Eye3CaminosBundle:Planificacion:modifica.html.twig")
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
            ->getRepository('Eye3\CaminosBundle\Entity\Sightdata');
        $qb = $userRepository->createQueryBuilder('sightdata');
		
		if (!$this->container->get('security.context')->isGranted('ROLE_DIOS'))
		$qb->add('where', "sightdata.invalido is null");

        return $qb;
    }
}