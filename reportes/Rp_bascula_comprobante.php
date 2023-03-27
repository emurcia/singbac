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
//$id_despacho_buscar="ALMACEN-003";
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
$pdf = new FPDF('P', 'mm', array(205,216 ));
$pdf->AliasNbPages();
$pdf->AddPage('P', 'Letter');

// cuerpo del reporte

$pdf->SetFont('Arial','B',8);
// BUSCA EL NUMERO DE TRANSACCION...
$cont=mysql_query("SELECT * FROM tab_contador WHERE codigo='1'");
  while($row_contador = mysql_fetch_array($cont)){
	$contador1=number_format($row_contador['total'],0,".",",");
	}
$result=mysql_query("SELECT * FROM tab_bascula WHERE id_bascula='$id_despacho_buscar'");
  
	while($row = mysql_fetch_array($result)){
	$id_cliente=$row['id_cliente'];
	$entrada=number_format($row['entrada'],0,".",",");
	$id_transportista = $row['id_transportista'];	
	//$peso_bruto1=number_format($row['peso_bruto'],0,".",",");
	$fecha1=parseDatePhp($row['fecha_entrada']);
	$hora1=$row['hora_entrada'];	
	$id_producto=$row['id_producto'];
	$id_subproducto=$row['id_subproducto'];
	$observacion1=utf8_decode($row['observacion']);	
	$destino1=utf8_decode($row['destino']);
	$usuario_busca=$row['id_usuario2'];		

if($row['opcion_peso']==1){
	$peso_bruto1=number_format($row['peso_bruto'],0,".",",");
	$mensaje="PESO BRUTO";
	}
if($row['opcion_peso']==2){
	$peso_bruto1=number_format($row['peso_tara'],0,".",",");
	$mensaje="PESO TARA";
	}	
if($row['opcion_peso']==3){
	$peso_bruto1=number_format($row['peso_unico'],0,".",",");
	$mensaje="PESO UNICO";
	}		
	$result1=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='$id_cliente'"); // NOMBRE DEL CLIENTE
	while($row_cliente=mysql_fetch_array($result1)){
		$nom_cliente1=utf8_decode($row_cliente['nom_cliente']);
		}
		
	$result3=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto'"); // producto
	while($row3=mysql_fetch_array($result3)){
		$nom_producto1=utf8_decode($row3['nom_producto']);
		$nom_productor=$row3['nom_productor'];		
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
$result8=mysql_query("SELECT * FROM t_usuarios WHERE id_usuario='$usuario_busca'"); // piloto
	while($row8=mysql_fetch_array($result8)){
		$nombre_usuario=$row8['nombre_usuario'];		
		}		
		
$pdf->Cell(1);
$pdf->Rect(5,5,200,130);
$pdf->SetFont('Times','',12);
//ENCABEZADO
$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");

    //Logo
	$pdf->Image('logo/logo.png',10,10);
//<img src="logo/logo.png" width="80" height="66" />
	 //TITULO DEL REPORTE
 	$pdf->Ln(5);	 
	$pdf->Cell(80);
    $pdf->SetFont('Arial','B',15);
	$pdf->Cell(40,5,'COMPROBANTE DE SERVICIO DE BASCULA',0,0,'C');
	
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
    $pdf->Ln(7);
	 //Movernos a la derecha
    $pdf->Cell(50);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(40,5,utf8_decode('Número de Control'),0,0,'C');
    $pdf->SetFont('Arial','',10);
	$pdf->Cell(23,5,$contador1,0,0);
	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(0);
	$pdf->Cell(50);
	$pdf->Cell(0,5,utf8_decode('N° de Entrada'),0,0,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(-55);
	$pdf->Cell(1,5,$entrada,0,0);
	$pdf->Ln(5);
	$pdf->Cell(35);
	$pdf->Ln(3);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Cliente:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->MultiCell(80,5,utf8_decode($nom_cliente1));
	$pdf->Cell(17);
	$pdf->SetFont('Arial','',12);
    $pdf->Cell(10,5,'Producto:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_producto1),0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Subproducto:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_subproducto1),0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Productor:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_productor),0,0,'J');	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Piloto:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($piloto1)."           ".($placa1),0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Destino:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
	$pdf->MultiCell(140,5,$destino1);
	$pdf->Ln(0);	
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Observaciones:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->MultiCell(140,5,$observacion1);
	$pdf->SetFont('Arial','',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Operador:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
//	$pdf->MultiCell(80,5,utf8_decode($nombre_usuario));		
 	$pdf->MultiCell(80,5,utf8_decode($_SESSION['nombre_usuario_silo']));
	$pdf->Ln(5);	
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(40);
    $pdf->Cell(10,5,'Peso Kg',0,0,'J',0); 
	$pdf->Cell(40);
    $pdf->Cell(10,5,'Fecha',0,0,'J',0);
	$pdf->Cell(40);
    $pdf->Cell(10,5,'Hora',0,0,'J',0);	 	
	$pdf->Ln(6);
	$pdf->Cell(15);
    $pdf->Cell(10,5,'Pesaje',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(10,5,$peso_bruto1,0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(5,5,$fecha1,0,'C');
	$pdf->Cell(46);
 	$pdf->Cell(5,5,$hora1,0,'C');	
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',10);	
 	$pdf->Cell(5,5,$mensaje,0,'C');		
	
	
	
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
//	$pdf->Ln(155);
		
	}


$pdf->Output();
?>
