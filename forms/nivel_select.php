<?php 
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

$id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 



 $id_nivel = mysql_real_escape_string($_POST['id_nivel_busca']);
  if(($id_nivel !="" and $id_nivel!="0"))//entra cuando ocurre el change de municipio
  {
     $consulta=mysql_query("SELECT a.* FROM tab_menu as a, tab_detalle_menu as b WHERE b.id_nivel='".$id_nivel."' and a.id_empresa='".$id_empresa."' and a.id_menu NOT IN(SELECT b.id_menu FROM tab_detalle_menu as b WHERE b.id_nivel='".$id_nivel."') GROUP BY a.id_menu",$con);
		
	 echo "<select size='5' name='lista' id='uno' class='form-control input-lg' style='width:540px;height: 125px; background:#FFF;' >";
	      
	
								while($valor=mysql_fetch_array($consulta)){
									$id_nivel=$valor['nivel_menu'];
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