<?php

namespace Eye3\CaminosBundle\Entity;
use Doctrine\ORM\EntityRepository;


use Eye3\CaminosBundle\Entity\Gpsdata;

/**
 * GpsdataRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GpsdataRepository extends EntityRepository
{

		
		public function GetAreas($fecha )
		{
			
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"SELECT zonaid FROM pmdata join gpsdata  gps on id_gps = gps.id join tramoMapa tramo on pmdata.id_tramo = tramo.id where fecha like '$fecha%' group by zonaid"
				);
			$query->execute();
			return $query->fetchColumn();
				
			
			

		}
		
		
		public function GetTramos()
		{
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					'SELECT id,NombreTramo from graficarMapa '
				);

			$query->execute();
			return $query->fetchAll();
		}
		
		public function GetTramo($tramo_id = 51)
		{
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					'SELECT NumPoints(tramo) from graficarMapa where id = '.$tramo_id
				);

			$query->execute();
			$cantidad= $query->fetchColumn(0);
			
			if (!is_numeric($cantidad)) return NULL;
			
			for($punto=1;$punto<$cantidad+1;$punto++)
			{
				
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"SELECT X(PointN(tramo,$punto)) as X ,Y(PointN(tramo,$punto)) as Y from graficarMapa where id = $tramo_id"
				);
				$query->execute();
				$puntos[]= $query->fetch();
			}
			
			return $puntos;

		}
		
		//formato fecha desde y hasta "yyyy-mm-dd"
		public function historial_excel($desde = "2014-12-01" ,$hasta = "2014-12-31")
		{

			$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"SELECT altitude, d.id_gps as id_gps ,tsplat ,pm10lat ,pm25lat ,pm1lat ,fecha, latitude as latitud, longitude as longitud ,speed ,value ,NombreTramo  FROM pmdata d 
		join gpsdata  gps on d.id_gps = gps.id join graficarMapa tramo on d.id_tramo = tramo.id left join sightdata o on d.id_gps =o.id_gps  
		WHERE fecha BETWEEN :desde and :hasta  and d.id_tramo is not null order by fecha, d.id_tramo ;"

			);
				$query->bindValue('desde', $desde );
				$query->bindValue('hasta', $hasta );
// VER EL ORDEN, EL FORMATO ANTERIOR AHORA NO ES VALIDO -->order by date_format(fecha,'%Y%m%d'), zonaid, d.id_tramo ;"
			 $query->execute();
			 
			 return $query->fetchAll();
		}

}
		
