<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece                        
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
//$id_despacho_buscar="ALMACEN-005";

//$fecha_inicio_buscar= '2017/03/27';
//$fecha_fin_buscar= '2017/03/29';
//$seleccion1= 'CLI-002';


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

$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");
	$this->Cell(1);
	$this->Rect(5,5,268,205);
    //Logo
	
	 //TITULO DEL REPORTE
 	$this->Ln(6);	 
	$this->Cell(100);
    $this->SetFont('Arial','B',15);
	$this->Cell(40,5,'REPORTE DE AGRICULTORES',0,0,'C');
	$this->Ln(6);
	$this->Cell(100);	
	$this->SetFont('Arial','',11);
	$this->Cell(40,5,'SAN CAYETANO ISTEPEQUE',0,0,'C');	
	
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
	
		$this->Ln(8);
	$this->SetFont('Arial','B',10);
	//$pdf->Cell(3);
    $this->Cell(190,5,utf8_decode('N°')."    ".utf8_decode('DUI')."                         ".utf8_decode('NOMBRE')."                                                                                      ".utf8_decode('SECTOR')."                                ".utf8_decode('OFICIO')."                         ".utf8_decode('TELEFONO')."   ".utf8_decode('AREA(MZ)'),0,0,'J',0);
	$this->Ln(7);	
	$this->Cell(1);
	$this->Cell(260, 0, '', 1, 1, 0, 'C', false );
	$this->Ln(2);
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
		 parent::__construct('L','mm','Letter');
      //  parent::__construct('P','mm','Letter');
    }
   
}

ob_end_clean();
$pdf=new PDF ();
//$pdf->SetTopMargin(5.4);
//$pdf->SetLeftMargin(4.5); 
$pdf->AliasNbPages();
$pdf->AddPage();
	
	 $seleccion1=$_GET['id']; 
               if($id_usuario!='USU-0351'){
               		if($seleccion1=="TODOS"){
 				$where1="id_empresa='$id_empresa' AND id_usuario_ingreso='$id_usuario'";
 			}else{
	 			$where1="zona='$seleccion1' AND id_usuario_ingreso='$id_usuario' AND id_empresa='$id_empresa' ";
	 		}
                   }else{
                   	if($seleccion1=="TODOS"){
 				$where1="id_empresa='$id_empresa'";
 			}else{
	 			$where1="zona='$seleccion1' AND id_empresa='$id_empresa' ";
	 		}
 
                 }
    /*             
	
	if($seleccion1=="TODOS"){
 $sql=mysql_query("SELECT * FROM tab_agricultor WHERE id_empresa='$id_empresa'");
 }else{
	 $sql=mysql_query("SELECT * FROM tab_agricultor WHERE zona='$seleccion1' and id_empresa='$id_empresa'");
	 }*/
 $sql=mysql_query("SELECT * FROM tab_agricultor where $where1");
 
 $conta=0;
	while($row_datos = mysql_fetch_array($sql)){
		$conta++;
	 $dui_agricultor=$row_datos['dui_agricultor'];
	 $nombre=$row_datos['nom_agricultor'].' '.$row_datos['ape_agricultor'];
	 $sector=$row_datos['zona'];
	 $oficio=$row_datos['oficio'];
	  $telefono=$row_datos['tel_agricultor'];
	  $area=$row_datos['area_cultiva'];
	$pdf->SetFont('Arial','',10);
	
	$pdf->Cell(1);
	$pdf->Cell(5,4,$conta);
	$pdf->Cell(3);
	$pdf->Cell(5,4,$dui_agricultor);
	$pdf->Cell(20);
	$pdf->Cell(100,4,utf8_decode($nombre));
	$pdf->Cell(5);
	$pdf->Cell(38,4,$sector);
	$pdf->Cell(8);
	$pdf->Cell(36,4,$oficio);
	$pdf->Cell(5);
	$pdf->Cell(15,4,$telefono);
	$pdf->Cell(10);
	$pdf->Cell(20,4,$area);
		
	$pdf->Ln(5);
}
	$pdf->Output();
?>
