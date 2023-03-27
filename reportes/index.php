<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("conexion/conexion.php");
include ("conexion/conexion.inc");
$id_empresa=$_SESSION['id_empresa_silo'];

?>
<?PHP
date_default_timezone_set("America/El_Salvador");
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora_entrada=date("H:i:s");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="images/favicon.ico" rel="icon">
<title>SYLOS</title>
<script>
function entrar()
{//inicio entrar
   document.formulario.bandera.value="ok";
   //document.formulario.submit();
}//fin entrar
</script>


</head>

<body <?php if($_GET['action']=="expired")  echo '<div>Estimado Usuario, le informamos que se abrió otra sesión con sus credenciales.!!!</div>';?> >
<div class = "container">
  <div class = "container">
    <form action="index.php" class="formusu" method="post" name="formulario" role="form">
      <div>
	    <h1 style="color:#FFF"><center>

	      <!--  INICIO FOOTER   -->
	      <img src="../images/error404.png" width="682" height="472" />
	    </center>
	    </h1>
      </div>
    </form>
  </div>
</div>
<!-- FIN FOOTER  -->
</body>
</html>