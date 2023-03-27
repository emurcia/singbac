<?php 
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];

if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
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
/*
function consultaDetalle(str1)
  {
	window.open("../reportes/Rp_graficas_generales.php?id_imagen="+str1+"","DETALLE DE IMAGEN","width=890,height=605,scrollbars=NO,Top=30,Left=100,Resizable=NO,Titlebar=NO,Location=NO");
  }
  
*/
function consultaDetalle(str1)
  {
	window.open("dashboard_detallado.php?id_imagen="+str1+"","DETALLE DE IMAGEN","fullscreen","scrollbars=NO,Top=30,Left=100,Resizable=NO,Titlebar=NO,Location=NO");
  }
 </script>
<?php
	$bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
	   //$stringEjecucion = mysql_query ("insert into t_bitacora(id_usu,entradaBitacora,horaBitacora,diaBitacora) values ('$id_empleado','0',CURTIME(),CURDATE());",$conexion);			
 	   session_unset();
	   session_destroy();     
       echo "document.location.href='../index.php';";
     }//Fin if bandera ok
	 echo "</script>";
?>
<body class="container"> 


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



<form name="formulario" method="post" action="f_maqueta.php">
  <input type="hidden" value="0" name="bandera"/>
</form>

           <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>ESTRUCTURA GEOGRAFICA DE SILOS</strong></div> <!-- PANEL 1 --->
           <br>
                      
           <table width="100%" height="100%" border="0" rules="all" align="center">
                <tr>
                	<td>
                 <?PHP
				 $id_sil="SILO-000".$id_empresa;
				$consulta_images = mysql_query("SELECT * FROM tab_silo WHERE id_silo!='$id_sil';",$con);
				$num = 0; $imp_br = 0; 
				if ($fila = mysql_fetch_array($consulta_images)){ 
				   echo "<table border='0' width='100%' rules='none' align='left' cellpadding='12'> \n"; 
				   do { 
				        if(($num%5) == 0){
						   echo "<tr>\n"; $imp_br = 1;}
				        $url_img = $fila['foto_silo'];
					
						  echo "<td width='20%' align='center' height='270px'>\n";
						   echo "<table border='0'  height='100%' width='100%' style='border-radius: 5px; background-color: #ecf4ff; border-color: #c5deff;  border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; font-weight:normal; ' > \n";
						   echo "<tr><td height='155px' align='center'><img src='".$url_img."' style='max-width: 175px; max-height: 150px; ' title='Descripción: ".htmlspecialchars(utf8_encode($fila['nom_silo']))."\n\n Nombre del Silo: ".utf8_encode($fila['nom_silo'])."\n\n Ubicación del silo: ".utf8_encode($fila['dir_silo'])."'></td></tr>\n";
						   echo "<tr><td valign='top' align='center' height='35px'><font size='1'>".$fila['id_silo'].".JPG <br>".utf8_encode($fila['nom_silo'])."</font></td></tr> \n";
						   
						  
						   echo "<tr><td valign='middle' align='center' height='15px'><font size='1'><a href=\"javascript:consultaDetalle('".$fila['id_silo']."')\">[Ver Detalles]</a> &nbsp; ".$link_eliminar."</font></td></tr>\n";

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

