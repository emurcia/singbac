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

date_default_timezone_set("America/El_Salvador");
$fecha_entrada=date('d').'/'.date('m').'/'.date('Y');
$hora_entrada=date("H:i:s");
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

<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones1').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
    });
	</script>

<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
    }); 

function recepcion() //funcionar para activas las cajas de textos
  {
			document.getElementById('recepcion').style.display = 'block';//Mostrar contenido
			document.getElementById('despacho').style.display = 'none';//oculta contenido
	  
  }
function despacho() //funcionar para activas las cajas de textos
  {
			document.getElementById('despacho').style.display = 'block';//Mostrar contenido
			document.getElementById('recepcion').style.display = 'none';//oculta contenido	

  }

function ajustelote(cod){
		document.formulario.ajuste.value=cod;
		document.formulario.action='f_ajuste_lote.php';//redireccionar
		document.formulario.submit();
	}


function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
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
<form role="form" name="formulario"  method="post" action="f_ajuste.php">
<input type="hidden" name="ajuste" value="">
<input type="hidden" name="bandera" value="0">
</form>
 <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Ajuste de inventario</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           

<div>
<?php
$id_lot="LOT-000".$id_empresa;
$sql="SELECT l.id_lote, l.num_lote, l.fecha_usuario, l.hora_usuario, l.cant_producto, c.nom_cliente, s.nom_silo, o.nom_origen, pro.nom_producto, spro.nom_subproducto,  u.nombre_usuario FROM tab_lote as l, tab_cliente as c, tab_silo as s, tab_origen as o, tab_producto as pro, tab_subproducto as spro, t_usuarios as u WHERE l.id_lote!='$id_lot' and l.id_empresa='$id_empresa' and l.bandera=0 and l.id_cliente=c.id_cliente and l.id_silo=s.id_silo and l.id_origen=o.id_origen AND l.id_producto=pro.id_producto and l.id_subproducto=spro.id_subproducto and l.id_usuario2=u.id_usuario group by l.id_silo, l.id_producto, l.id_cliente, l.num_lote ORDER BY l.fecha_usuario desc, l.hora_usuario desc";
$result = mysql_query($sql, $con);

 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>   
							    <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='100px'><div align='left'><a href='#' title='Ordenar por Cliente'>LOTE</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Cliente'>CLIENTE </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Silo'>SILO </a></div></th>	
								<th width='150px'><div align='left'><a href='#' title='Odenar por Origen'>ORIGEN </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Producto'>PRODUCTO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Subproducto'>SUBPRODUCTO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Cantidad'>CANTIDAD (KG) </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>CREADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA CREADO</a></div></th>
													
        </tr>
        </thead>
        <tbody>";

			if ($result > 0){	
		    $correlativo = 1;
			$contar2++;
		while ($row = mysql_fetch_assoc($result)) 
                            {	
							 $fecha_imprime=parseDatePhp($row['fecha_usuario']);
							 $cant_dos=number_format($row['cant_producto'], 2, ".", ",");
											
		echo"<tr>
		<td width='60px' align='center'><a onClick='ajustelote(\"".$row['id_lote']."\");' style='cursor:pointer' title='Ajustar inventario'><img src='../images/aceptar.png' width='28px' height='28px'></a>
		</td>	   
         
         <td width='auto' align='left'> $row[num_lote]</td>
		  <td width='auto' align='left'> $row[nom_cliente] </td>
 		  <td width='auto' align='left'> $row[nom_silo] </td>
		  <td width='auto' align='left'> $row[nom_origen] </td>
		  <td width='auto' align='left'> $row[nom_producto] </td>
		  <td width='auto' align='left'> $row[nom_subproducto] </td>		  
		  <td width='auto' align='left'> $cant_dos</td>	
		  <td width='auto' align='left'> $row[nombre_usuario]</td>	
		  <td width='auto' align='left'> $fecha_imprime </td>						  
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
</div>  <!--- FIN LOTES ACTIVOS -->


<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->

<!--  INICIO FOOTER   -->
<?PHP include("footer.php"); ?>
<!-- FIN FOOTER  -->

</body> 
</html>
<?PHP mysql_close(); ?>
	
