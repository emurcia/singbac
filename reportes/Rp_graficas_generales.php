<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");
include("../graficos/jpgraph/inc/jpgraph.php");
include("../graficos/jpgraph/inc/jpgraph_bar.php");
include("../graficos/jpgraph/inc/jpgraph_pie.php");
include("../graficos/jpgraph/inc/jpgraph_pie3d.php");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece                        
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)

$id_imagen = $_GET['id_imagen']; //  CODIGO DEL SILO

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
    $this->SetFont('Times','B',15);
	$this->Cell(40,5,'INDICADORES POR SILO',0,0,'C');
	$this->Ln(6);
	$this->Cell(80);	
	$this->SetFont('Times','',11);
	//Salto de línea
    $this->Ln(5);
	 //Movernos a la derecha
    $this->Cell(130);
	$this->SetFont('Times','',10);
	$this->Cell(40,5,'FECHA DE IMPRESION:',0,0,'C');
    $this->SetFont('Times','',10);
	$this->Cell(20,5,$fecha_entrada,0,0,'C');
    $this->Ln(5);	
	$this->Cell(130);
	$this->SetFont('Times','',10);
	$this->Cell(39,5,'HORA DE IMPRESION:',0,0,'C');
    $this->SetFont('Times','',10);
	$this->Cell(20,5,$hora,0,0,'C');
	$this->Ln(5);
    }

    //Pie de página
    function Footer()
    {
      
      //Posición: a 1,5 cm del final
        $this->SetY(-15);
        //Arial italic 8
        $this->SetFont('Times','I',10);
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

//CREACION DE GRAFICA DE ESPACIO DE SILO 
// EXTRAER DATOS DE ALMACENAJE DE PRODUCTOS
$suma_lote_almacen=mysql_query("SELECT SUM(peso_bruto) AS suma_peso, SUM(peso_tara) AS suma_tara FROM `tab_almacenaje` WHERE id_silo='$id_imagen'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO
$row_suma_almacen = mysql_fetch_assoc($suma_lote_almacen);
 $acumulado_lote_almacen=$row_suma_almacen['suma_peso']; //SUMA EL PESO BRUTO
 $acumulado_tara_almacen=$row_suma_almacen['suma_tara'];// SUMA EL PESO TARA

 $total_bruto_almacen=$acumulado_lote_almacen-$acumulado_tara_almacen;
//EXTRAER DATOS DE SALIDA DE PRODUCTO
$suma_lote_salida=mysql_query("SELECT SUM(peso_bruto) AS suma_peso, SUM(peso_tara) AS suma_tara FROM `tab_salida` WHERE id_silo='$id_imagen'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO
$row_suma_salida = mysql_fetch_assoc($suma_lote_salida);
 $acumulado_lote_salida=$row_suma_salida['suma_peso']; //SUMA EL PESO BRUTO
 $acumulado_tara_salida=$row_suma_salida['suma_tara'];// SUMA EL PESO TARA
  $total_bruto_salida=$acumulado_lote_salida-$acumulado_tara_salida;
 
  $total_bruto=$total_bruto_almacen-$total_bruto_salida;

 
$cons = mysql_query("SELECT * FROM tab_silo WHERE id_silo = '".$id_imagen."';",$con);
if ($fila1 = mysql_fetch_array($cons)){ 
  $nom_sil=$fila1['nom_silo'];
  $cap=$fila1['cap_silo'];
}

// CREACION DE GRAFICOS
 $disponibilidad=$cap-$total_bruto; 
 $id_usuario=$_SESSION['id_usuario_silo'];
 $a2=substr($id_usuario,4,3);
 
 $datos_grafi=$cap."/".$total_bruto."/".$disponibilidad;
 $tabla="temp"."silo".$a2;
 $tabla1="temp"."silo2".$a2;
 $tabla2="temp"."silo3".$a2;
 //$tabla3="temp"."silo".$a2;
	mysql_query("CREATE TABLE $tabla(datos double)",$con);

//PROCEDIMIENTO PARA ALMACENAR EN LA TABLA DETALLE SERVICIOS
	$string_to_array= split("/",$datos_grafi);
	foreach ($string_to_array as $value):
     $value;
		mysql_query("INSERT INTO $tabla(datos) VALUES('$value')",$con);	
	 endforeach;

$result = mysql_query("SELECT * FROM $tabla");
while ($row = mysql_fetch_row($result)) {
$arreglo1[] = $row[0]; 
} 	

$datax = array('Capacidad','Utilizado','Disponible'); 

$ydata = $arreglo1;
$graph = new Graph(350, 250, "auto");   
$graph->SetShadow(); 
$graph->SetScale("textlin");
//$graph->SetMarginColor('white');
$graph->img->SetMargin(40, 20, 20, 40);
$graph->SetBackgroundGradient($aFrom='white',$aTo='blue',$aGradType=11,$aStyle=GRAD_LEFT_REFLECTION);
$graph->title->Set($nom_sil);	
$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetTickLabels($datax); 
//$graph->yaxis->title->Set("Kilogramos" );

$barplot =new BarPlot($ydata);

$barplot->SetWidth(1);
$barplot->SetFillGradient("AntiqueWhite4:0.8","palegreen:1.65",GRAD_LEFT_REFLECTION);
$barplot->value->SetFont(FF_ARIAL,FS_BOLD); 
$barplot->value->Show();

$graph->Add($barplot);
$direccion_grafica="../graficos/temp/".$tabla.".png";
$graph->Stroke("$direccion_grafica");

// FIN 
//CREACION DE GRAFICA DE LOTE ENTRADA
$disponible_almacen=0;
$consulta_lote = mysql_query("SELECT id_lote AS lote, (SUM(peso_bruto) - SUM(peso_tara)) AS disponible FROM `tab_almacenaje` WHERE id_silo='".$id_imagen."' Group by lote",$con);
while ($rowlote = mysql_fetch_row($consulta_lote)) {
$arreglo11e[] = $rowlote[1]; // DATOS
$disponible_almacen=$disponible_almacen+ $rowlote[1];
}
$consulta_lot = mysql_query("SELECT * FROM `tab_lote` WHERE id_silo='".$id_imagen."' Group by id_lote",$con);
while ($rowlotenombre = mysql_fetch_row($consulta_lot)) {
$arreglo22e[] = $rowlotenombre[1]; // NOMBRE
} 	

$datax = $arreglo22e; 
$ydata = $arreglo11e;
$graph = new PieGraph(350, 225, "auto"); 
$graph->SetShadow();  
$graph->SetScale("textlin");
$graph->img->SetMargin(40, 20, 20, 40);

$graph->SetBackgroundGradient($aFrom='white',$aTo='blue',$aGradType=4,$aStyle=GRAD_MIDVER);
$graph->title->Set("CANTIDAD OCUPADA POR LOTES");	

$graph->legend->SetAbsPos(4,20,'right','top');

$barplot1 =new PiePlotC($ydata);
$barplot1->value->SetFont(FF_FONT1,8);

$barplot1->SetLegends($datax);
$barplot1->SetSize(0.35);
$barplot1->SetCenter(0.40,0.55);
$barplot1->midtitle->Set("Cantidad\n".$disponible_almacen."\nKG");
$barplot1->SetMidColor('yellow');
$barplot1->value->SetColor("black");
$barplot1->value->SetFormat('%2.2f%%'); 
$barplot1->SetLabelPos(1); 
$graph->Add($barplot1);
$tabla2="temp"."lotee".$a2;
$direccion_graficalote="../graficos/temp/".$tabla2.".png";
$graph->Stroke("$direccion_graficalote");

// FIN DE CREACION
//CREACION DE GRAFICA DE LOTE SALIDA
$disponible_salida="0";
$consulta_lote = mysql_query("SELECT id_lote AS lote, (SUM(peso_bruto) - SUM(peso_tara)) AS disponible FROM `tab_salida` WHERE id_silo='".$id_imagen."' Group by lote",$con);
while ($rowlote = mysql_fetch_row($consulta_lote)) {
$arreglo11s[] = $rowlote[1]; // DATOS
$disponible_salida=$disponible_salida+ $rowlote[1];
}
$consulta_lot = mysql_query("SELECT * FROM `tab_lote` WHERE id_silo='".$id_imagen."' Group by id_lote",$con);
while ($rowlotenombre = mysql_fetch_row($consulta_lot)) {
$arreglo22s[] = $rowlotenombre[1]; // NOMBRE
} 	

$datax = $arreglo22s; 
$ydata = $arreglo11s;
$graph = new PieGraph(350, 225, "auto"); 
$graph->SetShadow();  
$graph->SetScale("textlin");
$graph->img->SetMargin(40, 20, 20, 40);

$graph->SetBackgroundGradient($aFrom='white',$aTo='blue',$aGradType=4,$aStyle=GRAD_MIDVER);
$graph->title->Set("CANTIDAD OCUPADA POR LOTES");	

$graph->legend->SetAbsPos(4,20,'right','top');

$barplot1 =new PiePlotC($ydata);
$barplot1->value->SetFont(FF_FONT1,8);

$barplot1->SetLegends($datax);
$barplot1->SetSize(0.35);
$barplot1->SetCenter(0.40,0.55);
$barplot1->midtitle->Set("Cantidad\n" .$disponible_salida."\nKG");
$barplot1->SetMidColor('yellow');
$barplot1->value->SetColor("black");
$barplot1->value->SetFormat('%2.2f%%'); 
$barplot1->SetLabelPos(1); 
$graph->Add($barplot1);
$tabla2="temp"."lotes".$a2;
$direccion_graficalots="../graficos/temp/".$tabla2.".png";
$graph->Stroke("$direccion_graficalots");

// FIN
//DISTRIBUCION DEL LOTE POR CLIENTE / EMPRESA ENTRADA
$disponible_cliente="0";
$consulta_cliente = mysql_query("SELECT a.id_lote AS lote, a.id_cliente AS cliente, (SUM(a.peso_bruto) - SUM(a.peso_tara)) AS disponible, b.nom_cliente, b.id_cliente FROM tab_almacenaje as a, tab_cliente as b WHERE id_silo='".$id_imagen."' AND a.id_cliente=b.id_cliente Group BY cliente",$con);
while ($rowcliente = mysql_fetch_row($consulta_cliente)) {
$arreglo111[] = $rowcliente[2]; // DATOS
$arreglo222[] = $rowcliente[4]; // NOMBRE
$disponible_cliente=$disponible_cliente + $rowcliente[2];
}

$datax = $arreglo222; 
$ydata = $arreglo111;
$graph = new PieGraph(375, 275, "auto"); 
$graph->SetShadow();  
$graph->SetScale("textlin");
$graph->img->SetMargin(30, 20, 20, 40);

$graph->SetBackgroundGradient($aFrom='white',$aTo='blue',$aGradType=4,$aStyle=GRAD_MIDVER);
$graph->title->Set("DISTRIBUCION DEL SILO POR CLIENTE");	

$graph->legend->SetAbsPos(4,20,'right','top');

$barplot1 =new PiePlotC($ydata);
$barplot1->value->SetFont(FF_FONT1,5);


$barplot1->SetLegends($datax);
$barplot1->SetSize(0.35);
$barplot1->SetCenter(0.4,0.55);
$barplot1->midtitle->Set("Cantidad\n" .$disponible_cliente."\nKG");
$barplot1->SetMidColor('yellow');

$barplot1->SetLabelType(PIE_VALUE_PER);

$barplot1->value->Show();
$graph->Add($barplot1);
$tabla3="temp"."clienteen".$a2;
$direccion_graficacli="../graficos/temp/".$tabla3.".png";
$graph->Stroke("$direccion_graficacli");

// FIN DE CREACION DE GRAFICO POR CLIENTE ENTRADA
//DISTRIBUCION DEL LOTE POR CLIENTE / EMPRESA SALIDA
$disponible_cliente_sal="0";
$consulta_cliente_sal = mysql_query("SELECT a.id_lote AS lote, a.id_cliente AS cliente, (SUM(a.peso_bruto) - SUM(a.peso_tara)) AS disponible, b.nom_cliente, b.id_cliente FROM tab_salida as a, tab_cliente as b WHERE id_silo='".$id_imagen."' AND a.id_cliente=b.id_cliente Group BY cliente",$con);
while ($rowcliente_sal = mysql_fetch_row($consulta_cliente_sal)) {
$arreglo111_sal[] = $rowcliente_sal[2]; // DATOS
$arreglo222_sal[] = $rowcliente_sal[4]; // NOMBRE
$disponible_cliente_sal=$disponible_cliente_sal + $rowcliente_sal[2];
}

$datax = $arreglo222_sal; 
$ydata = $arreglo111_sal;
$graph = new PieGraph(375, 275, "auto"); 
$graph->SetShadow();  
$graph->SetScale("textlin");
$graph->img->SetMargin(30, 20, 20, 40);

$graph->SetBackgroundGradient($aFrom='white',$aTo='blue',$aGradType=4,$aStyle=GRAD_MIDVER);
$graph->title->Set("DISTRIBUCION DEL SILO POR CLIENTE");	

$graph->legend->SetAbsPos(4,20,'right','top');


$barplot1 =new PiePlotC($ydata);
$barplot1->value->SetFont(FF_FONT1,5);


$barplot1->SetLegends($datax);
$barplot1->SetSize(0.35);
$barplot1->SetCenter(0.4,0.55);
$barplot1->midtitle->Set("Cantidad\n" .$disponible_cliente_sal."\nKG");
$barplot1->SetMidColor('yellow');

$barplot1->SetLabelType(PIE_VALUE_PER);

$barplot1->value->Show();
$graph->Add($barplot1);
$tabla3="temp"."clientesa".$a2;
$direccion_graficaclisal="../graficos/temp/".$tabla3.".png";
$graph->Stroke("$direccion_graficaclisal");

// FIN DE CREACION DE GRAFICO POR CLIENTE SALIDA

//DISTRIBUCION DEL LOTE POR SERVICIOS
$disponible_servicio="0";
$consulta_servicio = mysql_query("SELECT a.id_lote AS lote, a.id_servicio AS servicio, (SUM(a.peso_bruto) - SUM(a.peso_tara)) AS disponible, b.nom_servicio FROM tab_almacenaje as a, tab_servicio as b WHERE id_silo='".$id_imagen."' AND a.id_servicio=b.id_servicio Group BY nom_servicio",$con);
while ($rowservicio = mysql_fetch_row($consulta_servicio)) {
$arreglo1111[] = $rowservicio[2]; // DATOS
$arreglo2222[] = $rowservicio[1]; // NOMBRE
$disponible_servicio=$disponible_servicio+$rowservicio[2];
}

$datax = $arreglo2222; 
$ydata = $arreglo1111;
$graph = new PieGraph(375, 275, "auto"); 
$graph->SetShadow();  
$graph->SetScale("textlin");
$graph->img->SetMargin(30, 20, 20, 40);

$graph->SetBackgroundGradient($aFrom='white',$aTo='blue',$aGradType=4,$aStyle=GRAD_MIDVER);
$graph->title->Set("DISTRIBUCION DEL SILO POR SERVICIOS");	

$graph->legend->SetAbsPos(4,20,'right','top');

$barplot1 =new PiePlotC($ydata);
$barplot1->value->SetFont(FF_FONT1,5);


$barplot1->SetLegends($datax);
$barplot1->SetSize(0.35);
$barplot1->SetCenter(0.4,0.55);
$barplot1->midtitle->Set("Cantidad\n" .$disponible_servicio."\nKG");
$barplot1->SetMidColor('yellow');

$barplot1->SetLabelType(PIE_VALUE_PER);

$barplot1->value->Show();
$graph->Add($barplot1);
$tabla4="temp"."servicio".$a2;
$direccion_graficaserv="../graficos/temp/".$tabla4.".png";
$graph->Stroke("$direccion_graficaserv");

// FIN

//KARDEX
$con_kardex = mysql_query("SELECT SUM(b.peso_bruto) as p_bruto_ent, SUM(b.peso_tara) as p_tara_ent,(SUM(b.peso_bruto) - SUM(b.peso_tara))as diferencia_entrada, SUM(c.peso_bruto) as p_bruto_sa, SUM(c.peso_tara) as p_tara_sa, (SUM(c.peso_bruto) - SUM(c.peso_tara)) as diferencia_salida FROM tab_kardex as a, tab_almacenaje as b, tab_salida as c WHERE a.id_almacenaje=b.id_almacenaje and a.id_salida=c.id_salida and (b.id_silo='".$id_imagen."' or c.id_silo='".$id_imagen."')",$con);
mysql_query("CREATE TABLE $tabla1(datos double)",$con);
mysql_query("CREATE TABLE $tabla2(datos double)",$con);

while ($kardex = mysql_fetch_row($con_kardex)) {
 $datos_entrada=$kardex[0]."/".$kardex[1]."/".$kardex[2];	
 $datos_salida=$kardex[3]."/".$kardex[4]."/".$kardex[5];	
}
$string_to_array= split("/",$datos_entrada);
	foreach ($string_to_array as $value):
	mysql_query("INSERT INTO $tabla1(datos) VALUES('$value')",$con);	
  	endforeach;
	
$string_to_array= split("/",$datos_salida);
	foreach ($string_to_array as $value1):
	mysql_query("INSERT INTO $tabla2(datos) VALUES('$value1')",$con);	
  	endforeach;	

$result2 = mysql_query("SELECT * FROM $tabla1");
while ($row1 = mysql_fetch_row($result2)) {
$arr[] = $row1[0]; 
}

$consultarr = mysql_query("SELECT * FROM $tabla2");
while ($ro = mysql_fetch_row($consultarr)) {
$arr1[] = $ro[0]; 
}
		 
$datay1=$arr;
$datay2=$arr1;

$graph = new Graph(350, 250,'auto');	
$graph->SetScale("textlin");
$graph->SetShadow();
$graph->img->SetMargin(40,30,40,40);
$datos=array(BRUTO,TARA,NETO);
$graph->xaxis->SetTickLabels($datos);

$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

$graph->title->Set('ENTRADA / SALIDA');
$graph->title->SetFont(FF_FONT1,FS_BOLD);

$bplot1 = new BarPlot($datay1);
$bplot2 = new BarPlot($datay2);
$bplot1->value->Show();
$bplot2->value->Show();
$bplot1->SetFillColor("orange");
$bplot2->SetFillColor("brown");
$bplot1->SetLegend("Ent");
$bplot2->SetLegend("Sal");
	

$bplot1->SetShadow();
$bplot2->SetShadow();

$gbarplot = new GroupBarPlot(array($bplot1,$bplot2));
$gbarplot->SetWidth(0.90);

//

$graph->Add($gbarplot);
$graph->legend->SetPos(0.95,0.99,'center','bottom');

$tabla5="temp"."kardex".$a2;
$direccion_graficakar="../graficos/temp/".$tabla5.".png";
$graph->Stroke("$direccion_graficakar");

// FIN 

$consulta = mysql_query("SELECT * FROM tab_silo WHERE id_silo = '".$id_imagen."';",$con);
if ($fila = mysql_fetch_array($consulta)){ 
	$nombre_silo=$fila['nom_silo'];
	$descripcion_silo=$fila['desc_silo'];
	$direccion_silo=$fila['dir_silo'];	
  	$url_img = $fila['foto_silo'];
  	$capacidad=$fila['cap_silo'];
	}
  	$espacio_libre=$capacidad-$total_bruto;


	$pdf->Ln(8);
	$pdf->SetFont('Times','B',12);
	$pdf->Cell(17);
    $pdf->Cell(10,5,'Nombre:',0,0,'J',0); 
	$pdf->SetFont('Times','',10);
	$pdf->Cell(25);
 	$pdf->Cell(80,5,utf8_decode($nombre_silo));
	$pdf->Ln(5);
	$pdf->Cell(17);	
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10,5,utf8_decode('Descripción:'),0,0,'J',0); 
	$pdf->SetFont('Times','',10);
	$pdf->Cell(25);
 	$pdf->MultiCell(135,5,utf8_decode($descripcion_silo));
	$pdf->Cell(17);	
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10,5,utf8_decode('Dirección:'),0,0,'J',0); 
	$pdf->SetFont('Times','',10);
	$pdf->Cell(25);
 	$pdf->MultiCell(135,5,utf8_decode($direccion_silo));
	$pdf->Cell(17);	
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10,5,utf8_decode('Capacidad:'),0,0,'J',0); 
	$pdf->SetFont('Times','',10);
	$pdf->Cell(25);
	$pdf->SetFont('Times','',10);
 	$pdf->Cell(80,5,utf8_decode($capacidad)."  KG");
	$pdf->Ln(5);
	$pdf->Cell(17);	
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10,5,utf8_decode('Recepción:'),0,0,'J',0); 
	$pdf->SetFont('Times','',10);
	$pdf->Cell(25);
	$pdf->SetFont('Times','',10);
 	$pdf->Cell(80,5,utf8_decode($total_bruto_almacen)	."  KG");
	$pdf->Ln(5);
	$pdf->Cell(17);	
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10,5,utf8_decode('Despacho:'),0,0,'J',0); 
	$pdf->SetFont('Times','',10);
	$pdf->Cell(25);
	$pdf->SetFont('Times','',10);
 	$pdf->Cell(80,5,utf8_decode($total_bruto_salida)."  KG");
	$pdf->Ln(5);
	$pdf->Cell(17);	
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10,5,utf8_decode('Espacio Ocupado:'),0,0,'J',0); 
	$pdf->SetFont('Times','',10);
	$pdf->Cell(25);
 	$pdf->Cell(80,5,utf8_decode($total_bruto)." KG");
	$pdf->Ln(5);
	$pdf->Cell(17);	
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10,5,utf8_decode('Disponibilidad:'),0,0,'J',0); 
	$pdf->SetFont('Times','',10);
	$pdf->Cell(25);
 	$pdf->MultiCell(80,5,utf8_decode($disponibilidad)." KG");
	
	$pdf->Ln(2);
	$pdf->Cell(35,40, $pdf->Image($direccion_grafica, $pdf->GetX()+40, $pdf->GetY()+3, 100) ,0,"C");
	//$pdf->Ln(2);
	$y1 = $pdf->GetY();
	$y2=$y1+76;
	$pdf->SetY($y2);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(8);
	$pdf->Cell(170,5,utf8_decode('RECEPCION DE GRANOS DEL SILO "'.$nom_sil.'" POR LOTE'),0,0,'C',0);
	$pdf->Ln(6);
	$pdf->Cell(20);
    $pdf->Cell(170,5,utf8_decode('N°')."         ".utf8_decode('LOTE')."         ".utf8_decode('FECHA INGRESO')."         ".utf8_decode('BRUTO (KG)')."         ".utf8_decode('TARA (KG)')."         ".utf8_decode('NETO (KG)'),0,0,'J',0);
	$pdf->Ln(5);	
	$pdf->Cell(20);
	$pdf->Cell(150, 0, '', 1, 1, 0, 'C', false );
	$pdf->SetFont('Times','',10);

$nu="0";	
$sum_bruto="0";
$sum_tara="0";
$sum_neto="0";
$consulta_lote_t = mysql_query("SELECT id_lote, fecha_entrada, SUM(peso_bruto) AS peso_bruto, SUM(peso_tara) as peso_tara FROM `tab_almacenaje` WHERE id_silo='".$id_imagen."' Group by id_lote",$con);
while ($rowlote_t = mysql_fetch_array($consulta_lote_t)) {
$nu++;	
$lote=$rowlote_t['id_lote'];
$fecha=$rowlote_t['fecha_entrada'];
$peso_bruto1=$rowlote_t['peso_bruto'];
$peso_tara1=$rowlote_t['peso_tara'];
$dif=$peso_bruto1-$peso_tara1;
$sum_bruto=$sum_bruto+$peso_bruto1;
$sum_tara=$sum_tara+$peso_tara1;
$sum_neto=$sum_neto+$dif;

$consulta_lot_t = mysql_query("SELECT * FROM `tab_lote` WHERE id_lote='".$lote."' Group by id_lote",$con);
while ($rowlotenombre_t = mysql_fetch_array($consulta_lot_t)) {
$nom_lote=$rowlotenombre_t['num_lote'];
}
$pdf->Cell(20);
$pdf->SetFont('Times','',10);	
    $pdf->Cell(5,4,utf8_decode($nu));
	$pdf->Cell(7);
    $pdf->Cell(5,4,utf8_decode($nom_lote));
	$pdf->Cell(20);
    $pdf->Cell(5,4,utf8_decode(parseDatePhp($fecha)));
	$pdf->Cell(35);
    $pdf->Cell(5,4,utf8_decode($peso_bruto1));
	$pdf->Cell(23);
    $pdf->Cell(5,4,utf8_decode($peso_tara1));
	$pdf->Cell(23);
    $pdf->Cell(5,4,utf8_decode($dif));

$pdf->Ln(4);
}	
$pdf->Ln(1);	
	$pdf->Cell(20);
	$pdf->Cell(150, 0, '', 1, 1, 0, 'C', false );	
	$pdf->Ln(1);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(55);
    $pdf->Cell(5,4,utf8_decode('TOTALES'));
	$pdf->Cell(37);
    $pdf->Cell(5,4,utf8_decode($sum_bruto));
	$pdf->Cell(23);
    $pdf->Cell(5,4,utf8_decode($sum_tara));
	$pdf->Cell(23);
    $pdf->Cell(5,4,utf8_decode($sum_neto));
	$pdf->Ln(5);
	$pdf->Cell(35,40, $pdf->Image($direccion_graficalote, $pdf->GetX()+40, $pdf->GetY()+3, 115) ,0,"C");
	
	// TABLA DE DESPACHO DE GRANOS BASICOS
	$pdf->AddPage();
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(8);
	$pdf->Cell(170,5,utf8_decode('DESPACHO DE GRANOS DEL SILO "'.$nom_sil.'" POR LOTE'),0,0,'C',0);
	$pdf->Ln(6);
	$pdf->Cell(20);
    $pdf->Cell(170,5,utf8_decode('N°')."         ".utf8_decode('LOTE')."         ".utf8_decode('FECHA INGRESO')."         ".utf8_decode('BRUTO (KG)')."         ".utf8_decode('TARA (KG)')."         ".utf8_decode('NETO (KG)'),0,0,'J',0);
	$pdf->Ln(5);	
	$pdf->Cell(20);
	$pdf->Cell(150, 0, '', 1, 1, 0, 'C', false );
	$pdf->SetFont('Times','',10);

$nu="0";	
$sum_bruto="0";
$sum_tara="0";
$sum_neto="0";
$consulta_lote_t = mysql_query("SELECT id_lote, fecha_entrada, SUM(peso_bruto) AS peso_bruto, SUM(peso_tara) as peso_tara FROM `tab_salida` WHERE id_silo='".$id_imagen."' Group by id_lote",$con);
while ($rowlote_t = mysql_fetch_array($consulta_lote_t)) {
$nu++;	
$lote=$rowlote_t['id_lote'];
$fecha=$rowlote_t['fecha_entrada'];
$peso_bruto1=$rowlote_t['peso_bruto'];
$peso_tara1=$rowlote_t['peso_tara'];
$dif=$peso_bruto1-$peso_tara1;
$sum_bruto=$sum_bruto+$peso_bruto1;
$sum_tara=$sum_tara+$peso_tara1;
$sum_neto=$sum_neto+$dif;

$consulta_lot_t = mysql_query("SELECT * FROM `tab_lote` WHERE id_lote='".$lote."' Group by id_lote",$con);
while ($rowlotenombre_t = mysql_fetch_array($consulta_lot_t)) {
$nom_lote=$rowlotenombre_t['num_lote'];
}
$pdf->Cell(20);
$pdf->SetFont('Times','',10);	
    $pdf->Cell(5,4,utf8_decode($nu));
	$pdf->Cell(7);
    $pdf->Cell(5,4,utf8_decode($nom_lote));
	$pdf->Cell(20);
    $pdf->Cell(5,4,utf8_decode(parseDatePhp($fecha)));
	$pdf->Cell(35);
    $pdf->Cell(5,4,utf8_decode($peso_bruto1));
	$pdf->Cell(23);
    $pdf->Cell(5,4,utf8_decode($peso_tara1));
	$pdf->Cell(23);
    $pdf->Cell(5,4,utf8_decode($dif));

$pdf->Ln(4);
}	
$pdf->Ln(1);	
	$pdf->Cell(20);
	$pdf->Cell(150, 0, '', 1, 1, 0, 'C', false );	
	$pdf->Ln(1);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(55);
    $pdf->Cell(5,4,utf8_decode('TOTALES'));
	$pdf->Cell(37);
    $pdf->Cell(5,4,utf8_decode($sum_bruto));
	$pdf->Cell(23);
    $pdf->Cell(5,4,utf8_decode($sum_tara));
	$pdf->Cell(23);
    $pdf->Cell(5,4,utf8_decode($sum_neto));
	$pdf->Ln(5);
	$pdf->Cell(35,40, $pdf->Image($direccion_graficalots, $pdf->GetX()+40, $pdf->GetY()+3, 115) ,0,"C");	
	
	// TABLA PARA GRAFICO DETALLE POR EMPRESA / CLIENTE ENTRADA

	$pdf->AddPage();
	$pdf->Ln(5);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10);
	$pdf->Cell(170,5,utf8_decode('RECEPCION DE GRANOS DEL SILO "'.$nom_sil.'" POR EMPLESA / CLIENTE'),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->Cell(10);
    $pdf->Cell(170,5,utf8_decode('N°')."    ".utf8_decode('CODIGO')."         ".utf8_decode('EMPRESA / CLIENTE')."                 ".utf8_decode('BRUTO (KG)')."         ".utf8_decode('TARA (KG)')."         ".utf8_decode('NETO (KG)'),0,0,'J',0);
	$pdf->Ln(5);	
	$pdf->Cell(10);
	$pdf->Cell(160, 0, '', 1, 1, 0, 'J', false );
	$pdf->SetFont('Times','',10);

$nu="0";	
$sum_bruto="0";
$sum_tara="0";
$sum_neto="0";
$consulta_lote_t = mysql_query("SELECT  a.id_cliente AS id_cliente, SUM(a.peso_bruto) as peso_bruto, SUM(a.peso_tara) AS peso_tara, b.nom_cliente FROM tab_almacenaje as a, tab_cliente as b WHERE a.id_silo='".$id_imagen."' AND a.id_cliente=b.id_cliente Group BY a.id_cliente",$con);
while ($rowlote_t = mysql_fetch_array($consulta_lote_t)) {
$nu++;	
$idcliente=$rowlote_t['id_cliente'];
$nomcliente=$rowlote_t['nom_cliente'];
$peso_bruto1=$rowlote_t['peso_bruto'];
$peso_tara1=$rowlote_t['peso_tara'];
$dif=$peso_bruto1-$peso_tara1;
$sum_bruto=$sum_bruto+$peso_bruto1;
$sum_tara=$sum_tara+$peso_tara1;
$sum_neto=$sum_neto+$dif;
$pdf->Ln(1);
$pdf->Cell(10);
$pdf->SetFont('Times','',10);	
    $pdf->Cell(5,4,utf8_decode($nu));
	$pdf->Cell(5);
    $pdf->Cell(5,4,utf8_decode($idcliente));
	$pdf->Cell(10);
	$x1 = $pdf->GetX();
    $pdf->Multicell(60,3,utf8_decode($nomcliente));	
	$y1 = $pdf->GetY();
	$posicionX = $x1 + 60; 
	$pdf->SetXY($posicionX,$y1);
	$y2 = $pdf->GetY();
	$alto = $y2-$y1-3;
	$pdf->Cell(3);
    $pdf->Cell(5,$alto,utf8_decode($peso_bruto1));
	$pdf->Cell(25);
    $pdf->Cell(5,$alto,utf8_decode($peso_tara1));
	$pdf->Cell(21);
    $pdf->Cell(5,$alto,utf8_decode($dif));

$pdf->Ln(1);
}	
$pdf->Ln(1);	
	$pdf->Cell(10);
	$pdf->Cell(160, 0, '', 1, 1, 0, 'C', false );	
	$pdf->Ln(1);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(55);
    $pdf->Cell(5,4,utf8_decode('TOTALES'));
	$pdf->Cell(38);
    $pdf->Cell(5,4,utf8_decode($sum_bruto));
	$pdf->Cell(25);
    $pdf->Cell(5,4,utf8_decode($sum_tara));
	$pdf->Cell(21);
    $pdf->Cell(5,4,utf8_decode($sum_neto));
	$pdf->Ln(7);
	$pdf->Cell(35,40, $pdf->Image($direccion_graficacli, $pdf->GetX()+40, $pdf->GetY()+3, 115) ,0,"C");
	
// TABLA PARA GRAFICO DETALLE POR EMPRESA / CLIENTE SALIDA

	$pdf->AddPage();
	$pdf->Ln(5);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10);
	$pdf->Cell(170,5,utf8_decode('DESPACHO DE GRANOS DEL SILO "'.$nom_sil.'" POR EMPLESA / CLIENTE'),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->Cell(10);
    $pdf->Cell(170,5,utf8_decode('N°')."    ".utf8_decode('CODIGO')."         ".utf8_decode('EMPRESA / CLIENTE')."                 ".utf8_decode('BRUTO (KG)')."         ".utf8_decode('TARA (KG)')."         ".utf8_decode('NETO (KG)'),0,0,'J',0);
	$pdf->Ln(5);	
	$pdf->Cell(10);
	$pdf->Cell(160, 0, '', 1, 1, 0, 'J', false );
	$pdf->SetFont('Times','',10);

$nu="0";	
$sum_bruto="0";
$sum_tara="0";
$sum_neto="0";
$consulta_lote_t = mysql_query("SELECT  a.id_cliente AS id_cliente, SUM(a.peso_bruto) as peso_bruto, SUM(a.peso_tara) AS peso_tara, b.nom_cliente FROM tab_salida as a, tab_cliente as b WHERE a.id_silo='".$id_imagen."' AND a.id_cliente=b.id_cliente Group BY a.id_cliente",$con);
while ($rowlote_t = mysql_fetch_array($consulta_lote_t)) {
$nu++;	
$idcliente=$rowlote_t['id_cliente'];
$nomcliente=$rowlote_t['nom_cliente'];
$peso_bruto1=$rowlote_t['peso_bruto'];
$peso_tara1=$rowlote_t['peso_tara'];
$dif=$peso_bruto1-$peso_tara1;
$sum_bruto=$sum_bruto+$peso_bruto1;
$sum_tara=$sum_tara+$peso_tara1;
$sum_neto=$sum_neto+$dif;
$pdf->Ln(1);
$pdf->Cell(10);
$pdf->SetFont('Times','',10);	
    $pdf->Cell(5,4,utf8_decode($nu));
	$pdf->Cell(5);
    $pdf->Cell(5,4,utf8_decode($idcliente));
	$pdf->Cell(10);
	$x1 = $pdf->GetX();
    $pdf->Multicell(60,3,utf8_decode($nomcliente));	
	$y1 = $pdf->GetY();
	$posicionX = $x1 + 60; 
	$pdf->SetXY($posicionX,$y1);
	$y2 = $pdf->GetY();
	$alto = $y2-$y1-3;
	$pdf->Cell(3);
    $pdf->Cell(5,$alto,utf8_decode($peso_bruto1));
	$pdf->Cell(25);
    $pdf->Cell(5,$alto,utf8_decode($peso_tara1));
	$pdf->Cell(21);
    $pdf->Cell(5,$alto,utf8_decode($dif));

$pdf->Ln(1);
}	
$pdf->Ln(1);	
	$pdf->Cell(10);
	$pdf->Cell(160, 0, '', 1, 1, 0, 'C', false );	
	$pdf->Ln(1);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(55);
    $pdf->Cell(5,4,utf8_decode('TOTALES'));
	$pdf->Cell(38);
    $pdf->Cell(5,4,utf8_decode($sum_bruto));
	$pdf->Cell(25);
    $pdf->Cell(5,4,utf8_decode($sum_tara));
	$pdf->Cell(21);
    $pdf->Cell(5,4,utf8_decode($sum_neto));
	$pdf->Ln(7);
	$pdf->Cell(35,40, $pdf->Image($direccion_graficaclisal, $pdf->GetX()+40, $pdf->GetY()+3, 115) ,0,"C");	
	
// TABLA PARA GRAFICO DETALLE POR SERVICIO
;
	$pdf->AddPage();
	$pdf->Ln(5);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10);
	$pdf->Cell(170,5,utf8_decode('RECEPCION DE GRANOS DEL SILO "'.$nom_sil.'" POR SERVICIOS'),0,0,'C',0);
	$pdf->Ln(5);
	$pdf->Cell(10);
    $pdf->Cell(170,5,utf8_decode('N°')."       ".utf8_decode('CODIGO')."         ".utf8_decode('     SERVICIOS   ')."                      ".utf8_decode('BRUTO (KG)')."         ".utf8_decode('TARA (KG)')."         ".utf8_decode('NETO (KG)'),0,0,'J',0);
	$pdf->Ln(5);	
	$pdf->Cell(10);
	$pdf->Cell(160, 0, '', 1, 1, 0, 'J', false );
	$pdf->SetFont('Times','',10);

$nu="0";	
$sum_bruto="0";
$sum_tara="0";
$sum_neto="0";
$consulta_ser_t = mysql_query("SELECT a.id_lote AS lote, a.id_servicio AS id_servicio, SUM(a.peso_bruto) as peso_bruto, SUM(a.peso_tara) AS peso_tara, b.nom_servicio FROM tab_almacenaje as a, tab_servicio as b WHERE id_silo='".$id_imagen."' AND a.id_servicio=b.id_servicio Group BY nom_servicio",$con);
while ($rowser_t = mysql_fetch_array($consulta_ser_t)) {
$nu++;	
$idcliente=$rowser_t['id_servicio'];
$nomcliente=$rowser_t['nom_servicio'];
$peso_bruto1=$rowser_t['peso_bruto'];
$peso_tara1=$rowser_t['peso_tara'];
$dif=$peso_bruto1-$peso_tara1;
$sum_bruto=$sum_bruto+$peso_bruto1;
$sum_tara=$sum_tara+$peso_tara1;
$sum_neto=$sum_neto+$dif;
$pdf->Ln(1);
$pdf->Cell(10);
$pdf->SetFont('Times','',10);	
    $pdf->Cell(5,4,utf8_decode($nu));
	$pdf->Cell(3);
    $pdf->Cell(5,4,utf8_decode($idcliente));
	$pdf->Cell(15);
	$x1 = $pdf->GetX();
    $pdf->Multicell(58,3,utf8_decode($nomcliente));	
	$y1 = $pdf->GetY();
	$posicionX = $x1 + 59; 
	$pdf->SetXY($posicionX,$y1);
	$y2 = $pdf->GetY();
	$alto = $y2-$y1-3;
	$pdf->Cell(1);
    $pdf->Cell(5,$alto,utf8_decode($peso_bruto1));
	$pdf->Cell(25);
    $pdf->Cell(5,$alto,utf8_decode($peso_tara1));
	$pdf->Cell(21);
    $pdf->Cell(5,$alto,utf8_decode($dif));

$pdf->Ln(1);
}	
$pdf->Ln(1);	
	$pdf->Cell(10);
	$pdf->Cell(160, 0, '', 1, 1, 0, 'C', false );	
	$pdf->Ln(1);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(55);
    $pdf->Cell(5,4,utf8_decode('TOTALES'));
	$pdf->Cell(38);
    $pdf->Cell(5,4,utf8_decode($sum_bruto));
	$pdf->Cell(25);
    $pdf->Cell(5,4,utf8_decode($sum_tara));
	$pdf->Cell(21);
    $pdf->Cell(5,4,utf8_decode($sum_neto));
	$pdf->Ln(7);
	$pdf->Cell(35,40, $pdf->Image($direccion_graficaserv, $pdf->GetX()+40, $pdf->GetY()+3, 115) ,0,"C");	
	

// KARDEX
	$pdf->AddPage();
	$pdf->Ln(5);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10);
	$pdf->Cell(170,5,utf8_decode('ENTRADAS Y SALIDAS DE GRANOS DEL SILO ' .$nom_sil),0,0,'C',0);
	$pdf->Ln(6);
	$pdf->Cell(5);
    $pdf->Cell(170,5,utf8_decode('')."       ".utf8_decode('')."                                                        ".utf8_decode('ENTRADA (KG)')."                                ".utf8_decode('SALIDA (KG)')."         ".utf8_decode(''),0,0,'J',0);
	$pdf->Ln(4);
	$pdf->Cell(3);
    $pdf->Cell(170,5,utf8_decode('N°')."     ".utf8_decode('FECHA')."     ".utf8_decode('CONCEPTO')."     ".utf8_decode('BRUTO')."      ".utf8_decode('TARA')."         ".utf8_decode('NETO')."           ".utf8_decode('BRUTO')."        ".utf8_decode('TARA')."           ".utf8_decode('NETO')."       ".utf8_decode('SALDO (KG)'),0,0,'J',0);
	$pdf->Ln(5);	
	$pdf->Cell(3);
	$pdf->Cell(188, 0, '', 1, 1, 0, 'J', false );
	$pdf->SetFont('Times','',10);

$nu="0";	
$sum_bruto_en="0";
$sum_tara_en="0";
$sum_neto_en="0";
$sum_bruto_sa="0";
$sum_tara_sa="0";
$sum_neto_sa="0";
$consulta_kardex = mysql_query("SELECT a.id_almacenaje as kardex_entra, a.id_salida as kardex_sal, a.fecha as kardex_fec, b.fecha_entrada as fecha_entrada, b.id_almacenaje as entrada, b.peso_bruto as p_bruto_ent, b.peso_tara as p_tara_ent, b.id_silo as silo_entrada, c.id_silo as silo_salida, c.fecha_entrada as fecha_salida, c.id_salida as salida, c.peso_bruto as p_bruto_sa, c.peso_tara as p_tara_sa FROM tab_kardex as a, tab_almacenaje as b, tab_salida as c WHERE a.id_almacenaje=b.id_almacenaje and a.id_salida=c.id_salida and (b.id_silo='".$id_imagen."' or c.id_silo='".$id_imagen."') order by a.fecha, a.hora",$con);
while ($rowkardex = mysql_fetch_array($consulta_kardex)) {
$nu++;	
$fecha=$rowkardex['kardex_fec'];
$bruto_en=$rowkardex['p_bruto_ent'];
$tara_en=$rowkardex['p_tara_ent'];
$neto_en=$bruto_en-$tara_en;
if($bruto_en==0){
	$bruto_en="";
	$concepto="SALIDA";
	}
if($tara_en==0){
	$tara_en="";
	}
if($neto_en==0){
	$neto_en="";

	}	

$bruto_sa=$rowkardex['p_bruto_sa'];
$tara_sa=$rowkardex['p_tara_sa'];
$neto_sa=$bruto_sa-$tara_sa;
if($bruto_sa==0){
	$bruto_sa="";
	$concepto="ENTRADA";	
	}
if($tara_sa==0){
	$tara_sa="";
	}
if($neto_sa==0){
	$neto_sa="";

	}		

$sum_bruto_en=$sum_bruto_en+$bruto_en;
$sum_tara_en=$sum_tara_en+$tara_en;
$sum_neto_en=$sum_neto_en+$neto_en;
$sum_bruto_sa=$sum_bruto_sa+$bruto_sa;
$sum_tara_sa=$sum_tara_sa+$tara_sa;
$sum_neto_sa=$sum_neto_sa+$neto_sa;

$saldo_kardex=$saldo_kardex+$neto_en-$neto_sa;	

$pdf->Ln(1);
$pdf->Cell(3);
$pdf->SetFont('Times','',10);	
    $pdf->Cell(5,4,utf8_decode($nu));
	$pdf->Cell(2);
    $pdf->Cell(5,4,utf8_decode(parseDatePhp($fecha)));
	$pdf->Cell(15);
    $pdf->Cell(5,4,utf8_decode(($concepto)));
	$pdf->Cell(19);
	$pdf->Cell(5,4,utf8_decode($bruto_en));
	$pdf->Cell(15);
	$pdf->Cell(5,4,utf8_decode($tara_en));
	$pdf->Cell(14);
	$pdf->Cell(5,4,utf8_decode($neto_en));
	$pdf->Cell(16);
	$pdf->Cell(5,4,utf8_decode($bruto_sa));
	$pdf->Cell(15);
	$pdf->Cell(5,4,utf8_decode($tara_sa));
	$pdf->Cell(15);
	$pdf->Cell(5,4,utf8_decode($neto_sa));
	$pdf->Cell(15);
	$pdf->Cell(5,4,utf8_decode($saldo_kardex));	
	

$pdf->Ln(3);
}	
$resta=$sum_neto_en-$sum_neto_sa;
$pdf->Ln(1);	
	$pdf->Cell(3);
	$pdf->Cell(188, 0, '', 1, 1, 0, 'J', false );	
	$pdf->Ln(1);
	$pdf->SetFont('Times','B',10);
	$pdf->Cell(10);
    $pdf->Cell(5,4,utf8_decode('TOTALES'));
	$pdf->Cell(38);
    $pdf->Cell(5,4,utf8_decode($sum_bruto_en));
	$pdf->Cell(15);
    $pdf->Cell(5,4,utf8_decode($sum_tara_en));
	$pdf->Cell(15);
    $pdf->Cell(5,4,utf8_decode($sum_neto_en));
	$pdf->Cell(15);
    $pdf->Cell(5,4,utf8_decode($sum_bruto_sa));
	$pdf->Cell(15);
    $pdf->Cell(5,4,utf8_decode($sum_tara_sa));
	$pdf->Cell(15);
    $pdf->Cell(5,4,utf8_decode($sum_neto_sa));
	$pdf->Cell(15);
    $pdf->Cell(5,4,utf8_decode($resta));
	$pdf->Ln(7);
	$pdf->Cell(35,40, $pdf->Image($direccion_graficakar, $pdf->GetX()+40, $pdf->GetY()+3, 115) ,0,"C");			
	$pdf->Output();
?>
<?PHP
mysql_query("DROP TABLE $tabla",$con);
mysql_query("DROP TABLE $tabla1",$con);
mysql_query("DROP TABLE $tabla2",$con);
?>