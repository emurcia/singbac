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
 
date_default_timezone_set("America/El_Salvador");
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora_entrada=date("H:i:s");
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");

$bandera = $_POST['bandera1'];
  
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
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
</head> 
<script>
function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
</script>



<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });


    $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=09 && tecla.keyCode !=127 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
            });
		
});
</script>
	
<script>
function guardar(){
		document.formulario.bandera.value='ok';
		document.formulario.submit();
}// fin guardar

function enviar(cod){
		document.formulario.busca.value="actualizarcliente";	
		document.formulario.cod_prod_modif.value=cod;
		document.formulario.action='f_mod_cliente.php';//redireccionar a musuario.php
		document.formulario.submit();
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
	 
$usu_utilizado=mysql_query("SELECT * from tab_cliente where id_cliente='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']=="0"){ // no ha sido utilizado
		$lleno="0";
  }else{ // Posse datos
  	 	$lleno="1";
  }	 
	 
	 
if ($lleno=="0"){
$resultado = eliminar_su("tab_cliente","id_cliente",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
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

<body class="container" onLoad="document.formulario.nom_cliente.focus();"> 


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

<?php // Generar el codigo de la medida
$Result1 = mysql_query("SELECT MAX(id_cliente) as a  FROM tab_cliente where id_empresa='$id_empresa' ORDER BY id_cliente ") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],4,3);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "CLI-00".$num.$id_empresa;
	}else{
		if ($a1<99){
			$num = "$a1"+"1";
			$nu= "CLI-0".$num.$id_empresa;
		}else{
			 if($a1<999){
				$num = "$a1"+"1";
				$nu= "CLI-".$num.$id_empresa;
				}
			}
	}          
     									

// INICIA EL GUARDADO DE INFORMACION 
		 $bandera = $_POST['bandera'];
 		 $id_nuevo = strtoupper($_POST["id_cliente"]);
	     $nombre  = strtoupper($_POST["nom_cliente"]);
	     $direccion = strtoupper($_POST["dir_cliente"]);
	     $tel = ($_POST["tel_cliente"]);	
	     $ape1 = strtoupper($_POST["ape_responsable"]);	
	     $nom1 = strtoupper($_POST["nom_responsable"]);
	     $dir1 = strtoupper($_POST["dir_responsable"]);
	     $tel1 = strtoupper($_POST["tel_responsable"]);				

if($pingresar=="1"){	
 if($bandera=="ok")
   {//inicio if bandera ok
   $cliente_utilizado=mysql_query("SELECT count(*) as existe from tab_cliente where nom_cliente='$nombre' and id_empresa='$id_empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$cliente_utilizado2 = mysql_fetch_array($cliente_utilizado);
if($cliente_utilizado2['existe']!="0"){ // no ha sido utilizado
	$error="5"; // Cliente ya existe
  }else{ // Posse datos
      
			mysql_query("insert into tab_cliente(id_cliente, nom_cliente, dir_cliente, tel_cliente, ape_responsable, nom_responsable, dir_responsable, tel_responsable, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica, bandera) values('$id_nuevo', '$nombre', '$direccion' , '$tel', '$ape1', '$nom1', '$dir1', '$tel1', '$id_empresa', '$id_usuario',0, '$fecha', '$hora','$id_usuario','$fecha','$hora',0)",$con);     
				   
		 if(mysql_error())
		  { 
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

 if($error == "1")
 {
	  echo '<div class="alert alert-success">
 			<a href="f_cliente.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == "2")
 {
 echo '<div class="alert alert-success">
 						  <a href="f_cliente.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }
	  
if($mensaje=="1"){
echo '<div class="alert alert-success">
 						  <a href="f_cliente.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje=="2"){
echo '<div class="alert alert-danger">
 						  <a href="f_cliente.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje=="3"){
echo '<div class="alert alert-danger">
 						  <a href="f_cliente.php" class="alert-link"> El Usuario no se puede eliminar, ya realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
if($error=="4"){
echo '<div class="alert alert-danger">
 						  <a href="f_cliente.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';

}
if($error=="5"){
echo '<div class="alert alert-danger">
 						  <a href="f_cliente.php" class="alert-link"> Cliente ya existe!!!</a>
						  </div>';

}
?>


           <div class="container-fluid">
  <div class="row" >
  
 <div class="container-fluid">
  <div class="row" >
     <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Registro de Clientes</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           <div class="panel-heading bg-info"><strong>Datos del Cliente ó Empresa</strong></div> <!-- PANEL 1 ---> 
           <form role="form" name="formulario"  method="post" action="f_cliente.php">
           <input type="hidden"  name="bandera" value="0">
           <input type="hidden"  name="busca">
           <input type="hidden" name="cod_prod_eliminar"> 
           <input type="hidden" name="cod_prod_modif"> 
            <div class="row"><!--- INICIO ROW----->
            
          <div class="col-md-12">
          <div class="form-group">
          		<label for="nombre_cliente">Código del Cliente</label>
            	<input type="text" class="form-control input-lg" value="<?php echo $nu; ?>"   name="id_cliente" id="id_cliente" readonly style="background:#FFF" autocomplete="off">
            </div>
          </div>
          
          </div><!--- FIN ROW-----> 
           
             <div class="row"><!--- INICIO ROW----->
           <div class="col-md-12">
          <div class="form-group">
          		<label for="nombre_cliente">Nombre del Cliente ó empresa</label>
            	<input type="text" class="form-control input-lg" id="nom_cliente" placeholder="Nombre del cliente" require  name="nom_cliente" style="text-transform:uppercase;" autocomplete="off" required>
            </div>
          </div>
          </div><!--- FIN ROW-----> 
          
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="direccion_comprador">Dirección del cliente ó empresa</label>
             <textarea name="dir_cliente" style="text-transform:uppercase;" class="form-control" rows="3" placeholder="Dirección del cliente" autocomplete="off" id="dir_cliente" required></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
          <div class="form-group">
             <label for="direccion_comprador">Teléfono del cliente ó empresa</label>
             <input type="text" class="form-control input-lg soloNUMEROS" id="tel_cliente" onkeypress="mascara(this, '####-####')" maxlength="9" placeholder="Telefono del cliente"  name="tel_cliente" autocomplete="off" required>
          </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="checkbox">
              <label>
                <input type="checkbox" value="" onclick="activar_textos()">Desea Agregar Datos del Encargado de la empresa
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
                                    <input type="text" class="form-control input-lg" id="ape_responsable" placeholder="Apellidos del Encargado"  name="ape_responsable" autocomplete="off" style="text-transform:uppercase;" >
                              </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                    <label for="origen_servicio">Nombre del Encargado</label>
                                    <input type="text" class="form-control input-lg" id="nom_responsable" placeholder="Nombre del Encargado"  name="nom_responsable" autocomplete="off" style="text-transform:uppercase;" >
                              </div>
                            </div>
                          </div><!--- FIN ROW-----> 
                          <div class="row"><!--- INICIO ROW----->
                          <div class="col-md-12">
                          <div class="form-group">
                             <label for="direccion_comprador">Dirección del encargado de la Empresa</label>
                             <textarea name="dir_responsable" class="form-control" rows="3" placeholder="Dirección del Encargado" autocomplete="off" id="dir_responsable" style="text-transform:uppercase;" ></textarea>
                          </div>
                          </div>
                          </div><!--- FIN ROW----->
                          <div class="row"><!--- INICIO ROW----->
                          <div class="col-md-4">
                          <div class="form-group">
                             <label for="direccion_comprador">Teléfono del encargado</label>
                             <input type="text" class="form-control input-lg soloNUMEROS" id="tel_responsable" placeholder="Telefono del encargado"  name="tel_responsable" onkeypress="mascara(this, '####-####')" maxlength="9" autocomplete="off" >
                          </div>
                          </div>
                          </div><!--- FIN ROW----->
                                          
                       </div>
                     </div>
            </div>
          </div>
               
              	  <table width="220" border="0" align="right">
              	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" onClick="cancelar()" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="submit" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
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
           <div class="panel-heading"><strong>CLIENTES</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >

<div>
<?php
$id_cliente="CLI-000".$id_empresa;
	/*echo"<script>alert('llega al php');</script>";*/ 	 
	 $sql = "SELECT * FROM `tab_cliente` as u WHERE 1=1 and id_empresa='$id_empresa' and id_cliente!='$id_cliente' and bandera=0 ORDER BY fecha_usuario desc, hora_usuario desc";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                            	<th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='200px'><div align='left'><a href='#' title='Ordenar por Cliente'>NOMBRE DEL CLIENTE</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Dirección'>DIRECCION DEL CLIENTE </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Nivel'>TELEFONO DE CLIENTE </a></div></th>	
								<th width='150px'><div align='left'><a href='#' title='Odenar por Nivel'>RESPONSABLE DE LA EMPRESA </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Nivel'>TELEFONO DEL RESPONSABLE </a></div></th>
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
		<td width='60px' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_cliente']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a>
		<a onClick='enviar(\"".$row['id_cliente']."\");' style='cursor:pointer' title='Modificar registro'><img src='../images/recovery.png' width='28px' height='28px'></a></td>	   
         
          <td width='auto' align='left'> $row[nom_cliente] </td>
		  <td width='auto' align='left'> $row[dir_cliente] </td>
		  <td width='auto' align='left'> $row[tel_cliente] </td>
		  <td width='auto' align='left'> $row[nom_responsable] $row[ape_responsable] </td>
		  <td width='auto' align='left'> $row[tel_responsable] </td>
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
</div>

<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->





<!--  INICIO FOOTER   -->

<?PHP include("footer.php"); ?>

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

</body> 
</html>
<?php 
 mysql_close($con);
?>