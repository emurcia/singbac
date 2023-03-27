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

function revertir_recepcion(cod){
		//document.formulario.busca.value="actualizartransportista";	
		document.formulario.r_recepcion.value=cod;
		document.formulario.action='f_revertir_recepcion.php';//redireccionar
		document.formulario.submit();
	}

function revertir_despacho(cod){
		//document.formulario.busca.value="actualizartransportista";	
		document.formulario.r_despacho.value=cod;
		document.formulario.action='f_revertir_despacho.php';//redireccionar
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
<form role="form" name="formulario"  method="post" action="f_reversion.php">
<input type="hidden" name="r_recepcion" value="">
<input type="hidden" name="r_despacho" value="">
<input type="hidden" name="bandera" value="0">
</form>
 <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>REVERSION DE TRANSACCIONES</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 
            <div class="row"><!-- INICIO ROW-->
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="nacional">Revertir</label><br>
                          
                          <label class="checkbox-inline">
                            <input type="radio" id="tipo_reversion" value="1" name="tipo_reversion" onclick="recepcion()" >  Recepción de Granos
                          </label>
                          <label class="checkbox-inline">
                          
                            <input type="radio" id="tipo_reversion" onclick="despacho()" value="2" name="tipo_reversion">  Despacho de Granos
                          </label>
                          </div>
                        </div>  
                  	</div> <!-- FIN ROW--> 

<div  style='display:none;' id="recepcion"> <!-- INICIA RECEPCION -->
<div class="row" >
<div class="col-md-12">
 	<div class="panel-heading bg-info"><strong>Recepción de Granos Básicos</strong></div> <!-- PANEL 1 --->  
      <div class="panel-body">
      
<?php
$id_almacen="ALMACEN-0000000".$id_empresa;
	 $sql = "SELECT * FROM tab_almacenaje WHERE id_almacenaje!='$id_almacen' and tipo_peso=2 and id_empresa='$id_empresa' order by fecha_entrada desc, hora_entrada desc ";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='50px'><div align='left'></div></th>
								<th width='100px'><div align='left'><a href='#' title='Ordenar por Control'>CONTROL</a></div></th>								
                                <th width='100px'><div align='left'><a href='#' title='Ordenar por Cliente'>FECHA</a></div></th>
                                <th width='125px'><div align='left'><a href='#' title='Odenar por Hora'>HORA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Cliente'>CLIENTE </a></div></th>	
								<th width='150px'><div align='left'><a href='#' title='Odenar por Placa'>PLACA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Motorista'>MOTORISTA </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Lote'>LOTE </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Silo'>SILO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Bruto'>BRUTO (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Tara'>TARA (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Neto'>NETO (KG) </a></div></th>
								
	    </tr>
        </thead>
        <tbody>";
		
		if ($result> 0){	
		while ($row = mysql_fetch_array($result)) 
		{
			 $id_empresa_busca=$row['id_cliente'];
			 $id_lote_busca=$row['id_lote'];
			 $id_silo_busca=$row['id_silo'];
			 $id_motorista_busca=$row['id_transportista'];
			 $usuario_busca=$row['id_usuario2'];
			 $usuario_modifica=$row['id_usuario_modifica'];	
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);
			 $peso_neto=$row['peso_bruto']-$row['peso_tara']; //Calcular el peso neto
			 $fecha_imprime2=parseDatePhp($row['fecha_usuario']);
			 $fecha_imprime_modif=parseDatePhp($row['fecha_modifica']);	

			if($row['opcion_peso']==1)$peso="PESO BRUTO";
			if($row['opcion_peso']==2)$peso="PESO TARA";	 
									
			$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa_busca' and id_empresa='$id_empresa'";
			$select2=mysql_query($tabla2,$con);
			while($row2=mysql_fetch_array($select2)) {
			$nom_empresa=$row2['nom_cliente'];
			}
				$tabla3="SELECT * FROM tab_lote WHERE id_lote='$id_lote_busca' and id_empresa='$id_empresa'";
				$select3=mysql_query($tabla3,$con);
				while($row3=mysql_fetch_array($select3)) {
				$num_lote=$row3['num_lote'];
				}
					$tabla4="SELECT * FROM tab_silo WHERE id_silo='$id_silo_busca' and id_empresa='$id_empresa'";
					$select4=mysql_query($tabla4,$con);
					while($row4=mysql_fetch_array($select4)) {
					$nom_silo=$row4['nom_silo'];
					}
						$tabla5="SELECT * FROM tab_transportista WHERE id_transportista='$id_motorista_busca' and id_empresa='$id_empresa'";
						$select5=mysql_query($tabla5,$con);
						while($row5=mysql_fetch_array($select5)) {
						$nom_transportista=$row5['nom_transportista']." ".$row5['ape_transportista'];
						$placa=$row5['placa_vehiculo'];
				
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
		<td width='60px' align='center'><a onClick='revertir_recepcion(\"".$row['id_almacenaje']."\");' style='cursor:pointer' title='Revertir entrada'><img src='../images/aceptar.png' width='28px' height='28px'></a></td>	   
          <td width='auto' align='center'> $row[entrada]</td>
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $nom_empresa </td>
  		  <td width='auto' align='left'> $placa </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $num_lote </td>
		  <td width='auto' align='left'> $nom_silo </td>
		  <td width='auto' align='left'> $row[peso_bruto] </td>
		  <td width='auto' align='left'> $row[peso_tara] </td>
		  <td width='auto' align='left'> $peso_neto </td>
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
</div> <!-- FIN DE RECEPCION -->
</div>

<div>
<div  style='display:none;' id="despacho"> <!-- INICIA DESPACHO -->
<div class="row" >
<div class="col-md-12">
 	<div class="panel-heading bg-info"><strong>Despacho de Granos Básicos</strong></div> <!-- PANEL 1 --->  
      <div class="panel-body" >
      
<?php
$id_salida="DESPACH-0000000".$id_empresa;
	 $sql = "SELECT * FROM tab_salida WHERE id_salida!='$id_salida' and tipo_peso=1 and id_empresa='$id_empresa' order by fecha_entrada desc, hora_entrada desc ";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones1' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='50px'><div align='left'></div></th>
								<th width='100px'><div align='left'><a href='#' title='Ordenar por Control'>CONTROL</a></div></th>								
                                <th width='100px'><div align='left'><a href='#' title='Ordenar por Cliente'>FECHA</a></div></th>
                                <th width='125px'><div align='left'><a href='#' title='Odenar por Hora'>HORA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Cliente'>CLIENTE </a></div></th>	
								<th width='150px'><div align='left'><a href='#' title='Odenar por Placa'>PLACA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Motorista'>MOTORISTA </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Lote'>LOTE </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Silo'>SILO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Bruto'>BRUTO (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Tara'>TARA (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Neto'>NETO (KG) </a></div></th>
								
	    </tr>
        </thead>
        <tbody>";
		
		if ($result> 0){	
		while ($row = mysql_fetch_array($result)) 
		{
			 $id_empresa_busca=$row['id_cliente'];
			 $id_lote_busca=$row['id_lote'];
			 $id_silo_busca=$row['id_silo'];
			 $id_motorista_busca=$row['id_transportista'];
			 $usuario_busca=$row['id_usuario2'];
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);
			 $peso_neto=$row['peso_bruto']-$row['peso_tara']; //Calcular el peso neto
			 
			if($row['opcion_peso']==1)$peso="PESO BRUTO";
			if($row['opcion_peso']==2)$peso="PESO TARA";	 
									
			$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa_busca' and id_empresa='$id_empresa'";
			$select2=mysql_query($tabla2,$con);
			while($row2=mysql_fetch_array($select2)) {
			$nom_empresa=$row2['nom_cliente'];
			}
				$tabla3="SELECT * FROM tab_lote WHERE id_lote='$id_lote_busca' and id_empresa='$id_empresa'";
				$select3=mysql_query($tabla3,$con);
				while($row3=mysql_fetch_array($select3)) {
				$num_lote=$row3['num_lote'];
				}
					$tabla4="SELECT * FROM tab_silo WHERE id_silo='$id_silo_busca' and id_empresa='$id_empresa'";
					$select4=mysql_query($tabla4,$con);
					while($row4=mysql_fetch_array($select4)) {
					$nom_silo=$row4['nom_silo'];
					}
						$tabla5="SELECT * FROM tab_transportista WHERE id_transportista='$id_motorista_busca' and id_empresa='$id_empresa'";
						$select5=mysql_query($tabla5,$con);
						while($row5=mysql_fetch_array($select5)) {
						$nom_transportista=$row5['nom_transportista']." ".$row5['ape_transportista'];
						$placa=$row5['placa_vehiculo'];
				
						}
		
		 
								
										
											
		echo"<tr>
		<td width='60px' align='center'><a onClick='revertir_despacho(\"".$row['id_salida']."\");' style='cursor:pointer' title='Revertir Salida'><img src='../images/aceptar.png' width='28px' height='28px'></a></td>	   
          <td width='auto' align='center'> $row[entrada]</td>
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $nom_empresa </td>
  		  <td width='auto' align='left'> $placa </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $num_lote </td>
		  <td width='auto' align='left'> $nom_silo </td>
		  <td width='auto' align='left'> $row[peso_bruto] </td>
		  <td width='auto' align='left'> $row[peso_tara] </td>
		  <td width='auto' align='left'> $peso_neto </td>
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
</div> <!-- FIN DE DESAPACHO -->


</div> 
</div> 
</div>
</div>
</div> <!-- FIN DEL CUERPO-->


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
	
