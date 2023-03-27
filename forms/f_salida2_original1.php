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
    
 $peso_bruto_url1=$_GET['peso_bruto'];
  list($peso_bruto_url, $quitar) = split(' ', $peso_bruto_url1);
 $buscar_salida=$_GET['parametro'];
// $_SESSION['buscarrr']=$buscar_salida;

if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
$tabla="SELECT *  FROM tab_salida where id_salida='$buscar_salida' and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	
// EXTRAER DATOS PARA REALIZAR EL TARA
		 $id_salida1=$row['id_salida'];
		 $entrada1=$row['entrada'];
		 $id_cliente1=$row['id_cliente'];
		 $id_lote1=$row['id_lote'];	
		 $id_silo1=$row['id_silo'];
		 $id_servicio1=$row['id_servicio'];
		 $id_transportista1=$row['id_transportista'];
		 $fecha_entrada1=parseDatePhp($row['fecha_entrada']);
		 $hora_entrada1=$row['hora_entrada'];
		 $peso_tara1=$row['peso_tara'];
		 $peso_teorico1=$row['peso_teorico'];		 
	     $observacion1=$row['observacion'];
}	

$tabla2="SELECT *  FROM tab_cliente where id_cliente='$id_cliente1' and id_empresa='$id_empresa' and bandera=0";
$select2 = mysql_query($tabla2,$con);
while($row2 = mysql_fetch_array($select2))
{
	$nom_cliente1=$row2['nom_cliente'];
}
$tabla3="SELECT *  FROM tab_lote where id_lote='$id_lote1' and id_empresa='$id_empresa' and bandera=0";
$select3 = mysql_query($tabla3,$con);
while($row3 = mysql_fetch_array($select3))
{
	$num_lote1=$row3['num_lote'];
}
$tabla4="SELECT *  FROM tab_silo where id_silo='$id_silo1' and id_empresa='$id_empresa' and bandera=0";
$select4 = mysql_query($tabla4,$con);
while($row4 = mysql_fetch_array($select4))
{
	$nom_silo1=$row4['nom_silo'];
}
 
$tabla6="SELECT *  FROM tab_transportista where id_transportista='$id_transportista1' and id_empresa='$id_empresa'";
$select6 = mysql_query($tabla6,$con);
while($row6 = mysql_fetch_array($select6))
{
	$nom_transportista1=$row6['nom_transportista']." ".$row6['ape_transportista'];
} 

date_default_timezone_set("America/El_Salvador");
$ano=date('Y');
$fecha=date('d').'-'.date('m').'-'.date('Y');
$hora=date("H:i:s");
?>

<!DOCTYPE html> 
<html> 
<head> 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script language="javascript" type="text/javascript" src="../js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
</head> 
<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers"
	 });


     $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=09 && tecla.keyCode !=127 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
            });
		
});
</script>

<script type="text/javascript">
function guardar(){
		if(document.formulario.id_variable.value=="VAR-000"){
			document.formulario.variable.value="VAR-000";
		 }

		document.formulario.bandera.value='ok';
		document.formulario.submit();
			
}// fin guardar

function tara(cod){
		document.formulario.busca.value="tara";	
		document.formulario.cod_prod_modif.value=cod;
		document.formulario.action="http://localhost/bascula/?parametro="+cod+"&direccion=http://190.143.196.3/silos/forms/f_almacenaje2.php";//capturar el Tara.
		document.formulario.submit();
	} 

function cancelar(){
		document.location.href='f_salida_cola.php';	
	}
function activar_textos() //funcionar para activas las cajas de textos
  {
		if(document.formulario.disabled=!document.formulario.disabled){
			document.getElementById('formulario_responsable').style.display = 'block';//Mostrar contenido
			return;
  		}else{
			document.getElementById('formulario_responsable').style.display = 'none';//oculta contenido
			return;
		}
  }	


function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
 function datos(){
	 window.open('../reportes/Rp_despacho_vehiculo_lleno.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
	 if (window.confirm("Desea imprimir el informe de calidad?")) { 
 window.open('../reportes/Rp_despacho_calidad.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}	 
}
	
function validar_peso_bruto(str){
		   var a = str;
		 
		   if(parseFloat(document.formulario.peso_bruto.value) < parseFloat(document.formulario.peso_base_bruto.value))
		   {
			   alert('El Peso Tara no puede ser mayor que el Peso Bruto');
			   document.formulario.peso_bruto.value="";
			   document.formulario.peso_bruto.focus();
			  //return 0;
		   }
}	
</script>

<script type="text/javascript">
       $(document).ready(function() {
	  
		   $('#id_cliente2').change(function() {//inicio1
			 $.post('lote_select.php', {id_cliente_busca:document.formulario.id_cliente2.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
			
				$('#feedback2').load('select_silo.php').show();
				$('#id_lote2').change(function() {//inicio2
		   		$.post('select_silo.php', {id_lote_busca:document.formulario.id_lote2.value}, 
			 	function(result) {
				$('#feedback2').html(result).show();
				
						//$('#feedback3').load('select_servicio.php').show();
						$('#id_silo2').change(function() {//inicio3
						$.post('select_servicio.php', {id_lote_busca:document.formulario.id_lote2.value, id_cliente_busca:document.formulario.id_cliente2.value}, 
						function(result) {
						$('#feedback3').html(result).show();	
						
						
								//$('#feedback3').load('select_servicio.php').show();
								$('#id_servicio2').change(function() {//inicio4
								$.post('piloto_select.php', {id_servicio_busca:document.formulario.id_servicio2.value, id_cliente_busca:document.formulario.id_cliente2.value}, 
								function(result) {
								$('#feedback4').html(result).show();																					 
									}); 									 
								});//fin4
																												 
							}); 									 
						});//fin3	
						
																														 
					}); 									 
				});//fin2
				
				 }); 									 
		  });//fin1
		 		  
       });

	  // FUNCION PARA ENVIAR LAS ALERTAS COMPARANDO LAS VARIABLES 
	   function validar_peso(str){
		   var a = str;
		 
		   if(parseFloat(document.formulario.peso_vol.value) > parseFloat(document.formulario.peso_base.value) && document.formulario.pasa1.value==0)
		   {
			   alert('El Peso Volumetrico ingresado es mayor a lo permitido');
			   document.formulario.pasa1.value=1;
			   //return 0;
		   }
		    
		   if(parseFloat(document.formulario.humedad.value) > parseFloat(document.formulario.humedad_base.value) && document.formulario.pasa2.value==0)
		   {
			    alert('La humedad ingresada es mayor a lo permitido');
 			    document.formulario.pasa2.value=1;
				return;

		   }
		   if(parseFloat(document.formulario.temperatura.value) > parseFloat(document.formulario.temperatura_base.value) && document.formulario.pasa3.value==0)
		   {
			    alert('La Temperatura ingresada es mayor a lo permitido');
			   document.formulario.pasa3.value=1;				
				return;
		   }

		   if(parseFloat(document.formulario.grano_entero.value) > parseFloat(document.formulario.grano_entero_base.value) && document.formulario.pasa4.value==0)
		   {
			    alert('El porcentaje de Grano entero ingresado es mayor a lo permitido');
			   document.formulario.pasa4.value=1;				
				return;
		   }
 		 if(parseFloat(document.formulario.grano_quebrado.value) > parseFloat(document.formulario.grano_quebrado_base.value) && document.formulario.pasa5.value==0)
		   {
			    alert('El porcentaje de Grano quebrado ingresado es mayor a lo permitido');
			   document.formulario.pasa5.value=1;				
				return;
		   }
			if(parseFloat(document.formulario.dan_hongo.value) > parseFloat(document.formulario.dan_hongo_base.value) && document.formulario.pasa6.value==0)
		   {
			    alert('El porcentaje de daño por hongo ingresado es mayor a lo permitido');
			   document.formulario.pasa6.value=1;				
				return;
		   }
		   if(parseFloat(document.formulario.impureza.value) > parseFloat(document.formulario.impureza_base.value) && document.formulario.pasa7.value==0)
		   {
			    alert('El porcentaje de impureza ingresado es mayor a lo permitido');
			   document.formulario.pasa7.value=1;				
				return;
		   }	
 			if(parseFloat(document.formulario.grano_chico.value) > parseFloat(document.formulario.grano_chico_base.value) && document.formulario.pasa8.value==0)
		   {
			    alert('El porcentaje de grano chico ingresado es mayor a lo permitido');
			   document.formulario.pasa8.value=1;				
				return;
		   }		  
		   if(parseFloat(document.formulario.grano_picado.value) > parseFloat(document.formulario.grano_picado_base.value) && document.formulario.pasa9.value==0)
		   {
			    alert('El porcentaje de grano picado ingresado es mayor a lo permitido');
			   document.formulario.pasa9.value=1;				
				return;
		   }	
		   if(parseFloat(document.formulario.plaga_viva.value) > parseFloat(document.formulario.plaga_viva_base.value) && document.formulario.pasa10.value==0)
		   {
			    alert('El porcentaje de plaga viva ingresado es mayor a lo permitido');
			   document.formulario.pasa10.value=1;				
				return;
		   }
		   if(parseFloat(document.formulario.plaga_muerta.value) > parseFloat(document.formulario.plaga_muerta_base.value) && document.formulario.pasa11.value==0)
		   {
			    alert('El porcentaje de plaga muerta ingresado es mayor a lo permitido');
			   document.formulario.pasa11.value=1;				
				return;
		   }
		   if(parseFloat(document.formulario.stress_crack.value) > parseFloat(document.formulario.stress_crack_base.value)&& document.formulario.pasa12.value==0)
		   {
			    alert('El porcentaje de Stress Crack ingresado es mayor a lo permitido');
			   document.formulario.pasa12.value=1;				
				return;
		   }				   	   		   		   
		   
	   }
</script>
  
<?php // cierre de sesion por medio del boton
	 $bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
       echo "document.location.href='sesion_destruida.php';";
	}//Fin if bandera ok
	 echo "</script>";
?>

 <?php
 $bandera = $_POST['bandera'];
 $variable_mostrar = $_POST['variable'];
	 		
 if($bandera=="ok")
   {//inicio if bandera ok
   // INICIA EL GUARDADO DE INFORMACION 
  $cod2=$_POST['transaccion1'];
  $_SESSION['buscarrr']=$cod2;
  

 if($variable_mostrar=="VAR-000"){
	         $_POST['id_variable']="VAR-0001";
			 }else{
			 $id_variable1=$_POST['id_variable'];	 
				 }
		 
		// $entrada;

		 $id_cliente1=$_POST['id_cliente2'];
		 
		 $nom_lote1=$_POST['num_lote'];		
		 $nom_silo1=$_POST['nom_silo'];	
		 $id_servicio1=$_POST['id_servicio2'];	
		 $fecha_entrada1=parseDateMysql($_POST['fecha_entrada']);
		 $hora_entrada1=$_POST['hora_entrada'];	
		 $fecha_salida1=parseDateMysql($_POST['fecha_salida']);
		 $hora_salida1=$_POST['hora_salida'];
		  if($_POST['peso_teorico']==""){$peso_teorico1="0.00";}else{$peso_teorico1=$_POST['peso_teorico'];}
	 	$tipo_peso1=$_POST['tipo_peso'];	
	 	if($_POST['peso_bruto']==""){$peso_bruto1="0.00";}else {$peso_bruto1=$_POST['peso_bruto'];}
		//$peso_bruto1=$_POST['peso_bruto'];	
		if($_POST['peso_tara']==""){$peso_tara1="0.00";}else {$peso_tara1=$_POST['peso_tara'];}	 	 	 	
		// $peso_tara1=$_POST['peso_tara'];
		 $id_variable1=$_POST['id_variable'];
		 if($_POST['peso_vol']==""){$peso_vol1="0.00";}else {$peso_vol1=$_POST['peso_vol'];}	 	 	 	
 		// $peso_vol1=$_POST['peso_vol'];
 		 if($_POST['humedad']==""){$humedad1="0.00";}else {$humedad1=$_POST['humedad'];}	 	 	 	
		// $humedad1=$_POST['humedad'];
		 if($_POST['temperatura']==""){$temperatura1="0.00";}else {$temperatura1=$_POST['temperatura'];}	 	 	 	
		// $temperatura1=$_POST['temperatura'];
		 if($_POST['grano_entero']==""){$grano_entero1="0.00";}else {$grano_entero1=$_POST['grano_entero'];}	 	 	 	
		//$grano_entero1=$_POST['grano_entero'];
		 if($_POST['grano_quebrado']==""){$grano_quebrado1="0.00";}else {$grano_quebrado1=$_POST['grano_quebrado'];}	 	 	 	
		// $grano_quebrado1=$_POST['grano_quebrado'];
		 if($_POST['dan_hongo']==""){$dan_hongo1="0.00";}else {$dan_hongo1=$_POST['dan_hongo'];}	 	 	 	
		// $dan_hongo1=$_POST['dan_hongo'];
		 if($_POST['impureza']==""){$impureza1="0.00";}else {$impureza1=$_POST['impureza'];}	 	 	 	
		// $impureza1=$_POST['impureza'];
		 if($_POST['grano_chico']==""){$grano_chico1="0.00";}else {$grano_chico1=$_POST['grano_chico'];}	 	 	 	
		// $grano_chico1=$_POST['grano_chico'];
		 if($_POST['grano_picado']==""){$grano_picado1="0.00";}else {$grano_picado1=$_POST['grano_picado'];}	 	 	 	
		// $grano_picado1=$_POST['grano_picado'];
		 if($_POST['plaga_viva']==""){$plaga_viva1="0.00";}else {$plaga_viva1=$_POST['plaga_viva'];}	 	 	 	
		// $plaga_viva1=$_POST['plaga_viva'];
		 if($_POST['plaga_muerta']==""){$plaga_muerta1="0.00";}else {$plaga_muerta1=$_POST['plaga_muerta'];}	 	 	 	
		// $plaga_muerta1=$_POST['plaga_muerta'];
		 if($_POST['stress_crack']==""){$stress_crack1="0.00";}else {$stress_crack1=$_POST['stress_crack'];}	 	 	 	
		 //$stress_crack1=$_POST['stress_crack'];
		 
		 
		 
		 /*
		 $peso_teorico1=$_POST['peso_teorico'];	
		 $tipo_peso1=$_POST['tipo_peso'];	
		 $peso_bruto1=$_POST['peso_bruto'];		 	 	 	
		 $peso_tara1=$_POST['peso_tara'];
		 $id_variable1=$_POST['id_variable'];
 		 $peso_vol1=$_POST['peso_vol'];
		 $humedad1=$_POST['humedad'];
		 $temperatura1=$_POST['temperatura'];
		 $grano_entero1=$_POST['grano_entero'];
		 $grano_quebrado1=$_POST['grano_quebrado'];
		 $dan_hongo1=$_POST['dan_hongo'];
		 $impureza1=$_POST['impureza'];
		 $grano_chico1=$_POST['grano_chico'];
		 $grano_picado1=$_POST['grano_picado'];
		 $plaga_viva1=$_POST['plaga_viva'];
		 $plaga_muerta1=$_POST['plaga_muerta'];
		 $stress_crack1	=$_POST['stress_crack'];*/
		 
		 $olor1=strtoupper($_POST['olor']);
		 $observacion2=strtoupper($_POST['observacion']);
		 $vapor1=strtoupper($_POST['vapor']);
		 $nom_analista1=strtoupper($_POST['nom_analista']);		
		 $_SESSION['taraaa']=$_POST['peso_tara'];
		 $_SESSION['pesoooo']=$_POST['peso_bruto'];		 	 	 	 	
		 $_SESSION['fec_salida']=$fecha_salida1;
		 $_SESSION['hor_salida']=$hora_salida1;	
		 $_SESSION['variable2']=$id_variable1;
		 $_SESSION['peso_vol2']=$peso_vol1;
		 $_SESSION['humedad2']=$humedad1;
		 $_SESSION['temperatura2']=$temperatura1;
		 $_SESSION['grano_entero2']=$grano_entero1;
		 $_SESSION['grano_quebrado2']=$grano_quebrado1;
		 $_SESSION['dan_hongo2']=$dan_hongo1;
		 $_SESSION['impureza2']=$impureza1;		 		 		 		 				 		 			 
		 $_SESSION['grano_chico2']=$grano_chico1;
		 $_SESSION['grano_picado2']=$grano_picado1;
		 $_SESSION['plaga_viva2']=$plaga_viva1;
		 $_SESSION['plaga_muerta2']=$plaga_muerta1;
		 $_SESSION['stress_crack2']=$stress_crack1;
		 $_SESSION['olor2']=$olor1;
		 $_SESSION['observacion2']=$observacion1;
		 $_SESSION['vapor2']=$vapor1;
		 $_SESSION['nom_analista2']=$nom_analista1;	
				 	 		 		 		 		 		 		 		 		 
$tabla8="SELECT * FROM tab_lote where num_lote='$nom_lote1'";
$datos = mysql_query($tabla8,$con);
while($row8 = mysql_fetch_array($datos))
{
	$id_lote2=$row8['id_lote'];
    $_SESSION['id_lote2']=$id_lote2;
} 		 
	
$tabla9="SELECT * FROM tab_silo where nom_silo='$nom_silo1'";
$datos2 = mysql_query($tabla9,$con);
while($row9 = mysql_fetch_array($datos2))
{
	$id_silo2=$row9['id_silo'];
}			
 
   //VERIFICAR CANTIDAD DE PRODUCTO EN ALMACEN  PESO BRUTO 
   //(1)  QUITAR EN CASO QUE SEA EL PRODUCTO NETO CON HUMEDAD
//$suma_lote=mysql_query("SELECT (round(SUM(peso_bruto),2)- round(SUM(peso_tara),2)) AS suma_peso FROM `tab_almacenaje` WHERE id_silo='$id_silo2' and id_lote='$id_lote2'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO (1)
//$row_suma = mysql_fetch_assoc($suma_lote); // (1)
//$acumulado_lote=$row_suma['suma_peso']; //(1)

$suma_lote_humedad=mysql_query("SELECT round(SUM(neto_sin_humedad),2) AS suma_peso_humedad, round(SUM(neto_sin_humedad_maximo)) AS humedad_maximo FROM `tab_almacenaje` WHERE id_silo='$id_silo2' and id_lote='$id_lote2'");
$row_suma_humedad = mysql_fetch_assoc($suma_lote_humedad);
$acumulado_lote_humedad=$row_suma_humedad['suma_peso_humedad'];
$acumulado_maximo_humedad=$row_suma_humedad['humedad_maximo'];

//VERIFICAR CANTIDAD DE PRODUCTO DESPACHADO (1)
//$suma_lote2=mysql_query("SELECT (round(SUM(peso_bruto),2)- round(SUM(peso_tara),2)) AS suma_peso2 FROM `tab_salida` WHERE id_silo='$id_silo2' and id_lote='$id_lote2' and bandera=2",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO
//$row_suma2 = mysql_fetch_assoc($suma_lote2);
//$acumulado_lote2=$row_suma2['suma_peso2'];
$string_salida = mysql_query("SELECT COUNT(*) AS num FROM tab_salida WHERE id_silo='$id_silo2' and id_lote='$id_lote2' and bandera=2 and id_empresa='$id_empresa';") or die(mysql_error());
$rs_salida2 = mysql_fetch_array($string_salida);
if(!empty($rs_salida2['num'])){
	$suma_lote_humedad2=mysql_query("SELECT round(SUM(peso_sin_humedad),2) AS suma_peso_humedad2 FROM `tab_salida` WHERE id_silo='$id_silo2' and id_lote='$id_lote2' and bandera=2 and id_empresa='$id_empresa'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO
	$row_suma_humedad2 = mysql_fetch_assoc($suma_lote_humedad2);
	$acumulado_lote_humedad2=$row_suma_humedad2['suma_peso_humedad2'];
	}else{
	$acumulado_lote_humedad2=0;
		 }

// (1) PESO NETO CON HUMEDAD
//$resta1=$acumulado_lote-$acumulado_lote2; (1)
//$neto=$peso_bruto1-$peso_tara1; (1)
 //$espacio_lote=$resta1-$peso_bruto1; (1)
 //$espacio_lote=$resta1-$neto; (1)

 $resta1=$acumulado_lote_humedad-$acumulado_lote_humedad2;

// (1) PESO CON HUMEDAD
// $resta_humedad1=$acumulado_lote_humedad-$acumulado_lote_humedad2; (1)
 //$espacio_lote_humedad=$resta_humedad1-$peso_bruto1; (1)
 //$espacio_lote_humedad2=$espacio_lote_humedad+($espacio_lote_humedad*0.05); (1)

// ALMACENAR EN INVENTARIO  esto es sin humedad
   $tabla_inve="SELECT *  FROM tab_inventario where id_lote='$id_lote2'";
	$select_inve = mysql_query($tabla_inve,$con);
	while($row_inve = mysql_fetch_array($select_inve))
	{
	 $cantidad_almacenada=$row_inve['movimiento_lote'];
	 $cantidad_almacenada_humedad=$row_inve['peso_sin_humedad'];
	 $cantidad_maxima=$row_inve['peso_sin_humedad_maximo'];
	}	 
    $peso_inve=$peso_bruto1-$peso_tara1;	 
	$peso_bruto_inv=$cantidad_almacenada-$peso_inve;
	$cantidad_sin_humedad=$cantidad_almacenada_humedad-$peso_inve;
	$cantidad_sin_humedad_maxima2=$cantidad_maxima-$peso_inve;
	$dato_retitar=$cantidad_maxima;

  	$pneto= $peso_bruto1-$peso_tara1;
   	$espacio_lote=$cantidad_maxima-$pneto;
	$calculo2=$pneto+($pneto*0.005);
	$pneto_sin_humedad=$resta1-$calculo2; // agregar porcentaje adicional
if($calculo2<=$resta1){ // VALIDACION 
	$paso=1; // Indica que el peso a retirar  no supera la existencia
	
/*	echo "<script> alert('peso neto  es menor que sin humedad'); </script>";  */

	}else{
		if($espacio_lote<0){
			$guarda="3";
			}else{
			$paso="2"; // indica que necesita contraseña para validar el paso.		
/*		echo "<script> alert('peso neto  es mayor que sin humedad entra'); </script>"; */
				}
			}

 if($paso=="2"){ // solicitar contraseña 
 		if($acumulado_maximo_humedad<=$calculo2){
			$guarda="101"; // mensaje que indica que la salida es mayor al inventario seco
			}else {
			$guarda="201"; // llamar el modal
			}

	}	
	

if($espacio_lote>="0" and $paso=="1"){ // Verifica si hay productos
if(isset($cod2)){
$sql= ("UPDATE `tab_salida` SET `fecha_salida`='$fecha_salida1',`hora_salida`='$hora_salida1', `tipo_peso` ='1',  `peso_bruto`='$peso_bruto1', `id_variable`='$id_variable1', `peso_vol`='$peso_vol1', `humedad`='$humedad1',  `temperatura`='$temperatura1', `grano_entero`='$grano_entero1', `grano_quebrado`='$grano_quebrado1', `dan_hongo`='$dan_hongo1', `impureza`='$impureza1', `grano_chico`='$grano_chico1', `grano_picado`='$grano_picado1', `plaga_viva`='$plaga_viva1', `plaga_muerta`='$plaga_muerta1', `stress_crack`='$stress_crack1', `olor`='$olor1', `observacion`='$observacion2', `bandera`='2',   `vapor`='$vapor1', `nom_analista`='$nom_analista1', `peso_sin_humedad`='$pneto' WHERE id_salida='$cod2'");

$sql_inv= ("UPDATE `tab_inventario` SET `movimiento_lote`='$peso_bruto_inv', peso_sin_humedad='$cantidad_sin_humedad', peso_sin_humedad_maximo='$cantidad_sin_humedad_maxima2' WHERE id_lote='$id_lote2'");
				   	mysql_query($sql,$con);
				   	mysql_query($sql_inv,$con);		
					mysql_query($sql,$con);
		 
					  if(mysql_error())
					  { 
						$guarda="1";
					  }
					  else
					  	 mysql_query($sql,$con);
						  $guarda="2";
		 }
}else{
		if($guarda=="201"){
			$guarda="202";

			}else{	
			$guarda="3";
			}
	}
   }//fin bandera ok	
	
?>  

<?PHP
	$bandera_eli = $_POST['bandera_eliminar'];
	if($bandera_eli=="ok"){
	 $nombre_usuario=$_POST['nombre_usuario'];
	 $con_usuario=md5($_POST['con_usuario']);
	 $activo="1";
	 $empresa=$id_empresa;
	 $nivel="NIV-0031";

$resultado = autorizar_su($nombre_usuario,$con_usuario,$activo,$empresa,$nivel);	
if($resultado=="1"){
		$guarda="400"; // Guarda
	}else{
		$guarda="301"; // no posee permisos
		}
	}
	
?>
 
<body class="container" <?PHP if($guarda == "2") echo "onload='datos()';"; ?> > 

<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->

<?PHP include("menu.php"); ?>


<!-----fin menu ---->
<!-----fin menu ---->
<!-----fin menu ---->
<!-----fin menu ---->




<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<br><br><br><br>
  <?PHP 
if($guarda=="1"){
unset($_SESSION['pesoooo']);
unset($_SESSION['taraaa']);
unset($_SESSION['fec_salida']);
unset($_SESSION['hor_salida']);
unset($_SESSION['variable2']);
unset($_SESSION['peso_vol2']);
unset($_SESSION['humedad2']);
unset($_SESSION['temperatura2']);
unset($_SESSION['grano_entero2']);
unset($_SESSION['grano_quebrado2']);
unset($_SESSION['dan_hongo2']);
unset($_SESSION['impureza2']);		 		 		 		 				 		 			 
unset($_SESSION['grano_chico2']);
unset($_SESSION['grano_picado2']);
unset($_SESSION['plaga_viva2']);
unset($_SESSION['plaga_muerta2']);
unset($_SESSION['stress_crack2']);
unset($_SESSION['olor2']);
unset($_SESSION['observacion2']);
unset($_SESSION['vapor2']);
unset($_SESSION['nom_analista2']);
unset($_SESSION['id_lote2']);
	echo '<div class="alert alert-danger">
 		 <a href="f_salida_cola.php" class="alert-link"> Error en el procesamiento de datos!!! Haga click para continuar .....</a>
			</div>';
	}
 if($guarda == "2")
 {
unset($_SESSION['pesoooo']);
unset($_SESSION['taraaa']);
unset($_SESSION['fec_salida']);
unset($_SESSION['hor_salida']);
unset($_SESSION['variable2']);
unset($_SESSION['peso_vol2']);
unset($_SESSION['humedad2']);
unset($_SESSION['temperatura2']);
unset($_SESSION['grano_entero2']);
unset($_SESSION['grano_quebrado2']);
unset($_SESSION['dan_hongo2']);
unset($_SESSION['impureza2']);		 		 		 		 				 		 			 
unset($_SESSION['grano_chico2']);
unset($_SESSION['grano_picado2']);
unset($_SESSION['plaga_viva2']);
unset($_SESSION['plaga_muerta2']);
unset($_SESSION['stress_crack2']);
unset($_SESSION['olor2']);
unset($_SESSION['observacion2']);
unset($_SESSION['vapor2']);
unset($_SESSION['nom_analista2']);
unset($_SESSION['id_lote2']);
 echo '<div class="alert alert-success">
 		<a href="f_salida_cola.php" class="alert-link">Datos almacenados con éxito, cuenta con una existencia de  '.$espacio_lote.' Kilogramos. en el Silo '.$nom_silo1.', lote '.$nom_lote1.'   !!! Haga click para continuar .....</a>
		</div>';
}
 if($guarda == "3")
 {
unset($_SESSION['pesoooo']);
unset($_SESSION['taraaa']);	 
unset($_SESSION['fec_salida']);
unset($_SESSION['hor_salida']);
unset($_SESSION['variable2']);
unset($_SESSION['peso_vol2']);
unset($_SESSION['humedad2']);
unset($_SESSION['temperatura2']);
unset($_SESSION['grano_entero2']);
unset($_SESSION['grano_quebrado2']);
unset($_SESSION['dan_hongo2']);
unset($_SESSION['impureza2']);		 		 		 		 				 		 			 
unset($_SESSION['grano_chico2']);
unset($_SESSION['grano_picado2']);
unset($_SESSION['plaga_viva2']);
unset($_SESSION['plaga_muerta2']);
unset($_SESSION['stress_crack2']);
unset($_SESSION['olor2']);
unset($_SESSION['observacion2']);
unset($_SESSION['vapor2']);
unset($_SESSION['nom_analista2']);
unset($_SESSION['id_lote2']);
	echo '<div class="alert alert-success">
	<a href="f_salida_cola.php" class="alert-link">Registro no Almacenado, El Lote '.$nom_lote1.' es sobregirado en '.(-1)*($espacio_lote).', solo posee '.$dato_retitar.' Kilogramos. !!! Haga click para continuar .....</a>
						  </div>';
}

if($guarda == "4")
 {
unset($_SESSION['pesoooo']);
unset($_SESSION['taraaa']);
unset($_SESSION['fec_salida']);
unset($_SESSION['hor_salida']);
unset($_SESSION['variable2']);
unset($_SESSION['peso_vol2']);
unset($_SESSION['humedad2']);
unset($_SESSION['temperatura2']);
unset($_SESSION['grano_entero2']);
unset($_SESSION['grano_quebrado2']);
unset($_SESSION['dan_hongo2']);
unset($_SESSION['impureza2']);		 		 		 		 				 		 			 
unset($_SESSION['grano_chico2']);
unset($_SESSION['grano_picado2']);
unset($_SESSION['plaga_viva2']);
unset($_SESSION['plaga_muerta2']);
unset($_SESSION['stress_crack2']);
unset($_SESSION['olor2']);
unset($_SESSION['observacion2']);
unset($_SESSION['vapor2']);
unset($_SESSION['nom_analista2']);
unset($_SESSION['id_lote2']);
	echo '<div class="alert alert-success">
	<a href="f_salida_cola.php" class="alert-link">Sobrepasa  Kilogramos. !!! Haga click para continuar .....</a>
						  </div>';
}

if($guarda == "202")
 {
	$mostrar="1"; 
	echo '<div class="alert alert-success">
	<a  data-toggle="modal" data-target="#ventana4" class="alert-link">Necesita autorización para procesar el despacho de productos !!! Haga click para continuar .....</a> </div>';

}

if($guarda == "301") // No posee permisos
 {
	$mostrar="1"; 
	echo '<div class="alert alert-warning alert-dismissable">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
  	<strong>¡Advertencia!</strong> No posee permisos para realizar el despacho del producto.
	</div>';

}
if($guarda == "400") // Pide contraseña y pasa el filtro
 {
	$mostrar="2"; // llamar a almacenamiento 

}
if($guarda == 101) // El inventario es menos
 {
	$mostrar="1"; 
	echo '<div class="alert alert-warning alert-dismissable">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
  	<strong>¡Advertencia!</strong> La cantidad de producto a retirar es mayor al inventario.
	</div>';

}

if ($mostrar=="1"){
$buscar_salida2=$_SESSION['buscarrr'];
$peso_bruto_url=$_SESSION['pesoooo'];
$tabla="SELECT *  FROM tab_salida where id_salida='$buscar_salida2' and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	
// EXTRAER DATOS PARA REALIZAR EL TARA
		 $id_salida1=$row['id_salida'];
		 $entrada1=$row['entrada'];
		 $id_cliente1=$row['id_cliente'];
		 $id_lote1=$row['id_lote'];	
		 $id_lote2=$id_lote1;
		 $id_silo1=$row['id_silo'];
		 $id_servicio1=$row['id_servicio'];
		 $id_transportista1=$row['id_transportista'];
		 $fecha_entrada1=parseDatePhp($row['fecha_entrada']);
		 $hora_entrada1=$row['hora_entrada'];
		 $peso_tara1=$row['peso_tara'];
		 $peso_teorico1=$row['peso_teorico'];		 
	     $observacion1=$row['observacion'];
}	 
$tabla2="SELECT *  FROM tab_cliente where id_cliente='$id_cliente1' and id_empresa='$id_empresa' and bandera=0";
$select2 = mysql_query($tabla2,$con);
while($row2 = mysql_fetch_array($select2))
{
	$nom_cliente1=$row2['nom_cliente'];
}
$tabla3="SELECT *  FROM tab_lote where id_lote='$id_lote1' and id_empresa='$id_empresa' and bandera=0";
$select3 = mysql_query($tabla3,$con);
while($row3 = mysql_fetch_array($select3))
{
	$num_lote1=$row3['num_lote'];
}
$tabla4="SELECT *  FROM tab_silo where id_silo='$id_silo1' and id_empresa='$id_empresa' and bandera=0";
$select4 = mysql_query($tabla4,$con);
while($row4 = mysql_fetch_array($select4))
{
	$nom_silo1=$row4['nom_silo'];
}
$tabla5="SELECT *  FROM tab_servicio where id_servicio='$id_servicio1' and id_empresa='$id_empresa' and bandera=0";
$select5 = mysql_query($tabla5,$con);
while($row5 = mysql_fetch_array($select5))
{
	$nom_servicio1=$row5['nom_servicio'];
} 
$tabla6="SELECT *  FROM tab_transportista where id_transportista='$id_transportista1' and id_empresa='$id_empresa'";
$select6 = mysql_query($tabla6,$con);
while($row6 = mysql_fetch_array($select6))
{
	$nom_transportista1=$row6['nom_transportista']." ".$row6['ape_transportista'];
} 
}

if($mostrar=="2"){
 // INICIA EL GUARDADO DE INFORMACION 
		 $peso_bruto1=$_SESSION['pesoooo'];
 		 $peso_tara1=$_SESSION['taraaa'];
         $cod2=$_SESSION['buscarrr'];
  		 $fecha_salida1=$_SESSION['fec_salida'];
		 $hora_salida1= $_SESSION['hor_salida'];
		 $peso_teorico1=$_POST['peso_teorico'];	
		 $id_variable1=$_SESSION['variable2'];
		 $peso_vol1=$_SESSION['peso_vol2'];
		 $humedad1=$_SESSION['humedad2'];
		 $temperatura1=$_SESSION['temperatura2'];
		 $grano_entero1=$_SESSION['grano_entero2'];
		 $grano_quebrado1=$_SESSION['grano_quebrado2'];
		 $dan_hongo1=$_SESSION['dan_hongo2'];
		 $impureza1=$_SESSION['impureza2'];		 		 		 		 				 		 			 
		 $grano_chico1=$_SESSION['grano_chico2'];
		 $grano_picado1=$_SESSION['grano_picado2'];
		 $plaga_viva1=$_SESSION['plaga_viva2'];
		 $plaga_muerta1=$_SESSION['plaga_muerta2'];
		 $stress_crack1=$_SESSION['stress_crack2'];
		 $olor1=$_SESSION['olor2'];
		 $observacion1=$_SESSION['observacion2'];
		 $vapor1=$_SESSION['vapor2'];
		 $nom_analista1=$_SESSION['nom_analista2'];
		 $id_lote2=$_SESSION['id_lote2'];

  $tabla_inve="SELECT *  FROM tab_inventario where id_lote='$id_lote2'";
	$select_inve = mysql_query($tabla_inve,$con);
	while($row_inve = mysql_fetch_array($select_inve))
	{
	 $cantidad_almacenada=$row_inve['movimiento_lote'];
	 $cantidad_almacenada_humedad=$row_inve['peso_sin_humedad'];
	 $cantidad_maxima=$row_inve['peso_sin_humedad_maximo'];
	}	 
    $peso_inve=$peso_bruto1-$peso_tara1;	 
	$peso_bruto_inv=$cantidad_almacenada-$peso_inve;
	$cantidad_sin_humedad=$cantidad_almacenada_humedad-$peso_inve;
	$cantidad_sin_humedad_maxima2=$cantidad_maxima-$peso_inve;		 		 		 		 		 		 		
														 		 		 		 
	$sql= ("UPDATE `tab_salida` SET `fecha_salida`='$fecha_salida1',`hora_salida`='$hora_salida1', `tipo_peso` ='1',  `peso_bruto`='$peso_bruto1', `id_variable`='$id_variable1', `peso_vol`='$peso_vol1', `humedad`='$humedad1',  `temperatura`='$temperatura1', `grano_entero`='$grano_entero1', `grano_quebrado`='$grano_quebrado1', `dan_hongo`='$dan_hongo1', `impureza`='$impureza1', `grano_chico`='$grano_chico1', `grano_picado`='$grano_picado1', `plaga_viva`='$plaga_viva1', `plaga_muerta`='$plaga_muerta1', `stress_crack`='$stress_crack1', `olor`='$olor1', `observacion`='$observacion1', `bandera`='2',   `vapor`='$vapor1', `nom_analista`='$nom_analista1', `peso_sin_humedad`='$peso_inve' WHERE id_salida='$cod2'");
		
$sql_inv= ("UPDATE `tab_inventario` SET `movimiento_lote`='$peso_bruto_inv', peso_sin_humedad='$cantidad_sin_humedad', peso_sin_humedad_maximo='$cantidad_sin_humedad_maxima2' WHERE id_lote='$id_lote2'");

$sql_inv= ("UPDATE `tab_inventario` SET `movimiento_lote`='$peso_bruto_inv', peso_sin_humedad='$cantidad_sin_humedad', peso_sin_humedad_maximo='$cantidad_sin_humedad_maxima2' WHERE id_lote='$id_lote2'");

				   mysql_query($sql,$con);
				   mysql_query($sql_inv,$con);		
		
		   
					  if(mysql_error())
					  { 
						echo '<div class="alert alert-danger">
 		 <a href="f_salida_cola.php" class="alert-link"> Error en el procesamiento de datos!!! Haga click para continuar .....</a>
			</div>';
					  }
					  else

unset($_SESSION['pesoooo']);
unset($_SESSION['taraaa']);
//unset($_SESSION['buscarrr']);
unset($_SESSION['fec_salida']);
unset($_SESSION['hor_salida']);
unset($_SESSION['variable2']);
unset($_SESSION['peso_vol2']);
unset($_SESSION['humedad2']);
unset($_SESSION['temperatura2']);
unset($_SESSION['grano_entero2']);
unset($_SESSION['grano_quebrado2']);
unset($_SESSION['dan_hongo2']);
unset($_SESSION['impureza2']);		 		 		 		 				 		 			 
unset($_SESSION['grano_chico2']);
unset($_SESSION['grano_picado2']);
unset($_SESSION['plaga_viva2']);
unset($_SESSION['plaga_muerta2']);
unset($_SESSION['stress_crack2']);
unset($_SESSION['olor2']);
unset($_SESSION['observacion2']);
unset($_SESSION['vapor2']);
unset($_SESSION['nom_analista2']);
unset($_SESSION['id_lote2']);	

$guarda="2";				  
				 echo '<div class="alert alert-success">
 		<a href="f_salida_cola.php" class="alert-link">Datos almacenados con éxito, !!! Haga click para continuar .....</a>
		</div>';
				
		 }

?>
  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>DESPACHO DE GRANOS BASICOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form role="form" name="formulario"  method="post" action="f_salida2.php">
           <input type="hidden"  name="bandera" value="0">
           <input type="hidden"  name="variable" value="0"> 
 			<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif">   
           <input type="hidden"  name="reporte" value="<?PHP echo $_SESSION['buscarrr']; ?>">           
           <input type="hidden" name="peso_base_bruto" value="<?PHP echo $peso_tara1; ?>">                                     
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="transaccion">CODIGO</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $id_salida1;?>" id="transaccion1"   name="transaccion1" autocomplete="off" style="background:#FFF;" readonly>
                      
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="entrada">ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $entrada1;?>" id="entrada1"  name="entrada1" autocomplete="off" style="background:#FFF;" readonly>
                        
                              
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
           
            <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="entrada">CLIENTE</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $nom_cliente1;?>" id="nom_cliente"  name="nom_cliente" autocomplete="off" style="background:#FFF;" readonly>
              </div>
              </div>
               <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">LOTE</label>
                <input type="text" class="form-control input-lg" value="<?PHP echo $num_lote1;?>" id="num_lote"  name="num_lote" autocomplete="off" style="background:#FFF;" readonly>
                  </div>
              </div>
              </div>
              
               <div class="row"><!--- INICIO ROW----->
               <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">SILO</label>
        		 <input type="text" class="form-control input-lg" value="<?PHP echo $nom_silo1;?>" id="nom_silo"  name="nom_silo" autocomplete="off" style="background:#FFF;" readonly>
                  </div>
              </div>
             
                <div class="col-md-6" >
              <div class="form-group">
               <label for="moneda_servicio">SERVICIOS DEL LOTE</label>
                 <?PHP
               $tabla_servicio=mysql_query("SELECT * FROM tab_servicio as a, tab_detalle_servicio as b WHERE a.id_servicio=b.id_servicio and b.id_lote = '$id_lote1' and b.id_cliente = '$id_cliente1' and a.id_empresa='".$id_empresa."' and a.bandera=0");
			   
			   ?>
              <div> <select size="3" name="id_servicio2" id="id_servicio2" class="form-control input-lg" style="height: auto; background:#FFF;" > 
               <?php 
								while($valor4=mysql_fetch_array($tabla_servicio)){
									$codigo_cliente= $valor4["id_servicio"];
									$nombre_cliente= $valor4["nom_servicio"];
									echo "<option value='$codigo_cliente'>";
									echo ("$nombre_cliente");
									echo"</option>";
								}	
							?>
                            </select></div>
              </div>
              </div>  
           </div><!--- FIN ROW----->

     <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">FECHA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $fecha_entrada1;?>" id="fecha_entrada" name="fecha_entrada" autocomplete="off" readonly style="background:#FFF;">
                </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">HORA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $hora_entrada1;?>" id="hora_entrada" name="hora_entrada" autocomplete="off" readonly style="background:#FFF;">
                   </div>
              </div>
                         
           </div><!--- FIN ROW----->
           <br>
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">FECHA SALIDA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $fecha;?>" id="fecha_salida" name="fecha_salida" autocomplete="off" style="background:#FFF;">
                 </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">HORA SALIDA</label>
               <input type="text" class="form-control input-lg"  value="<?PHP echo $hora;?>" id="hora_salida" name="hora_salida" autocomplete="off" style="background:#FFF;">
                   </div>
              </div>
                         
           </div><!--- FIN ROW----->
           <br>
           <!-- PARA CAPTURA LOS PESOS -->
           <div class="row"><!--- INICIO ROW----->
          <div class="col-md-6">
         <div class="form-group">
              <label>PESO TEORICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_teorico"  name="peso_teorico"  placeholder="PESO TEORICO" autocomplete="off"  value="<?PHP echo $peso_teorico1;?>" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
           <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">TRANSPORTISTA</label>
        		<input type="text" class="form-control input-lg"  value="<?PHP echo $nom_transportista1;?>" id="nom_piloto" name="nom_piloto" autocomplete="off" readonly style="background:#FFF;">
                  </div>
              </div>
          </div>	<!-- FIN -->
          <br>
           <div class="row"><!--- INICIO ROW----->
              <div class="col-md-4">
              <div class="form-group">
              <label for="opciones"> PESO A REALIZAR </label>
              </div>
              </div>
              </div> <!-- FIN -->
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
             
               	 <div>
                 <input type="radio" id="tipo_peso" value="1" name="tipo_peso" onClick=" validar_peso_bruto(document.formulario.peso_base_bruto.value); btnguardar.disabled=false;">  PESO BRUTO 
                 </div>
                 </div>
                 </div>
              
               <div class="col-md-6">
              	<div class="form-group">
				<label for="tipo_peso"></label>
                 <input type="radio" id="tipo_peso" value="2" name="tipo_peso" disabled >  PESO TARA 
                
                 </div>
                 </div>
            
              </div><!--- FIN ROW----->
                     <div class="row"><!--- INICIO ROW----->
          <div class="col-md-6">
         <div class="form-group">
              <label>PESO BRUTO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_bruto"  name="peso_bruto"  placeholder="PESO BRUTO" autocomplete="off"  style="background:#FFF;" value="<?PHP echo $peso_bruto_url; ?>" onChange="validar_peso_bruto(document.formulario.peso_base_bruto.value);">
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-6">
         <div class="form-group">
              <label>PESO TARA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_tara"  name="peso_tara"  placeholder="PESO TARA" autocomplete="off" readonly style="background:#FFF;"  value="<?PHP echo $peso_tara1; ?>" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
                  </div>
          </div>
            
          </div><!--- FIN ROW-----> 
          
       <br>
       <div class="checkbox">
              <label>
                <input type="checkbox" value="" onclick="activar_textos()">CONTROL DE CALIDAD </label>
          </div>
          
                         
          	<div  style='display:none;' id="formulario_responsable">
     		<div class="row" >
  		   	<div class="col-md-12">
        		
           			 <div class="panel-heading bg-info"><strong>CONTROL DE CALIDAD</strong></div> <!-- PANEL 1 --->  
           				<div class="panel-body" >
          
                      
           <div class="row"><!--- INICIO ROW----->
                        
             <div class="col-md-4">
              <div class="form-group">
              <!-- DEFINICION DE VARIABLES -->
               <input type="hidden" name="peso_base" value="0">
               <input type="hidden" name="humedad_base" value="0">  
               <input type="hidden" name="temperatura_base" value="0">  
               <input type="hidden" name="grano_entero_base" value="0">  
               <input type="hidden" name="grano_quebrado_base" value="0">
               <input type="hidden" name="dan_hongo_base" value="0">                
               <input type="hidden" name="impureza_base" value="0">               
               <input type="hidden" name="grano_chico_base" value="0">
               <input type="hidden" name="grano_picado_base" value="0">
               <input type="hidden" name="plaga_viva_base" value="0">
               <input type="hidden" name="plaga_muerta_base" value="0">               
               <input type="hidden" name="stress_crack_base" value="0">
               <input type="hidden" name="pasa1" value="0">
               <input type="hidden" name="pasa2" value="0">
               <input type="hidden" name="pasa3" value="0">
               <input type="hidden" name="pasa4" value="0">
               <input type="hidden" name="pasa5" value="0">
               <input type="hidden" name="pasa6" value="0">              
               <input type="hidden" name="pasa7" value="0">
               <input type="hidden" name="pasa8" value="0">  
			   <input type="hidden" name="pasa9" value="0">
               <input type="hidden" name="pasa10" value="0">              
               <input type="hidden" name="pasa11" value="0">
               <input type="hidden" name="pasa12" value="0">               
               <label for="moneda_servicio">CATEGORIA</label>
                         <?php
						       $tabla=mysql_query("SELECT * FROM tab_variables WHERE id_variable!='VAR-000'");
						  ?>
                      <select name="id_variable" class="form-control input-lg"  size="1" id="id_variable" >
                            <option value="VAR-000">SELECCION CATEGORIA </option>
							 <?php 
								while($valor=mysql_fetch_array($tabla)){
									$codigo_variable= $valor['id_variable'];
									$nombre_variable= $valor["nom_variable"];

									echo "<option value='$codigo_variable' onClick='document.formulario.peso_base.value=\"".$valor['peso_vol']."\"; validar_peso(document.formulario.peso_base.value); document.formulario.humedad_base.value=\"".$valor['humedad']."\"; validar_peso(document.formulario.humedad_base.value); document.formulario.temperatura_base.value=\"".$valor['temperatura']."\"; validar_peso(document.formulario.temperatura_base.value); document.formulario.grano_entero_base.value=\"".$valor['grano_entero']."\"; validar_peso(document.formulario.grano_entero_base.value); document.formulario.grano_quebrado_base.value=\"".$valor['grano_quebrado']."\"; validar_peso(document.formulario.grano_quebrado_base.value); document.formulario.dan_hongo_base.value=\"".$valor['dan_hongo']."\"; validar_peso(document.formulario.dan_hongo_base.value); document.formulario.impureza_base.value=\"".$valor['impureza']."\"; validar_peso(document.formulario.impureza_base.value); document.formulario.grano_chico_base.value=\"".$valor['grano_chico']."\"; validar_peso(document.formulario.grano_chico_base.value); document.formulario.grano_picado_base.value=\"".$valor['grano_picado']."\"; validar_peso(document.formulario.grano_picado_base.value); document.formulario.plaga_viva_base.value=\"".$valor['plaga_viva']."\"; validar_peso(document.formulario.plaga_viva_base.value); document.formulario.plaga_muerta_base.value=\"".$valor['plaga_muerta']."\"; validar_peso(document.formulario.plaga_muerta_base.value); document.formulario.stress_crack_base.value=\"".$valor['stress_crack']."\"; validar_peso(document.formulario.stress_crack_base.value); document.formulario.pasa1.value=0; document.formulario.pasa2.value=0; document.formulario.pasa3.value=0; document.formulario.pasa4.value=0; document.formulario.pasa5.value=0; document.formulario.pasa6.value=0; document.formulario.pasa7.value=0; document.formulario.pasa8.value=0; document.formulario.pasa9.value=0;  document.formulario.pasa10.value=0; document.formulario.pasa11.value=0; document.formulario.pasa12.value=0;' >";
									
									echo utf8_encode("$nombre_variable");
									echo"</option>";
								}	
								
								
							?>
                          </select>
                              
                 </div>
       </div>
       </div><!--- FIN ROW----->
		<br>
               <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>PESO VOLUMETRICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_vol"  name="peso_vol"  placeholder="PESO VOLUMETRICO" autocomplete="off" onKeyUp="validar_peso(document.formulario.peso_base.value);" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
         
            <div class="col-md-4">
         <div class="form-group">
              <label>HUMEDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="humedad"  name="humedad"  placeholder="HUMEDAD" autocomplete="off" onKeyUp="validar_peso(document.formulario.humedad_base.value);"  >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>TEMPERATURA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="temperatura"  name="temperatura"  placeholder="TEMPERATURA" autocomplete="off" onKeyUp="validar_peso(document.formulario.temperatura_base.value);" >
              <span class="input-group-addon">GRADOS</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
 
       <br>
            <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>GRANO ENTERO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_entero"  name="grano_entero"  placeholder="GRANO ENTERO" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_entero_base.value);" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO QUEBRADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_quebrado"  name="grano_quebrado"  placeholder="GRANO QUEBRADO" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_quebrado_base.value);" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>DAÑO POR HONGO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="dan_hongo"  name="dan_hongo"  placeholder="TEMPERATURA" autocomplete="off" onKeyUp="validar_peso(document.formulario.dan_hongo_base.value);"  >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
                <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>IMPUREZA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="impureza"  name="impureza"  placeholder="IMPUREZA" autocomplete="off" onKeyUp="validar_peso(document.formulario.impureza_base.value);" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO CHICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_chico"  name="grano_chico"  placeholder="GRANO CHICO" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_chico_base.value);" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>GRANO PICADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_picado"  name="grano_picado"  placeholder="GRANO PICADO" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_picado_base.value);">
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
                 <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>PLAGA VIVA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_viva"  name="plaga_viva"  placeholder="PLAGA VIVA" autocomplete="off" onKeyUp="validar_peso(document.formulario.plaga_viva_base.value);" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PLAGA MUERTA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_muerta"  name="plaga_muerta"  placeholder="PLAGA MUERTA" autocomplete="off" onKeyUp="validar_peso(document.formulario.plaga_muerta_base.value);" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>STRESS CRACK </label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="stress_crack"  name="stress_crack"  placeholder="STRESS CRACK" autocomplete="off" onKeyUp="validar_peso(document.formulario.stress_crack_base.value);">
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>OLOR</label>
              <input type="text" class="form-control input-lg" id="olor"  name="olor"  placeholder="OLOR" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         <div class="col-md-4">
         <div class="form-group">
              <label>VAPOR</label>
              <input type="text" class="form-control input-lg" id="vapor"  name="vapor"  placeholder="VAPOR" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
           <div class="col-md-4">
         <div class="form-group">
              <label>ANALISTA</label>
              <input type="text" class="form-control input-lg" id="nom_analista"  name="nom_analista"  placeholder="ANALISTA" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         </div><!--- FIN ROW----->
       <br>
       <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="direccion_comprador">OBSERVACION</label>
             <textarea name="observacion" class="form-control" rows="3" placeholder="Observaciones" autocomplete="off" id="observacion" style="text-transform:uppercase"><?PHP echo $observacion1; ?></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
<br><br>
                         
         </div></div></div></div>
          
               	  <table width="220" border="0" align="right">
 				   	    <tr>
              	      <td width="100"><button type="reset" onClick="cancelar()" id="btnsub" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="submit" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right" disabled>  </button></td>
                                            
              	    </tr>
           	      </table> 
            
           </form> 
</div>
</div>
</div>
</div>

<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->

<!--  INICIO FOOTER   -->
<?PHP include("footer.php"); ?>
<!-- FIN FOOTER  -->

<!-- INICIA ELIMINAR REGISTRO -->
<div class="modal fade" id="ventana4">
<form name="formulario_delete" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="id_eliminar" value="0">
<input type="hidden" name="bandera_eliminar" value="ok">
        <div class="modal-dialog">
          <div class="modal-content">                        
            <div class="modal-header">
               <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h3 class="modal-title">Autorización</h3>
            </div>            
          <div class="modal-body"> 
          
            <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">USUARIO</label>
                       <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" id="con_usuario" name="con_usuario" class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
            <div class="modal-footer">
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               	<button class="btn btn-primary" type="submit">Aceptar </button>
            </div>    
    </div>
    <div>               
    </form>
</div>
<!--------------------FIN VENTANA 4-------------------->
</body> 
</html>
<?PHP
mysql_close($con);
?>


