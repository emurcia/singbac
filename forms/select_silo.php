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
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

  $id_lote2 = mysql_real_escape_string($_POST['id_lote_busca']);
  if(($id_lote2 !="" ))//entra cuando ocurre el change de municipio
  {
	 $consulta=mysql_query("SELECT * FROM tab_silo as a, tab_lote as b WHERE a.id_silo=b.id_silo and b.id_lote = '".$id_lote2."' and b.id_empresa='".$id_empresa."' and b.bandera=0",$con);
     echo " <select name='id_silo2' id='id_silo2' class='chosen' style='width:100%; border: 1px solid #ddd; height: 46px; border-color: #66afe9; outline: 0;  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);     box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6); border-radius: 4px;' >";
     echo "<option value='0'> SELECCIONE SILO</option>";
							  
		while($valor=mysql_fetch_array($consulta)){
			$codigo_municipio= $valor['id_silo'];
			$nombre= $valor['nom_silo'];
			echo "<option value='$codigo_municipio'>";
			echo utf8_encode("$nombre");
			echo"</option>";
		}	
     echo "</select> ";	
}else
    {
	  echo " <select name='id_silo2' id='id_silo2' class='chosen' style='width:100%; border: 1px solid #ddd; height: 46px; border-color: #66afe9; outline: 0;  -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);     box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6); border-radius: 4px;' >";
     echo "<option value='0'> SELECCIONE SILO</option>";
	 echo "</select>";
  }
?>