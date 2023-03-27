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
			"sProcessing": true,
    		"sPaginationType": "full_numbers",
			 
			"sScrollX": "100%"
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
		document.formulario.busca.value="actualizartransportista";	
		document.formulario.cod_prod_modif.value=cod;
		document.formulario.action='f_mod_transportistas.php';//redireccionar a musuario.php
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
	 
$prod_utilizado=mysql_query("SELECT * from tab_transportista where id_transportista='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI YA TIENE DATOS
$prod_utilizado2 = mysql_fetch_array($prod_utilizado);
if($prod_utilizado2['ocupado']=="0"){ // no ha sido utilizado
		$lleno="0";
  }else{ // Posse datos
  	 	$lleno="1";
  }	 
	 
	 
if ($lleno=="0"){
$resultado = eliminar_su("tab_transportista","id_transportista",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
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
<body class="container" onLoad="document.formulario.dpi_transportista.focus();"> 

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
$Result1 = mysql_query("SELECT MAX(id_transportista) as a  FROM tab_transportista WHERE id_empresa='$id_empresa' ORDER BY id_transportista") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],6,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "TRANS-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "TRANS-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "TRANS-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "TRANS-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "TRANS-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "TRANS-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "TRANS-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}

// INICIA EL GUARDADO DE INFORMACION 
		 $bandera = $_POST['bandera'];
 		 $id1= strtoupper($_POST["id_transportista"]);
		 $dpi1=$_POST["dpi_transportista"];
	     $ape1  = strtoupper($_POST["ape_transportista"]);
	     $nom1  = strtoupper($_POST["nom_transportista"]);		 
	     $dir1 = strtoupper($_POST["dir_transportista"]);
	     $tel1 = ($_POST["tel_transportista"]);
		 $placa1=strtoupper($_POST["placa_vehiculo"]);
		 $color1=strtoupper($_POST["color_vehiculo"]);
		
		 
		  if($_POST["capacidad_vehiculo"]==""){$cap1="0.00";} else{ $cap1=($_POST["capacidad_vehiculo"]);	 } 
		 $obs1=strtoupper($_POST["obs_vehiculo"]);	
		 $id_cliente1=$_POST["id_cliente"];		 		 	
	    			
if($pingresar=="1"){	
 if($bandera=="ok")
   {//inicio if bandera ok
    if($id_cliente1=="0") {
		echo '<div class="alert alert-warning alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Adventencia!</strong> Seleccione Cliente
		</div>';
		} else{
		$correo_utilizado=mysql_query("SELECT count(*) as existe from tab_transportista where ape_transportista='$ape1' and nom_transportista='$nom1' and id_empresa='$id_empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$correo_utilizado2 = mysql_fetch_array($correo_utilizado);
if($correo_utilizado2['existe']!="0"){ // no ha sido utilizado
	$error="5"; // Correo ya existe
  }else{ // Posse datos
      		mysql_query("insert into tab_transportista(id_transportista, dpi_transportista, ape_transportista, nom_transportista, dir_transportista, tel_transportista, placa_vehiculo, color_vehiculo, cap_vehiculo, obs_vehiculo, id_cliente, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values('$id1', '$dpi1', '$ape1' , '$nom1', '$dir1', '$tel1', '$placa1', '$color1', '$cap1', '$obs1', '$id_cliente1', '$id_empresa', '$id_usuario',0, '$fecha_entrada',  '$hora_entrada', '$id_usuario', '$fecha_entrada', '$hora_entrada')",$con);     
			   
			if(mysql_error())
		  { 
			$error="1"; // error en datos
		  }
			  else
		     $error="2"; // datos almacenados
					  
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
 			<a href="f_transportistas.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == "2")
 {
	 $act= ("UPDATE tab_cliente SET ocupado=1 WHERE id_cliente='$id_cliente1' and id_empresa='$id_empresa'");
	 mysql_query($act,$con);
	 echo '<div class="alert alert-success">
 						  <a href="f_transportistas.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }
	  
if($mensaje=="1"){
echo '<div class="alert alert-success">
 						  <a href="f_transportistas.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje=="2"){
echo '<div class="alert alert-danger">
 						  <a href="f_transportistas.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje=="3"){
echo '<div class="alert alert-danger">
 						  <a href="f_transportistas.php" class="alert-link"> El Usuario no se puede eliminar, ya realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
if($error=="4"){
echo '<div class="alert alert-danger">
 						  <a href="f_transportistas.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';

}
if($error=="5"){
echo '<div class="alert alert-danger">
 						  <a href="f_transportistas.php" class="alert-link"> Piloto ya existe!!!</a>
						  </div>';

}
?>
           <div class="container-fluid">
  <div class="row" >
  
 <div class="container-fluid">
  <div class="row" >
     <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Registro de transportistas</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           <form role="form" name="formulario"  method="post" action="f_transportistas.php">
           <input type="hidden"  name="bandera" value="0">
           <input type="hidden"  name="busca">
           <input type="hidden" name="cod_prod_eliminar"> 
           <input type="hidden" name="cod_prod_modif"> 
              <div class="row"><!--- INICIO ROW----->
            
          <div class="col-md-12">
          <div class="form-group">
          		<label for="nombre_producto">Código del Transportista</label>
            	<input type="text" class="form-control input-lg" value="<?PHP echo $nu;?>"  style="background:#FFF" readonly  name="id_transportista" id="id_transportista" autocomplete="off">
            </div>
          </div>
          
          </div><!--- FIN ROW-----> 
          <div class="panel-heading bg-info"><strong>Datos Motorista</strong></div> <!-- PANEL 1 ---> 
          <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="cliente"> Cliente ó Empresa</label>
                         <?php
						 $id_cli="CLI-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente!='$id_cli' and id_empresa='$id_empresa' and bandera=0");
						  ?>
                      <select name="id_cliente" class="form-control input-lg chosen" size="1" id="id_cliente">
                            <option value="0">SELECCIONE CLIENTE / EMPRESA </option>
							 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_cliente= $valor['id_cliente'];
									$nombre_cliente= $valor["nom_cliente"];
									echo "<option value='$codigo_cliente'>";
									echo ("$nombre_cliente");
									echo"</option>";
								}	
							?>
                    </select>
                              
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
		 <br>	


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
                <input type="checkbox" value="" onclick="activar_textos()">Desea Agregar Datos del Vehiculo </label>
          </div>
          
                         
          <div  style='display:none;' id="formulario_responsable">
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
             <textarea name="obs_vehiculo" class="form-control" rows="3" style="text-transform:uppercase;" placeholder="Observaciones del vehiculo" autocomplete="off" id="obs_vehiculo"><?PHP echo $obs1; ?> </textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
               
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
</div> <!-- Inicia paginacion -->


   <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Transportistas</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           

<div>
<?php
	$nivel_busca="";
	$usuario_busca="";
	$id_trans="TRANS-0000000".$id_empresa;
	// $sql = "SELECT * FROM tab_transportista WHERE id_transportista!='$id_trans' and id_empresa='$id_empresa' ORDER BY fecha_usuario desc, hora_usuario desc";
	$sql="SELECT t.id_transportista, CONCAT(t.nom_transportista,' ',t.ape_transportista) as piloto, t.tel_transportista, t.placa_vehiculo, t.cap_vehiculo, t.id_usuario_modifica, t.fecha_usuario, t.hora_usuario, t.fecha_modifica, t.hora_modifica, c.nom_cliente, c.tel_cliente, u.nombre_usuario as usuario1 FROM tab_transportista as t, tab_cliente as c, t_usuarios as u WHERE  c.id_cliente= t.id_cliente AND u.id_usuario=t.id_usuario2 AND t.id_transportista!='$id_trans' and t.id_empresa='$id_empresa' ORDER BY t.fecha_usuario desc, t.hora_usuario desc";
 	 $result = mysql_query($sql,$con);
				
echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='200px'><div align='left'><a href='#' title='Ordenar por Nombre'>NOMBRE MOTORISTA</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Teléfono'>TELEFONO </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Placa'>PLACA VEHICULO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Capacidad'>CAPACIDAD (TONELADAS)</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Empresa'>EMPRESA</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Tel. empresa'>TELEFONO EMPRESA</a></div></th>
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
						//	 $usuario_busca=$row['id_usuario2'];
							 $usuario_modifica=$row['id_usuario_modifica'];
						//	 $id_cliente_buscar=$row['id_cliente'];							 
							 $fecha_imprime=parseDatePhp($row[fecha_usuario]);
							 $fecha_imprime_modif=parseDatePhp($row[fecha_modifica]);
							 	
															 
			//				 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_busca' and id_empresa='$id_empresa'";
				//				$result_us = mysql_query($sql_usuario,$con);
				//				if ($result_us > 0){	
                //               		while ($row_usuario = mysql_fetch_assoc($result_us)){
				//					 $nombre_usuario=$row_usuario['nombre_usuario'];
				//					}
				//				}
								
								 $sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_modifica' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario_modif=$row_usuario['nombre_usuario'];
									}
								}
				/*				
								$sql_cliente = "SELECT * FROM tab_cliente WHERE id_cliente='$id_cliente_buscar' and id_empresa='$id_empresa'";
								$result_cli = mysql_query($sql_cliente,$con);
								if ($result_cli > 0){	
                               		while ($row_cliente = mysql_fetch_assoc($result_cli)){
									 $nom_empresa=$row_cliente['nom_cliente'];
									 $tel_empresa=$row_cliente['tel_cliente'];
									}
								}
				*/
		echo"<tr>
		<td width='60px' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_transportista']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a>
		<a onClick='enviar(\"".$row['id_transportista']."\");' style='cursor:pointer' title='Modificar registro'><img src='../images/recovery.png' width='28px' height='28px'></a></td>	   
         
          <td width='auto' align='left'> $row[piloto]</td>
		  <td width='auto' align='left'> $row[tel_transportista]</td>
 		  <td width='auto' align='left'> $row[placa_vehiculo]</td>
		  <td width='auto' align='left'> $row[cap_vehiculo]</td>		  
		  <td width='auto' align='left'> $row[nom_cliente]</td>
		  <td width='auto' align='left'> $row[tel_cliente]</td>	
		  <td width='auto' align='left'> $row[usuario1] </td>	
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

<!--------------------FIN VENTANA 4-------------------->

</body> 
</html>
<?php 
  mysql_close();
?>