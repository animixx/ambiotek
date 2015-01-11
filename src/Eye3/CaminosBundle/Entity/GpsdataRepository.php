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

		
		public function GetAreas($fecha = null)
		{
			if ($fecha)
			{
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"SELECT zonaid FROM pmdata join gpsdata  gps on id_gps = gps.id join tramoMapa tramo on id_tramo = tramo.id where fecha like '$fecha%' group by zonaid"
				);
			$query->execute();
			return $query->fetchColumn();
				
			}
			else
			{
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					'SELECT id,NombreZona from zonaMapa'
				);
			$query->execute();
			return $query->fetchAll();
				
			}

		}
		
		
		public function GetTramos($area=null)
		{
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					'SELECT id,NombreTramo from tramoMapa where 1 '.(is_null($area)?'':" and zonaid = $area")
				);

			$query->execute();
			return $query->fetchAll();
		}
		
		public function GetTramo($tramo_id = 51)
		{
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					'SELECT NumPoints(tramo) from graficarMapa where tramoid = '.$tramo_id
				);

			$query->execute();
			$cantidad= $query->fetchColumn(0);
			
			if (!is_numeric($cantidad)) return NULL;
			
			for($punto=1;$punto<$cantidad+1;$punto++)
			{
				
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"SELECT X(PointN(tramo,$punto)) as X ,Y(PointN(tramo,$punto)) as Y from graficarMapa where tramoid = $tramo_id"
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
					"SELECT @lati,@longi,altitude, d.id_gps as id_gps ,tsplat ,pm10lat ,pm25lat ,pm1lat ,fecha ,  (((acos(sin((@lati*pi()/180)) * 
            sin((latitud*pi()/180))+cos((@lati*pi()/180)) * 
            cos((latitud*pi()/180)) * cos(((@longi- longitud )* 
            pi()/180))))*180/pi())*60*1.1515*1609.344
        ) as distancia, @lati:=latitud as latitud, @longi:=longitud as longitud ,speed ,value ,NombreTramo , NombreZona FROM pmdata d 
		join gpsdata  gps on d.id_gps = gps.id join tramoMapa tramo on id_tramo = tramo.id join zonaMapa z on zonaid=z.id left join sightdata o on d.id_gps =o.id_gps  ,  (select @lati :=null , @longi := null ) nulo 
		WHERE fecha BETWEEN :desde and :hasta  and id_tramo is not null order by date_format(fecha,'%Y%m%d'), zonaid, id_tramo ;"

			);
				$query->bindValue('desde', $desde );
				$query->bindValue('hasta', $hasta );

			 $query->execute();
			 
			 return $query->fetchAll();
		}

}
		