<?php 
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

   $id_lote2 = $_POST['id_lote_busca'];
	 $consulta=mysql_query("SELECT humedad FROM tab_producto WHERE id_producto= '".$id_lote2."' and id_empresa='".$id_empresa."'",$con);
 		echo $valor=mysql_fetch_assoc($consulta);
			

?>