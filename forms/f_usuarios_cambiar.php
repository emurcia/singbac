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
$id_usuario = $_SESSION['id_usuario_silo']; // id_usuario en bd
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
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../assets/stylesheet/caja_buscar.css">
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">

</head> 
<script>
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX": "100%"
	 });
	 });
	 
	  $(document).ready(function() {
    	$('#tblInstituciones1').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX": "100%"
	 });
	 });
	 
function guardar(){
		
			document.formulario.bandera.value='ok';
			document.formulario.submit();
	
		
}// fin guardar

/*
function eliminar(cod_transportista){/*funcion eliminar registro 
	document.formulario.busca.value="eliminartransportista";	
	if(confirm("Seguro que desea eliminar el registro?")){
		document.formulario.cod_prod_eliminar.value=cod_transportista;
		document.formulario.submit();
		}
	}
*/

function activar_guardar(){
	if(document.formulario.nombre_usuario.value!="" && document.formulario.id_nivel.value!=0)
	document.formulario.btnguardar.disabled=false;
	else
		document.formulario.btnguardar.disabled=true;
	}
function activar(codigo_act){
	document.formulario.busca.value="activar";	
	if(confirm("Seguro que desea Activar el usuario?")){
		document.formulario.cod_prod_eliminar.value=codigo_act;
		document.formulario.submit();
		}
	}	

function enviar(codigo_act){
	document.formulario.busca.value="baja";	
	if(confirm("Seguro que desea Inhabilitar el usuario?")){
		document.formulario.cod_prod_eliminar.value=codigo_act;
		document.formulario.submit();
		}
	}	
	
function modificar(cod){
		document.formulario.cod_prod_eliminar.value=cod;
		document.formulario.action='f_actualizar_usuarios.php';//redireccionar a musuario.php
		document.formulario.submit();
	}	
 
function validarEmail(valor) {
  if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
 //  alert("La dirección de email " + valor + " es correcta!.");
  } else {
   alert("La dirección de email " + valor + " es incorrecta!.");
   document.formulario.correo_usuario.value="";
   document.formulario.correo_usuario.focus();
  }
}
</script>	 

<script>
function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
   function index()
 {	 	
		document.location.href="f_principal.php";
    		     
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

	 $activo=1;
	 $empresa=$id_empresa;
	 $eliminar=1;
	 
$usu_utilizado=mysql_query("SELECT * from t_usuarios where id_usuario='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']==0){ // no ha sido utilizado
		$lleno=0;
  }else{ // Posse datos
  	 	$lleno=1;
  }	 
	 
	 
if ($lleno==0){
$resultado = eliminar_su("t_usuarios","id_usuario",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
if($resultado==1){
	$mensaje="1"; // Registro Eliminado
	
	}else{
	$mensaje="2"; // No posee permisos	
		
		}
	}
if($lleno==1){
	$mensaje="3";
	
	}
	
}// fin de bandera

?>

<body class="container" onLoad="document.formulario.id_lote.focus();"> 


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
<?php
$Result1 = mysql_query("SELECT MAX(id_usuario) as a  FROM t_usuarios WHERE id_empresa='$id_empresa' ORDER BY id_usuario") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],4,3);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "USU-00".$num.$id_empresa;
	}else{
		if ($a1<99){
			$num = "$a1"+"1";
			$nu= "USU-0".$num.$id_empresa;
		}else{
			 if($a1<999){
				$num = "$a1"+"1";
				$nu= "USU-".$num.$id_empresa;
				}
			}
	}		   
		

// INICIA EL GUARDADO DE INFORMACION 
		 $bandera = $_POST['bandera'];
		 $actuali = $_POST['act'];		 
 		 $id_nuevo1 = $nu;
	     $nombre1  = strtoupper($_POST["nombre_usuario"]);
	     $correo1 = $_POST["correo_usuario"];
	     $pass1 = md5($_POST["pass_usuario"]);
		 $nivel1=$_POST['id_nivel'];
		//  $id_empresa="1";
		// $activo_usuario1="1";
		 if (isset($_POST['usuario_activo']) && $_POST['usuario_activo'] == '1')
      	$activo_usuario1="1";
   			else
      	$activo_usuario1="0";
		
if($pingresar==1){
if($bandera=="ok")
   {//

$correo_utilizado=mysql_query("SELECT count(*) as existe from t_usuarios where correo_usuario='$correo1' and id_empresa='$id_empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$correo_utilizado2 = mysql_fetch_array($correo_utilizado);
if($correo_utilizado2['existe']!=0){ // no ha sido utilizado
	$error=5; // Correo ya existe
  }else{ // Posse datos
  	 	
   
mysql_query("insert into t_usuarios(id_usuario, nombre_usuario, correo_usuario, pass_usuario, activo_usuario, id_nivel, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values ('$id_nuevo1', '$nombre1', '$correo1', '$pass1', '$activo_usuario1', '$nivel1', '$id_empresa', '$id_usuario','0', '$fecha', '$hora','$id_usuario','$fecha','$hora')",$con) or die(mysql_error());     
				   
		 if(mysql_error())
		  { 
		  echo mysql_error();
			$error="1"; // error en datos
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

 if($error == 1)
 {
	  echo '<div class="alert alert-success">
 			<a href="f_usuarios.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == 2)
 {
	 $act= ("UPDATE tab_nivel SET ocupado=1 WHERE id_nivel='$nivel1' and id_empresa='$id_empresa'");
	 mysql_query($act,$con);
		
	 echo '<div class="alert alert-success">
 						  <a href="f_usuarios.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }
	  
if($mensaje==1){
echo '<div class="alert alert-success">
 						  <a href="f_usuarios.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje==2){
echo '<div class="alert alert-danger">
 						  <a href="f_usuarios.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje==3){
echo '<div class="alert alert-danger">
 						  <a href="f_usuarios.php" class="alert-link"> El Usuario no se puede eliminar, ya realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
if($error==4){
echo '<div class="alert alert-danger">
 						  <a href="f_usuarios.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';

}
if($error==5){
echo '<div class="alert alert-danger">
 						  <a href="f_usuarios.php" class="alert-link"> Correo electrónico ya existe!!!</a>
						  </div>';

}
?>
           <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-12">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>REGISTRO DE USUARIOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form action="f_usuarios.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="0" type="hidden" />     
	       <input type="hidden"  name="busca">
           <input type="hidden" name="cod_prod_eliminar"> 
           <input type="hidden" name="cod_prod_modif">          
           
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>NOMBRE USUARIO:</label>
               <input type="text" class="form-control input-lg" name="nombre_usuario" placeholder="NOMBRE DE USUARIO" required/>           
                  </div>
              </div>
              </div> <!-- fin-->
              <div class="row">
              <div class="col-md-12">
              <div class="form-group">
               <label>CORREO ELECTRONICO:</label>
               <input type="text" class="form-control input-lg" name="correo_usuario" placeholder="CORREO ELECTRONICO"  required/>    
                            
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
           
                   
            <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>CONTRASEÑA:</label>
               <input type="password" class="form-control input-lg" onfocus="validarEmail(document.formulario.correo_usuario.value)" name="pass_usuario"  placeholder="CONTRASEÑA" required/> 
                              
                  </div>
              </div>
              </div>
                  <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="cliente"> NIVEL DE USUARIO</label>
                         <?php
						       $tabla=mysql_query("SELECT * FROM tab_nivel Where id_empresa='$id_empresa'");
						  ?>
                      <select name="id_nivel" class="form-control input-lg" onChange="activar_guardar()" size="1" id="id_nivel">
                            <option value="0">NIVEL DE USUARIO </option>
							 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_cliente= $valor['id_nivel'];
									$nombre_cliente= $valor['nom_nivel'];
									echo "<option value='$codigo_cliente'>";
									echo ("$nombre_cliente");
									echo"</option>";
								}	
							?>
                    </select>
                              
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
              
               <div class="row"><!--- INICIO ROW----->
               <div class="col-md-12">
              <div class="checkbox">
               <label>
                <input type="checkbox" value="1" name="usuario_activo" >DESEA ACTIVAR USUARIO?
              </label>
                  </div>
              </div>
             </div><!--- FIN ROW----->
           

<br><br>
             
               	  <table width="220" border="0" align="right">
                  
                  
				   	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="submit" disabled name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
              	    </tr>
           	      </table> 
            
           </form> 
</div>
</div>
</div>

<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-12">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>USUARIOS ACTIVOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>
					<?php
					$nivel_busca="";
					$usuario_busca="";
                        /*echo"<script>alert('llega al php');</script>";*/ 	 
                         $sql = "SELECT * FROM `t_usuarios` WHERE activo_usuario='1' and id_empresa='$id_empresa'";
						 $result = mysql_query($sql);
                       echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='200px'><div align='left'><a href='#' title='Ordenar por Nombre'>NOMBRE</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Correo'>CORREO ELECTRONICO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Nivel'>NIVEL DE USUARIO </a></div></th>
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
                                $correlativo1 = 1;
                                $contar4=0;
								
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							 $nivel_busca=$row['id_nivel'];
							 $usuario_busca=$row['id_usuario2'];
							 $usuario_modifica=$row['id_usuario_modifica'];							 
							 $fecha_imprime=parseDatePhp($row[fecha_usuario]);
							 $fecha_imprime_modif=parseDatePhp($row[fecha_modifica]);
							 	
								$sql_nivel = "SELECT * FROM tab_nivel WHERE id_nivel='$nivel_busca' and id_empresa='$id_empresa'";
								$result_ni = mysql_query($sql_nivel,$con);
								if ($result_ni > 0){	
                               		while ($row_nivel = mysql_fetch_assoc($result_ni)){
									$nivel=$row_nivel['nom_nivel'];
									}
								}
							 
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
                            <td width='60px' align='letf'><a onClick='modificar(\"".$row['id_usuario']."\");' style='cursor:pointer' title='Modificar Usuario'><img src='../images/recovery1.png' width='28px' height='28px'></a>
                            <a onClick='enviar(\"".$row['id_usuario']."\");' style='cursor:pointer' title='Inhabilitar Usuario'><img src='../images/close.png' width='26px' height='26px'></a></td>
							  <td width='auto' align='left'> $row[nombre_usuario] </td>
                              <td width='auto' align='left'> $row[correo_usuario] </td>
                              <td width='auto' align='left'> $nivel</td>
							  <td width='auto' align='left'> $nombre_usuario</td>	
							  <td width='auto' align='left'> $fecha_imprime </td>						  
							  <td width='auto' align='left'> $row[hora_usuario] </td>
							  <td width='auto' align='left'> $nombre_usuario_modif</td>	
							  <td width='auto' align='left'> $fecha_imprime_modif </td>						  
							  <td width='auto' align='left'> $row[hora_modifica] </td>
                              
                            </tr>";
                            $contar4++;
                            }
								
							
                            $correlativo++;		
                    
                            echo"</tbody>
                        </table>
                        ";
                    
                    }
                    
                    
                    
                        ?>
    <!--Fin si se ha seleccionado administrador-->

					<?php

					echo "Total de Registros" ." ".$contar4;
					 
					?>
  
</div>
</div>
</div>
</div>
</div>
</div>
</div>             

<!-- Inicia paginacion para mostrar los usuarios -->

<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-12">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>USUARIOS INACTIVOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>
					<?php
					$nivel_busca="";
					$usuario_busca="";
                        /*echo"<script>alert('llega al php');</script>";*/ 	 
                         $sql = "SELECT * FROM `t_usuarios` WHERE activo_usuario='0' and id_empresa='$id_empresa'";
						 $result = mysql_query($sql);
                       echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones1' >";
                    
                        echo"<thead>                     
                              <tr>            
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='200px'><div align='left'><a href='#' title='Ordenar por Nombre'>NOMBRE</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Correo'>CORREO ELECTRONICO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Nivel'>NIVEL DE USUARIO </a></div></th>
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
                                $correlativo1 = 1;
                                $contar4=0;
								
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							 $nivel_busca=$row['id_nivel'];
							 $usuario_busca=$row['id_usuario2'];
							 $usuario_modifica=$row['id_usuario_modifica'];							 
							 $fecha_imprime=parseDatePhp($row[fecha_usuario]);
							 $fecha_imprime_modif=parseDatePhp($row[fecha_modifica]);
							 	
								$sql_nivel = "SELECT * FROM tab_nivel WHERE id_nivel='$nivel_busca' and id_empresa='$id_empresa'";
								$result_ni = mysql_query($sql_nivel,$con);
								if ($result_ni > 0){	
                               		while ($row_nivel = mysql_fetch_assoc($result_ni)){
									$nivel=$row_nivel['nom_nivel'];
									}
								}
							 
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
                            <td width='60px' align='left'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_usuario']."\");' style='cursor:pointer' title='Eliminar Usuario'><img src='../images/trash-icon.png' width='28px' height='28px'></a>
                            <a onClick='activar(\"".$row['id_usuario']."\");' style='cursor:pointer' title='Activar Usuario'><img src='../images/recovery.gif' width='26px' height='26px'></a></td>	                              <td width='auto' align='left'> $row[nombre_usuario] </td>
                              <td width='auto' align='left'> $row[correo_usuario] </td>
                              <td width='auto' align='left'> $nivel</td>
							  <td width='auto' align='left'> $nombre_usuario</td>	
							  <td width='auto' align='left'> $fecha_imprime </td>						  
							  <td width='auto' align='left'> $row[hora_usuario] </td>
							  <td width='auto' align='left'> $nombre_usuario_modif</td>	
							  <td width='auto' align='left'> $fecha_imprime_modif </td>						  
							  <td width='auto' align='left'> $row[hora_modifica] </td>
                              
                            </tr>";
                            $contar4++;
                            }
								
							
                            $correlativo++;		
                    
                            echo"</tbody>
                        </table>
                        ";
                    
                    }
                    
                    
                    
                        ?>
    <!--Fin si se ha seleccionado administrador-->

					<?php

					echo "Total de Registros" ." ".$contar4;
					 
					?>
  
</div>
</div>
</div>
</div>
</div>
</div>
</div>             



</div>
</div>
<br>
<br>
<br>
<!--  INICIO FOOTER   -->
<?php include('footer.php'); ?>
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
               	<button class="btn btn-primary" onClick="elimina()">Eliminar Registro</button>
    </div>
    <div>               
    </form>
</div>



<!------------------- ACTIVAR USUARIO-------------------->

  <?php 
  // Eliminar transportista	
if(isset($_POST['busca']) && $_POST['busca']=="activar"){
 $usuario_activar1='1';
 $cod_activa=$_POST['cod_prod_eliminar'];


 $sql2="UPDATE `t_usuarios` SET  `activo_usuario`='$usuario_activar1' WHERE id_usuario='$cod_activa'";		
		if(!$result = mysql_query($sql2,$con)){die ('Ocurrio un error al ejecutar el sql');
			}
		 else{ 
			echo" <script language='javascript'>";
			echo" alert('Usuario Activado con éxito...');";
			echo"location.href='f_usuarios.php';";
			echo" </script>";
		}
  }
?>

<!------------------- DAR DE BAJA A USUARIO-------------------->

  <?php 
  // Eliminar transportista	
if(isset($_POST['busca']) && $_POST['busca']=="baja"){
 $usuario_activar1='0';
 $cod_activa=$_POST['cod_prod_eliminar'];

 $sql2="UPDATE `t_usuarios` SET  `activo_usuario`='$usuario_activar1' WHERE id_usuario='$cod_activa'";		
		if(!$result = mysql_query($sql2,$con)){die ('Ocurrio un error al ejecutar el sql');
			}
		 else{ 
			echo" <script language='javascript'>";
			echo" alert('Usuario Desactivado con éxito...');";
			echo"location.href='f_usuarios.php';";
			echo" </script>";
		}
  }
?>

</body> 
</html>


  <?php 
  // Eliminar producto	
  mysql_close();
?>
