<?php 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
@session_start();
$id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
$id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
//echo '<script type="text/javascript">';
date_default_timezone_set("America/El_Salvador");
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora_entrada=date("H:i:s"); 
  
if(isset($_POST['guardar_id_valmacenaje']) && !empty($_POST['guardar_id_valmacenaje'])){
	
		$id_variable1=$_POST['guardar_id_variable'];
		$id_almacenaje1=$_POST['guardar_id_valmacenaje'];
		$peso_vol1=$_POST['guardar_peso_vol'];
		$humedad1=$_POST['guardar_humedad'];
		$temperatura1=$_POST['guardar_temperatura'];	
		$grano_entero1=$_POST['guardar_grano_entero'];
		$grano_quebrado1=$_POST['guardar_grano_quebrado'];
		$dan_hongo1=$_POST['guardar_dan_hongo'];
		$impureza1=$_POST['guardar_impureza'];
		$grano_chico1=$_POST['guardar_grano_chico'];
		$grano_picado1=$_POST['guardar_grano_picado'];	
		$plaga_viva1=$_POST['guardar_plaga_viva'];
		$plaga_muerta1=$_POST['guardar_plaga_muerta'];	
		$stress_crack1=$_POST['guardar_stress_crack'];
		$olor1=strtoupper($_POST['guardar_olor']);
		$vapor1=strtoupper($_POST['guardar_vapor']);	
		$nom_analista1=strtoupper($_POST['guardar_nom_analista']);																		
		
		$_SESSION['$id_almacenaje1']=$id_almacenaje1;
		$_SESSION['peso_tara1']=$_POST['peso_tara1'];
	
// INICIA EL GUARDADO DE INFORMACION 
				
	
 $sqlvar= ("UPDATE tab_almacenaje SET id_variable='$id_variable1', peso_vol='$peso_vol1', humedad='$humedad1', temperatura='$temperatura1', grano_entero='$grano_entero1', grano_quebrado='$grano_quebrado1', dan_hongo='$dan_hongo1', impureza='$impureza1', grano_chico='$grano_chico1', grano_picado='$grano_picado1', plaga_viva='$plaga_viva1', plaga_muerta='$plaga_muerta1', stress_crack='$stress_crack1', olor='$olor1', vapor='$vapor1', nom_analista='$nom_analista1' WHERE id_almacenaje='$id_almacenaje1' and id_empresa='$id_empresa'");
 mysql_query($sqlvar,$con);    
				   
					  
 }


?>