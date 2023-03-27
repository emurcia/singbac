<?php 
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
$id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 

  $id_cliente2 = mysql_real_escape_string($_POST['id_cliente_busca']);
  $id_lote2 = mysql_real_escape_string($_POST['id_lote_busca']);
  if(($id_lote2 !=""))//entra cuando ocurre el change de municipio
  {
	 $consulta=mysql_query("SELECT * FROM tab_servicio as a, tab_detalle_servicio as b WHERE a.id_servicio=b.id_servicio and b.id_lote = '".$id_lote2."' and b.id_cliente = '".$id_cliente2."' and a.id_empresa='".$id_empresa."' and a.bandera=0 ",$con);

     echo " <select size='5' name='id_servicio2' id='id_servicio2' class='form-control input-lg ' style='height: auto; background:#FFF;' readonly >";
		while($valor=mysql_fetch_array($consulta)){
			$codigo_municipio= $valor['id_servicio'];
			$nombre= $valor['nom_servicio'];
			echo "<option value='$codigo_municipio'>";
			echo utf8_encode("$nombre");
			echo"</option>";
		}	
     echo "</select> ";		
  
  }else
  
    {
	  echo "<select size='5' name='id_servicio2' id='id_servicio2' class='form-control input-lg' style='height: auto; background:#FFF; ' disabled='disabled' >";
     echo "<option value='0'> SERVICIOS DEL LOTE</option>";
	 echo "</select>";
  }
?>