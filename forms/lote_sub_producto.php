<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
<script src="../assets/javascript/chosen.jquery.js"></script>
<script>
        $(document).ready(function(){
			//$(".chosen").chosen();
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
</script>
<?php
ini_set('session.save_handler', 'files');
@session_start();

 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

 
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 
  $id_lote2 = mysql_real_escape_string($_POST['id_producto_busca']);
  if(($id_lote2 !="" ))//entra cuando ocurre el change de municipio
  {
     $consulta=mysql_query("SELECT * FROM tab_subproducto WHERE id_producto = '".$id_lote2."' and id_empresa='$id_empresa'",$con);
     echo " <select name='id_subproducto' id='id_subproducto' class='chosen' style='width:100%; border: 1px solid #ddd; height: 46px; border-color: #66afe9; outline: 0;  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);     box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6); border-radius: 4px;' >";
     echo "<option value='0'> SELECCIONE SUBPRODUCTO</option>";
							  
		while($valor=mysql_fetch_array($consulta)){
			$codigo_municipio= $valor['id_subproducto'];
			$nombre= $valor["nom_subproducto"];
			echo "<option value='$codigo_municipio'>";
			
			echo utf8_encode("$nombre");
			echo"</option>";
		}	
     echo "</select> ";		
  
  }else
    {
	  echo " <select name='id_subproducto' id='id_subproducto' class='chosen' style='width:100%; border: 1px solid #ddd; height: 46px; border-color: #66afe9; outline: 0;  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);     box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6); border-radius: 4px;' >";
     echo "<option value='0'> SELECCIONE SUBPRODUCTO</option>";
	 echo "</select>";
  }
?>