<?php 
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
$bandera = $_POST['bandera'];

$tabla="SELECT *  FROM tab_cliente where id_cliente='$_POST[cod_prod_modif]' and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	$cod1=$row['id_cliente'];
	$nom1=$row['nom_cliente'];
	$dir1=$row['dir_cliente'];
	$tel1=$row['tel_cliente'];
	$ape_respon1=$row['ape_responsable'];
	$nom_respon1=$row['nom_responsable'];	
	$dir_respon1=$row['dir_responsable'];	
	$tel_respon1=$row['tel_responsable'];	
	$check=$row['tipo_cliente'];
	
}	
date_default_timezone_set("America/El_Salvador");
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");	
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
</head> 

<script  languaje="javascript" type="text/javascript" >
function activar_boton() //funcionar para activas las cajas de textos
  {
		
		if (document.formulario.activar.checked==false){
			document.formulario.btnguardar.disabled=true;
			}else{
				document.formulario.btnguardar.disabled=false;
				}
			
  }	

function cancelar(){
		document.location.href='f_cliente.php';	
	}
	
	function activar_textos() //funcionar para activas las cajas de textos
  {
		if(document.formulario.disabled=!document.formulario.disabled){
			document.getElementById('formulario_responsable').style.display = 'block';//Mostrar contenido
			document.formulario.ape_responsable.focus();
			return;
  		}else{
			document.getElementById('formulario_responsable').style.display = 'none';//oculta contenido
			return;
		}
  }	
  
  function mascara(t, mask){
 var i = t.value.length;
 var saida = mask.substring(1,0);
 var texto = mask.substring(i)
 if (texto.substring(0,1) != saida){
 t.value += texto.substring(0,1);
 }
 }
 
 function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }

</script>
<script>

function actualizar()
{
	document.formulario.bandera_acciones.value="ok";
    document.formulario.submit(); 
   
}

function indicadores() //funcionar para activas las cajas de textos
  {
		if (document.formulario.activar_indicadores.checked==true)
			document.formulario.activar_indi.value="1";
  }
  
</script>
<?php // cierre de sesion por medio del boton
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
	if($bandera_eli=="ok"){
	  $nombre_usuario=$_POST['nombre_usuario']; // CORREO
	  $con_usuario=md5($_POST['con_usuario']);
	  $activo="1";
	  $empresa=$id_empresa;
	  $modificar="1";
 	 $cod2= $_POST["id_cliente1"];
	 $_SESSION['codigo']=$cod2;

$resultado = autorizar_mod($nombre_usuario,$con_usuario,$activo,$empresa,$modificar);	
	
	if($resultado=="1"){
		$guarda="400"; // Guarda
	}else{
	$tabla="SELECT *  FROM tab_cliente where id_cliente='".$_SESSION['codigo']."' and id_empresa='$id_empresa'";
 $result = mysql_query($tabla);
$array = mysql_fetch_assoc($result);
{
	$cod1=$array['id_cliente'];
}
		$error="3"; // no posee permisos
		}
	}
	
?>
<body class="container" onLoad="document.formulario.nom_cliente.focus();"> 


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

           
<?php
// INICIA EL GUARDADO DE INFORMACION 
$bandera = $_POST['bandera'];
 		
	
if($guarda=="400") // incia la actualizaccón
   {//inicio if bandera ok
   	 $cod2=$_POST['id_cliente1'];
	 $nom2=strtoupper($_POST['nom_cliente1']);
	 $dir2=strtoupper($_POST['dir_cliente1']);
	 $tel2=$_POST['tel_cliente1'];
	 $ape_respon2=strtoupper($_POST['ape_responsable1']);
	 $nom_respon2=strtoupper($_POST['nom_responsable1']);	
	 $dir_respon2=strtoupper($_POST['dir_responsable1']);	
	 $tel_respon2=$_POST['tel_responsable1'];
	 $tipo_cliente2 = $_POST['tipo_cliente1'];	
	 $activar_indig=$_POST["activar_indi"];
	 
	 if($activar_indig!=1){
		   $activar_indig=0;
		   }
	 
	 $tabla5="SELECT *  FROM t_usuarios where correo_usuario='$nombre_usuario' and pass_usuario='$con_usuario' and id_empresa='$id_empresa'";
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_actualiza=$row5['id_usuario'];
}	
     
	if(isset($cod2)){
		$sql= ("UPDATE `tab_cliente` SET `nom_cliente`='$nom2',`dir_cliente`='$dir2', `tel_cliente`='$tel2', `ape_responsable`='$ape_respon2', `nom_responsable`='$nom_respon2', `dir_responsable`='$dir_respon2', `tel_responsable`='$tel_respon2', id_usuario_modifica='$usuario_actualiza', fecha_modifica='$fecha', hora_modifica='$hora', tipo_cliente='$tipo_cliente2', otros_indicadores='$activar_indig' WHERE id_cliente='$cod2'");
		mysql_query($sql,$con);


if($tipo_cliente2=="1"){
	mysql_query("insert into tab_detalle_cliente(id_cliente_principal, id_cliente_secundario, id_empresa) values('$cod2', '$cod2', '$id_empresa')",$con);  
	}
       }
   	   
				   
		 if(mysql_error())
		  { 
			$error="1";
		  }
			  else
			$error="2";
					  
		//	}
   }//fin bandera ok	
	
?>   
<?PHP 

 if($error == "1")
 {
	  echo '<div class="alert alert-success">
 			<a href="f_cliente.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == "2")
 {
	 unset($_SESSION['codigo']);
	 echo '<div class="alert alert-success">
 						  <a href="f_cliente.php" class="alert-link">Datos Actualizados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }

if($error == "3")
 {
	 echo '<div class="alert alert-danger">
 						  <a href="f_cliente.php" class="alert-link">No tiene permiso para modificar registro!!! Haga click para continuar .....</a>
						  </div>';
	  }	  
 
?>
           <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Modificar datos de productos</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form role="form" name="formulario"  method="post" action="f_mod_cliente.php">
           <input name="bandera" value="0" type="hidden" />     
	   	   <input type="hidden" name="bandera_acciones" value="">
           <input type="hidden" value="0" name="activar_indi"> 
           <div class="row"><!--- INICIO ROW----->
            
          <div class="col-md-12">
          <div class="form-group">
          		<label for="nombre_cliente">Código del Cliente</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $cod1; ?>"   name="id_cliente1" style="background:#FFF" readonly  id="id_cliente1" autocomplete="off">
            </div>
          </div>
          
          </div><!--- FIN ROW-----> 
           
             <div class="row"><!--- INICIO ROW----->
           <div class="col-md-12">
          <div class="form-group">
          		<label for="nombre_cliente">Nombre del Cliente ó empresa</label>
            	<input type="text" class="form-control input-lg" id="nom_cliente1" placeholder="Nombre del cliente" name="nom_cliente1" style="text-transform:uppercase;" value="<?PHP echo $nom1; ?>"  autocomplete="off" required>
            </div>
          </div>
          </div><!--- FIN ROW-----> 
          
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="direccion_comprador">Dirección del cliente ó empresa</label>
             <textarea name="dir_cliente1" style="text-transform:uppercase;"  class="form-control" rows="3" placeholder="Dirección del cliente" autocomplete="off" id="dir_cliente1" required><?PHP echo $dir1; ?> </textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
          <div class="form-group">
             <label for="direccion_comprador">Teléfono del cliente ó empresa</label>
             <input type="text" class="form-control input-lg soloNUMEROS" value="<?PHP echo $tel1; ?>" id="tel_cliente1" placeholder="Telefono del cliente"  name="tel_cliente1" onkeypress="mascara(this, '####-####')" maxlength="9" autocomplete="off" required>
          </div>
          </div>
          
           <div class="col-md-4">
                        <div class="form-group">
                          <label for="nacional">Cliente / Empresa</label><br>
                          
                          <label class="checkbox-inline">
                            <input type="radio" id="tipo_cliente1" value="1" name="tipo_cliente1"  <?php if($check=="1") print "checked=true"?> >  Principal
                          </label>
                          <label class="checkbox-inline">
                          
                           <input type="radio" id="tipo_cliente1" value="2" name="tipo_cliente1"  <?php if($check=="2") print "checked=true"?> >  Secundaria 
                          </label>
                          
                        </div>  

                    </div>
          
           <div class="col-md-4">
           <div class="form-group">
           <label for="nombre_producto">Otros indicadores?</label>
           <div class="checkbox-inline">
              <label>
                <input type="checkbox" name="activar_indicadores" value="0" onclick="indicadores()">Activar </label>
          </div>
         </div>
         </div>
          
          
          </div><!--- FIN ROW----->
          <div class="checkbox">
              <label>
                <input type="checkbox" value="" onclick="activar_textos()">Desea Modificar los datos del Encargado de la empresa
              </label>
          </div>
          <div  style='display:none;' id="formulario_responsable">
     	<div class="row" >
  		   <div class="col-md-12">
        		
           			 <div class="panel-heading bg-info"><strong>Datos del Encargado de la empresa</strong></div> <!-- PANEL 1 --->  
           				<div class="panel-body" >
           				    <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-6">
                              <div class="form-group">
                                    <label for="origen_servicio">Apellidos del Encargado</label>
                                    <input type="text" class="form-control input-lg" id="ape_responsable1" placeholder="Apellidos del Encargado"  name="ape_responsable1" value="<?PHP echo $ape_respon1; ?>"  autocomplete="off" style="text-transform:uppercase;" >
                              </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                    <label for="origen_servicio">Nombre del Encargado</label>
                                    <input type="text" class="form-control input-lg" id="nom_responsable1" placeholder="Nombre del Encargado"  name="nom_responsable1" value="<?PHP echo $nom_respon1; ?>"  autocomplete="off" style="text-transform:uppercase;" >
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
                          <div class="row"><!--- INICIO ROW----->
                          <div class="col-md-12">
                          <div class="form-group">
                             <label for="direccion_comprador">Dirección del encargado de la Empresa</label>
                             <textarea name="dir_responsable1" class="form-control" rows="3" placeholder="Dirección del Encargado" autocomplete="off" id="dir_responsable1" style="text-transform:uppercase;" > <?PHP echo $dir_respon1; ?> </textarea>
                          </div>
                          </div>
                          </div><!--- FIN ROW----->
                          <div class="row"><!--- INICIO ROW----->
                          <div class="col-md-4">
                          <div class="form-group">
                             <label for="direccion_comprador">Teléfono del encargado</label>
                             <input type="text" class="form-control input-lg soloNUMEROS" id="tel_responsable1" placeholder="Telefono del encargado"  name="tel_responsable1" onkeypress="mascara(this, '####-####')" maxlength="9" value="<?PHP echo $tel_respon1; ?>"  autocomplete="off" >
                          </div>
                          </div>
                          </div><!--- FIN ROW----->
                                          
                       </div>
                     </div>
            </div>
          </div>
                   
         <div class="checkbox">
              <label><input type="checkbox" name="activar" onclick="activar_boton()">Realizar modificación? </label>
          </div>
                      
 	  <table width="220" border="0" align="right">
              	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" onClick="cancelar()" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="button" disabled name="btnguardar" data-toggle="modal" data-target="#ventana4" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
              	    </tr>
           	      </table> 
 <!-- SOLICITA PERMISO PARA ACTUALIZAR -->


</div>
</div><!-- Fin de formularios  Inicia la paginacion-->

<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->


<!--  INICIO FOOTER   -->

<?PHP include("footer.php"); ?>

<!-- FIN FOOTER  -->
<div class="modal fade" id="ventana4">
        <div class="modal-dialog">
          <div class="modal-content">                        
            <div class="modal-header">
               <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h3 class="modal-title">Modificar Registro</h3>
            </div>            
          <div class="modal-body"> 
          
            <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">USUARIO</label>
                       <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" id="con_usuario" name="con_usuario"  class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
            <div class="modal-footer">
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               	<button class="btn btn-primary" type="submit" onClick="actualizar()">Actualizar Registro</button>
            </div>    
    </div>
    <div>               
  </div>                  
           </form> 
</body> 
</html>
<?PHP
mysql_close($con);
?>