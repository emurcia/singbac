<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("conexion/conexion.php");
include ("conexion/conexion.inc");
include("function/functions.inc");
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
<title>SINGBAC - SISTEMA DE INVENTARIO DE GRANOS BASICOS</title>
<script>
function entrar()
{//inicio entrar
   document.formulario.bandera.value="ok";
}//fin entrar
</script>


</head>

<body <?php if($_GET['action']=="expired")  echo '<div>Estimado Usuario, le informamos que se abrió otra sesión con sus credenciales.!!!</div>';?> >
<div class = "container">

<?PHP
    $error = "0";
	$bandera = $_POST['bandera'];
	$correo_usuario = $_POST['correo_usuario'];
	$pass_usuario = md5($_POST['pass_usuario']);
    if($bandera=="ok")
    {//inicio bandera ok

	
	$resultado0=mysql_query("SELECT count(*) AS maximo, b.estado as estado_empresa FROM  t_usuarios as a, t_empresa as b WHERE a.id_empresa=b.id_empresa and correo_usuario = '$correo_usuario'",$con);
            $valor=mysql_fetch_array($resultado0);
			
			if (mysql_error()) die('Error, mysql_error()! :-(');            
            if($valor['maximo']==0)
            {
                $error = 1; //contraseña o nombre incorrectos
            }
            else
            {//inicio else 2 
                $resultado=mysql_query("SELECT a.*, b.* FROM t_usuarios  as a, t_empresa as b WHERE a.id_empresa=b.id_empresa and a.correo_usuario = '$correo_usuario'",$con);
				$valor=mysql_fetch_array($resultado);
                				
				$id_usuario = 0;
				$id_empresa = 0;
				$activo_usuario = 0;
				$nivel=0;
				$bandera_empresa1=0;
				$bandera_empresa1=$valor['estado']; // 1 activo, 2 desactivado
				$id_usuario = $valor['id_usuario'];
				$id_empresa = $valor['id_empresa'];
				$nombre_empresa=$valor['nombre_empresa'];
				$activo_usuario = $valor['activo_usuario'];
				$nivel = $valor['id_nivel'];				
				
				if($bandera_empresa1==2){							   
				   $error=3;
				}else{
             //verificar nivel de usuario
                if($pass_usuario==$valor['pass_usuario'])
                {//inicio if passusuario    
				        $_SESSION['activo_usuario_silo']=0;
                        if($activo_usuario == 1)
                          $_SESSION['activo_usuario_silo']=1; //master
                        else //if($activo_usuario == 0)
						  $_SESSION['activo_usuario_silo']=0; // Inactivo
						  
						if($bandera_empresa1==1)
						     $bandera_empresa=1;
						
							   							   
						if($activo_usuario == 0) //inactivo
						  $error = 55;
						else if($activo_usuario == 1) //Master, administrador, operador y reporteria
						{		

$Result1 = mysql_query("SELECT MAX(id_bitacora) as a  FROM tab_bitacora where id_empresa='$id_empresa' ORDER BY id_bitacora asc ") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],8,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "BITACOR-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "BITACOR-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "BITACOR-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "BITACOR-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "BITACOR-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "BITACOR-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "BITACOR-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}	
	
							$datoToken = session_id();
						                  
							$_SESSION['permiso_silo']='ok';
							$_SESSION['nombre_usuario_silo']=$valor['nombre_usuario'];
							$_SESSION['id_empresa_silo']=$id_empresa; 
							$_SESSION['bandera_empresa']=$bandera_empresa; 							                        	$_SESSION['id_usuario_silo']=$id_usuario;
							$_SESSION['nivel_silo']=$nivel;	
							$_SESSION['token_ss'] =  $datoToken;
							$_SESSION['correo_usu'] =  $correo_usuario;
							$_SESSION['hora_entra'] =  $hora_entrada;
							$_SESSION['nom_sistema']=$nombre_empresa; // Nombre del sistema
							mysql_query("insert into tab_bitacora( id_bitacora, id_usuario, id_empresa, fecha_entrada, hora_entrada, fecha_salida, hora_salida, estado_bitacora) values ('$nu','$id_usuario', '$id_empresa', '$fecha_entrada', '$hora_entrada', '$fecha_entrada', '$hora_entrada', 0)",$con);  
							$updateSQL = "UPDATE t_usuarios SET token='$datoToken' WHERE id_usuario='$id_usuario'";
							$resultSQL = mysql_query($updateSQL, $con);
		
   					
							$error = 2; //acceder
							
				   
		
						} 
                   
                }//fin if passusuario
                else
                {
                    $error = 1; //contraseña o nombres incorrectos
                }
		 } // fin del if de empresa activa
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

if($error == 3)
 {
	 echo "<br><br> <div class='alert alert-danger alert-dismissable'>
			  <button type='button' class='close' data-dismiss='alert'>&times;</button>
			  <center><strong>¡Error!</strong> La Empresa se encuentra inactiva, debe ponerse en contacto con un administrador!!!</center>
			</div>";
	  }	  
 if ($error == 2)
 {
	 echo "<script>";
	 echo "document.location.href='forms/f_principal.php';"; 
	 echo "</script>";
 }

if ($error == 5)
 {
	 echo '<div class="alert alert-danger">
 			<a class="alert-link">Estimado Usuario, le informamos que se abrió otra sesión con sus credenciales.!!!</a>
						  </div>';
	 }
    
?>

    
		<form action="index.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="" type="hidden" />     
	
      
              
		<div>
			<h1 style="color:#FFF"><center>Iniciar sesión<img src="images/user.png"></center></h1>
		
			 
		</div>             
			  <div style="padding-left:4%; padding-right:4%">
               <label style="color:#FFF">USUARIO:</label>
			  <input type="text" class="form-control input-lg" id="correo_usuario" name="correo_usuario" placeholder="Correo Electrónico" required autofocus="" autocomplete="off" />
              </div>
              <br />
              <div style="padding-left:4%; padding-right:4%">
              <label style="color:#FFF">CONTRASEÑA:</label>
               <input type="password" class="form-control input-lg" name="pass_usuario" id="pass_usuario" placeholder="Contraseña" autocomplete="off" required/>     		  			  </div>
              <br />

          <br />	
			 <div align="center">
			  <button  name="submit" value="Login" type="submit" onclick="entrar();"><img src="images/entrar.gif" width="180" height="28" />
              </button>  			
              </div>
              <br />
		</form>			
	</div>
</div>
<?PHP
  mysql_close();
?>
</div>

<!--  INICIO FOOTER   -->
<?PHP include("forms/footer.php"); ?>
<!-- FIN FOOTER  -->
</body>
</html>