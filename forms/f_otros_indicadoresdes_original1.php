﻿<?php 
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
$nom_cliente=$_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];
 
  // Verificación de sesiones
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

// EXTRAER EL CODIGO DEL CLIENTE
$nomSQL=mysql_query("select id_cliente from tab_cliente where nom_cliente='$nom_cliente'",$con);
$fila_nom = mysql_fetch_array($nomSQL, MYSQL_ASSOC);
$cod_usuario_cliente=$fila_nom['id_cliente']; 
$_SESSION['cod_usuario_cliente']=$cod_usuario_cliente;


date_default_timezone_set("America/El_Salvador");
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora_entrada=date("H:i:s");
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>

<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">

<script type="text/javascript"  src="../assets/alertify/lib/alertify.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="../assets/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="../assets/alertify/themes/alertify.default.css" />

<link href="../images/favicon.ico" rel="icon">

</head> 

<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones3').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
    });

  
  
function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }	
</script>

<script>
 
function activar_textosdespacho() //funcionar para activas las cajas de textos
  {	
		if (document.indicadorrecepcion.activarbotondes.checked==false){
			document.indicadorrecepcion.btnguardar_despacho.disabled=true;
			}else{
				document.indicadorrecepcion.btnguardar_despacho.disabled=false;
			}
  }
  
  
function indicadorrecepcion1(con)
{
	
	document.formulario.indicador_otrosrecepcion.value = con;
	alert(document.formulario.indicador_otrosrecepcion.value);
	$.post('otros_indicadores_despacho.php', {id_cuentas_buscardespacho:document.formulario.indicador_otrosrecepcion.value}, 
			 function(result) {
				 	 
				$('#feedbackindicadorrecepcion').html(result).show();	
		  });//fin1
				
}

 function actualizarrecepcion()
 {	 
    document.indicadorrecepcion.banderaindicadorrecepcion.value="ok";
    document.indicadorrecepcion.submit();  
 }
 
 function recepcion_boleta(cod){
		document.formulario.r_recepcion.value=cod;
		window.open('../reportes/Rp_otrosin_calidadentrada.php?id='+document.formulario.r_recepcion.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
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



<!-- ALMACENAR INDICADORES DE RECEPCION -->
<?PHP
	$bandera_indi = $_POST['banderaindicadorrecepcion'];
	if($bandera_indi=="ok"){
		
		
$Result1 = mysql_query("SELECT MAX(id_indicadoressalida) as a  FROM tab_indicadoresdespacho where id_empresa='$id_empresa' ORDER BY id_indicadoressalida asc ") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],8,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "INDISAL-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "INDISAL-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "INDISAL-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "INDISAL-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "INDISAL-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "INDISAL-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "INDISAL-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}
			
// leer variables
   $nu;
   $cod_almacenaje1=$_SESSION['cod_despacho'];
   $humedadg1=$_POST['humedadg'];
   $humedad_rojog1=$_POST['humedad_rojog']; if($humedad_rojog1!=1){$humedad_rojog1=0;}		  
   $humedad_verdeg1=$_POST['humedad_verdeg']; if($humedad_verdeg1!=1){$humedad_verdeg1=0;}	
   $temperaturag1=$_POST['temperaturag'];	
   $temperatura_rojog1=$_POST['temperatura_rojog']; if($temperatura_rojog1!=1){$temperatura_rojog1=0;}		  
   $temperatura_verdeg1=$_POST['temperatura_verdeg']; if($temperatura_verdeg1!=1){$temperatura_verdeg1=0;}	
   $grano_bolag1=$_POST['grano_bolag'];	
   $grano_bola_rojog1=$_POST['grano_bola_rojog']; if($grano_bola_rojog1!=1){$grano_bola_rojog1=0;}		  
   $grano_bola_verdeg1=$_POST['grano_bola_verdeg']; if($grano_bola_verdeg1!=1){$grano_bola_verdeg1=0;}
   $grano_chicog1=$_POST['grano_chicog'];	
   $grano_chico_rojog1=$_POST['grano_chico_rojog']; if($grano_chico_rojog1!=1){$grano_chico_rojog1=0;}		  
   $grano_chico_verdeg1=$_POST['grano_chico_verdeg']; if($grano_chico_verdeg1!=1){$grano_chico_verdeg1=0;}
   $grano_rotog1=$_POST['grano_rotog'];	
   $grano_roto_rojog1=$_POST['grano_roto_rojog']; if($grano_roto_rojog1!=1){$grano_roto_rojog1=0;}		  
   $grano_roto_verdeg1=$_POST['grano_roto_verdeg']; if($grano_roto_verdeg1!=1){$grano_roto_verdeg1=0;}
   $impurezag1=$_POST['impurezag'];	
   $impureza_rojog1=$_POST['impureza_rojog']; if($impureza_rojog1!=1){$impureza_rojog1=0;}		  
   $impureza_verdeg1=$_POST['impureza_verdeg']; if($impureza_verdeg1!=1){$impureza_verdeg1=0;}
   $otras_variedadesg1=$_POST['otras_variedadesg'];	
   $otras_variedades_rojog1=$_POST['otras_variedades_rojog']; if($otras_variedades_rojog1!=1){$otras_variedades_rojog1=0;}		  
   $otras_variedades_verdeg1=$_POST['otras_variedades_verdeg']; if($otras_variedades_verdeg1!=1){$otras_variedades_verdeg1=0;}
   $piedrasg1=$_POST['piedrasg'];	
   $piedras_rojog1=$_POST['piedras_rojog']; if($piedras_rojog1!=1){$piedras_rojog1=0;}		  
   $piedras_verdeg1=$_POST['piedras_verdeg']; if($piedras_verdeg1!=1){$piedras_verdeg1=0;}
   $infestaciong1=$_POST['infestaciong'];	
   $infestacion_rojog1=$_POST['infestacion_rojog']; if($infestacion_rojog1!=1){$infestacion_rojog1=0;}		  
   $infestacion_verdeg1=$_POST['infestacion_verdeg']; if($infestacion_verdeg1!=1){$infestacion_verdeg1=0;}
   $retencion_mallag1=$_POST['retencion_mallag'];	
   $retencion_malla_rojog1=$_POST['retencion_malla_rojog']; if($retencion_malla_rojog1!=1){$retencion_malla_rojog1=0;}		  
   $retencion_malla_verdeg1=$_POST['retencion_malla_verdeg']; if($retencion_malla_verdeg1!=1){$retencion_malla_verdeg1=0;}
   $calorg1=$_POST['calorg'];	
   $calor_rojog1=$_POST['calor_rojog']; if($calor_rojog1!=1){$calor_rojog1=0;}		  
   $calor_verdeg1=$_POST['calor_verdeg']; if($calor_verdeg1!=1){$calor_verdeg1=0;}
   $insectog1=$_POST['insectog'];	
   $insecto_rojog1=$_POST['insecto_rojog']; if($insecto_rojog1!=1){$insecto_rojog1=0;}		  
   $insecto_verdeg1=$_POST['insecto_verdeg']; if($insecto_verdeg1!=1){$insecto_verdeg1=0;}
   $hongog1=$_POST['hongog'];	
   $hongo_rojog1=$_POST['hongo_rojog']; if($hongo_rojog1!=1){$hongo_rojog1=0;}		  
   $hongo_verdeg1=$_POST['hongo_verdeg']; if($hongo_verdeg1!=1){$hongo_verdeg1=0;}
   $germinaciong1=$_POST['germinaciong'];	
   $germinacion_rojog1=$_POST['germinacion_rojog']; if($germinacion_rojog1!=1){$germinacion_rojog1=0;}		  
   $germinacion_verdeg1=$_POST['germinacion_verdeg']; if($germinacion_verdeg1!=1){$germinacion_verdeg1=0;}
   $peso_100_granosg1=$_POST['peso_100_granosg'];	
   $peso_100_granos_rojog1=$_POST['peso_100_granos_rojog']; if($peso_100_granos_rojog1!=1){$peso_100_granos_rojog1=0;}		  
   $peso_100_granos_verdeg1=$_POST['peso_100_granos_verdeg']; if($peso_100_granos_verdeg1!=1){$peso_100_granos_verdeg1=0;}	
   $longitud_20_granosg1=$_POST['longitud_20_granosg'];	
   $longitud_20_granos_rojog1=$_POST['longitud_20_granos_rojog']; if($longitud_20_granos_rojog1!=1){$longitud_20_granos_rojog1=0;}		   $longitud_20_granos_verdeg1=$_POST['longitud_20_granos_verdeg']; if($longitud_20_granos_verdeg1!=1){$longitud_20_granos_verdeg1=0;}	
   $densidadg1=$_POST['densidadg'];	
   $densidad_rojog1=$_POST['densidad_rojog']; if($densidad_rojog1!=1){$densidad_rojog1=0;}		  
   $densidad_verdeg1=$_POST['densidad_verdeg']; if($densidad_verdeg1!=1){$densidad_verdeg1=0;}	
   $aflotoxinasg1=$_POST['aflotoxinasg'];	
   $aflotoxinas_rojog1=$_POST['aflotoxinas_rojog']; if($aflotoxinas_rojog1!=1){$aflotoxinas_rojog1=0;}		  
   $aflotoxinas_verdeg1=$_POST['aflotoxinas_verdeg']; if($aflotoxinas_verdeg1!=1){$aflotoxinas_verdeg1=0;}	
   $fumonisinasg1=$_POST['fumonisinasg'];	
   $fumonisinas_rojog1=$_POST['fumonisinas_rojog']; if($fumonisinas_rojog1!=1){$fumonisinas_rojog1=0;}		  
   $fumonisinas_verdeg1=$_POST['fumonisinas_verdeg']; if($fumonisinas_verdeg1!=1){$fumonisinas_verdeg1=0;}	
   $vomitoxinasg1=$_POST['vomitoxinasg'];	
   $vomitoxinas_rojog1=$_POST['vomitoxinas_rojog']; if($vomitoxinas_rojog1!=1){$vomitoxinas_rojog1=0;}		  
   $vomitoxinas_verdeg1=$_POST['vomitoxinas_verdeg']; if($vomitoxinas_verdeg1!=1){$vomitoxinas_verdeg1=0;}	
   $stress_crackg1=$_POST['stress_crackg'];	
   $stress_crack_rojog1=$_POST['stress_crack_rojog']; if($stress_crack_rojog1!=1){$stress_crack_rojog1=0;}		  
   $stress_crack_verdeg1=$_POST['stress_crack_verdeg']; if($stress_crack_verdeg1!=1){$stress_crack_verdeg1=0;}	
   $flotadoresg1=$_POST['flotadoresg'];	
   $flotadores_rojog1=$_POST['flotadores_rojog']; if($flotadores_rojog1!=1){$flotadores_rojog1=0;}		  
   $flotadores_verdeg1=$_POST['flotadores_verdeg']; if($flotadores_verdeg1!=1){$flotadores_verdeg1=0;}	
   $elaboradoporg1=strtoupper($_POST['elaboradoporg']);
   $observacionesg1=strtoupper($_POST['observacionesg']);
  
  $suma_granos_danadosg1=$calorg1+$insectog1+$hongog1;
  $suma_grano_danados_rojog1=0;
  $suma_grano_danado_verdeg1=0;
	$nombre_usuario2=($_POST['nom_usuario2']); // CORREO
	$con_usuario2=md5($_POST['con_usuario2']);
	  $activo2="1";
	  $empresa2=$id_empresa;
	  $modificar2="1";

	$resultado = autorizar_mod($nombre_usuario2,$con_usuario2,$activo2,$empresa2,$modificar2);	
	
	if($resultado=="1"){
	$guarda="400"; // Guarda
	}else{
		$error="500"; // no posee permisos
		}
	}

 if($guarda=="400") // incia la actualizaccón
   {//inicio actualizar

   $tabla5="SELECT * FROM t_usuarios where correo_usuario='$nombre_usuario2' and pass_usuario='$con_usuario2' and id_empresa='$id_empresa'" or die(mysql_error());
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_actualiza2=$row5['id_usuario'];
}
   

		mysql_query("insert into tab_indicadoresdespacho(id_indicadoressalida, id_salida, humedad, humedad_rojo, humedad_verde, temperatura, temperatura_rojo, temperatura_verde, grano_bola, grano_bola_rojo, grano_bola_verde, grano_chico, grano_chico_rojo, grano_chico_verde, grano_roto, grano_roto_rojo, grano_roto_verde, impureza, impureza_rojo, impureza_verde, otras_variedades, otras_variedades_rojo, otras_variedades_verde, piedras, piedras_rojo, piedras_verde, infestacion, infestacion_rojo, infestacion_verde, retencion_malla, retencion_malla_rojo, retencion_malla_verde, suma_granos_danados, suma_granos_danados_rojo, suma_granos_danados_verde, calor, calor_rojo, calor_verde, insecto, insecto_rojo, insecto_verde, hongo, hongo_rojo, hongo_verde, germinacion, germinacion_rojo, germinacion_verde, peso_100_granos, peso_100_granos_rojo, peso_100_granos_verde, longitud_20_granos, longitud_20_granos_rojo, longitud_20_granos_verde, densidad, densidad_rojo, densidad_verde, aflotoxinas, aflotoxinas_rojo, aflotoxinas_verde, fumonisinas, fumonisinas_rojo, fumonisinas_verde, vomitoxinas, vomitoxinas_rojo, vomitoxinas_verde, stress_crack, stress_crack_rojo, stress_crack_verde, flotadores, flotadores_rojo, flotadores_verde, nom_analista, observaciones, id_empresa, id_usuario2, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values ('$nu','$cod_almacenaje1', '$humedadg1', '$humedad_rojog1','$humedad_verdeg1', '$temperaturag1', '$temperatura_rojog1', '$temperatura_verdeg1', '$grano_bolag1', '$grano_bola_rojog1', '$grano_bola_verdeg1', '$grano_chicog1', '$grano_chico_rojog1', '$grano_chico_verdeg1', '$grano_rotog1', '$grano_roto_rojog1', '$grano_roto_verdeg1', '$impurezag1', '$impureza_rojog1', '$impureza_verdeg1', '$otras_variedadesg1', '$otras_variedades_rojog1', '$otras_variedades_verdeg1', '$piedrasg1', '$piedras_rojog1', '$piedras_verdeg1', '$infestaciong1', '$infestacion_rojog1', '$infestacion_verdeg1', '$retencion_mallag1', '$retencion_malla_rojog1', '$retencion_malla_verdeg1', '$suma_granos_danadosg1', '$suma_grano_danados_rojog1', '$suma_grano_danado_verdeg1', '$calorg1', '$calor_rojog1', '$calor_verdeg1', '$insectog1', '$insecto_rojog1', '$insecto_verdeg1', '$hongog1', '$hongo_rojog1', '$hongo_verdeg1', '$germinaciong1', '$germinacion_rojog1', '$germinacion_verdeg1', '$peso_100_granosg1', '$peso_100_granos_rojog1', '$peso_100_granos_verdeg1', '$longitud_20_granosg1', '$longitud_20_granos_rojog1', '$longitud_20_granos_verdeg1', '$densidadg1', '$densidad_rojog1', '$densidad_verdeg1', '$aflotoxinasg1', '$aflotoxinas_rojog1', '$aflotoxinas_verdeg1', '$fumonisinasg1', '$fumonisinas_rojog1', '$fumonisinas_verdeg1', '$vomitoxinasg1', '$vomitoxinas_rojog1', '$vomitoxinas_verdeg1', '$stress_crackg1', '$stress_crack_rojog1', '$stress_crack_verdeg1', '$flotadoresg1', '$flotadores_rojog1', '$flotadores_verdeg1', '$elaboradoporg1', '$observacionesg1', '$id_empresa', '$usuario_actualiza2', '$fecha_entrada', '$hora_entrada', '$usuario_actualiza2', '$fecha_entrada', '$hora_entrada')") or die(mysql_error()); 

$sqlin= ("UPDATE tab_salida SET nuevo_indicador='1' WHERE id_salida='$cod_almacenaje1' and id_empresa='$id_empresa'");
		mysql_query($sqlin,$con);    
				   
	if(mysql_error())
		  { 
			$mensaje="11"; // Error en almacenamiento de datos
		  }
			  else
			$error="16"; // Almancenado
				
					  
   } // fin guardar
	
?>
<body class="container"> 


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
<?php
if($mensaje=="11"){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Error en almacenamiento de datos!!!", function () {
					});
</script>				
 <?PHP  
}
if($error=="16"){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Datos almacenados con éxito!!!", function () {
		   window.open('../reportes/Rp_otrosin_calidadsalida.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
					});
</script>				
 <?PHP  
}
if($error=="500"){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  No posee permisos para actualizar registro!!!", function () {
					});
</script>				
 <?PHP
}

?>



<form role="form" name="formulario"  method="post" action="f_otros_indicadoresdes.php">
<input type="hidden" name="indicador_otrosrecepcion" value="">
<input type="hidden" name="bandera" value="0">
<input type="hidden"  name="reporte" value="<?PHP echo $_SESSION['cod_despacho']; ?>"> 
</form>


 <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>INGRESO DE INDICADORES </strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 
 <?php
 			  if($cod_usuario_cliente==""){
			  	$cli="CLI-000".$id_empresa;
                $Sqldespacho="SELECT a.* FROM tab_salida as a WHERE  a.nuevo_indicador=0 AND a.bandera=1 AND a.id_empresa='$id_empresa' order by a.fecha_entrada desc, a.hora_entrada desc"; //
			  }else{
					$Sqldespacho="SELECT a.* FROM tab_salida as a, tab_detalle_cliente as d WHERE d.id_cliente_principal='$cod_usuario_cliente' AND a.id_cliente=d.id_cliente_secundario AND a.bandera=1 AND a.nuevo_indicador=0 AND a.id_empresa='$id_empresa' order by a.fecha_entrada desc, a.hora_entrada desc"; //
			  }
					
				?>
     
      
<?php
//$sql = "";
 	 $resultdes = mysql_query($Sqldespacho,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones3' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='50px'><div align='left'></div></th>
								<th width='100px'><div align='left'><a href='#' title='Ordenar por Control'>CONTROL</a></div></th>								
                                <th width='100px'><div align='left'><a href='#' title='Ordenar por Cliente'>FECHA</a></div></th>
                                <th width='125px'><div align='left'><a href='#' title='Odenar por Hora'>HORA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Cliente'>CLIENTE </a></div></th>	
								<th width='150px'><div align='left'><a href='#' title='Odenar por Placa'>PLACA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Motorista'>MOTORISTA </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Lote'>LOTE </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Silo'>SILO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Bruto'>BRUTO (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Tara'>TARA (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Neto'>NETO (KG) </a></div></th>
								
	    </tr>
        </thead>
        <tbody>";
		
		if ($resultdes> 0){	
		while ($rowdes = mysql_fetch_array($resultdes)) 
		{
			 $id_empresa_buscades=$rowdes['id_cliente'];
			 $id_lote_buscades=$rowdes['id_lote'];
			 $id_silo_buscades=$rowdes['id_silo'];
			 $id_motorista_buscades=$rowdes['id_transportista'];
			 $usuario_buscades=$rowdes['id_usuario2'];
			 $fecha_imprimedes=parseDatePhp($rowdes['fecha_entrada']);
			 $peso_netodes=$rowdes['peso_bruto']-$rowdes['peso_tara']; //Calcular el peso neto
			 
			if($rowdes['opcion_peso']==1)$pesodes="PESO BRUTO";
			if($rowdes['opcion_peso']==2)$pesodes="PESO TARA";	 
									
			$tabla2des="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa_buscades' and id_empresa='$id_empresa'";
			$select2des=mysql_query($tabla2des,$con);
			while($row2des=mysql_fetch_array($select2des)) {
			$nom_empresades=$row2des['nom_cliente'];
			}
				$tabla3des="SELECT * FROM tab_lote WHERE id_lote='$id_lote_buscades' and id_empresa='$id_empresa'";
				$select3des=mysql_query($tabla3des,$con);
				while($row3des=mysql_fetch_array($select3des)) {
				$num_lotedes=$row3des['num_lote'];
				}
					$tabla4des="SELECT * FROM tab_silo WHERE id_silo='$id_silo_buscades' and id_empresa='$id_empresa'";
					$select4des=mysql_query($tabla4des,$con);
					while($row4des=mysql_fetch_array($select4des)) {
					$nom_silodes=$row4des['nom_silo'];
					}
						$tabla5des="SELECT * FROM tab_transportista WHERE id_transportista='$id_motorista_buscades' and id_empresa='$id_empresa'";
						$select5des=mysql_query($tabla5des,$con);
						while($row5des=mysql_fetch_array($select5des)) {
						$nom_transportistades=$row5des['nom_transportista']." ".$row5des['ape_transportista'];
						$placades=$row5des['placa_vehiculo'];
				
						}
		 											
		echo"<tr>
		<td width='60px' align='center'><a data-toggle='modal' data-target='#modal_indicador1' onClick='indicadorrecepcion1(\"".$rowdes['id_salida']."\");'  style='cursor:pointer' title='Agregar indicadores'><img src='../images/modificar_indicador.png' width='28px' height='28px'></a></td>		   
          <td width='auto' align='center'> $rowdes[entrada]</td>
          <td width='auto' align='left'> $fecha_imprimedes</td>
		  <td width='auto' align='left'> $rowdes[hora_entrada] </td>		  
		  <td width='auto' align='left'> $nom_empresades </td>
  		  <td width='auto' align='left'> $placades </td>	
 		  <td width='auto' align='left'> $nom_transportistades </td>
		  <td width='auto' align='left'> $num_lotedes </td>
		  <td width='auto' align='left'> $nom_silodes </td>
		  <td width='auto' align='left'> $rowdes[peso_bruto] </td>
		  <td width='auto' align='left'> $rowdes[peso_tara] </td>
		  <td width='auto' align='left'> $peso_netodes</td>
		</tr>";
		$contar2++;
		}
			
		$correlativo2++;		

		echo"</tbody>
	</table>
	";
}
	?>
    <!--Fin si se ha seleccionado administrador-->

<?php
//echo $correlativo;

echo "Total de Registros" ." ".$contar2;
 
?>
</div>
</div>
</div>
</div> <!-- FIN DE RECEPCION -->


<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->


<!--  INICIO FOOTER   -->
<?PHP include("footer.php"); ?>
<!-- FIN FOOTER  -->

</body> 
</html>
	

<!-- INICIA MODAL INDICADOR -->
<div class="modal fade" id="modal_indicador1" >
<form name="indicadorrecepcion" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" >
<input type="hidden" name="banderaindicadorrecepcion" value="">

     <div class="modal-dialog">
          <div class="modal-content">                        
             <div id="feedbackindicadorrecepcion" class="modal-body" > 
          </div> 
          </div></div>  
</div>



<!-- SOLICITA PERMISO PARA ACTUALIZAR -->


<div class="modal fade" id="actualizardespacho">

        <div class="modal-dialog">
          <div class="modal-content">                        
            <div class="modal-header">
               <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h3 class="modal-title">Confirmación de Registro</h3>
            </div>            
          <div class="modal-body"> 
          
            <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">USUARIO</label>
                       <input type="text" id="nom_usuario2" name="nom_usuario2" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" id="con_usuario2" name="con_usuario2"  class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
            <div class="modal-footer">
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button id="btnactualizarrecepcion"  name="btnactualizarrecepcion" onclick="actualizarrecepcion()" class="btn btn-primary glyphicon glyphicon-cd center pull-right">  Actualizar</button>
               </div>
    </div>
    <div>               
  </div>                  
            
           </form> 
 </div><!-- Fin de formularios  Inicia la paginacion-->
     
</div>
</div>
</div>




