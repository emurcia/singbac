<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa= $_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece                        
  $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
//$id_despacho_buscar="DESPACH-002";
 $id_ajuste_buscar=$_GET['id'];

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
	$contador1=$row_contador['num_ajuste'];
	}
	
	
$tabla_extrae="SELECT a.*, l.num_lote, c.nom_cliente, s.nom_silo, pro.nom_producto, (case when pro.humedad='0' then 'PRODUCTO NO APLICA HUMEDAD' else 'PRODUCTO APLICA HUMEDAD' end) as nota_humedad FROM tab_ajuste as a, tab_lote as l, tab_cliente as c, tab_silo as s, tab_producto as pro, tab_subproducto as spro WHERE a.id_ajuste='$id_ajuste_buscar' and a.id_empresa='$id_empresa' and a.id_cliente=c.id_cliente and a.id_silo=s.id_silo and a.id_lote=l.id_lote and l.id_producto=pro.id_producto GROUP BY a.id_lote ";
$select_extrae = mysql_query($tabla_extrae,$con);
while($row_extrae = mysql_fetch_array($select_extrae))
{
			 $usuario_autoriza=$row_extrae['id_usuario2_ajuste'];
			 $id_lote_contar=$row_extrae['id_lote'];
			 $nom_cliente=$row_extrae['nom_cliente'];
			 $num_lote=$row_extrae['num_lote'];
			 $nom_silo=$row_extrae['nom_silo'];
			 $nom_producto=$row_extrae['nom_producto'];
			 $nota=$row_extrae['nota_humedad'];
			 $observaciones=$row_extrae['comentario_ajuste'];
			 $peso_bruto_entrada=number_format($row_extrae['peso_bruto_entrada'],2,".",",");
			 $peso_tara_entrada=number_format($row_extrae['peso_tara_entrada'],2,".",",");
			 $peso_saldo_entrada=number_format($row_extrae['peso_bruto_entrada']-$row_extrae['peso_tara_entrada'],2,".",",");
			 $peso_humedad_entrada=number_format($row_extrae['peso_humedad_entrada'],2,".",",");
			 $peso_bruto_salida=number_format($row_extrae['peso_bruto_salida'],2,".",",");
			 $peso_tara_salida=number_format($row_extrae['peso_tara_salida'],2,".",",");
			 $peso_saldo_salida=number_format($row_extrae['peso_bruto_salida']-$row_extrae['peso_tara_salida'],2,".",",");
			 $peso_humedad_salida=number_format($row_extrae['peso_humedad_salida'],2,".",",");
			 $peso_bruto_saldo=number_format($row_extrae['peso_bruto_entrada']-$row_extrae['peso_bruto_salida'],2,".",",");
			 $peso_tara_saldo=number_format($row_extrae['peso_tara_entrada']-$row_extrae['peso_tara_salida'],2,".",",");
			 $peso_neto_saldo=number_format(($row_extrae['peso_bruto_entrada']-$row_extrae['peso_tara_entrada'])-($row_extrae['peso_bruto_salida']-$row_extrae['peso_tara_salida']),2,".",",");
			 $peso_humedad_saldo=number_format($row_extrae['peso_humedad_entrada']-$row_extrae['peso_humedad_salida'],2,".",",");
			 $peso_bruto_ajuste=number_format($row_extrae['nuevo_peso_bruto'],2,".",",");
			 $peso_tara_ajuste=number_format($row_extrae['nuevo_peso_tara'],2,".",",");
			 $peso_neto_ajuste=number_format($row_extrae['nuevo_peso_bruto']-$row_extrae['nuevo_peso_tara'],2,".",",");
			 $peso_humedad_ajuste=number_format($row_extrae['nuevo_peso_humedad'],2,".",",");
			 $peso_bruto_nuevo=number_format(($row_extrae['peso_bruto_entrada']-$row_extrae['peso_bruto_salida']+$row_extrae['nuevo_peso_bruto']),2,".",",");
			 $peso_tara_nuevo=number_format(($row_extrae['peso_tara_entrada']-$row_extrae['peso_tara_salida']+$row_extrae['nuevo_peso_tara']),2,".",",");
			 $peso_neto_nuevo=number_format((($row_extrae['peso_bruto_entrada']-$row_extrae['peso_tara_entrada'])-($row_extrae['peso_bruto_salida']-$row_extrae['peso_tara_salida'])+($row_extrae['nuevo_peso_bruto']-$row_extrae['nuevo_peso_tara'])),2,".",",");
			 $peso_humedad_nuevo=number_format((($row_extrae['peso_humedad_entrada']-$row_extrae['peso_humedad_salida'])+$row_extrae['nuevo_peso_humedad']),2,".",",");
}

$contar_ajustes=mysql_query("select COUNT(id_ajuste) as contador from tab_ajuste WHERE id_lote='$id_lote_contar'",$con);
$fila_ajuste = mysql_fetch_array($contar_ajustes, MYSQL_ASSOC);
$num_ajuste=$fila_ajuste['contador'];

$loginSQL=mysql_query("select nombre_usuario from t_usuarios  where id_usuario='$id_usuario'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$usuario_elabora=$fila_usu['nombre_usuario'];

$loginSQL2=mysql_query("select nombre_usuario from t_usuarios  where id_usuario='$usuario_autoriza'",$con);
$fila_usu2 = mysql_fetch_array($loginSQL2, MYSQL_ASSOC);
$usuario_autoriza=$fila_usu2['nombre_usuario'];

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
	$pdf->Cell(40,5,'COMPROBANTE DE AJUSTE DE INVENTARIO',0,0,'C');
	
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
    $pdf->Ln(5);
	 //Movernos a la derecha
    $pdf->Cell(-10);
	$pdf->Cell(0,5,utf8_decode('N° de Entrada'),0,0,'C');
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(-80);
	$pdf->Cell(1,5,$contador1,0,0);
	//$pdf->Cell(1,5,$entrada,0,0);

    $pdf->Ln(6);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Cliente:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->MultiCell(80,5,utf8_decode($nom_cliente));
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Producto:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_producto),0,0,'J');
	$pdf->Ln(5);
	$pdf->Cell(17);
	$pdf->SetFont('Arial','',11);	
	$pdf->Cell(10,5,'Nota:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(80,5,utf8_decode($nota));
	$pdf->Ln(5);	
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Observaciones:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->MultiCell(140,5,($observaciones),0,'J');
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,utf8_decode('Ubicación:'),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->cell(80,5,utf8_decode($nom_silo));
	$pdf->Cell(-25);
    $pdf->Cell(10,5,utf8_decode('N° de Lote:'),0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->cell(80,5,utf8_decode($num_lote));
	$pdf->Ln(8);	
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(38);
    $pdf->Cell(10,5,'PESO BRUTO',0,0,'J',0); 
	$pdf->Cell(28);
    $pdf->Cell(10,5,'PESO TARA',0,0,'J',0);
	$pdf->Cell(20);
    $pdf->Cell(10,5,'PESO NETO',0,0,'J',0);
	$pdf->Cell(20);
    $pdf->Cell(10,5,'PESO SIN HUMEDAD',0,0,'J',0);	 	
	$pdf->Ln(5);
	$pdf->Cell(10);
    $pdf->Cell(10,5,'Entrada',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(10,5,$peso_bruto_entrada,0,'C');
	$pdf->Cell(28);
 	$pdf->Cell(5,5,$peso_tara_entrada,0,'C');
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_saldo_entrada,0,'C');	
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_humedad_entrada,0,'C');	
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Ln(5);
	$pdf->Cell(10);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Salida',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(10,5,$peso_bruto_salida,0,'C');
	$pdf->Cell(28);
 	$pdf->Cell(5,5,$peso_tara_salida,0,'C');
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_saldo_salida,0,'C');	
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_humedad_salida,0,'C');	
	
	$pdf->Ln(5);
	$pdf->Cell(10);
	$pdf->Cell(160, 0, '', 1, 1, 0, 'C', false );
	$pdf->Ln(1);
	$pdf->Cell(10);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Saldo',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(10,5,$peso_bruto_saldo,0,'C');
	$pdf->Cell(28);
 	$pdf->Cell(5,5,$peso_tara_saldo,0,'C');
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_neto_saldo,0,'C');	
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_humedad_saldo,0,'C');	
	$pdf->Ln(5);
	$pdf->Cell(10);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Ajuste ('.$num_ajuste.')' ,0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(10,5,$peso_bruto_ajuste,0,'C');
	$pdf->Cell(28);
 	$pdf->Cell(5,5,$peso_tara_ajuste,0,'C');
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_neto_ajuste,0,'C');	
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_humedad_ajuste,0,'C');
	
	
	$pdf->Ln(5);
	$pdf->Cell(10);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Nuevo saldo',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(18);
 	$pdf->Cell(10,5,$peso_bruto_nuevo,0,'C');
	$pdf->Cell(28);
 	$pdf->Cell(5,5,$peso_tara_nuevo,0,'C');
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_neto_nuevo,0,'C');	
	$pdf->Cell(25);
 	$pdf->Cell(5,5,$peso_humedad_nuevo,0,'C');
	
// DESACTIVAR PARA MOSTRAR LOS INDICADORES
	
// PARA MOSTRAR LAS COPIAS	
	$pdf->Ln(12);
	$pdf->Cell(10);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(10,6,'Elaborado por:');
	$pdf->Cell(18);
 	$pdf->Cell(10,6,$usuario_elabora,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(10);
	$pdf->Cell(10,6,utf8_decode('Autorizado por:'));
	$pdf->Cell(18);
 	$pdf->Cell(10,6,$usuario_autoriza,0,'C');

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