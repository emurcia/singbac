<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece                        
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $nom_sistema=$_SESSION['nom_sistema'];

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
$seleccion1= $_GET['id'];
$fecha_inicio_buscar= parseDateMysql($_GET['id2']);
$fecha_fin_buscar= parseDateMysql($_GET['id3']);


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
	
	$bascula=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='".$_GET['id']."'");
	while($row_bascula = mysql_fetch_array($bascula)){
	$nom_cliente1=$row_bascula['nom_cliente'];
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
	$this->Cell(40,5,'SERVICIO DE BASCULA DE CLIENTES POR PRODUCTOS',0,0,'C');
	$this->Ln(6);
	$this->Cell(80);	
	$this->SetFont('Arial','',11);
	$this->Cell(40,5,'Periodo del  '.$fecha_inicio_buscar1.' al ' .$fecha_fin_buscar1,0,0,'C');	
	
	//Salto de línea
    $this->Ln(4);
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
	$this->Ln(3);
	$this->Cell(35);
    $this->Cell(10,5,'Cliente:',0,0,'J',0); 
	$this->SetFont('Arial','B',10);
	$this->Cell(12);
 	$this->MultiCell(80,5,utf8_decode($nom_cliente1));
	
		
	// ENCABEZADO DE TABLA
	$this->Ln(3);
	$this->SetFont('Arial','B',10);
	$this->Cell(50);
    $this->Cell(150,5,utf8_decode('')."         ".utf8_decode('')."         ".utf8_decode('')."                   ".utf8_decode('')."             ".utf8_decode('Fecha')."          ".utf8_decode('Hora')."         ".utf8_decode('')."                  ".utf8_decode('Kilogramos')."         ".utf8_decode(''),0,0,'J',0);
	$this->Ln(4);
	$this->Cell(175,5,utf8_decode('N°')."     ".utf8_decode('Control')."     ".utf8_decode('Placas')."            ".utf8_decode('Subproducto')."                           ".utf8_decode('entrada')."      ".utf8_decode('entrada')."         ".utf8_decode('Bruto')."         ".utf8_decode('Tara')."         ".utf8_decode('Neto'),0,0,'J',0);
	$this->Ln(5);	
	$this->Cell(1);
	$this->Cell(190, 0, '', 1, 1, 0, 'C', false );
	
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
// CONSULTAR EL NUMERO DE TRANSACCIONES
$cont=mysql_query("SELECT * FROM tab_contador WHERE codigo='1'");
  while($row_contador = mysql_fetch_array($cont)){
	$contador1=$row_contador['total'];
	$servicio_bascula1=$row_contador['servicio_bascula'];
	}	

	

// MOSTRAR POR PRODUCTOS
$suma_total_bruto1=0;
$suma_total_tara1=0;
$suma_total_neto1=0;
$transacciones=0;
$result=mysql_query("SELECT a.*, b.* FROM tab_bascula as a, tab_cliente as b WHERE a.id_cliente=b.id_cliente and a.id_cliente='$seleccion1' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') group by id_producto");
 while($row_datos = mysql_fetch_array($result)){
//	$id_cliente=$row['id_cliente'];
    $id_producto1=$row_datos['id_producto'];

	
$producto=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto1'");
  while($row_producto = mysql_fetch_array($producto)){
//	$nom_producto1=$row_producto['nom_producto'];	
	
/*		
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Producto:',0,0,'J',0); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_producto1),0,0,'J');

*/

// extrae los datos de la tabla para mostrarlos en el espacio de la tabla	
	$contador=0;
	$suma_subtotal_bruto1=0;
	$suma_subtotal_tara1=0;
	$suma_subtotal_neto1=0;	

$reporte=mysql_query("SELECT a.*, b.* FROM tab_bascula as a, tab_cliente as b WHERE a.id_cliente=b.id_cliente and a.id_cliente='$seleccion1' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar')  and id_producto='$id_producto1'");	
	 while($row_datos2 = mysql_fetch_array($reporte)){
		$id_transportista_con=$row_datos2['id_transportista'];
		$id_subproducto1=$row_datos2['id_subproducto'];
		$contador++;
		$entrada1=number_format($row_datos2['entrada'],0,".",",");
		$peso_bruto1=number_format($row_datos2['peso_bruto'],0,".",",");
		$peso_tara1=number_format($row_datos2['peso_tara'],0,".",",");
		$peso_neto2=$row_datos2['peso_bruto']-$row_datos2['peso_tara'];
		$peso_neto1=number_format($peso_neto2,0,".",",");
		$fecha1=parseDatePhp($row_datos2['fecha_entrada']);
		$hora1=$row_datos2['hora_entrada'];	
		$fecha2=parseDatePhp($row_datos2['fecha_salida']);
		$hora2=$row_datos2['hora_salida'];
								
		$suma_subtotal_bruto1=$suma_subtotal_bruto1+$row_datos2['peso_bruto'];
		$suma_subtotal_tara1=$suma_subtotal_tara1+$row_datos2['peso_tara'];
		$suma_subtotal_neto1=$suma_subtotal_neto1+$peso_neto2;
	  	$suma_total_bruto1=$suma_total_bruto1+$row_datos2['peso_bruto'];
	  	$suma_total_tara1=$suma_total_tara1+$row_datos2['peso_tara'];
	  	$suma_total_neto1=$suma_total_neto1+$peso_neto2;	
			
		
		$transportista=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_transportista_con'");
  		while($row_trans = mysql_fetch_array($transportista)){
		$placa1=$row_trans['placa_vehiculo'];
  		}
		
		$subproducto=mysql_query("SELECT * FROM tab_subproducto WHERE id_subproducto='$id_subproducto1'");
		 while($row_subproducto = mysql_fetch_array($subproducto)){
		$nom_subproducto1=$row_subproducto['nom_subproducto'];	
		 }

	//$pdf->Ln(1);
	$pdf->Cell(1);
	$pdf->SetFont('Arial','',9);	
    $pdf->Cell(5,5,utf8_decode($contador));
	$pdf->Cell(8);
    $pdf->Cell(5,5,utf8_decode($entrada1));
	$pdf->Cell(5);
    $pdf->Cell(5,5,utf8_decode($placa1));	
	$pdf->Cell(17);

	$x1 = $pdf->GetX();	
    $pdf->Multicell(50,5,utf8_decode($nom_subproducto1));
	$y1 = $pdf->GetY();
	$posicionX = $x1 + 50; 
	$pdf->SetXY($posicionX,$y1);
	
	$y2 = $pdf->GetY();
	$alto = $y2-$y1-5;
	$pdf->Cell(2);
    $pdf->Cell(5,$alto,utf8_decode($fecha1));
	$pdf->Cell(15);
    $pdf->Cell(5,$alto,utf8_decode($hora1));
	$pdf->Cell(14);
    $pdf->Cell(5,$alto,utf8_decode($peso_bruto1));
	$pdf->Cell(15);
    $pdf->Cell(5,$alto,utf8_decode($peso_tara1));	
	$pdf->Cell(15);
    $pdf->Cell(5,$alto,utf8_decode($peso_neto1));	
 	$pdf->Ln(0);
	
   }
    $suma_subtotal_bruto=number_format($suma_subtotal_bruto1 ,0,".",",");
	$suma_subtotal_tara=number_format($suma_subtotal_tara1 ,0,".",",");	
	$suma_subtotal_neto=number_format($suma_subtotal_neto1 ,0,".",",");	
	
   	$pdf->Cell(110);
	$pdf->SetFont('Arial','B',9);	
	$pdf->Cell(5,5,utf8_decode('Subtotal (Kg)'));
	$pdf->Cell(22);	
	$pdf->Cell(5,5,utf8_decode($suma_subtotal_bruto));
	$pdf->Cell(15);	
	$pdf->Cell(5,5,utf8_decode($suma_subtotal_tara));	
	$pdf->Cell(14);	
	$pdf->Cell(5,5,utf8_decode($suma_subtotal_neto));	
	$pdf->Ln(5);
	$pdf->Cell(119);
	$pdf->Cell(72, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(4);
	$transacciones=	$transacciones+$contador;


  }//fin de producto
  
  
} //FIN DE LA CONSULTA PRINCIPAL
	$suma_total_bruto=number_format($suma_total_bruto1 ,0,".",",");
	$suma_total_tara=number_format($suma_total_tara1 ,0,".",",");
	$suma_total_neto=number_format($suma_total_neto1 ,0,".",",");
	$transacciones1=number_format($transacciones ,0,".",",");	
	$pdf->Ln(2);
	$pdf->Cell(5,5,utf8_decode('Transacciones'));
	$pdf->Cell(25);	
	$pdf->Cell(5,5,utf8_decode($transacciones1));
	$pdf->Cell(80);
	$pdf->SetFont('Arial','B',9);	
	$pdf->Cell(5,5,utf8_decode('Total (Kg)'));
	$pdf->Cell(15);	
	$pdf->Cell(5,5,utf8_decode($suma_total_bruto));
	$pdf->Cell(15);	
	$pdf->Cell(5,5,utf8_decode($suma_total_tara));	
	$pdf->Cell(14);	
	$pdf->Cell(5,5,utf8_decode($suma_total_neto));
	$pdf->Ln(5);
	$pdf->Cell(119);
	$pdf->Cell(72, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(1);
	$pdf->Cell(119);
	$pdf->Cell(72, 0, '', 1, 1, 0, 'J', false );
	
	$pdf->Output();
?>
<title><?PHP echo $nom_sistema; ?></title>
