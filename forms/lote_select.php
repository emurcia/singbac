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
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
unset($_SESSION['id_producto']);
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");
$id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 


  $id_cliente2 = mysql_real_escape_string($_POST['id_cliente_busca']);
  
  if(($id_cliente2 !="" ))//entra cuando ocurre el change de municipio
  {
     $consulta=mysql_query("SELECT * FROM tab_detalle_servicio WHERE id_cliente = '".$id_cliente2."' and id_empresa='".$id_empresa."' and bandera=0 group by id_lote;",$con);
     echo " <select name='id_lote2' onchange='cerrar()' id='id_lote2' class='chosen' style='width:100%; border: 1px solid #ddd; height: 46px; border-color: #66afe9; outline: 0;  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);     box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6); border-radius: 4px;' >";
     echo "<option value='0'>SELECCIONE LOTE</option>";
							  
		while($valor=mysql_fetch_array($consulta)){
			$codigo_municipio= $valor['id_lote'];
			$nombre= $valor["num_lote"];
			echo "<option value='$codigo_municipio'>";
			echo ("$nombre");
			echo"</option>";
		}	
     echo "</select> ";	
	 
	 
	 
 }else
    {
	  echo " <select name='id_silo2' id='id_silo2' class='chosen' style='width:100%; border: 1px solid #ddd; height: 46px; border-color: #66afe9; outline: 0;  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);     box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6); border-radius: 4px;' >";
     echo "<option value='0'> SELECCIONE LOTE</option>";
	 echo "</select>";
  }
  
?>