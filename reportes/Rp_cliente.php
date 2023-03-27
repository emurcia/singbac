<html>
<head>
<title>REPORTE CLIENTES</title>
<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece                        
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $peso_bruto_url=$_GET['peso_bruto'];
 //$reporte_busca=$_POST['nu'];
if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
 
date_default_timezone_set("America/El_Salvador");
$ano=date('Y');
$fecha=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");


$string_clientes = mysql_query("SELECT  
											`id_cliente`,  
											`nom_cliente`,  
											`dir_cliente`,  
											`tel_cliente`,  
											`ape_responsable`,  
											`nom_responsable`, 
											`dir_responsable`,  
											`tel_responsable` 
											FROM `tab_cliente` WHERE `id_cliente`!='CLI-000'",$con);


//$string_plan = mysql_query("SELECT * FROM t_plan_pagos WHERE id_compromiso = '".$rs_todo_pago['id_compromiso']."' AND num_cuota_plan = '".$rs_todo_pago['num_cuota_pagop']."'; ",$conexion);
//$rs_plan = mysql_fetch_array($string_plan);

//$string_compradores = mysql_query("SELECT ca.*, c.* FROM t_compradores_asoc AS ca, t_compradores as c WHERE ca.id_compromiso = '".$rs_todo_pago['id_compromiso']."' AND ca.id_comprador = c.id_comprador",$conexion);

?>


<style type="text/css">


BODY{


   	font-family: verdana;


}
</style>




<script type="text/javascript">
function mostrar(){
	window.print();
}	

</script>

</head>
<body onLoad="mostrar();" onclick="window.close();">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
	  <td width="18%" ><img src="../images/logo.png" alt="Logo" width="100px" height="100px"></td>
		<td width="82%" ><center>
		  <b><font size="4px">CLIENTES</font></b>
		  </center>
<center></center>

		</td>
	</tr>
</table>
<HR>
<table style="font-size: 14px" width="100%" cellpadding="0" cellspacing="0" border="1">
	<tr>
		<th width="5%"><center><font size="2px"><b>N°</b></font></center></th>
		<th width="5%"><center><font size="2px"><b>ID</b></font></center></th>
		<th width="20%"><center><font size="2px"><b>CLIENTE</b></font></center></th>
		<th width="20%"><center><font size="2px"><b>DIRECCION</b></font></center></th>
		<th width="5%"><center><font size="2px"><b>TELEFONO</b></font></center></th>
		<th width="20%"><center><font size="2px"><b>RESPONSABLE</b></font></center></th>
		<th width="20%"><center><font size="2px"><b>DIRECCION</b></font></center></th>
		<th width="5%"><center><font size="2px"><b>TELEFONO</b></font></center></th>
	</tr>
	<?php 
		$i=0;
		while ($rs_clientes = mysql_fetch_array($string_clientes)) {
			$i++;
			echo "<tr>";
			echo "<td><center><font size=\"2px\">".$i."</center></td>";
			echo "<td><center><font size=\"2px\">".$rs_clientes['id_cliente']."</center></td>";
			echo "<td><left><font size=\"2px\">".$rs_clientes['nom_cliente']."</left></td>";
			echo "<td><left><font size=\"2px\">".$rs_clientes['dir_cliente']."</left></td>";
			echo "<td><left><font size=\"2px\">".$rs_clientes['tel_cliente']."</left></td>";
			echo "<td><left><font size=\"2px\">".$rs_clientes['nom_responsable']." ".$rs_clientes['ape_responsable']."</left></td>";
			echo "<td><left><font size=\"2px\">".$rs_clientes['dir_responsable']."</left></td>";
			echo "<td><left><font size=\"2px\">".$rs_clientes['tel_responsable']."</left></td>";
			echo "</tr>";
		}
	 ?>
</table>
</body>


</html>