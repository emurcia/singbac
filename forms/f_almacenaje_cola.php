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
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>

<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<script src="../js/jquery.dataTables.min.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">

<script type="text/javascript"  src="../assets/alertify/lib/alertify.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" href="../assets/alertify/themes/alertify.core.css" />
<link rel="stylesheet" href="../assets/alertify/themes/alertify.default.css" />>

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
		document.formulario.action="http://localhost/bascula/?parametro="+cod+"&direccion=https://singbac.sigenesis.net/forms/f_almacenaje2.php"; // Capturar el Tara	
	//	document.formulario.action="http://localhost/bascula/?parametro="+cod+"&direccion=http://localhost/singbac/forms/f_almacenaje2.php"; // Capturar el Tara	
	//	document.formulario.action="http://192.168.178.108/bascula/?parametro="+cod+"&direccion=http://localhost/silos/forms/f_almacenaje2.php";//capturar el Tara.
		document.formulario.submit();
	} 

 function actualizar()
 {	 

    document.indicador.banderaindicador.value="ok";
    document.indicador.submit();  
 }

</script>
<script>
function activar_textos() //funcionar para activas las cajas de textos
  {
		if(document.indicador.disabled=!document.indicador.disabled){
			document.indicador.btnguardar_act.disabled=false;
			return;
  		}else{
						document.indicador.btnguardar_act.disabled=true;
			return;
		}
  }

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
<script>
function indicador1(con)
{
					
	document.formulario.indicador_otros.value = con;
	$.post('otros_indicadores.php', {id_cuentas_busca:document.formulario.indicador_otros.value}, 
			 function(result) {
				 	 
				$('#feedbackindicador').html(result).show();	
		  });//fin1
				
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
	 
$usu_utilizado=mysql_query("SELECT * from tab_almacenaje where id_almacenaje='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']==0){ // no ha sido utilizado
		$lleno=0;
  }else{ // Posse datos
  	 	$lleno=1;
  }	 
	 
	 
if ($lleno=="0"){
$resultado = eliminar_su("tab_almacenaje","id_almacenaje",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
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
<?PHP
	$bandera_indi = $_POST['banderaindicador'];
	if($bandera_indi=="ok"){
		
		
$Result1 = mysql_query("SELECT MAX(id_indicadores) as a  FROM tab_indicadoresrecepcion where id_empresa='$id_empresa' ORDER BY id_indicadores asc ") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],8,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "INDICAD-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "INDICAD-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "INDICAD-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "INDICAD-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "INDICAD-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "INDICAD-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "INDICAD-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}
			
// leer variables
   $nu;
   $cod_almacenaje1=$_SESSION['cod_almacenaje'];
   $temperaturag1=$_POST['temperaturag'];	
   $humedadg1=$_POST['humedadg'];
   $retenciong1=$_POST['retenciong']; 
   $grano_rotog1=$_POST['grano_rotog']; 
   $grano_dañadog1=$_POST['grano_dañadog']; 
   $impurezag1=$_POST['impurezag']; 
   $grano_chicog1=$_POST['grano_chicog']; 
   $grano_bolag1=$_POST['grano_bolag']; 
   $stress_crackg1=$_POST['stress_crackg']; 
   $germinaciong1=$_POST['germinaciong'];    		  
   $peso100granosg1=$_POST['peso100granosg'];    		  
   $longitud20granosg1=$_POST['longitud20granosg'];    		  
   $densidadg1=$_POST['densidadg'];    		  
   $otrasvariedadesg1=$_POST['otrasvariedadesg'];
   $piegrasg1=$_POST['piegrasg'];    		  
   $elaboradoporg1=strtoupper($_POST['elaboradoporg']);
  		  
	$nombre_usuario2=($_POST['nom_usuario2']); // CORREO
	$con_usuario2=md5($_POST['con_usuario2']);
	  $activo2="1";
	  $empresa2=$id_empresa;
	  $modificar2="1";

	$resultado = autorizar_mod($nombre_usuario2,$con_usuario2,$activo2,$empresa2,$modificar2);	
	
	if($resultado=="1"){
	$guarda="400"; // Guarda
	}else{
		$error="500"; // no posee permisos
		}
	}

 if($guarda=="400") // incia la actualizaccón
   {//inicio actualizar

   $tabla5="SELECT * FROM t_usuarios where correo_usuario='$nombre_usuario2' and pass_usuario='$con_usuario2' and id_empresa='$id_empresa'" or die(mysql_error());
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_actualiza2=$row5['id_usuario'];
}
   

		mysql_query("insert into tab_indicadoresrecepcion(id_indicadores, id_almacenaje, temperatura, humedad, retencion_malla, grano_roto, grano_arruinado, impureza, grano_chico, grano_bola, stress_crack, germinacion, peso_100_gramos, longitud_20_gramos, densidad, otras_variedades, piedras, nom_analista, id_empresa, id_usuario2, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values ('$nu','$cod_almacenaje1', '$temperaturag1', '$humedadg1','$retenciong1', '$grano_rotog1', '$grano_dañadog1','$impurezag1', '$grano_chicog1', '$grano_bolag1','$stress_crackg1', '$germinaciong1', '$peso100granosg1','$longitud20granosg1', '$densidadg1', '$otrasvariedadesg1', '$piegrasg1', '$elaboradoporg1', '$id_empresa', '$usuario_actualiza2', '$fecha', '$hora','$usuario_actualiza2','$fecha','$hora')") or die(mysql_error()); 

$sqlin= ("UPDATE tab_almacenaje SET nuevo_indicador='1' WHERE id_almacenaje='$cod_almacenaje1' and id_empresa='$id_empresa'");
		mysql_query($sqlin,$con);    
				   
	if(mysql_error())
		  { 
			$mensaje="11";
		  }
			  else
			$error="16";
				
					  
   } // fin guardar
	
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
if($mensaje=="11"){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Error en almacenamiento de datos!!!", function () {
					});
</script>				
 <?PHP  
}
if($error=="16"){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Datos actualizados con éxito!!!", function () {
					});
</script>				
 <?PHP  
}
if($error=="500"){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  No posee permisos para actualizar registro!!!", function () {
					});
</script>				
 <?PHP
}

?>

<?PHP 

  
if($mensaje=="1"){
echo '<div class="alert alert-success">
 						  <a href="f_almacenaje_cola.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje=="2"){
echo '<div class="alert alert-danger">
 						  <a href="f_almacenaje_cola.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje=="3"){
echo '<div class="alert alert-danger">
 						  <a href="f_almacenaje_cola.php" class="alert-link"> El Usuario no se puede eliminar, ya realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
?>

 <form role="form" name="formulario"  method="post" action="f_almacenaje_cola.php">
           <input type="hidden"  name="bandera" value="0">
 			<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif"> 
            <input type="hidden" name="indicador_otros" value="">

</form>      
        
<div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>VEHICULO EN COLA</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           

<div>
<?php

$id_almacen="ALMACEN-0000000".$id_empresa;
	 $sql = "SELECT * FROM tab_almacenaje WHERE id_almacenaje!='$id_almacen' and tipo_peso=1 and id_empresa='$id_empresa' order by fecha_entrada desc, hora_entrada desc ";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='table'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class=' display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>   
     
                                
                                <th width='150px'><div align='left'>ACCIONES</div></th>
                                <th width='120px'><div align='left'><a href='#' title='Ordenar por Fecha'>FECHA</a></div></th>
                                <th width='125px'><div align='left'><a href='#' title='Odenar por Hora'>HORA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Cliente'>CLIENTE </a></div></th>	
								<th width='150px'><div align='left'><a href='#' title='Odenar por Placa'>PLACA </a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Motorista'>MOTORISTA </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Lote'>LOTE </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Silo'>SILO </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Bruto'>BRUTO (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Tara'>TARA (KG) </a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Neto'>NETO (KG) </a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>REALIZADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA CREADO</a></div></th>
								
	 
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
			// $peso_neto=$row['peso_bruto']-$row['peso_tara']; //Calcular el peso neto
			 $fecha_imprime2=parseDatePhp($row['fecha_usuario']);
			 $fecha_imprime_modif=parseDatePhp($row['fecha_modifica']);	
			 $peso_neto1=$row['peso_bruto']-$row['peso_tara']; //Calcular el peso neto
			 $peso_neto =number_format($peso_neto1, 0, ".", ",");
			 $peso_bruto=number_format($row['peso_bruto'], 0, ".", ",");
			 $peso_tara=number_format($row['peso_tara'], 0, ".", ",");

			if($row['opcion_peso']==1)$peso="PESO BRUTO";
			if($row['opcion_peso']==2)$peso="PESO TARA";	 
									
			$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa_busca' and id_empresa='$id_empresa'";
			$select2=mysql_query($tabla2,$con);
			while($row2=mysql_fetch_array($select2)) {
			$nom_empresa=$row2['nom_cliente'];
			$otros_idicadores=$row2['otros_indicadores'];
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
		<td width='80px' align='left'>
		<a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_almacenaje']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a>
		<a onClick='tara(\"".$row['id_almacenaje']."\");' style='cursor:pointer' title='Completar Peso'><img src='../images/aceptar.png' width='28px' height='28px'></a>";
		
		if($otros_idicadores=="1"){
			if($row['nuevo_indicador']=="0"){
								echo"
							 <a data-toggle='modal' data-target='#modal_indicador1' onClick='indicador1(\"".$row['id_almacenaje']."\");'  style='cursor:pointer' title='Agregar indicadores'><img src='../images/modificar_indicador.png' width='28px' height='28px'></a>
							";} else{ echo"
							<a data-toggle='modal' data-target='#mensaje' style='cursor:pointer' title='Agregar indicadores'><img src='../images/modificar_indicador.png' width='28px' height='28px'></a>
							";}
							
			echo"
	   
							";} echo"
		</td>	   
         

		  
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $nom_empresa </td>
  		  <td width='auto' align='left'> $placa </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $num_lote </td>
		  <td width='auto' align='left'> $nom_silo </td>
		  <td width='auto' align='left'> $peso_bruto </td>
		  <td width='auto' align='left'> $peso_tara </td>
		  <td width='auto' align='left'> $peso_neto </td>
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
</div>
</div>
</div>

</body> 
</html>


<!-- INICIA MODAL INDICADOR -->
<div class="modal fade" id="modal_indicador1" >
<form name="indicador" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" >
<input type="hidden" name="banderaindicador" value="">
     <div class="modal-dialog">
          <div class="modal-content">                        
             <div id="feedbackindicador" class="modal-body" > 
          </div> 
          </div></div>  
                                 
    
</div>


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
                       <input type="text" id="nom_usuario2" name="nom_usuario2" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" id="con_usuario2" name="con_usuario2"  class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
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
</div>
</div>
<!-- MENSAJE REFERENCIA -->
<div class="modal fade" id="mensaje" >

<div class="modal-dialog">
          <div class="modal-content">                        
            <div class="modal-header">
               <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h3 class="modal-title">Estimado usuario, ya registro los indicadores para este pesaje</h3>
            </div>            
       
            <div class="modal-footer">
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               </div>
    <div>               
  </div>                  
            
 </div><!-- Fin de formularios  Inicia la paginacion-->  
    
</div>

  <?php 
  mysql_close($con);
?>