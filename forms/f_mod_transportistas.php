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
 
?>
<?PHP
$tabla="SELECT *  FROM tab_transportista where id_transportista='$_POST[cod_prod_modif]' and id_empresa='$id_empresa'";
$select = mysql_query($tabla);
while($row = mysql_fetch_array($select ))
{
		 $id1= $row['id_transportista'];
		 $dpi1=$row['dpi_transportista'];
	  	 $ape1  = $row['ape_transportista'];
	     $nom1  = $row['nom_transportista'];		 
	     $dir1 = $row['dir_transportista'];
	     $tel1 = $row['tel_transportista'];
		 $placa1=$row['placa_vehiculo'];
		 $color1=$row['color_vehiculo'];
		 $cap1=$row['cap_vehiculo'];		 
		 $obs1=$row['obs_vehiculo'];	
		 $id_cliente1=$row['id_cliente'];	
}	
$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_cliente1' and id_empresa='$id_empresa'";
  $select2 = mysql_query($tabla2);
	while($row2 = mysql_fetch_array($select2)){
	$nom_cliente1=$row2['nom_cliente'];
}
date_default_timezone_set("America/El_Salvador");
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");
	
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=width-device, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
</head> 

<script  languaje="javascript" type="text/javascript" >
    $(document).ready(function() {
    $('.soloLetras').keypress(function(tecla) {
                if((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && tecla.keyCode !=08 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32) return false;
            });

     $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=09 && tecla.charCode !=127 && tecla.charCode !=46 && tecla.charCode !=0 ) return false;
            });
        });
	
function activar_boton() //funcionar para activas las cajas de textos
  {	
		if (document.formulario1.activar.checked==false){
			document.formulario1.btnguardar.disabled=true;
			}else{
				document.formulario1.btnguardar.disabled=false;
			}
			
  }

function cancelar(){
		document.location.href='f_transportistas.php';	
	}
	
function activar_textos() //funcionar para activas las cajas de textos
  {
		if(document.formulario1.disabled=!document.formulario1.disabled){
			document.getElementById('formulario1_responsable').style.display = 'block';//Mostrar contenido
			document.formulario1.ape_responsable.focus();
			return;
  		}else{
			document.getElementById('formulario1_responsable').style.display = 'none';//oculta contenido
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
    document.formulario1.bandera.value="oki";
    document.formulario1.submit();       
 }

</script>
<script>
function actualizar()
{
	document.formulario1.bandera_acciones.value="ok";
    document.formulario1.submit(); 
   
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
	$tabla="SELECT *  FROM tab_transportista where id_transportista='".$_SESSION['codigo']."' and id_empresa='$id_empresa'";
 $result = mysql_query($tabla);
$array = mysql_fetch_assoc($result);
{
	$cod1=$array['id_transpostista'];
}
		$error="3"; // no posee permisos
		}
	}
	
?>
<body class="container"> 


<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->

<nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

 
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
   
   <!-- menu -->
      <ul id="menu-bar">
     <?PHP
      $indicadorul = 0;
      $indicadorli = 1;
     // $consulta = mysql_query("SELECT * FROM tab_menu",$con);
	 $consulta = mysql_query("SELECT a.opcion_menu, a.url_menu, a.acceso_menu, a.nivel_menu FROM tab_menu as a, tab_detalle_menu as b, t_empresa as c WHERE a.id_menu=b.id_menu and b.id_nivel='".$acceso."' and b.id_empresa='$id_empresa' and c.estado='$estado' GROUP by a.id_menu ",$con);
      while($fila = mysql_fetch_array($consulta)){
          if((($fila['acceso_menu']==0) || ($fila['acceso_menu']==$acceso)) && (!empty($acceso))){
              if(($fila['nivel_menu']==2) && ($indicadorul==0)){  echo "<ul class='dropdown-menu'>"; $indicadorul=1; }
              if(($fila['nivel_menu']==1) && ($indicadorul==1)){  echo "</ul>"; $indicadorul=0; }
              
              if(($fila['nivel_menu']==1) && ($indicadorli == 0)){echo "</li>";$indicadorli=1;}
               
              if($fila['id_menu']==1)//Menu de inicio(index.php) debe de ir sin 'forms/'
                  echo "<li><div align='left'><a  href='../".utf8_encode($fila['url_menu'])."'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
              else{
                  if($fila['nivel_menu']==2)
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
                  else{
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a>";
                      $indicadorli = 0;
                  }			  
              }
          }
      }
	  
	  
      echo "</li>";
		  
     ?>

      <li><a><?PHP echo $_SESSION['nombre_usuario_silo']; ?></a></li>
      <li><a onClick="salirr()"><button type="button" class="btn btn-danger btn-xs">Cerrar Sesión</button></a></li>
          
</ul>
    </div>
    
</nav>
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
 		
if($guarda=="400")
   {//inicio if bandera ok
 		 $id2= strtoupper($_POST["id_transportista"]);
		 $dpi2=$_POST["dpi_transportista"];
	      $ape2  = strtoupper($_POST["ape_transportista"]);
	     $nom2  = strtoupper($_POST["nom_transportista"]);		 
	     $dir2 = strtoupper($_POST["dir_transportista"]);
	     $tel2 = ($_POST["tel_transportista"]);
		 $placa2=strtoupper($_POST["placa_vehiculo"]);
		 $color2=strtoupper($_POST["color_vehiculo"]);
		 $cap2=($_POST["capacidad_vehiculo"]);		 
		 $obs2=strtoupper($_POST["obs_vehiculo"]);	
		 $id_cliente2=$_POST["nom_cliente"];	
		 
$tabla5="SELECT *  FROM t_usuarios where correo_usuario='$nombre_usuario' and pass_usuario='$con_usuario' and id_empresa='$id_empresa'";
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_actualiza=$row5['id_usuario'];
}			 
		  	 
	 	
      if(isset($id2)){
		$sql= ("UPDATE `tab_transportista` SET `dpi_transportista`='$dpi2', `ape_transportista`='$ape2', `nom_transportista`='$nom2', `dir_transportista`='$dir2', `tel_transportista`='$tel2', `placa_vehiculo`='$placa2', `color_vehiculo`='$color2', `cap_vehiculo`='$cap2', `obs_vehiculo`='$obs2', id_usuario_modifica='$usuario_actualiza', fecha_modifica='$fecha', hora_modifica='$hora' WHERE id_transportista='$id2' and id_empresa='$id_empresa'");
		mysql_query($sql,$con);
	  }
if(mysql_error())
		  { 
			$error="1";
		  }
			  else
			$error="2";
	}//fin bandera ok	
	
?>   
<?PHP 

 if($error == "1")
 {
	  echo '<div class="alert alert-success">
 			<a href="f_transportistas.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == "2")
 {
	 unset($_SESSION['codigo']);
	 echo '<div class="alert alert-success">
 						  <a href="f_transportistas.php" class="alert-link">Datos Actualizados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }

if($error == "3")
 {
	 echo '<div class="alert alert-danger">
 						  <a href="f_transportistas.php" class="alert-link">No tiene permiso para modificar registro!!! Haga click para continuar .....</a>
						  </div>';
	  }	  
 ?>

            <!-- Formulario para ingresar servicios que ofrece -->
			
  					<div class="row" >
  		   				<div class="col-md-13">
        					<div class="panel panel-primary">
           						<div class="panel-heading"><strong>Registro de Pilotos</strong>				</div> <!-- PANEL 1 --->
           						<div class="panel-body" >
    	   <form role="form" name="formulario1"  method="post" action="f_mod_transportistas.php">
           <input type="hidden"  name="bandera" value="0">
	   	   <input type="hidden" name="bandera_acciones" value="">
              <div class="row"><!--- INICIO ROW----->
            
          <div class="col-md-12">
          <div class="form-group">
          		<label for="nombre_producto">Código del Transportista</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $id1; ?>"  style="background:#FFF" readonly  name="id_transportista" id="id_transportista" autocomplete="off">
            </div>
          </div>
         
          </div><!--- FIN ROW-----> 
           <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
         	<div class="form-group">
          		<label for="ape_transportista">Cliente</label>
          		<input type="text" class="form-control input-lg" style="background:#FFF" readonly id="nom_cliente" placeholder="Nombre del cliente"   name="nom_cliente" autocomplete="off" value="<?PHP echo $nom_cliente1; ?>"   >
           </div>
          </div>
		</div>	<!--- FIN ROW-----> 
        
          <div class="panel-heading bg-info"><strong>Datos Motorista</strong></div> <!-- PANEL 1 ---> 
        
        <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         	<div class="form-group">
          		<label for="id_transportista">DPI</label>
          		<input type="text" class="form-control input-lg soloNUMEROS" id="dpi_transportista" onkeypress="mascara(this, '#### ##### ####')" maxlength="15" placeholder="Identificador del Motorista" style="text-transform:uppercase;"  name="dpi_transportista" autocomplete="off" value="<?PHP echo $dpi1; ?>" required>
           </div>
          </div>
          <div class="col-md-4">
         	<div class="form-group">
          		<label for="ape_transportista">Apellidos</label>
          		<input type="text" class="form-control input-lg" style="text-transform:uppercase;" id="ape_transportista" placeholder="Apellidos del Motorista"   name="ape_transportista" autocomplete="off" required value="<?PHP echo $ape1; ?>" >
           </div>
          </div>
         <div class="col-md-4">
         	<div class="form-group">
          		<label for="nom_transportista">Nombres</label>
          		<input type="text" class="form-control input-lg" style="text-transform:uppercase;"id="nom_transportista" placeholder="Nombres del Motorista"   name="nom_transportista" autocomplete="off" required value="<?PHP echo $nom1;?>">
           </div>
          </div> 
        </div><!--- FIN ROW-----> 
          
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="direccion_comprador">Dirección de residencia</label>
             <textarea name="dir_transportista" class="form-control" rows="3" style="text-transform:uppercase;" placeholder="Dirección del Motorista" autocomplete="off" id="dir_transportista" required><?PHP echo $dir1; ?></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
          <div class="form-group">
             <label for="direccion_comprador">Teléfono</label>
             <input type="text" class="form-control input-lg soloNUMEROS" id="tel_transportista" placeholder="Teléfono del Motorista"  name="tel_transportista" onkeypress="mascara(this, '####-####')" maxlength="9" style="text-transform:uppercase;" autocomplete="off" required value="<?PHP echo $tel1; ?>">
          </div>
          </div>
          </div><!--- FIN ROW----->
                 
          <div class="checkbox">
              <label>
                <input type="checkbox" value="" onclick="activar_textos()">Desea Modificar datos del Vehículo? </label>
          </div>
          
                         
          <div  style='display:none;' id="formulario1_responsable">
     	<div class="row" >
  		   <div class="col-md-12">
        		
           			 <div class="panel-heading bg-info"><strong>Datos del Vehiculo</strong></div> <!-- PANEL 1 --->  
           				<div class="panel-body" >
           				   <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         	<div class="form-group">
          		<label for="id_placa">Placa</label>
          		<input type="text" class="form-control input-lg" id="placa_vehiculo" style="text-transform:uppercase;" placeholder="Placa del vehiculo"   name="placa_vehiculo" autocomplete="off" value="<?PHP echo $placa1; ?>">
           </div>
          </div>
          <div class="col-md-4">
         	<div class="form-group">
          		<label for="color">Color</label>
          		<input type="text" class="form-control input-lg" id="color_vehiculo" style="text-transform:uppercase;" placeholder="Color del Vehiculo"   name="color_vehiculo" autocomplete="off" value="<?PHP echo $color1; ?>">
           </div>
          </div>
          
             
              <div class="form-group">
              <label>Capacidad</label>
             
             
           <div class="col-md-4">
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="capacidad_vehiculo" placeholder="Capacidad del vehiculo"   name="capacidad_vehiculo" autocomplete="off" value="<?PHP echo $cap1; ?>">
              <span class="input-group-addon">Toneladas</span>
              </div>
              </div>
       </div>
        </div>
         
        </div><!--- FIN ROW-----> 
          
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="obs_vehiculo">Observaciones</label>
             <textarea name="obs_vehiculo" class="form-control" rows="3" style="text-transform:uppercase;" placeholder="Observaciones del vehiculo" autocomplete="off" id="obs_vehiculo"><?PHP echo $obs1 ?> </textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
   
         </div>
          </div>
          </div>

           <div class="checkbox">
              <label>
                <input type="checkbox" name="activar" onclick="activar_boton()">Realizar modificación? </label>
          </div>
 <table width="220" border="0" align="right">
              	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" onClick="cancelar()" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="button" disabled name="btnguardar" data-toggle="modal" data-target="#ventana4" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
              	    </tr>
           	      </table> 
       
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
<!-- SOLICITA PERMISO PARA ACTUALIZAR -->

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
