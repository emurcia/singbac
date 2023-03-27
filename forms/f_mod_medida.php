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
$tabla="SELECT *  FROM tab_medida where id_medida='$_POST[codigo_modificar]' and id_empresa='$id_empresa'";
  $select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	$cod=$row['id_medida'];
	$nom=$row['nom_medida'];
	$con1=$row['conversion'];
	
}	
date_default_timezone_set("America/El_Salvador");
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s")	
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
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
</head> 

<script  languaje="javascript" type="text/javascript" >
    $(document).ready(function() {
    $('.soloLetras').keypress(function(tecla) {
                if((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && tecla.keyCode !=08 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32) return false;
            });

     $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
            });
        });
	

function activar_boton() //funcionar para activas las cajas de textos
  {	
		if (document.formulario.activar.checked==false){
			document.formulario.btnguardar.disabled=true;
			}else{
				document.formulario.btnguardar.disabled=false;
			}
			
  }

function cancelar(){
		document.location.href='f_moneda_medida.php';	
	}

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }	
</script>
<script>
function actualizar()
{
	document.formulario.bandera_acciones.value="ok";
    document.formulario.submit(); 
   
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
	 $bandera_eli = $_POST['bandera_acciones'];
	if($bandera_eli=="ok"){
	  $nombre_usuario=$_POST['nombre_usuario']; // CORREO
	  $con_usuario=md5($_POST['con_usuario']);
	  $activo="1";
	  $empresa=$id_empresa;
	  $modificar="1";
 	 $cod2= $_POST["id_medida"];
	 $_SESSION['codigo']=$cod2;

$resultado = autorizar_mod($nombre_usuario,$con_usuario,$activo,$empresa,$modificar);	
	
	if($resultado=="1"){
		$guarda="400"; // Guarda
	}else{
	$tabla="SELECT *  FROM tab_medida where id_medida='".$_SESSION['codigo']."' and id_empresa='$id_empresa'";
 $result = mysql_query($tabla);
$array = mysql_fetch_assoc($result);
{
	$cod=$array['id_medida'];
}
		$error="3"; // no posee permisos
		}
	}
	
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

 <?PHP
	
// INICIA EL GUARDADO DE INFORMACION 
 	 $cod3 = $_POST["id_medida"];
	 $nombre1  = strtoupper($_POST["nom_medida"]);
	 $conve1 = ($_POST["conversion"]);
	
 if($guarda=="400")
   {//inicio if bandera ok
$tabla5="SELECT *  FROM t_usuarios where correo_usuario='$nombre_usuario' and pass_usuario='$con_usuario' and id_empresa='$id_empresa'";
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_actualiza=$row5['id_usuario'];
}
	
      if(isset($cod3)){
		$sql= ("UPDATE `tab_medida` SET `nom_medida`='$nombre1',`conversion`='$conve1', id_usuario_modifica='$usuario_actualiza', fecha_modifica='$fecha', hora_modifica='$hora'  WHERE id_medida='$cod3' and id_empresa='$id_empresa'");
		mysql_query($sql,$con);
		 }
if(mysql_error())
		  { 
			$error="1";
		  }
			  else
			$error="2";
   		
	}//fin bandera ok		
?>
<?PHP 
 if($error == "1")
 {
	  echo '<div class="alert alert-success">
 			<a href="f_moneda_medida.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == "2")
 {
	 unset($_SESSION['codigo']);
	 echo '<div class="alert alert-success">
 						  <a href="f_moneda_medida.php" class="alert-link">Datos Actualizados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }

if($error == "3")
 {
	 echo '<div class="alert alert-danger">
 						  <a href="f_moneda_medida.php" class="alert-link">No tiene permiso para modificar registro!!! Haga click para continuar .....</a>
						  </div>';
	  }	  
 ?>
   
  <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Modificar datos</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
            <form role="form" name="formulario"  method="post" action="f_mod_medida.php">
           	<input type="hidden"  name="bandera" value="0">
	   	   	<input type="hidden" name="bandera_acciones" value="">  
                 
           <div class="row"><!--- INICIO ROW----->
                         <div class="col-md-12">
                          <div class="form-group">
                                <label>Código</label>
                                <input type="text" class="form-control input-lg" value="<?PHP echo $cod; ?>"   name="id_medida" id="id_medida" autocomplete="off" readonly style="background:#FFF;">
                            </div>
                          </div>
                          </div><!--- FIN ROW-----> 
                                           <div class="row"><!--- INICIO ROW----->
                                            <div class="col-md-12">
                              <div class="form-group">
                                    <label for="origen_producto">Unidades de Peso</label>
                                    <input type="text" class="form-control input-lg" style="text-transform:uppercase;" id="nom_medida" placeholder="Unidad de Peso" value="<?PHP echo $nom; ?>"  name="nom_medida" required autocomplete="off">
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
          
                            <div class="row"><!--- INICIO ROW----->
                      	     <div class="col-md-6">
              <div class="form-group">
              <label for="moneda_servicio">Equivalente en Kilogramos</label>
              </div>
            <div class="col-md-8">
              <div class="input-group">
              <input type="text" class="form-control soloNUMEROS input-lg" id="conversion" name="conversion" value="<?PHP echo $con1; ?>" placeholder="PESO" autocomplete="off" required>
              <span class="input-group-addon">Kg</span>
              </div>
              </div>
       </div>
      </div><!--- FIN ROW----->
                          <br> 
           <div class="checkbox">
            <label>
            <input type="checkbox" name="activar" onclick="activar_boton()">Realizar modificación? </label>
          </div>

              	  <table width="220" border="0" align="right">
              	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" onclick="cancelar()" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="button" disabled name="btnguardar" data-toggle="modal" data-target="#ventana4" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
              	    </tr>
           	      </table> 
                  
   </div>   </div>    </div>

<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->


<!--  INICIO FOOTER   -->
<?PHP include("footer.php"); ?>
<!-- FIN FOOTER  -->
<!-- SOLICITA PERMISO PARA ACTUALIZAR -->

<div class="modal fade" id="ventana4">
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
            <br> <div class="modal-footer">
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               	<button class="btn btn-primary" type="submit" onClick="actualizar()">Actualizar Registro</button>
             </div>   
    </div>
    <div>               
  </div>                  
  </form> 
          
</div>
</div><!-- Fin de formularios  Inicia la paginacion-->

</body> 
</html>