<?php 
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
    	$('#tblInstituciones2').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
    });
	</script>        

<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones3').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
    }); 


function modificar(str3)
{
				
	document.formulario.modificardatos.value = str3;
	$.post('mostrar_otrosindi.php', {id_entrada:document.formulario.modificardatos.value}, 
			 function(result) {
				$('#feedbackindicador').html(result).show();	
		  });//fin1
				
}

function report_recepcion() //funcionar para activas las cajas de textos
  {
			document.getElementById('report_recepcion').style.display = 'block';//Mostrar contenido
			document.getElementById('report_despacho').style.display = 'none';//oculta contenido
	  
  }

function report_despacho() //funcionar para activas las cajas de textos
  {
			document.getElementById('report_despacho').style.display = 'block';//Mostrar contenido
			document.getElementById('report_recepcion').style.display = 'none';//oculta contenido
	  
  }  
 
function activar_textosrecepcion() //funcionar para activas las cajas de textos
  {
	 if (document.indicador.activarbotonrecep.checked==false){
			document.indicador.btnguardar_actrecepcion.disabled=true;
			}else{
				document.indicador.btnguardar_actrecepcion.disabled=false;
			}
  }
   
function actualizar()
 {	 
    document.indicador.banderaindicador.value="ok";
    document.indicador.submit();  
 }
    
function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }	
</script>

<script>
function recepcion_boleta(cod){
		document.formulario.r_recepcion.value=cod;
		window.open('../reportes/Rp_otrosin_calidadentrada.php?id='+document.formulario.r_recepcion.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
 }

function despacho_boleta(bol){
		document.formulario.r_despacho.value=bol;
		window.open('../reportes/Rp_otrosin_calidadsalida.php?id='+document.formulario.r_despacho.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
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
<?PHP
$bandera_indi = $_POST['banderaindicador'];
	if($bandera_indi=="ok"){
		// leer variables
   $cod_almacenajeg1=$_SESSION['cod_almacenaje'];
   $humedadg1=$_POST['humedadg'];
   if(isset($_POST['humedad_rojog']) or $_POST['humedad_rojog'] == '1'){ $humedad_rojog1=1;}else{$humedad_rojog1=0;}
   if(isset($_POST['humedad_verdeg']) or $_POST['humedad_verdeg'] == '1'){ $humedad_verdeg1=1;}else{$humedad_verdeg1=0;}
   $temperaturag1=$_POST['temperaturag'];
   if(isset($_POST['temperatura_rojog']) or $_POST['temperatura_rojog'] == '1'){ $temperatura_rojog1=1;}else{$temperatura_rojog1=0;}
   if(isset($_POST['temperatura_verdeg']) or $_POST['temperatura_verdeg'] == '1'){ $temperatura_verdeg1=1;}else{$temperatura_verdeg1=0;}
   $grano_bolag1=$_POST['grano_bolag'];
   if(isset($_POST['grano_bola_rojog']) or $_POST['grano_bola_rojog'] == '1'){ $grano_bola_rojog1=1;}else{$grano_bola_rojog1=0;}
   if(isset($_POST['grano_bola_verdeg']) or $_POST['grano_bola_verdeg'] == '1'){ $grano_bola_verdeg1=1;}else{$grano_bola_verdeg1=0;}
   $grano_chicog1=$_POST['grano_chicog'];
   if(isset($_POST['grano_chico_rojog']) or $_POST['grano_chico_rojog'] == '1'){ $grano_chico_rojog1=1;}else{$grano_chico_rojog1=0;}
   if(isset($_POST['grano_chico_verdeg']) or $_POST['grano_chico_verdeg'] == '1'){ $grano_chico_verdeg1=1;}else{$grano_chico_verdeg1=0;}
   $grano_rotog1=$_POST['grano_rotog'];
   if(isset($_POST['grano_roto_rojog']) or $_POST['grano_roto_rojog'] == '1'){ $grano_roto_rojog1=1;}else{$grano_roto_rojog1=0;}
   if(isset($_POST['grano_roto_verdeg']) or $_POST['grano_roto_verdeg'] == '1'){ $grano_roto_verdeg1=1;}else{$grano_roto_verdeg1=0;}
   $impurezag1=$_POST['impurezag'];
   if(isset($_POST['impureza_rojog']) or $_POST['impureza_rojog'] == '1'){ $impureza_rojog1=1;}else{$impureza_rojog1=0;}
   if(isset($_POST['impureza_verdeg']) or $_POST['impureza_verdeg'] == '1'){ $impureza_verdeg1=1;}else{$impureza_verdeg1=0;}
   $otras_variedadesg1=$_POST['otras_variedadesg'];
   if(isset($_POST['otras_variedades_rojog']) or $_POST['otras_variedades_rojog'] == '1'){ $otras_variedades_rojog1=1;}else{$otras_variedades_rojog1=0;}
   if(isset($_POST['otras_variedades_verdeg']) or $_POST['otras_variedades_verdeg'] == '1'){ $otras_variedades_verdeg1=1;}else{$otras_variedades_verdeg1=0;}
   $piedrasg1=$_POST['piedrasg'];
   if(isset($_POST['piedras_rojog']) or $_POST['piedras_rojog'] == '1'){ $piedras_rojog1=1;}else{$piedras_rojog1=0;}
   if(isset($_POST['piedras_verdeg']) or $_POST['piedras_verdeg'] == '1'){ $piedras_verdeg1=1;}else{$piedras_verdeg1=0;}
   $infestaciong1=$_POST['infestaciong'];
   if(isset($_POST['infestacion_rojog']) or $_POST['infestacion_rojog'] == '1'){ $infestacion_rojog1=1;}else{$infestacion_rojog1=0;}
   if(isset($_POST['infestacion_verdeg']) or $_POST['infestacion_verdeg'] == '1'){ $infestacion_verdeg1=1;}else{$infestacion_verdeg1=0;}
   $retencion_mallag1=$_POST['retencion_mallag'];
   if(isset($_POST['retencion_malla_rojog']) or $_POST['retencion_malla_rojog'] == '1'){ $retencion_malla_rojog1=1;}else{$retencion_malla_rojog1=0;}
   if(isset($_POST['retencion_malla_verdeg']) or $_POST['retencion_malla_verdeg'] == '1'){ $retencion_malla_verdeg1=1;}else{$retencion_malla_verdeg1=0;}
   $calorg1=$_POST['calorg'];
   if(isset($_POST['calor_rojog']) or $_POST['calor_rojog'] == '1'){ $calor_rojog1=1;}else{$calor_rojog1=0;}
   if(isset($_POST['calor_verdeg']) or $_POST['calor_verdeg'] == '1'){ $calor_verdeg1=1;}else{$calor_verdeg1=0;}
   $insectog1=$_POST['insectog'];
   if(isset($_POST['insecto_rojog']) or $_POST['insecto_rojog'] == '1'){ $insecto_rojog1=1;}else{$insecto_rojog1=0;}
   if(isset($_POST['insecto_verdeg']) or $_POST['insecto_verdeg'] == '1'){ $insecto_verdeg1=1;}else{$insecto_verdeg1=0;}
   $hongog1=$_POST['hongog'];
   if(isset($_POST['hongo_rojog']) or $_POST['hongo_rojog'] == '1'){ $hongo_rojog1=1;}else{$hongo_rojog1=0;}
   if(isset($_POST['hongo_verdeg']) or $_POST['hongo_verdeg'] == '1'){ $hongo_verdeg1=1;}else{$hongo_verdeg1=0;}
   $germinaciong1=$_POST['germinaciong'];
   if(isset($_POST['germinacion_rojog']) or $_POST['germinacion_rojog'] == '1'){ $germinacion_rojog1=1;}else{$germinacion_rojog1=0;}
   if(isset($_POST['germinacion_verdeg']) or $_POST['germinacion_verdeg'] == '1'){ $germinacion_verdeg1=1;}else{$germinacion_verdeg1=0;}
   $peso_100_granosg1=$_POST['peso_100_granosg'];
   if(isset($_POST['peso_100_granos_rojog']) or $_POST['peso_100_granos_rojog'] == '1'){ $peso_100_granos_rojog1=1;}else{$peso_100_granos_rojog1=0;}
   if(isset($_POST['peso_100_granos_verdeg']) or $_POST['peso_100_granos_verdeg'] == '1'){ $peso_100_granos_verdeg1=1;}else{$peso_100_granos_verdeg1=0;}
   $longitud_20_granosg1=$_POST['longitud_20_granosg'];
   if(isset($_POST['longitud_20_granos_rojog']) or $_POST['longitud_20_granos_rojog'] == '1'){ $longitud_20_granos_rojog1=1;}else{$longitud_20_granos_rojog1=0;}
   if(isset($_POST['longitud_20_granos_verdeg']) or $_POST['longitud_20_granos_verdeg'] == '1'){ $longitud_20_granos_verdeg1=1;}else{$longitud_20_granos_verdeg1=0;}
   $densidadg1=$_POST['densidadg'];
   if(isset($_POST['densidad_rojog']) or $_POST['densidad_rojog'] == '1'){ $densidad_rojog1=1;}else{$densidad_rojog1=0;}
   if(isset($_POST['densidad_verdeg']) or $_POST['densidad_verdeg'] == '1'){ $densidad_verdeg1=1;}else{$densidad_verdeg1=0;}
   $aflotoxinasg1=$_POST['aflotoxinasg'];
   if(isset($_POST['aflotoxinas_rojog']) or $_POST['aflotoxinas_rojog'] == '1'){ $aflotoxinas_rojog1=1;}else{$aflotoxinas_rojog1=0;}
   if(isset($_POST['aflotoxinas_verdeg']) or $_POST['aflotoxinas_verdeg'] == '1'){ $aflotoxinas_verdeg1=1;}else{$aflotoxinas_verdeg1=0;}
   $fumonisinasg1=$_POST['fumonisinasg'];
   if(isset($_POST['fumonisinas_rojog']) or $_POST['fumonisinas_rojog'] == '1'){ $fumonisinas_rojog1=1;}else{$fumonisinas_rojog1=0;}
   if(isset($_POST['fumonisinas_verdeg']) or $_POST['fumonisinas_verdeg'] == '1'){ $fumonisinas_verdeg1=1;}else{$fumonisinas_verdeg1=0;}
   $vomitoxinasg1=$_POST['vomitoxinasg'];
   if(isset($_POST['vomitoxinas_rojog']) or $_POST['vomitoxinas_rojog'] == '1'){ $vomitoxinas_rojog1=1;}else{$vomitoxinas_rojog1=0;}
   if(isset($_POST['vomitoxinas_verdeg']) or $_POST['vomitoxinas_verdeg'] == '1'){ $vomitoxinas_verdeg1=1;}else{$vomitoxinas_verdeg1=0;}	
   $stress_crackg1=$_POST['stress_crackg'];
   if(isset($_POST['stress_crack_rojog']) or $_POST['stress_crack_rojog'] == '1'){ $stress_crack_rojog1=1;}else{$stress_crack_rojog1=0;}
   if(isset($_POST['stress_crack_verdeg']) or $_POST['stress_crack_verdeg'] == '1'){ $stress_crack_verdeg1=1;}else{$stress_crack_verdeg1=0;}	
   $flotadoresg1=$_POST['flotadoresg'];
   if(isset($_POST['flotadores_rojog']) or $_POST['flotadores_rojog'] == '1'){ $flotadores_rojog1=1;}else{$flotadores_rojog1=0;}
   if(isset($_POST['flotadores_verdeg']) or $_POST['flotadores_verdeg'] == '1'){ $flotadores_verdeg1=1;}else{$flotadores_verdeg1=0;}	
   $elaboradoporg1=strtoupper($_POST['elaboradoporg']);
   $observacionesg1=strtoupper($_POST['observacionesg']);
  
  $suma_granos_danadosg1=$calorg1+$insectog1+$hongog1;
  $suma_grano_danados_rojog1=0;
  $suma_grano_danado_verdeg1=0;
	$nombre_usuario2=($_POST['nom_usuario']); // CORREO
	$con_usuario2=md5($_POST['con_usuario']);
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
	
	
	if($guarda=="400"){ // inicia actualizacion
	$tabla5="SELECT * FROM t_usuarios where correo_usuario='$nombre_usuario2' and pass_usuario='$con_usuario2' and id_empresa='$id_empresa'" or die(mysql_error());
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_actualiza2=$row5['id_usuario'];
}

	$sqlin= ("UPDATE tab_indicadoresrecepcion SET humedad='$humedadg1', humedad_rojo='$humedad_rojog1',  humedad_verde='$humedad_verdeg1', temperatura='$temperaturag1', temperatura_rojo='$temperatura_rojog1',  temperatura_verde='$temperatura_verdeg1', grano_bola='$grano_bolag1', grano_bola_rojo='$grano_bola_rojog1', grano_bola_verde='$grano_bola_verdeg1', grano_chico='$grano_chicog1', grano_chico_rojo='$grano_chico_rojog1', grano_chico_verde='$grano_chico_verdeg1', grano_roto='$grano_rotog1', grano_roto_rojo='$grano_roto_rojog1', grano_roto_verde='$grano_roto_verdeg1', impureza='$impurezag1', impureza_rojo='$impureza_rojog1', impureza_verde='$impureza_verdeg1', otras_variedades='$otras_variedadesg1', otras_variedades_rojo='$otras_variedades_rojog1', otras_variedades_verde='$otras_variedades_verdeg1', piedras='$piedrasg1', piedras_rojo='$piedras_rojog1', piedras_verde='$piedras_verdeg1', infestacion='$infestaciong1', infestacion_rojo='$infestacion_rojog1', infestacion_verde='$infestacion_verdeg1', retencion_malla='$retencion_mallag1', retencion_malla_rojo='$retencion_malla_rojog1', retencion_malla_verde='$retencion_malla_verdeg1', suma_granos_danados='$suma_granos_danadosg1', suma_granos_danados_rojo='$suma_grano_danados_rojog1', suma_granos_danados_verde='$suma_grano_danado_verdeg1', calor='$calorg1', calor_rojo='$calor_rojog1', calor_verde='$calor_verdeg1', insecto='$insectog1', insecto_rojo='$insecto_rojog1', insecto_verde='$insecto_verdeg1', hongo='$hongog1', hongo_rojo='$hongo_rojog1', hongo_verde='$hongo_verdeg1', germinacion='$germinaciong1', germinacion_rojo='$germinacion_rojog1', germinacion_verde='$germinacion_verdeg1', peso_100_granos='$peso_100_granosg1', peso_100_granos_rojo='$peso_100_granos_rojog1', peso_100_granos_verde='$peso_100_granos_verdeg1', longitud_20_granos='$longitud_20_granosg1', longitud_20_granos_rojo='$longitud_20_granos_rojog1', longitud_20_granos_verde='$longitud_20_granos_verdeg1', densidad='$densidadg1', densidad_rojo='$densidad_rojog1', densidad_verde='$densidad_verdeg1', aflotoxinas='$aflotoxinasg1', aflotoxinas_rojo='$aflotoxinas_rojog1', aflotoxinas_verde='$aflotoxinas_verdeg1', fumonisinas='$fumonisinasg1', fumonisinas_rojo='$fumonisinas_rojog1', fumonisinas_verde='$fumonisinas_verdeg1', vomitoxinas='$vomitoxinasg1', vomitoxinas_rojo='$vomitoxinas_rojog1', vomitoxinas_verde='$vomitoxinas_verdeg1', stress_crack='$stress_crackg1', stress_crack_rojo='$stress_crack_rojog1', stress_crack_verde='$stress_crack_verdeg1', flotadores='$flotadoresg1', flotadores_rojo='$flotadores_rojog1', flotadores_verde='$flotadores_verdeg1', nom_analista='$elaboradoporg1', observaciones='$observacionesg1', id_usuario_modifica='$usuario_actualiza2', fecha_modifica='$fecha_entrada', hora_modifica='$hora_entrada' WHERE id_almacenaje='$cod_almacenajeg1' and id_empresa='$id_empresa'");
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
		   window.open('../reportes/Rp_otrosin_calidadentrada.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
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

<form role="form" name="formulario"  method="post" action="f_otros_indicadores.php">
<input type="hidden" name="indicador_otrosrecepcion" value="">
<input type="hidden" name="indicador_otrosdespacho" value="">
<input type="hidden" name="modificardatos" value="">

<input type="hidden" name="r_recepcion" value="">
<input type="hidden" name="r_despacho" value="">
<input type="hidden" name="bandera" value="0">
<input type="hidden"  name="reporte" value="<?PHP echo $_SESSION['cod_almacenaje']; ?>"> 
</form>

<div class="container-fluid">
  <div class="row" >
  <div class="col-md-13">
  <div class="panel panel-primary">
  <div class="panel-heading "><strong>INDICADORES </strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 
            <div class="row"><!-- INICIO ROW-->
                    <div class="col-md-12">
                        <div class="form-group">
                          
                          <label class="checkbox-inline">
                            <input type="radio" id="tipo_reporte" value="1" name="tipo_reporte" onclick="report_recepcion()" >  Recepción
                          </label>
                          <label class="checkbox-inline">
                          
                            <input type="radio" id="tipo_reporte" onclick="report_despacho()" value="2" name="tipo_reporte">  Despacho
                          </label>
                          </div>
                        </div>  
                  	</div> <!-- FIN ROW--> 
	
<div  style='display:none;' id="report_recepcion"> <!-- INICIA  REPORTE RECEPCION -->
<div class="row" >
<div class="col-md-12">
 	<div class="panel-heading bg-info"><strong>Recepción de Granos Básicos</strong></div> </div> <!-- PANEL 1 --->  
    <br>
    <br>
      <div class="panel-body">
      
<?php
$id_almacen="ALMACEN-0000000".$id_empresa;
	 $sql = "SELECT a.* FROM tab_almacenaje as a, tab_indicadoresrecepcion as b WHERE a.id_almacenaje=b.id_almacenaje AND a.id_almacenaje!='$id_almacen' and (a.tipo_peso=2 and a.peso_completo=1) and a.nuevo_indicador=1 AND a.id_empresa='$id_empresa' order by a.fecha_entrada desc, a.hora_entrada desc";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones2' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='130px'><div align='left'>ACCIONES</div></th>
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
		
		if ($result> 0){	
		while ($row = mysql_fetch_array($result)) 
		{
			 $id_empresa_busca=$row['id_cliente'];
			 $id_lote_busca=$row['id_lote'];
			 $id_silo_busca=$row['id_silo'];
			 $id_motorista_busca=$row['id_transportista'];
			 $usuario_busca=$row['id_usuario2'];
			 $usuario_modifica=$row['id_usuario_modifica'];	
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);
			 $peso_neto=$row['peso_bruto']-$row['peso_tara']; //Calcular el peso neto
			 $fecha_imprime2=parseDatePhp($row['fecha_usuario']);
			 $fecha_imprime_modif=parseDatePhp($row['fecha_modifica']);	

			if($row['opcion_peso']==1)$peso="PESO BRUTO";
			if($row['opcion_peso']==2)$peso="PESO TARA";	 
									
			$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa_busca' and id_empresa='$id_empresa'";
			$select2=mysql_query($tabla2,$con);
			while($row2=mysql_fetch_array($select2)) {
			$nom_empresa=$row2['nom_cliente'];
			$otros_idicadores=$row2['otros_indicadores'];
			}
				$tabla3="SELECT * FROM tab_lote WHERE id_lote='$id_lote_busca' and id_empresa='$id_empresa'";
				$select3=mysql_query($tabla3,$con);
				while($row3=mysql_fetch_array($select3)) {
				$num_lote=$row3['num_lote'];
				}
					$tabla4="SELECT * FROM tab_silo WHERE id_silo='$id_silo_busca' and id_empresa='$id_empresa'";
					$select4=mysql_query($tabla4,$con);
					while($row4=mysql_fetch_array($select4)) {
					$nom_silo=$row4['nom_silo'];
					}
						$tabla5="SELECT * FROM tab_transportista WHERE id_transportista='$id_motorista_busca' and id_empresa='$id_empresa'";
						$select5=mysql_query($tabla5,$con);
						while($row5=mysql_fetch_array($select5)) {
						$nom_transportista=$row5['nom_transportista']." ".$row5['ape_transportista'];
						$placa=$row5['placa_vehiculo'];
				
						}
		
		 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_busca' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario=$row_usuario['nombre_usuario'];
									}
								}
								
								 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_modifica' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario_modif=$row_usuario['nombre_usuario'];
									}
								}	
		if($otros_idicadores=="1"){												
											
		echo"<tr>
		<td width='130px' align='center'><a onClick='recepcion_boleta(\"".$row['id_almacenaje']."\");' style='cursor:pointer' title='Imprimir'><img src='../images/impresora.png' width='28px' height='28px'></a>
		<a data-toggle='modal' data-target='#ventana4' onClick='modificar(\"".$row['id_almacenaje']."\");' style='cursor:pointer' title='Modificar registro'><img src='../images/modificar_indicador.png' width='28px' height='28px'></a></td>
		
		   
          <td width='auto' align='center'> $row[entrada]</td>
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $nom_empresa </td>
  		  <td width='auto' align='left'> $placa </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $num_lote </td>
		  <td width='auto' align='left'> $nom_silo </td>
		  <td width='auto' align='left'> $row[peso_bruto] </td>
		  <td width='auto' align='left'> $row[peso_tara] </td>
		  <td width='auto' align='left'> $peso_neto </td>
		</tr>";
		$contar3++;
		}
		
		}
			
		$correlativo3++;		

		echo"</tbody>
	</table>
	";
}
	?>
    <!--Fin si se ha seleccionado administrador-->

<?php
//echo $correlativo;

echo "Total de Registros" ." ".$contar3;
 
?>
         </div>
</div>
</div>
</div> <!-- FIN DE RECEPCION -->
</div>

<div style='display:none;' id="report_despacho"> <!-- INICIA DESPACHO -->
<div class="row" >
<div class="col-md-12">
<div class="panel-heading bg-info"><strong>Despacho de Granos Básicos</strong></div> <!-- PANEL 1 --->  
<div class="panel-body" >
      
        
<?php
$id_salida="DESPACH-0000000".$id_empresa;
$sql = "SELECT a.* FROM tab_salida as a, tab_indicadoresdespacho as b WHERE a.id_salida=b.id_salida AND a.id_salida!='$id_salida' and (a.tipo_peso=1 and a.peso_completo=1) and a.nuevo_indicador=1 AND a.id_empresa='$id_empresa' order by a.fecha_entrada desc, a.hora_entrada desc";
 	 $result = mysql_query($sql,$con);
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
		
		if ($result> 0){	
		while ($row = mysql_fetch_array($result)) 
		{
			 $id_empresa_busca=$row['id_cliente'];
			 $id_lote_busca=$row['id_lote'];
			 $id_silo_busca=$row['id_silo'];
			 $id_motorista_busca=$row['id_transportista'];
			 $usuario_busca=$row['id_usuario2'];
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);
			 $peso_neto=$row['peso_bruto']-$row['peso_tara']; //Calcular el peso neto
			 
			if($row['opcion_peso']==1)$peso="PESO BRUTO";
			if($row['opcion_peso']==2)$peso="PESO TARA";	 
									
			$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa_busca' and id_empresa='$id_empresa'";
			$select2=mysql_query($tabla2,$con);
			while($row2=mysql_fetch_array($select2)) {
			$nom_empresa=$row2['nom_cliente'];
			}
				$tabla3="SELECT * FROM tab_lote WHERE id_lote='$id_lote_busca' and id_empresa='$id_empresa'";
				$select3=mysql_query($tabla3,$con);
				while($row3=mysql_fetch_array($select3)) {
				$num_lote=$row3['num_lote'];
				}
					$tabla4="SELECT * FROM tab_silo WHERE id_silo='$id_silo_busca' and id_empresa='$id_empresa'";
					$select4=mysql_query($tabla4,$con);
					while($row4=mysql_fetch_array($select4)) {
					$nom_silo=$row4['nom_silo'];
					}
						$tabla5="SELECT * FROM tab_transportista WHERE id_transportista='$id_motorista_busca' and id_empresa='$id_empresa'";
						$select5=mysql_query($tabla5,$con);
						while($row5=mysql_fetch_array($select5)) {
						$nom_transportista=$row5['nom_transportista']." ".$row5['ape_transportista'];
						$placa=$row5['placa_vehiculo'];
				
						}
		echo"<tr>
		<td width='60px' align='center'><a onClick='despacho_boleta(\"".$row['id_salida']."\");' style='cursor:pointer' title='Imprimir Reporte'><img src='../images/impresora.png' width='28px' height='28px'></a></td>	   
          <td width='auto' align='center'> $row[entrada]</td>
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $nom_empresa </td>
  		  <td width='auto' align='left'> $placa </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $num_lote </td>
		  <td width='auto' align='left'> $nom_silo </td>
		  <td width='auto' align='left'> $row[peso_bruto] </td>
		  <td width='auto' align='left'> $row[peso_tara] </td>
		  <td width='auto' align='left'> $peso_neto </td>
		</tr>";
		$contar4++;
		}
			
		$correlativo4++;		

		echo"</tbody>
	</table>
	";
}
	?>
    <!--Fin si se ha seleccionado administrador-->

<?php
//echo $correlativo;

echo "Total de Registros" ." ".$contar4;
 
?>
         </div>
</div>
</div>
</div> <!-- FIN DE DESAPACHO -->


</div> 
</div> 
</div>
</div>
</div> <!-- FIN DEL CUERPO-->

</div> <!--FIN DE REPORTE -->


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


<!-- INICIA MODAL DOMICILIO -->
<div class="modal fade" id="ventana4" >
<form name="indicador" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" >
<input type="hidden" name="banderaindicador" value="">
<input type="hidden" name="peso_bruto_uno" value="">
     <div class="modal-dialog">
          <div class="modal-content">                        
             <div id="feedbackindicador" class="modal-body" > 
          </div> 
          </div></div>  
                                 

    
<!-- SOLICITA PERMISO PARA ACTUALIZAR -->
<div class="modal fade" id="actualizar">
        <div class="modal-dialog">
          <div class="modal-content">                        
            <div class="modal-header">
               <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h3 class="modal-title">Modificar Registro</h3>
            </div>            
          <div class="modal-body"> 
          
            <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">USUARIO</label>
                       <input type="text" id="nom_usuario" name="nom_usuario" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" id="con_usuario" name="con_usuario"  class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
            <div class="modal-footer">
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button id="btnactualizar"  name="btnactualizar" onclick="actualizar()" class="btn btn-primary glyphicon glyphicon-cd center pull-right">  Actualizar</button>
               </div>
    </div>
    <div>               
  </div>                  
            
           </form> 
 </div><!-- Fin de formularios  Inicia la paginacion-->
     
</div>

