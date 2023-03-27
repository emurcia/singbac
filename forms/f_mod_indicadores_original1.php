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
$fec_entrada2=date('Y').'-'.date('m').'-'.date('d');
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

<script type="text/javascript"  src="../assets/alertify/lib/alertify.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="../assets/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="../assets/alertify/themes/alertify.default.css" />

</head> 

<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones1').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
    });


function mostrarindicador(str3)
{
				
	document.formulario.habilitaindicador.value = str3;
	$.post('mostrar_indicadores.php', {id_entrada:document.formulario.habilitaindicador.value}, 
			 function(result) {
				$('#feedbackindicador').html(result).show();	
		  });//fin1
				
}
 
function activar_textos() //funcionar para activas las cajas de textos
  {
		if(document.indicador.disabled=!document.indicador.disabled){
			document.indicador.btnguardar_act.disabled=false;
		//	document.getElementById('btnguardar_act').style.display = 'block';//Mostrar contenido
		//	document.formulario.ape_responsable.focus();
			return;
  		}else{
						document.indicador.btnguardar_act.disabled=true;
			//document.getElementById('formulario_responsable').style.display = 'none';//oculta contenido
			return;
		}
  }
 
 function actualizar()
 {	 
    document.indicador.banderaindicador.value="ok";
    document.indicador.submit();  
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
<?PHP
	$bandera_eli = $_POST['banderaindicador'];
	if($bandera_eli=="ok"){
// leer variables
   $entrada=$_SESSION['cod_entrada'];
   $peso_volg1=$_POST['peso_volg'];	
   $humedadg1=$_POST['humedadg'];
   $temperaturag1=$_POST['temperaturag']; 
   $grano_enterog1=$_POST['grano_enterog']; 
   $grano_quebradog1=$_POST['grano_quebradog']; 
   $dan_hongog1=$_POST['dan_hongog']; 
   $impurezag1=$_POST['impurezag']; 
   $grano_chicog1=$_POST['grano_chicog']; 
   $grano_picadog1=$_POST['grano_picadog']; 
   $plaga_vivag1=$_POST['plaga_vivag'];    		  
   $plaga_muertag1=$_POST['plaga_muertag'];    		  
   $stress_crackg1=$_POST['stress_crackg'];    		  
   $olorg1=strtoupper($_POST['olorg']);    		  
   $vaporg1=strtoupper($_POST['vaporg']);    		  
	  
		  
	  $nombre_usuario=($_POST['nom_usuario']); // CORREO
	  $con_usuario=md5($_POST['con_usuario']);
	  $activo="1";
	  $empresa=$id_empresa;
	  $modificar="1";

	$resultado = autorizar_mod($nombre_usuario,$con_usuario,$activo,$empresa,$modificar);	
	
	if($resultado=="1"){
	$guarda="400"; // Guarda
	}else{
		$error="500"; // no posee permisos
		}
	}

 if($guarda=="400") // incia la actualizaccón
   {//inicio actualizar

   $tabla5="SELECT * FROM t_usuarios where correo_usuario='$nombre_usuario' and pass_usuario='$con_usuario' and id_empresa='$id_empresa'" or die(mysql_error());
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_actualiza=$row5['id_usuario'];
}
   
   if(isset($entrada)){
		$sql= ("UPDATE tab_almacenaje SET peso_vol='$peso_volg1', humedad='$humedadg1', temperatura='$temperaturag1', grano_entero='$grano_enterog1', grano_quebrado='$grano_quebradog1', dan_hongo='$dan_hongog1', impureza='$impurezag1', grano_chico='$grano_chicog1', grano_picado='$grano_picadog1', plaga_viva='$plaga_vivag1', plaga_muerta='$plaga_muertag1', stress_crack='$stress_crackg1', olor='$olorg1', vapor='$vaporg1', id_usuario_mod_indicador='$usuario_actualiza', fec_mod_indicador='$fec_entrada2', hor_mod_indicador='$hora_entrada'  WHERE entrada='$entrada' and id_empresa='$id_empresa'")  or die(mysql_error());
		mysql_query($sql,$con);
	}
	if(mysql_error())
		  { 
			$mensaje="1";
		  }
			  else
			$error="6";
					  
   } // fin actualizar
	
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
if($mensaje==1){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Error en almacenamiento de datos!!!", function () {
					});
</script>				
 <?PHP  
}
if($error==6){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Datos actualizados con éxito!!!", function () {
					});
</script>				
 <?PHP  
}
if($error==500){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  No posee permisos para actualizar registro!!!", function () {
					});
</script>				
 <?PHP
}

?>
 <div class="container-fluid">
  <div class="row">
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>MODIFICAR INDICADORES</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 
 <form role="form" name="formulario"  method="post" action="f_mod_indicadores.php">
<input type="hidden" name="bandera" value="0">
<input type="hidden" name="bandera_acciones" value="0">
<input type="hidden" name="habilitaindicador" value="">
</form>         

     
<?php
$id_almacen="ALMACEN-0000000".$id_empresa;
$sql="SELECT a.id_almacenaje, a.entrada, a.fecha_entrada, a.hora_entrada, a.peso_bruto, a.peso_tara, l.num_lote, l.id_producto, c.nom_cliente, s.nom_silo, t.placa_vehiculo, t.nom_transportista, t.ape_transportista FROM tab_almacenaje as a, tab_lote as l, tab_cliente as c, tab_silo as s, tab_transportista as t, tab_producto as pro WHERE a.id_almacenaje!='$id_almacen' AND a.id_empresa='$id_empresa' and a.id_cliente=c.id_cliente and a.id_silo=s.id_silo and a.id_lote=l.id_lote AND l.id_producto=pro.id_producto AND pro.humedad='1' AND a.bandera='2' AND a.id_transportista=t.id_transportista GROUP BY a.fecha_entrada desc, a.hora_entrada desc ";
 	 $result = mysql_query($sql,$con);
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
		
		if ($result> 0){	
		while ($row = mysql_fetch_array($result)) 
		{
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);
			 $nom_transportista=$row['nom_transportista']." ".$row['ape_transportista'];
			 $peso_neto_entrada=number_format(($row['peso_bruto']-$row['peso_tara']),0, ".",","); //Calcular el peso neto
			 $peso_tara_entrada=number_format($row['peso_tara'], 0, ".", ",");
			 $peso_bruto_entrada=number_format($row['peso_bruto'], 0, ".", ",");
				
		echo"<tr>
		<td width='30px' align='center'><a data-toggle='modal' data-target='#modal_indicador' onClick='mostrarindicador(\"".$row['entrada']."\");'  style='cursor:pointer' class='btn btn-info glyphicon glyphicon-edit' title='Conyugue'></a></td>	   
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

<!-- INICIA MODAL DOMICILIO -->
<div class="modal fade" id="modal_indicador" >
<form name="indicador" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" >
<input type="hidden" name="banderaindicador" value="">
     <div class="modal-dialog">
          <div class="modal-content">                        
             <div id="feedbackindicador" class="modal-body" > 
          </div> 
          </div></div>  
                                 

    
    
<!-- SOLICITA PERMISO PARA ACTUALIZAR -->

<div class="modal fade" id="actualizar">
        <div class="modal-dialog">
          <div class="modal-content">                        
            <div class="modal-header">
               <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h3 class="modal-title">Modificar Registro</h3>
            </div>            
          <div class="modal-body"> 
          
            <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">USUARIO</label>
                       <input type="text" id="nom_usuario" name="nom_usuario" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" id="con_usuario" name="con_usuario"  class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
            <div class="modal-footer">
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button id="btnactualizar"  name="btnactualizar" onclick="actualizar()" class="btn btn-primary glyphicon glyphicon-cd center pull-right">  Actualizar</button>
               </div>
    </div>
    <div>               
  </div>                  
            
           </form> 
 </div><!-- Fin de formularios  Inicia la paginacion-->
     
</div>

