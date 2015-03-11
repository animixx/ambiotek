<?php

namespace Eye3\CaminosBundle\Entity;
use Doctrine\ORM\EntityRepository;


use Eye3\CaminosBundle\Entity\Aditivo;

/**
 * AditivoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AditivoRepository extends EntityRepository
{

		//formato fecha desde y hasta "yyyy-mm-dd"
		public function GraficarAditivo($desde = "2014-12-01" ,$hasta = "2015-02-28")
		{
			$query = $this->getEntityManager()
				->getConnection()
				->prepare(
					"select * from aditivo join usuario on usuario = usuario.id WHERE fecha BETWEEN :desde and :hasta order by fecha"

			);
				$query->bindValue('desde', $desde );
				$query->bindValue('hasta', $hasta." 23:59:59" );

			 $query->execute();
			 
			 return $query->fetchAll();
		}

}
		
