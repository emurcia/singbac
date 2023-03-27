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

date_default_timezone_set("America/El_Salvador");
$ano=date('Y');
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");


 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $id_usuario = $_SESSION['id_usuario_silo']; // id_usuario en bd
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

        
$bandera = $_POST['bandera'];

$tabla="SELECT *  FROM t_usuarios where id_usuario='".$_POST["cod_prod_eliminar"]."' and id_empresa='$id_empresa'";
 $result = mysql_query($tabla);
$array = mysql_fetch_assoc($result);
{
	$cod1=$array['id_usuario'];
	$nom1=$array['nombre_usuario'];
	$cor1=$array['correo_usuario'];
	$nivel1=$array['id_nivel'];

}
$sql_nivel = "SELECT * FROM tab_nivel WHERE id_nivel='$nivel1' and id_empresa='$id_empresa'";
								$result_ni = mysql_query($sql_nivel,$con);
								if ($result_ni > 0){	
                               		while ($row_nivel = mysql_fetch_assoc($result_ni)){
									 $nivel_mostrar=$row_nivel['nom_nivel'];
									// $pingresar=$row_nivel['ingresar'];
									 //$pmodificar=$row_nivel['modificar'];
									 //$peliminar=$row_nivel['eliminar'];
									 //$pconsultar=$row_nivel['consultar'];
									}
								}
								

	
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=625, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
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
 
//function guardar(){
	//		document.formulario.bandera.value='ok';
	//		document.formulario.submit();
		
//}// fin guardar
function activar_boton() //funcionar para activas las cajas de textos
  {
		if(document.formulario.correo_usuario.value=="" ){
			alert("Ingrese correo del usuario");
			document.formulario.correo_usuario.focus();
			document.formulario.activar.checked=false;
			return;
		}else{
				if(document.formulario.pass_usuario.value==""){
					alert("Igrese contraseña del usuario");
					document.formulario.pass_usuario.focus();
					document.formulario.activar.checked=false;
					return;
				}
		}
		if (document.formulario.activar.checked==false){
			document.formulario.btnguardar.disabled=true;
			}else{
				document.formulario.btnguardar.disabled=false;
				}
			
  }	

   function cancelar()
 {	 
    	
document.location.href="f_usuarios.php";
//document.formulario.action='f_registrar_usuarios.php';//redireccionar a musuario.php
//		document.formulario.submit();        
 }


function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }

function validarEmail(valor) {
  if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
 //  alert("La dirección de email " + valor + " es correcta!.");
  } else {
   alert("La dirección de email " + valor + " es incorrecta!.");
   document.formulario.correo_usuario.value="";
   document.formulario.correo_usuario.focus();
  }
}
 
 
 </script>
 <script>

function actualizar()
{
	document.formulario.bandera_acciones.value="ok";
    document.formulario.submit(); 
   
}
</script>
<?php
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
 	 $cod2= $_POST["codigo_usuario"];
	 $_SESSION['codigo']=$cod2;

$resultado = autorizar_mod($nombre_usuario,$con_usuario,$activo,$empresa,$modificar);	
	
	if($resultado==1){
		$guarda=400; // Guarda
	}else{
	$tabla="SELECT *  FROM t_usuarios where id_usuario='".$_SESSION['codigo']."' and id_empresa='$id_empresa'";
 $result = mysql_query($tabla);
$array = mysql_fetch_assoc($result);
{
	$cod1=$array['id_usuario'];
	$nom1=$array['nombre_usuario'];
	$cor1=$array['correo_usuario'];
	$nivel1=$array['id_nivel'];

}
$sql_nivel = "SELECT * FROM tab_nivel WHERE id_nivel='$nivel1' and id_empresa='$id_empresa'";
								$result_ni = mysql_query($sql_nivel,$con);
								if ($result_ni > 0){	
                               		while ($row_nivel = mysql_fetch_assoc($result_ni)){
									 $nivel_mostrar=$row_nivel['nom_nivel'];
									// $pingresar=$row_nivel['ingresar'];
									 //$pmodificar=$row_nivel['modificar'];
									 //$peliminar=$row_nivel['eliminar'];
									 //$pconsultar=$row_nivel['consultar'];
									}
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

 <?php
									

// INICIA EL GUARDADO DE INFORMACION 
	
	
//	$bandera_eli = $_POST['bandera_acciones'];
//	if($bandera_eli=="ok"){
	
	 $cod2= $_POST["codigo_usuario"];
	 $_SESSION['codigo']=$cod2;
	 $nombre1  = strtoupper($_POST["nombre_usuario_mod"]);
	 $correo1 = $_POST["correo_usuario"];
	 $pass1 = md5($_POST["pass_usuario"]);
	 	
//	 $nombre_usuario=$_POST['nombre_usuario'];
//	 $con_usuario=$_POST['con_usuario'];
//	 $activo=1;
//	 $empresa=$id_empresa;
//	 $modificar=1;

//$resultado = autorizar_mod($nombre_usuario,$con_usuario,$activo,$empresa,$modificar);	
//if($resultado==1){
//		$guarda="400"; // Guarda
//	}else{
//		
//		$guarda="300"; // no posee permisos
//		}
//	}
//	
		
 if($guarda==400) // incia la actualizaccón
   {//inicio if bandera ok
   //	  	echo "entra";
   $tabla5="SELECT *  FROM t_usuarios where correo_usuario='$nombre_usuario' and pass_usuario='$con_usuario' and id_empresa='$id_empresa'";
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_actualiza=$row5['id_usuario'];
}
   
   if(isset($cod2)){
		$sql= ("UPDATE t_usuarios SET nombre_usuario='$nombre1',correo_usuario='$correo1', pass_usuario='$pass1', id_usuario_modifica='$usuario_actualiza', fecha_modifica='$fecha', hora_modifica='$hora' WHERE id_usuario='$cod2' and id_empresa='$id_empresa'");
		mysql_query($sql,$con);
   }
   	   
				   
		 if(mysql_error())
		  { 
			$error="1";
		  }
			  else
			$error="2";
					  
		//	}
   }//fin bandera ok	

?>   

<?PHP 

 if($error == 1)
 {
	  echo '<div class="alert alert-success">
 			<a href="f_usuarios.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == 2)
 {
	 unset($_SESSION['codigo']);
	 echo '<div class="alert alert-success">
 						  <a href="f_usuarios.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }

if($error == 3)
 {
	 echo '<div class="alert alert-danger">
 						  <a href="f_usuarios.php" class="alert-link">No tiene permiso para modificar registro!!! Haga click para continuar .....</a>
						  </div>';
	  }	  
 
?>
           <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Modificar datos de usuarios</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
          <form action="f_actualizar_usuarios.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="0" type="hidden" />     
	   	<input type="hidden" name="bandera_acciones" value="">
       
           <div class="row"><!--- INICIO ROW----->
            
          <div class="col-md-12">
          <div class="form-group">
          		<label>CODIGO USUARIO:</label>
               <input type="text" class="form-control input-lg" id="codigo_usuario" name="codigo_usuario" value="<?PHP echo $cod1; ?>" style="background:#FFF" readonly/> 
            </div>
          </div>
          
          </div><!--- FIN ROW-----> 
           
             <div class="row"><!--- INICIO ROW----->
           <div class="col-md-12">
          <div class="form-group">
          		<label>NOMBRE USUARIO:</label>
               <input type="text" class="form-control input-lg" id="nombre_usuario_mod" name="nombre_usuario_mod" value="<?PHP echo $nom1; ?>"placeholder="NOMBRE DE USUARIO" required/> 
            </div>
          </div>
          </div><!--- FIN ROW-----> 
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
            <label>NIVEL:</label>
               <input type="text" class="form-control input-lg" id="nivel_usuario" name="nivel_usuario" value="<?PHP echo $nivel_mostrar; ?>"  style="background:#FFF" readonly/> 
          </div>
          </div>
          </div><!--- FIN ROW-----><br>
          
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
               <label>CORREO ELECTRONICO:</label>
               <input type="text" class="form-control input-lg" name="correo_usuario" value="<?PHP echo $cor1; ?>" placeholder="CORREO ELECTRONICO" required/> 
          </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label>CONTRASEÑA:</label>
               <input type="password" class="form-control input-lg" onfocus="validarEmail(document.formulario.correo_usuario.value)" id="pass_usuario" name="pass_usuario" placeholder="CONTRASEÑA" required/>  
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
              	      <td width="100"><button type="reset" id="btnsub" onClick="cancelar()" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="button" disabled name="btnguardar" data-toggle="modal" data-target="#ventana4" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
              	    </tr>
           	      </table> 
           	      
                </div>
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
<?PHP include("footer.php");  ?>

<!-- FIN FOOTER  -->

</body>
</html>


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
            <br>
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               	<button class="btn btn-primary" type="submit" onClick="actualizar()">Actualizar Registro</button>
    </div>
    <div>               
  </div>                  
            
           </form> 
          
</div>
</div>



