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
    	$('#tblInstituciones2').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
    });
	</script> 
<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones3').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
    });
	</script> 

<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones4').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
    });
	</script>   

<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones5').dataTable( {
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
			document.getElementById('bascula').style.display = 'none';//oculta contenido	
			document.getElementById('despacho').style.display = 'none';//oculta contenido
			document.getElementById('reversion').style.display = 'none';//oculta contenido	
			document.getElementById('reversion_sali').style.display = 'none';//oculta contenido	
			document.getElementById('ajuste').style.display = 'none';//oculta contenido									
  }
function despacho() //funcionar para activas las cajas de textos
  {
			document.getElementById('despacho').style.display = 'block';//Mostrar contenido
			document.getElementById('bascula').style.display = 'none';//oculta contenido	
			document.getElementById('recepcion').style.display = 'none';//oculta contenido
			document.getElementById('reversion').style.display = 'none';//oculta contenido	
			document.getElementById('reversion_sali').style.display = 'none';//oculta contenido	
			document.getElementById('ajuste').style.display = 'none';//oculta contenido										
  }

function bascula() //funcionar para activas las cajas de textos
  {
			document.getElementById('bascula').style.display = 'block';//Mostrar contenido
			document.getElementById('despacho').style.display = 'none';//oculta contenido	
			document.getElementById('recepcion').style.display = 'none';//oculta contenido	
			document.getElementById('reversion').style.display = 'none';//oculta contenido	
			document.getElementById('reversion_sali').style.display = 'none';//oculta contenido	
			document.getElementById('ajuste').style.display = 'none';//oculta contenido													
	} 

function reversion() //funcionar para activas las cajas de textos
  {
			document.getElementById('reversion').style.display = 'block';//Mostrar contenido
			document.getElementById('despacho').style.display = 'none';//oculta contenido	
			document.getElementById('recepcion').style.display = 'none';//oculta contenido	
			document.getElementById('bascula').style.display = 'none';//oculta contenido	
			document.getElementById('reversion_sali').style.display = 'none';//oculta contenido	
			document.getElementById('ajuste').style.display = 'none';//oculta contenido													
	}

function reversion_sali() //funcionar para activas las cajas de textos
  {
			document.getElementById('reversion_sali').style.display = 'block';//Mostrar contenido		  
			document.getElementById('reversion').style.display = 'none';//oculta contenido
			document.getElementById('despacho').style.display = 'none';//oculta contenido	
			document.getElementById('recepcion').style.display = 'none';//oculta contenido	
			document.getElementById('bascula').style.display = 'none';//oculta contenido
			document.getElementById('ajuste').style.display = 'none';//oculta contenido					
	} 	 	 

function ajuste() //funcionar para activas las cajas de textos
  {
			document.getElementById('ajuste').style.display = 'block';//Mostrar contenido		  
			document.getElementById('reversion').style.display = 'none';//oculta contenido
			document.getElementById('despacho').style.display = 'none';// contenido	
			document.getElementById('recepcion').style.display = 'none';//oculta contenido	
			document.getElementById('bascula').style.display = 'none';//oculta contenido
			document.getElementById('reversion_sali').style.display = 'none';//oculta contenido					
	} 

function comprobante_recepcion(cod){
		document.formulario.r_recepcion.value=cod;
		window.open('../reportes/Rp_comprobante_recepcion.php?id='+document.formulario.r_recepcion.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
		

if (window.confirm("Desea imprimir indicadores de calidad?")) { 
  window.open('../reportes/Rp_comprobante_calidad.php?id='+document.formulario.r_recepcion.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');

}		
	} 

function comprobante_despacho(cod_despacho){
		document.formulario.r_despacho.value=cod_despacho;
		window.open('../reportes/Rp_comprobante_despacho.php?id='+document.formulario.r_despacho.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
	}

function comprobante_bascula(cod_bascula){
		document.formulario.r_bascula.value=cod_bascula;
		window.open('../reportes/Rp_comprobante_bascula.php?id='+document.formulario.r_bascula.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
	}

function comprobante_reversion(cod_reversion){
		document.formulario.r_reversion.value=cod_reversion;
		window.open('../reportes/Rp_comprobante_reversion.php?id='+document.formulario.r_reversion.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
	}		

function comprobante_reversion_sali(cod_reversion_sali){
		document.formulario.r_reversion_sali.value=cod_reversion_sali;
		window.open('../reportes/Rp_comprobante_reversion_salida.php?id='+document.formulario.r_reversion_sali.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
	}

function ajuste_reporte(cod_ajuste){
		document.formulario.r_ajuste.value=cod_ajuste;
		window.open('../reportes/Rp_comprobante_ajuste.php?id='+document.formulario.r_ajuste.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
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
<form role="form" name="formulario"  method="post" action="f_comprobantes.php">
<input type="hidden" name="r_recepcion" value="">
<input type="hidden" name="r_despacho" value="">
<input type="hidden" name="r_bascula" value="">
<input type="hidden" name="r_reversion" value="">
<input type="hidden" name="r_reversion_sali" value="">
<input type="hidden" name="r_ajuste" value="">
<input type="hidden" name="bandera" value="0">
</form>
 <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>COMPROBANTE DE TRANSACCIONES</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 
            <div class="row"><!-- INICIO ROW-->
                    <div class="col-md-12">
                        <div class="form-group">
                          <label for="nacional">Servicios</label><br>
                          <label class="checkbox-inline">
                            <input type="radio" id="tipo_comprobante" value="1" name="tipo_comprobante" onclick="recepcion()" >  Recepción de granos
                          </label>
                          <label class="checkbox-inline">
                          <input type="radio" id="tipo_comprobante" onclick="despacho()" value="2" name="tipo_comprobante">  Despacho de granos
                          </label>
                          <label class="checkbox-inline">
                          <input type="radio" id="tipo_comprobante" onclick="bascula()" value="3" name="tipo_comprobante">  Servicio de báscula
                          </label>
                            <label class="checkbox-inline">
                          <input type="radio" id="tipo_comprobante" onclick="reversion()" value="4" name="tipo_comprobante">  Reversion de recepción
                          </label>
                           <label class="checkbox-inline">
                          <input type="radio" id="tipo_comprobante" onclick="reversion_sali()" value="5" name="tipo_comprobante">  Reversion de despacho
                          </label>
                          <label class="checkbox-inline">
                          <input type="radio" id="tipo_comprobante" onclick="ajuste()" value="6" name="tipo_comprobante">  Ajuste de inventario
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
$sql="SELECT a.id_almacenaje, a.entrada, a.fecha_entrada, a.hora_entrada, a.peso_bruto, a.peso_tara, l.num_lote, c.nom_cliente, s.nom_silo, t.placa_vehiculo, t.nom_transportista, t.ape_transportista FROM tab_almacenaje as a, tab_lote as l, tab_cliente as c, tab_silo as s, tab_transportista as t WHERE a.id_almacenaje!='$id_almacen' AND a.id_empresa='$id_empresa' and a.id_cliente=c.id_cliente and a.id_silo=s.id_silo and a.id_lote=l.id_lote and a.id_transportista=t.id_transportista GROUP BY a.fecha_entrada desc, a.hora_entrada desc ";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='50px'><div align='left'></div></th>
								<th width='100px'><div align='left'><a href='#' title='Ordenar por Control'>CONTROL</a></div></th>								
                                <th width='150px'><div align='left'><a href='#' title='Ordenar por Cliente'>FECHA</a></div></th>
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
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);
			 $nom_transportista=$row['nom_transportista']." ".$row['ape_transportista'];
			 $peso_neto_entrada=number_format(($row['peso_bruto']-$row['peso_tara']),0, ".",","); //Calcular el peso neto
			 $peso_tara_entrada=number_format($row['peso_tara'], 0, ".", ",");
			 $peso_bruto_entrada=number_format($row['peso_bruto'], 0, ".", ",");
				
		echo"<tr>
		<td width='60px' align='center'><a onClick='comprobante_recepcion(\"".$row['id_almacenaje']."\");' style='cursor:pointer' title='Imprimir Reporte'><img src='../images/impresora.png' width='28px' height='28px'></a></td>	   
          <td width='auto' align='center'> $row[entrada]</td>
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $row[nom_cliente] </td>
  		  <td width='auto' align='left'> $row[placa_vehiculo] </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $row[num_lote] </td>
		  <td width='auto' align='left'> $row[nom_silo] </td>
		  <td width='auto' align='left'> $peso_bruto_entrada </td>
		  <td width='auto' align='left'> $peso_tara_entrada </td>
		  <td width='auto' align='left'> $peso_neto_entrada </td>
		</tr>";
		$contar++;
		}
			
		$correlativo++;		

		echo"</tbody></table>";
}
	?>
    <!--Fin si se ha seleccionado administrador-->

<?php
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
$sql_salida = "SELECT a.id_salida, a.entrada, a.fecha_entrada, a.hora_entrada, a.peso_bruto, a.peso_tara, l.num_lote, c.nom_cliente, s.nom_silo, t.placa_vehiculo, t.nom_transportista, t.ape_transportista FROM tab_salida as a, tab_lote as l, tab_cliente as c, tab_silo as s, tab_transportista as t WHERE a.id_salida!='$id_salida' AND a.id_empresa='$id_empresa' and a.id_cliente=c.id_cliente and a.id_silo=s.id_silo and a.id_lote=l.id_lote and a.id_transportista=t.id_transportista GROUP BY a.fecha_entrada desc, a.hora_entrada desc";
 	 $result_salida = mysql_query($sql_salida,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones1' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='50px'><div align='left'></div></th>
								<th width='100px'><div align='left'><a href='#' title='Ordenar por Control'>CONTROL</a></div></th>								
                                <th width='150px'><div align='left'><a href='#' title='Ordenar por Cliente'>FECHA</a></div></th>
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
		
		if ($result_salida> 0){	
		while ($row_salida = mysql_fetch_array($result_salida)) 
		{
			 $fecha_imprime_salida=parseDatePhp($row_salida['fecha_entrada']);
			 $nom_transportista_salida=$row_salida['nom_transportista']." ".$row_salida['ape_transportista'];
			 $peso_neto_salida=number_format(($row_salida['peso_bruto']-$row_salida['peso_tara']),0, ".",",");
			 $peso_tara_salida=number_format($row_salida['peso_tara'], 0, ".", ",");
			 $peso_bruto_salida=number_format($row_salida['peso_bruto'], 0, ".", ",");
				
		echo"<tr>
		<td width='60px' align='center'><a onClick='comprobante_despacho(\"".$row_salida['id_salida']."\");' style='cursor:pointer' title='Imprimir Reporte'><img src='../images/impresora.png' width='28px' height='28px'></a></td>	   
          <td width='auto' align='center'> $row_salida[entrada]</td>
          <td width='auto' align='left'> $fecha_imprime_salida</td>
		  <td width='auto' align='left'> $row_salida[hora_entrada] </td>		  
		  <td width='auto' align='left'> $row_salida[nom_cliente] </td>
  		  <td width='auto' align='left'> $row_salida[placa_vehiculo] </td>	
 		  <td width='auto' align='left'> $nom_transportista_salida </td>
		  <td width='auto' align='left'> $row_salida[num_lote] </td>
		  <td width='auto' align='left'> $row_salida[nom_silo] </td>
		  <td width='auto' align='left'> $peso_bruto_salida </td>
		  <td width='auto' align='left'> $peso_tara_salida </td>
		  <td width='auto' align='left'> $peso_neto_salida </td>
		</tr>";
		$contar_salida++;
		}
		$correlativo++;		
		echo"</tbody></table>";
}
	?>
    <!--Fin si se ha seleccionado administrador-->

<?php
echo "Total de Registros" ." ".$contar_salida;
?>
</div>
</div>
</div>
</div> <!-- FIN DE DESAPACHO -->
</div>

<div>
<div  style='display:none;' id="bascula"> <!-- INICIA BASCULA -->
<div class="row" >
<div class="col-md-12">
 	<div class="panel-heading bg-info"><strong>Servicio de Báscula</strong></div> <!-- PANEL 1 --->  
      <div class="panel-body" >
      
<?php
$id_bas="BASC-0000000".$id_empresa;
$sql_bascula = "SELECT a.*, c.nom_cliente, t.placa_vehiculo, t.nom_transportista, t.ape_transportista, p.nom_producto FROM tab_bascula as a, tab_cliente as c, tab_transportista as t, tab_producto as p WHERE  a.id_bascula!='$id_bas' and (a.opcion_peso=3 or a.opcion_peso=4) and a.id_empresa='$id_empresa' and a.id_producto=p.id_producto and a.id_cliente=c.id_cliente and a.id_transportista=t.id_transportista GROUP BY a.fecha_entrada desc, a.hora_entrada desc  ";
 	 $result_bascula = mysql_query($sql_bascula,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones2' >";
                    
                        echo"<thead>                      
                              <tr>   
     							<th width='50px'><div align='left'></div></th>
								<th width='100px'><div align='left'><a href='#' title='Ordenar por Control'>CONTROL</a></div></th>	
                                <th width='150px'><div align='left'><a href='#' title='Ordenar por Fecha'>FECHA</a></div></th>
                                <th width='125px'><div align='left'><a href='#' title='Odenar por Hora'>HORA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Cliente'>CLIENTE </a></div></th>	
								<th width='150px'><div align='left'><a href='#' title='Odenar por Placa'>PLACA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Motorista'>MOTORISTA </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Producto'>PRODUCTO </a></div></th>
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
		
		if ($result_bascula> 0){	
		while ($row_bascula = mysql_fetch_array($result_bascula)) 
		{
			 $usuario_busca=$row_bascula['id_usuario2'];
			 $usuario_modifica=$row_bascula['id_usuario_modifica'];	
			 $fecha_imprime=parseDatePhp($row_bascula['fecha_entrada']);
			 $fecha_imprime2=parseDatePhp($row_bascula['fecha_usuario']);
			 $fecha_imprime_modif=parseDatePhp($row_bascula['fecha_modifica']);	
			 $nom_transportista_bascula=$row_bascula['nom_transportista']." ".$row_bascula['ape_transportista'];
			 
			 $peso_neto_bascula=number_format(($row_bascula['peso_bruto']-$row_bascula['peso_tara']),0, ".",",");
			 $peso_tara_bascula=number_format($row_bascula['peso_tara'], 0, ".", ",");
			 $peso_bruto_bascula=number_format($row_bascula['peso_bruto'], 0, ".", ",");
	
			if($row_bascula['opcion_peso']==3)$peso="PESO UNICO";
			if($row_bascula['opcion_peso']==4)$peso="PESO COMPLETO";	 
	
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
		<td width='60px' align='center'><a onClick='comprobante_bascula(\"".$row_bascula['id_bascula']."\");' style='cursor:pointer' title='Revertir entrada'><img src='../images/impresora.png' width='28px' height='28px'></a></td>
	  	  <td width='auto' align='center'> $row_bascula[entrada] </td>
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row_bascula[hora_entrada] </td>		  
		  <td width='auto' align='left'> $row_bascula[nom_cliente] </td>
  		  <td width='auto' align='left'> $row_bascula[placa_vehiculo] </td>	
 		  <td width='auto' align='left'> $nom_transportista_bascula </td>
		  <td width='auto' align='left'> $row_bascula[nom_producto] </td>
		  <td width='auto' align='left'> $peso_bruto_bascula </td>
		  <td width='auto' align='left'> $peso_tara_bascula </td>
		  <td width='auto' align='left'> $peso_neto_bascula </td>
		  <td width='auto' align='left'> $peso </td>		  
		  <td width='auto' align='left'> $nombre_usuario</td>	
		  <td width='auto' align='left'> $fecha_imprime2 </td>						  
		  <td width='auto' align='left'> $row_bascula[hora_usuario] </td>	  		  
		  
		</tr>";
		$contar_bascula++;
		}
			
		$correlativo++;		
		echo"</tbody></table>";
}
	?>
    <!--Fin si se ha seleccionado administrador-->

<?PHP
echo "Total de Registros" ." ".$contar_bascula;
?>
         </div>
</div>
</div>
</div> <!-- FIN DE BASCULA -->
</div>

<div  style='display:none;' id="reversion"> <!-- INICIA REVERSION -->
<div class="row" >
<div class="col-md-12">
 	<div class="panel-heading bg-info"><strong>Reversión de recepción de Granos Básicos</strong></div> <!-- PANEL 1 --->  
      <div class="panel-body">
      
<?php
$sql = "SELECT a.id_reversion, a.entrada, a.fecha_entrada, a.hora_entrada, a.peso_bruto, a.peso_tara, l.num_lote, c.nom_cliente, s.nom_silo, t.placa_vehiculo, t.nom_transportista, t.ape_transportista FROM tab_reversion as a, tab_lote as l, tab_cliente as c, tab_silo as s, tab_transportista as t WHERE a.tipo_reversion='1' AND a.id_empresa='$id_empresa' and a.id_cliente=c.id_cliente and a.id_silo=s.id_silo and a.id_lote=l.id_lote and a.id_transportista=t.id_transportista GROUP BY a.fecha_revierte desc, a.hora_revierte desc";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones3' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='50px'><div align='left'></div></th>
								<th width='100px'><div align='left'><a href='#' title='Ordenar por Control'>CONTROL</a></div></th>								
                                <th width='150px'><div align='left'><a href='#' title='Ordenar por Cliente'>FECHA</a></div></th>
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
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);
			 $nom_transportista=$row['nom_transportista']." ".$row['ape_transportista'];
			 $peso_neto_entrada=number_format(($row['peso_bruto']-$row['peso_tara']),0, ".",","); //Calcular el peso neto
			 $peso_tara_entrada=number_format($row['peso_tara'], 0, ".", ",");
			 $peso_bruto_entrada=number_format($row['peso_bruto'], 0, ".", ",");
				
		echo"<tr>
		<td width='60px' align='center'><a onClick='comprobante_reversion(\"".$row['id_reversion']."\");' style='cursor:pointer' title='Imprimir Reporte'><img src='../images/impresora.png' width='28px' height='28px'></a></td>	   
          <td width='auto' align='center'> $row[entrada]</td>
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $row[nom_cliente] </td>
  		  <td width='auto' align='left'> $row[placa_vehiculo] </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $row[num_lote] </td>
		  <td width='auto' align='left'> $row[nom_silo] </td>
		  <td width='auto' align='left'> $peso_bruto_entrada </td>
		  <td width='auto' align='left'> $peso_tara_entrada </td>
		  <td width='auto' align='left'> $peso_neto_entrada </td>
		</tr>";
		$contar++;
		$contarrever++;
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

echo "Total de Registros" ." ".$contarrever;
 
?>
         </div>
</div>
</div>
</div> <!-- FIN DE REVERSION -->
</div>
<div  style='display:none;' id="reversion_sali"> <!-- INICIA REVERSION -->
<div class="row" >
<div class="col-md-12">
 	<div class="panel-heading bg-info"><strong>Reversión de Despacho de Granos Básicos</strong></div> <!-- PANEL 1 --->  
      <div class="panel-body">
      
<?php
//$id_almacen="ALMACEN-0000000".$id_empresa;
	 $sql = "SELECT * FROM tab_reversion WHERE tipo_reversion=2 and id_empresa='$id_empresa' order by fecha_revierte desc, hora_revierte desc ";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones4' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='50px'><div align='left'></div></th>
								<th width='100px'><div align='left'><a href='#' title='Ordenar por Control'>CONTROL</a></div></th>								
                                <th width='150px'><div align='left'><a href='#' title='Ordenar por Cliente'>FECHA</a></div></th>
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
		<td width='60px' align='center'><a onClick='comprobante_reversion_sali(\"".$row['id_reversion']."\");' style='cursor:pointer' title='Imprimir Reporte'><img src='../images/impresora.png' width='28px' height='28px'></a></td>	   
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
		$contarreversal++;
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

echo "Total de Registros" ." ".$contarreversal;
 
?>
         </div>
</div>
</div>
</div> <!-- FIN DE RECEPCION -->
</div>
<div>
<div  style='display:none;' id="ajuste"> <!-- INICIA AJUSTE -->
<div class="row" >
<div class="col-md-12">
 	<div class="panel-heading bg-info"><strong>Ajuste de Inventario</strong></div> <!-- PANEL 1 --->  
      <div class="panel-body">
      
<?php
$tabla_extrae="SELECT a.*, l.num_lote, c.nom_cliente, s.nom_silo, pro.nom_producto FROM tab_ajuste as a, tab_lote as l, tab_cliente as c, tab_silo as s, tab_producto as pro, tab_subproducto as spro WHERE a.id_empresa='$id_empresa' and a.id_cliente=c.id_cliente and a.id_silo=s.id_silo and a.id_lote=l.id_lote and l.id_producto=pro.id_producto GROUP BY a.fecha_usuario_ajuste desc, hora_usuario_ajuste desc ";
$select_extrae = mysql_query($tabla_extrae,$con);

echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones5' >";
                    
                        echo"<thead>                     
                              <tr>   
     							<th width='50px'><div align='left'></div></th>
								<th width='100px'><div align='left'><a href='#' title='Ordenar por Control'>CONTROL</a></div></th>								
                                <th width='150px'><div align='left'><a href='#' title='Ordenar por Cliente'>FECHA</a></div></th>
                                <th width='125px'><div align='left'><a href='#' title='Odenar por Hora'>HORA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Cliente'>CLIENTE </a></div></th>	
								<th width='250px'><div align='left'><a href='#' title='Odenar por Producto'>PRODUCTO </a></div></th>	
								<th width='200px'><div align='left'><a href='#' title='Odenar por Lote'>LOTE </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Silo'>SILO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Bruto'>BRUTO (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Tara'>TARA (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Neto'>NETO (KG) </a></div></th>
								
	    </tr>
        </thead>
        <tbody>";
		
		if ($result> 0){	
		while($row_extrae = mysql_fetch_array($select_extrae))
			{
				 $fecha_imprime_ajuste=parseDatePhp($row_extrae['fecha_usuario_ajuste']);
				 $nuevo_peso_bruto=number_format($row_extrae[nuevo_peso_bruto],2,".",",");
				 $nuevo_peso_tara=number_format($row_extrae[nuevo_peso_tara],2,".",",");
				 $peso_neto_ajuste=number_format(($row_extrae[nuevo_peso_bruto]-$row_extrae[nuevo_peso_tara]),2,".",",");
		echo"<tr>
		<td width='60px' align='center'><a onClick='ajuste_reporte(\"".$row_extrae['id_ajuste']."\");' style='cursor:pointer' title='Imprimir Reporte'><img src='../images/impresora.png' width='28px' height='28px'></a></td>	   
          <td width='auto' align='center'> $row_extrae[entrada]</td>
          <td width='auto' align='left'> $fecha_imprime_ajuste</td>
		  <td width='auto' align='left'> $row_extrae[hora_usuario_ajuste] </td>		  
		  <td width='auto' align='left'> $row_extrae[nom_cliente] </td>
		  <td width='auto' align='left'> $row_extrae[nom_producto] </td>		  
		  <td width='auto' align='left'> $row_extrae[num_lote] </td>
		  <td width='auto' align='left'> $row_extrae[nom_silo] </td>
		  <td width='auto' align='left'> $nuevo_peso_bruto </td>
		  <td width='auto' align='left'> $nuevo_peso_tara </td>
		  <td width='auto' align='left'> $peso_neto_ajuste </td>
		</tr>";
		$contarajuste++;
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

echo "Total de Registros" ." ".$contarajuste;
 
?>
         </div>
</div>
</div>
</div> <!-- FIN DE RECEPCION -->
</div>
</div>

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
	
<?PHP
mysql_close($con);
?>