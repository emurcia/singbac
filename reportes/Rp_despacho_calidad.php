<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece                        
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
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

$pdf=new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'Letter');
	


// cuerpo del reporte
//$pdf->SetFillColor(238,197,32);

$pdf->SetFont('Arial','B',8);
$result=mysql_query("SELECT * FROM tab_salida WHERE id_salida='$id_despacho_buscar'");
  
	while($row = mysql_fetch_array($result)){
	$id_cliente=$row['id_cliente'];
	$id_lote = $row['id_lote'];
	$id_transportista = $row['id_transportista'];	
	$vapor1=utf8_decode($row['vapor']);
	$peso_vol1=$row['peso_vol'];
	$temperatura1=$row['temperatura'];	
	$humedad1=$row['humedad'];
	$olor1=utf8_decode($row['olor']);
	$grano_entero1=($row['grano_entero']);	
	$grano_quebrado1=($row['grano_quebrado']);	
	$dan_hongo1=($row['dan_hongo']);	
	$impureza1=($row['impureza']);
	$grano_chico1=($row['grano_chico']);
	$total1=$grano_entero1+$grano_quebrado1+$dan_hongo1+$impureza1+$grano_chico1;
	$observacion1=utf8_decode($row['observacion']);	
	$analista1=utf8_decode($row['nom_analista']);						
	
	$result1=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='$id_cliente'"); // NOMBRE DEL CLIENTE
	while($row_cliente=mysql_fetch_array($result1)){
		$nom_cliente1=utf8_decode($row_cliente['nom_cliente']);
		}
		
	$result2=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote'"); // NUMERO DEL LOTE
	while($row2=mysql_fetch_array($result2)){
		$num_lote1=$row2['num_lote'];
		$id_producto=$row2['id_producto'];
		$id_subproducto=$row2['id_subproducto'];
		}
	
	$result3=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto'"); // producto
	while($row3=mysql_fetch_array($result3)){
		$nom_producto1=utf8_decode($row3['nom_producto']);
		}
	$result4=mysql_query("SELECT * FROM tab_subproducto WHERE id_subproducto='$id_subproducto'"); // subproducto
	while($row4=mysql_fetch_array($result4)){
		$nom_subproducto1=utf8_decode($row4['nom_subproducto']);
		}	

	$result5=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_transportista'"); // piloto
	while($row5=mysql_fetch_array($result5)){
		$placa1=utf8_decode($row5['placa_vehiculo']);
		$piloto1=utf8_decode($row5['nom_transportista']." ".$row5['ape_transportista']);		
		}	

$pdf->Cell(1);
$pdf->Rect(5,5,200,268);
$pdf->SetFont('Times','',12);
//ENCABEZADO
$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");

    //Logo
	$pdf->Image('logo/logo.png',10,10);
//<img src="logo/logo.png" width="80" height="66" />
	 //TITULO DEL REPORTE
 	$pdf->Ln(4);	 
	$pdf->Cell(80);
    $pdf->SetFont('Arial','B',15);
	$pdf->Cell(40,5,'CONTROL DE CALIDAD',0,0,'C');
	
	//Salto de línea
    $pdf->Ln(5);
	 //Movernos a la derecha
    $pdf->Cell(130);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(40,5,'FECHA DE IMPRESION:',0,0,'C');
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(20,5,$fecha_entrada,0,0,'C');
    $pdf->Ln(5);	
	$pdf->Cell(130);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(39,5,'HORA DE IMPRESION:',0,0,'C');
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(20,5,$hora,0,0,'C');
	
	//Salto de línea
    $pdf->Ln(6);
	 //Movernos a la derecha
    $pdf->Cell(50);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40,5,'MUESTRA',0,0,'C');
    $pdf->SetFont('Arial','B',10);
	$pdf->Cell(23,5,'RECEPCION ',0,0,'C');
	$pdf->Rect(122,30,6,5);

	$pdf->Ln(0);
	$pdf->Cell(130);
	$pdf->Cell(0,5,'DESPACHO',0,0,'J');
	$pdf->Rect(163,30,6,5);
	$pdf->Cell(-36);
	$pdf->Cell(1,5,'X',0,0);
	

	//Salto de línea

//	$pdf->Line(5,45,205,45); 
    $pdf->Ln(6);
	$pdf->Cell(35);
					
		
    $pdf->Ln(8);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(20);
    $pdf->Cell(10,5,'Cliente:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->MultiCell(60,5,$nom_cliente1);
//	$pdf->Ln(1);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(20);
    $pdf->Cell(10,5,utf8_decode('Lote N°:'),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(1,5,$num_lote1,0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(20);
    $pdf->Cell(10,5,'Producto:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(1,5,$nom_producto1,0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(20);
    $pdf->Cell(10,5,'Subproducto:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(1,5,$nom_subproducto1,0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(20);
    $pdf->Cell(10,5,'Vapor:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(1,5,$vapor1,0,0,'J');
	$pdf->SetFont('Arial','',12);
	
	$pdf->SetY(44);
	$pdf->Cell(120);
    $pdf->Cell(10,5,utf8_decode("Peso Volumétrico:"),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30);
 	$pdf->Cell(1,5,$peso_vol1,0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(120);
    $pdf->Cell(10,5,utf8_decode("Temperatura:"),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30);
 	$pdf->Cell(1,5,$temperatura1,0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(120);
    $pdf->Cell(10,5,utf8_decode("Humedad:"),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30);
 	$pdf->Cell(1,5,$humedad1,0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(120);
    $pdf->Cell(10,5,utf8_decode("Olor:"),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(30);
 	$pdf->Cell(1,5,$olor1,0,0,'J');
	
    $pdf->Ln(25);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(10);
    $pdf->Cell(8,6,'1',1,0,'C',0); 
	$pdf->Cell(40,6,'Grano Entero:',1,0,'J',0); 
	$pdf->Cell(15,6,$grano_entero1,1,0,'C',0);
	$pdf->Cell(8,6,'%',0,0,'C',0); 
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(10);
    $pdf->Cell(8,6,'2',1,0,'C',0); 
	$pdf->Cell(40,6,'Grano Quebrado:',1,0,'J',0); 
	$pdf->Cell(15,6,$grano_quebrado1,1,0,'C',0);
	$pdf->Cell(8,6,'%',0,0,'C',0); 
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(10);
    $pdf->Cell(8,6,'3',1,0,'C',0); 
	$pdf->Cell(40,6,utf8_decode("Dañor por Hongo:"),1,0,'J',0); 
	$pdf->Cell(15,6,$dan_hongo1,1,0,'C',0);
	$pdf->Cell(8,6,'%',0,0,'C',0);
	
	$pdf->SetY(84);
	$pdf->Cell(110);
    $pdf->Cell(8,6,'4',1,0,'C',0); 
	$pdf->Cell(40,6,'Impureza:',1,0,'J',0); 
	$pdf->Cell(15,6,$impureza1,1,0,'C',0);  
	$pdf->Cell(8,6,'%',0,0,'C',0); 
	$pdf->Ln(6);
	$pdf->Cell(110);
	$pdf->Cell(8,6,'5',1,0,'C',0); 
	$pdf->Cell(40,6,'Grano Chico:',1,0,'J',0); 
	$pdf->Cell(15,6,$grano_chico1,1,0,'C',0);  
	$pdf->Cell(8,6,'%',0,0,'C',0); 
	$pdf->Ln(6);
	$pdf->Cell(110);
	$pdf->Cell(8,6,'',1,0,'C',0); 
	$pdf->Cell(40,6,'Total:',1,0,'J',0); 
	$pdf->Cell(15,6,$total1,1,0,'C',0);  
	$pdf->Cell(8,6,'%',0,0,'C',0); 	
	$pdf->Ln(11);
	$pdf->Cell(10,6,'Observaciones:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Ln(1);
	$pdf->Cell(33);
 	$pdf->MultiCell(155,5,$observacion1);
	$pdf->SetY(138);
	$pdf->Cell(10);
	$pdf->Cell(20,6,$placa1,0,0,'C',0);
	$pdf->Ln(5);
	$pdf->Cell(7);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(8,6,utf8_decode('N° de Placa'),0,0,'J',0); 
	$pdf->SetY(138);
	$pdf->Cell(50);
	$pdf->SetFont('Arial','',10);	
	$pdf->MultiCell(50,4,$piloto1);
//	$pdf->Ln(5);
	$pdf->Cell(60);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(10,6,utf8_decode('Nombre Piloto'),0,0,'J',0);
	$pdf->SetY(138);
	$pdf->Cell(120);
	$pdf->SetFont('Arial','',10);	
	$pdf->Cell(20,6,$analista1,0,0,'C',0);
	$pdf->Ln(5);
	$pdf->Cell(120);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(10,6,utf8_decode('Analista'),0,0,'J',0);
	$pdf->Ln(0);
	$pdf->Cell(175);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(10,6,utf8_decode('Firma'),0,0,'J',0);
	$pdf->Ln(8);
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

	$pdf->Rect(5,5,200,268);
	$pdf->SetY(274);
	$pdf->Ln(-10);
	$pdf->Cell(155); 
	$pdf->Cell(40,0,'PAGINA:   '.$pdf->PageNo().'/{nb}',0,0,'C');
	$pdf->Ln(155);
	
	}


$pdf->Output();
?>
