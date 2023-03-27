<?PHP
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");

 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];
 // Verificación de sesiones

 if ($_SESSION['token_ss'] != NULL) //solo si hay session activa
									{
$loginSQL=mysql_query("select token from t_usuarios  where id_usuario='$id_usuario'",$con);

$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
 $fila_usu['token'];

if( $fila_usu['token'] != $_SESSION['token_ss'] )
{
	echo "<script language='javascript'>";
	echo "document.location.href='destruir_sesion.php';";
	echo "</script>";
}
} // fin de verificar sesion

if($_SESSION['permiso_silo']!='ok'){
	
					echo "<script language='javascript'>";
					echo "document.location.href='../index.php';";
					echo "</script>";
				
		}

// verifica permiso de escritura
$tabla="SELECT *  FROM t_usuarios where id_usuario='$id_usuario' and id_empresa='$id_empresa'";
 $result = mysql_query($tabla);
$array = mysql_fetch_assoc($result);
{
	$nivel1=$array['id_nivel'];
}

$sql_nivel = "SELECT * FROM tab_nivel WHERE id_nivel='$nivel1' and id_empresa='$id_empresa'";
								$result_ni = mysql_query($sql_nivel,$con);
								if ($result_ni > 0){	
                               		while ($row_nivel = mysql_fetch_assoc($result_ni)){
									 $nivel_mostrar=$row_nivel['nom_nivel'];
									 $pingresar=$row_nivel['ingresar'];
									 }
								}
  

date_default_timezone_set("America/El_Salvador");
$ano=date('Y');
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");

?>

<!DOCTYPE html> 
<html> 
<head> 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../assets/stylesheet/caja_buscar.css">
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script src="../assets/javascript/chosen.jquery.js"></script>
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
<link href="../images/favicon.ico" rel="icon">

</head> 

<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers"
	 });


     $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=09 && tecla.keyCode !=127 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
            });
		
});
</script>

	
<script>

		
function guardar(){
var tmsel = document.getElementById('dos').length;
var t="";

			t=document.getElementById('dos').options[0].value;
			
			document.formulario.pasar_parametro.value=t;
			
				for(var z = 1; z < tmsel; z++)
				{
				t = t + "/" + document.getElementById('dos').options[z].value;
				document.formulario.pasar_parametro.value=t;
			//	alert("pueba",+t);
				}
		
	
		document.formulario.bandera.value='ok';
		document.formulario.submit();

		
}// fin guardar

 
function agregar(){
document.formulario.btnguardar.disabled=false;
var sel="";
var aa = document.formulario.lista.options.selectedIndex;
var rec = new Array();

if(aa !=-1){
var x = document.getElementById("dos");
var option = document.createElement("option");
var x1 = document.getElementById("uno");
option.text = x1.options[x1.selectedIndex].value;
x.add(option);
var x = document.getElementById("uno");
x.remove(x.selectedIndex);
}
else
alert("no hay opciones selecciondas");
}


function quitar(){

var sel="", aa = document.formulario.sel2.options.selectedIndex, rec = new Array();

if(aa !=-1){
var x = document.getElementById("uno");
var option = document.createElement("option");

var x1 = document.getElementById("dos");
option.text = x1.options[x1.selectedIndex].value;
x.add(option);
var x = document.getElementById("dos");
x.remove(x.selectedIndex);
}
else
alert("no hay opciones selecciondas");
}

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
  </script>
<script type="text/javascript">
       $(document).ready(function() {
	  
		   $('#id_nivel').change(function() {//inicio1
			 $.post('clientesecundario_select.php', {id_nivel_busca:document.formulario.id_nivel.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
			
			 }); 									 
		  });//fin1

		 		  
       });
	   

       $(document).ready(function() {
          //$('#feedback').load('usuario_nuevoCheck.php').show();
		  //$('#feedback2').load('usuario_nuevoCheck2.php').show();
		  
		   $('#id_nivel').change(function() {//inicio1
			 $.post('clientesecundario_existe.php', {id_nivel_busca:document.formulario.id_nivel.value}, 
			 function(result) {
				$('#feedback2').html(result).show();	
			
			 }); 									 
		  });//fin1

		 		  
       });	
	   
	     $(document).ready(function() {
	  
		   $('#id_nivel').change(function() {//inicio1
			 $.post('clientesecundario_consulta.php', {id_nivel_busca:document.formulario.id_nivel.value}, 
			 function(result) {
				$('#feedback3').html(result).show();	
			
			 }); 									 
		  });//fin1

		 		  
       });   
</script> 
<script>
        $(document).ready(function(){
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
</script>  
<script>
function eliminar(str1)
{
	 document.formulario_delete.id_eliminar.value = str1;
   
}
function eliminadato()
{
	document.formulario_delete.id_nivel_borrar.value=document.formulario.id_nivel.value;
	document.formulario_delete.bandera_acciones.value="oki";
    document.formulario_delete.submit(); 
   
}
</script>
  
<?PHP // cierre de sesion por medio del boton
	 $bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
       echo "document.location.href='sesion_destruida.php';";
	}//Fin if bandera ok
	 echo "</script>";
?>
<?PHP
	$bandera_eli = $_POST['bandera_acciones'];
	if($bandera_eli=="oki"){
	  $id_nivel=$_POST["id_nivel_borrar"];
	  $id_eliminar=$_POST['id_eliminar'];
	  $nombre_usuario=$_POST['nombre_usuario'];
	  $con_usuario=md5($_POST['con_usuario']);

	 $activo=1;
	 $empresa=$id_empresa;
	 $eliminar=1;
	 
//$usu_utilizado=mysql_query("SELECT * from tab_cliente where id_cliente='$id_eliminar' and id_empresa='$id_empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado=mysql_query("SELECT * from t_usuarios where id_usuario='$id_eliminar' and id_empresa='$id_empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']==0){ $lleno=0; }// no ha sido utilizado
		
if($usu_utilizado2['ocupado']==1) {$lleno=1 ;} //ya es ocupado
	 

	 
if ($lleno==0){
	
$resultado = eliminar_niveles("tab_detalle_cliente","id_cliente_secundario","id_cliente_principal",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar,$id_nivel);	
if($resultado==1){
	mysql_query("DELETE FROM tab_detalle_cliente WHERE id_cliente_secundario = '$id_eliminar' AND id_empresa='$empresa';") or die(mysql_error());
	
	$mensaje="1"; // Registro Eliminado
	
	$act223= ("UPDATE tab_cliente SET asignado=0 WHERE id_cliente='$id_eliminar' and id_empresa='$id_empresa'");
			 		 mysql_query($act223,$con);
	
	}else{
	$mensaje="2"; // No posee permisos	
		
		}
	}
if($lleno==1){
	$mensaje="3"; // ya esta siendo utilizdo
	
	}
	
}// fin de bandera

?>
<body class="container" >

<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->

<?PHP include("menu.php"); ?>


<!-----fin menu ---->
<!-----fin menu ---->
<!-----fin menu ---->
<!-----fin menu ---->




<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<!--   INICIO CUERPO   -->
<br><br><br><br>
<?PHP

// INICIA EL GUARDADO DE INFORMACION 
	$bandera = $_POST['bandera'];
	$servicios=$_POST["pasar_parametro"];
	$nivel1=$_POST["id_nivel"];
	//$empresa=$id_empresa;
	
if($pingresar==1){		 
    if($bandera=="ok")
   {//inicio if bandera ok
 
//PROCEDIMIENTO PARA ALMACENAR EN LA TABLA DETALLE SERVICIOS
	$string_to_array= split("/",$servicios);
	foreach ($string_to_array as $value):
           	 $value;
					
			//EXTRAER EL CODIGO DEL CLIENTE
			$result = mysql_query("SELECT * FROM tab_cliente WHERE nom_cliente ='".utf8_decode($value)."' and id_empresa='".$id_empresa."'");

		while($row = mysql_fetch_array($result)) {
    			 $guarda= $row['id_cliente'];
				 
				 $correo_utilizado=mysql_query("SELECT count(*) as existe from tab_detalle_cliente where id_cliente_secundario='$guarda' and id_cliente_principal='$nivel1'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$correo_utilizado2 = mysql_fetch_array($correo_utilizado);
if($correo_utilizado2['existe']!=0){ // no ha sido utilizado
//	$error=5; // Correo ya existe
  }else{ // Posse datos
  
				 
			mysql_query("insert into tab_detalle_cliente(id_cliente_principal, id_cliente_secundario, id_empresa) values('$nivel1', '$guarda', '$id_empresa')",$con);
			
			 $act22= ("UPDATE tab_cliente SET asignado=1 WHERE id_cliente='$guarda' and id_empresa='$id_empresa'");
			 		 mysql_query($act22,$con);
			 
}
		}
		
    endforeach;

					  if(mysql_error())
					  { 
						echo '<div class="alert alert-danger">
 						  <a href="f_permisos_cliente.php" class="alert-link"> Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
					  }
					  else
					 
			  
					 $act= ("UPDATE tab_cliente SET ocupado=1 WHERE id_cliente='$nivel1' and id_empresa='$id_empresa'");
	 				 mysql_query($act,$con);
						  echo '<div class="alert alert-success">
 						  <a href="f_permisos_cliente.php" class="alert-link">Datos almacenados con éxito !!! Haga click para continuar .....</a>
						  </div>';
   }
	
   }else{ // fin bandera ok
	   echo '<div class="alert alert-danger">
 						  <a href="f_permisos_cliente.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>'; //no tiene permiso de escritura
	   }//fin permiso	

// MENSAJES
if($mensaje==1){
	 echo '<div class="alert alert-success">
 						  <a href="f_permisos_cliente.php" class="alert-link"> Registro eliminado correctamente!!! Haga click para continuar</a>
						  </div>';
	}

if($mensaje==2){
echo '<div class="alert alert-danger">
 						  <a href="f_permisos_cliente.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje==3){
echo '<div class="alert alert-danger">
 						  <a href="f_permisos_cliente.php" class="alert-link"> El Nivel no se puede eliminar, ya se utilizó en el sistema!!! Haga click para continuar .....</a>
						  </div>';

}		   
	   
?>   
           <div class="container-fluid">
  <div class="row" >
  
 <div class="container-fluid">
  <div class="row" >
     <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Administración Clientes</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           <form role="form" id="loginForm" name="formulario"  method="post" action="f_permisos_cliente.php">
           <input type="hidden"  name="bandera" value="0">
           <input type="hidden"  name="busca">
           <input type="hidden"  name="pasar_parametro" value=""> 
                  
           <input type="hidden" name="cod_prod_eliminar"> 
           <input type="hidden" name="cod_prod_modif"> 
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">Cliente / Empresa</label>
                         <?php
						       $tabla=mysql_query("SELECT * FROM tab_cliente WHERE tipo_cliente='1' AND id_empresa='$id_empresa'");
						  ?>
                      <select name="id_nivel" class="form-control input-lg chosen" size="1" id="id_nivel"  >
                            <option value="0">Cliente / empresa</option>
							 <?php 
								while($valor=mysql_fetch_array($tabla)){
									$codigo_nivel= $valor['id_cliente'];
									$nombre_nivel= ($valor["nom_cliente"]);
									echo "<option value='$codigo_nivel'>";
									echo utf8_decode("$nombre_nivel");
									echo"</option>";
								}	
							?>
                          </select>
                              
                  </div>
              </div>
              
          </div><!--- FIN ROW-----> 
		 <br>	
      
          <div class="row"><!--- INICIO ROW----->
			<div class="col-md-6">
              <div class="form-group"> 
              <label for="nombre_servicio">Opciones</label> 
             <div id="feedback"><select size="5" name="lista" id="uno" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px; width:540px;height: 125px; background:#FFF;"><option value="0"> SELECCIONE  NIVEL</option></select>
                 </div>
                
               <button type="button" class="btn btn-toolbar btn-lg" onClick="agregar()"> Agregar </button>
            </div>
 	</div>
<div class="col-md-6">
   			<div class="form-group">  
            <label for="nombre_servicio"> Opciones seleccionadas </label> 
            <div id="feedback2"><select class="form-control input-lg" style="width:540px;height:125px" size="5" name="sel2" id="dos">
            </select>
			</div>

            <button type="button" class="btn btn-toolbar btn-lg" onClick="quitar()">  Quitar </button>


</div>
</div>
</div>
   <br>    
       
     	
          <table width="220" border="0" align="right">
              	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" onClick="cancelar()" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="submit" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right" disabled>  </button></td>
           	    </tr>
       	      </table> 	   
            
           </form> 
</div>
</div>
</div>



   <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>ELIMINAR CLIENTES</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
<div  id="feedback3">

</div>


           
          
</div>
</div>
</div>

</div>
</div>
</div>

<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->





<!--  INICIO FOOTER   -->
<?PHP include("footer.php");  ?>
<!-- FIN FOOTER  -->

</body> 
</html>

<!--------------------ELIMINAR REGISTRO-------------------->
<!-- INICIA ELIMINAR REGISTRO -->
<div class="modal fade" id="ventana4">
<form name="formulario_delete" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="id_eliminar" value="0">
<input type="hidden" name="id_nivel_borrar" value="0">
<input type="hidden" name="bandera_acciones" value="">
        <div class="modal-dialog">
          <div class="modal-content">                        
            <div class="modal-header">
               <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h3 class="modal-title">Borrar Registro</h3>
            </div>            
          <div class="modal-body"> 
          
            <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">USUARIO</label>
                       <input type="text" name="nombre_usuario" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" name="con_usuario" class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               	<button class="btn btn-primary" type="submit" onClick="eliminadato()">Eliminar Registro</button>
    </div>
    <div>               
    </form>
</div>


  <?php 
  mysql_close();
?>