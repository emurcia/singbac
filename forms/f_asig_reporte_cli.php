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
 
 
// INICIA EL GUARDADO DE INFORMACION 
		$bandera = $_POST['bandera'];
 		$id_nuevo = strtoupper($_POST["id_nivel"]);
	     $nombre  = strtoupper($_POST["nom_nivel"]);
	    $descripcion = strtoupper($_POST["desc_nivel"]);
		$almacena=$_POST["almacena"];
		$modifica=$_POST["modifica"];
		$elimina=$_POST["elimina"];		

// FECHA Y HORA
date_default_timezone_set("America/El_Salvador");
$ano=date('Y');
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");		
		
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../assets/stylesheet/caja_buscar.css">
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
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
    }); 

function guardar(){
		document.formulario.bandera.value='ok';
		document.formulario.submit();
	
}// fin guardar

/*
function eliminar(cod_producto){/*funcion eliminar registro 
	document.formulario.busca.value="eliminarproducto";	
	if(confirm("Seguro que desea eliminar el registro?")){
		document.formulario.cod_prod_eliminar.value=cod_producto;
		document.formulario.submit();
		}
	}
*/

function enviar(cod){
		document.formulario.busca.value="actualizarproducto";	
		document.formulario.cod_prod_modif.value=cod;
		document.formulario.action='f_mod_nivel.php';//redireccionar a musuario.php
		document.formulario.submit();
	}

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }	
 
 function almacenarr() //funcionar para activas las cajas de textos
  {
		if (document.formulario.activar_almacena.checked==true)
			document.formulario.almacena.value="1";
  }
 function modificarr() //funcionar para activas las cajas de textos
  {
		if (document.formulario.activar_modifica.checked==true)
			document.formulario.modifica.value="1";
  } 
 function eliminarr() //funcionar para activas las cajas de textos
  {
		if (document.formulario.activar_elimina.checked==true)
			document.formulario.elimina.value="1";
  }    	
 
 
</script>
<script>
function eliminar(str1)
{
	 document.formulario_delete.id_eliminar.value = str1;
   
}
function eliminadato()
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

	 $activo=1;
	 $empresa=$id_empresa;
	 $eliminar=1;
	 
$usu_utilizado=mysql_query("SELECT * from tab_nivel where id_nivel='$id_eliminar' and id_empresa='$id_empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']==0){ $lleno=0; }// no ha sido utilizado
		
if($usu_utilizado2['ocupado']==1) {$lleno=1 ;} //ya es ocupado
	 

	 
if ($lleno==0){
$resultado = eliminar_su("tab_nivel","id_nivel",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
if($resultado==1){
	$mensaje="1"; // Registro Eliminado
	
	}else{
	$mensaje="2"; // No posee permisos	
		
		}
	}
if($lleno==1){
	$mensaje="3"; // ya esta siendo utilizdo
	
	}
	
}// fin de bandera

?>
<body class="container"> 


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
		 
$Result1 = mysql_query("SELECT MAX(id_nivel) as a  FROM tab_nivel WHERE id_empresa='$id_empresa' ORDER BY id_nivel ") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],4,3);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "NIV-00".$num.$id_empresa;
	}else{
		if ($a1<99){
			$num = "$a1"+"1";
			$nu= "NIV-0".$num.$id_empresa;
		}else{
			 if($a1<999){
				$num = "$a1"+"1";
				$nu= "NIV-".$num.$id_empresa;
				}
			}
	}
				
				

if($pingresar==1){	
 if($bandera=="ok")
   {//inicio if bandera ok
	   if($modifica!=1){
		   $modifica=0;
		   }
	   if($elimina!=1){
		   $elimina=0;
		   }
	   if($almacena!=1){
		   $almacena=0;
		   }	   	   
      if($nombre=="") {
		echo '<div class="alert alert-warning alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Adventencia!</strong> Ingrese nombre del Nivel
		</div>';
		}else{
			mysql_query("insert into tab_nivel(id_nivel, nom_nivel, desc_nivel, id_empresa, ingresar, modificar, eliminar, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values ('$id_nuevo', '$nombre', '$descripcion', '$id_empresa','$almacena', '$modifica','$elimina','$id_usuario', 0, '$fecha', '$hora','$id_usuario','$fecha','$hora')",$con); 
			    
				   
			if(mysql_error())
				  { 
					echo '<div class="alert alert-danger">
 				    <a href="f_nivel.php" class="alert-link"> Error en el procesamiento de datos!!! Haga click para continuar .....</a>
					  </div>';
					  }
					  else
					  
					mysql_query("insert into tab_detalle_menu(id_nivel, id_menu, id_empresa) values ('$id_nuevo', '1', '$id_empresa'), ('$id_nuevo', '71', '$id_empresa'),('$id_nuevo', '72', '$id_empresa');",$con); 
						  echo '<div class="alert alert-success">
 						  <a href="f_nivel.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
					  
		}
   }
  }else{ // fin bandera ok
	   echo '<div class="alert alert-danger">
 						  <a href="f_nivel.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>'; //no tiene permiso de escritura
	   }//fin permiso	


if($mensaje==1){
	 echo '<div class="alert alert-success">
 						  <a href="f_nivel.php" class="alert-link"> Registro eliminado correctamente!!! Haga click para continuar</a>
						  </div>';
	}

if($mensaje==2){
echo '<div class="alert alert-danger">
 						  <a href="f_nivel.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje==3){
echo '<div class="alert alert-danger">
 						  <a href="f_nivel.php" class="alert-link"> El Nivel no se puede eliminar, ya se utilizó en el sistema!!! Haga click para continuar .....</a>
						  </div>';

}		
?>   

           <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Asignación de Reportes a Clientes</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           	<form role="form" name="formulario"  method="post" action="f_nivel.php">
           	<input type="hidden"  name="bandera" value="0">
           	<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif"> 
             <input type="hidden" name="almacena"> 
             <input type="hidden" name="modifica">          
             <input type="hidden" name="elimina"> 
                              
                       
         <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">CLIENTE</label>
                         <?php
					//	$id_cli="CLI-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM t_usuarios Where id_empresa='$id_empresa' and activo_usuario=1;");
						  ?>
                      <select name="id_cliente2" class="form-control input-lg chosen" size="1" id="id_cliente2">
                              <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_cliente= $valor['id_usuario'];
									$nombre_cliente= $valor["nombre_usuario"];
									echo "<option value='$codigo_cliente'>";
									echo ("$nombre_cliente");
									echo"</option>";
								}	
							?>
                          </select>
                  </div>
              </div>
               <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">LOTE</label>
                <div id="feedback"><select class="chosen" name="id_lote2" id="id_lote2" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="<?php echo $id_lote11; ?>"><?PHP echo $nom_lote1; ?></option></select></div>
                  </div>
              </div>
              </div>
          
          
          
          
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
          <div class="form-group">
          <label for="nombre_producto">Permisos</label>
           <div class="checkbox">
              <label>
                <input type="checkbox" name="activar_almacena" value="0" onclick="almacenarr()">Almacenamiento </label>
          </div>
          </div>
          </div>
          <div class="col-md-4">
           <div class="form-group">
           <label for="nombre_producto"></label>
           <div class="checkbox">
              <label>
                <input type="checkbox" name="activar_modifica" value="0" onclick="modificarr()">Modificación </label>
          </div>
         </div>
         </div>
         <div class="col-md-4">
           <div class="form-group">
           <label for="nombre_producto"></label>
           <div class="checkbox">
              <label>
                <input type="checkbox" name="activar_elimina" value="0" onclick="eliminarr()">Eliminación </label>
          </div>
          </div>
         </div>
          </div><!--- FIN ROW-----> 
          
          
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="direccion_comprador">Descripción</label>
                        <textarea name="desc_nivel" class="form-control" style="text-transform:uppercase;" rows="3" placeholder="Descripción del Nivel" autocomplete="off" id="desc_nivel"><?PHP echo $descripcion; ?> </textarea>
          </div>
          </div>
          
          </div><!--- FIN ROW----->
                   
           
                      

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
</div> <!-- Fin de formularios  Inicia la paginacion-->

   <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>NIVEL DE USUARIOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           

<div>
<?php
	/*echo"<script>alert('llega al php');</script>";*/ 	 
	 $sql = "SELECT * FROM `tab_nivel` as u WHERE 1=1 and id_empresa='$id_empresa' ";
 	 $result = mysql_query($sql,$con);
    
    echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                <th width='120px'><div align='left'>ACCIONES</div></th>
                                <th width='225px'><div align='left'><a href='#' title='Ordenar por Nombre'>NIVEL</a></div></th>
                                <th width='125px'><div align='left'><a href='#' title='Odenar por Correo'>ALMACENA </a></div></th>
								<th width='125px'><div align='left'><a href='#' title='Odenar por Nivel'>MODIFICA</a></div></th>
								<th width='125px'><div align='left'><a href='#' title='Odenar por Nivel'>ELIMINA</a></div></th>
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
		$usuario_busca=$row['id_usuario2'];
		$usuario_modifica=$row['id_usuario_modifica'];							 
		$fecha_imprime=parseDatePhp($row[fecha_usuario]);
		$fecha_imprime_modif=parseDatePhp($row[fecha_modifica]);
		if($row['ingresar']==1)	$almace="SI"; else $almace="NO";
		if($row['modificar']==1)	$modifi="SI"; else $modifi="NO";
		if($row['eliminar']==1)	$elim="SI"; else $elim="NO";		
				
		
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
		<td width='30px' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_nivel']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a></td>
   
        <td width='auto' align='left'> $row[nom_nivel] </td>
        <td width='auto' align='center'> $almace </td>
        <td width='auto' align='center'> $modifi </td>
        <td width='auto' align='center'> $elim </td>						
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
      <p class="navbar-text">
         Diseñado y Desarrollado Por <a href="http://www.ie-networks.com/">Ie Networks</a> © 2017.
      </p>
   </div>
</div>
<!-- FIN FOOTER  -->

</body> 
</html>


<!--------------------ELIMINAR REGISTRO-------------------->
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
               	<button class="btn btn-primary" onClick="eliminadato()">Eliminar Registro</button>
    </div>
    <div>               
    </form>
</div>


  <?php 
  mysql_close();
?>