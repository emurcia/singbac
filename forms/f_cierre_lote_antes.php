<?PHP
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
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
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
 

// verifica permiso de escritura
$tabla="SELECT *  FROM t_usuarios where id_usuario='$id_usuario' and id_empresa='$id_empresa'";
 $result = mysql_query($tabla);
$array = mysql_fetch_assoc($result);
{
	$nivel1=$array['id_nivel'];
}

$sql_nivel = "SELECT * FROM tab_nivel WHERE id_nivel='$nivel1' and id_empresa='$id_empresa'";
								$result_ni = mysql_query($sql_nivel,$con);
								if ($result_ni > 0){	
                               		while ($row_nivel = mysql_fetch_assoc($result_ni)){
									 $nivel_mostrar=$row_nivel['nom_nivel'];
									 $pingresar=$row_nivel['ingresar'];
									 }
								}
								
date_default_timezone_set("America/El_Salvador");
$ano=date('Y');
$fecha=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../css/datepicker.css">
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script> 
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
<script src="../assets/javascript/chosen.jquery.js"></script>
</head> 
<script>
$(function (){
	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy', viewMode: 0  //0: dias, 1: meses, 2:años
	})
		.on('changeDate', function(ev){
		$('.datepicker').datepicker('hide');
		});
});
</script>

<script>
 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers"
	 });
});
</script>

<script type="text/javascript">
function cancelar(){
	document.formulario.btnguardar.disabled=false;
	}

function retirar_grano(){
	document.formulario_retirar.transaccion_almacena.value=document.formulario.transaccion1.value;
	document.formulario_retirar.destino_almacena.value=document.formulario.destino.value;
	document.formulario_retirar.observacion_almacena.value=document.formulario.observacion.value;	
	document.formulario_retirar.id_transportista_almacena.value=document.formulario.id_piloto2.value;
	document.formulario_retirar.neto_almacena.value=document.formulario.saldo_peso_neto.value;			
	document.formulario_retirar.saldo_peso_seco_almacena.value=document.formulario.saldo_peso_seco.value;					
	document.formulario_retirar.bandera_acciones.value="ok";
    document.formulario_retirar.submit(); 
   
}

function consultar(){
			document.formulario.seleccion.value=document.formulario.id_cliente2.value;
			document.formulario.id_lote_buscar.value=document.formulario.id_lote2.value;			
			document.formulario.bandera.value='ok';
			document.formulario.submit();
		
}// fin guardar

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
  function reporte(){
window.open('../reportes/Rp_despacho_retirar_grano.php?id='+document.formulario_retirar.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}

 function reporte_cierre(){
window.open('../reportes/Rp_cierre.php?id='+document.formulario_retirar.reporte2.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}
</script>

<script type="text/javascript">
       $(document).ready(function() {
	  
		   $('#id_cliente2').change(function() {//inicio1
			 $.post('lote_select.php', {id_cliente_busca:document.formulario.id_cliente2.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
			 }); 									 
		  });//fin1	
		 		  
       });
  </script>
<script>
        $(document).ready(function(){
		$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
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
if($pingresar==1){		
	$bandera_eli = $_POST['bandera_acciones'];
	if($bandera_eli=="ok"){
	  $retiro_cierre=$_POST['retiro_cierre'];
	  $nombre_usuario=$_POST['nombre_usuario']; // CORREO
	  $con_usuario=md5($_POST['con_usuario']);
	  $activo=1;
	  $empresa=$id_empresa;
	  $modificar=1;
 	// DATOS ALMANCENADOS EN SESIONES PARA ALMACENARLOS AL REALIZAR LA AUTORIZACION
	 $_SESSION['neto_almacena']=$_POST['neto_almacena'];
	 $_SESSION['destino_almacena']=$_POST['destino_almacena'];
	 $_SESSION['observacion_almacena']=$_POST['observacion_almacena'];	
	 $_SESSION['id_transportista_almacena']=$_POST['id_transportista_almacena'];	
	 $_SESSION['saldo_peso_seco_almacena']=$_POST['saldo_peso_seco_almacena'];	
	 $_SESSION['transaccion_almacena']=$_POST['transaccion_almacena'];		 

	$resultado = autorizar_mod($nombre_usuario,$con_usuario,$activo,$empresa,$modificar);	

	if($resultado==1 and $retiro_cierre==1){
		$guarda=800; // SOLO ACTUALIZAR EN TABLA LA BANDERA A 1 DE INACTIVO
		}else{	
		if($resultado==1 and $retiro_cierre=!0){
			$guarda=400; // Guarda
		}else{
			$error="3"; // no posee permisos
			}
		}
	}
}else {$error="4"; // no tiene permisos
   }//fin bandera ok	
?>

<?php	              
					$sql = "SELECT * FROM `tab_contador` where id_empresa='$id_empresa'"; 
					$result = mysql_query($sql); //usamos la conexion para dar un resultado a la variable
					if ($result> 0){ //si la variable tiene al menos 1 fila entonces seguimos con el codigo
					    while ($fila = mysql_fetch_array($result)) 
						{
							$cont_total=$fila['total'];
							$cod_entrada=$fila['salida_almacen'];
							$transaccion=$cont_total+1;
							$entrada=$cod_entrada+1; 	
						}
					}
?>

<?PHP
// INICIA EL GUARDADO DE INFORMACION 
// EXTRAE DATOS DEL USUARIO QUE AUTORIZA LA OPERACION
$tabla5="SELECT *  FROM t_usuarios where correo_usuario='$nombre_usuario' and pass_usuario='$con_usuario' and id_empresa='$id_empresa'";
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
			$id_usuario_modifica_guarda=$row5['id_usuario']; // USUARIO QUE AUTORIZA LA OPERACION
			
}

///// ------ DESACTTIVAR EL LOTE  -------------////////
if($guarda==800){
$sql = "SELECT * FROM `tab_contador` where id_empresa='$id_empresa'"; 
					$result = mysql_query($sql); //usamos la conexion para dar un resultado a la variable
					if ($result> 0){ //si la variable tiene al menos 1 fila entonces seguimos con el codigo
					    while ($fila = mysql_fetch_array($result)) 
						{
							$cont_total=$fila['total'];
							$cierre_lote=$fila['cierre_lote'];
							$transaccion2=$cont_total+1;
							$cierre_lote=$cierre_lote+1; 	
						}
					}	
	
	
$codigo2=1;	
$cod_lote_cierra= $_SESSION['cod_lote']; 	
$comentario_almacena=strtoupper($_SESSION['observacion_almacena']);
$fecha_usuario_guarda1=date('Y').'/'.date('m').'/'.date('d');
$hora_usuario_guarda1=date("H:i:s");
$cierra_lote= ("UPDATE tab_lote SET bandera=1, comentario_cierre='$comentario_almacena', id_usuario_desactiva='$id_usuario_modifica_guarda', fecha_desactiva='$fecha_usuario_guarda1',hora_desactiva='$hora_usuario_guarda1' WHERE id_lote='$cod_lote_cierra'  and id_empresa='$id_empresa'");

$cierra_lote2= ("UPDATE tab_detalle_servicio SET bandera=1 WHERE id_lote='$cod_lote_cierra'  and id_empresa='$id_empresa'");

 $sql_contador_lote= ("UPDATE `tab_contador` SET `total`='$transaccion2',`cierre_lote`='$cierre_lote' WHERE codigo='$codigo2' and id_empresa='$id_empresa'");
mysql_query($sql_contador_lote,$con);
mysql_query($cierra_lote,$con);
mysql_query($cierra_lote2,$con);
$error="200";
}

if($guarda==400)
   {//inicio if bandera ok
 //  SACAR TODO EL PRODUCTO DEL INVENTARIO  
$cod_seleccion= $_SESSION['cod_seleccion']; // CLIENTE
$cod_lote= $_SESSION['cod_lote']; 

	// codigo del kardex
$Result2 = mysql_query("SELECT MAX(id_kardex) as a  FROM tab_kardex where id_empresa='$id_empresa'  ORDER BY id_kardex") or die(mysql_error());
$dec3=mysql_fetch_assoc($Result2);
$a2=substr($dec3['a'],7,7);
if ($a2<9)
	{
	$num1 = "$a2"+"1";
	$nu1= "KARDEX-000000".$num1.$id_empresa;
	}else{if ($a2<99){
			$num1 = "$a2"+"1";
			$nu1= "KARDEX-00000".$num1.$id_empresa;
		}else{if($a2<999){
				$num1 = "$a2"+"1";
				$nu1= "KARDEX-0000".$num1.$id_empresa;
				}else{if($a2<9999){
					$num1 = "$a2"+"1";
					$nu1= "KARDEX-000".$num1.$id_empresa;
					}else{if($a2<99999){
						$num1 = "$a2"+"1";
						$nu1= "KARDEX-00".$num1.$id_empresa;
						}else{if($a2<999999){
							$num1 = "$a2"+"1";
							$nu1= "KARDEX-0".$num1.$id_empresa;
							}else{if($a2<9999999){
									$num1 = "$a2"+"1";
									$nu1= "KARDEX-".$num1.$id_empresa;
									}
								}
						}
					}
				}
			}
	}								




$cod1=$_SESSION['transaccion_almacena'];
$_SESSION['buscarrr']=$cod1;
$tabla_extrae="SELECT *  FROM tab_almacenaje where id_cliente='$cod_seleccion' and id_lote='$cod_lote' and id_empresa='$id_empresa'";
$select_extrae = mysql_query($tabla_extrae,$con);
while($row_extrae = mysql_fetch_array($select_extrae))
{
			$control_guarda=$entrada;
			$id_cliente_guarda=$row_extrae['id_cliente'];
			$id_lote_guarda=$row_extrae['id_lote'];
			$id_silo_guarda=$row_extrae['id_silo'];
			$id_servicio_guarda=$row_extrae['id_servicio'];
			$fecha_entrada_guarda=date('Y').'/'.date('m').'/'.date('d');
			$hora_entrada_guarda=date("H:i:s");
			$fecha_salida_guarda=date('Y').'/'.date('m').'/'.date('d');
			$hora_salida_guarda=date("H:i:s");		
			$peso_teorico_guarda=$row_extrae['peso_teorico'];
			$tipo_peso_guarda="2"; // INDICA PESAJE FINALIZADO
			$peso_bruto_guarda=	$_SESSION['neto_almacena'];
			$peso_tara_guarda="0"; // INDICA QUE PESO DE CAMION FUE 0, POR EL CIERRE
			$id_variable_guarda="VAR-000".$id_empresa;
			$peso_vol_guarda="0";
			$humedad_guarda="0";
			$temperatura_guarda="0";
			$grano_entero_guarda="0";
			$grano_quebrado_guarda="0";
			$dan_hongo_guarda="0";
			$impureza_guarda="0";
			$grano_chico_guarda="0";
			$grano_picado_guarda="0";
			$plaga_viva_guarda="0";
			$plaga_muerta_guarda="0";
			$stress_crack_guarda="0";
			$olor_guarda="";
			$destino_guarda=strtoupper($_SESSION['destino_almacena']);
			$observacion_guarda=strtoupper($_SESSION['observacion_almacena']);
			$bandera_guarda="3"; // INDICA QUE LA OPERACION HA SIDO PARA CERRAR EL LOTE
			$id_transportista_guarda=$_SESSION['id_transportista_almacena'];
			$vapor_guarda="";
			$nom_analista_guarda="";
			$neto_sin_humedad_guarda=$_SESSION['saldo_peso_seco_almacena'];
			$id_empresa_guarda=$id_empresa;
			$id_usuario2_guarda=$id_usuario;
			$ocupado_guarda="2";
			$fecha_usuario_guarda=date('Y').'/'.date('m').'/'.date('d');
			$hora_usuario_guarda=date("H:i:s");
			$codigo1="1";
			$fecha_modifica_guarda=date('Y').'/'.date('m').'/'.date('d');
			$hora_modifica_guarda=date("H:i:s");
}



$tablainve="SELECT * FROM tab_inventario WHERE id_lote='$id_lote_guarda' and id_empresa='$id_empresa'";
			$select_inve=mysql_query($tablainve,$con);
			while($row_inve=mysql_fetch_array($select_inve)) {
			$movimiento_lote1=$row_inve['movimiento_lote'];
			$peso_sin_humedad1=$row_inve['peso_sin_humedad'];
			$peso_sin_humedad_maximo1=$row_inve['peso_sin_humedad_maximo'];
			}

// RESTAR DATOS DEL INVETARIO POR SER REVERSION DE GRANOS POR LOTE.
		$peso_neto=$peso_bruto_guarda-$peso_tara_guarda;
		$movimiento_lote_guardar=$movimiento_lote1-$peso_neto;
		$peso_sin_humedad_guardar=$peso_sin_humedad1-$neto_sin_humedad_guarda;
		$peso_sin_humedad_maximo_guarda=$peso_sin_humedad_maximo1-$neto_sin_humedad_maximo_guarda;
		

		$sql= "insert into tab_salida(id_salida, entrada, id_cliente, id_lote, id_silo, id_servicio, fecha_entrada, hora_entrada, fecha_salida, hora_salida, peso_teorico, tipo_peso, peso_bruto, peso_tara, id_variable, peso_vol, humedad, temperatura, grano_entero, grano_quebrado, dan_hongo, impureza, grano_chico, grano_picado, plaga_viva, plaga_muerta, stress_crack, olor, destino, observacion,  bandera, id_transportista, vapor, nom_analista, peso_sin_humedad, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values ('$cod1', '$control_guarda', '$id_cliente_guarda', '$id_lote_guarda', '$id_silo_guarda', '$id_servicio_guarda', '$fecha_entrada_guarda', '$hora_entrada_guarda', '$fecha_salida_guarda', '$hora_salida_guarda', '$peso_teorico_guarda', '$tipo_peso_guarda', '$peso_bruto_guarda', '$peso_tara_guarda', '$id_variable_guarda', '$peso_vol_guarda', '$humedad_guarda', '$temperatura_guarda', '$grano_entero_guarda', '$grano_quebrado_guarda', '$dan_hongo_guarda', '$impureza_guarda', '$grano_chico_guarda', '$grano_picado_guarda', '$plaga_viva_guarda', '$plaga_muerta_guarda', '$stress_crack_guarda', '$olor_guarda', '$destino_guarda', '$observacion_guarda', '$bandera_guarda', '$id_transportista_guarda', '$vapor_guarda', '$nom_analista_guarda', '$neto_sin_humedad_guarda', '$id_empresa_guarda', '$id_usuario2_guarda', '$ocupado_guarda', '$fecha_entrada_guarda', '$hora_entrada_guarda', '$id_usuario_modifica_guarda', '$fecha_modifica_guarda', '$hora_modifica_guarda')";
		mysql_query($sql,$con);

if(mysql_error())
		  { 
			$error="1";
		  }
			  else{
				  $sql_inv= ("UPDATE `tab_inventario` SET `movimiento_lote`='$movimiento_lote_guardar',  peso_sin_humedad='$peso_sin_humedad_guardar', peso_sin_humedad_maximo='$peso_sin_humedad_maximo_guarda' WHERE id_lote='$id_lote_guarda' and id_empresa='$id_empresa'");
				   mysql_query($sql_inv,$con);
				   
				   $sql_contador= ("UPDATE `tab_contador` SET `total`='$transaccion',`salida_almacen`='$entrada' WHERE codigo='$codigo1' and id_empresa='$id_empresa'");
				   mysql_query($sql_contador,$con);
				   
					$error="2";
			  }
	}//fin bandera ok		
   
?>  

<body class="container" <?PHP if($error == 2) echo "onload='reporte()'";  if($error == 200) echo "onload='reporte_cierre()'; "; ?> > 


<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->

<?PHP include('menu.php'); ?>

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
 if($error == 1)
 {
	  echo '<div class="alert alert-success">
 			<a href="f_cierre_lote.php" class="alert-link">Error en el procesamiento de datos '.$id_usuario_modifica_guarda,'!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == 2)
 {
	 unset($_SESSION['codigo']);
	 unset($_SESSION['cod_seleccion']);
	 unset($_SESSION['cod_lote']);
	 echo '<div class="alert alert-success">
 						  <a href="f_cierre_lote.php" class="alert-link">Datos Almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }

 if($error == 200)
 {
	 unset($_SESSION['codigo']);
	 unset($_SESSION['cod_seleccion']);
	 unset($_SESSION['cod_lote']);
	 echo '<div class="alert alert-success">
 						  <a href="f_cierre_lote.php" class="alert-link">Lote Cerrado correctamente!!! Haga click para continuar .....</a>
						  </div>';
	  }
	  
if($error == 3)
 {
	 echo '<div class="alert alert-danger">
 						  <a href="f_cierre_lote.php" class="alert-link">No tiene permiso para revertir registro'.$retiro_cierre.',!!! Haga click para continuar .....</a>
						  </div>';
	  }	 

if($error==4){
echo '<div class="alert alert-danger">
 						  <a href="f_cierre_lote.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';
}	   
 ?>
 

  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>CIERRE DE LOTE</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
          		<form action="f_cierre_lote.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="0" type="hidden" />     
	       <input type="hidden"  name="busca">
	       <input type="hidden"  name="seleccion">   
	       <input type="hidden"  name="id_lote_buscar" value="">                    
            <input type="hidden" name="fecha_inicio11">
            <input type="hidden" name="fecha_fin11">  
            <input type="hidden"  name="lot" value="<?PHP echo $_POST['id_lote2']; ?>">  
         
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>NOMBRE CLIENTE</label>
              <?php
			  $id_cli="CLI-000".$id_empresa;
                	$tabla=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente!='$id_cli' and id_empresa='$id_empresa'",$con); //
				?>
                      <select name="id_cliente2" class="form-control input-lg chosen" size="1" id="id_cliente2">
                            <option value="TODOS">SELECCIONE CLIENTE</option>
							 <?php 
								while($valor=mysql_fetch_array($tabla)){
									
									$codigo_usu= $valor['id_cliente'];
									$nombre_usu= $valor['nom_cliente'];
									echo "<option value='$codigo_usu'>";
									echo ($nombre_usu);
									echo"</option>";  
          					}	
							?>
                          </select>
                              
                  </div>
              </div>
           
				 <div class="col-md-6">
              <div class="form-group">
               <label for="lote">LOTE</label>
                <div id="feedback"><select name="id_lote2" id="id_lote2" class="form-control input-lg chosen"><option value="">SELECCIONE LOTE</option></select></div>
                  </div>
              </div>      
            </div> <!-- fin -->
                
 <br />
   <table width="220" border="0" align="right">
   	    <tr>
  	      <td><input type="submit" name="btnconsultar" onclick="consultar()" value="Consultar" class="btn btn-info btn-lg pull-right" > </button></td>
   	    </tr>
    </table> 
	
</div>
</div>

<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>DATOS DEL LOTE </strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>
<?php
						
 if($bandera=="ok" )
   {//
 $seleccion1=$_POST['seleccion']; // CLIENTE
 $lote_busca=$_POST['id_lote_buscar'];  
 $_SESSION['cod_seleccion']=$seleccion1;
 $_SESSION['cod_lote']=$lote_busca;
 $_SESSION['cod_lote_reporte']=$_POST['id_lote_buscar'];
 $contar4=0;
$sql_entrada = "SELECT sum(a.peso_bruto-a.peso_tara) as peso_neto_entrada, round(sum(neto_sin_humedad),2) as neto_sin_humedad, a.fecha_entrada, b.*, c.* FROM tab_almacenaje as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$seleccion1' and a.id_lote='$lote_busca' and a.bandera=2 and a.id_empresa='$id_empresa'";
 
 $sql_salida = "SELECT sum(a.peso_bruto-a.peso_tara) as peso_neto_salida, sum(a.peso_sin_humedad) as peso_sin_humedad_salida, b.*, c.* FROM tab_salida as a, tab_cliente as b, tab_lote as c WHERE a.id_cliente=b.id_cliente and a.id_lote=c.id_lote and a.id_cliente='$seleccion1' and a.id_lote='$lote_busca' and (a.bandera=2 or a.bandera=3) and a.id_empresa='$id_empresa'";
 
$sql_salida2="SELECT MAX(a.fecha_entrada) as fecha_entrada FROM tab_salida as a WHERE a.id_cliente='$seleccion1' and a.id_lote='$lote_busca' and a.id_empresa='$id_empresa'";
	            
		 $result = mysql_query($sql_entrada);
					if ($result > 0){	
                       	$correlativo1 = 1;
						while ($row = mysql_fetch_assoc($result)) 
                            {	
							$contar4++;
							$nom_cliente=$row['nom_cliente'];
							$num_lote=$row['num_lote'];
							$id_silo=$row['id_silo'];
							$id_producto1=$row['id_producto'];
							$id_subproducto1=$row['id_subproducto'];
							$fecha_entrada1=parseDatePhp($row['fecha_entrada']);	
							$peso_entrada1=$row['peso_neto_entrada'];
							$peso_seco_entrada1=$row['neto_sin_humedad'];
		// EXTRAER NOMBRE DEL PRODUCTO										
$tabla2="SELECT *  FROM tab_producto where id_producto='$id_producto1' and id_empresa='$id_empresa'";
		$select2 = mysql_query($tabla2,$con);
				while($row2 = mysql_fetch_array($select2))
					{
					$nom_producto1=$row2['nom_producto'];
					}
		// EXTRAER DATOS DEL SILO										
		$tabla_silo="SELECT * FROM tab_silo where id_silo='$id_silo' and id_empresa='$id_empresa'";
						$select_silo = mysql_query($tabla_silo,$con);
						while($row_silo = mysql_fetch_array($select_silo))
							{
								$nom_silo=$row_silo['nom_silo'];
							}
														
		// EXTRAER DATOS DEL SUBPRODUCTO							
		$tabla3="SELECT *  FROM tab_subproducto where id_subproducto='$id_subproducto1' and id_empresa='$id_empresa'";
							$select3 = mysql_query($tabla3,$con);
							while($row3 = mysql_fetch_array($select3))
							{
								$nom_subproducto1=$row3['nom_subproducto'];
							}							
		// EXTRAER DATOS DE SALIDA DE GRANOS					
							$result2 = mysql_query($sql_salida);
							while ($row2 = mysql_fetch_assoc($result2)) 
                            {
								$peso_neto_salida1=$row2['peso_neto_salida'];	
								$fecha_salida1=parseDatePhp($row2['fecha_entrada']);
								$peso_seco_salida=round($row2['peso_sin_humedad_salida'],2);
							}		
		// EXTRAER ULTIMA FECHA DE SALIDA DE GRANOS BASICOS							
							$result3 = mysql_query($sql_salida2);
							while ($row3 = mysql_fetch_assoc($result3)) 
                            {
								$fecha_salida1=parseDatePhp($row3['fecha_entrada']);
							}		
							
							$diferencia=$peso_seco_entrada1-$peso_neto_salida1;
							$ban=0;
							
							if ($diferencia<=0){
								$peso_seco_entrada=$peso_seco_entrada1+($diferencia*-1);
								$ban=1;
								}
							}            
                    }
					
					
$Result1 = mysql_query("SELECT MAX(id_salida) as a  FROM tab_salida where id_empresa='$id_empresa' ORDER BY id_salida") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],8,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "DESPACH-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "DESPACH-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "DESPACH-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "DESPACH-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "DESPACH-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "DESPACH-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "DESPACH-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}		   
		
  ?>
  
   <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="transaccion">CODIGO</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $nu;?>" id="transaccion1"   name="transaccion1" autocomplete="off" style="background:#FFF;" readonly>
                      
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="entrada">ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $entrada;?>" id="entrada1"  name="entrada1" autocomplete="off" style="background:#FFF;" readonly>
                        
                              
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
           <div class="row">
			<div class="col-md-6">
              <div class="form-group">
               <label for="nombre_cliente">Cliente</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $nom_cliente; ?>"   name="nom_cliente" style="background:#FFF" readonly  id="nom_cliente" autocomplete="off">
            	</div>
             </div>  
             <div class="col-md-3">
              <div class="form-group">
               <label for="nombre_cliente">Lote</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $num_lote; ?>"   name="num_lote" style="background:#FFF" readonly  id="num_lote" autocomplete="off">
            	</div>
             </div>  
		<div class="col-md-3">
              <div class="form-group">
               <label for="nombre_cliente">SILO</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $nom_silo; ?>"   name="nom_silo" style="background:#FFF" readonly  id="nom_silo" autocomplete="off">
            	</div>
             </div>                   
          </div> <!-- fin -->
          <div class="row">
           <div class="col-md-6" >
              <div class="form-group">
               <label for="moneda_servicio">Servicios del lote</label>
                 <?PHP
               $tabla_servicio=mysql_query("SELECT * FROM tab_servicio as a, tab_detalle_servicio as b WHERE a.id_servicio=b.id_servicio and b.id_lote = '$lote_busca' and b.id_cliente = '$seleccion1' and a.id_empresa='".$id_empresa."' and a.bandera=0");
			   ?>
              <div id="feedback3"> <select size="5" name="id_servicio2" id="id_servicio2" class="form-control input-lg" style="height: auto; background:#FFF;" > 
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
			<div class="col-md-6">
              <div class="form-group">
               <label for="nombre_cliente">Producto</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $nom_producto1; ?>"   name="nom_producto" style="background:#FFF" readonly  id="nom_producto" autocomplete="off">
            	</div>
             </div> 
             <div class="col-md-6">
              <div class="form-group">
               <label for="nombre_cliente">Subproducto</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $nom_subproducto1; ?>"   name="nom_subproducto" style="background:#FFF" readonly  id="nom_subproducto" autocomplete="off">
            	</div>
             </div>     
          </div> <!-- fin -->
           <div class="row">
			<div class="col-md-6">
              <div class="form-group">
               <label for="nombre_cliente">Fecha entrada</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $fecha_entrada1; ?>"   name="fecha_entrada" style="background:#FFF" readonly  id="fecha_entrada" autocomplete="off">
            	</div>
             </div> 
             <div class="col-md-6">
              <div class="form-group">
               <label for="nombre_cliente">Fecha última salida</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $fecha_salida1; ?>"   name="fecha_salida" style="background:#FFF" readonly  id="fecha_salida" autocomplete="off">
            	</div>
             </div>     
          </div> <!-- fin -->
             
          <div class="row"> <!-- INICIA ROw-->
			<div class="col-md-4">
              <div class="form-group">
               <label for="nombre_cliente">Peso Neto entrada</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $peso_entrada1; ?>"   name="peso_neto_entrada" style="background:#FFF" readonly  id="peso_neto_entrada" autocomplete="off">
            	</div>
             </div> 
             <div class="col-md-4">
              <div class="form-group">
               <label for="nombre_cliente">Peso neto salida</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $peso_neto_salida1; ?>"   name="peso_neto_salida" style="background:#FFF" readonly  id="peso_neto_salida" autocomplete="off">
            	</div>
             </div>   
             <div class="col-md-4">
              <div class="form-group">
               <label for="nombre_cliente">Saldo peso neto</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo ($peso_entrada1-$peso_neto_salida1); ?>"   name="saldo_peso_neto" style="background:#FFF" readonly  id="saldo_peso_neto" autocomplete="off">
            	</div>
             </div>     
          </div> <!-- fin -->
          <div class="row">
			<div class="col-md-4">
              <div class="form-group">
               <label for="nombre_cliente">Peso seco entrada</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $peso_seco_entrada1; ?>"   name="peso_seco_entrada" style="background:#FFF" readonly  id="peso_seco_entrada" autocomplete="off">
            	</div>
             </div> 
             <div class="col-md-4">
              <div class="form-group">
               <label for="nombre_cliente">Peso seco salida</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $peso_seco_salida; ?>"   name="peso_seco_salida" style="background:#FFF" readonly  id="peso_seco_salida" autocomplete="off">
            	</div>
             </div>   
             <div class="col-md-4">
              <div class="form-group">
               <label for="nombre_cliente">Saldo peso seco</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo ($peso_seco_entrada1-$peso_seco_salida); ?>"   name="saldo_peso_seco" style="background:#FFF" readonly  id="saldo_peso_seco" autocomplete="off">
            	</div>
             </div>     
          </div> <!-- fin -->
          
          
          <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">Piloto</label>
               <?PHP
               $tabla_transportista=mysql_query("SELECT * FROM tab_transportista WHERE id_cliente = '$seleccion1' and id_empresa='$id_empresa'");
			   ?>
			<select name="id_piloto2" id="id_piloto2" if(<?php if($ban==1){ ?> disabled <?php } ?>) class="chosen" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;">
     		<option value='0'> SELECCIONE TRANSPORTISTA</option>
		<?PHP					  
		while($valor=mysql_fetch_array($tabla_transportista)){
			$codigo_trans= $valor['id_transportista'];
			$nombre= $valor['nom_transportista']." ".$valor['ape_transportista'];
			echo "<option value='$codigo_trans'>";
			echo ("$nombre");
			echo"</option>";
		}	
		?>
     </select>
               </div>
			</div>
         <div class="col-md-6">
         <div class="form-group">
              <label>Destino</label>
             <input type="text" class="form-control input-lg" id="destino" if(<?php if($ban==1){ ?> disabled <?php } ?>) name="destino"  placeholder="DESTINO DEL PRODUCTO" autocomplete="off" style="text-transform:uppercase;" >
                  </div>
      		</div>
          </div>
           </div>	<!-- FIN -->
        
           
           <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="Comentarios">Comentarios</label>
             <textarea name="observacion" class="form-control" rows="3" placeholder="Comentarios" autocomplete="off" id="observacion" style="text-transform:uppercase"></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
 	<?php }//fin bandera ok	?>
<br>
 </form>	
 
<?php if($contar4!=0  and $nom_cliente!=""){ ?>

<table border="0" align="center" width="auto">
 <tr>
 <?php if($ban!=1){ ?>
 <td width="auto">
<button type="button" name="btnguardar" data-toggle="modal" data-target="#ventana4" value="Retirar" class="btn btn-primary btn-lg pull-right"> Retirar</button>
<td width="20px">&nbsp;</td>
  <?php } ?>
   <?php if($ban==1){ ?>
 <td width="auto">
<button name="btnguardar" data-toggle="modal" data-target="#ventana4" value="cerrar" class="btn btn-primary btn-lg pull-right" >   Cerrar </button></td>
   <?php } ?>
 <td width="20px">&nbsp;</td>
 <td width="auto"><button name="btn_reporte" onclick="reporte_excel()" value="cancelar" class="btn btn-danger btn-lg pull-right" > Cancelar</button></td>
              	    </tr>
           	      </table>             
<?php }?>

</div>
</div>
 </div>    
 </div>   
 </div>
</div>
 </div>  
 </div>
</div>   
</div>  
</div>
<br>
<br>
<br>


<!--  INICIO FOOTER   -->
<div class="navbar navbar-inverse navbar-fixed-bottom" >
   <div class="container">
      <p align="center" class="navbar-text">
         Diseñado y Desarrollado Por <a href="http://www.ie-networks.com/">Ie Networks</a> © 2017.
      </p>
   </div>
</div>
<!-- FIN FOOTER  -->

</body> 
</html>

<!------------ AUTORIZACION ----->
<div class="modal fade" id="ventana4" tabindex="1" role="dialog">
<form id="formulario_retirar" name="formulario_retirar" action="f_cierre_lote.php" method="post">
<input type="hidden" name="id_eliminar" value="0">
<input type="hidden" name="bandera_acciones" value="">
<input type="hidden" name="transaccion_almacena" value="">
<input type="hidden" name="destino_almacena" value="">
<input type="hidden" name="observacion_almacena" value="">
<input type="hidden" name="id_transportista_almacena" value="">
<input type="hidden" name="neto_almacena" value="">
<input type="hidden" name="saldo_peso_seco_almacena" value="">
<input type="hidden" name="comentario_cierre" value="">
<input type="hidden" name="retiro_cierre" value="<?PHP echo $ban; ?>">
<input type="hidden"  name="reporte" value="<?PHP echo $_SESSION['buscarrr']; ?>"> 
<input type="hidden"  name="reporte2" value="<?PHP echo $_SESSION['cod_lote_reporte']; ?>"> 

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
                       <input type="text" name="nombre_usuario" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" name="con_usuario"  class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
            <div class="modal-header">
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               	<button class="btn btn-primary" type="submit" onClick="retirar_grano()">Autorizar</button>
            </div>    
    </div>
    <div>               
  </div>                  
            
           </form> 
           
</div>
