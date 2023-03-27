<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
$id_empresa= $_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece                        
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
//$id_despacho_buscar="DESPACH-002";
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
	$contador1=$row_contador['cierre_lote'];
	}

	$result=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_despacho_buscar' group by id_lote");
 	while($row = mysql_fetch_array($result)){
	$id_cliente=$row['id_cliente'];
	$id_lote = $row['id_lote'];
	$observaciones=$row['comentario_cierre'];
//	}
	$result88=mysql_query("SELECT * FROM tab_salida WHERE id_cliente='$id_cliente' and id_lote='$id_lote'");
	while($row88 = mysql_fetch_array($result88)){
	$id_silo=$row88['id_silo'];
	}
	
	$sql_entrada = mysql_query("SELECT sum(peso_bruto) as peso_bruto, sum(peso_tara) as peso_tara, round(sum(neto_sin_humedad),2) as neto_sin_humedad, fecha_entrada FROM tab_almacenaje  WHERE id_lote='$id_lote'  and id_empresa='$id_empresa'");
					
						while ($row_entrada = mysql_fetch_array($sql_entrada)) 
                            {	
							$fecha_entrada1=parseDatePhp($row_entrada['fecha_entrada']);	
							$peso_bruto1=$row_entrada['peso_bruto'];
							$peso_tara1=$row_entrada['peso_tara'];	
							$peso_neto1=$peso_bruto1-$peso_tara1;						
							$peso_seco_entrada1=$row_entrada['neto_sin_humedad'];
							}
							
$sql_salida = mysql_query("SELECT sum(peso_bruto) as peso_brutos, sum(peso_tara) as peso_taras, round(sum(peso_sin_humedad),2) as neto_sin_humedads, fecha_entrada FROM tab_salida  WHERE id_lote='$id_lote'  and id_empresa='$id_empresa'");
					
						while ($row_salida = mysql_fetch_array($sql_salida)) 
                            {	
							$fecha_entrada1=parseDatePhp($row_salida['fecha_entrada']);	
							$peso_bruto2=$row_salida['peso_brutos'];
							$peso_tara2=$row_salida['peso_taras'];	
							$peso_neto2=$peso_bruto2-$peso_tara2;						
							$peso_seco_entrada2=$row_salida['neto_sin_humedads'];
							}							
 

	
	
	
	$result1=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='$id_cliente'"); // NOMBRE DEL CLIENTE
	while($row_cliente=mysql_fetch_array($result1)){
		$nom_cliente1=utf8_decode($row_cliente['nom_cliente']);
		}
		
	$result2=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote'"); // NUMERO DEL LOTE
	while($row2=mysql_fetch_array($result2)){
		$num_lote1=$row2['num_lote'];
		$id_producto=$row2['id_producto'];
		$id_subproducto=$row2['id_subproducto'];
		$id_origen=$row2['id_origen'];
		}
	
	$result3=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto'"); // producto
	while($row3=mysql_fetch_array($result3)){
		$nom_producto1=utf8_decode($row3['nom_producto']);
		$nom_productor=$row3['nom_productor'];		
		}

		
	$result6=mysql_query("SELECT * FROM tab_origen WHERE id_origen='$id_origen'"); // piloto
	while($row6=mysql_fetch_array($result6)){
		$nom_origen=utf8_decode($row6['nom_origen']);
		}
		
	$result7=mysql_query("SELECT * FROM tab_silo WHERE id_silo='$id_silo'"); // piloto
	while($row7=mysql_fetch_array($result7)){
		$nom_silo1=utf8_decode($row7['nom_silo']);
		}
	$result8=mysql_query("SELECT * FROM t_usuarios WHERE id_usuario='$usuario_busca'"); // piloto
	while($row8=mysql_fetch_array($result8)){
		$nombre_usuario=$row8['nombre_usuario'];		
		}						
}
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
	$pdf->Cell(40,5,'COMPROBANTE DE CIERRE DE LOTES',0,0,'C');
	
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
 	$pdf->MultiCell(80,5,utf8_decode($nom_cliente1));
	$pdf->Cell(17);
	$pdf->SetFont('Arial','',11);	
	$pdf->Cell(10,5,'Origen:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->MultiCell(80,5,utf8_decode($nom_origen));
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Producto:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_producto1),0,0,'J');
//	$pdf->Ln(5);
//	$pdf->SetFont('Arial','',11);
//	$pdf->Cell(17);
//    $pdf->Cell(10,5,'Subproducto:',0,0,'J',0); 
//	$pdf->SetFont('Arial','',10);
//	$pdf->Cell(22);
// 	$pdf->Cell(1,5,utf8_decode($nom_subproducto1),0,0,'J');
//	$pdf->Ln(5);
//	$pdf->SetFont('Arial','',11);
//	$pdf->Cell(17);
//    $pdf->Cell(10,5,'Productor:',0,0,'J',0); 
//	$pdf->SetFont('Arial','',10);
//	$pdf->Cell(22);
 //	$pdf->Cell(1,5,utf8_decode($nom_productor),0,0,'J');	
//	$pdf->Ln(5);
//	$pdf->SetFont('Arial','',11);
//	$pdf->Cell(17);
//    $pdf->Cell(10,5,'Piloto:',0,0,'J',0); 
//	$pdf->SetFont('Arial','',10);
//	$pdf->Cell(22);
 //	$pdf->Cell(1,5,$piloto1."           ".$placa1,0,0,'J');
//	$pdf->Ln(5);	
//	$pdf->SetFont('Arial','',12);
//	$pdf->Cell(17);
//    $pdf->Cell(10,5,'Destino:',0,0,'J',0); 
//	$pdf->SetFont('Arial','',10);
//	$pdf->Cell(22);
//	$pdf->MultiCell(140,5,$destino1);
	$pdf->Ln(5);	
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Observaciones:',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->MultiCell(140,5,($observaciones),0,'J');
	//$pdf->SetFont('Arial','',11);
	//$pdf->Cell(17);
    //$pdf->Cell(10,5,'Operador:',0,0,'J',0); 
	//$pdf->SetFont('Arial','',10);
	//$pdf->Cell(22);
	//$pdf->MultiCell(80,5,utf8_decode($nombre_usuario));	
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
	$pdf->Ln(8);	
	$pdf->SetFont('Arial','B',11);
	$pdf->Cell(38);
    $pdf->Cell(10,5,'ENTRADA',0,0,'J',0); 
	$pdf->Cell(38);
    $pdf->Cell(10,5,'SALIDA',0,0,'J',0);
	$pdf->Cell(40);
    $pdf->Cell(10,5,'SALDO',0,0,'J',0);	 	
	$pdf->Ln(4);
	$pdf->Cell(15);
    $pdf->Cell(10,5,'Bruto',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(10,5,$peso_bruto1,0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(5,5,$peso_bruto2,0,'C');
	$pdf->Cell(46);
 	$pdf->Cell(5,5,$peso_bruto1-$peso_bruto2,0,'C');	
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',10);	
 //	$pdf->Cell(5,5,'Salida',0,'C');
	$pdf->Ln(4);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Tara',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(10,5,$peso_tara1,0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(5,5,$peso_tara2,0,'C');
	$pdf->Cell(46);
 	$pdf->Cell(5,5,$peso_tara1-$peso_tara2,0,'C');	

	$pdf->Ln(5);
	$pdf->Cell(15);
//	$pdf->Cell( 30, 15, $pdf->Image($imagen, $pdf->GetX()+5, $pdf->GetY()+3, 20), 1, 0, 'C', false );
	$pdf->Cell(160, 0, '', 1, 1, 0, 'C', false );
	$pdf->Ln(3);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Neto',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(10,5,$peso_neto1,0,'C');
	$pdf->Cell(30);
 	$pdf->Cell(10,5,$peso_neto2,0,'C');
	$pdf->Cell(41);
 	$pdf->Cell(10,5,$peso_neto1-$peso_neto2,0,'C');
	$pdf->Ln(5);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',11);	
    $pdf->Cell(10,5,'Sin Humedad',0,0,'J',0); 
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(22);
 	$pdf->Cell(10,5,$peso_seco_entrada1.' Kg',0,'C');
		$pdf->Cell(30);
 	$pdf->Cell(10,5,$peso_seco_entrada2.' Kg',0,'C');
	$pdf->Cell(41);
 	$pdf->Cell(10,5,$peso_seco_entrada1 - $peso_seco_entrada2.' Kg',0,'C');
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