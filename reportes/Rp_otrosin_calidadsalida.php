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

$id_despacho_buscar=$_GET['id'];
	
// BUSCA EL NUMERO DE TRANSACCION...
$result=mysql_query("SELECT a.id_cliente, a.id_lote, a.entrada, a.id_transportista, a.id_silo, a.peso_bruto, a.peso_tara, a.peso_sin_humedad, a.fecha_entrada, a.hora_entrada, a.fecha_salida, a.hora_salida, b.* FROM tab_salida as a, tab_indicadoresdespacho as b WHERE a.id_salida=b.id_salida AND a.id_salida='$id_despacho_buscar'");
  
	while($row = mysql_fetch_array($result)){
	$id_cliente=$row['id_cliente'];
	$id_lote = $row['id_lote'];
	$entrada=number_format($row['entrada'],0,".",",");
	$id_transportista = $row['id_transportista'];	
	$id_silo=$row['id_silo'];
	$peso_bruto1=number_format($row['peso_bruto'],2,".", ",");
	//$peso_bruto1=$row['peso_bruto'];
	$fecha1=parseDatePhp($row['fecha_entrada']);
	$hora1=$row['hora_entrada'];	
	//$peso_tara1=$row['peso_tara'];
	$peso_tara1=number_format($row['peso_tara'],2,".", ",");
	$fecha2=parseDatePhp($row['fecha_salida']);
	$hora2=$row['hora_salida'];	
	$peso_neto2=$row['peso_bruto']-$row['peso_tara'];
	$peso_neto1=number_format($peso_neto2,2,".", ",");
	$teorico1=number_format($row['peso_teorico'],2,".", ",");
	$diferencia2= $peso_neto2-$row['peso_teorico'];
	$diferencia1=number_format($diferencia2,2,".", ",");
	$humedad1=$row['humedad'].'%';
	if($row['humedad_rojo']!=0){$humedad_rojo1=chr(52);}
	if($row['humedad_verde']!=0){$humedad_verde1=chr(52);}
	$temperatura1=$row['temperatura'].'%';
	if($row['temperatura_rojo']!=0){$temperatura_rojo1=chr(52);}
	if($row['temperatura_verde']!=0){$temperatura_verde1=chr(52);}
	$grano_bola1=$row['grano_bola'].'%';
	if($row['grano_bola_rojo']!=0){$grano_bola_rojo1=chr(52);}
	if($row['grano_bola_verde']!=0){$grano_bola_verde1=chr(52);}
	$grano_chico1=$row['grano_chico'].'%';
	if($row['grano_chico_rojo']!=0){$grano_chico_rojo1=chr(52);}
	if($row['grano_chico_verde']!=0){$grano_chico_verde1=chr(52);}
	$grano_roto1=$row['grano_roto'].'%';
	if($row['grano_roto_rojo']!=0){$grano_roto_rojo1=chr(52);}
	if($row['grano_roto_verde']!=0){$grano_roto_verde1=chr(52);}
	$impureza1=$row['impureza'].'%';
	if($row['impureza_rojo']!=0){$impureza_rojo1=chr(52);}
	if($row['impureza_verde']!=0){$impureza_verde1=chr(52);}
	$otras_variedades1=$row['otras_variedades'].'%';
	if($row['otras_variedades_rojo']!=0){$otras_variedades_rojo1=chr(52);}
	if($row['otras_variedades_verde']!=0){$otras_variedades_verde1=chr(52);}
	$piedras1=$row['piedras'].'%';
	if($row['piedras_rojo']!=0){$piedras_rojo1=chr(52);}
	if($row['piedras_verde']!=0){$piedras_verde1=chr(52);}
	$infestacion1=$row['infestacion'].'%';
	if($row['infestacion_rojo']!=0){$infestacion_rojo1=chr(52);}
	if($row['infestacion_verde']!=0){$infestacion_verde1=chr(52);}
	$retencion_malla1=$row['retencion_malla'].'%';
	if($row['retencion_malla_rojo']!=0){$retencion_malla_rojo1=chr(52);}
	if($row['retencion_malla_verde']!=0){$retencion_malla_verde1=chr(52);}
	$suma_granos_danados1=$row['suma_granos_danados'].'%';
	if($row['suma_granos_danados_rojo']!=0){$suma_granos_danados_rojo1=chr(52);}
	if($row['suma_granos_danados_verde']!=0){$suma_granos_danados_verde1=chr(52);}
	$calor1=$row['calor'].'%';
	if($row['calor_rojo']!=0){$calor_rojo1=chr(52);}
	if($row['calor_verde']!=0){$calor_verde1=chr(52);}
	$insecto1=$row['insecto'].'%';
	if($row['insecto_rojo']!=0){$insecto_rojo1=chr(52);}
	if($row['insecto_verde']!=0){$insecto_verde1=chr(52);}
	$hongo1=$row['hongo'].'%';
	if($row['hongo_rojo']!=0){$hongo_rojo1=chr(52);}
	if($row['hongo_verde']!=0){$hongo_verde1=chr(52);}
	$germinacion1=$row['germinacion'].'%';
	if($row['germinacion_rojo']!=0){$germinacion_rojo1=chr(52);}
	if($row['germinacion_verde']!=0){$germinacion_verde1=chr(52);}
	$peso_100_granos1=$row['peso_100_granos'].'%';
	if($row['peso_100_granos_rojo']!=0){$peso_100_granos_rojo1=chr(52);}
	if($row['peso_100_granos_verde']!=0){$peso_100_granos_verde1=chr(52);}
	$longitud_20_granos1=$row['longitud_20_granos'].'%';
	if($row['longitud_20_granos_rojo']!=0){$longitud_20_granos_rojo1=chr(52);}
	if($row['longitud_20_granos_verde']!=0){$longitud_20_granos_verde1=chr(52);}
	$densidad1=$row['densidad'].'%';
	if($row['densidad_rojo']!=0){$densidad_rojo1=chr(52);}
	if($row['densidad_verde']!=0){$densidad_verde1=chr(52);}
	$aflotoxinas1=$row['aflotoxinas'].'%';
	if($row['aflotoxinas_rojo']!=0){$aflotoxinas_rojo1=chr(52);}
	if($row['aflotoxinas_verde']!=0){$aflotoxinas_verde1=chr(52);}
	$fumonisinas1=$row['fumonisinas'].'%';
	if($row['fumonisinas_rojo']!=0){$fumonisinas_rojo1=chr(52);}
	if($row['fumonisinas_verde']!=0){$fumonisinas_verde1=chr(52);}
	$vomitoxinas1=$row['vomitoxinas'].'%';
	if($row['vomitoxinas_rojo']!=0){$vomitoxinas_rojo1=chr(52);}
	if($row['vomitoxinas_verde']!=0){$vomitoxinas_verde1=chr(52);}
	$stress_crack1=$row['stress_crack'].'%';
	if($row['stress_crack_rojo']!=0){$stress_crack_rojo1=chr(52);}
	if($row['stress_crack_verde']!=0){$stress_crack_verde1=chr(52);}
	$flotadores1=$row['flotadores'].'%';
	if($row['flotadores_rojo']!=0){$flotadores_rojo1=chr(52);}
	if($row['flotadores_verde']!=0){$flotadores_verde1=chr(52);}
	$_SESSION['nom_analista1']=$row['nom_analista'];
	$observaciones1=$row['observaciones'];
	
	
	
	
	$result1=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='$id_cliente'"); // NOMBRE DEL CLIENTE
	while($row_cliente=mysql_fetch_array($result1)){
		$nom_cliente1=utf8_decode($row_cliente['nom_cliente']);
		$nom_cliente11 = substr($nom_cliente1, 0,24);
		}
		
	$result2=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote'"); // NUMERO DEL LOTE
	while($row2=mysql_fetch_array($result2)){
		$num_lote1=$row2['num_lote'];
		$id_producto=$row2['id_producto'];
		$id_origenbuscar=$row2['id_origen'];
		}
		
	$origen1=mysql_query("SELECT * FROM tab_origen WHERE id_origen='$id_origenbuscar'"); // origen
	while($roworigen=mysql_fetch_array($origen1)){
		$nom_origen1=substr(utf8_decode($roworigen['nom_origen']),0,27);
				
		}	
		
	
	$result3=mysql_query("SELECT * FROM tab_producto WHERE id_producto='$id_producto'"); // producto
	while($row3=mysql_fetch_array($result3)){
		$nom_producto1=substr(utf8_decode($row3['nom_producto']),0,25);
		$nom_productor=utf8_decode($row3['nom_productor']);		
		}


	$result5=mysql_query("SELECT * FROM tab_transportista WHERE id_transportista='$id_transportista'"); // piloto
	while($row5=mysql_fetch_array($result5)){
		$placa1=utf8_decode($row5['placa_vehiculo']);
		$piloto1=substr(utf8_decode($row5['nom_transportista']." ".$row5['ape_transportista']),0,23);		
		}	
	
	$result7=mysql_query("SELECT * FROM tab_silo WHERE id_silo='$id_silo'"); // piloto
	while($row7=mysql_fetch_array($result7)){
		$nom_silo1=utf8_decode($row7['nom_silo']);
		}	
} //FIN DE LA CONSULTA PRINCIPAL

if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
date_default_timezone_set("America/El_Salvador");
$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");
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

	$this->Cell(1);
	$this->Rect(5,5,200,268);
    //Logo
	$this->Image('logo/logo.png',15,6);
	$this->Rect(5,5,50,40);
	$this->Rect(55,15,150,10);
	$this->Rect(5,35,200,10);
	$this->Rect(155,5,50,40);
	 //TITULO DEL REPORTE
 	$this->Ln(-1);	 
	$this->Cell(92);
    $this->SetFont('Arial','B',12);
	$this->Cell(5,5,utf8_decode('GRANOS BASICOS DE CENTROAMÉRICA, S.A'),0,0,'C');
	$this->Cell(56);
	$this->SetFont('Arial','',9);
	$this->Cell(5,5,utf8_decode('EDICIÓN: 00'),0,0,'C');
	$this->Ln(7);	 
	$this->Cell(45);
    $this->SetFont('Arial','',9);
	$this->Cell(5,5,utf8_decode('CLASIFICACIÓN DEL DOCUMENTO:'),0,0,'J');
	$this->Ln(3);	 
	$this->Cell(70);
	$this->Cell(5,5,utf8_decode(' FORMATO DE REGISTRO: DESPACHO'),0,0,'J');
	$this->Ln(-2);
	$this->Cell(145);
    $this->SetFont('Arial','',9);
	$this->Cell(5,8,utf8_decode('FECHA DE EMISIÓN: 20/05/2019'),0,0,'J');
	$this->Ln(10);	 
	$this->Cell(45);
    $this->SetFont('Arial','',9);
	$this->Cell(5,5,utf8_decode('TÍTULO:'),0,0,'J');
	$this->Ln(2);	 
	$this->Cell(60);
	$this->Cell(5,5,utf8_decode(' INFORME DE ANÁLISIS DE MATERIA PRIMA MAÍZ'),0,0,'J');
	$this->Ln(-2);
	$this->Cell(145);
    $this->SetFont('Arial','',9);
	$this->Cell(5,8,utf8_decode('VIGENCIA: 20/05/2021'),0,0,'J');
	$this->Ln(10);	
	$this->Cell(-2);
    $this->SetFont('Arial','',9);
	$this->Cell(5,5,utf8_decode('CLAVE:'),0,0,'J'); 
	$this->Cell(43);
    $this->SetFont('Arial','',9);
	$this->Cell(5,5,utf8_decode('RESPONSABLE:'),0,0,'J');
	$this->Ln(2);	 
	$this->Cell(15);
	$this->Cell(5,5,utf8_decode(' FR-GT-CC-013'),0,0,'J');
	$this->Cell(60);
	$this->Cell(5,5,utf8_decode(' CONTROL DE CALIDAD'),0,0,'J');
	$this->Ln(-5);
	$this->Cell(145);
    $this->SetFont('Arial','',9);
	$this->Cell(5,8,utf8_decode('PÁGINA: 1 DE 1'),0,0,'J');
	$this->Ln(4);
	$this->Cell(145);
    $this->SetFont('Arial','',9);
	$this->Cell(5,8,utf8_decode('ESTATUS: VIGENTE'),0,0,'J');
	
    }



function __construct()
    {       
        //Llama al constructor de su clase Padre.
        //Modificar aka segun la forma del papel del reporte
        parent::__construct('P','mm','Letter');
    }
	
	
    //Pie de página
    function Footer()
    {
      
      //Posición: a 1,5 cm del final
        $this->SetY(-22);
        //Arial italic 8
        $this->SetFont('Arial','',8);
			
        //Número de página
        $this->MultiCell(60,5,utf8_decode($_SESSION['nom_analista1']));
      
    }	

   
}

ob_end_clean();
$pdf=new PDF ();


//$pdf->SetTopMargin(5.4);
//$pdf->SetLeftMargin(4.5); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Rect(5,50,200,6);
$pdf->Rect(5,62,200,6);
$pdf->Rect(5,74,200,6);
$pdf->Rect(5,86,200,5);
$pdf->Rect(5,96,200,5);
$pdf->Rect(5,106,200,5);
$pdf->Rect(5,116,200,5);
$pdf->Rect(5,126,200,5);
$pdf->Rect(5,136,200,5);
$pdf->Rect(5,146,200,5);
$pdf->Rect(5,156,200,5);
$pdf->Rect(5,166,200,5);
$pdf->Rect(5,176,200,5);
$pdf->Rect(5,186,200,5);
$pdf->Rect(5,196,200,5);
$pdf->Rect(5,206,200,5);
$pdf->Rect(5,226,200,5);
$pdf->Rect(5,236,200,5);
$pdf->Rect(5,246,200,5);
$pdf->Rect(5,256,200,17);
$pdf->Rect(70,50,65,176);
$pdf->Rect(160,86,22,120);
$pdf->Rect(70,251,65,22);





	


// cuerpo del reporte
//$pdf->SetFillColor(238,197,32);
//simbolo




// BUSCA EL NUMERO DE TRANSACCION...

	$pdf->Ln(13);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,'FECHA: '.$fecha_entrada,0,0,'J',0);
	$pdf->Cell(58);
    $pdf->Cell(5,5,'HORA: '.$hora,0,0,'J',0); 
	$pdf->Cell(60);
    $pdf->Cell(5,5,'ORDEN DE COMPRA:',0,0,'J',0); 
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(68,5,utf8_decode('PROVEEDOR: '.$nom_cliente11),0,0,'J',0);
	$pdf->Cell(-5);
    $pdf->Cell(5,5,utf8_decode('ORIGEN: '.$nom_origen1),0,0,'J',0); 
	$pdf->Cell(60);
    $pdf->Cell(5,5,utf8_decode('LOTE DE INSPECCIÓN:'),0,0,'J',0); 
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(68,5,utf8_decode('CENTRO DE ACOPIO: GRAN. BÁSIC. DE C.A' ),0,0,'J',0);
	$pdf->Cell(-5);
    $pdf->Cell(5,5,utf8_decode('N° DE SILO: '.$nom_silo1),0,0,'J',0); 
	$pdf->Cell(60);
    $pdf->Cell(5,5,utf8_decode('CANTIDAD:'),0,0,'J',0);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(68,5,utf8_decode('N° DE SILO DE PLANTA:'),0,0,'J',0);
	$pdf->Cell(-5);
    $pdf->Cell(5,5,utf8_decode('COLOR'),0,0,'J',0); 
	$pdf->Cell(60);
    $pdf->Cell(5,5,utf8_decode('PLACAS: '.$placa1.' '.$piloto1),0,0,'J',0);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(68,5,utf8_decode('VARIEDAD: '.$nom_producto1),0,0,'J',0);
	$pdf->Cell(-5);
    $pdf->Cell(5,5,utf8_decode('LOTE ASIGNADO: '.$num_lote1),0,0,'J',0); 
	$pdf->Cell(60);
    $pdf->Cell(5,5,utf8_decode('SELLOS:'),0,0,'J',0);
	$pdf->Ln(6);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('N° DE INSPECCIÓN DE TRANSPORTE:'),0,0,'J',0);
	$pdf->Cell(123);
    $pdf->Cell(5,5,utf8_decode('CERTIFICADO: '),0,0,'J',0); 
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(-2);
    $pdf->Cell(60,5,utf8_decode('ANÁLISIS'),0,0,'C',0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(1);
    $pdf->Cell(65,5,utf8_decode('ESPECIFICACIONES'),0,0,'C',0);
	$pdf->Cell(1);
    $pdf->Cell(26,5,utf8_decode('RESULTADOS'),0,0,'C',0);
	$pdf->Cell(1);
    $pdf->Cell(17,5,utf8_decode('ROJO'),0,0,'C',0);
	$pdf->Cell(9);
    $pdf->Cell(9,5,utf8_decode('VERDE'),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('HUMEDAD'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('11.0 - 14.5% MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($humedad1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($humedad_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($humedad_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('TEMPERATURA'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('28.0% MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($temperatura1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($temperatura_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($temperatura_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('GRANO BOLA'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('3.0% MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($grano_bola1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($grano_bola_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($grano_bola_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('GRANO CHICO'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('2.0% MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($grano_chico1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($grano_chico_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($grano_chico_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('GRANOS ROTOS'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('2.0% MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($grano_roto1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($grano_roto_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($grano_roto_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('IMPUREZAS'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('3.0% MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($impureza1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($impureza_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($impureza_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('OTRAS VARIEDADES'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('3.0% MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($otras_variedades1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($otras_variedades_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($otras_variedades_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('PIEDRAS'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('AUSENTE'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($piedras1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($piedras_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($piedras_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('INFESTACIÓN'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('AUSENTE'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($infestacion1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($infestacion_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($infestacion_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('RETENCION EN MALLA 1/4'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('96% MIN'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($retencion_malla1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($retencion_malla_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($retencion_malla_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('GRANOS DAÑADOS'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('3.0% MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($suma_granos_danados1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($suma_granos_danados_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($suma_granos_danados_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('CALOR'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode(''),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($calor1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($calor_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($calor_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('INSECTO'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode(''),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($insecto1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($insecto_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($insecto_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('HONGO'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode(''),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($hongo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($hongo_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($hongo_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('GERMINACIÓN'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('90.0% MIN'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($germinacion1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($germinacion_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($germinacion_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('PESO DE 100 GRANOS'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('28 GRAMOS MIN'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($peso_100_granos1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($peso_100_granos_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($peso_100_granos_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('LONGITUD 20 GRANOS'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('15.5CM MIN'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($longitud_20_granos1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($longitud_20_granos_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($longitud_20_granos_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('DENSIDAD'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('721GL MIN'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($densidad1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($densidad_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($densidad_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('AFLOTOXINAS'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('20.0 PPB MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($aflotoxinas1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($aflotoxinas_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($aflotoxinas_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('FUMONISINAS'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('2.0 PPM MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($fumonisinas1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($fumonisinas_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($fumonisinas_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('VOMITOXINAS (DON)'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('1.0 PPM MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($vomitoxinas1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($vomitoxinas_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($vomitoxinas_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('STRESS CRACK'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode('3.0% MAX'),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($stress_crack1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($stress_crack_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($stress_crack_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(-2);
    $pdf->Cell(5,5,utf8_decode('FLOTADORES'),0,0,'J',0);
	$pdf->Cell(56);
    $pdf->Cell(65,5,utf8_decode(''),0,0,'C',0); 
	$pdf->Cell(11);
    $pdf->Cell(5,5,utf8_decode($flotadores1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
    $pdf->Cell(5,5,($flotadores_rojo1),0,0,'C',0);
	$pdf->Cell(18);
	$pdf->SetFont('ZapfDingbats','',12);
	$pdf->Cell(5,5,($flotadores_verde1),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(-2);
    $pdf->Cell(60,5,utf8_decode('APROBADO'),0,0,'C',0);
	$pdf->Cell(68,5,utf8_decode('RECHAZADO'),0,0,'C',0);
	$pdf->Cell(70,5,utf8_decode('CUARENTENA'),0,0,'C',0);
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(-2);
    $pdf->Cell(200,5,utf8_decode('OBSERVACIONES'),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->SetFont('Arial','',8);
	$pdf->Multicell(190,5,utf8_decode($observaciones1));
	//$pdf->Ln(24);
	$pdf->SetY(250);	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(-2);
    $pdf->Cell(60,7,utf8_decode('ANALISTA'),0,0,'C',0);
	$pdf->Cell(68,7,utf8_decode('CONTROL MP'),0,0,'C',0);
	$pdf->Cell(70,7,utf8_decode('CONTROL CALIDAD'),0,0,'C',0);
		


	
	$pdf->Output();
?>
