<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
<script src="../assets/javascript/chosen.jquery.js"></script>
<script>
        $(document).ready(function(){
			//$(".chosen").chosen();
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
</script>
<?php 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

  $id_cliente = mysql_real_escape_string($_POST['id_cliente_busca']);
  if(($id_cliente !="" ))//entra cuando ocurre el change de municipio
  {
     $consulta=mysql_query("SELECT a.id_producto, a.nom_producto from tab_producto as a, tab_bascula as b WHERE a.id_producto=b.id_producto and b.id_cliente='$id_cliente' GROUP BY a.id_producto",$con);
     echo " <select name='id_producto' id='id_producto' class='chosen' style='width:100%; border: 1px solid #ddd; height: 46px; border-color: #66afe9; outline: 0;  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);     box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6); border-radius: 4px;' >";
     echo "<option value='0'> TODOS </option>";
							  
		while($valor=mysql_fetch_array($consulta)){
			$codigo_municipio= $valor['id_producto'];
			$nombre= $valor["nom_producto"];
			echo "<option value='$codigo_municipio'>";
			echo ("$nombre");
			echo"</option>";
		}	
     echo "</select> ";		
  
  }
?>