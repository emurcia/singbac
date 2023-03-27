<?php 
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

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

$loginSQL=mysql_query("select token, nombre_usuario from t_usuarios  where id_usuario='$id_usuario'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$fila_usu['token'];
$nombre_usuario=$fila_usu['nombre_usuario'];
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
	
$datos=mysql_query("SELECT * FROM tab_cliente WHERE nom_cliente='$nombre_usuario'",$con);
$array = mysql_fetch_assoc($datos);
{
	 
	 $cod_cliente=$array['id_cliente'];
	 $nom_cliente=$array['nom_cliente'];
	 $direccion_cliente=$array['dir_cliente'];
	 $telefono_cliente=$array['tel_cliente'];
	 $reponsable_cliente=$array['nom_responsable']." ".$array['ape_responsable'];
	 $direccion_responsable=$array['dir_responsable'];
	 $tel_responsable=$array['tel_resposable'];
	// $fecha_creado=parseDatePhp($array['fecha_usuario']);	 	 
	 
}	
	
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=Width-device, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="http://code.jquery.com/jquery.js"></script> 
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
 
function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }

function consultaDetalle(str1)
  {
	  
	window.open("../"+str1+"","DETALLE DE IMAGEN","fullscreen","scrollbars=NO,Top=30,Left=100,Resizable=NO,Titlebar=NO,Location=NO");
  }
  
function inforgeneral()
  {
	window.open("detalleImagen.php","DETALLE DE IMAGEN","fullscreen","scrollbars=NO,Top=30,Left=100,Resizable=NO,Titlebar=NO,Location=NO");
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



<form name="formulario" method="post" action="f_reportes_cliente.php">
  <div align="center">
    <input type="hidden" value="0" name="bandera"/>
    <span class="panel panel-primary"><img onClick="inforgeneralcliente()" src="../images/ver.jpg" width="283" height="140" longdesc="Información General"></span></div>
</form>

           <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>REPORTES</strong></div> <!-- PANEL 1 ---><br>
           <br>
           
                      
          <table width="100%" height="100%" border="0" rules="all" align="center">
                <tr>
                	<td>
                 <?PHP
				// $id_sil="SILO-000".$id_empresa;
				$consulta_images = mysql_query("SELECT * FROM tab_reporte_cliente WHERE id_cliente='$cod_cliente' and bandera=0 and numero_reporte!=0 and id_empresa='$id_empresa' ORDER BY id_reporte asc",$con);
				$num = 0; $imp_br = 0; 
				if ($fila = mysql_fetch_array($consulta_images)){ 
				   echo "<table border='0' width='100%' rules='none' align='left' cellpadding='12'> \n"; 
				   do { 
				        if(($num%5) == 0){
						   echo "<tr>\n"; $imp_br = 1;}
				        $url_img = $fila['foto_reporte'];
					
						  echo "<td width='20%' align='center' height='20%'>\n";
						   echo "<table border='0'  height='100%' width='100%' style='border-radius: 5px; background-color: #ecf4ff; border-color: #c5deff;  border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; font-weight:normal; ' > \n";
						   echo "<tr><td height='155px' align='center'><img src='".$url_img."' style='max-width: 150px; max-height: 125px; ' title='Nombre del silo: ".htmlspecialchars(utf8_encode($fila['nom_reporte']))."\n'></td></tr>\n";
						   echo "<tr><td valign='top' align='center' height='35px'><font size='1'>".$fila['nom_reporte']."<br>"."</font></td></tr>";
						   
						  
						   echo "<tr><td valign='middle' align='center' height='15px'><font size='1'><a href=\"javascript:consultaDetalle('".$fila['url']."')\">[Ver Detalles]</a></font></td></tr>\n";

						   echo "</table>\n";
						echo "</td> \n"; 
						if($imp_br == 5){
						   echo "</tr>\n"; $imp_br = 0;}
						$num++;
						$imp_br++;
				   } while ($fila = mysql_fetch_array($consulta_images)); 
				   if($num%5 != 0)
				     echo "<td></td></tr> \n";
				   echo "</table> \n"; 
				} else { 
				echo "¡ No hay imágenes en esta carpeta !";
				}
				?>        
                      	</td>
                </tr>
                </table>

           
           <br>
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

