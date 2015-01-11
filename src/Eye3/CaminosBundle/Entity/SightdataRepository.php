<?php

namespace Eye3\CaminosBundle\Entity;
use Doctrine\ORM\EntityRepository;


use Eye3\CaminosBundle\Entity\Sightdata;

/**
 * SightdataRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SightdataRepository extends EntityRepository
{

		public function GetMedicion($tipo=true,$fecha = '031214')
		{ 
			if ($tipo)
			{
				//con esta opcion se obtienen los tramos medidos con sus respectivos promedios
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"select avg(tsplat) as tpm, avg(pm10lat) as pm10, avg(pm25lat) as pm25, avg(pm1lat) as pm1, id_tramo as id from pmdata join gpsdata on id_gps=id where date='$fecha' group by id_tramo having id_tramo is not null "
				);
			}
			else
			{
				//con esta otra opcion se obtienen TODOS los puntos de la medicion incluyendo los que no pertenecen a un tramo
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"SELECT * FROM pmdata join gpsdata on id_gps=id where date='$fecha'"
				);
			}
			$query->execute();

			return $query->fetchAll();
		}
		
		public function GraficarMedicion($tipo=true,$fecha = '2014-12-03',$fecha_inicio = "2014-12-02")
		{ 
			if ($tipo)
			{
				//con esta opcion se obtienen las mediciones promediadas por zonas para filtro xrango
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"SELECT round(avg(tsplat),1) as tpm, round(avg(pm10lat),1) as pm10, round(avg(pm25lat),1) as pm25, round(avg(pm1lat),1) as pm1, NombreZona,date,fecha FROM pmdata 
					join gpsdata gps on id_gps=gps.id join tramoMapa tramo on id_tramo=tramo.id join zonaMapa zona on zonaid=zona.id where  fecha >= '$fecha_inicio' and fecha <= '$fecha 23:59:59' 
							and	( tsplat< 6000 or tsplat is null) and (pm10lat< 6000 or pm10lat is null) and (pm25lat< 6000 or pm25lat is null) and (pm1lat< 6000 or pm1lat is null) and id_tramo is not null 
						group by NombreZona, date"
				);
			}
			else
			{
				//con esta otra opcion se obtienen las mediciones validas por zonas para filtro xdia
				$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"SELECT round(avg(tsplat),1) as tpm, round(avg(pm10lat),1) as pm10, round(avg(pm25lat),1) as pm25, round(avg(pm1lat),1) as pm1, NombreZona, null as utctime,null as fecha FROM pmdata 
					join gpsdata gps on id_gps=gps.id join tramoMapa tramo on id_tramo=tramo.id join zonaMapa zona on zonaid=zona.id where fecha like '$fecha%' 
							and ( tsplat< 6000 or tsplat is null) and (pm10lat< 6000 or pm10lat is null) and (pm25lat< 6000 or pm25lat is null) and (pm1lat< 6000 or pm1lat is null) and id_tramo is not null group by NombreZona
					UNION
					SELECT round(tsplat,1), round(pm10lat,1), round(pm25lat,1), round(pm1lat,1), NombreZona , utctime,fecha FROM pmdata 
					join gpsdata gps on id_gps=gps.id join tramoMapa tramo on id_tramo=tramo.id join zonaMapa zona on zonaid=zona.id where fecha like '$fecha%'  
							and ( tsplat< 6000 or tsplat is null) and (pm10lat< 6000 or pm10lat is null) and (pm25lat< 6000 or pm25lat is null) and (pm1lat< 6000 or pm1lat is null)  and id_tramo is not null
						order by NombreZona, utctime"
				);
			}
			$query->execute();

			return $query->fetchAll();
		}
		
		public function GetSightDots($fecha = "031214")
		{
			$query = $this->getEntityManager()
				->createQuery(
					'SELECT dato FROM Eye3CaminosBundle:Sightdata dato where dato.date = :fecha'
				)->setParameter('fecha', $fecha);

			try {
				return $query->getResult();
			} catch (\Doctrine\ORM\NoResultException $e) {
				return null;
			}
			 
		}
		
		
		public function FirstDato()
		{ 
			
			$query = $this->getEntityManager()
			->getConnection()
			->prepare(
				"SELECT min(fecha) FROM pmdata join gpsdata on id_gps=id where id_tramo is not null"
			);
			
			$query->execute();

			return $query->fetchcolumn(0);
		}

}
		
