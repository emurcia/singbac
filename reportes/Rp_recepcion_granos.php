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

//$fecha_inicio_buscar= '2017/03/27';
//$fecha_fin_buscar= '2017/03/29';
//$seleccion1= 'CLI-002';
$seleccion1= $_GET['id'];
$fecha_inicio_buscar= parseDateMysql($_GET['id2']);
$fecha_fin_buscar= parseDateMysql($_GET['id3']);

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
class PDF extends FPDF
{
  //Cabecera de página
    function Header()
    {
$cont=mysql_query("SELECT * FROM tab_contador WHERE codigo='1'");
  while($row_contador = mysql_fetch_array($cont)){
	$contador1=$row_contador['total'];
	$servicio_bascula1=$row_contador['servicio_bascula'];
	}		
$fecha_inicio_buscar1= ($_GET['id2']);
$fecha_fin_buscar1= ($_GET['id3']);     

$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");
	$this->Cell(1);
	$this->Rect(5,5,200,268);
    //Logo
	$this->Image('logo/logo.png',10,10);
	 //TITULO DEL REPORTE
 	$this->Ln(6);	 
	$this->Cell(86);
    $this->SetFont('Arial','B',15);
	$this->Cell(40,5,'RECEPCION DE GRANOS BASICOS POR CLIENTE',0,0,'C');
	$this->Ln(6);
	$this->Cell(80);	
	$this->SetFont('Arial','',11);
	$this->Cell(40,5,'Periodo del  '.$fecha_inicio_buscar1.' al ' .$fecha_fin_buscar1,0,0,'C');	
	
	//Salto de línea
    $this->Ln(5);
	 //Movernos a la derecha
    $this->Cell(130);
	$this->SetFont('Arial','',10);
	$this->Cell(40,5,'FECHA DE IMPRESION:',0,0,'C');
    $this->SetFont('Arial','',10);
	$this->Cell(20,5,$fecha_entrada,0,0,'C');
    $this->Ln(5);	
	$this->Cell(130);
	$this->SetFont('Arial','',10);
	$this->Cell(39,5,'HORA DE IMPRESION:',0,0,'C');
    $this->SetFont('Arial','',10);
	$this->Cell(20,5,$hora,0,0,'C');
    }

    //Pie de página
    function Footer()
    {
      
      //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Arial','I',10);
        //Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
      
    }

function __construct()
    {       
        //Llama al constructor de su clase Padre.
        //Modificar aka segun la forma del papel del reporte
        parent::__construct('P','mm','Letter');
    }
   
}

ob_end_clean();
$pdf=new PDF ();
//$pdf->SetTopMargin(5.4);
//$pdf->SetLeftMargin(4.5); 
$pdf->AliasNbPages();
$pdf->AddPage();
// CONSULTAR EL NUMERO DE TRANSACCIONES
$cont=mysql_query("SELECT * FROM tab_contador WHERE codigo='1'");
  while($row_contador = mysql_fetch_array($cont)){
	$contador1=$row_contador['total'];
	$servicio_bascula1=$row_contador['servicio_bascula'];
	}	
$bascula=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='$seleccion1'");
  while($row_bascula = mysql_fetch_array($bascula)){
	$nom_cliente1=$row_bascula['nom_cliente'];
	
	}
	

// cuerpo del reporte
//$pdf->SetFillColor(238,197,32);

$pdf->SetFont('Arial','B',8);
// BUSCA EL NUMERO DE TRANSACCION...

	$pdf->Ln(9);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Cliente:',0,0,'J',0); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22);
 	$pdf->MultiCell(100,5,utf8_decode($nom_cliente1));
	
// MOSTRAR POR PRODUCTOS
$suma_total=0;
$transacciones=0;
$result=mysql_query("SELECT a.*, b.* FROM tab_almacenaje as a, tab_cliente as b WHERE a.id_cliente=b.id_cliente and a.id_cliente='$seleccion1' and a.peso_bruto!=0 and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.tipo_peso=2 group by a.id_lote");
 while($row_datos = mysql_fetch_array($result)){
	 $id_lote1=$row_datos['id_lote'];
	 
	$lote=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote1'");
  while($row_lote = mysql_fetch_array($lote)){
	  $num_lote1=$row_lote['num_lote'];
	  $id_lote2=$row_lote['id_lote'];
//	$nom_producto1=$row_producto['nom_producto'];
	 
//	$id_cliente=$row['id_cliente'];
    $id_producto1=$row_lote['id_producto'];
	$id_subproducto1=$row_lote['id_subproducto'];
	
	
$producto=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto1'");
  while($row_producto = mysql_fetch_array($producto)){
	$nom_producto1=$row_producto['nom_producto'];	
	
		$subproducto=mysql_query("SELECT * FROM tab_subproducto WHERE id_subproducto='$id_subproducto1'");
		 while($row_subproducto = mysql_fetch_array($subproducto)){
		$nom_subproducto1=$row_subproducto['nom_subproducto'];	
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Lote:',0,0,'J',0); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($num_lote1),0,0,'J');
	$pdf->Ln(5);		
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Producto:',0,0,'J',0); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_producto1),0,0,'J');
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Subproducto:',0,0,'J',0); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_subproducto1),0,0,'J');

// ENCABEZADO DE TABLA
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(3);
    $pdf->Cell(183,5,utf8_decode('N°')."      ".utf8_decode('Control')."         ".utf8_decode('Placas')."                       ".utf8_decode('Chofer')."                       ".utf8_decode('Neto')."         ".utf8_decode('Fecha ')."           ".utf8_decode('Hora')."         ".utf8_decode('Fecha ')."       ".utf8_decode('Hora'),0,0,'C',0);
	$pdf->Ln(4);
	$pdf->Cell(60);	
	$pdf->Cell(1,5,utf8_decode('  ')."         ".utf8_decode('       ')."      ".utf8_decode('    ')."      ".utf8_decode('    ')."      ".utf8_decode(' kg')."         ".utf8_decode('Entrada ')."        ".utf8_decode('Entrada')."      ".utf8_decode('Salida ')."      ".utf8_decode('Salida'),0,0,'J',0);
	$pdf->Ln(7);	
	$pdf->Cell(1);
	$pdf->Cell(190, 0, '', 1, 1, 0, 'C', false );

// extrae los datos de la tabla para mostrarlos en el espacio de la tabla	
	$contador=0;
	$suma_subtotal=0;



$reporte=mysql_query("SELECT a.*, b.*, c.* FROM tab_almacenaje as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_cliente=c.id_cliente and a.id_cliente='$seleccion1' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada<= '$fecha_fin_buscar') and c.id_subproducto='$id_subproducto1' and c.id_producto='$id_producto1' and a.id_lote='$id_lote2' and a.bandera='2' and a.tipo_peso=2 group by c.id_subproducto, c.id_producto, a.entrada, a.id_lote",$con);	
	 while($row_datos2 = mysql_fetch_array($reporte)){
		$id_transportista_con=$row_datos2['id_transportista'];
		$contador++;
		$entrada1=$row_datos2['entrada'];
		$peso_bruto1=$row_datos2['peso_bruto'];
		$peso_tara1=$row_datos2['peso_tara'];
		$peso_neto1=$peso_bruto1-$peso_tara1;
		$fecha1=parseDatePhp($row_datos2['fecha_entrada']);
		$hora1=$row_datos2['hora_entrada'];	
		$fecha2=parseDatePhp($row_datos2['fecha_salida']);
		$hora2=$row_datos2['hora_salida'];						
		$suma_subtotal=$suma_subtotal+$peso_neto1;
	  	$suma_total=$suma_total+$peso_neto1;
				
		$transportista=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_transportista_con'");
  		while($row_trans = mysql_fetch_array($transportista)){
		$nom_transportista1=$row_trans['nom_transportista']." ".$row_trans['ape_transportista'];	
		$placa1=$row_trans['placa_vehiculo'];
  		}
    //$id_producto2=$row_datos2['id_producto'];
	//$id_subproducto2=$row_datos2['id_subproducto'];
	$pdf->Ln(1);
	$pdf->Cell(1);
	$pdf->SetFont('Arial','',10);	
    $pdf->Cell(5,4,utf8_decode($contador));
	$pdf->Cell(7);
    $pdf->Cell(5,4,utf8_decode($entrada1));
	$pdf->Cell(9);
    $pdf->Cell(5,4,utf8_decode($placa1));
	$pdf->Cell(18);
	$x1 = $pdf->GetX();
    $pdf->Multicell(50,3,utf8_decode($nom_transportista1));	
	$y1 = $pdf->GetY();
	$posicionX = $x1 + 50; 
	$pdf->SetXY($posicionX,$y1);
	$y2 = $pdf->GetY();
	$alto = $y2-$y1-3;
	$pdf->Cell(5);
    $pdf->Cell(5,$alto,utf8_decode($peso_neto1),0,0,'C');
	$pdf->Cell(6);
    $pdf->Cell(5,$alto,utf8_decode($fecha1));
	$pdf->Cell(16);
    $pdf->Cell(5,$alto,utf8_decode($hora1));
	$pdf->Cell(12);
    $pdf->Cell(5,$alto,utf8_decode($fecha2));
	$pdf->Cell(15);
    $pdf->Cell(5,$alto,utf8_decode($hora2));
	$pdf->Ln(1);
   }
   	$pdf->Cell(104);
	$pdf->Cell(87, 0, '', 1, 1, 0, 'J', false );	
	$pdf->Ln(2);
   	$pdf->Cell(83);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Subtotal'));
	$pdf->Cell(16);	
	$pdf->Cell(5,5,utf8_decode($suma_subtotal)."  Kg");
	$pdf->Ln(5);
	$pdf->Cell(104);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(4);
	$transacciones=	$transacciones+$contador;
} // fin de sub subproducto

  }//fin de producto
  } // fin del lote
  
} //FIN DE LA CONSULTA PRINCIPAL
	$pdf->Cell(27);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Transacciones'));
	$pdf->Cell(25);	
	$pdf->Cell(5,5,utf8_decode($transacciones));
	$pdf->Cell(20);	
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Total'));
	$pdf->Cell(16);	
	$pdf->Cell(5,5,utf8_decode($suma_total)."  Kg");
	
	$pdf->Ln(5);
	$pdf->Cell(104);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(1);
	$pdf->Cell(104);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	
	$pdf->Output();
?>
