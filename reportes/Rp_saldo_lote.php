<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
  $estado= $_SESSION['bandera_empresa'];
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
  $nom_sistema=$_SESSION['nom_sistema'];
  

$fecha_inicio_buscar= parseDateMysql($_GET['id2']);
$fecha_fin_buscar= parseDateMysql($_GET['id3']);
$seleccion1= $_GET['id'];



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

	$cli=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente='$seleccion1'");
  	while($row_cli = mysql_fetch_array($cli)){
	$nom_cliente1=$row_cli['nom_cliente'];
	}
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
	$this->Cell(40,5,'SALDO POR LOTE ',0,0,'C');
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
	
	$this->Cell(40,5,'CLIENTE/EMPRESA:',0,0,'J');
    $this->SetFont('Arial','B',10);
	$this->Cell(5);
	$this->Cell(10,5,$nom_cliente1,0,0,'J');
	$this->SetFont('Arial','B',10);
	$this->Ln(10);
    $this->Cell(183,5,utf8_decode('Silo')."                ".utf8_decode('Lote')."       ".utf8_decode('Concepto')."         ".utf8_decode('N°')."        ".utf8_decode('Placa')."        ".utf8_decode('Entrada')."        ".utf8_decode('Salida')."          ".utf8_decode('Saldo')."          ".utf8_decode('Fecha')."           ".utf8_decode('Hora '),0,0,'J',0);
	$this->Ln(7);	
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

	
// MOSTRAR POR PRODUCTOS
$suma_total_entrada=0;
$suma_total_salida=0;
$transacciones=0;
$lotes_asig=0;
$acumulado=0;
$suma_saldo=0;
$result=mysql_query("SELECT a.id_kardex, a.id_almacenaje as kardex_entra, a.id_salida as kardex_sal, a.fecha as kardex_fec, a.hora as kardex_hor, b.fecha_entrada as fecha_entrada, b.id_almacenaje as entrada, (b.peso_bruto - b.peso_tara) as p_neto_entrada, b.id_cliente as id_cliente_ent, b.id_silo as silo_entrada, b.id_lote as id_lote_ent, c.id_silo as silo_salida, c.fecha_entrada as fecha_salida, c.id_salida as salida, (c.peso_bruto - c.peso_tara) as p_neto_salida, c.id_cliente as id_cliente_sal, c.id_lote as id_lote_sal, d.nom_cliente as cliente_entra, e.id_lote as id_lote, e.id_silo as id_silo,  f.placa_vehiculo FROM tab_kardex as a, tab_almacenaje as b, tab_salida as c, tab_cliente as d, tab_lote as e, tab_transportista as f WHERE a.id_almacenaje=b.id_almacenaje and a.id_salida=c.id_salida and (c.id_cliente=d.id_cliente or b.id_cliente=d.id_cliente) and (b.id_lote=e.id_lote or c.id_lote=e.id_lote) and (b.id_transportista=f.id_transportista or c.id_transportista= f.id_transportista) and (a.fecha>='$fecha_inicio_buscar' and a.fecha<='$fecha_fin_buscar')and (b.id_cliente='$seleccion1' or c.id_cliente='$seleccion1') and d.nom_cliente!='' and e.num_lote!='' and f.placa_vehiculo!='' group by id_lote ");
 while($row_datos = mysql_fetch_array($result)){
	 $id_silo1=$row_datos['id_silo'];
	 $id_lote1=$row_datos['id_lote'];
	 
	 $lote=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote1'");
    while($row_lote = mysql_fetch_array($lote)){
	  $capacidad_lote=$row_lote['cant_producto'];
	}
	
	

	$contador=0;
	$suma_entrada=0;
	$suma_salida=0;
	$saldo=0;
	

$reporte=mysql_query("SELECT a.id_kardex, a.id_almacenaje as kardex_entra, a.id_salida as kardex_sal, a.fecha as kardex_fec, a.hora as kardex_hor, b.fecha_entrada as fecha_entrada, b.id_almacenaje as entrada, (b.peso_bruto - b.peso_tara) as p_neto_entrada, b.id_cliente as id_cliente_ent, b.id_silo as silo_entrada, b.id_lote as id_lote_ent, c.id_silo as silo_salida, c.fecha_entrada as fecha_salida, c.id_salida as salida, (c.peso_bruto - c.peso_tara) as p_neto_salida, c.id_cliente as id_cliente_sal, c.id_lote as id_lote_sal, d.nom_cliente as cliente_entra, e.id_lote as id_lote, e.num_lote as num_lote, e.id_silo as id_silo, f.placa_vehiculo FROM tab_kardex as a, tab_almacenaje as b, tab_salida as c, tab_cliente as d, tab_lote as e, tab_transportista as f WHERE a.id_almacenaje=b.id_almacenaje and a.id_salida=c.id_salida and (c.id_cliente=d.id_cliente or b.id_cliente=d.id_cliente) and (b.id_lote=e.id_lote or c.id_lote=e.id_lote) and (b.id_transportista=f.id_transportista or c.id_transportista= f.id_transportista) and (a.fecha>='$fecha_inicio_buscar' and a.fecha<='$fecha_fin_buscar')and (b.id_cliente='$seleccion1' or c.id_cliente='$seleccion1') AND (b.bandera='2' OR c.bandera='2') and d.nom_cliente!='' and e.num_lote!='' and f.placa_vehiculo!='' and e.id_lote='$id_lote1' ORDER BY a.fecha ASC, a.hora ASC",$con);	
	 while($row_datos2 = mysql_fetch_array($reporte)){
		 $silo=mysql_query("SELECT * FROM tab_silo WHERE id_silo='$id_silo1'");
  		  while($row_silo = mysql_fetch_array($silo)){
	  		$nom_silo=$row_silo['nom_silo'];
			
			}
		//$id_transportista_con=$row_datos2['id_transportista'];
		$contador++;
		$entrada1=$row_datos2['num_lote'];
		$silo1=$nom_silo;
		$placa1=$row_datos2['placa_vehiculo'];
		$peso_entrada1=$row_datos2['p_neto_entrada'];
		$peso_salida1=$row_datos2['p_neto_salida'];
		$fecha1=$row_datos2['kardex_fec'];
		$hora1=$row_datos2['kardex_hor'];			
		$suma_entrada=$suma_entrada+$peso_entrada1;
		$suma_salida=$suma_salida+$peso_salida1;
		$saldo=$saldo+$peso_entrada1-$peso_salida1;	
		
		if($peso_entrada1=="0"){
			$peso_entrada1="";
			$concepto="SALIDA";
			}
		if($peso_salida1=="0"){
			$peso_salida1="";
			$concepto="ENTRADA";
			}			
		if($peso_entrada1=="" and $peso_salida1==""){
			$peso_entrada1="0";
			$peso_salida1="0";
			}	
		
	$pdf->Ln(1);
	$pdf->Cell(1);
	$pdf->SetFont('Arial','',10);	
    
//	$pdf->Cell(7);
	$x1 = $pdf->GetX();
    $pdf->Multicell(20,4,utf8_decode($silo1));
	$y1 = $pdf->GetY();
	$posicionX = $x1 + 12; 
	$pdf->SetXY($posicionX,$y1);
	$y2 = $pdf->GetY();
	$alto = $y2-$y1-3;
	$pdf->Cell(9);
	$pdf->Cell(5,$alto,utf8_decode($entrada1));
	$pdf->Cell(10);
	$pdf->Cell(5,$alto,utf8_decode($concepto));
	$pdf->Cell(20);
	$pdf->Cell(5,$alto,utf8_decode($contador));
	$pdf->Cell(2);
    $pdf->Cell(5,$alto,utf8_decode($placa1));
	$pdf->Cell(18);
	$pdf->Cell(5,$alto,utf8_decode($peso_entrada1));
	$pdf->Cell(16);
	$pdf->Cell(5,$alto,utf8_decode($peso_salida1));	
	$pdf->Cell(16);
	$pdf->Cell(5,$alto,utf8_decode($saldo));	
	$pdf->Cell(13);
    $pdf->Cell(5,$alto,utf8_decode(parseDatePhp($fecha1)));
	$pdf->Cell(17);
    $pdf->Cell(5,$alto,utf8_decode($hora1));
	$pdf->Ln(0);
   }
   //  SUMAR INVENTARIO SIN HUMEDAD
  $lot=mysql_query("SELECT * FROM tab_inventario WHERE id_lote='$id_lote1' and id_empresa='$id_empresa'");
	while($lot2 = mysql_fetch_array($lot)){
		$psinhumeda= $lot2['peso_sin_humedad'];
	 } 
   
  
   $reporte2=mysql_query("SELECT round(SUM(neto_sin_humedad),2) AS suma_sin_humedad FROM tab_almacenaje WHERE (fecha_entrada>='$fecha_inicio_buscar' and fecha_entrada<='$fecha_fin_buscar') and id_lote='$id_lote1' and id_silo='$id_silo1' and id_cliente='$seleccion1' AND bandera='2' and id_empresa='$id_empresa'",$con);	
	 while($row_datos22 = mysql_fetch_array($reporte2)){
		$sin_humedad= $row_datos22['suma_sin_humedad'];
	 }

	 
	 if ($psinhumeda<0)
	 {
		 $sin_humedad=$sin_humedad+($psinhumeda*-1);
	 }
	
	 
 $reporte3=mysql_query("SELECT round(SUM(peso_sin_humedad),2) AS suma_sin_humedad_sal FROM tab_salida WHERE (fecha_entrada>='$fecha_inicio_buscar' and fecha_entrada<='$fecha_fin_buscar') and id_lote='$id_lote1' and id_silo='$id_silo1' and id_cliente='$seleccion1' AND bandera='2' and id_empresa='$id_empresa'",$con);	
	 while($row_datos33 = mysql_fetch_array($reporte3)){
		$sin_humedad_sal= $row_datos33['suma_sin_humedad_sal'];
	 }	 
  
   $pdf->Ln(1);
   	$pdf->Cell(93);
	$pdf->Cell(98, 0, '', 1, 1, 0, 'J', false );	
	$pdf->Ln(2);
   	$pdf->Cell(1);
	$pdf->SetFont('Arial','B',10);	
	//$pdf->Cell(5,5,utf8_decode('Capacidad del Lote (KG)'));
	$pdf->Cell(38);	
	//$pdf->Cell(5,5,utf8_decode($capacidad_lote));
	$pdf->Cell(26);	
	$pdf->Cell(5,5,utf8_decode('Subtotal (KG)'));
	$pdf->Cell(22);	
	$pdf->Cell(5,5,utf8_decode($suma_entrada));
	$pdf->Cell(16);	
	$pdf->Cell(5,5,utf8_decode($suma_salida));
	$pdf->Cell(16);	
	$pdf->Cell(5,5,utf8_decode($suma_entrada-$suma_salida));
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',10);	
	//$pdf->Cell(5,5,utf8_decode('Capacidad del Lote (KG)'));
	$pdf->Cell(24);	
	//$pdf->Cell(5,5,utf8_decode($capacidad_lote));
	$pdf->Cell(26);	
	$pdf->Cell(5,5,utf8_decode('Subtotal sin Humedad'));
	$pdf->Cell(37);	
	$pdf->Cell(5,5,$sin_humedad);
	$pdf->Cell(16);	
	$pdf->Cell(5,5,$sin_humedad_sal);
	$pdf->Cell(16);	
	$pdf->Cell(5,5,($sin_humedad-$sin_humedad_sal));
	$pdf->Ln(5);
	$pdf->Cell(93);
	$pdf->Cell(52, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(4);
	$transacciones=	$transacciones+$contador;
	$suma_total_entrada=$suma_total_entrada+$suma_entrada;
	$suma_total_salida=$suma_total_salida+$suma_salida;
	$lotes_asig=$lotes_asig+1;
	$acumulado=$acumulado+$capacidad_lote;
	$suma_saldo=$suma_saldo+$suma_entrada-$suma_salida;
	$acumulado_sin_hum=$acumulado_sin_hum+$sin_humedad;
	$acu_sin_hum_sal=$acu_sin_hum_sal+$sin_humedad_sal;
  
} //FIN DE LA CONSULTA PRINCIPAL
	$pdf->Cell(1);
	$pdf->SetFont('Arial','B',10);	
	//$pdf->Cell(5,5,utf8_decode('Lotes'));
	$pdf->Cell(8);	
//	$pdf->Cell(5,5,utf8_decode($lotes_asig));
	$pdf->Cell(6);	
//	$pdf->Cell(5,5,utf8_decode('Capacidad'));
	$pdf->Cell(15);	
//	$pdf->Cell(5,5,utf8_decode($acumulado));
	$pdf->Cell(39);	
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Total (KG)'));
	$pdf->Cell(18);	
	$pdf->Cell(5,5,round($suma_total_entrada),2);
	$pdf->Cell(16);	
	$pdf->Cell(5,5,round($suma_total_salida),2);
	$pdf->Cell(16);	
	$pdf->Cell(5,5,round($suma_saldo),2);
	$pdf->Cell(15);
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Transacciones'));
	$pdf->Cell(25);	
	$pdf->Cell(5,5,utf8_decode($transacciones));
	$pdf->Ln(5);
	$pdf->Cell(1);
	$pdf->SetFont('Arial','B',10);	



	$pdf->Cell(46);	
	$pdf->SetFont('Arial','B',10);	
	$pdf->Cell(5,5,utf8_decode('Total sin Humedad(KG)'));
	$pdf->Cell(40);	
	$pdf->Cell(5,5,round($acumulado_sin_hum),2);
	$pdf->Cell(16);	
	$pdf->Cell(5,5,round($acu_sin_hum_sal),2);
	$pdf->Cell(16);	
	$pdf->Cell(5,5,round($acumulado_sin_hum-$acu_sin_hum_sal),2);
	$pdf->Cell(15);
	
	$pdf->Ln(5);
	$pdf->Cell(93);
	$pdf->Cell(52, 0, '', 1, 1, 0, 'J', false );
	$pdf->Ln(1);
	$pdf->Cell(93);
	$pdf->Cell(52, 0, '', 1, 1, 0, 'J', false );
	$pdf->Output();
?>
