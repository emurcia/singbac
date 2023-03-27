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
 
date_default_timezone_set("America/El_Salvador");
$ano=date('Y');
$fecha=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");

if($id_producto==""){
	$id_producto1="";
	$nom_producto1="SELECCIONE PRODUCTO";
	}
?>

<!DOCTYPE html> 
<html> 
<head ><meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title><?PHP echo $nom_sistema; ?></title> 
 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script> 

<!--script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script-->
<script src="../assets/javascript/chosen.jquery.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css"> 

<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../css/datepicker.css">
<link rel="stylesheet" type="text/css" href="../menu/styles.css">

<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
<link href="../images/favicon.ico" rel="icon">
</head> 
<script>
$(function (){
	$('.datepicker').datepicker({
		format: 'dd-mm-yyyy', viewMode: 0  //0: dias, 1: meses, 2:años
	})
				.on('changeDate', function(ev){
					
					$('.datepicker').datepicker('hide');
				});
});

</script>

<script>
$(document).ready(function() {
$('#id_cliente2').change(function() {//inicio1
			 $.post('producto_buscar.php', {id_cliente_busca:document.formulario.id_cliente2.value}, 
			 function(result) {
				$('#feedback').html(result).show();
					 });
})
})
</script>                
<script type="text/javascript">

function consultar(){
			document.consulta.cod_producto.value=document.formulario.id_producto.value;
			$('$ventana4').modal('show');
		
}// fin guardar
function ver(){
	  $.post('consultar_producto_cliente.php', {id_cliente_busca:document.formulario.id_cliente2.value, id_producto_busca:document.formulario.id_producto.value, fecha_inicio11:document.formulario.fec_inicio.value, fecha_fin11:document.formulario.fec_fin.value}, 
			 function(result) {
				$('#feedback_consulta').html(result).show();	
		  });//fin1
		 		  
	}

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
  
</script>

<script>
        $(document).ready(function(){
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
</script>
  
<?php
	$bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
	   echo "document.location.href='sesion_destruida.php';";
     }//Fin if bandera ok
	 echo "</script>";
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



  <div class="container-fluid">
  <div class="row">
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>SERVICIO DE BASCULA DE CLIENTES POR PRODUCTOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
            <form action="f_rep_bascula_producto_cliente.php" method="post" name="formulario" role="form" >  
            <input name="bandera" value="0" type="hidden" />     
	        <input type="hidden"  name="busca">
	        <input type="hidden"  name="seleccion">
            <input type="hidden"  name="cod_producto">           
            <input type="hidden" name="fecha_inicio11">
            <input type="hidden" name="fecha_fin11">  
 			<input type="hidden"  name="reporte" value="<?PHP echo $_POST['id_cliente2']; ?>">
            <input type="hidden"  name="cod_producto2" value="<?PHP echo $_POST['id_producto']; ?>">
            <input type="hidden"  name="fec1" value="<?PHP echo $_POST['fec_inicio']; ?>">           
            <input type="hidden"  name="fec2" value="<?PHP echo $_POST['fec_fin']; ?>"> 
 
          
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>NOMBRE CLIENTE</label>
              <?php
			  $bas="BASC-00000001";
                	$tabla=mysql_query("SELECT a.id_cliente, a.nom_cliente, b.id_bascula FROM tab_cliente as a, tab_bascula as b WHERE a.id_cliente=b.id_cliente AND b.id_bascula!='$bas' GROUP by b.id_cliente",$con); //
				?>
                      <select name="id_cliente2" class="form-control input-lg chosen" size="1" id="id_cliente2">
                            <option value="TODOS">SELECCIONE CLIENTE</option>
							 <?php 
								while($valor=mysql_fetch_array($tabla)){
									
									$codigo_usu= $valor['id_cliente'];
									$nombre_usu= $valor['nom_cliente'];
									echo "<option value='$codigo_usu'>";
									echo ($nombre_usu);
									echo"</option>";  

								}	
							?>
                          </select>
                              
                  </div>
              </div>
 
         
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">PRODUCTO</label>
                <div id="feedback"><select class="chosen" name="id_producto" id="id_producto" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="<?php echo $id_producto1; ?>"><?PHP echo $nom_producto1; ?></option></select></div>
                  </div>
              </div>
 
            </div> <!-- fin -->
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>FECHA INICIO</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_inicio" placeholder="Fecha" name="fec_inicio" value="<?PHP echo $fecha; ?>" readonly style="background:#FFF;">
              </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label>FECHA FIN</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_fin" placeholder="Fecha" name="fec_fin" value="<?PHP echo $fecha; ?>" readonly style="background:#FFF;">
              </div>
              </div>
            </div><!--- FIN ROW-----> 
 
 <br />
 
			   <table width="220" border="0" align="right">
              	    <tr>

              	      <td><button type="button" name="btnguardar" value="Consultar" class="btn btn-info btn-lg pull-right" data-toggle="modal" data-target="#ventana4" onClick="consultar()" > Consultar </button></td>
                       
              	    </tr>
           	      </table> 
              
		</form>	
</div>

</div></div>
</div></div>
<br>
<br>
<br>
<!--  INICIO FOOTER   -->

<?PHP include("footer.php"); ?>

<!-- FIN FOOTER  -->

</body>
</html>


<!-- Inicia paginacion para mostrar los usuarios -->

<div class="modal fade" id="ventana4">
<form name="consulta">
    <div class="modal-dialog" style="height: 70vh;
    width: 83vw;">
          <div class="modal-content">                        
            <div class="modal-header">
            <input type="text" id="id_cliente2" readonly onClick="ver()" name="id_cliente2" class="form-control input-lg"  autocomplete="off" value="Haga Clic para refrescar la consulta !!!!" style="background:#FFF;">
            </div>            
          <div id="feedback_consulta" class="modal-body" > </div>
		<br>
		<div class="modal-footer">
         	<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	    </div>
    </div>
    <div>               
    </form>
    

<?PHP
  mysql_close();
?>
