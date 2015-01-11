<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class RegistroController extends Controller
{
    /**
     * @Route("/registro", name="registro")
     * @Template()
     */
    public function indexAction()
    {
        $fecha = date("d-m-Y");
		
		
		$em = $this->getDoctrine()->getManager();
        $primerizo = $em->getRepository('Eye3CaminosBundle:Sightdata')->FirstDato();
		
		
		return array(
               'desde' => $primerizo,
            );    
	}

	/**
     * 
     * @Route("/excel/{fecha}", requirements={"fecha" = "[0-9]{4}/[0-9]{1,2}"}, name="genera_excel")
	 *
     * @return response
     */
    public function excelAction($fecha = "2015/1"  ) {
			
			$date= date_create($fecha."/1");
			$hasta = $date->modify('first day of next month')->format('Y-m-d');
			$desde = $date->modify('first day of last month')->format('Y-m-d');
			
			$meses = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
			
			$em = $this->getDoctrine()->getManager();
			$datos = $em->getRepository('Eye3CaminosBundle:Gpsdata')->historial_excel($desde,$hasta);
			
			 // ask the service for a Excel5
			$phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

			$phpExcelObject->getProperties()->setCreator("Eye3")
				->setLastModifiedBy("Eye3 Online Monitor")
				->setTitle('Historial'.$meses[($date->format('n'))-1].$date->format('Y').'-ambiotek')
				// ->setSubject("Faena KDM Til-Til")
				->setDescription("Reporte Mensual")
				->setKeywords("eye3")
				->setCategory("Reportes");
			
				$contador=0;
				$earthRadius = 6371000;
				$tramo=$zona=$distancia=$kino=$longi=$lati=null;$fechaMedicionAnterior=new \DateTime('01/01/2011');
				
				if (count($datos)==0)
					$datos=array(array('id_gps'=>NULL,'NombreTramo'=>NULL,"NombreZona"=>'','fecha'=>NULL,"latitud"=>NULL,
				'longitud'=>NULL,'speed'=>NULL,'altitude'=>NULL,'tsplat'=>NULL,'pm10lat'=>NULL,'pm25lat'=>NULL,'pm1lat'=>NULL,'value'=>NULL));
				
				foreach ($datos as $llenado)
					{	
						// convert from degrees to radians
						$latFrom = deg2rad($lati);
						$lonFrom = deg2rad($longi);
						$latTo = deg2rad($llenado['latitud']);
						$lonTo = deg2rad($llenado['longitud']);
						
						$fechaMedicion=date_create($llenado['fecha']);

						$angle = 2 * asin(sqrt(pow(sin(($latTo - $latFrom) / 2), 2) +
						cos($latFrom) * cos($latTo) * pow(sin(($lonTo - $lonFrom) / 2), 2)));
						
						$distancia = $angle * $earthRadius;
							
						if (date_format($fechaMedicion,'Y-m-d')!=date_format($fechaMedicionAnterior,'Y-m-d') )
						{
							if ($contador >0 ) $phpExcelObject->createSheet();
							$phpExcelObject->setActiveSheetIndex($contador++)
									->setCellValue('A1', 'ID')
									->setCellValue('B1', 'Tramo')
									->setCellValue('C1', 'Zona')
									->setCellValue('D1', 'Fecha')
									->setCellValue('E1', 'Latitud')
									->setCellValue('F1', 'Longitud')
									->setCellValue('G1', "Velocidad\n(km/h)")
									->setCellValue('H1', "Altura\n(mts)")
									->setCellValue('I1', "Distancia\n(mts)")
									->setCellValue('J1', "Acumulada\nx tramo (mts)")
									->setCellValue('K1', 'TPS')
									->setCellValue('L1', 'PM10')
									->setCellValue('M1', 'PM2,5')
									->setCellValue('N1', 'PM1')
									->setCellValue('O1', 'Observación');
							
							foreach (range('A', $phpExcelObject->getActiveSheet()->getHighestDataColumn()) as $col) 
							{
								if (!in_array($col,array('K','L','M','N')))
									$phpExcelObject->getActiveSheet()
											->getColumnDimension($col)
											->setAutoSize(true);
								$phpExcelObject->getActiveSheet()
										->getStyle($col.'1')
										->getFont()->setBold(true);
								$phpExcelObject->getActiveSheet()
										->getStyle($col.'1')
										->getAlignment()->setWrapText(true);
							}
							$phpExcelObject->getActiveSheet()->calculateColumnWidths();
							$phpExcelObject->getActiveSheet()->freezePane('A2');
							$aux=2;
							
							if ($llenado['NombreTramo']!='')
								$phpExcelObject->getActiveSheet()->setTitle($llenado['NombreZona'].'('.$fechaMedicion->format('d-m-Y').')');
							else
								$phpExcelObject->getActiveSheet()->setTitle('Sin Mediciones');
						}
						
							
						$kino = ($tramo==$llenado['NombreTramo'] and $zona==$llenado['NombreZona'])?$kino+$distancia:0;
						
						if ($llenado['NombreTramo']!='')
						{
							$phpExcelObject->getActiveSheet()->setCellValue('A'.$aux, $llenado['id_gps'])
									->setCellValue('B'.$aux, $llenado['NombreTramo'])
									->setCellValue('C'.$aux, $llenado['NombreZona'])
									->setCellValue('D'.$aux, $llenado['fecha'])
									->setCellValue('E'.$aux, $llenado['latitud'])
									->setCellValue('F'.$aux, $llenado['longitud'])
									->setCellValue('G'.$aux, round($llenado['speed']))
									->setCellValue('H'.$aux, round($llenado['altitude'],2))
									->setCellValue('I'.$aux, (($zona==$llenado['NombreZona'])?round($distancia,3):0))
									->setCellValue('J'.$aux, round($kino,3, PHP_ROUND_HALF_UP))
									->setCellValue('K'.$aux, $llenado['tsplat'])
									->setCellValue('L'.$aux, $llenado['pm10lat'])
									->setCellValue('M'.$aux, $llenado['pm25lat'])
									->setCellValue('N'.$aux, $llenado['pm1lat'])
									->setCellValue('O'.$aux, $llenado['value']);
							
							$phpExcelObject->getActiveSheet()->getStyle('E'.$aux)->getNumberFormat()->setFormatCode('0.000000'); 
							$phpExcelObject->getActiveSheet()->getStyle('F'.$aux)->getNumberFormat()->setFormatCode('0.000000'); 
							$phpExcelObject->getActiveSheet()->getStyle('H'.$aux)->getNumberFormat()->setFormatCode('0.00'); 
							$phpExcelObject->getActiveSheet()->getStyle('I'.$aux)->getNumberFormat()->setFormatCode('0.000'); 
							$phpExcelObject->getActiveSheet()->getStyle('J'.$aux)->getNumberFormat()->setFormatCode('0.000'); 
							$phpExcelObject->getActiveSheet()->getStyle('K'.$aux)->getNumberFormat()->setFormatCode('0.00'); 
							$phpExcelObject->getActiveSheet()->getStyle('L'.$aux)->getNumberFormat()->setFormatCode('0.00'); 
							$phpExcelObject->getActiveSheet()->getStyle('M'.$aux)->getNumberFormat()->setFormatCode('0.00'); 
							$phpExcelObject->getActiveSheet()->getStyle('N'.$aux++)->getNumberFormat()->setFormatCode('0.00'); 
							
							 $longi=$llenado['longitud'];$lati=$llenado['latitud'];
							 $tramo=$llenado['NombreTramo'];$zona=$llenado['NombreZona'];
							 $fechaMedicionAnterior=date_create($llenado['fecha']);
						}
					}
	   
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$phpExcelObject->setActiveSheetIndex(0);

			// create the writer
			$writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
			// create the response
			$response = $this->get('phpexcel')->createStreamedResponse($writer);
			// adding headers
			$response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
			$response->headers->set('Content-Disposition', 'attachment;filename=Historial'.$meses[($date->format('n'))-1].$date->format('Y').'-ambiotek.xlsx');
			$response->headers->set('Pragma', 'public');
			$response->headers->set('Cache-Control', 'maxage=1');

			return $response;
			
    }
	
	


}
