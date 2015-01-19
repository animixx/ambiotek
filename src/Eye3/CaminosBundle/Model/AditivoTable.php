<?php
namespace Eye3\CaminosBundle\Model;

use Brown298\DataTablesBundle\MetaData as DataTable;
use Brown298\DataTablesBundle\Model\DataTable\QueryBuilderDataTableInterface;
use Brown298\DataTablesBundle\Test\DataTable\QueryBuilderDataTable;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

/**
 * Class AditivoTable
 *
 * @package Eye3\CaminosBundle\Model
 *
 * @DataTable\Table(id="aditivoTable",displayLength=10, serverSideProcessing = false)
 */
class AditivoTable extends QueryBuilderDataTable implements QueryBuilderDataTableInterface
{
	
    /**
     * @var date
     * @DataTable\Column(source="aditivo.fecha", name="Fecha", stype="date-euro")
	 * @DataTable\Format(dataFields={"dato":"aditivo.fecha"}, template="Eye3CaminosBundle:Registro:fecha.html.twig")
     * @DataTable\DefaultSort()
     */
    public $cuando; 
	
	/**
     * @var string
     * @DataTable\Column(source="aditivo.agua", name="Agua (m3)")
     */
    public $agua;
	
    /**
     * @var string
     * @DataTable\Column(source="aditivo.aditivo", name="Aditivo (m3)")
     */
    public $aditivo;

   /**
     * @var string
     * @DataTable\Column(source="aditivo.usuario.nombre", name="Usuario")
     */
    public $usuario;

	/**
     * @var int
     * @DataTable\Column(source="aditivo.id", name="",sortable=false,searchable=false)
	 * @DataTable\Format(dataFields={"id":"aditivo.id"}, template="Eye3CaminosBundle:Graficos:modifica.html.twig")
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
            ->getRepository('Eye3\CaminosBundle\Entity\Aditivo');
        $qb = $userRepository->createQueryBuilder('aditivo');

        return $qb;
    }
}