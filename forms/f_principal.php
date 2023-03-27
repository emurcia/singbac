<?php 
ini_set('session.save_handler', 'files');
@session_start();

include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
//header('Content-Type: text/html; charset=UTF-8'); 


 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $id_usuario1=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];
 $hora_entra= $_SESSION['hora_entra'];

 // Verificación de sesiones

 if ($_SESSION['token_ss'] != NULL) //solo si hay session activa
									{
$loginSQL=mysql_query("select token from t_usuarios  where id_usuario='$id_usuario1'",$con);

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
date_default_timezone_set("America/El_Salvador");
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora_entrada=date("H:i:s");
?>
<!DOCTYPE html> 
<html> 
<head > 

<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
</head> 
<script>
function salirr()
 {	 
    document.formulario.bandera.value="oki";
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
<body class="container" >


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

<br><br><br>
<br><br>
<br>

 <div class="row"><!--- INICIO ROW----->
   <div class="col-md-12" width="100px" align="center">
   <img src="../images/principal.png"  alt="" > 
   </div>
  </div><!--- FIN ROW-----> 
    
<form name="formulario" method="post" action="f_principal.php">
  <input type="hidden" value="0" name="bandera"/>
</form>

<!--  INICIO FOOTER   -->
<?PHP include("footer.php"); ?>
<!-- FIN FOOTER  -->

</body> 
</html>
<?PHP mysql_close(); ?>
