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
$seleccion1=$_GET['id1'];
               if($id_usuario!='USU-0351'){
               		if($seleccion1=="TODOS"){
 				$where1="id_empresa='$id_empresa' AND id_usuario_ingreso='$id_usuario' AND eliminado='0' AND canasta='SI' ORDER BY zona";
 			}else{
	 			$where1="zona='$seleccion1' AND id_usuario_ingreso='$id_usuario' AND eliminado='0' AND canasta='SI' AND id_empresa='$id_empresa' ORDER BY zona";
	 		}
             //   $sql= "SELECT * FROM `tab_agricultor` WHERE zona='$seleccion1' AND id_usuario_ingreso='$id_usuario' ORDER BY zona";
                   }else{
                   	if($seleccion1=="TODOS"){
 				$where1="id_empresa='$id_empresa' AND eliminado='0' AND canasta='SI' ORDER BY zona";
 			}else{
	 			$where1="zona='$seleccion1' AND id_empresa='$id_empresa' AND eliminado='0' AND canasta='SI' ORDER BY zona";
	 		}
                   
             //    $sql= mysql_query("SELECT zona FROM `tab_agricultor` GROUP BY zona");
                 }
                 
                  $sql=mysql_query("SELECT * FROM tab_agricultor where $where1");
 
/*
$seleccion1= $_GET['id1'];

	if($seleccion1=="TODOS"){
 $sql=mysql_query("SELECT * FROM tab_agricultor WHERE id_empresa='$id_empresa'");
 }else{
	 $sql=mysql_query("SELECT * FROM tab_agricultor WHERE zona='$seleccion1' and id_empresa='$id_empresa'");
	 }
		
*/
				
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

		
			
		$tituloReporte = "BIENESTAR SOCIAL";
		$tituloReporte2 = "GRUPO FAMILIAR";
		$titulosColumnas = array('N.', 'NOMBRE1', 'NOMBRE2', 'NOMBRE3','APELLIDO1', 'APELLIDO2', 'APELLIDO CASADA', 'DUI', 'DEPARTAMENTO','MUNICIPIO', 'CANTON O CASERIO ', 'NUMERO DE CONTACTO', 'RUBRO', 'NIÑOS', 'ADULTOS', '+60 AÑOS');
		
		$objPHPExcel->setActiveSheetIndex(0)
        		    ->mergeCells('A1:M1')
					->mergeCells('N1:P1');


					//FILTROS
					
$objPHPExcel->getActiveSheet()->setAutoFilter("A2:P2");	
	
		

		
		//$a=1;			
		
		// Se agregan los titulos del reporte
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1',$tituloReporte)
					->setCellValue('N1',$tituloReporte2)
								
        		    ->setCellValue('A2',  $titulosColumnas[0])
		            ->setCellValue('B2',  $titulosColumnas[1])
        		    ->setCellValue('C2',  $titulosColumnas[2])
					->setCellValue('D2',  $titulosColumnas[3])
            		->setCellValue('E2',  $titulosColumnas[4])
					->setCellValue('F2',  $titulosColumnas[5])
					->setCellValue('G2',  $titulosColumnas[6])
					->setCellValue('H2',  $titulosColumnas[7])
					->setCellValue('I2',  $titulosColumnas[8])
					->setCellValue('J2',  $titulosColumnas[9])
        		    ->setCellValue('K2',  $titulosColumnas[10])
					->setCellValue('L2',  $titulosColumnas[11])
            		->setCellValue('M2',  $titulosColumnas[12])
					->setCellValue('N2',  $titulosColumnas[13])
					->setCellValue('O2',  $titulosColumnas[14])
					->setCellValue('P2',  $titulosColumnas[15]);
					
							
		//Se agregan los datos de los alumnos
		$i = 3;
		$i2=1;
		//$result = mysql_query($sql);
		 while($row = mysql_fetch_assoc($sql)) 
                {	
				
					
						list($nom1, $nom2, $nom3, $nom4) = split(' ', $row['nom_agricultor']);	
						list($ape1, $ape2,$ape3, $ape4) = split(' ', $row['ape_agricultor']);
						
						
						
						
						if ($nom3=='DE'){$nom3=$nom3.' '.$nom4;}
						if ($nom3=='LOS'){$nom2=$nom2.' '.$nom3.' '.$nom4;
										 $nom3="";}
						
						if($nom2=='DE' OR $nom2=='DEL'){$nom2=$nom2.' '.$nom3;
										$nom3="";}
						
										
										
						if($ape2=='DE'){$ape3=$ape2.' '.$ape3;
										$ape2="";
										}
						if($ape2=='VDA.'){$ape3=$ape2.' '.$ape3.' '.$ape4;
										$ape2="";
										}
						
						if($ape2=='VDA'){$ape3=$ape2.' '.$ape3.' '.$ape4;
										$ape2="";
										}										
										
						 						
						if($row['oficio']=='AMA DE CASA' OR $row['oficio']=='DOMESTICOS' ){
							$oficio="VENDEDOR INFORMAL";
							}else{
							$oficio=$row['oficio'];
							}											
								
					$objPHPExcel->setActiveSheetIndex(0)
        		    ->setCellValue('A'.$i, $i2)
					->setCellValue('B'.$i, $nom1)
					->setCellValue('C'.$i, $nom2)
					->setCellValue('D'.$i, $nom3)
					->setCellValue('E'.$i, $ape1)
					->setCellValue('F'.$i, $ape2)
					->setCellValue('G'.$i, $ape3)
					->setCellValue('H'.$i, $row['dui_agricultor'])
					->setCellValue('I'.$i, 'SAN VICENTE')
					->setCellValue('J'.$i, 'SAN CAYETANO ISTEPEQUE')
					->setCellValue('K'.$i, $row['zona'])
					->setCellValue('L'.$i, $row['tel_agricultor'])					
					->setCellValue('M'.$i, $oficio)
					->setCellValue('N'.$i, $row['ninos'])
					->setCellValue('O'.$i, $row['adultos'])					
					->setCellValue('P'.$i, $row['terceraedad']);
		
					$i++;
					$i2++;
					$i4=$i4+2;
					
		$objPHPExcel->getActiveSheet()
		->getStyle('A'.$i4.':'.'P'.$i4)
       ->getFill()
       ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
	   
       ->getStartColor()
       ->setARGB('FFF2CC');		 		
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
			
			
			
			
	        'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => 'FFC000')
			),
			
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_THIN                    
               	)
            ), 
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
			
			    'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => 'FFC000')
			),
			
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_THIN                    
               	)
            ), 
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
            ),
	       'fill' => array(
				'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
				'color'	=> array('rgb' => 'FFC000')
			),
			
            'borders' => array(
               	'allborders' => array(
                	'style' => PHPExcel_Style_Border::BORDER_THIN                    
               	)
            ), 
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
				'color'		=> array('rgb' => 'FFFFFF')
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
	
	
	   
		$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('N1:P1')->applyFromArray($estiloTituloReporte);
		$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray($estiloTituloColumnas);
		

				
		
		for($i = 'A'; $i <= 'P'; $i++){
			$objPHPExcel->setActiveSheetIndex(0)			
				->getColumnDimension($i)->setAutoSize(TRUE);
		}

		
	
		// Se asigna el nombre a la hoja
		$objPHPExcel->getActiveSheet()->setTitle('Canastas');

		// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
		$objPHPExcel->setActiveSheetIndex(0);
		// Inmovilizar paneles 
		//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
		$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,3);

		// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="canastas.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit;

?>