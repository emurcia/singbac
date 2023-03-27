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
  
 $peso_bruto_url= $_GET['peso_bruto'];
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
$fecha=date('d').'/'.date('m').'/'.date('Y');
$hora=date("H:i:s");
?>

<!DOCTYPE html> 
<html> 
<head>
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
			 "sScrollX":"100%"
    	 });
    	
});
</script>

<script type="text/javascript">
function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
function tara(cod){
		document.formulario.busca.value="tara";	
		document.formulario.cod_prod_modif.value=cod;
		document.formulario.action="http://localhost/bascula/?parametro="+cod+"&direccion=https://singbac.sigenesis.net/forms/f_bascula2.php";//capturar el Tara.

	//	document.formulario.action="http://192.168.178.161/bascula/?parametro="+cod+"&direccion=http://localhost/silos/forms/f_bascula2.php";//capturar el Tara.
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
	 
$usu_utilizado=mysql_query("SELECT * from tab_bascula where id_bascula='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']==0){ // no ha sido utilizado
		$lleno="0";
  }else{ // Posse datos
  	 	$lleno="1";
  }	 
	 
if ($lleno=="0"){
$resultado = eliminar_su("tab_bascula","id_bascula",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
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
<?PHP 
if($mensaje=="1"){
echo '<div class="alert alert-success">
 						  <a href="f_bascula_cola.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje=="2"){
echo '<div class="alert alert-danger">
 						  <a href="f_bascula_cola.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje=="3"){
echo '<div class="alert alert-danger">
 						  <a href="f_bascula_cola.php" class="alert-link"> El Usuario no se puede eliminar, ya realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
?>

 <form role="form" name="formulario"  method="post" action="f_bascula.php">
           <input type="hidden"  name="bandera" value="0">
 			<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif"> 

</form>              
<div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>VEHICULO EN COLA</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
<div>
<?php
$id_bas="BASC-0000000".$id_empresa;

$sql = "SELECT b.id_bascula, b.fecha_entrada, b.hora_entrada, b.entrada, b.peso_bruto, b.peso_tara,b.opcion_peso, b.fecha_usuario, b.hora_usuario,  c.nom_cliente, t.placa_vehiculo, t.nom_transportista, t.ape_transportista, p.nom_producto, sp.nom_subproducto, u.nombre_usuario FROM tab_bascula AS b JOIN tab_cliente AS c ON b.id_cliente=c.id_cliente JOIN tab_transportista AS t ON b.id_transportista=t.id_transportista JOIN tab_producto AS p ON b.id_producto=p.id_producto JOIN tab_subproducto AS sp ON b.id_subproducto=sp.id_subproducto JOIN t_usuarios AS u ON b.id_usuario2=u.id_usuario WHERE b.id_bascula!='$id_bas' and (b.opcion_peso=1 or b.opcion_peso=2) and b.id_empresa='$id_empresa' order by b.fecha_entrada desc, b.hora_entrada desc";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>   
     
                                
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='120px'><div align='left'><a href='#' title='Ordenar por Fecha'>FECHA</a></div></th>
                                <th width='125px'><div align='left'><a href='#' title='Odenar por Hora'>HORA </a></div></th>
								<th width='155px'><div align='left'><a href='#' title='Odenar por Comprobante'>COMPROBANTE </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Cliente'>CLIENTE </a></div></th>	
								<th width='150px'><div align='left'><a href='#' title='Odenar por Placa'>PLACA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Motorista'>MOTORISTA </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Producto'>PRODUCTO </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Subproducto'>SUBPRODUCTO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Bruto'>BRUTO (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Tara'>TARA (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Neto'>NETO (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Pesaje'>PESAJE REALIZADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>REALIZADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA CREADO</a></div></th>
								
	 
	    </tr>
        </thead>
        <tbody>";
		
		if ($result> 0){	
		while ($row = mysql_fetch_array($result)) 
		{
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);
			 $fecha_imprime2=parseDatePhp($row['fecha_usuario']);
			 $peso_bruto=number_format($row['peso_bruto'], 0, ".", ",");
			 $peso_tara=number_format($row['peso_tara'], 0, ".", ",");
			 $peso_neto1=$row['peso_bruto']-$row['peso_tara']; //Calcular el peso neto
			 $peso_neto =number_format($peso_neto1, 0, ".", ",");
			 $nom_empresa=$row['nom_cliente'];
			 $nom_producto=$row['nom_producto'];
			 $nom_subproducto=$row['nom_subproducto'];
			 $nom_transportista=$row['nom_transportista']." ".$row['ape_transportista'];
			 $placa=$row['placa_vehiculo'];
			 $nombre_usuario=$row['nombre_usuario'];
			 

			if($row['opcion_peso']==1)$peso="PESO BRUTO";
			if($row['opcion_peso']==2)$peso="PESO TARA";	 
				
											
		echo"<tr>
		<td width='60px' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_bascula']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a>
		<a onClick='tara(\"".$row['id_bascula']."\");' style='cursor:pointer' title='Completar Peso'><img src='../images/aceptar.png' width='28px' height='28px'></a></td>	   

          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>	
		  <td width='auto' align='left'> $row[entrada] </td>			  	  
		  <td width='auto' align='left'> $nom_empresa </td>
  		  <td width='auto' align='left'> $placa </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $nom_producto </td>
		  <td width='auto' align='left'> $nom_subproducto </td>
		  <td width='auto' align='left'> $peso_bruto </td>
		  <td width='auto' align='left'> $peso_tara </td>
		  <td width='auto' align='left'> $peso_neto </td>
		  <td width='auto' align='left'> $peso </td>		  
		  <td width='auto' align='left'> $nombre_usuario</td>	
		  <td width='auto' align='left'> $fecha_imprime2 </td>						  
		  <td width='auto' align='left'> $row[hora_usuario] </td>	  		  
		  
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
<?PHP include("footer.php");  ?>
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
<?PHP
  mysql_close($con);
?>