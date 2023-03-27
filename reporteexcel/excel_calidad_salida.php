<?PHP
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

  $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];
 
 
 // Verificación de sesiones
 if ($_SESSION['token_ss'] != NULL) //solo si hay session activa
{
$loginSQL=mysql_query("select token from t_usuarios  where id_usuario='$id_usuario'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$fila_usu['token'];
if( $fila_usu['token'] != $_SESSION['token_ss'] )
{
	echo "<script language='javascript'>";
	echo "document.location.href='destruir_sesion.php';";
	echo "</script>";
}
} // fin de verificar sesion

if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
date_default_timezone_set("America/El_Salvador");
$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
?>
<?PHP
$fecha_inicio_buscar = parseDateMysql($_GET['id2']);
$fecha_fin_buscar = parseDateMysql($_GET['id3']);

$id_cliente2= $_GET['id'];
$fecha_inicio_buscar1= $_GET['id2'];
$fecha_fin_buscar1= $_GET['id3']; 
$id_lote2 = $_GET['id4'];
 
$fecha_inicio_imprime= substr($fecha_inicio_buscar1, 0, 2).'-'.substr($fecha_inicio_buscar1, 3, 2).'-'.substr($fecha_inicio_buscar1, 6, 4);
$fecha_fin_imprime= substr($fecha_fin_buscar1, 0, 2).'-'.substr($fecha_fin_buscar1, 3, 2).'-'.substr($fecha_fin_buscar1, 6, 4);
$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');

if($id_cliente2=="0" AND $id_lote2=="0"){
$where = "a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa'";
}else{
	if($id_cliente2!="0" AND $id_lote2=="0"){
	$where = "a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$id_cliente2' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa'";
	}else{
		$where = "a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$id_cliente2' and a.id_lote='$id_lote2' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa'";
	      }
}
		
$sql = "SELECT a.*, b.*, c.* FROM tab_salida as a, tab_cliente as b, tab_lote as c WHERE $where";



$resultdos = mysql_query($sql);
		while($rowdos = mysql_fetch_assoc($resultdos)) 
                            {	
							$nom_cliente=$rowdos['nom_cliente'];
							$num_lote=$rowdos['num_lote'];
							$id_producto_bus=$rowdos['id_producto'];
							$id_silo_bus=$rowdos['id_silo'];
							$id_origen_bus=$rowdos['id_origen'];
							}
$producto=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto_bus' and id_empresa='$id_empresa'");
  		while($row_prod = mysql_fetch_array($producto)){
		$nomproducto=$row_prod['nom_producto'];
		}

$silo=mysql_query("SELECT * FROM tab_silo WHERE id_silo='$id_silo_bus' and id_empresa='$id_empresa'");
  		while($row_silo = mysql_fetch_array($silo)){
		$nom_silo=$row_silo['nom_silo'];
		}

$origen=mysql_query("SELECT * FROM tab_origen WHERE id_origen='$id_origen_bus' and id_empresa='$id_empresa'");
  		while($row_origen = mysql_fetch_array($origen)){
		$nom_origen=$row_origen['nom_origen'];
		}		
						
//		date_default_timezone_set('America/Mexico_City');

		if (PHP_SAPI == 'cli')
			die('Este archivo solo se puede ver desde un navegador web');

		/** Se agrega la libreria PHPExcel */
		require_once 'lib/PHPExcel/PHPExcel.php';

		// Se crea el objeto PHPExcel
		$objPHPExcel = new PHPExcel();

		// Se asignan las propiedades del libro
		$objPHPExcel->getProperties()->setCreator("Codedrinks") //Autor
							 ->setLastModifiedBy("Codedrinks") //Ultimo usuario que lo modificó
							 ->setTitle("Reporte Excel con PHP y MySQL")
							 ->setSubject("Reporte Excel con PHP y MySQL")
							 ->setDescription("Control de calidad")
							 ->setKeywords("Control de calidad")
							 ->setCategory("Reporte excel");

		
		//First sheet 
		$sheet = $objPHPExcel->getActiveSheet(); //Start adding next sheets 
		/*
		$i=0; while ($i < 10) { // Add new sheet 
		$objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating //Write cells 
		$objWorkSheet->setCellValue('A1', 'Hello'.$i) ->setCellValue('B2', 'world!') ->setCellValue('C1', 'Hello') ->setCellValue('D2', 'world!'); // Rename sheet 
		$objWorkSheet->setTitle("$i");
		 $i++; } 
		*/
		$tituloReporte = "REPORTE DE CALIDAD -  SALIDA";
		$periodo= "Período del ".$fecha_inicio_imprime. " al ".$fecha_fin_imprime;
		$cliente= "Cliente:  " .$nom_cliente;
		$productoimprime= "Producto:  " .$nomproducto;
		$lote= "Lote:  " .$num_lote;
		$silo= "SILO:  " .$nom_silo;
		$origen= "Origen:  " .$nom_origen;
		$titulosColumnas = array('N°', 'Control', 'Placa', 'Piloto', 'Peso humedo (kg)', 'Pérdida de peso (kg)', 'Peso seco (kg)', 'Fecha entrada', 'Hora entrada', 'Peso Volumétrico', 'Temperatura', 'Humedad',  'Grano entero', 'Grano quebrado',  'Daño hongo', 'Impureza', 'Grano chico','Grano picado','Stress crack', 'Plaga muerta' );
		
		
		
		
		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A1:T1')
					->mergeCells('A2:T2')
					->mergeCells('B3:E3')
					->mergeCells('B4:E4')
					->mergeCells('B5:E5')
					->mergeCells('B6:E6')
					->mergeCells('B7:E7');
		
		//$a=1;			
		
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',$tituloReporte)
					->setCellValue('A2',$periodo)
					->setCellValue('B3', $cliente)
					->setCellValue('B4', $productoimprime)
					->setCellValue('B5', $lote)
					->setCellValue('B6', $silo)
					->setCellValue('B7', $origen)
        		    ->setCellValue('A9',  $titulosColumnas[0])
		            ->setCellValue('B9',  $titulosColumnas[1])
        		    ->setCellValue('C9',  $titulosColumnas[2])
					->setCellValue('D9',  $titulosColumnas[3])
            		->setCellValue('E9',  $titulosColumnas[4])
					->setCellValue('F9',  $titulosColumnas[5])
					->setCellValue('G9',  $titulosColumnas[6])
					->setCellValue('H9',  $titulosColumnas[7])
					->setCellValue('I9',  $titulosColumnas[8])
					->setCellValue('J9',  $titulosColumnas[9])
					->setCellValue('K9',  $titulosColumnas[10])
            		->setCellValue('L9',  $titulosColumnas[11])
					->setCellValue('M9',  $titulosColumnas[12])
					->setCellValue('N9',  $titulosColumnas[13])
					->setCellValue('O9',  $titulosColumnas[14])
					->setCellValue('P9',  $titulosColumnas[15])
					->setCellValue('Q9',  $titulosColumnas[16])
					->setCellValue('R9',  $titulosColumnas[17])
					->setCellValue('S9',  $titulosColumnas[18])
					->setCellValue('T9',  $titulosColumnas[19]);
					
							
		//Se agregan los datos de los alumnos
		$i = 10;
		$numero=0;
		$result = mysql_query($sql);
		while($row = mysql_fetch_assoc($result)) 
                            {	
							$numero++;
							$proveedor=$row[2];
							$fecha_entrada1=parseDatePhp($row['fecha_entrada']);
							$id_transportista_con=$row['id_transportista'];
							$entrada1=$row['entrada'];
							$peso_bruto1=$row['peso_bruto'];
							$peso_tara1=$row['peso_tara'];
							$peso_neto1=round(($peso_bruto1-$peso_tara1),2);
							$fecha1=parseDatePhp($row['fecha_entrada']);
							$hora1=$row['hora_entrada'];	
							$peso_volumetrico1=$row['peso_vol'];
							$temperatura1=$row['temperatura'];
							$humedad1=$row['humedad'];
							$gran_entero1=$row['grano_entero'];
							$gran_quebrado1=$row['grano_quebrado'];
							$dan_hongo1=$row['dan_hongo'];
							$impureza1=$row['impureza'];
							$grano_chico1=$row['grano_chico'];
							$grano_picado1=$row['grano_picado'];
							$plaga_viva1=$row['plaga_viva'];
							$plaga_muerta1=$row['plaga_muerta'];
							$stress_crack1=$row['stress_crack'];
							$olor1=$row['olor'];
							$vapor1=$row['vapor'];
							$neto_sin_humedad1=$row['neto_sin_humedad'];
							$suma_subtotal=$suma_subtotal+$peso_neto1;
							$suma_total=$suma_total+$peso_neto1;
							$suma_sin_humedad=$suma_sin_humedad+$neto_sin_humedad1;
							
							$perdidapeso=round(($peso_neto1-$neto_sin_humedad1),2);
							$neto_sin_humedad2=round($neto_sin_humedad1,2);
							
							$transportista=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_transportista_con' and id_empresa='$id_empresa'");
  		while($row_trans = mysql_fetch_array($transportista)){
		$placa1=$row_trans['placa_vehiculo'];
		$nomtranportista=$row_trans['nom_transportista'].' '.$row_trans['ape_transportista'];
  		}
																			
							
										
					$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i, $numero)
		            ->setCellValue('B'.$i, $entrada1)
        		    ->setCellValue('C'.$i, $placa1)
					->setCellValue('D'.$i, $nomtranportista)
					->setCellValue('E'.$i, $peso_neto1)
					->setCellValue('F'.$i, $perdidapeso)
					->setCellValue('G'.$i, $neto_sin_humedad2)
            		->setCellValue('H'.$i, $fecha1)
					->setCellValue('I'.$i, $hora1)
					->setCellValue('J'.$i, $peso_volumetrico1)
					->setCellValue('K'.$i, $temperatura1)
					->setCellValue('L'.$i, $humedad1)
					->setCellValue('M'.$i, $gran_entero1)
					->setCellValue('N'.$i, $gran_quebrado1)
					->setCellValue('O'.$i, $dan_hongo1)
					->setCellValue('P'.$i, $impureza1)
					->setCellValue('Q'.$i, $grano_chico1)
					->setCellValue('R'.$i, $grano_picado1)
					->setCellValue('S'.$i, $stress_crack1)
					->setCellValue('T'.$i, $plaga_muerta1);
					
		
					$i++;
					
					 		
		}
		
		$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('E'.$i, $titulofinreporte);
					
				
					
///--------------- IMPRIME EL CUADRO RESUMEN --------------------				
					
					
		// FUNCION PARA DAR COLOR A LAS CELDAS
		$estiloTituloReporte = array(
        	'font' => array(
	        	'name'      => 'Arial',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>12,
	            	'color'     => array(
    	            	'rgb' => '020202'
        	       	)
            ),
			/*
	        'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => 'FFFFFF')
			),
			
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE                    
               	)
            ), */
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );


	$estilofinColumnas = array(
        	'font' => array(
	        	'name'      => 'Arial',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>10,
	            	'color'     => array(
    	            	'rgb' => '020202'
        	       	)
            ),
			/*
			    'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => 'FFFFFF')
			),
			
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE                    
               	)
            ), */
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
		
		$estiloTituloColumnas = array(
        	'font' => array(
	        	'name'      => 'Arial',
    	        'bold'      => true,
        	    'italic'    => false,
                'strike'    => false,
               	'size' =>10,
	            	'color'     => array(
    	            	'rgb' => '020202'
        	       	)
            ),/*
	        'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('argb' => 'FFFFFF')
			),
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_NONE                    
               	)
            ), */
            'alignment' =>  array(
        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        			'rotation'   => 0,
        			'wrap'          => TRUE
    		)
        );
 
		/*
			
		$estiloInformacion = new PHPExcel_Style();  // Impresion de la informacion
		$estiloInformacion->applyFromArray(
			array(
           		'font' => array(
               	'name'      => 'Arial',               
               	'color'     => array(
                   	'rgb' => 'FF431a5d'
               	)
           	),
           	'fill' 	=> array(
				'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'		=> array('argb' => 'FFFFFF')
			),
           	'borders' => array(
               	'left'     => array(
                   	'style' => PHPExcel_Style_Border::BORDER_THIN ,
	                'color' => array(
    	            	'rgb' => '3a2a47'
                   	)
               	)             
           	)
        ));
		
		*/
		
		$objPHPExcel->getActiveSheet()->getStyle('A1:T1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:T2')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('B3:E2')->applyFromArray($estiloTituloReporte);
		//$objPHPExcel->getActiveSheet()->getStyle('A9:T9')->applyFromArray($estiloTituloReporte);
		
		
						
		for($i = 'A'; $i <= 'T'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}
		
		
	
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('reporte de calidad');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,10);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Control_calidad.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

?>