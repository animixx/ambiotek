<?php

namespace Eye3\CaminosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use \PHPExcel_Style_Fill;
use \PHPExcel_Style_Color;
use \PHPExcel_RichText;
use \PHPExcel_Style_Alignment;
use \PHPExcel_Style_Border;
use \PHPExcel_Worksheet_Drawing;

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
				->setTitle('Registro-'.$meses[($date->format('n'))-1].$date->format('Y').'CMTQB')
				// ->setSubject("Faena KDM Til-Til")
				->setDescription("Reporte Mensual")
				->setKeywords("Eye3 - Reporte Mensual")
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
						
						$style['titulo'] = array(
														'font'  => array(
															'bold'  => true,
															'color' => array('rgb' => '63B434'),
															'size'  => 11,
															'name'  => 'Calibri'
															),
											  'borders' => array(
												'left' => array(
												  'style' => PHPExcel_Style_Border::BORDER_THIN,
												),
												'right' => array(
												  'style' => PHPExcel_Style_Border::BORDER_THIN,
												),
												'bottom' => array(
												  'style' => PHPExcel_Style_Border::BORDER_NONE,
												), 
											  ),
											  'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'startcolor' => array(
												  'argb' => 'FFFFFFCC',
												),
											  ),
													);
													
						
													
						$style['impares'] = array(
														'font' => array(
															'name' => 'Calibri',
															'color' => array(
																'rgb' => '464646'
															)
														),
													);
						
						
						$styleArray = array(
											  'font' => array(
												'name' => 'Arial',
												'size' => '8',
											  ),
											  'borders' => array(
												'left' => array(
												  'style' => PHPExcel_Style_Border::BORDER_THIN,
												),
												'right' => array(
												  'style' => PHPExcel_Style_Border::BORDER_THIN,
												),
												'bottom' => array(
												  'style' => PHPExcel_Style_Border::BORDER_NONE,
												), 
											  ),
											  'fill' => array(
												'type' => PHPExcel_Style_Fill::FILL_SOLID,
												'startcolor' => array(
												  'argb' => 'FFFFFFCC',
												),
											  ),
											);
						$fechaMedicion=date_create($llenado['fecha']);

						$angle = 2 * asin(sqrt(pow(sin(($latTo - $latFrom) / 2), 2) +
						cos($latFrom) * cos($latTo) * pow(sin(($lonTo - $lonFrom) / 2), 2)));
						
						$distancia = $angle * $earthRadius;
							
						if (date_format($fechaMedicion,'Y-m-d')!=date_format($fechaMedicionAnterior,'Y-m-d') )
						{
    
							if ($contador >0 ) $phpExcelObject->createSheet();

							$phpExcelObject->setActiveSheetIndex($contador++)
                                   // ->setCellValue('A1'," REPORTE MONITOREO Y MEDICIÓN DE POLVO\n".$meses[($date->format('n'))-1].' '.$date->format('Y').' - TECK - QUEBRADA BLANCA')
									->setCellValue('A2', 'ID')
									->setCellValue('B2', 'Tramo')
									->setCellValue('C2', 'Zona')
									->setCellValue('D2', 'Fecha')
									->setCellValue('E2', 'Latitud')
									->setCellValue('F2', 'Longitud')
									->setCellValue('G2', "Velocidad\n(km/h)")
									->setCellValue('H2', "Altura\n(mts)")
									->setCellValue('I2', "Distancia\n(mts)")
									->setCellValue('J2', "Dist Acumulada\npor tramo (mts)")
									->setCellValue('K2', 'TPS')
									->setCellValue('L2', 'PM10')
									->setCellValue('M2', 'PM2,5')
									->setCellValue('N2', 'PM1')
									->setCellValue('O2', 'Observación');

                            //unir celdas
                            $phpExcelObject->getActiveSheet()
                                    ->mergeCells('A1:C1')
                                    ->mergeCells('D1:L1')
                                    ->mergeCells('M1:O1');

                            //titulo, tamaño letra 20, sin negrita, color blanco
                            $objRichText = new PHPExcel_RichText();
                            $titulo = $objRichText->createTextRun(strtoupper($meses[($date->format('n'))-1]).' '.$date->format('Y').' - TECK - QUEBRADA BLANCA                                                           ');
                            $titulo->getFont()->setSize(20);
                            $titulo->getFont()->setBold(false);
                            $titulo->getFont()->setColor(new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ));
                            
                            //subtitulo tamaño letra 13, sin negrita, color blanco
                            $subtitulo = $objRichText->createTextRun("REPORTE MONITOREO Y MEDICIÓN DE POLVO");
                            $subtitulo->getFont()->setSize(13);
                            $subtitulo->getFont()->setBold(false);
                            $subtitulo->getFont()->setColor(new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ));
    
                            $phpExcelObject->getActiveSheet()->getCell('D1')->setValue($objRichText);

                            //fondo verde
                            $phpExcelObject->getActiveSheet()->getStyle('A1:O1')
                                    ->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $phpExcelObject->getActiveSheet()->getStyle('A1:O1')
                                    ->getFill()->getStartColor()->setARGB('FF74BD43');
                            //alineacion vertical y horizontal centrados
                            $phpExcelObject->getActiveSheet()->getStyle("D1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $phpExcelObject->getActiveSheet()->getStyle("D1")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

                            //altura de la fila
                            $phpExcelObject->getActiveSheet()->getRowDimension(1)->setRowHeight(85);

                            //logo Teck
                            $objDrawing1 = new PHPExcel_Worksheet_Drawing();
                            $objDrawing1->setName('Logo1');
                            $objDrawing1->setDescription('Logo1');
                            $objDrawing1->setPath('/home2/animixco/public_html/teck/web/logos blanco excel-03.png');
                            $objDrawing1->setHeight(60);
                            $objDrawing1->setOffsetX(100);
                            $objDrawing1->setOffsetY(30);
                            $objDrawing1->setCoordinates('B1');
                            $objDrawing1->setWorksheet($phpExcelObject->getActiveSheet());


                            //logo EYE3
                            $objDrawing2 = new PHPExcel_Worksheet_Drawing();
                            $objDrawing2->setName('Logo2');
                            $objDrawing2->setDescription('Logo2');
                            $objDrawing2->setPath('/home2/animixco/public_html/teck/web/logos blanco excel-01.png');
                            $objDrawing2->setHeight(85);
                            $objDrawing2->setOffsetX(20);
                            $objDrawing2->setOffsety(20);
                            $objDrawing2->setCoordinates('K1');
                            $objDrawing2->setWorksheet($phpExcelObject->getActiveSheet());


                            //logo Vial Activo
                            $objDrawing3 = new PHPExcel_Worksheet_Drawing();
                            $objDrawing3->setName('Logo3');
                            $objDrawing3->setDescription('Logo3');
                            $objDrawing3->setPath('/home2/animixco/public_html/teck/web/logos blanco excel-02.png');
                            $objDrawing3->setHeight(70);
                            $objDrawing3->setOffsetX(80);
                            $objDrawing3->setOffsetY(30);
                            $objDrawing3->setCoordinates('M1');
                            $objDrawing3->setWorksheet($phpExcelObject->getActiveSheet());

                            //$phpExcelObject->getActiveSheet()->getStyle('A1:O1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
                            //$phpExcelObject->getActiveSheet()->getStyle('A2:O2')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_NONE);
                           
                            //cambia la fuente a negrita color verde
                            $phpExcelObject->getDefaultStyle()->getFont()
                                            ->setBold(true)
                                            ->getColor()->setARGB('FF63B434');
                                            

                            //fila 2 fondo plomo
                            $phpExcelObject->getActiveSheet()->getStyle('A2:O2')
                                    ->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            $phpExcelObject->getActiveSheet()->getStyle('A2:O2')
                                    ->getFill()->getStartColor()->setARGB('FFE6F3DD');
                            //tamaño de la fila
                            $phpExcelObject->getActiveSheet()->getRowDimension(2)->setRowHeight(50);
                            //alineacion vertical y horizontal centrados
                            $phpExcelObject->getActiveSheet()->getStyle("A2:O2")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                            $phpExcelObject->getActiveSheet()->getStyle("A2:O2")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                            //ajuste de línea
                            $phpExcelObject->getActiveSheet()->getStyle('G2')->getAlignment()->setWrapText(true);
                            $phpExcelObject->getActiveSheet()->getStyle('H2')->getAlignment()->setWrapText(true);
                            $phpExcelObject->getActiveSheet()->getStyle('I2')->getAlignment()->setWrapText(true);
                            $phpExcelObject->getActiveSheet()->getStyle('J2')->getAlignment()->setWrapText(true);
                            
                            //cambia la fuente a color ~plomo oscuro sin negrita                 
                            $phpExcelObject->getDefaultStyle()->getFont()
                                            ->setBold(false)
                                            ->getColor()->setARGB('FF464646');

							foreach (range('A', $phpExcelObject->getActiveSheet()->getHighestDataColumn()) as $col) 
							{
								if (!in_array($col,array('K','L','M','N')))
									$phpExcelObject->getActiveSheet()
											->getColumnDimension($col)
											->setAutoSize(true);
								$phpExcelObject->getActiveSheet()
										->getStyle($col.'2')
										->applyFromArray($style['titulo']);
								$phpExcelObject->getActiveSheet()
										->getStyle($col.'2')
										->getAlignment()->setWrapText(true);
							}
							$phpExcelObject->getActiveSheet()->getColumnDimension('O')
                                        ->setAutoSize(false)
                                        ->setWidth(29);
							$phpExcelObject->getActiveSheet()->calculateColumnWidths();
							$phpExcelObject->getActiveSheet()->freezePane('A3');
							$aux=3;
							
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
							$phpExcelObject->getActiveSheet()->getStyle('N'.$aux)->getNumberFormat()->setFormatCode('0.00'); 
							
							 $longi=$llenado['longitud'];$lati=$llenado['latitud'];
							 $tramo=$llenado['NombreTramo'];$zona=$llenado['NombreZona'];
							 $fechaMedicionAnterior=date_create($llenado['fecha']);

                            $phpExcelObject->getActiveSheet()->getRowDimension($aux)->setRowHeight(28);
                            $phpExcelObject->getActiveSheet()->getStyle('A'.$aux.':O'.$aux)->getAlignment()
                                           ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                                           ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                            $phpExcelObject->getActiveSheet()->getStyle('A'.$aux.':O'.$aux)
                                    ->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                            if ($aux%2==1) {
                                    $phpExcelObject->getActiveSheet()->getStyle('A'.$aux.':O'.$aux)
                                            ->getFill()->getStartColor()->setARGB('FFFFFFFF');
                            } else {
                                    $phpExcelObject->getActiveSheet()->getStyle('A'.$aux.':O'.$aux)
                                            ->getFill()->getStartColor()->setARGB('FFF7F8F8');
                            }
                            $phpExcelObject->getActiveSheet()->getStyle('A'.$aux.':O'.$aux)
                                            ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $phpExcelObject->getActiveSheet()->getStyle('A'.$aux.':O'.$aux++)
                                            ->getBorders()->getTop()->getColor()->setARGB('FFD5D5D5');



						}
                            //borde grueso plomo
                            $phpExcelObject->getActiveSheet()->getStyle('A3:O3')
                                    ->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                            $phpExcelObject->getActiveSheet()->getStyle('A3:O3')->getBorders()->getTop()->getColor()->setARGB('FFD5D5D5');
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
