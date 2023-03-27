<?php 
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

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

$loginSQL=mysql_query("select token, nombre_usuario from t_usuarios  where id_usuario='$id_usuario'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$fila_usu['token'];
$nombre_usuario=$fila_usu['nombre_usuario'];
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
$fecha=date('d').'/'.date('m').'/'.date('Y');
	
?>
<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../css/datepicker.css">
<script src="../js/bootstrap.min.js"></script>
<script src="../js/bootstrap-datepicker.js"></script> 
<script src="../assets/javascript/chosen.jquery.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
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
function ver(){
	  $.post('consultar_estado_cuenta.php', {fec_inicio_busca:document.formulario.fec_inicio.value, fec_fin_busca:document.formulario.fec_fin.value}, 
			 function(result) {
				$('#feedback_consulta').html(result).show();	
		  });//fin1
		 		  
	}
	
        $(document).ready(function(){
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
</script>
<script>
 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers"
	 });
});

</script>

<script type="text/javascript">
function cancelar(){
	document.formulario.btnguardar.disabled=false;
	}

function cerrar_ventana(){
	document.formulario.action="f_ingresosegresos.php";
    document.formulario.submit();  
	}	

function consultar(){
			//document.consulta.cod_producto.value=document.formulario.id_producto.value;
			$('$ventana4').modal('show');
		
}// fin guardar

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
  
</script>

<?php // cierre de sesion por medio del boton
	 $bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
       echo "document.location.href='destruir_sesion.php';";
	}//Fin if bandera ok
	 echo "</script>";
?>
 		
 

<body class="container" <?PHP if($guarda == 2) echo "onload='datos()';"; ?> > 


<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<?PHP include('menu.php');?>

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
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>INGRESO - EGRESO POR FECHA </strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
          		<form action="f_ingresosegresos.php" class="formusu" method="post" name="formulario" role="form">  
                <input name="bandera" value="0" type="hidden" />                                          
             <div class="row"><!--- INICIO ROW----->
             <div class="col-md-6">
             <div class="form-group">
               <label>FECHA INICIO</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_inicio" placeholder="Fecha" name="fec_inicio" value="<?PHP echo $fecha;?>" readonly style="background:#FFF;">
              </div>
                         
                  </div>
           
           
				 <div class="col-md-6">
              <div class="form-group">
               <label>FECHA FIN</label>
                <input type="text" class="form-control input-lg datepicker" id="fec_fin" placeholder="Fecha" name="fec_fin" value="<?PHP echo $fecha;?>" readonly style="background:#FFF;">
              </div>
              </div>      
            </div> <!-- fin -->
               
 <br />
 
			   <table width="220" border="0" align="right">
                  
                  
				   	    <tr>

              	      <td><button type="button" name="btnguardar" value="Consultar" class="btn btn-info btn-lg pull-right" data-toggle="modal" data-target="#ventana4" onClick="consultar()" > Consultar </button></td>
              	    </tr>
           	      </table> 
              
		</form>	

</div>
</div>
</div>


                

<br>
<br>
<br>
<!--  INICIO FOOTER   -->

<?PHP include('footer.php');?>
<!-- FIN FOOTER  -->

</body>
</html>
<!-- VENTANA MODAL -->
<div class="modal fade" id="ventana4">
<form name="consulta" >
    <div class="modal-dialog" style="height: 70vh;
    width: 83vw;">
          <div class="modal-content">                        
            <div class="modal-header">
            <input type="text" id="ventana" readonly onClick="ver()" name="ventana" class="form-control input-lg"  autocomplete="off" value=" INGRESO EGRESO (Clic para actualizar) " style="background:#FFF;">
            </div>            
          <div id="feedback_consulta" class="modal-body" > </div>
		<br>
        		<div class="modal-footer">
         	<button class="btn btn-danger" onClick="cerrar_ventana()" data-dismiss="modal">Cerrar</button>
	    </div>
    </div>
    <div>               
    </form>
    
    
<?PHP
  mysql_close();
?>