<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece                        
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)

$seleccion1= $_GET['id'];
$id_lote2 = $_GET['id4'];
$fecha_inicio_buscar= parseDateMysql($_GET['id2']);
$fecha_fin_buscar= parseDateMysql($_GET['id3']);


if($seleccion1=="0" AND $id_lote2=="0"){
$where = "a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa' group by a.id_lote";
}else{
	if($seleccion1!="0" AND $id_lote2=="0"){
	$where = "a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$seleccion1' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa' group by a.id_lote";
	}else{
		$where = "a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$seleccion1' and a.id_lote='$id_lote2' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.peso_bruto!='0'  and a.bandera='2' AND a.id_empresa='$id_empresa' group by a.id_lote";
	      }
}



/*echo"<script>alert('llega al php');</script>";*/ 	


// $id_despacho_buscar=$_GET['id'];

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
$cont=mysql_query("SELECT * FROM tab_contador WHERE codigo='1' and id_empresa='$id_empresa'");
  while($row_contador = mysql_fetch_array($cont)){
	$contador1=$row_contador['total'];
	$servicio_bascula1=$row_contador['servicio_bascula'];
	}		
$fecha_inicio_buscar1= ($_GET['id2']);
$fecha_fin_buscar1= ($_GET['id3']);     

$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");
	$this->Cell(1);
	$this->Rect(5,5,268,200);
    //Logo
	$this->Image('logo/logo.png',10,10);
	 //TITULO DEL REPORTE
 	$this->Ln(6);	 
	$this->Cell(100);
    $this->SetFont('Arial','B',15);
	$this->Cell(40,5,'ENTRADA DE PRODUCTOS - CONTROL DE CALIDAD',0,0,'C');
	$this->Ln(6);
	$this->Cell(100);	
	$this->SetFont('Arial','',11);
	$this->Cell(40,5,'Periodo del  '.$fecha_inicio_buscar1.' al ' .$fecha_fin_buscar1,0,0,'C');	
	
	//Salto de línea
    $this->Ln(5);
	 //Movernos a la derecha
    $this->Cell(200);
	$this->SetFont('Arial','',10);
	$this->Cell(40,5,'FECHA DE IMPRESION:',0,0,'C');
    $this->SetFont('Arial','',10);
	$this->Cell(20,5,$fecha_entrada,0,0,'C');
    $this->Ln(5);	
	$this->Cell(200);
	$this->SetFont('Arial','',10);
	$this->Cell(39,5,'HORA DE IMPRESION:',0,0,'C');
    $this->SetFont('Arial','',10);
	$this->Cell(20,5,$hora,0,0,'C');
	$this->Ln(6);
    }

    //Pie de página
    function Footer()
    {
      
      //Posición: a 1,5 cm del final
        $this->SetY(-20);
        //Arial italic 8
        $this->SetFont('Arial','I',10);
        //Número de página
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
      
    }

function __construct()
    {       
        //Llama al constructor de su clase Padre.
        //Modificar aka segun la forma del papel del reporte
        parent::__construct('L','mm','Letter');
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

	
	
// MOSTRAR POR PRODUCTOS
$suma_total=0;
$transacciones=0;
$result=mysql_query("SELECT a.*, b.*, c.* FROM tab_almacenaje as a, tab_cliente as b, tab_lote as c WHERE $where");

//$result=mysql_query("SELECT a.*, b.* FROM tab_almacenaje as a, tab_cliente as b WHERE a.id_cliente=b.id_cliente and a.id_cliente='$seleccion1' and a.peso_bruto!=0 and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada <= '$fecha_fin_buscar') and a.tipo_peso=2 and a.id_empresa='$id_empresa' group by a.id_lote ");
 while($row_datos = mysql_fetch_array($result)){
	 $id_lote1=$row_datos['id_lote'];
	 $ban=$row_datos['bandera'];
	 $id_cliente_buscar=$row_datos['id_cliente'];
	 $nom_cliente=$row_datos['nom_cliente'];;
	 
	$lote=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote1' and id_empresa='$id_empresa'");
  while($row_lote = mysql_fetch_array($lote)){
	  	$num_lote1=$row_lote['num_lote'];
	  	$id_lote2=$row_lote['id_lote'];
	  	$id_producto1=$row_lote['id_producto'];
		$id_subproducto1=$row_lote['id_subproducto'];
	
	
$producto=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto1' and id_empresa='$id_empresa'");
  while($row_producto = mysql_fetch_array($producto)){
	$nom_producto1=$row_producto['nom_producto'];	
	
		$subproducto=mysql_query("SELECT * FROM tab_subproducto WHERE id_subproducto='$id_subproducto1' and id_empresa='$id_empresa'");
		 while($row_subproducto = mysql_fetch_array($subproducto)){
		$nom_subproducto1=$row_subproducto['nom_subproducto'];	

if($ban=="0") $estado_lote="ACTIVO";  else $estado_lote="INACTIVO";

	$pdf->Ln(9);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Cliente:',0,0,'J',0); 
	$pdf->Cell(22);
 	$pdf->MultiCell(80,5,utf8_decode($nom_cliente));		
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Lote:',0,0,'J',0); 
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($num_lote1),0,0,'J');
	$pdf->Ln(5);	
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Estado del Lote:',0,0,'J',0); 
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($estado_lote),0,0,'J');
	$pdf->Ln(5);		
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Producto:',0,0,'J',0); 
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_producto1),0,0,'J');
	$pdf->Ln(5);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Subproducto:',0,0,'J',0); 
	$pdf->Cell(22);
 	$pdf->Cell(1,5,utf8_decode($nom_subproducto1),0,0,'J');

// ENCABEZADO DE TABLA
	$pdf->Ln(8);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(1);
    $pdf->Cell(250,5,utf8_decode('N°')."   ".utf8_decode('Control')."   ".utf8_decode('Placas')."      ".utf8_decode('Neto')."         ".utf8_decode('Fecha ')."         ".utf8_decode('Hora')."      ".utf8_decode('Peso')."   ".utf8_decode('Tempe')."   ".utf8_decode('Hum')."  ".utf8_decode('Grano')."  ".utf8_decode('Grano')."   ".utf8_decode('Daño')."  ".utf8_decode('Impur')."  ".utf8_decode('Grano')."  ".utf8_decode('Grano')."     ".utf8_decode('Plaga')."  ".utf8_decode('Plaga')."   ".utf8_decode('Stress')."      ".utf8_decode('Olor')."      ".utf8_decode('Vapor')."      ".utf8_decode('Peso sin'),0,0,'J',0);
	$pdf->Ln(4);
	$pdf->Cell(12);	
	$pdf->Cell(1,5,utf8_decode('  ')."".utf8_decode('       ')."      ".utf8_decode('    ')."         ".utf8_decode(' kg')."          ".utf8_decode('Entrada ')."     ".utf8_decode('Entrada')."    ".utf8_decode('Vol')."      ".utf8_decode('ratura')."      ".utf8_decode('')."         ".utf8_decode('Ente')."   ".utf8_decode('Quebra')."  ".utf8_decode('hongo')."            ".utf8_decode('Chico')."   ".utf8_decode('Picado')."   ".utf8_decode('viva')."    ".utf8_decode('muert')."   ".utf8_decode('Crack')."                                     ".utf8_decode('Humedad'),0,0,'J',0);
	$pdf->Ln(7);	
	$pdf->Cell(1);
	$pdf->Cell(260, 0, '', 1, 1, 0, 'J', false );

// extrae los datos de la tabla para mostrarlos en el espacio de la tabla	
	$contador=0;
	$suma_subtotal=0;
	$suma_sin_humedad=0;



$reporte=mysql_query("SELECT a.*, b.*, c.* FROM tab_almacenaje as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_cliente=c.id_cliente and a.id_cliente='$id_cliente_buscar' and (a.fecha_entrada>= '$fecha_inicio_buscar' and a.fecha_entrada<= '$fecha_fin_buscar') and c.id_subproducto='$id_subproducto1' and c.id_producto='$id_producto1' and a.id_lote='$id_lote2' and a.bandera='2' and a.tipo_peso=2 and a.id_empresa='$id_empresa' group by c.id_subproducto, c.id_producto, a.entrada, a.id_lote ",$con);	
	 while($row_datos2 = mysql_fetch_array($reporte)){
		$id_transportista_con=$row_datos2['id_transportista'];
		$id_variable=$row_datos2['id_variable'];
		$contador++;
		$entrada1=$row_datos2['entrada'];
		$peso_bruto1=$row_datos2['peso_bruto'];
		$peso_tara1=$row_datos2['peso_tara'];
		$peso_neto1=$peso_bruto1-$peso_tara1;
		$fecha1=parseDatePhp($row_datos2['fecha_entrada']);
		$hora1=$row_datos2['hora_entrada'];	
		$fecha2=parseDatePhp($row_datos2['fecha_salida']);
		$hora2=$row_datos2['hora_salida'];						
		$peso_volumetrico1=$row_datos2['peso_vol'];
		$temperatura1=$row_datos2['temperatura'];
		$humedad1=$row_datos2['humedad'];
		$gran_entero1=$row_datos2['grano_entero'];
		$gran_quebrado1=$row_datos2['grano_quebrado'];
		$dan_hongo1=$row_datos2['dan_hongo'];
		$impureza1=$row_datos2['impureza'];
		$grano_chico1=$row_datos2['grano_chico'];
		$grano_picado1=$row_datos2['grano_picado'];
		$plaga_viva1=$row_datos2['plaga_viva'];
		$plaga_muerta1=$row_datos2['plaga_muerta'];
		$stress_crack1=$row_datos2['stress_crack'];
		$olor1=strtoupper($row_datos2['olor']);
		$vapor1=strtoupper($row_datos2['vapor']);
		$neto_sin_humedad1=$row_datos2['neto_sin_humedad'];
		$suma_subtotal=$suma_subtotal+$peso_neto1;
	  	$suma_total=$suma_total+$peso_neto1;
		$suma_sin_humedad=$suma_sin_humedad+$neto_sin_humedad1;
		
		$transportista=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_transportista_con' and id_empresa='$id_empresa'");
  		while($row_trans = mysql_fetch_array($transportista)){
		$placa1=$row_trans['placa_vehiculo'];
  		}
$variable=mysql_query("SELECT * FROM tab_variables WHERE id_variable='$id_variable' and id_empresa='$id_empresa'");
  		while($row_var = mysql_fetch_array($variable)){
		$peso_vol=$row_var['peso_vol'];
		$humedad=$row_var['humedad'];
		$temperatura=$row_var['temperatura'];
		$grano_entero=$row_var['grano_entero'];
		$grano_quebrado=$row_var['grano_quebrado'];	
		$dan_hongo=$row_var['dan_hongo'];
		$impureza=$row_var['impureza'];	
		$grano_chico=$row_var['grano_chico'];
		$grano_picado=$row_var['grano_picado'];
		$plaga_viva=$row_var['plaga_viva'];	
		$plaga_muerta=$row_var['plaga_muerta'];	
		$stress_crack=$row_var['stress_crack'];														
  		}		
    //$id_producto2=$row_datos2['id_producto'];
	//$id_subproducto2=$row_datos2['id_subproducto'];
	//$pdf->Ln(2);
	$pdf->Cell(1);
	$pdf->SetFont('Arial','',9);	
    $pdf->Cell(5,5,utf8_decode($contador));
	$pdf->Cell(5);
    $pdf->Cell(5,5,utf8_decode($entrada1));
	$pdf->Cell(3);
    $pdf->Cell(5,5,utf8_decode($placa1));	
	$pdf->Cell(14);
    $pdf->Cell(5,5,number_format(($peso_neto1), 0, ".", ","));
	$pdf->Cell(6);
    $pdf->Cell(5,5,utf8_decode($fecha1));
	$pdf->Cell(13);
    $pdf->Cell(5,5,utf8_decode($hora1));
	$pdf->Cell(13);
	if ($peso_volumetrico1>$peso_vol){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($peso_volumetrico1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($peso_volumetrico1));	
	}
	$pdf->Cell(6);
	if ($temperatura1>$temperatura){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($temperatura1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($temperatura1));	
	}
	$pdf->Cell(6);
	if ($humedad1>$humedad){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($humedad1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($humedad1));	
	}
	$pdf->Cell(6);
	if ($gran_entero1>$grano_entero){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($gran_entero1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($gran_entero1));	
	}
	$pdf->Cell(6);
	if ($gran_quebrado1>$grano_quebrado){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($gran_quebrado1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($gran_quebrado1));	
	}
	$pdf->Cell(6);
	if ($dan_hongo1>$dan_hongo){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($dan_hongo1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($dan_hongo1));	
	}
	$pdf->Cell(6);
	if ($impureza1>$impureza){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($impureza1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($impureza1));	
	}
	$pdf->Cell(6);
	if ($grano_chico1>$grano_chico){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($grano_chico1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($grano_chico1));	
	}
	$pdf->Cell(6);
	if ($grano_picado1>$grano_picado){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($grano_picado1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($grano_picado1));	
	}
	$pdf->Cell(6);
	if ($plaga_viva1>$plaga_viva){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($plaga_viva1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($plaga_viva1));	
	}
	$pdf->Cell(6);
	if ($plaga_muerta1>$plaga_muerta){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($plaga_muerta1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($plaga_muerta1));	
	}
	$pdf->Cell(6);
	if ($stress_crack1>$stress_crack){
	$pdf->SetFont('Arial','B',9);
    $pdf->Cell(5,5,utf8_decode($stress_crack1));
	}else {
	$pdf->SetFont('Arial','',9);	
	$pdf->Cell(5,5,utf8_decode($stress_crack1));	
	}
	$pdf->Cell(4);
	$pdf->SetFont('Arial','',9);
    $pdf->Cell(5,5,utf8_decode($olor1));	
	$pdf->Cell(10);
    $pdf->Cell(5,5,utf8_encode($vapor1));	
	$pdf->Cell(10);
    $pdf->Cell(5,5,number_format(round($neto_sin_humedad1,2), 2, ".", ","));
 	$pdf->Ln(5);
   }
   	$pdf->Cell(38);
	$pdf->Cell(223, 0, '', 1, 1, 0, 'J', false );	
	$pdf->Ln(1);
   	$pdf->Cell(17);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Subtotal'));
	$pdf->Cell(14);	
	$pdf->Cell(5,5,number_format(round($suma_subtotal,2), 2, ".", ","));
	$pdf->Cell(199);	
	$pdf->Cell(5,5, number_format(round($suma_sin_humedad,2), 2, ".", ","));
	$pdf->Ln(5);
	$pdf->Cell(38);
	$pdf->Cell(20, 0, '', 1, 1, 0, 'J', false );
	$pdf->Cell(241);
	$pdf->Cell(20, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(4);
	$transacciones=	$transacciones+$contador;
	$suma_sin_humedad_total=$suma_sin_humedad_total+$suma_sin_humedad;
} // fin de sub subproducto

  }//fin de producto
  } // fin del lote
  
} //FIN DE LA CONSULTA PRINCIPAL
	$pdf->Cell(17);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Total'));
	$pdf->Cell(15);	
	$pdf->Cell(5,5,number_format(round($suma_total,2), 2, ".", ","));
	$pdf->Cell(27);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Transacciones'));
	$pdf->Cell(25);	
	$pdf->Cell(5,5, round($transacciones,2));
	$pdf->Cell(135);	
	$pdf->Cell(5,5,number_format(round($suma_sin_humedad_total,2), 2, ".", ","));
	$pdf->Ln(5);
	$pdf->Cell(38);
	$pdf->Cell(20, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(1);
	$pdf->Cell(38);
	$pdf->Cell(20, 0, '', 1, 1, 0, 'J', false );
	$pdf->Cell(241);
	$pdf->Cell(20, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(1);
	$pdf->Cell(241);
	$pdf->Cell(20, 0, '', 1, 1, 0, 'J', false );
	
	$pdf->Output();
?>
