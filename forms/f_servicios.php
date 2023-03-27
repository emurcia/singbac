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
<?PHP
$correo_usuario = $_POST['correo_usuario'];
$pass_usuario = $_POST['pass_usuario'];

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
<script src="../assets/javascript/chosen.jquery.js"></script>
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
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
		document.formulario1.bandera.value='ok';
		document.formulario1.submit();
}// fin guardar

function enviar(cod){
		document.formulario1.busca.value="actualizarmedida";	
		document.formulario1.codigo_modificar.value=cod;
		document.formulario1.action='f_mod_servicios.php';//redireccionar a musuario.php
		document.formulario1.submit();
	}

function salirr()
 {	 
    document.formulario1.bandera.value="oki";
    document.formulario1.submit();       
 }
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
	 
$prod_utilizado=mysql_query("SELECT * from tab_servicio where id_servicio='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI YA TIENE DATOS
$prod_utilizado2 = mysql_fetch_array($prod_utilizado);
if($prod_utilizado2['ocupado']=="0"){ // no ha sido utilizado
		$lleno="0";
  }else{ // Posse datos
  	 	$lleno="1";
  }	 
	 
	 
if ($lleno=="0"){
$resultado = eliminar_su("tab_servicio","id_servicio",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
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
$Result1 = mysql_query("SELECT MAX(id_servicio) as a  FROM tab_servicio  WHERE id_empresa='$id_empresa' ORDER BY id_servicio") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],5,3);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "SERV-00".$num.$id_empresa;
	}else{
		if ($a1<99){
			$num = "$a1"+"1";
			$nu= "SERV-0".$num.$id_empresa;
		}else{
			 if($a1<999){
				$num = "$a1"+"1";
				$nu= "SERV-".$num.$id_empresa;
				}
			}
	}
		
     
// INICIA EL GUARDADO DE INFORMACION 
		 $bandera = $_POST['bandera'];
 		 $id_servicio1 = strtoupper($_POST["id_servicio"]);
	    $nom_servicio1  = strtoupper($_POST["nom_servicio"]);
	     $desc_servicio1  = strtoupper($_POST["desc_servicio"]);
	    $precio_servicio1 = $_POST["precio_servicio"];
		 $codigo_medida1= $_POST["id_origen"];
	     $guarda1 = 0;
	
if($pingresar=="1"){	
 if($bandera=="ok")
   {//inicio if bandera ok
    $correo_utilizado=mysql_query("SELECT count(*) as existe from tab_servicio where nom_servicio='$nom_servicio1' and id_empresa='$id_empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$correo_utilizado2 = mysql_fetch_array($correo_utilizado);
if($correo_utilizado2['existe']!="0"){ // no ha sido utilizado
	$error="5"; // Correo ya existe
  }else{ // Posse datos
   if($codigo_medida1=="0") {
		echo '<div class="alert alert-warning alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Adventencia!</strong> Seleccione Unidad de medida.
		</div>';
		} else {
      if($nom_servicio1=="") {
		echo '<div class="alert alert-warning alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Adventencia!</strong> Ingrese del nombre del Producto.
		</div>';
		}else{
		mysql_query("insert into tab_servicio(id_servicio, nom_servicio, desc_servicio, precio_servicio, id_medida, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica, bandera) values('$id_servicio1', '$nom_servicio1', '$desc_servicio1','$precio_servicio1','$codigo_medida1', '$id_empresa', '$id_usuario',0, '$fecha_entrada', '$hora_entrada','$id_usuario','$fecha_entrada','$hora_entrada',0)",$con);     
				   
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

 if($error == "1")
 {
	  echo '<div class="alert alert-success">
 			<a href="f_servicios.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == "2")
 {
	$act= ("UPDATE tab_medida SET ocupado=1 WHERE id_medida='$codigo_medida1' and id_empresa='$id_empresa'");
	 mysql_query($act,$con);
	 echo '<div class="alert alert-success">
 						  <a href="f_servicios.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }
	  
if($mensaje=="1"){
echo '<div class="alert alert-success">
 						  <a href="f_servicios.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje=="2"){
echo '<div class="alert alert-danger">
 						  <a href="f_servicios.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje=="3"){
echo '<div class="alert alert-danger">
 						  <a href="f_servicios.php" class="alert-link"> El Usuario no se puede eliminar, ya realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
if($error=="4"){
echo '<div class="alert alert-danger">
 						  <a href="f_servicios.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';

}
if($error=="5"){
echo '<div class="alert alert-danger">
 						  <a href="f_servicios.php" class="alert-link"> Producto ya existe!!!</a>
						  </div>';

}
?>

 <div class="container-fluid">
  <div class="row" >
  
 <div class="container-fluid">
  <div class="row" >
     <div class="col-md-13">
        <div class="panel panel-primary">
           						<div class="panel-heading"><strong>Registro de Servicios</strong>				</div> <!-- PANEL 1 --->
           						<div class="panel-body" >
      					<form role="form" name="formulario1"  method="post" action="f_servicios.php">
			           	<input type="hidden"  name="bandera" value="0">
                         <input type="hidden" name="busca">
                        <input type="hidden" name="codigo_eliminar"> 
                        <input type="hidden" name="codigo_modificar">  
                        
                          <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-12">
                              <div class="form-group">
                                    <label for="origen_servicio">Código</label>
                                    <input type="text" class="form-control input-lg" id="id_servicio" style="background:#FFF" readonly	 value="<?PHP echo $nu; ?>"name="id_servicio" autocomplete="off">
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
           		           <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-12">
                              <div class="form-group">
                                    <label for="origen_servicio">Servicio a ofrecer</label>
                                    <input type="text" class="form-control input-lg" style="text-transform:uppercase;" id="nom_servicio" value="<?php echo $nom_servicio1; ?>" placeholder="Nombre del servicio a brindar"  name="nom_servicio" autocomplete="off" required>
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
          
          
                            <div class="row"><!--- INICIO ROW----->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion">Descripción</label>
                                        <textarea name="desc_servicio" class="form-control" style="text-transform:uppercase;" rows="3" placeholder="Descripción del Servicio a brindar" autocomplete="off" id="desc_servicio" required><?PHP echo $desc_servicio1; ?></textarea>
                                    </div>
                                </div>
                            </div><!--- FIN ROW----->
                            
          <div class="row"><!--- INICIO ROW----->
            <div class="col-md-6">
              <div class="form-group">
              <label>Precio por unidad de Medida</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="precio_servicio" value="<?PHP echo $precio_servicio1; ?>" name="precio_servicio"  placeholder="PRECIO" autocomplete="off" required>
              <span class="input-group-addon">Quetzal</span>
                  </div>
      
              </div>
       </div>
       
                         
             <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">Unidad de Medida</label>
                         <?php
						 $id_med="UMED-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_medida WHERE id_medida!='$id_med' and id_empresa='$id_empresa'");
						  ?>
                      <select name="id_origen" class="form-control input-lg chosen" size="1" id="id_origen">
                            <option value="0">SELECCIONE UNIDAD DE MEDIDA </option>
							 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_medida= $valor['id_medida'];
									$nombre_medida= $valor["nom_medida"];
									echo "<option value='$codigo_medida'>";
									echo utf8_encode("$nombre_medida");
									echo"</option>";
								}	
							?>
                          </select>
                              
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
<div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Servicios a ofrecer</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>
					<?php
                        /*echo"<script>alert('llega al php');</script>";*/ 	
						$id_ser="SERV-000".$id_empresa; 
                         $sql = "SELECT * FROM tab_servicio WHERE 1=1 and id_servicio!='$id_ser' and id_empresa='$id_empresa' ORDER BY fecha_usuario desc, hora_usuario desc";
 	 					$result = mysql_query($sql,$con);
						
						echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='200px'><div align='left'><a href='#' title='Ordenar por Nombre'>NOMBRE</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Precio'>PRECIO (QUETZAL)</a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Precio'>PRECIO (DOLAR)</a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Precio'>UNIDAD DE MEDIDA</a></div></th>
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
								$contar2++;
							while ($row=mysql_fetch_array($result)) 
							    {	
							$conver=round($row[precio_servicio]/7.4396,2);	
							$familia1=$row['id_medida'];
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
							
							
							$tabla2="SELECT * FROM tab_medida WHERE id_medida='$familia1' and id_empresa='$id_empresa'";
 	 						$result2 = mysql_query($tabla2,$con);
							while($row2=mysql_fetch_array($result2)) {
							$familia=$row2['nom_medida'];
							}
                            echo"<tr>
                            <td width='60px' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_servicio']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a>
                            <a onClick='enviar(\"".$row['id_servicio']."\");' style='cursor:pointer' title='Modificar registro'><img src='../images/recovery.png' width='28px' height='28px'></a></td>	   
								 <td width='auto' align='left'> $row[nom_servicio] </td>
								 <td width='auto' align='left'> $row[precio_servicio] </td>
								 <td width='auto' align='left'> $conver </td>
								 <td width='auto' align='left'>$familia  </td>	
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

</div>
 <!-- TERMINA FORMULARIO ORIGEN -->


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
            <div class="modal-header">
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
 <?php 
  mysql_close($con);
?>