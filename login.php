<?php 
//ini_set('session.save_handler', 'files');
session_start();
//include("forms/functions.inc");
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
?>
<?PHP
$bandera = $_POST['bandera'];
$correo_usuario = $_POST['correo_usuario'];
$pass_usuario = $_POST['pass_usuario'];
//include("Connections/db_fns.php");
//$conexion = db_connect(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SILOS</title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<link href="css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="css/login.css" rel="stylesheet" media="screen"> 
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script> 
<link href="images/favicon.ico" rel="icon">

<script>
function entrar()
{//inicio entrar
   document.formulario.bandera.value="ok";
   //document.formulario.submit();
}//fin entrar
</script>


</head>

<body>

<?php 
    $error = 0;
     
    echo "<script>";
    if($_SESSION['permiso']=='ok')
    {
        if($_SESSION['activo_usuario']==1)
             echo "document.location.href='forms/index.php';";
    }
    echo "</script>";
                     
    if($bandera=="ok")
    {//inicio bandera ok
            $resultado0=mysql_query("SELECT count(*) AS maximo FROM t_usuarios WHERE correo_usuario = '$correo_usuario'",$con);
            $valor=mysql_fetch_array($resultado0);
			
			if (mysql_error()) die('Error, mysql_error()! :-(');            
            if($valor['maximo']==0)
            {
                $error = 1; //contraseña o nombre incorrectos
            }
            else
            {//inicio else 2 
                $resultado=mysql_query("SELECT * FROM t_usuarios WHERE correo_usuario = '$correo_usuario';",$con);
				$valor=mysql_fetch_array($resultado);
                				
				$id_usuario = 0;
				$id_empresa = 0;
				$activo_usuario = 0;
				
				$id_usuario = $valor['id_usuario'];
				$id_empresa = $valor['id_empresa'];
				$activo_usuario = $valor['activo_usuario'];
				
             
                if($pass_usuario==$valor['pass_usuario'])
                {//inicio if passusuario    
				        $_SESSION['activo_usuario']=0;
                        if($activo_usuario == 1)
                          $_SESSION['activo_usuario']=1;
                        else 
						  $_SESSION['activo_usuario']=0;
						  
						if($activo_usuario == 0)
						  $error = 55;
						else
						{						                  
							$_SESSION['permiso']='ok';
							$_SESSION['nombre_usuario']=$valor['nombre_usuario'];
							$_SESSION['id_empresa']=$id_empresa;                         
							$_SESSION['id_usuario']=$id_usuario;
							
							$error = 2; //acceder
						}
                   
                }//fin if passusuario
                else
                {
                    $error = 1; //contraseña o nombres incorrectos
                }
            }//Fin else 2
 
    }//fin if bandera ok
   
?>


<div class = "container">

<?PHP 

 if($error == 1)
 {
	 echo "<br><br> <div class='alert alert-danger alert-dismissable'>
			  <button type='button' class='close' data-dismiss='alert'>&times;</button>
			  <center><strong>¡Error!</strong> Contraseña o Nombre de Usuario Incorrectos!!!</center>
			</div>";
 }
 
 if($error == 55)
 {
	 echo "<br><br> <div class='alert alert-danger alert-dismissable'>
			  <button type='button' class='close' data-dismiss='alert'>&times;</button>
			  <center><strong>¡Error!</strong> La cuenta se encuentra inactiva, debe ponerse en contacto con un administrador!!!</center>
			</div>";
 }
 if ($error == 2)
 {
	 echo "<script>";
	 echo "document.location.href='forms/index.php';";
	 echo "</script>";
 }
?>
	<div class="wrapper">
		<form action="login.php" method="post" name="formulario" class="form-signin" role="form">  
        <input name="bandera" value="0" type="hidden" />     
		    <h3 class="form-signin-heading">¡Bienvenido!</h3>
			  <hr class="colorgraph"><br>
			  
			  <input type="text" class="form-control" name="correo_usuario" placeholder="Correo Electrónico" required autofocus="" />
			  <input type="password" class="form-control" name="pass_usuario" placeholder="Contraseña" required/>     		  
			 
			  <button class="btn btn-lg btn-primary btn-block"  name="submit" value="Login" type="submit" onclick="entrar();">Iniciar Sesión</button>  			
		</form>			
	</div>
</div>

</body>
</html>