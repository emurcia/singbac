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

$seleccion1= $_GET['id1'];

	if($seleccion1=="TODOS"){
 $sql=mysql_query("SELECT * FROM tab_agricultor WHERE fecha_modifica>='2022-01-01' AND id_empresa='$id_empresa'");
 }else{
	 $sql=mysql_query("SELECT * FROM tab_agricultor WHERE zona='$seleccion1' AND fecha_modifica>='2022-01-01' and id_empresa='$id_empresa'");
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
							 ->setDescription("Agricultores")
							 ->setKeywords("Agricultores")
							 ->setCategory("Reporte excel");

		
			
		$tituloReporte = "REGISTRO Y CARNETIZACIÓN DE PRODUCTORES AGROALIMENTARIOS";
		//$periodo= "Fecha elaborado ".$fecha_entrada;
		$titulosColumnas = array('N°', 'Nombre completo', 'DUI', 'Núcleo familiar', 'Siembra principal', 'Siembra secundaria', 'Extensión de la parcela (mz)', 'Tipo de tenencia de tierra', 'Época de siembra', 'Departamento', 'Municipio', 'Cantón', 'Teléfono', 'Dirección de vivienda');
		
		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A1:I1')
					->mergeCells('A2:I2');
		

		
		//$a=1;			
		
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',$tituloReporte)
					->setCellValue('A2',$periodo)
				
        		    ->setCellValue('A6',  $titulosColumnas[0])
		            ->setCellValue('B6',  $titulosColumnas[1])
        		    ->setCellValue('C6',  $titulosColumnas[2])
					->setCellValue('D6',  $titulosColumnas[3])
            		->setCellValue('E6',  $titulosColumnas[4])
					->setCellValue('F6',  $titulosColumnas[5])
					->setCellValue('G6',  $titulosColumnas[6])
					->setCellValue('H6',  $titulosColumnas[7])
					->setCellValue('I6',  $titulosColumnas[8])
					->setCellValue('J6',  $titulosColumnas[9])
					->setCellValue('K6',  $titulosColumnas[10])
					->setCellValue('L6',  $titulosColumnas[11])
					->setCellValue('M6',  $titulosColumnas[12])
					->setCellValue('N6',  $titulosColumnas[13]);
					
							
		//Se agregan los datos de los alumnos
		$i = 7;
		$i2=1;
		//$result = mysql_query($sql);
		 while($row = mysql_fetch_assoc($sql)) 
                {	
					if ($row['spmaiz']==1){$var1="MAÍZ";}else{$var1="";}
					if ($row['spfrijol']==1){$var2="FRIJOL";}else{$var2="";}
					if ($row['spsorgo']==1){$var3="SORGO";}else{$var3="";}
					if ($row['spcafe']==1){$var4="CAFÉ";}else{$var4="";}
					$var5=$var1.'    '.$var2.'    '.$var3.'    '.$var4;
					
					
					if ($row['ssmaiz']==1){$var11="MAÍZ";}else{$var11="";}
					if ($row['ssfrijol']==1){$var22="FRIJOL";}else{$var22="";}
					if ($row['sssorgo']==1){$var33="SORGO";}else{$var33="";}
					if ($row['sscafe']==1){$var44="CAFÉ";}else{$var44="";}
					$var55=$var11.'    '.$var22.'    '.$var33.'    '.$var44;
					
					if ($row['invierno']==1){$var111="INVIERNO";}else{$var111="";}
					if ($row['postrera']==1){$var222="POSTRERA";}else{$var222="";}
					if ($row['apante']==1){$var333="APANTE";}else{$var333="";}
					$var555=$var111.'    '.$var222.'    '.$var333;
						
										
					$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i, $i2)
					->setCellValue('B'.$i, $row['nom_agricultor']. ' '.$row['ape_agricultor'])
					
					
            		->setCellValue('C'.$i, $row['dui_agricultor'])
					->setCellValue('D'.$i, $row['nucleo_familiar'])
					->setCellValue('E'.$i, $var5)
					->setCellValue('F'.$i, $var55)
					->setCellValue('G'.$i, $row['area_cultiva'])
					->setCellValue('H'.$i, $row['propiedad'])
					->setCellValue('I'.$i, $var555)
					->setCellValue('J'.$i, $row['nom_depto'])
					->setCellValue('K'.$i, $row['nom_municipio'])
					->setCellValue('L'.$i, $row['zona'])
					->setCellValue('M'.$i, $row['tel_agricultor'])
					->setCellValue('N'.$i, $row['direccion']);
					
		
					$i++;
					$i2++;
					
					 		
		}
	
		
						
				
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
		$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($estilofinColumnas);
		$objPHPExcel->getActiveSheet()->getStyle('A6:N6')->applyFromArray($estiloTituloColumnas);
		
		for($i = 'A'; $i <= 'N'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}

		
	
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Agricultores');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,7);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="agricultor.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

?>