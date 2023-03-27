<?php 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");


  $id_cliente2 = mysql_real_escape_string($_POST['id_cliente_busca']);
  
  if(($id_cliente2 !="" ))//entra cuando ocurre el change de municipio
  {
	  
	   
     $consulta=mysql_query("SELECT * FROM tab_detalle_servicio as a, tab_almacenaje as b WHERE a.id_cliente=b.id_cliente and a.id_cliente = '".$id_cliente2."' and b.bandera=2 group by b.id_lote",$con);
     echo " <select name='id_lote2' id='id_lote2' style='width:100%; border: 1px solid #ddd; height: 46px; border-color: #66afe9; outline: 0;  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);     box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6); border-radius: 4px;' >";
     echo "<option value='0'>SELECCIONE LOTE</option>";
							  
		while($valor=mysql_fetch_array($consulta)){
			$codigo_municipio= $valor['id_lote'];
			$nombre= $valor["num_lote"];
			echo "<option value='$codigo_municipio'>";
			echo ("$nombre");
			echo"</option>";
		}	
     echo "</select> ";	
  
	 
  }
  
?>