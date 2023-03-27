<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece                        
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
//$id_despacho_buscar="ALMACEN-005";
 $id_despacho_buscar=$_GET['id'];

if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
date_default_timezone_set("America/El_Salvador");
?>
<?php
include('font/times.php');
include('font/helveticab.php');
include('font/helveticai.php');
require('fpdf.php');

//$pdf=new FPDF();
$pdf = new FPDF('P', 'mm', array(205,216));
$pdf->AliasNbPages();
$pdf->AddPage('P', 'Letter');

// cuerpo del reporte

$pdf->SetFont('Arial','B',8);
// BUSCA EL NUMERO DE TRANSACCION...
$cont=mysql_query("SELECT * FROM tab_contador WHERE codigo='1'");
  while($row_contador = mysql_fetch_array($cont)){
	$contador2=$row_contador['total'];
	$contador1=number_format($contador2,0,".",",");
	}
$result=mysql_query("SELECT * FROM tab_almacenaje WHERE id_almacenaje='$id_despacho_buscar'");
  
	while($row = mysql_fetch_array($result)){
	$id_cliente=$row['id_cliente'];
	$id_lote = $row['id_lote'];
	$entrada=number_format($row['entrada'],0,".",",");
	$id_transportista = $row['id_transportista'];	
	$id_silo=$row['id_silo'];
	$peso_bruto1=number_format($row['peso_bruto'],2,".", ",");
	//$peso_bruto1=$row['peso_bruto'];
	$fecha1=parseDatePhp($row['fecha_entrada']);
	$hora1=$row['hora_entrada'];	
	//$peso_tara1=$row['peso_tara'];
	$peso_tara1=number_format($row['peso_tara'],2,".", ",");
	$fecha2=parseDatePhp($row['fecha_salida']);
	$hora2=$row['hora_salida'];	
	$peso_neto2=$row['peso_bruto']-$row['peso_tara'];
	$peso_neto1=number_format($peso_neto2,2,".", ",");
	$teorico1=number_format($row['peso_teorico'],2,".", ",");
	$diferencia2= $peso_neto2-$row['peso_teorico'];
	$diferencia1=number_format($diferencia2,2,".", ",");
	$peso_volumetrico1=$row['peso_vol'];	
	$temperatura1=$row['temperatura'];
	$humedad1=$row['humedad'];
	$peso_gran_entero=$row['grano_entero'];
	$peso_gran_quebrado=$row['grano_quebrado'];
	$peso_gran_hongo=$row['dan_hongo'];
	$peso_gran_impureza=$row['impureza'];
	$peso_gran_chico=$row['grano_chico'];
	$peso_gran_picado=$row['grano_picado'];
	$peso_gran_stress=$row['stress_crack'];	
	$peso_plaga_muerta=$row['plaga_muerta'];	
	$peso_plaga_viva=$row['plaga_viva'];	
	$peso_olor=$row['olor'];
	$peso_vapor=$row['vapor'];	
		
	$peso_seco=number_format(round($row['neto_sin_humedad'],2),2,".", ",");
	
	$usuario_busca=$row['id_usuario2'];	
	
	//CALCULOS
	$cal_peso_vol=round(($peso_volumetrico1/100)*$peso_neto1,2);
	$cal_peso_hum=round(($humedad1/100)*$peso_neto1,2);	
	$cal_peso_tem=round(($temperatura1/100)*$peso_neto1,2);	
	$cal_peso_graen=round(($peso_gran_entero/100)*$peso_neto1,2);
	$cal_peso_graque=round(($peso_gran_quebrado/100)*$peso_neto1,2);	
	$cal_peso_danhongo=round(($peso_gran_hongo/100)*$peso_neto1,2);	
	$cal_peso_impureza=round(($peso_gran_impureza/100)*$peso_neto1,2);	
	$cal_peso_gran_chico=round(($peso_gran_chico/100)*$peso_neto1,2);	
	$cal_peso_gran_picado=round(($peso_gran_picado/100)*$peso_neto1,2);	
	$cal_peso_gran_stress=round(($peso_gran_stress/100)*$peso_neto1,2);			
	
	
	$result1=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='$id_cliente'"); // NOMBRE DEL CLIENTE
	while($row_cliente=mysql_fetch_array($result1)){
		$nom_cliente1=utf8_decode($row_cliente['nom_cliente']);
		}
		
	$result2=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote'"); // NUMERO DEL LOTE
	while($row2=mysql_fetch_array($result2)){
		$num_lote1=$row2['num_lote'];
		$id_producto=$row2['id_producto'];
		}
	
	$result3=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto'"); // producto
	while($row3=mysql_fetch_array($result3)){
		$nom_producto1=utf8_decode($row3['nom_producto']);
		$nom_productor=utf8_decode($row3['nom_productor']);		
		}


	$result5=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_transportista'"); // piloto
	while($row5=mysql_fetch_array($result5)){
		$placa1=utf8_decode($row5['placa_vehiculo']);
		$piloto1=utf8_decode($row5['nom_transportista']." ".$row5['ape_transportista']);		
		}	
	
	$result7=mysql_query("SELECT * FROM tab_silo WHERE id_silo='$id_silo'"); // piloto
	while($row7=mysql_fetch_array($result7)){
		$nom_silo1=utf8_decode($row7['nom_silo']);
		}		

$result8=mysql_query("SELECT * FROM t_usuarios WHERE id_usuario='$usuario_busca'"); // piloto
	while($row8=mysql_fetch_array($result8)){
		$nombre_usuario=$row8['nombre_usuario'];		
		}				

$pdf->Cell(1);
$pdf->Rect(5,5,200,130);
$pdf->SetFont('Times','',11);
//ENCABEZADO
$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");

    //Logo
	$pdf->Image('logo/logo.png',7,7);
//<img src="logo/logo.png" width="80" height="66" />
	 //TITULO DEL REPORTE
 	$pdf->Ln(5);	 
	$pdf->Cell(80);
    $pdf->SetFont('Arial','B',14);
	$pdf->Cell(40,5,'INDICADORES DE CALIDAD',0,0,'C');
	
	//Salto de línea
    $pdf->Ln(4);
	 //Movernos a la derecha
    $pdf->Cell(130);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(40,5,'FECHA DE IMPRESION:',0,0,'C');
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(20,5,$fecha_entrada,0,0,'C');
    $pdf->Ln(4);	
	$pdf->Cell(130);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(39,5,'HORA DE IMPRESION:',0,0,'C');
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(20,5,$hora,0,0,'C');
	
	//Salto de línea
    $pdf->Ln(4);
	 //Movernos a la derecha
    $pdf->Cell(50);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40,5,utf8_decode('Número de Control'),0,0,'C');
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(23,5,$contador1,0,0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(0);
	$pdf->Cell(65);
	$pdf->Cell(0,5,utf8_decode('N° de Entrada'),0,0,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(-45);
	$pdf->Cell(1,5,$entrada,0,0);
				
    $pdf->Ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Cliente:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->MultiCell(80,5,utf8_decode($nom_cliente1));
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Producto:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_producto1),0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Piloto:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($piloto1)."           ".utf8_decode($placa1),0,0,'J');
	$pdf->Ln(5);	
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Operador:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
	$pdf->MultiCell(120,5,utf8_decode($nombre_usuario));	
 //	$pdf->MultiCell(80,5,utf8_decode($_SESSION['nombre_usuario_silo']));
	//$pdf->Ln(5);	
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,utf8_decode('Ubicación:'),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->cell(80,5,utf8_decode($nom_silo1));
	$pdf->Cell(-25);
    $pdf->Cell(10,5,utf8_decode('N° de Lote:'),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->cell(80,5,utf8_decode($num_lote1));
	$pdf->Ln(5);	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40);
    $pdf->Cell(10,5,'Peso Kg',0,0,'J',0); 
	$pdf->Cell(40);
    $pdf->Cell(10,5,'Fecha',0,0,'J',0);
	$pdf->Cell(40);
    $pdf->Cell(10,5,'Hora',0,0,'J',0);	 	
	$pdf->Ln(4);
	$pdf->Cell(15);
    $pdf->Cell(10,5,'Bruto',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(10,5,$peso_bruto1,0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(5,5,$fecha1,0,'C');
	$pdf->Cell(46);
 	$pdf->Cell(5,5,$hora1,0,'C');	
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',10);	
 	$pdf->Cell(5,5,'Entrada',0,'C');
	$pdf->Ln(4);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Tara',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(10,5,$peso_tara1,0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(5,5,$fecha2,0,'C');
	$pdf->Cell(46);
 	$pdf->Cell(5,5,$hora2,0,'C');	
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',10);	
 	$pdf->Cell(5,5,'Salida',0,'C');
	$pdf->Ln(5);
	$pdf->Cell(15);
	$pdf->Cell(160, 0, '', 1, 1, 0, 'C', false );
	$pdf->Ln(0);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Neto',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(10,5,$peso_neto1,0,'C');
	//$pdf->Ln(5);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,utf8_decode('Peso seco'),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(10,5,$peso_seco. '  Kg',0,'C');
	$pdf->Ln(5);
	$pdf->Cell(-5);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(200,4,utf8_decode('INDICADORES'),0,0,'C',0); 
	$pdf->Ln(5);
	$pdf->Cell(-3);
	$pdf->SetFont('Arial','B',10);		
	$pdf->Cell(5,4,'N',1,0,'J',0); 
	$pdf->Cell(50,4,'INDICADOR',1,0,'C',0);
	$pdf->Cell(15,4,'%',1,0,'C',0);
	$pdf->Cell(25,4,'KG',1,0,'C',0);
	$pdf->Cell(3);
	$pdf->SetFont('Arial','B',10);		
	$pdf->Cell(5,4,'N',1,0,'J',0); 
	$pdf->Cell(50,4,'INDICADOR',1,0,'C',0);
	$pdf->Cell(15,4,'%',1,0,'C',0);
	$pdf->Cell(25,4,'KG',1,0,'C',0);
	
	$pdf->Ln(4);
	$pdf->Cell(-3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'1',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Peso Volumétrico'),1,0,'C',0);
	$pdf->Cell(15,4,$peso_volumetrico1,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_vol,1,0,'C',0);
	$pdf->Cell(3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'4',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Daño por Hongo'),1,0,'C',0);
	$pdf->Cell(15,4,$peso_gran_hongo,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_danhongo,1,0,'C',0);
	$pdf->Ln(4);
	$pdf->Cell(-3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'2',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Humedad'),1,0,'C',0);
	$pdf->Cell(15,4,$humedad1,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_hum,1,0,'C',0);
	$pdf->Cell(3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'7',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Impureza'),1,0,'C',0);
	$pdf->Cell(15,4,$peso_gran_impureza,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_impureza,1,0,'C',0);
	$pdf->Ln(4);
	$pdf->Cell(-3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'3',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Temperatura'),1,0,'C',0);
	$pdf->Cell(15,4,$temperatura1,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_tem,1,0,'C',0);
	$pdf->Cell(3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'8',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Grano Chico'),1,0,'C',0);
	$pdf->Cell(15,4,$peso_gran_chico,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_gran_chico,1,0,'C',0);
	$pdf->Ln(4);
	$pdf->Cell(-3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'4',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Grano Entero'),1,0,'C',0);
	$pdf->Cell(15,4,$peso_gran_entero,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_graen,1,0,'C',0);
	$pdf->Cell(3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'9',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Grano Picado'),1,0,'C',0);
	$pdf->Cell(15,4,$peso_gran_picado,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_gran_picado,1,0,'C',0);
	$pdf->Ln(4);
	$pdf->Cell(-3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'5',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Grano Quebrado'),1,0,'C',0);
	$pdf->Cell(15,4,$peso_gran_quebrado,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_graque,1,0,'C',0);
	$pdf->Cell(3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'10',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Sress Crack'),1,0,'C',0);
	$pdf->Cell(15,4,$peso_gran_stress,1,0,'C',0);
	$pdf->Cell(25,4,$cal_peso_gran_stress,1,0,'C',0);
	$pdf->Ln(5);
	$pdf->Cell(-5);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(200,5,utf8_decode('OTROS INDICADORES'),0,0,'C',0); 
	$pdf->Ln(4);
	$pdf->Cell(-3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'11',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Plaga Muerta'),1,0,'C',0);
	$pdf->Cell(40,4,$peso_plaga_muerta. ' UNIDADES',1,0,'J',0);
	$pdf->Cell(3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'14',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('VAPOR'),1,0,'C',0);
	$pdf->Cell(40,4,$peso_vapor,1,0,'J',0);
	$pdf->Ln(4);
	$pdf->Cell(-3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'12',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('Plaga Viva'),1,0,'C',0);
	$pdf->Cell(40,4,$peso_plaga_viva. ' UNIDADES',1,0,'J',0);	
	$pdf->Cell(3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,8,'15',1,0,'C',0); 
	$pdf->MultiCell(50,4,'SUBPRODUCTO(Impureza+Grano chico+Grano quebrado)',1,0,'J',0);
	$pdf->SetY(114);
	$pdf->Cell(150);
//	$pdf->SetX(55);	
	$pdf->Cell(15,8,($peso_gran_impureza+$peso_gran_chico+$peso_gran_quebrado). ' %',1,0,'J',0);
	$pdf->Cell(25,8,($cal_peso_impureza+$cal_peso_gran_chico+$cal_peso_graque). ' Kg',1,0,'J',0);
	
	$pdf->Ln(4);
	$pdf->Cell(-3);
	$pdf->SetFont('Arial','',9);		
    $pdf->Cell(5,4,'13',1,0,'C',0); 
	$pdf->Cell(50,4,utf8_decode('OLOR'),1,0,'C',0);
	$pdf->Cell(40,4,$peso_olor,1,0,'J',0);
	
	
	
/*	$pdf->Ln(10);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,6,utf8_decode('Nota: Este análisis NO es un certificado de calidad y se emite unicamente para uso interno de la empresa SILOS DE AMATITAN'));
	$pdf->SetY(157);
	$pdf->Cell(30);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(8,6,utf8_decode('Original: Gerencia'),0,0,'J',0); 
	$pdf->SetY(157);
	$pdf->Cell(75);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(8,6,utf8_decode('Duplicado: Archivo'),0,0,'J',0);
	$pdf->SetY(157);
	$pdf->Cell(115);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(8,6,utf8_decode('Triplicado: Cliente'),0,0,'J',0);

*/
	$pdf->SetFont('Arial','',10);		
	$pdf->Rect(5,5,200,130);
	$pdf->SetY(129);
	$pdf->Ln(-1);
	$pdf->Cell(155); 
	$pdf->Cell(40,0,'PAGINA:   '.$pdf->PageNo().'/{nb}',0,0,'C');
	$pdf->Ln(155);
		
	}


$pdf->Output();
?>
