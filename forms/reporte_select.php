<?php 
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

$id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 



$id_nivel = mysql_real_escape_string($_POST['id_nivel_busca']);
 
 $datos=mysql_query("SELECT * FROM tab_cliente WHERE nom_cliente='$id_nivel'",$con);
$array = mysql_fetch_assoc($datos);
{
	 
	$id_cliente=$array['id_cliente'];
	$_SESSION['id_cliente_guarda']=$id_cliente;
	 	 
	 
}
 
  if(($id_cliente !="" and $id_cliente!="0"))//entra cuando ocurre el change de municipio
  {
     $consulta=mysql_query("SELECT a.* FROM tab_menu_reporte as a, tab_reporte_cliente as b WHERE a.numero_reporte!='0' and b.id_cliente='".$id_cliente."' and a.id_empresa='".$id_empresa."' and a.numero_reporte NOT IN(SELECT b.numero_reporte FROM tab_reporte_cliente as b) GROUP BY a.opcion_menu",$con);
		
	 echo "<select size='5' name='lista' id='uno' class='form-control input-lg' style='width:540px;height: 125px; background:#FFF;' >";
	      
	
								while($valor=mysql_fetch_array($consulta)){
									//$id_nivel=$valor['id_menu'];
									//if($id_nivel=="1") $variable="Opción Principal";
									//if ($id_nivel=="2") $variable="Opción Secundaria";
									$id_menu= $valor['id_menu'];
									//$nom_menu= $valor["opcion_menu"] ."  (".$variable.")" ;
									$nom_menu= utf8_encode($valor['opcion_menu']);
									echo "<option value='$nom_menu'>";
									echo ("$nom_menu");
									echo"</option>";
								}	
					
			
     echo "</select> ";		
  
  }else{
	  echo "<select size='5' name='lista' id='uno' class='form-control input-lg' style='width:540px;height: 125px; background:#FFF;' >";
    echo "<option value='0'> SELECCIONE NIVEL</option>";
	 echo "</select> ";	
  }
?>