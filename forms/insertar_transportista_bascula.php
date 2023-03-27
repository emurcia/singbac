<?PHP
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
@session_start();
$id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
//echo '<script type="text/javascript">';
date_default_timezone_set("America/El_Salvador");
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora_entrada=date("H:i:s"); 
  
if(isset($_POST['codigounidad']) && !empty($_POST['codigounidad'])){
	
	  
  	 $id1= strtoupper($_POST['codigounidad']);
	$dpi1=$_POST["dpi_transportista"];
	   $ape1  = strtoupper($_POST["ape_transportista"]);
	    $nom1  = strtoupper($_POST["nom_transportista"]);		 
	    $dir1 = "";
	    $tel1 = "";
		$placa1=strtoupper($_POST["placa_vehiculo"]);
		 $color1="";
	    $cap1="0.00";		 
	    $obs1="";	
	    $id_cliente1=$_POST["insercliente"];		 		 	
	    $id_empresa1=$_SESSION['id_empresa_silo'];	
		
		
		$_SESSION['$peso_url']=$_POST["peso_capturado"]; // PARA MANTENER EL PESO
		$_SESSION['$id_cliente1']=$id_cliente1;
		$_SESSION['$id_transportista1']=$_POST['codigounidad'];
			
  	  
// INICIA EL GUARDADO DE INFORMACION 
				
	

  mysql_query("insert into tab_transportista(id_transportista, dpi_transportista, ape_transportista, nom_transportista, dir_transportista, tel_transportista, placa_vehiculo, color_vehiculo, cap_vehiculo, obs_vehiculo, id_cliente, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values('$id1', '$dpi1', '$ape1', '$nom1', '$dir1', '$tel1', '$placa1', '$color1', '$cap1', '$obs1', '$id_cliente1', '$id_empresa1', '$id_usuario','0', '$fecha_entrada',  '$hora_entrada', '$id_usuario', '$fecha_entrada', '$hora_entrada')",$con) or die(mysql_error());    
				   
					  if(mysql_error())
					  { 
					 
					 $error1=1;
					  }
					  else
					  
					 $error1=2;
					  
 }
else{
echo "error";}

?>