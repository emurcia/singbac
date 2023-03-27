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
  
?>
<?PHP
$tabla="SELECT *  FROM tab_salida where id_salida='$_POST[r_despacho]' and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
			$cod=$row['id_salida'];
			$control=$row['entrada'];
			$id_empresa_busca=$row['id_cliente'];
			$id_lote_busca=$row['id_lote'];
			$id_silo_busca=$row['id_silo'];
			$id_motorista_busca=$row['id_transportista'];
			$fecha_recepcion=parseDatePhp($row['fecha_entrada']);
			$hora_recepciion=$row['hora_entrada'];
			$peso_bruto=$row['peso_bruto'];
			$peso_tara=$row['peso_tara'];
			$peso_neto=$row['peso_bruto']-$row['peso_tara']; //Calcular el peso neto
			$peso_sin_humedad=round($row['neto_sin_humedad'],2); 
			
									
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
	
}
date_default_timezone_set("America/El_Salvador");
$fecha=date('d').'/'.date('m').'/'.date('Y');
$fecha2=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s")	
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../assets/stylesheet/caja_buscar.css">
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">

</head> 

<script  languaje="javascript" type="text/javascript" >
function activar_boton() //funcionar para activas las cajas de textos
  {	
		if (document.formulario1.activar.checked==false){
			document.formulario1.btnguardar.disabled=true;
			}else{
				document.formulario1.btnguardar.disabled=false;
			}
  }

function cancelar(){
		document.location.href='f_reversion.php';	
	}
	
function salirr()
 {	 
    document.formulario1.bandera.value="oki";
    document.formulario1.submit();       
 }
 
 function datos(){
	 window.open('../reportes/Rp_reversion_despacho.php?id='+document.formulario1.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
	
}

</script>
<script>
function actualizar()
{
	document.formulario1.bandera_acciones.value="ok";
    document.formulario1.submit(); 
   
}
</script>
<?PHP // cierre de sesion por medio del boton
	 $bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
       echo "document.location.href='sesion_destruida.php';";
	}//Fin if bandera ok
	 echo "</script>";
?>
<?PHP
	 $bandera_eli = $_POST['bandera_acciones'];
	if($bandera_eli=="ok"){
	  $nombre_usuario=$_POST['nombre_usuario']; // CORREO
	  $con_usuario=md5($_POST['con_usuario']);
	  $activo=1;
	  $empresa=$id_empresa;
	  $modificar=1;
 	 $cod2= $_POST["id_salida"];
	 $_SESSION['codigo']=$cod2;

$resultado = autorizar_mod($nombre_usuario,$con_usuario,$activo,$empresa,$modificar);	
	
	if($resultado==1){
		$guarda=400; // Guarda
	}else{
		$error="3"; // no posee permisos
		}
	}
?>

<?php	              
					$sql = "SELECT * FROM `tab_contador` where id_empresa='$id_empresa'"; 
					$result = mysql_query($sql); //usamos la conexion para dar un resultado a la variable
					if ($result> 0){ //si la variable tiene al menos 1 fila entonces seguimos con el codigo
					    while ($fila = mysql_fetch_array($result)) 
						{
							$cont_total=$fila['total'];
							$cod_entrada=$fila['reversion_salida'];
							$transaccion=$cont_total+1;
							$entrada=$cod_entrada+1; 	
						}
					}
?>

<?PHP

// INICIA EL GUARDADO DE INFORMACION 
$bandera = $_POST['bandera'];
$cod1= $_POST["id_salida"];

$Result1 = mysql_query("SELECT MAX(id_reversion) as a  FROM tab_reversion where id_empresa='$id_empresa' ORDER BY id_reversion asc ") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],8,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "REVERSI-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "REVERSI-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "REVERSI-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "REVERSI-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "REVERSI-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "REVERSI-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "REVERSI-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}

if($guarda==400)
   {//inicio if bandera ok
$tabla5="SELECT *  FROM t_usuarios where correo_usuario='$nombre_usuario' and pass_usuario='$con_usuario' and id_empresa='$id_empresa'";
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_revierte1=$row5['id_usuario'];
}
 
$tabla_extrae="SELECT *  FROM tab_salida where id_salida='$cod1' and id_empresa='$id_empresa'";
$select_extrae = mysql_query($tabla_extrae,$con);
while($row_extrae = mysql_fetch_array($select_extrae))
{
			$cod=$row_extrae['id_salida'];
			$control_guarda=$row_extrae['entrada'];
			$id_cliente_guarda=$row_extrae['id_cliente'];
			$id_lote_guarda=$row_extrae['id_lote'];
			$id_silo_guarda=$row_extrae['id_silo'];
			$id_servicio_guarda=$row_extrae['id_servicio'];
			$fecha_entrada_guarda=$row_extrae['fecha_entrada'];
			$hora_entrada_guarda=$row_extrae['hora_entrada'];
			$fecha_salida_guarda=$row_extrae['fecha_salida'];
			$hora_salida_guarda=$row_extrae['hora_salida'];			
			if ($row_extrae['peso_teorico']==""){$peso_teorico_guarda="0.00";}else{$peso_teorico_guarda=$row_extrae['peso_teorico'];}
			$tipo_peso_guarda=$row_extrae['tipo_peso'];
			$peso_bruto_guarda=$row_extrae['peso_bruto'];
			$peso_tara_guarda=$row_extrae['peso_tara'];
			$id_variable_guarda=$row_extrae['id_variable'];
			$peso_vol_guarda=$row_extrae['peso_vol'];
			$humedad_guarda=$row_extrae['humedad'];
			$temperatura_guarda=$row_extrae['temperatura'];
			$grano_entero_guarda=$row_extrae['grano_entero'];
			$grano_quebrado_guarda=$row_extrae['grano_quebrado'];
			$dan_hongo_guarda=$row_extrae['dan_hongo'];
			$impureza_guarda=$row_extrae['impureza'];
			$grano_chico_guarda=$row_extrae['grano_chico'];
			$grano_picado_guarda=$row_extrae['grano_picado'];
			$plaga_viva_guarda=$row_extrae['plaga_viva'];
			$plaga_muerta_guarda=$row_extrae['plaga_muerta'];
			$stress_crack_guarda=$row_extrae['stress_crack'];
			$olor_guarda=$row_extrae['olor'];
			$destino_guarda=$row_extrae['destino'];
			$observacion_guarda=$row_extrae['observacion'];
			$bandera_guarda=$row_extrae['bandera'];
			$id_transportista_guarda=$row_extrae['id_transportista'];
			$vapor_guarda=$row_extrae['vapor'];
			$nom_analista_guarda=$row_extrae['nom_analista'];
			if($row_extrae['neto_sin_humedad']==""){$neto_sin_humedad_guarda="0.00";}else{$neto_sin_humedad_guarda=$row_extrae['neto_sin_humedad'];}
			
			$id_empresa_guarda=$row_extrae['id_empresa'];
			if($row_extrae['neto_sin_humedad_maximo']==""){$neto_sin_humedad_maximo_guarda="0.00";}else{$neto_sin_humedad_maximo_guarda=$row_extrae['neto_sin_humedad_maximo'];}
			//$neto_sin_humedad_maximo_guarda=$row_extrae['neto_sin_humedad_maximo'];
			$id_usuario2_guarda=$row_extrae['id_usuario2'];
			$ocupado_guarda=$row_extrae['ocupado'];
			$fecha_usuario_guarda=$row_extrae['fecha_usuario'];
			$hora_usuario_guarda=$row_extrae['hora_usuario'];
			$id_usuario_modifica_guarda=$row_extrae['id_usuario_modifica'];
			$fecha_modifica_guarda=$row_extrae['fecha_modifica'];
			$hora_modifica_guarda=$row_extrae['hora_modifica'];
			$tipo_reversion="2"; // Despacho de granos
			$usuario_revierte=$usuario_revierte1;
			$fecha_revierte=$fecha2;
			$hora_revierte=$hora;
			$comentario=strtoupper($_POST['desc']);
			$codigo1="1";
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
		$movimiento_lote_guardar=$movimiento_lote1+$peso_neto;
		$peso_sin_humedad_guardar=$peso_sin_humedad1+$neto_sin_humedad_guarda;
		$peso_sin_humedad_maximo_guarda=$peso_sin_humedad_maximo1+$neto_sin_humedad_maximo_guarda;
		
 
      if(isset($cod1)){
		$sql= mysql_query("insert into tab_reversion(id_reversion, id_almacenaje, entrada, control, id_cliente, id_lote, id_silo, id_servicio, fecha_entrada, hora_entrada, fecha_salida, hora_salida, peso_teorico, tipo_peso, peso_bruto, peso_tara, id_variable, peso_vol, humedad, temperatura, grano_entero, grano_quebrado, dan_hongo, impureza, grano_chico, grano_picado, plaga_viva, plaga_muerta, stress_crack, olor, destino, observacion, bandera, id_transportista, vapor, nom_analista, neto_sin_humedad, id_empresa, neto_sin_humedad_maximo, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica, tipo_reversion, usuario_revierte, fecha_revierte, hora_revierte, comentario) values ('$nu', '$cod', '$control_guarda', '$entrada', '$id_cliente_guarda', '$id_lote_guarda', '$id_silo_guarda', '$id_servicio_guarda', '$fecha_entrada_guarda', '$hora_entrada_guarda', '$fecha_salida_guarda', '$hora_salida_guarda', '$peso_teorico_guarda', '$tipo_peso_guarda', '$peso_bruto_guarda', '$peso_tara_guarda', '$id_variable_guarda', '$peso_vol_guarda', '$humedad_guarda', '$temperatura_guarda', '$grano_entero_guarda', '$grano_quebrado_guarda', '$dan_hongo_guarda', '$impureza_guarda', '$grano_chico_guarda', '$grano_picado_guarda', '$plaga_viva_guarda', '$plaga_muerta_guarda', '$stress_crack_guarda', '$olor_guarda', '$destino_guarda', '$observacion_guarda', '$bandera_guarda', '$id_transportista_guarda', '$vapor_guarda', '$nom_analista_guarda', '$neto_sin_humedad_guarda', '$id_empresa_guarda', '$neto_sin_humedad_maximo_guarda','$id_usuario2_guarda', '$ocupado_guarda', '$fecha_entrada_guarda', '$hora_entrada_guarda', '$id_usuario_modifica_guarda', '$fecha_modifica_guarda', '$hora_modifica_guarda', '$tipo_reversion', '$usuario_revierte', '$fecha_revierte', '$hora_revierte', '$comentario')") or die (mysql_error());
		//mysql_query($sql,$con)  or die(mysql_error());
		  }
if(mysql_error())
		  { 
		  echo mysql_error();
			$error="1";
		  }
			  else{
				  $sql_inv= ("UPDATE `tab_inventario` SET `movimiento_lote`='$movimiento_lote_guardar',  peso_sin_humedad='$peso_sin_humedad_guardar', peso_sin_humedad_maximo='$peso_sin_humedad_maximo_guarda' WHERE id_lote='$id_lote_guarda' and id_empresa='$id_empresa'");
				   mysql_query($sql_inv,$con);
				   
				   $sql_contador= ("UPDATE `tab_contador` SET `total`='$transaccion',`reversion_salida`='$entrada' WHERE codigo='$codigo1' and id_empresa='$id_empresa'");
				   mysql_query($sql_contador,$con);
				   
				   mysql_query("DELETE FROM tab_salida WHERE id_salida = '$cod' AND id_empresa='$id_empresa';",$con);
					$error="2";
			  }
	}//fin bandera ok		
   
?>   

<body class="container" <?PHP if($error == 2) echo "onload='datos()';";?>> 


<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

 
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
   
   <!-- menu -->
      <ul id="menu-bar">
     <?PHP
      $indicadorul = 0;
      $indicadorli = 1;
     // $consulta = mysql_query("SELECT * FROM tab_menu",$con);
	 $consulta = mysql_query("SELECT a.opcion_menu, a.url_menu, a.acceso_menu, a.nivel_menu FROM tab_menu as a, tab_detalle_menu as b, t_empresa as c WHERE a.id_menu=b.id_menu and b.id_nivel='".$acceso."' and b.id_empresa='$id_empresa' and c.estado='$estado' GROUP by a.id_menu ",$con);
      while($fila = mysql_fetch_array($consulta)){
          if((($fila['acceso_menu']==0) || ($fila['acceso_menu']==$acceso)) && (!empty($acceso))){
              if(($fila['nivel_menu']==2) && ($indicadorul==0)){  echo "<ul class='dropdown-menu'>"; $indicadorul=1; }
              if(($fila['nivel_menu']==1) && ($indicadorul==1)){  echo "</ul>"; $indicadorul=0; }
              
              if(($fila['nivel_menu']==1) && ($indicadorli == 0)){echo "</li>";$indicadorli=1;}
               
              if($fila['id_menu']==1)//Menu de inicio(index.php) debe de ir sin 'forms/'
                  echo "<li><div align='left'><a  href='../".utf8_encode($fila['url_menu'])."'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
              else{
                  if($fila['nivel_menu']==2)
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
                  else{
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a>";
                      $indicadorli = 0;
                  }			  
              }
          }
      }
      echo "</li>";
     ?>

      <li><a><?PHP echo $_SESSION['nombre_usuario_silo']; ?></a></li>
      <li><a onClick="salirr()"><button type="button" class="btn btn-danger btn-xs">Cerrar Sesión</button></a></li>
          
</ul>
    </div>
    
</nav>

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
 			<a href="f_reversion.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == 2)
 {
	 unset($_SESSION['codigo']);
	 echo '<div class="alert alert-success">
 						  <a href="f_reversion.php" class="alert-link">Datos Almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }

if($error == 3)
 {
	 echo '<div class="alert alert-danger">
 						  <a href="f_reversion.php" class="alert-link">No tiene permiso para revertir registro!!! Haga click para continuar .....</a>
						  </div>';
	  }	  
 ?>

            <!-- Formulario para modificar origen -->
<form role="form" name="formulario1"  method="post" action="f_revertir_despacho.php">
	<input type="hidden"  name="bandera" value="0">
	<input type="hidden" name="bandera_acciones" value=""> 
	<input type="hidden" name="id_almacenaje_guardar" value="<?PHP echo $control ?>";>  
    <input type="hidden"  name="reporte" value="<?PHP echo $cod; ?>">            
			
  					<div class="row" >
  		   				<div class="col-md-13">
        					<div class="panel panel-primary">
           						<div class="panel-heading"><strong>Reversión  de Despacho de Granos Básico</strong>				</div> <!-- PANEL 1 --->
           						<div class="panel-body" >
      					            <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Código</label>
                                    <input type="text" class="form-control input-lg" id="id_salida" style="background:#FFF" readonly  value="<?PHP echo $cod; ?>"name="id_salida" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Número de control</label>
                                    <input type="text" class="form-control input-lg" id="entrada" style="background:#FFF" readonly  value="<?PHP echo $control; ?>"name="entrada" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Fecha actual</label>
                                    <input type="text" class="form-control input-lg" id="fecha_actual" style="background:#FFF" readonly  value="<?PHP echo $fecha; ?>"name="fecha_actual" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Hora actual</label>
                                    <input type="text" class="form-control input-lg" id="hora_actual" style="background:#FFF" readonly  value="<?PHP echo $hora; ?>"name="hora_actual" autocomplete="off">
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
                          <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-6">
                              <div class="form-group">
                                    <label for="origen_origen">Empresa / Cliente</label>
                                    <input type="text" class="form-control input-lg" id="nom_cliente" style="background:#FFF" readonly  value="<?PHP echo $nom_empresa; ?>"name="nom_cliente" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                    <label for="origen_origen">Piloto</label>
                                    <input type="text" class="form-control input-lg" id="nom_piloto" style="background:#FFF" readonly  value="<?PHP echo $nom_transportista; ?>"name="nom_piloto" autocomplete="off">
                              </div>
                            </div>
                            
                          </div><!--- FIN ROW-----> 
                           <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Silo</label>
                                    <input type="text" class="form-control input-lg" id="nom_silo" style="background:#FFF" readonly  value="<?PHP echo $nom_silo; ?>"name="nom_silo" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Lote</label>
                                    <input type="text" class="form-control input-lg" id="num_lote" style="background:#FFF" readonly  value="<?PHP echo $num_lote; ?>"name="num_lote" autocomplete="off">
                              </div>
                            </div>
                            		<div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Fecha Recepción</label>
                                    <input type="text" class="form-control input-lg" id="fecha_entrada" style="background:#FFF" readonly  value="<?PHP echo $fecha_recepcion; ?>"name="fecha_entrada" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Hora Recepción</label>
                                    <input type="text" class="form-control input-lg" id="hora_entrada" style="background:#FFF" readonly  value="<?PHP echo $hora_recepciion; ?>"name="hora_entrada" autocomplete="off">
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
                          <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Peso Bruto</label>
                                    <input type="text" class="form-control input-lg" id="peso_bruto" style="background:#FFF" readonly  value="<?PHP echo $peso_bruto; ?>"name="peso_bruto" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Pero Tara</label>
                                    <input type="text" class="form-control input-lg" id="peso_tara" style="background:#FFF" readonly  value="<?PHP echo $peso_tara; ?>"name="peso_tara" autocomplete="off">
                              </div>
                            </div>
                            		<div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Peso Neto</label>
                                    <input type="text" class="form-control input-lg" id="peso_neto" style="background:#FFF" readonly  value="<?PHP echo $peso_neto ; ?>"name="peso_neto" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Peso sin Humedad</label>
                                    <input type="text" class="form-control input-lg" id="peso_sin_humedad" style="background:#FFF" readonly  value="<?PHP echo $peso_sin_humedad; ?>"name="peso_sin_humedad" autocomplete="off">
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
                            <div class="row"><!--- INICIO ROW----->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Comentario </label>
                                        <textarea name="desc" class="form-control input-lg" style="text-transform:uppercase;" rows="3" placeholder="Comentario de la reversión" autocomplete="off" id="desc"></textarea>
                                    </div>
                                </div>
                            </div><!--- FIN ROW----->
                            
           
                           <div class="checkbox">
              <label>
                <input type="checkbox" name="activar" onclick="activar_boton()">Realizar Reversión? </label>
          </div>
 <table width="220" border="0" align="right">
              	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" onClick="cancelar()" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="button" disabled name="btnguardar" data-toggle="modal" data-target="#ventana4" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
              	    </tr>
           	      </table> 
 <!-- SOLICITA PERMISO PARA ACTUALIZAR -->

<div class="modal fade" id="ventana4">
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
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               	<button class="btn btn-primary" type="submit" onClick="actualizar()">Revertir Registro</button>
    </div>
    <div>               
  </div>                  
            
           </form> 
          
</div>
</div><!-- Fin de formularios  Inicia la paginacion-->


<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->


<!--  INICIO FOOTER   -->
<div class="navbar navbar-inverse navbar-fixed-bottom">
   <div class="container">
      <p class="navbar-text">
         Diseñado y Desarrollado Por <a href="http://www.ie-networks.com/">Ie Networks</a> © 2017.
      </p>
   </div>
</div>
<!-- FIN FOOTER  -->

</body> 
</html>

