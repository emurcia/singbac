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
	$this->Cell(80);
    $this->SetFont('Arial','B',15);
	$this->Cell(30,5,'REPORTE DE INGRESOS / EGRESOS DIARIOS ',0,0,'C');
	$this->Ln(6);
	$this->Cell(85);	
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
	$this->Ln(10);
	 
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
        //Modificar segun la forma del papel del reporte
        parent::__construct('P','mm','Letter');
    }
   
}

ob_end_clean();
$pdf=new PDF ();
//$pdf->SetTopMargin(5.4);
//$pdf->SetLeftMargin(4.5); 
$pdf->AliasNbPages();
$pdf->AddPage();
	

// cuerpo del reporte

$pdf->SetFont('Arial','B',8);
// BUSCA EL NUMERO DE TRANSACCION...
	$pdf->Ln(1);

$pdf->SetFont('Arial','B',10);
	$pdf->Cell(1);
    $pdf->Cell(183,5,utf8_decode('Lote')."                        ".utf8_decode('Cliente')."                             ".utf8_decode('N°')."        ".utf8_decode('Placa')."          ".utf8_decode('Entrada')."         ".utf8_decode('Salida ')."            ".utf8_decode('Fecha')."             ".utf8_decode('Hora '),0,0,'J',0);
	$pdf->Ln(7);	
	$pdf->Cell(1);
	$pdf->Cell(190, 0, '', 1, 1, 0, 'C', false );	

	
// MOSTRAR POR PRODUCTOS
$suma_total_entrada=0;
$suma_total_salida=0;
$transacciones=0;
$result=mysql_query("SELECT a.id_kardex, a.id_almacenaje as kardex_entra, a.id_salida as kardex_sal, a.fecha as kardex_fec, a.hora as kardex_hor, b.fecha_entrada as fecha_entrada, b.id_almacenaje as entrada, b.id_cliente as id_cliente_ent, b.id_silo as silo_entrada, b.id_lote as id_lote_ent, c.id_silo as silo_salida, c.fecha_entrada as fecha_salida, c.id_salida as salida, c.id_cliente as id_cliente_sal, c.id_lote as id_lote_sal, e.num_lote as num_lote FROM tab_kardex as a, tab_almacenaje as b, tab_salida as c, tab_lote as e WHERE a.id_almacenaje=b.id_almacenaje and a.id_salida=c.id_salida and (b.id_lote=e.id_lote or c.id_lote=e.id_lote) and (a.fecha>='$fecha_inicio_buscar' and a.fecha<='$fecha_fin_buscar') and e.num_lote!='' group by e.num_lote ");
 while($row_datos = mysql_fetch_array($result)){
	 $num_lote1=$row_datos['num_lote'];

	$contador=0;
	$suma_entrada=0;
	$suma_salida=0;

$reporte=mysql_query("SELECT a.id_kardex, a.id_almacenaje as kardex_entra, a.id_salida as kardex_sal, a.fecha as kardex_fec, a.hora as kardex_hor, b.fecha_entrada as fecha_entrada, b.id_almacenaje as entrada, (b.peso_bruto - b.peso_tara) as p_neto_entrada, b.id_cliente as id_cliente_ent, b.id_silo as silo_entrada, b.id_lote as id_lote_ent, c.id_silo as silo_salida, c.fecha_entrada as fecha_salida, c.id_salida as salida, (c.peso_bruto - c.peso_tara) as p_neto_salida, c.id_cliente as id_cliente_sal, c.id_lote as id_lote_sal, d.nom_cliente as cliente_entra, e.num_lote as num_lote, f.placa_vehiculo FROM tab_kardex as a, tab_almacenaje as b, tab_salida as c, tab_cliente as d, tab_lote as e, tab_transportista as f WHERE a.id_almacenaje=b.id_almacenaje and a.id_salida=c.id_salida and (c.id_cliente=d.id_cliente or b.id_cliente=d.id_cliente) and (b.id_lote=e.id_lote or c.id_lote=e.id_lote) and (b.id_transportista=f.id_transportista or c.id_transportista= f.id_transportista) and (a.fecha>='$fecha_inicio_buscar' and a.fecha<='$fecha_fin_buscar') and d.nom_cliente!='' and e.num_lote!='' and f.placa_vehiculo!='' and num_lote='$num_lote1'",$con);	
	 while($row_datos2 = mysql_fetch_array($reporte)){
		//$id_transportista_con=$row_datos2['id_transportista'];
		$contador++;
		$entrada1=$row_datos2['num_lote'];
		$cliente1=$row_datos2['cliente_entra'];
		$placa1=$row_datos2['placa_vehiculo'];
		$peso_entrada1=$row_datos2['p_neto_entrada'];
		$peso_salida1=$row_datos2['p_neto_salida'];
		$fecha1=$row_datos2['kardex_fec'];
		$hora1=$row_datos2['kardex_hor'];			
		$suma_entrada=$suma_entrada+$peso_entrada1;
		$suma_salida=$suma_salida+$peso_salida1;
		
		if($peso_entrada1=="0"){
			$peso_entrada1="";
			}
		if($peso_salida1=="0"){
			$peso_salida1="";
			}			
		if($peso_entrada1=="" and $peso_salida1==""){
			$peso_entrada1="0";
			$peso_salida1="0";
			}			
	$pdf->Ln(1);
	$pdf->Cell(1);
	$pdf->SetFont('Arial','',10);	
    $pdf->Cell(5,4,utf8_decode($entrada1));
	$pdf->Cell(7);
	$x1 = $pdf->GetX();
    $pdf->Multicell(60,4,utf8_decode($cliente1));
	$y1 = $pdf->GetY();
	$posicionX = $x1 + 50; 
	$pdf->SetXY($posicionX,$y1);
	$y2 = $pdf->GetY();
	$alto = $y2-$y1-3;
	$pdf->Cell(9);
	$pdf->Cell(5,$alto,utf8_decode($contador));
	$pdf->Cell(2);
    $pdf->Cell(5,$alto,utf8_decode($placa1));
	$pdf->Cell(19);
	$pdf->Cell(5,$alto,utf8_decode($peso_entrada1));
	$pdf->Cell(16);
	$pdf->Cell(5,$alto,utf8_decode($peso_salida1));	
	$pdf->Cell(16);
    $pdf->Cell(5,$alto,utf8_decode(parseDatePhp($fecha1)));
	$pdf->Cell(18);
    $pdf->Cell(5,$alto,utf8_decode($hora1));
	$pdf->Ln(0);
   }
   $pdf->Ln(1);
   	$pdf->Cell(104);
	$pdf->Cell(87, 0, '', 1, 1, 0, 'J', false );	
	$pdf->Ln(2);
   	$pdf->Cell(75);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Subtotal (KG)'));
	$pdf->Cell(23);	
	$pdf->Cell(5,5,utf8_decode($suma_entrada));
	$pdf->Cell(16);	
	$pdf->Cell(5,5,utf8_decode($suma_salida));
	$pdf->Ln(5);
	$pdf->Cell(104);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(4);
	$transacciones=	$transacciones+$contador;
	$suma_total_entrada=$suma_total_entrada+$suma_entrada;
	$suma_total_salida=$suma_total_salida+$suma_salida;
  
} //FIN DE LA CONSULTA PRINCIPAL

	$pdf->Cell(27);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Transacciones'));
	$pdf->Cell(25);	
	$pdf->Cell(5,5,utf8_decode($transacciones));
	$pdf->Cell(19);	
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Total (KG)'));
	$pdf->Cell(17);	
	$pdf->Cell(5,5,utf8_decode($suma_total_entrada));
	$pdf->Cell(16);	
	$pdf->Cell(5,5,utf8_decode($suma_total_salida));
	
	$pdf->Ln(5);
	$pdf->Cell(104);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(1);
	$pdf->Cell(104);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',12);
	$pdf->Cell(5);
    $pdf->Cell(10,5,'SERVICIO DE BASCULA',0,0,'J',0); 
	$pdf->Ln(6);

$suma_total=0;
$transacciones=0;
$result=mysql_query("SELECT a.*, b.* FROM tab_bascula as a, tab_cliente as b WHERE a.id_cliente=b.id_cliente and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') group by id_subproducto");
 while($row_datos = mysql_fetch_array($result)){
//	$id_cliente=$row['id_cliente'];
    $id_producto1=$row_datos['id_producto'];
	$id_subproducto1=$row_datos['id_subproducto'];
	
$producto=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto1'");
  while($row_producto = mysql_fetch_array($producto)){
	$nom_producto1=$row_producto['nom_producto'];	
	
		$subproducto=mysql_query("SELECT * FROM tab_subproducto WHERE id_subproducto='$id_subproducto1'");
		 while($row_subproducto = mysql_fetch_array($subproducto)){
		$nom_subproducto1=$row_subproducto['nom_subproducto'];	
	
	$pdf->SetFont('Arial','B',10);
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
	$pdf->Cell(5);
    $pdf->Cell(180,5,utf8_decode('N°')."         ".utf8_decode('Control')."         ".utf8_decode('Placas')."         ".utf8_decode('Neto kg')."         ".utf8_decode('Fecha entrada')."         ".utf8_decode('Hora entrada')."         ".utf8_decode('Fecha salida')."         ".utf8_decode('Hora salida'),0,0,'C',0);
	$pdf->Ln(6);	
	$pdf->Cell(1);
	$pdf->Cell(190, 0, '', 1, 1, 0, 'C', false );

// extrae los datos de la tabla para mostrarlos en el espacio de la tabla	
	$contador=0;
	$suma_subtotal=0;

$reporte=mysql_query("SELECT a.*, b.* FROM tab_bascula as a, tab_cliente as b WHERE a.id_cliente=b.id_cliente and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and id_subproducto='$id_subproducto1' and id_producto='$id_producto1'");	
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
		$placa1=$row_trans['placa_vehiculo'];
  		}
    //$id_producto2=$row_datos2['id_producto'];
	//$id_subproducto2=$row_datos2['id_subproducto'];
	$pdf->Ln(1);
	$pdf->Cell(1);
	$pdf->SetFont('Arial','',10);	
    $pdf->Cell(5,5,utf8_decode($contador));
	$pdf->Cell(13);
    $pdf->Cell(5,5,utf8_decode($entrada1));
	$pdf->Cell(10);
    $pdf->Cell(5,5,utf8_decode($placa1));	
	$pdf->Cell(18);
    $pdf->Cell(5,5,utf8_decode($peso_neto1));
	$pdf->Cell(20);
    $pdf->Cell(5,5,utf8_decode($fecha1));
	$pdf->Cell(24);
    $pdf->Cell(5,5,utf8_decode($hora1));
	$pdf->Cell(24);
    $pdf->Cell(5,5,utf8_decode($fecha2));
	$pdf->Cell(26);
    $pdf->Cell(5,5,utf8_decode($hora2));		
 	$pdf->Ln(3);
   }
   	$pdf->Ln(2);
   	$pdf->Cell(51);
	$pdf->Cell(140, 0, '', 1, 1, 0, 'J', false );	
	$pdf->Ln(2);
   	$pdf->Cell(35);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Subtotal'));
	$pdf->Cell(16);	
	$pdf->Cell(5,5,utf8_decode($suma_subtotal)."  Kg");
	$pdf->Ln(5);
	$pdf->Cell(51);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(5);
		$transacciones=	$transacciones+$contador;

} // fin de sub subproducto

  }//fin de producto
  
  
} //FIN DE LA CONSULTA PRINCIPAL
	$pdf->Cell(35);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Total'));
	$pdf->Cell(16);	
	$pdf->Cell(5,5,utf8_decode($suma_total)."  Kg");
	$pdf->Cell(27);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Transacciones'));
	$pdf->Cell(25);	
	$pdf->Cell(5,5,utf8_decode($transacciones));
	$pdf->Ln(5);
	$pdf->Cell(50);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(1);
	$pdf->Cell(50);
	$pdf->Cell(30, 0, '', 1, 1, 0, 'J', false );	
	$pdf->Output();
?>
