<?php 
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

$id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 


 $id_nivel = mysql_real_escape_string($_POST['id_nivel_busca']);
 $sql_cliente=mysql_query("SELECT * FROM tab_cliente WHERE  nom_cliente='".$id_nivel."' and id_empresa='$id_empresa' GROUP BY nom_cliente", $con);
  while ($row2 = mysql_fetch_array($sql_cliente)) 
		{
			$id_cliente=$row2["id_cliente"];
		}
		
  if(($id_nivel !="" and $id_nivel!="0"))//entra cuando ocurre el change de municipio
  {
     $consulta=mysql_query("SELECT * FROM tab_reporte_cliente WHERE  id_cliente='".$id_cliente."'  and numero_reporte!='0' and id_empresa='$id_empresa'", $con);
		
	 echo "<select size='5' name='sel2' id='dos' class='form-control input-lg' style='width:540px;height: 125px; background:#FFF;' >";
	      
	
								while($valor=mysql_fetch_array($consulta)){
																	
									$id_menu= $valor['id_reporte'];
									//$nom_menu=$valor["opcion_menu"];
									$nom_menu= utf8_encode($valor["nom_reporte"]) ;
									echo "<option value='$nom_menu'>";
									echo ("$nom_menu");
									echo"</option>";
								}	
					
			
     echo "</select> ";		
  
  }else{
	  echo "<select size='5' name='sel2' id='dos' class='form-control input-lg' style='width:540px;height: 125px; background:#FFF;' >";
    echo "<option value='0'> SELECCIONE USUARIO</option>";
	 echo "</select> ";	
  }
?>