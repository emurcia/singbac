<?PHP
ini_set('session.save_handler', 'files');
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
 
//$id_despacho_buscar="DESPACH-002";
 $fec_inicio1=$_GET['id'];
 $fec_fin1=$_GET['id2'];
 $fec_inicio=parseDateMysql($_GET['id']);
 $fec_fin=parseDateMysql($_GET['id2']);


$loginSQL=mysql_query("SELECT SUM(peso_bruto) as peso_bruto, SUM(peso_tara) AS peso_tara, SUM(neto_sin_humedad) AS neto_sin_humedad  FROM tab_almacenaje WHERE (fecha_entrada>='$fec_inicio' AND fecha_entrada<='$fec_fin')",$con);
$fila_usu = mysql_fetch_array($loginSQL);
$peso_netoimprime=number_format($fila_usu['peso_bruto'],2);
$peso_taraimprime=number_format($fila_usu['peso_tara'],2);
$peso_brutoimprime1=number_format(($fila_usu['peso_bruto']-$fila_usu['peso_tara']),2);
$peso_sin_humedad=number_format($fila_usu['neto_sin_humedad'],2);

$consul=mysql_query("SELECT SUM(peso_bruto) AS peso_bruto2, SUM(peso_tara) AS peso_tara2, SUM(peso_sin_humedad) AS neto_sin_humedad2  FROM tab_salida WHERE (fecha_entrada>='$fec_inicio' AND fecha_entrada<='$fec_fin')",$con);
$fila_consul= mysql_fetch_array($consul);
$peso_netoimprime2=number_format($fila_consul['peso_bruto2'],2);
$peso_taraimprime2=number_format($fila_consul['peso_tara2'],2);
$peso_brutoimprime2=number_format(($fila_consul['peso_bruto2']-$fila_consul['peso_tara2']),2);
$peso_sin_humedad2=number_format($fila_consul['neto_sin_humedad2'],2);

$saldoentrada=number_format(($fila_usu['peso_bruto']-$fila_consul['peso_bruto2']),2);
$saldosalida=number_format(($fila_usu['peso_tara']-$fila_consul['peso_tara2']),2);
$saldo_bruto=number_format(($fila_usu['peso_bruto']-$fila_usu['peso_tara']),2);
$saldo_tara=number_format(($fila_consul['peso_bruto2']-$fila_consul['peso_tara2']),2);
$saldosaldo=number_format((($fila_usu['peso_bruto']-$fila_usu['peso_tara'])-($fila_consul['peso_bruto2']-$fila_consul['peso_tara2'])),2);
$saldo_humedadtotal=number_format(($fila_usu['neto_sin_humedad']-$fila_consul['neto_sin_humedad2']),2);

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
						

$pdf->Cell(1);
$pdf->Rect(5,5,200,130);
$pdf->SetFont('Times','',12);
//ENCABEZADO
$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");

    //Logo
	$pdf->Image('logo/logo.png',8,8	);
	//TITULO DEL REPORTE
 	$pdf->Ln(4);	 
	$pdf->Cell(80);
    $pdf->SetFont('Arial','B',15);
	$pdf->Cell(40,5,'COMPROBANTE DE INGRESO Y EGRESOS',0,0,'C');
	$pdf->Ln(4);	 
	$pdf->Cell(80);
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(40,5,'Del '.$fec_inicio1.'  Al  '.$fec_fin1,0,0,'C');
	
	//Salto de línea
    $pdf->Ln(6);
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

	//$pdf->SetFont('Arial','',11);
	//$pdf->Cell(17);
    //$pdf->Cell(10,5,'Operador:',0,0,'J',0); 
	//$pdf->SetFont('Arial','',10);
	//$pdf->Cell(22);
	//$pdf->MultiCell(80,5,utf8_decode($nombre_usuario));	
 //	$pdf->MultiCell(80,5,utf8_decode($_SESSION['nombre_usuario_silo']));

	$pdf->Ln(8);	
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(38);
    $pdf->Cell(10,5,'ENTRADA',0,0,'J',0); 
	$pdf->Cell(38);
    $pdf->Cell(10,5,'SALIDA',0,0,'J',0);
	$pdf->Cell(40);
    $pdf->Cell(10,5,'SALDO',0,0,'J',0);	 	
	$pdf->Ln(5);
	$pdf->Cell(15);
    $pdf->Cell(10,5,'Bruto',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(15);
 	$pdf->Cell(10,5,$peso_netoimprime,0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(5,5,$peso_netoimprime2,0,'C');
	$pdf->Cell(46);
 	$pdf->Cell(5,5,($saldoentrada),0,'C');	
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',10);	
 //	$pdf->Cell(5,5,'Salida',0,'C');
	$pdf->Ln(5);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Tara',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(15);
 	$pdf->Cell(10,5,$peso_taraimprime,0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(5,5,$peso_taraimprime2,0,'C');
	$pdf->Cell(46);
 	$pdf->Cell(5,5,$saldosalida,0,'C');	

	$pdf->Ln(5);
	$pdf->Cell(15);
//	$pdf->Cell( 30, 15, $pdf->Image($imagen, $pdf->GetX()+5, $pdf->GetY()+3, 20), 1, 0, 'C', false );
	$pdf->Cell(160, 0, '', 1, 1, 0, 'C', false );
	$pdf->Ln(3);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Neto',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(15);
 	$pdf->Cell(10,5,$saldo_bruto,0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(10,5,$saldo_tara,0,'C');
	$pdf->Cell(41);
 	$pdf->Cell(10,5,$saldosaldo,0,'C');
	$pdf->Ln(10);
	$pdf->Cell(10);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Sin Humedad',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(10,5,$peso_sin_humedad.' Kg',0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(10,5,$peso_sin_humedad2.' Kg',0,'C');
	$pdf->Cell(41);
 	$pdf->Cell(10,5,$saldo_humedadtotal.' Kg',0,'C');
// DESACTIVAR PARA MOSTRAR LOS INDICADORES
	
// PARA MOSTRAR LAS COPIAS	
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
	$pdf->Rect(5,5,200,130);
	$pdf->SetY(120);
	$pdf->Ln(-1);
	$pdf->Cell(155); 
	$pdf->Cell(40,0,'PAGINA:   '.$pdf->PageNo().'/{nb}',0,0,'C');
	$pdf->Ln(155);
		
	
$pdf->Output();
?>
<?PHP
mysql_close($con);
?>