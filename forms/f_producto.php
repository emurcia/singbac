﻿<?php 
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
 $id_usuario= $_SESSION['id_usuario_silo']; // id_usuario en bd
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
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora_entrada=date("H:i:s"); 
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
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
</head> 
<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    	"sPaginationType": "full_numbers",
		"sScrollX": "100%"
	 });
    }); 

function guardar(){
		document.formulario.bandera.value='ok';
		document.formulario.submit();
}// fin guardar

function activa_guardar(){
		document.formulario.btnguardar.disabled=false;
	}

function cancelar(){
		document.formulario.btnguardar.disabled=true;
		document.formulario.nom_producto.focus();
	}	

function enviar(cod){
		document.formulario.busca.value="actualizarproducto";	
		document.formulario.codigo_modificar.value=cod;
		document.formulario.action='f_mod_producto.php';//redireccionar a musuario.php
		document.formulario.submit();
	}

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }	
 
</script>
<script>
function eliminar(str1)
{
	 document.formulario_delete.id_eliminar.value = str1;
   
}
function elimina()
{
	document.formulario_delete.bandera_acciones.value="oki";
    document.formulario_delete.submit(); 
   
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
	if($bandera_eli=="oki"){
	
	  $id_eliminar=$_POST['id_eliminar'];
	  $nombre_usuario=$_POST['nombre_usuario'];
	  $con_usuario=md5($_POST['con_usuario']);

	 $activo="1";
	 $empresa=$id_empresa;
	 $eliminar="1";
	 
$prod_utilizado=mysql_query("SELECT * from tab_producto where id_producto='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI YA TIENE DATOS
$prod_utilizado2 = mysql_fetch_array($prod_utilizado);
if($prod_utilizado2['ocupado']=="0"){ // no ha sido utilizado
		$lleno="0";
  }else{ // Posse datos
  	 	$lleno="1";
  }	 
	 
	 
if ($lleno=="0"){
$resultado = eliminar_su("tab_producto","id_producto",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
if($resultado=="1"){
	$mensaje="1"; // Registro Eliminado
	
	}else{
	$mensaje="2"; // No posee permisos	
		}
	}
if($lleno=="1"){
	$mensaje="3";
	}
}// fin de bandera

?>
<body class="container" onLoad="document.formulario.nom_producto.focus();"> 


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
$Result1 = mysql_query("SELECT MAX(id_producto) as a  FROM tab_producto ORDER BY id_producto and id_empresa='$id_empresa'") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],5,3);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "PROD-00".$num.$id_empresa;
	}else{
		if ($a1<99){
			$num = "$a1"+"1";
			$nu= "PROD-0".$num.$id_empresa;
		}else{
			 if($a1<999){
				$num = "$a1"+"1";
				$nu= "PROD-".$num.$id_empresa;
				}
			}
	}
				
// INICIA EL GUARDADO DE INFORMACION 
		$bandera = $_POST['bandera'];
		$humedad = $_POST['humedad'];
 		$id_nuevo = strtoupper($_POST["id_producto"]);
	    $nombre  = strtoupper($_POST["nom_producto"]);
	    $nombre_productor  = strtoupper($_POST["nom_productor"]);		
	    $descripcion = strtoupper($_POST["desc_producto"]);

if($pingresar=="1"){	
 if($bandera=="ok")
   {//inicio if bandera ok
    $mensajeerror = "";
     $correo_utilizado=mysql_query("SELECT count(*) as existe from tab_producto where nom_producto='$nombre' and id_empresa='$id_empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$correo_utilizado2 = mysql_fetch_array($correo_utilizado);
if($correo_utilizado2['existe']!=0){ // no ha sido utilizado
	$error=5; // Correo ya existe
  }else{ // Posse datos

			mysql_query("insert into tab_producto(id_producto, nom_producto, nom_productor, desc_producto, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica, humedad) values
('$id_nuevo', '$nombre', '$nombre_productor', '$descripcion', '$id_empresa', '$id_usuario',0, '$fecha_entrada', '$hora_entrada','$id_usuario','$fecha_entrada','$hora_entrada','$humedad')",$con);     
				   
			if(mysql_error())
		  { 
			$error="1"; // error en datos
			$mensajeerror = mysql_error();
		  }
			  else
		     $error="2"; // datos almacenados
					  
	}
	
   }
}else{ // fin bandera ok
	   $error="4"; //no tiene permiso de escritura
	   }//fin permiso	
	
?>   

<?PHP 

 if($error == "1")
 {
	  echo '<div class="alert alert-success">
 			<a href="f_usuarios.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a><br>'.$mensajeerror.'
						  </div>';
	
 }
 
 if($error == "2")
 {
	 
	 echo '<div class="alert alert-success">
 						  <a href="f_producto.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }
	  
if($mensaje=="1"){
echo '<div class="alert alert-success">
 						  <a href="f_producto.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje=="2"){
echo '<div class="alert alert-danger">
 						  <a href="f_producto.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje=="3"){
echo '<div class="alert alert-danger">
 						  <a href="f_producto.php" class="alert-link"> El Usuario no se puede eliminar, ya realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
if($error=="4"){
echo '<div class="alert alert-danger">
 						  <a href="f_producto.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';
}
if($error=="5"){
echo '<div class="alert alert-danger">
 						  <a href="f_producto.php" class="alert-link"> Producto ya existe!!!</a>
						  </div>';
}
?>
<div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Registro de productos</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           	<form role="form" name="formulario"  method="post" action="f_producto.php">
           	<input type="hidden"  name="bandera" value="0">
           	<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="codigo_modificar"> 
             
           <div class="row"><!--- INICIO ROW----->
            <div class="col-md-12">
          <div class="form-group">
          		<label for="nombre_producto">Código del Producto</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $nu; ?>"   name="id_producto" id="id_producto" autocomplete="off" style="background:#FFF" readonly>
            </div>
          </div>
          
          </div><!--- FIN ROW-----> 
          
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
          		<label for="nombre_producto">Nombre del Producto</label>
            	<input type="text" class="form-control input-lg" id="nom_producto" style="text-transform:uppercase;" placeholder="Nombre del Producto"  name="nom_producto" autocomplete="off" required>	
            </div>
          </div>
          </div><!--- FIN ROW-----> 
    <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
          		<label for="nombre_productor">Nombre del Productor</label>
            	<input type="text" class="form-control input-lg" id="nom_productor" style="text-transform:uppercase;" placeholder="Nombre del Productor"  name="nom_productor" autocomplete="off" required>	
            </div>
          </div>
          </div><!--- FIN ROW----->           
           <div class="row"><!-- INICIO ROW-->
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="nacional"> Aplica Humedad?</label><br>
                          
                          <label class="checkbox-inline">
                            <input type="radio" id="humedad" value="1" name="humedad" onClick="activa_guardar()">  Si
                          </label>
                          <label class="checkbox-inline">
                          
                            <input type="radio" id="humedad"  value="0" name="humedad" onClick="activa_guardar()">  No
                          </label>
                          
                        </div>  
                      
                    </div>
                  </div> <!-- FIN -->
          
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="direccion_comprador">Descripción</label>
                        <textarea name="desc_producto" class="form-control" style="text-transform:uppercase;" rows="3" placeholder="Descripción del Producto" autocomplete="off" id="desc_producto"></textarea>
          </div>
          </div>
          
          </div><!--- FIN ROW----->
                   
           
                      

              	  <table width="220" border="0" align="right">
              	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" class="btn btn-danger btn-lg pull-right" onClick="cancelar()"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="submit" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right" disabled>  </button></td>
              	    </tr>
           	      </table> 
          </form> 
          
</div>
</div>
</div> <!-- Fin de formularios  Inicia la paginacion-->


   <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>PRODUCTOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
<div>
<?php
	/*echo"<script>alert('llega al php');</script>";*/ 	 
	$nivel_busca="";
	$usuario_busca="";
	$id_prod="PROD-000".$id_empresa;
	 $sql = "SELECT p.id_producto, p.nom_producto, p.nom_productor, p.desc_producto, p.humedad, p.fecha_usuario, p.hora_usuario, p.id_usuario_modifica, p.fecha_modifica, p.hora_modifica, u.nombre_usuario  FROM tab_producto as p, t_usuarios as u WHERE p.id_usuario2=u.id_usuario and p.id_producto!='$id_prod' and p.id_empresa='$id_empresa' ORDER BY p.fecha_usuario desc, p.hora_usuario desc";
 	 $result = mysql_query($sql,$con);
	  echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='250px'><div align='left'><a href='#' title='Ordenar por Nombre'>NOMBRE</a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Ordenar por Nombre'>NOMBRE DEL PRODUCTOR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Humedad'>APLICA HUMEDAD </a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Descripción'>DESCRIPCION DEL PRODUCTO </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>CREADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>MODIFICADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA  MODIFICACION</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA MODIFICACION</a></div></th>
								
  					
        </tr>
        </thead>
        <tbody>";

		if ($result > 0){	
		    $correlativo = 1;
			while ($row = mysql_fetch_assoc($result)) 
                            {	
					//		 $usuario_busca=$row['id_usuario2'];
							 $usuario_modifica=$row['id_usuario_modifica'];							 
							 $fecha_imprime=parseDatePhp($row['fecha_usuario']);
							 $fecha_imprime_modif=parseDatePhp($row['fecha_modifica']);
							 $humedad1=$row['humedad'];
							 if($humedad1=="0")
							 $nom_humedad="NO";
							 if($humedad1=="1")
							 $nom_humedad="SI";
							 
							 	
								/*							 
							 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_busca' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario=$row_usuario['nombre_usuario'];
									}
								}*/
								
								 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_modifica' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario_modif=$row_usuario['nombre_usuario'];
									}
								}						
		echo"<tr>
		<td width='60px' align='left'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_producto']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a>
		<a onClick='enviar(\"".$row['id_producto']."\");' style='cursor:pointer' title='Modificar registro'><img src='../images/recovery.png' width='28px' height='28px'></a></td>	   
          <td width='auto' align='left'> $row[nom_producto] </td>
          <td width='auto' align='left'> $row[nom_productor] </td>		  
          <td width='auto' align='left'> $nom_humedad </td>		  
		  <td width='auto' align='left'> $row[desc_producto] </td>
		  <td width='auto' align='left'> $row[nombre_usuario]</td>	
		 <td width='auto' align='left'> $fecha_imprime </td>						  
		 <td width='auto' align='left'> $row[hora_usuario] </td>
		 <td width='auto' align='left'> $nombre_usuario_modif</td>	
		 <td width='auto' align='left'> $fecha_imprime_modif </td>						  
		 <td width='auto' align='left'> $row[hora_modifica] </td>
		  		  
		</tr>";
		$contar++;
		}
		$correlativo++;		
		echo"</tbody></table></div>";
}

	?>
    <!--Fin si se ha seleccionado administrador-->

<?php
//echo $correlativo;

echo "Total de Registros" ." ".$contar;
 
?>
  
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
<div class="navbar navbar-inverse navbar-fixed-bottom">
   <div class="container">
      <p style="text-align:center; color:#FFF; font-style:oblique;">
         Diseñado y Desarrollado Por <a style="color:#FFF; font-weight:bold" href="http://www.ie-networks.com/" target="_blank">Ie Networks</a> © 2017
      </p>
   </div>
</div>
<!-- FIN FOOTER  -->
<!-- INICIA ELIMINAR REGISTRO -->
<div class="modal fade" id="ventana4">
<form name="formulario_delete" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="id_eliminar" value="0">
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
                       <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>	
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" id="con_usuario" name="con_usuario" class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
            <div class="modal-footer">
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               	<button class="btn btn-primary" onClick="elimina()">Eliminar Registro</button>
           </div>
       </div>
    <div>               
    </form>
</div>
<!--------------------FIN VENTANA 4-------------------->

</body> 
</html>
	
<?PHP
mysql_close($con);
?>