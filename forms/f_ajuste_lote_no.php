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

$tabla_extrae="SELECT l.id_lote, l.num_lote, c.id_cliente, c.nom_cliente, s.id_silo, s.nom_silo, pro.nom_producto, (case when pro.humedad='0' then ' Producto no aplica humedad ' else ' Producto aplica Humedad ' end) as nota_humedad, spro.nom_subproducto FROM tab_lote as l, tab_cliente as c, tab_silo as s, tab_producto as pro, tab_subproducto as spro WHERE (l.id_lote='$_POST[ajuste]')and l.id_empresa='$id_empresa' and l.bandera=0 and l.id_cliente=c.id_cliente and l.id_silo=s.id_silo and l.id_producto=pro.id_producto and l.id_subproducto=spro.id_subproducto group by l.id_silo, l.id_producto, l.id_cliente, l.num_lote";
$select_extrae = mysql_query($tabla_extrae,$con);
while($row_extrae = mysql_fetch_array($select_extrae))
{
			 $cod=$row_extrae['id_lote'];
			 $control=$row_extrae['num_lote'];
			 $cliente=$row_extrae['nom_cliente'];
			 $num_lote=$row_extrae['num_lote'];
			 $nom_silo=$row_extrae['nom_silo'];
			 $nom_producto=$row_extrae['nom_producto'];
			 $nom_subproducto=$row_extrae['nom_subproducto'];
			 $nota=$row_extrae['nota_humedad'];
			 
			 $_SESSION['id_cliente_guarda']=$row_extrae['id_cliente'];
			 $_SESSION['id_lote_guarda']=$row_extrae['id_lote'];
			 $_SESSION['id_silo_guarda']=$row_extrae['id_silo'];
			 
			 
}
// extraer datos que han sido almacenados
$tabla_almacen=mysql_query("SELECT sum(neto_sin_humedad) as peso_humedad_entrada, sum(peso_bruto) as peso_bruto_entrada, sum(peso_tara) as peso_tara_entrada, sum(peso_teorico) as teorico_entrada from tab_almacenaje WHERE id_lote='$_POST[ajuste]' and id_empresa='$id_empresa'",$con);
$select_almacen = mysql_fetch_array($tabla_almacen);
$cantidad_entrada1=$select_almacen['peso_humedad_entrada'];
$peso_bruto_entrada_guarda1=$select_almacen['peso_bruto_entrada'];
$peso_tara_entrada_guarda1=$select_almacen['peso_tara_entrada'];
$peso_teorico_entrada_guarda1=$select_almacen['teorico_entrada'];
$peso_humedad_entrada_guarda1=$select_almacen['peso_humedad_entrada'];
$peso_neto_entrada_guarda1=$peso_bruto_entrada_guarda1-$peso_tara_entrada_guarda1;

$peso_humedad_entrada=number_format($select_almacen['peso_humedad_entrada'],2,".",",");
$peso_bruto_entrada=number_format($select_almacen['peso_bruto_entrada'],2,".",",");
$peso_tara_entrada=number_format($select_almacen['peso_tara_entrada'],2,".",",");
$saldo_entrada=number_format($select_almacen['peso_bruto_entrada']-$select_almacen['peso_tara_entrada'],2,".",",");
$teorico_entrada=number_format($select_almacen['teorico_entrada'],2,".",",");


// extraer datos de salida de almacen
$tabla_salida=mysql_query("SELECT sum(peso_sin_humedad) as peso_humedad_salida, sum(peso_bruto) as peso_bruto_salida, sum(peso_tara) as peso_tara_salida, sum(peso_teorico) as teorico_salida from tab_salida WHERE id_lote='$_POST[ajuste]' and id_empresa='$id_empresa'",$con);
$select_salida = mysql_fetch_array($tabla_salida);
$cantidad_salida1=$select_salida['peso_humedad_salida'];
$peso_bruto_salida_guarda1=$select_salida['peso_bruto_salida'];
$peso_tara_salida_guarda1=$select_salida['peso_tara_salida'];
$peso_teorico_salida_guarda1=$select_salida['teorico_salida'];
$peso_humedad_salida_guarda1=$select_salida['peso_humedad_salida'];
$peso_neto_salida_guarda1=$peso_bruto_salida_guarda1-$peso_tara_salida_guarda1;


$peso_humedad_salida=number_format($select_salida['peso_humedad_salida'],2,".",",");
$peso_bruto_salida=number_format($select_salida['peso_bruto_salida'],2,".",",");
$peso_tara_salida=number_format($select_salida['peso_tara_salida'],2,".",",");
$saldo_salida=number_format($select_salida['peso_bruto_salida']-$select_salida['peso_tara_salida'],2,".",",");
$teorico_salida=number_format($peso_teorico_salida_guarda,2,".",",");

$cantidad_neto1=$cantidad_entrada1-$cantidad_salida1;
$cantidad_neto=number_format($cantidad_neto1,2,".",",");

$peso_bruto_disponible=number_format($select_almacen['peso_bruto_entrada']-$select_salida['peso_bruto_salida'],2,".",",");
$peso_tara_disponible=number_format($select_almacen['peso_tara_entrada']-$select_salida['peso_tara_salida'],2,".",",");
$peso_saldo_disponible=number_format(($select_almacen['peso_bruto_entrada']-$select_almacen['peso_tara_entrada'])-($select_salida['peso_bruto_salida']-$select_salida['peso_tara_salida']),2,".",",");
$peso_teorico_disponible=number_format($select_almacen['teorico_entrada']-$select_salida['teorico_salida'],2,".",",");
$peso_humedad_disponible=number_format($select_almacen['peso_humedad_entrada']-$select_salida['peso_humedad_salida'],2,".",",");

$tabla_num_ajuste=mysql_query("SELECT * FROM tab_inventario WHERE id_lote='$_POST[ajuste]' and id_empresa='$id_empresa'",$con);
$select_num_ajuste = mysql_fetch_array($tabla_num_ajuste);
$num_ajuste_valida=$select_num_ajuste['num_ajuste'];

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
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="../js/bootstrap.min.js"></script>
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
		document.location.href='f_ajuste.php';	
	}
	
function salirr()
 {	 
    document.formulario1.bandera.value="oki";
    document.formulario1.submit();       
 }
 
 function datos(){
	 window.open('../reportes/Rp_ajuste.php?id='+document.formulario1.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
	
}

 function sumar()
  {
      var total = 0;
      var valor1 = document.formulario1.nuevo_peso_bruto.value;
	  var valor2 = document.formulario1.nuevo_peso_tara.value;
	  
	  if (valor1=="") valor1=0;
	  if (valor2=="") valor2=0;

  	total = parseInt(valor1) - parseInt(valor2);
	document.formulario1.nuevo_peso_neto.value=total;

  }

</script>
<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=09 && tecla.keyCode !=127 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
            });
		
});
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
	  $con_usuario=md5($_POST['con_usuario']); // CONTRASEÑA
	  $activo=1;
	  $empresa=$id_empresa;
	  $modificar=1;
 	// $cod2= $_POST["id_almacenaje"];
	 //$_SESSION['codigo']=$cod2;

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
							$num_ajuste=$fila['num_ajuste'];
							$transaccion=$num_ajuste+1;
							$total=$cont_total+1; 	
						}
					}
?>

<?PHP

// INICIA EL GUARDADO DE INFORMACION 
$cod1= $_POST["id_ajuste"];

$Result1 = mysql_query("SELECT MAX(id_ajuste) as a  FROM tab_ajuste where id_empresa='$id_empresa' ORDER BY id_ajuste asc ") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],7,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "AJUSTE-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "AJUSTE-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "AJUSTE-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "AJUSTE-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "AJUSTE-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "AJUSTE-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "AJUSTE-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}

if($guarda==400)
   {//inicio if bandera ok
$nuevo_peso_bruto_guarda=$_POST['nuevo_peso_bruto']; 
$nuevo_peso_tara_guarda=$_POST['nuevo_peso_tara']; 
$nuevo_peso_teorico_guarda=$_POST['nuevo_peso_teorico']; 
$nuevo_peso_humedad_guarda=$_POST['nuevo_peso_humedad'];
$peso_neto_guarda=$_POST['nuevo_peso_neto'];  // para almacenar en inventario
$comentario_ajuste_guarda=strtoupper($_POST['comentario']); 
   
   
$tabla5="SELECT *  FROM t_usuarios where correo_usuario='$nombre_usuario' and pass_usuario='$con_usuario' and id_empresa='$id_empresa'";
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_autoriza=$row5['id_usuario'];
	$fecha_autoriza=date('Y').'/'.date('m').'/'.date('d');
	$hora_autoriza=date("H:i:s");
}


// extraer datos que han sido almacenados
$tabla_almacen=mysql_query("SELECT sum(neto_sin_humedad) as peso_humedad_entrada, sum(peso_bruto) as peso_bruto_entrada, sum(peso_tara) as peso_tara_entrada, sum(peso_teorico) as teorico_entrada from tab_almacenaje WHERE id_lote='".$_SESSION['id_lote_guarda']."' and id_empresa='$id_empresa'",$con);
$select_almacen = mysql_fetch_array($tabla_almacen);
//$cantidad_entrada1=$select_almacen['peso_humedad_entrada'];
$peso_bruto_entrada_guarda=$select_almacen['peso_bruto_entrada'];
$peso_tara_entrada_guarda=$select_almacen['peso_tara_entrada'];
$peso_teorico_entrada_guarda=$select_almacen['teorico_entrada'];
$peso_humedad_entrada_guarda=$select_almacen['peso_humedad_entrada'];

$tabla_salida=mysql_query("SELECT sum(peso_sin_humedad) as peso_humedad_salida, sum(peso_bruto) as peso_bruto_salida, sum(peso_tara) as peso_tara_salida, sum(peso_teorico) as teorico_salida from tab_salida WHERE id_lote='".$_SESSION['id_lote_guarda']."' and id_empresa='$id_empresa'",$con);
$select_salida = mysql_fetch_array($tabla_salida);
//$cantidad_salida1=$select_salida['peso_humedad_salida'];
$peso_bruto_salida_guarda=$select_salida['peso_bruto_salida'];
$peso_tara_salida_guarda=$select_salida['peso_tara_salida'];
$peso_teorico_salida_guarda=$select_salida['teorico_salida'];
$peso_humedad_salida_guarda=$select_salida['peso_humedad_salida'];



$tablainve="SELECT * FROM tab_inventario WHERE id_lote='".$_SESSION['id_lote_guarda']."' and id_empresa='$id_empresa'";
			$select_inve=mysql_query($tablainve,$con);
			while($row_inve=mysql_fetch_array($select_inve)) {
				$id_inventario_guarda=$row_inve['id_inventario'];
				$movimiento_lote1=$row_inve['movimiento_lote'];
			    $peso_sin_humedad_inve=$row_inve['peso_sin_humedad'];
			    $peso_sin_humedad_maximo_inve=$row_inve['peso_sin_humedad_maximo'];
				$num_ajuste=$row_inve['num_ajuste'];
			}

// SUMAR A INVENTARIO LOS NUEVOS VALORES.
		$movimiento_lote_guardar=$movimiento_lote1 + $peso_neto_guarda;
		$peso_sin_humedad_inve_guarda=$peso_sin_humedad_inve+$nuevo_peso_humedad_guarda;
		$peso_sin_humedad_maximo_inve_guarda=$peso_sin_humedad_maximo_inve+($nuevo_peso_humedad_guarda*1.17);	
		$num_ajuste_guarda=$num_ajuste+1;

      if(isset($cod1)){
		  
		$sql= ("insert into tab_ajuste(id_ajuste, entrada, id_cliente, id_lote, id_silo, peso_bruto_entrada, peso_tara_entrada, peso_teorico_entrada, peso_humedad_entrada, peso_bruto_salida, peso_tara_salida, peso_teorico_salida, peso_humedad_salida, id_inventario, peso_humedad_inventario, humedad_maximo_inventario, nuevo_peso_bruto, nuevo_peso_tara, nuevo_peso_teorico, nuevo_peso_humedad, comentario_ajuste, id_usuario2_ajuste, fecha_usuario_ajuste, hora_usuario_ajuste, id_usuario_autoriza, fecha_usuario_autoriza, hora_usuario_autoriza, id_empresa) values ('$nu', '$transaccion', '".$_SESSION['id_cliente_guarda']."', '".$_SESSION['id_lote_guarda']."', '".$_SESSION['id_silo_guarda']."', '$peso_bruto_entrada_guarda', '$peso_tara_entrada_guarda', '$peso_teorico_entrada_guarda', '$peso_humedad_entrada_guarda', '$peso_bruto_salida_guarda', '$peso_tara_salida_guarda', '$peso_teorico_salida_guarda', '$peso_humedad_salida_guarda', '$id_inventario_guarda', '$peso_sin_humedad_inve', '$peso_sin_humedad_maximo_inve', '$nuevo_peso_bruto_guarda', '$nuevo_peso_tara_guarda', '$nuevo_peso_teorico_guarda', '$nuevo_peso_humedad_guarda', '$comentario_ajuste_guarda', '$id_usuario', '$fecha2', '$hora', '$usuario_autoriza', '$fecha_autoriza', '$hora_autoriza', '$id_empresa')");
		mysql_query($sql,$con);
		
	 $sql_inv= ("UPDATE tab_inventario SET movimiento_lote='$movimiento_lote_guardar',  peso_sin_humedad='$peso_sin_humedad_inve_guarda', peso_sin_humedad_maximo='$peso_sin_humedad_maximo_inve_guarda', num_ajuste='$num_ajuste_guarda' WHERE id_lote='".$_SESSION['id_lote_guarda']."' and id_empresa='$id_empresa'");
      mysql_query($sql_inv,$con);	
	  
	  
	  
	  $sql= ("UPDATE tab_contador SET total='$total', num_ajuste='$transaccion' WHERE codigo='1' and id_empresa='$id_empresa'");
	  mysql_query($sql,$con);
		$error="2";
		  }
		  

if(mysql_error())
		  { 
			$error="1";
		  }
		  
		
	}//fin bandera ok		
   
?>   

<body class="container" <?PHP if($error == 2) echo "onload='datos()';";?>> 


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
 if($error == 1)
 {
	 unset($_SESSION['id_cliente_guarda']);
	 unset($_SESSION['id_lote_guarda']);
	 unset($_SESSION['id_silo_guarda']);
	  echo '<div class="alert alert-success">
 			<a href="f_ajuste.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == 2)
 {
	 unset($_SESSION['id_cliente_guarda']);
	 unset($_SESSION['id_lote_guarda']);
	 unset($_SESSION['id_silo_guarda']);
	 
	 echo '<div class="alert alert-success">
 						  <a href="f_ajuste.php" class="alert-link">Datos Almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }

if($error == 3)
 {
	 echo '<div class="alert alert-danger">
 						  <a href="f_ajuste.php" class="alert-link">No tiene permiso para revertir registro!!! Haga click para continuar .....</a>
						  </div>';
	  }	  
 ?>

            <!-- Formulario para modificar origen -->
<form role="form" name="formulario1"  method="post" action="f_ajuste_lote.php">
	<input type="hidden"  name="bandera" value="0">
	<input type="hidden" name="bandera_acciones" value=""> 
	    <input type="hidden"  name="reporte" value="<?PHP echo $nu; ?>">            
			
  					<div class="row" >
  		   				<div class="col-md-13">
        					<div class="panel panel-primary">
           						<div class="panel-heading"><strong>Ajuste de inventario</strong>				</div> <!-- PANEL 1 --->
           						<div class="panel-body" >
      					            <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Código</label>
                                    <input type="text" class="form-control input-lg" id="id_ajuste" style="background:#FFF" readonly  value="<?PHP echo $cod; ?>"name="id_ajuste" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                    <label for="origen_origen">Número de control</label>
                                    <input type="text" class="form-control input-lg" id="entrada" style="background:#FFF" readonly  value="<?PHP echo $transaccion; ?>" name="entrada" autocomplete="off">
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
                                    <input type="text" class="form-control input-lg" id="nom_cliente" style="background:#FFF" readonly  value="<?PHP echo $cliente; ?>"name="nom_cliente" autocomplete="off">
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
                                    <label for="origen_origen">Silo</label>
                                    <input type="text" class="form-control input-lg" id="nom_silo" style="background:#FFF" readonly  value="<?PHP echo $nom_silo; ?>" name="nom_silo" autocomplete="off">
                              </div>
                            </div>                                                 
                          </div><!--- FIN ROW-----> 
                          <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-6">
                              <div class="form-group">
                                    <label for="origen_origen">Producto</label>
                                    <input type="text" class="form-control input-lg" id="nom_producto" style="background:#FFF" readonly  value="<?PHP echo $nom_producto; ?>" name="nom_producto" autocomplete="off">
                              </div>
                            </div>
                       	<div class="col-md-6">
                              <div class="form-group">
                                    <label for="origen_origen">Subproducto</label>
                                    <input type="text" class="form-control input-lg" id="nom_subproducto" style="background:#FFF" readonly  value="<?PHP echo $nom_subproducto; ?>"name="nom_subproducto" autocomplete="off">
                              </div>
                            </div>                                                
                          </div><!--- FIN ROW-----> 
                          
                          <br>
                      <div class="row" >
  		   				<div class="col-md-12">
        			     <div class="panel-heading bg-info"><strong>Existencias actuales</strong>				</div> <!-- PANEL 1 --->
                         </div>
                      </div>
                      <br>
                       <div class="row" >
  		   				<div class="col-md-12">
        			    <div class="form-group">
                                    <label for="origen_origen">Nota</label>
                                    <input type="text" class="form-control input-lg" id="nota" style="background:#FFF; text-transform:uppercase;" readonly  value="<?PHP echo $nota; ?>" name="nota" autocomplete="off">
                              </div>
                         </div>
                      </div>
                                      
                          <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-2">
                              <div class="form-group">
                              <label for="origen_origen"></label>
                              </div>
                              <div class="form-group">
                                 <label for="origen_origen">ENTRADA</label>
                                </div>
                            </div>
                            	<div class="col-md-2">
                              <div class="form-group">
                                    <label for="origen_origen">Peso Bruto</label>
                                    <input type="text" class="form-control input-lg" id="peso_bruto_entrada" style="background:#FFF" readonly  value="<?PHP echo $peso_bruto_entrada; ?>" name="peso_bruto_entrada" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <label for="origen_origen">Peso Tara</label>
                                    <input type="text" class="form-control input-lg" id="peso_tara_entrada" style="background:#FFF" readonly  value="<?PHP echo $peso_tara_entrada; ?>"name="peso_tara_entrada" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <label for="origen_origen">Peso Neto </label>
                                    <input type="text" class="form-control input-lg" id="saldo_entrada" value="<?PHP echo $saldo_entrada; ?>" style="background:#FFF" readonly name="saldo_entrada" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                    <label for="origen_origen">Peso teórico </label>
                                    <input type="text" class="form-control input-lg" id="teorico_entrada" value="<?PHP echo $teorico_entrada; ?>" name="teorico_entrada" style="background:#FFF" readonly autocomplete="off">
                              </div>
                            </div>
                            
                            <div class="col-md-2">
                              <div class="form-group">
                                    <label for="origen_origen">Peso humedad</label>
                                    <input type="text" class="form-control input-lg" id="peso_neto_entrada" style="background:#FFF" readonly  value="<?PHP echo $peso_humedad_entrada; ?>" name="peso_neto_entrada" autocomplete="off">
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
                          
                          <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-2">
                           
                              <div class="form-group">
                                 <label for="origen_origen">SALIDA</label>
                                </div>
                            </div>
                            	<div class="col-md-2">
                              <div class="form-group">
                                    
                                    <input type="text" class="form-control input-lg" id="peso_bruto_salida" style="background:#FFF" readonly  value="<?PHP echo $peso_bruto_salida; ?>" name="peso_bruto_salida" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                 
                                    <input type="text" class="form-control input-lg" id="peso_tara_salida" style="background:#FFF" readonly  value="<?PHP echo $peso_tara_salida; ?>"name="peso_tara_salida" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                   
                                    <input type="text" class="form-control input-lg" id="saldo_salida" value="<?PHP echo $peso_humedad_salida; ?>" style="background:#FFF" readonly name="saldo_salida" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                 
                                    <input type="text" class="form-control input-lg" id="teorico_salida" value="<?PHP echo $teorico_salida; ?>" name="teorico_salida" style="background:#FFF" readonly autocomplete="off">
                              </div>
                            </div>
                            
                            <div class="col-md-2">
                              <div class="form-group">
                                
                                    <input type="text" class="form-control input-lg" id="peso_neto_salida" style="background:#FFF" readonly  value="<?PHP echo $saldo_salida; ?>" name="peso_neto_salida" autocomplete="off">
                              </div>
                            </div>
                          </div><!--- FIN ROW----->
                          
                         
                          <!--- IMPRIME SI YA SE HAN REALIZADO AJUSTES ANTERIORMENTE ---!>
                          <?PHP 
						 if($num_ajuste_valida!="0"){
							 $ajuste="1"; // si hay ajuste
							 // extraer datos de salida ajustes realizados
$tabla_ajuste_mostrar=mysql_query("SELECT sum(nuevo_peso_bruto) as a_peso_bruto, sum(nuevo_peso_tara) as a_peso_tara, sum(nuevo_peso_teorico) as a_peso_teorico, sum(nuevo_peso_humedad) as a_peso_humedad from tab_ajuste WHERE id_lote='".$_SESSION['id_lote_guarda']."' and id_empresa='$id_empresa'",$con);
$select_ajuste = mysql_fetch_array($tabla_ajuste_mostrar);

$peso_ajuste_bruto=number_format($select_ajuste['a_peso_bruto'],2,".",",");
$peso_ajuste_tara=number_format($select_ajuste['a_peso_tara'],2,".",",");
$peso_ajuste_teorico=number_format($select_ajuste['a_peso_teorico'],2,".",",");
$peso_ajuste_teorico1=$select_ajuste['a_peso_teorico'];
$peso_humedad_ajuste=number_format($select_ajuste['a_peso_humedad'],2,".",",");
$saldo_ajuste=number_format($select_ajuste['a_peso_bruto']-$select_ajuste['a_peso_tara'],2,".",",");

$peso_bruto_disponible_ajuste=number_format(($peso_bruto_entrada_guarda1+$select_ajuste['a_peso_bruto']-$peso_bruto_salida_guarda1),2,".",",");
$peso_tara_disponible_ajuste=number_format(($peso_tara_entrada_guarda1+$select_ajuste['a_peso_tara']-$peso_tara_salida_guarda1),2,".",",");
$peso_saldo_disponible_ajuste=number_format(($peso_neto_entrada_guarda1 + ($select_ajuste['a_peso_bruto']-$select_ajuste['a_peso_tara']) - $peso_neto_salida_guarda1),2,".",",");

$peso_teorico_disponible_ajuste=number_format(($peso_teorico_entrada_guarda1 + $peso_ajuste_teorico1 - $peso_teorico_salida_guarda),2,".",",");
$peso_humedad_disponible_ajuste=number_format(($peso_humedad_entrada_guarda1+$select_ajuste['a_peso_humedad']-$peso_humedad_salida_guarda1),2,".",",");
							 
							?>
                            <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-2">
                           
                              <div class="form-group">
                                 <label for="origen_origen">AJUSTE ANTERIOR (<?PHP echo $num_ajuste_valida?>)</label>
                                </div>
                            </div>
                            	<div class="col-md-2">
                              <div class="form-group">
                               <input type="text" class="form-control input-lg" id="peso_neto_ajuste" value="<?PHP echo $peso_ajuste_bruto; ?>" name="peso_neto_ajuste" style="background:#FFF" readonly autocomplete="off">     
                                   
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                 
                                   <input type="text" class="form-control input-lg" id="peso_tara_ajuste" value="<?PHP echo $peso_ajuste_tara; ?>" name="peso_tara_ajuste" style="background:#FFF" readonly autocomplete="off">  
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                              <input type="text" class="form-control input-lg" id="peso_saldo_ajuste" value="<?PHP echo $saldo_ajuste; ?>" name="peso_saldo_ajuste" style="background:#FFF" readonly autocomplete="off">  
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                              <input type="text" class="form-control input-lg" id="peso_teorico_ajuste" value="<?PHP echo $peso_ajuste_teorico; ?>" name="peso_teorico_ajuste" style="background:#FFF" readonly autocomplete="off"> 
                              </div>
                            </div>
                            
                            <div class="col-md-2">
                              <div class="form-group">
                                <input type="text" class="form-control input-lg" id="peso_humedad_ajuste" value="<?PHP echo $peso_humedad_ajuste; ?>" name="peso_humedad_ajuste" style="background:#FFF" readonly autocomplete="off"> 
                              </div>
                            </div>
                          </div><!--- FIN ROW----->
							<?PHP  
							}
						  
						  ?>
                          <!--- FIN IMPRESION SI YA SE REALIZARON AJUSTES----->
         
                                   
                           <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-2">
                           
                              <div class="form-group">
                                 <label for="origen_origen">DISPONIBILIDAD </label>
                                </div>
                            </div>
                            	<div class="col-md-2">
                              <div class="form-group">
                               <input type="text" class="form-control input-lg" id="peso_neto_disponible" value="<?PHP if($ajuste!="1") echo $peso_bruto_disponible; echo $peso_bruto_disponible_ajuste; ?>" name="peso_neto_disponible" style="background:#FFF" readonly autocomplete="off">     
                                   
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                 
                                   <input type="text" class="form-control input-lg" id="peso_tara_disponible" value="<?PHP if($ajuste!="1") echo $peso_tara_disponible; echo $peso_tara_disponible_ajuste; ?>" name="peso_tara_disponible" style="background:#FFF" readonly autocomplete="off">  
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                              <input type="text" class="form-control input-lg" id="peso_saldo_disponible" value="<?PHP if($ajuste!="1") echo $peso_saldo_disponible; echo $peso_saldo_disponible_ajuste; ?>" name="peso_saldo_disponible" style="background:#FFF" readonly autocomplete="off">  
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                              <input type="text" class="form-control input-lg" id="peso_teorico_disponible" value="<?PHP if($ajuste!="1") echo $peso_teorico_disponible; echo $peso_teorico_disponible_ajuste; ?>" name="peso_teorico_disponible" style="background:#FFF" readonly autocomplete="off"> 
                              </div>
                            </div>
                            
                            <div class="col-md-2">
                              <div class="form-group">
                                <input type="text" class="form-control input-lg" id="peso_humedad_disponible" value="<?PHP if($ajuste!="1") echo $peso_humedad_disponible; echo $peso_humedad_disponible_ajuste; ?>" name="peso_humedad_disponible" style="background:#FFF" readonly autocomplete="off"> 
                              </div>
                            </div>
                          </div><!--- FIN ROW----->
                          
                           <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-2">
                           
                              <div class="form-group">
                                 <label for="origen_origen">AJUSTE</label>
                                </div>
                            </div>
                            	<div class="col-md-2">
                              <div class="form-group">
                                    
                                    <input type="text" class="form-control input-lg soloNUMEROS" id="nuevo_peso_bruto" onkeyup="sumar()"  name="nuevo_peso_bruto" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                 
                                    <input type="text" class="form-control input-lg soloNUMEROS" id="nuevo_peso_tara" onkeyup="sumar()" name="nuevo_peso_tara" autocomplete="off">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                              <input type="text" class="form-control input-lg soloNUMEROS" id="nuevo_peso_neto"  name="nuevo_peso_neto" autocomplete="off" readonly style="background:#FFF">
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                 <input type="text" class="form-control input-lg soloNUMEROS" id="nuevo_peso_teorico"  name="nuevo_peso_teorico" autocomplete="off">
                              </div>
                            </div>
                            
                            <div class="col-md-2">
                              <div class="form-group">
                                <input type="text" class="form-control input-lg soloNUMEROS" id="nuevo_peso_humedad"  name="nuevo_peso_humedad" autocomplete="off">
                              </div>
                            </div>
                          </div><!--- FIN ROW----->
                          
                       
                            <div class="row"><!--- INICIO ROW----->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Comentario </label>
                                        <textarea name="comentario" class="form-control input-lg" style="text-transform:uppercase;" rows="3" placeholder="Comentario del ajuste" autocomplete="off" id="comentario"></textarea>
                                    </div>
                                </div>
                            </div><!--- FIN ROW----->
                            
           
                           <div class="checkbox">
              <label>
                <input type="checkbox" name="activar" onclick="activar_boton()">Realizar Ajuste? </label>
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
               	<button class="btn btn-primary" type="submit" onClick="actualizar()">Autorización</button>
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
<?PHP include("footer.php"); ?>
<!-- FIN FOOTER  -->

</body> 
</html>

