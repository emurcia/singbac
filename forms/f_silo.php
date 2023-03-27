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
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");
?>
<?PHP
$correo_usuario = $_POST['correo_usuario'];
$pass_usuario = $_POST['pass_usuario'];

?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?php echo $nom_sistema; ?> </title> 
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
			"sScrollX":"100%"
	 });
  	
    	$('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
            });
    }); 

function guardar(){
		if(document.formulario1.archivo_pagop.value==""){
			document.formulario1.imagen_defaul.value="imgdefaul";
			document.formulario1.bandera_silo.value='ok';
		    document.formulario1.submit();
		}else{
		document.formulario1.bandera_silo.value='ok';
		document.formulario1.submit();
		}
}// fin guardar

function enviar(cod){
		document.formulario1.busca.value="actualizarmedida";	
		document.formulario1.codigo_modificar.value=cod;
		document.formulario1.action='f_mod_silo.php';//redireccionar a musuario.php
		document.formulario1.submit();
	}

function salirr()
 {	 
    document.formulario1.bandera_silo.value="oki";
    document.formulario1.submit();       
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
	
	  $id_eliminar=$_POST['id_eliminar'];
	  $nombre_usuario=$_POST['nombre_usuario'];
	  $con_usuario=md5($_POST['con_usuario']);

	 $activo="1";
	 $empresa=$id_empresa;
	 $eliminar="1";
	 
$usu_utilizado=mysql_query("SELECT * from tab_silo where id_silo='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']=="0"){ // no ha sido utilizado
		$lleno="0";
  }else{ // Posse datos
  	 	$lleno="1";
  }	 
	 
if ($lleno=="0"){
$tabla_eli="SELECT *  FROM tab_silo where id_silo='$id_eliminar'";
	$select = mysql_query($tabla_eli,$con);
	while($row_eli = mysql_fetch_array($select))
	{
		$directorio=$row_eli['foto_silo'];

	}		

$resultado = eliminar_su("tab_silo","id_silo",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
if($resultado=="1"){
	if ($directorio!="imagen_silo/default.png"){	
	unlink($directorio); // ELIMINAR  IMAGEN
	}
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
$Result1 = mysql_query("SELECT MAX(id_silo) as a  FROM tab_silo where id_empresa='$id_empresa' ORDER BY id_silo") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],5,3);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "SILO-00".$num.$id_empresa;
	}else{
		if ($a1<99){
			$num = "$a1"+"1";
			$nu= "SILO-0".$num.$id_empresa;
		}else{
			 if($a1<999){
				$num = "$a1"+"1";
				$nu= "SILO-".$num.$id_empresa;
				}
			}
	}
       
// INICIA EL GUARDADO DE INFORMACION 
		 $bandera = $_POST['bandera_silo'];
 		 $id_silo1 = strtoupper($_POST["id_silo"]);
	     $nom_silo1  = strtoupper($_POST["nom_silo"]);
	     $desc_silo1  = strtoupper($_POST["desc_silo"]);
		 $cap_silo1=($_POST["cap_silo"]);
		 $dir_silo1  = strtoupper($_POST["dir_silo"]);
		 $imagen2=$_POST['imagen_defaul'];
	     $guarda1 = 0;
if($pingresar=="1"){		 
 if($bandera=="ok")
   {//inicio if bandera ok
    $cliente_utilizado=mysql_query("SELECT count(*) as existe from tab_silo where nom_silo='$nom_silo1' and id_empresa='$id_empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$cliente_utilizado2 = mysql_fetch_array($cliente_utilizado);
if($cliente_utilizado2['existe']!=0){ // no ha sido utilizado
	$error=5; // Cliente ya existe
  }else{ // Posse datos
   if($codigo_medida1=="0") {
		echo '<div class="alert alert-warning alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Adventencia!</strong> Seleccione Unidad de medida.
		</div>';

        
		} else {
      if($nom_silo1=="") {
		echo '<div class="alert alert-warning alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Adventencia!</strong> Ingrese nombre
		</div>';
		}else{
			$imagen = $_GET['archivo_pagop'];
				
				if($_FILES['archivo_pagop']['type']=="image/pjpeg" or $_FILES['archivo_pagop']['type']=="image/jpeg"){
					$extension=".jpg";
				}
				else if($_FILES['archivo_pagop']['type']=="image/png"){
					$extension=".png";
				}
				else if($_FILES['archivo_pagop']['type']=="image/gif") {
					$extension=".gif";
				}
				else{
					$error = "11";	// FORMATO NO INCORRECTO
				}
				
				if($imagen2!=""){
					$nuevo_nombre="imagen_silo/default.png";
					}else{
							$nuevo_nombre=$id_silo1.$extension;
							$nuevo_nombre="imagen_silo/".$nuevo_nombre;
							if($_FILES['archivo_pagop']['tmp_name']!="none"){
							copy($_FILES['archivo_pagop']['tmp_name'],$nuevo_nombre);
							}
					}
									
				//Fin guardado de Imagen
				
	   	mysql_query("insert into tab_silo(id_silo, nom_silo, desc_silo, dir_silo, cap_silo, foto_silo, id_empresa, bandera, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values
					   ('$id_silo1', '$nom_silo1', '$desc_silo1', '$dir_silo1', '$cap_silo1','$nuevo_nombre', '$id_empresa', 0,'$id_usuario',0, '$fecha', '$hora','$id_usuario','$fecha','$hora')",$con);     
				   
					 if(mysql_error())
		  { 
			$error="1"; // error en datos
		  }
			  else
		     $error="2"; // datos almacenados
	}
   }
   }
   }
}else{ // fin bandera ok
	   $error="4"; //no tiene permiso de escritura
	   }//fin permiso
	
	
?>   
<?PHP 
if($error == "11")
{
	 echo '<div class="alert alert-success">
 	  <a href="f_silo.php" class="alert-link"> Imagen incorrecta!!! Haga click para continuar .....</a>
	 </div>
	 ';
}

 if($error == "1")
 {
	  echo '<div class="alert alert-success">
 			<a href="f_silo.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == "2")
 {
	 echo '<div class="alert alert-success">
 						  <a href="f_silo.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }
	  
if($mensaje=="1"){
echo '<div class="alert alert-success">
 						  <a href="f_silo.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje=="2"){
echo '<div class="alert alert-danger">
 						  <a href="f_silo.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje=="3"){
echo '<div class="alert alert-danger">
 						  <a href="f_silo.php" class="alert-link"> El Usuario no se puede eliminar, ya realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
if($error=="4"){
echo '<div class="alert alert-danger">
 						  <a href="f_silo.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';

}
if($error=="5"){
echo '<div class="alert alert-danger">
 						  <a href="f_silo.php" class="alert-link"> Cliente ya existe!!!</a>
						  </div>';

}
?>

            <!-- Formulario para ingresar silos que ofrece -->
			
  					<div class="row" >
  		   				<div class="col-md-13">
        					<div class="panel panel-primary">
           						<div class="panel-heading"><strong>Registro de SILOS</strong>				</div> <!-- PANEL 1 --->
           						<div class="panel-body" >
      					<form role="form" name="formulario1"  method="post" action="f_silo.php" enctype="multipart/form-data">
           				<input type="hidden"  name="bandera_silo" value="0">
                        <input type="hidden" name="busca">
                        <input type="hidden" name="codigo_eliminar"> 
                        <input type="hidden" name="codigo_modificar"> 
                        <input type="hidden" name="imagen_defaul">                          
                        
                          <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-12">
                              <div class="form-group">
                                    <label for="id_">Código</label>
                                    <input type="text" class="form-control input-lg" id="id_silo"  value="<?PHP echo $nu; ?>"name="id_silo" readonly style="background:#FFF;" autocomplete="off">
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
           		           <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-12">
                              <div class="form-group">
                                    <label >Nombre de silo</label>
                                    <input type="text" class="form-control input-lg" style="text-transform:uppercase;" id="nom_silo" value="<?PHP echo $nom_silo1; ?>" placeholder="NOMBRE DEL SILO"  name="nom_silo" autocomplete="off" required>
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
                          
                          <div class="row"><!--- INICIO ROW----->
                            <div class="col-md-12">
                              <div class="form-group">
                              <label>Capacidad del SILO</label>
               				 <div class="input-group">
                                <input type="text" class="form-control input-lg soloNUMEROS" value="<?PHP echo $cap_silo1; ?>"   name="cap_silo" id="cap_silo" autocomplete="off"  placeholder="CAPACIDAD DEL SILO	"required>
                              <span class="input-group-addon">Kilogramos</span>
                            </div>
                         </div>
                          </div>
                          </div><!--- FIN ROW-----> 
          
          				<div class="row"><!--- INICIO ROW----->
                            <div class="col-md-12">
                              <div class="form-group">
                                <label for="imagen">Adjuntar Imagen del SILO</label>
   								<input type="file" id="archivo_pagopInput" name="archivo_pagop" onChange="cambiar_imagen(this);">
    							<p class="help-block">Imagen no mayor a los 5.00 MB.</p> 
                              </div>                              
                              </div>  
			            </div><!--- FIN ROW-----> 
                        <br>
                            <div class="row"><!--- INICIO ROW----->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <textarea name="desc_silo" class="form-control" style="text-transform:uppercase;" rows="3" placeholder="Descripción del Silo" autocomplete="off" id="desc_silo" required><?PHP echo $desc_silo1; ?></textarea>
                                    </div>
                                </div>
                            </div><!--- FIN ROW----->
                              <div class="row"><!--- INICIO ROW----->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Dirección</label>
                                        <textarea name="dir_silo" class="form-control" style="text-transform:uppercase;" rows="3" placeholder="Dirección del Silo" autocomplete="off" id="dir_silo" required><?PHP echo $dir_silo1; ?></textarea>
                                    </div>
                                </div>
                            </div><!--- FIN ROW----->
                    <br>
          <table width="220" border="0" align="right">
            <tr>
             <td width="100"><button type="reset" id="btnsub" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
             <td width="20">&nbsp;</td>
             <td width="100"><input type="submit" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
             </tr>
          </table> 
    </form> 
          
</div>
</div>
</div> <!-- PAGINACION -->

<div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>SILOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>
					<?PHP
						$id_sil="SILO-000".$id_empresa;
                        $sql = "SELECT * FROM `tab_silo` as u WHERE 1=1 and id_silo!='$id_sil' and id_empresa='$id_empresa' and bandera=0 ORDER BY fecha_usuario desc, hora_usuario desc";
                        $result = mysql_query($sql,$con);
						 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones'>";
                    
                        echo"<thead>                     
                              <tr>            
                                
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='200px'><div align='left'><a href='#' title='Ordenar por Cliente'>NOMBRE</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Dirección'>DESCRIPCION</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Nivel'>CAPACIDAD (KILOGRAMOS) </a></div></th>	
								
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>CREADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>MODIFICADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA  MODIFICACION</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA MODIFICACION</a></div></th>
                            </tr>
                            </thead>
                            <tbody>";
                    
                            if ($result> 0){	
                                $correlativo = 1;
                                $contar2++;
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							 $nivel_busca=$row['id_nivel'];
							 $usuario_busca=$row['id_usuario2'];
							 $usuario_modifica=$row['id_usuario_modifica'];							 
							 $fecha_imprime=parseDatePhp($row[fecha_usuario]);
							 $fecha_imprime_modif=parseDatePhp($row[fecha_modifica]);
							 	
														 
							 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_busca' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario=$row_usuario['nombre_usuario'];
									}
								}
								
								 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_modifica' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario_modif=$row_usuario['nombre_usuario'];
									}
								}

                            echo"<tr>
                            <td width='60px' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_silo']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a>
                           <a onClick='enviar(\"".$row['id_silo']."\");' style='cursor:pointer' title='Modificar registro'><img src='../images/recovery.png' width='28px' height='28px'></a></td>	   
                              <td width='auto' align='left'> $row[nom_silo] </td>
                              <td width='auto' align='left'> $row[desc_silo] </td>
                              <td width='auto' align='left'> $row[cap_silo] </td>							  
							  <td width='auto' align='left'> $nombre_usuario</td>	
							  <td width='auto' align='left'> $fecha_imprime </td>						  
							  <td width='auto' align='left'> $row[hora_usuario] </td>
							  <td width='auto' align='left'> $nombre_usuario_modif</td>	
							  <td width='auto' align='left'> $fecha_imprime_modif </td>						  
							  <td width='auto' align='left'> $row[hora_modifica] </td>		  		  
		     
                            </tr>";
                            $contar++;
                            }
                            $correlativo++;		
                             echo"</tbody>
                        </table>
                        ";
                    
                    }
                    
                        ?>
    <!--Fin si se ha seleccionado administrador-->
					<?php
					echo "Total de Registros" ." ".$contar;
					?>
  
</div>
</div>
</div>
</div>
</div>
</div>
</div>
 <!-- TERMINA FORMULARIO silo -->


<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->





<!--  INICIO FOOTER   -->
<div class="navbar navbar-inverse navbar-fixed-bottom">
  <div class="container"><br>
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

<!------------------- ACTIVAR USUARIO-------------------->
</body> 
</html>

<?php 
mysql_close($con);
?>