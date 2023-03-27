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
$lote_busca= $_GET['id4'];

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
$seleccion1= $_GET['id'];
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
	$this->Cell(40,5,'DESPACHO DE GRANOS BASICOS POR LOTE',0,0,'C');
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
	$this->Ln(8);
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
 
$pdf->AliasNbPages();
$pdf->AddPage();

	
// MOSTRAR POR PRODUCTOS
$suma_total=0;
$transacciones=0;
$salida_lote_neto=0;
$salida_lote_tara=0;
$acumulado_salida_lote=0;
$entrada_lote_neto=0;
$entrada_lote_tara=0;
$acumulado_entrada_lote=0;

$result=mysql_query("SELECT a.*, b.*, c.* FROM tab_salida as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$seleccion1' and a.id_lote='$lote_busca' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') group by a.id_lote");
 while($row_datos = mysql_fetch_array($result)){
	 $id_lote1=$row_datos['id_lote'];
	 
	$lote=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote1'");
  while($row_lote = mysql_fetch_array($lote)){
	  $num_lote1=$row_lote['num_lote'];
	  $id_lote2=$row_lote['id_lote'];
	  $capacidad_lote=$row_lote['cant_producto'];
      $id_producto1=$row_lote['id_producto'];
	 $id_subproducto1=$row_lote['id_subproducto'];
	
	
$producto=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto1'");
  while($row_producto = mysql_fetch_array($producto)){
	$nom_producto1=$row_producto['nom_producto'];	
	
		$subproducto=mysql_query("SELECT * FROM tab_subproducto WHERE id_subproducto='$id_subproducto1'");
		 while($row_subproducto = mysql_fetch_array($subproducto)){
		$nom_subproducto1=$row_subproducto['nom_subproducto'];	

$bascula=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='".$seleccion1."'");
  	while($row_bascula = mysql_fetch_array($bascula)){
	$nom_cliente1=$row_bascula['nom_cliente'];
	
	}
	
$pdf->SetFont('Arial','B',8);
// BUSCA EL NUMERO DE TRANSACCION...

	$pdf->Ln(-1);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Cliente:',0,0,'J',0); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22);
 	$pdf->MultiCell(80,5,utf8_decode($nom_cliente1));		
	
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Lote:',0,0,'J',0); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($num_lote1),0,0,'J');
	$pdf->Ln(4);		
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Producto:',0,0,'J',0); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_producto1),0,0,'J');
	$pdf->Ln(4);
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
	$pdf->Ln(6);	
	$pdf->Cell(1);
	$pdf->Cell(190, 0, '', 1, 1, 0, 'C', false );

// extrae los datos de la tabla para mostrarlos en el espacio de la tabla	
	$contador=0;
	$suma_subtotal=0;



$reporte=mysql_query("SELECT a.*, b.*, c.* FROM tab_salida as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_cliente=c.id_cliente and a.id_cliente='$seleccion1' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada<= '$fecha_fin_buscar') and c.id_subproducto='$id_subproducto1' and c.id_producto='$id_producto1' and a.id_lote='$lote_busca' and a.bandera=2 group by c.id_subproducto, c.id_producto,  a.entrada",$con);	
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
    $pdf->Cell(5,4,number_format($entrada1,0,".",","));
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
    $pdf->Cell(5,$alto,number_format($peso_neto1,0,".",","),0,0,'C');
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
	$pdf->Cell(5,5,number_format($suma_subtotal,0,".",",")."  Kg");
	$pdf->Ln(5);
	$pdf->Cell(104);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(4);
	$transacciones=	$transacciones+$contador;
	
	
} // fin de sub subproducto
    //EXTRAER LA SUMA DE LA CANTIDAD DESPACHADA EN EL SILO


  }//fin de producto
  

  } // fin del lote
  
  

  
} //FIN DE LA CONSULTA PRINCIPAL

//TOTALIZANDO EL INGRESO DE PRODUCTOS POR LOTE
$suma_lote2=mysql_query("SELECT a.*, b.*, c.* FROM tab_almacenaje as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_cliente=c.id_cliente and a.id_cliente='$seleccion1' and c.id_subproducto='$id_subproducto1' and c.id_producto='$id_producto1' and a.id_lote='$lote_busca' and a.bandera=2 and a.tipo_peso=2 group by c.id_subproducto, c.id_producto, a.entrada",$con); 
 while($row_suma_lote2 = mysql_fetch_array($suma_lote2)){
		$entrada_lote_neto=$entrada_lote_neto+$row_suma_lote2['peso_bruto'];
		$entrada_lote_tara=$entrada_lote_tara+$row_suma_lote2['peso_tara'];
		$entrada_lote_humedad=$entrada_lote_humedad+$row_suma_lote2['neto_sin_humedad'];
 	 }	

$suma_lote=mysql_query("SELECT a.*, b.*, c.* FROM tab_salida as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_cliente=c.id_cliente and a.id_cliente='$seleccion1' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada<= '$fecha_fin_buscar') and c.id_subproducto='$id_subproducto1' and c.id_producto='$id_producto1' and a.id_lote='$lote_busca' and a.bandera=2 group by c.id_subproducto, c.id_producto, a.entrada",$con); 
 while($row_suma_lote = mysql_fetch_array($suma_lote)){
		$salida_lote_neto=$salida_lote_neto+$row_suma_lote['peso_bruto'];
		$salida_lote_tara=$salida_lote_tara+$row_suma_lote['peso_tara'];
 	 }	
	 
$acumulado_salida_lote=$salida_lote_neto-$salida_lote_tara;
$acumulado_entrada_lote=$entrada_lote_neto-$entrada_lote_tara;
$diferencia=$acumulado_entrada_lote-$acumulado_salida_lote;
$diferencia_sin_humedad=$entrada_lote_humedad-$acumulado_salida_lote;
$perdida_humedad=$acumulado_entrada_lote-$entrada_lote_humedad;

	$pdf->Cell(27);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Transacciones'));
	$pdf->Cell(25);	
	$pdf->Cell(5,5,utf8_decode($transacciones));
	$pdf->Cell(20);	
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Total'));
	$pdf->Cell(16);	
	$pdf->Cell(5,5,number_format($suma_total,0,".",",")."  Kg");
	
	$pdf->Ln(5);
	$pdf->Cell(104);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(1);
	$pdf->Cell(104);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(5);
	//$pdf->Cell(15);
	//$pdf->SetFont('Arial','B',10);	
	//$pdf->Cell(5,5,('Capacidad del Lote'));
	$pdf->Cell(70);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,('Total Ingresos'));
	$pdf->Cell(25);	
	$pdf->Cell(5,5,('Total Egresos'));
	$pdf->Cell(25);	
	$pdf->Cell(5,5,('Existencia'));
	$pdf->Ln(5);
	$pdf->Cell(15);	
	$pdf->Cell(5,5,'Inventario con humedad');
	$pdf->Cell(50);
	$pdf->Cell(5,5,number_format($acumulado_entrada_lote,2,".",","));
	$pdf->Cell(27);
	$pdf->Cell(5,5,number_format($acumulado_salida_lote,2,".",","));
	$pdf->Cell(23);
	$pdf->Cell(5,5,number_format($diferencia,2,".",","));
	
	$pdf->Ln(5);
	$pdf->Cell(15);	
	$pdf->Cell(5,5,'Inventario sin humedad');
	$pdf->Cell(50);
	$pdf->Cell(5,5,number_format($entrada_lote_humedad,2,".",","));
	$pdf->Cell(27);
	$pdf->Cell(5,5,number_format($acumulado_salida_lote,2,".",","));
	$pdf->Cell(23);
	$pdf->Cell(5,5,number_format($diferencia_sin_humedad,2,".",","));
	$pdf->Ln(5);
	$pdf->Cell(15);	
	$pdf->Cell(5,5,'Perdida de humedad');
	$pdf->Cell(50);
	$pdf->Cell(5,5,number_format($perdida_humedad,2,".",","));
	
	$pdf->Output();
	
?>
