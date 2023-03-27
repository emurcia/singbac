<?php 
include("../Connections/db_fns.php");
include("../conexion/conexion.inc");///ABRIR LA CONEXION
$conexiondos = db_connect();


  $id_lote2 = mysql_real_escape_string($_POST['id_lote_busca']);
  if(($id_lote2 !="" ))//entra cuando ocurre el change de municipio
  {
     $consulta=mysql_query("SELECT * FROM tab_detalle_servicio as a, tab_servicio as b WHERE a.id_lote = '".$id_lote2."' and a.id_servicio=b.id_servicio ",$conexiondos);
     echo " <select name='id_municipio' id='id_municipio_input' style='width:100%; border: 1px solid #ddd; height: 46px; border-color: #66afe9; outline: 0;  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);     box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6); border-radius: 4px;' >";
     echo "<option value='0'>SELECCIONE SERVICIO</option>";
							  
		while($valor=mysql_fetch_array($consulta)){
			$codigo_municipio= $valor['id_servicio'];
			$nombre= $valor["nom_servicio"];
			echo "<option value='$codigo_municipio'>";
			
			echo utf8_encode("$nombre");
			echo"</option>";
		}	
     echo "</select> ";		
  
  }
?>