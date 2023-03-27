<?PHP
ini_set('session.save_handler', 'files');
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
 
 $buscar_bascula= $_GET['parametro'];
 $peso_tara_url1=$_GET['peso_bruto'];
  list($peso_tara_url, $quitar) = split(' ', $peso_tara_url1);
 

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
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");

$tabla="SELECT *  FROM tab_almacenaje where (id_almacenaje='$buscar_bascula' or id_almacenaje='".$_SESSION['$id_almacenaje1']."' or id_almacenaje='".$_POST['busca_id_almacenaje']."') and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
// EXTRAER DATOS PARA REALIZAR EL TARA
		 $id_bascula1=$row['id_almacenaje'];
		 $entrada1=$row['entrada'];
		 $id_cliente1=$row['id_cliente'];
		 $id_lote1=$row['id_lote'];	
		 $id_silo1=$row['id_silo'];
		 $id_servicio1=$row['id_servicio'];
		 $fecha_entrada1=parseDatePhp($row['fecha_entrada']);
		 $hora_entrada1=$row['hora_entrada'];
		 $peso_bruto1=$row['peso_bruto'];
	     $observacion1=strtoupper($row['observacion']); // Agregue strtoupper
		 // COMPLETAR EL MODAL
		 $id_variablebuscar=$row['id_variable'];
		 $mostrar_pesovol=$row['peso_vol'];
		 $mostrar_humedad=$row['humedad'];
 		 $mostrar_temperatura=$row['temperatura'];
 		 $mostrar_grano_entero=$row['grano_entero'];
  		 $mostrar_grano_quebrado=$row['grano_quebrado'];
 		 $mostrar_dan_hongo=$row['dan_hongo'];		 
 		 $mostrar_impureza=$row['impureza'];		 
 		 $mostrar_grano_chico=$row['grano_chico'];		 
 		 $mostrar_grano_picado=$row['grano_picado'];
 		 $mostrar_plaga_viva=$row['plaga_viva'];		 		 
 		 $mostrar_plaga_muerta=$row['plaga_muerta'];
 		 $mostrar_stress_crack=$row['stress_crack'];
 		 $mostrar_olor=strtoupper($row['olor']); //Agregue strtoupper
 		 $mostrar_vapor=strtoupper($row['vapor']); //Agregue strtoupper
		 $mostrar_nom_analista=strtoupper($row['nom_analista']); //Agregue strtoupper
		 		 		 		 		 		 
	}	

$tabla2="SELECT *  FROM tab_cliente where id_cliente='$id_cliente1' and id_empresa='$id_empresa' and bandera='0'";
$select2 = mysql_query($tabla2,$con);
while($row2 = mysql_fetch_array($select2))
{
	$nom_cliente1=$row2['nom_cliente'];
}
$tabla3="SELECT *  FROM tab_lote where id_lote='$id_lote1' and id_empresa='$id_empresa' and bandera='0'";
$select3 = mysql_query($tabla3,$con);
while($row3 = mysql_fetch_array($select3))
{
	$num_lote1=$row3['num_lote'];
	$id_producto=$row3['id_producto'];
}

$tabla4="SELECT *  FROM tab_silo where id_silo='$id_silo1' and id_empresa='$id_empresa' and bandera='0'";
$select4 = mysql_query($tabla4,$con);
while($row4 = mysql_fetch_array($select4))
{
	$nom_silo1=$row4['nom_silo'];
}
$tabla5="SELECT *  FROM tab_servicio where id_servicio='$id_servicio1' and id_empresa='$id_empresa' and bandera='0'";
$select5 = mysql_query($tabla5,$con);
while($row5 = mysql_fetch_array($select5))
{
	$nom_servicio1=$row5['nom_servicio'];
}

// EXTRAER DATOS PARA COMPLETAR EL MODAL
$tabladosvar="SELECT *  FROM tab_variables where id_variable='$id_variablebuscar' and id_empresa='$id_empresa'";
$selectdosvar = mysql_query($tabladosvar,$con);
while($rowdosvar = mysql_fetch_array($selectdosvar))
{
	 $nom_variable=$rowdosvar['nom_variable'];
 	 $id_variable1=$rowdosvar['id_variable'];
}		

$tabla6="SELECT p.humedad FROM tab_producto as p join tab_lote as l on p.id_producto=l.id_producto where l.id_lote='$id_lote1' and l.id_empresa='$id_empresa' and l.bandera='0'";
$select6 = mysql_query($tabla6,$con);
$row6 = mysql_fetch_array($select6, MYSQL_ASSOC);
$variable=$row6['humedad'];

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
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css">
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
</head> 
<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=09 && tecla.keyCode !=127 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
            });
		
});
</script>

<script type="text/javascript">
function guardar(){
		document.formulario.busca_id_almacenaje.value=document.formulario.id_bascula2.value;
		document.formulario.bandera.value='ok';
		document.formulario.submit();
}// fin guardar

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 function cancelar(){
	 
		document.location.href='f_almacenaje_cola.php';	
	}

 function datos(){
	 window.open('../reportes/Rp_recepcion_vehiculo_vacio.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');

if (window.confirm("Desea imprimir indicadores de calidad?")) { 
  window.open('../reportes/Rp_indicadores_calidad.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');

}	 
	
}	

function datos_variables(){
alert("Verique indicadores antes de guardar la transacción");	
}

 
function validar_peso(str){
		   var a = str;
		 
		   if(parseFloat(document.formulario.peso_tara.value) > parseFloat(document.formulario.peso_base.value))
		   {
			   alert('El Peso Tara no puede ser mayor que el Peso Bruto');
			   document.formulario.peso_tara.value="";
			   document.formulario.pero_tara.focus();
			  //return 0;
		   }
}

function validarvar()
{	
	
	if(document.fvariables.id_variable.value=="VAR-000"){
	alert("Seleccione Variable");
	return;
	}else {
	document.fvariables.guardar_id_variable.value=document.fvariables.id_variable.value;
	document.fvariables.guardar_id_valmacenaje.value=document.fvariables.id_valmacenaje.value;
	document.fvariables.guardar_peso_vol.value=document.fvariables.peso_vol.value;
	document.fvariables.guardar_humedad.value=document.fvariables.humedad.value;	
	document.fvariables.guardar_temperatura.value=document.fvariables.temperatura.value;		
	document.fvariables.guardar_grano_entero.value=document.fvariables.grano_entero.value;	
	document.fvariables.guardar_grano_quebrado.value=document.fvariables.grano_quebrado.value;	
	document.fvariables.guardar_dan_hongo.value=document.fvariables.dan_hongo.value;
	document.fvariables.guardar_impureza.value=document.fvariables.impureza.value;		
	document.fvariables.guardar_grano_chico.value=document.fvariables.grano_chico.value;	
	document.fvariables.guardar_grano_picado.value=document.fvariables.grano_picado.value;	
	document.fvariables.guardar_plaga_viva.value=document.fvariables.plaga_viva.value;	
	document.fvariables.guardar_plaga_muerta.value=document.fvariables.plaga_muerta.value;	
	document.fvariables.guardar_stress_crack.value=document.fvariables.stress_crack.value;	
	document.fvariables.guardar_olor.value=document.fvariables.olor.value;	
	document.fvariables.guardar_vapor.value=document.fvariables.vapor.value;	
	document.fvariables.guardar_nom_analista.value=document.fvariables.analista.value;	
	document.fvariables.peso_tara1.value=document.formulario.peso_tara.value;
	document.fvariables.insertarvar.value='guardarvar';
	document.fvariables.submit();
	}
}

</script>

<script>
<!-- FUNCION PARA PONER MASCARA  -->
function mascara(t, mask){
 var i = t.value.length;
 var saida = mask.substring(1,0);
 var texto = mask.substring(i)
 if (texto.substring(0,1) != saida){
 t.value += texto.substring(0,1);
 }
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
	   
// PARA ALMACENAR
 $bandera = $_POST['bandera'];	
 $id_lote_busca=$_POST['id_lote5'];	
 $fecha_salida2= parseDateMysql($_POST['fecha_salida']);
 $hora_salida2=$_POST['hora_salida'];
 $peso_tara2=$_POST['peso_tara'];
 $peso_bruto2=$_POST['peso_bruto'];
 $observacion3=strtoupper($_POST['observacion2']);
 $cod2=$_POST['id_bascula2'];		
 if($pingresar=="1"){
 if($bandera=="ok")
  {//inicio if bandera ok
// VERIFICA SI EXISTE HUMEDAD	

if ($variable=="1"){ 

	$tabla2="SELECT * FROM tab_almacenaje where id_almacenaje='$cod2' and id_empresa='$id_empresa'";
		$select2 = mysql_query($tabla2,$con);
		while($row2 = mysql_fetch_array($select2))
		{
			$humedad1=$row2['humedad'];
		}
		
		
		
		if(($humedad1-14)<0){ //14.25
			$factor=-1;
			}else{
			$factor=1;
			}

	  $porcentaje=(($humedad1-14)*$factor)/100; //14.25
	  $calculo= (($peso_bruto2-$peso_tara2)*$porcentaje*1.17);
	  $peso_sin_humedad=($peso_bruto2-$peso_tara2)-(($peso_bruto2-$peso_tara2)*$porcentaje*1.17); // RESTAR LA HUMEDAD MAS MARGEN DE ALMACENAMIENTO
	  $neto_maximo=($peso_bruto2-$peso_tara2)-(($peso_bruto2-$peso_tara2)*$porcentaje); // GRANOS MENOS HUMEDAD
	  
	  // Vefificar si la humedad es menor que 14.25
		if($humedad1<="14"){ //14.25
		$peso_sin_humedad=($peso_bruto2-$peso_tara2); // EN CASO QUE NO SE LE RESTE LA HUMEDAD
	        $neto_maximo=$peso_sin_humedad;			
		
		} // fin verificar humedad
	  
}else { // SI EL PRODUCTO NO TIENE HUMEDAD
	$peso_sin_humedad=($peso_bruto2-$peso_tara2); // EN CASO QUE NO SE LE RESTE LA HUMEDAD
	$neto_maximo=$peso_sin_humedad;

}
  
	$tabla6="SELECT *  FROM tab_inventario where id_lote='$id_lote_busca' and id_empresa='$id_empresa'";
	$select6 = mysql_query($tabla6,$con);
	while($row6 = mysql_fetch_array($select6))
	{
	 $cantidad_almacenada=$row6['movimiento_lote'];
	 $cantidad_sin_humedad=$row6['peso_sin_humedad'];
	 $cantidad_sin_humedad_max=$row6['peso_sin_humedad_maximo'];
	}	 
	 
	 $peso_sin_humedad2=round($cantidad_sin_humedad+$peso_sin_humedad,2);
	 $peso_sin_humedad_max2=round($cantidad_sin_humedad_max+$neto_maximo,2);
	 $peso_bruto_inv=round($peso_bruto2-$peso_tara2+$cantidad_almacenada,2);

	 
	
if(isset($cod2)){
$sql= ("UPDATE `tab_almacenaje` SET `fecha_salida`='$fecha_salida2',`hora_salida`='$hora_salida2' ,`tipo_peso` ='2',  `peso_tara`='$peso_tara2', `neto_sin_humedad`='$peso_sin_humedad', `neto_sin_humedad_maximo`='$neto_maximo', `observacion`='$observacion3',`bandera`='2', id_usuario_modifica='$id_usuario', fecha_modifica='$fecha_entrada', hora_modifica='$hora'  WHERE id_almacenaje='$cod2' and id_empresa='$id_empresa'");

$sql_inv= ("UPDATE `tab_inventario` SET `movimiento_lote`='$peso_bruto_inv',  peso_sin_humedad='$peso_sin_humedad2', peso_sin_humedad_maximo='$peso_sin_humedad_max2' WHERE id_lote='$id_lote_busca' and id_empresa='$id_empresa'");
				   mysql_query($sql,$con);
				   mysql_query($sql_inv,$con);
					  if(mysql_error())
					  { 
						$guarda="1";
					  }
					  else
					   $act= ("UPDATE tab_almacenaje SET ocupado=1 WHERE id_almacenaje='$cod2' and id_empresa='$id_empresa'");
	 		  			mysql_query($act,$con);
					   $guarda="2";

}
}
}else{ // fin bandera ok
	$error="4"; //no tiene permiso de escritura
}//fin bandera ok	
	
?>   


<body class="container" <?PHP if($guarda == 2) echo "onload='datos()';"; if($variable==1) echo "onload='datos_variables()';"; ?> > 


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
if($variable==1){
echo "<div class='alert alert-success'>
 		<a data-toggle='modal' class='alert-link' data-target='#modalvariables' onClick='eliminar(\"".$row['buscar_bascula']."\");' style='cursor:pointer' title='Eliminar registro'>Producto con humedad, haga click para ingresar parametros</a>
  </div>";

	}

if($guarda==1){
	echo '<div class="alert alert-danger">
 		<a href="f_almacenaje_cola.php" class="alert-link"> Error en el procesamiento de datos!!! Haga click para continuar .....</a>
</div>';
unset($_SESSION['$id_almacenaje1']);
unset($_SESSION['peso_tara1']);
	}
 if($guarda == 2)
 {
	 echo '<div class="alert alert-success">
 		<a href="f_almacenaje_cola.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
</div>';
unset($_SESSION['$id_almacenaje1']);
unset($_SESSION['peso_tara1']);

}
if($error==4){
echo '<div class="alert alert-danger">
 						  <a href="f_almacenaje_cola.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';
} 
?>

           <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>RECEPCION DE GRANOS BASICOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form role="form" name="formulario"  method="post" action="f_almacenaje2.php">
           	<input type="hidden"  name="bandera" value="0">
           	<input type="hidden"  name="id_lote5" value="<?PHP echo $id_lote1;?>"> 
           	<input type="hidden"  name="reporte" value="<?PHP echo $_POST['id_bascula2']; ?>"> 
           	<input type="hidden"  name="busca_id_almacenaje" value="">             
           	<input type="hidden" name="peso_base" value="<?PHP echo $peso_bruto1; ?>"> 
           	<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif">  
                      
           
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="entrada">CODIGO</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $id_bascula1;?>" id="id_bascula2"  name="id_bascula2" autocomplete="off" style="background:#FFF;" readonly>
                        
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="entrada">SERVICIO N°.</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $entrada1;?>" id="entrada2"  name="entrada2" autocomplete="off" style="background:#FFF;" readonly>
                            
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
           
                   
            <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">CLIENTE</label>
                <input type="text" class="form-control input-lg" value="<?PHP echo $nom_cliente1;?>" id="cliente2"  name="cliente2" autocomplete="off" style="background:#FFF;" readonly>
                              
                  </div>
              </div>

               <div class="col-md-6">
              <div class="form-group">
               <label>LOTE</label>
              <input type="text" class="form-control input-lg" value="<?PHP echo $num_lote1;?>" id="transportista2"  name="transportista2" autocomplete="off" style="background:#FFF;" readonly>
                  </div>
              </div>
              </div> <!-- FIN ROW -->
              
               <div class="row"><!--- INICIO ROW----->
              
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">SILO</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $nom_silo1;?>" id="producto2"  name="producto2" autocomplete="off" style="background:#FFF;" readonly>
                              
                  </div>
              </div>
             
             <div class="col-md-6" >
              <div class="form-group">
               <label for="moneda_servicio">SERVICIOS DEL LOTE</label>
                 <?PHP
               $tabla_servicio=mysql_query("SELECT * FROM tab_servicio as a, tab_detalle_servicio as b WHERE a.id_servicio=b.id_servicio and b.id_lote = '$id_lote1' and b.id_cliente = '$id_cliente1' and a.id_empresa='".$id_empresa."' and a.bandera=0");
			   
			   ?>
              <div> <select size="4" name="id_servicio2" id="id_servicio2" class="form-control input-lg" style="height: auto; background:#FFF;" > 
               <?php 
								while($valor4=mysql_fetch_array($tabla_servicio)){
									$codigo_cliente= $valor4["id_servicio"];
									$nombre_cliente= $valor4["nom_servicio"];
									echo "<option value='$codigo_cliente'>";
									echo ("$nombre_cliente");
									echo"</option>";
								}	
							?>
                            </select></div>
              </div>
              </div>  
           </div><!--- FIN ROW----->
           <br>
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">FECHA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $fecha_entrada1;?>" id="fecha_entrada" name="fecha_entrada" autocomplete="off" style="background:#FFF;" readonly>
                      
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">HORA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $hora_entrada1;?>" id="hora_entrada" name="hora_entrada" autocomplete="off" style="background:#FFF;" readonly>
                        
                              
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
           <br>
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">FECHA SALIDA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $fecha;?>" id="fecha_salida" name="fecha_salida" autocomplete="off" style="background:#FFF;" readonly >
                      
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">HORA SALIDA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $hora;?>" id="hora_salida" name="hora_salida" autocomplete="off" style="background:#FFF;" readonly>
                        
                              
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
           <br>
           <!-- PARA CAPTURA LOS PESOS -->
           <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
              <label for="opciones"> PESO A REALIZAR </label>
              </div>
              </div>
              </div>
              
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
             
               	 <div>
                 <input type="radio" id="tipo_peso" value="1" name="tipo_peso" disabled>  PESO BRUTO 
                 </div>
                 </div>
                 </div>
              
               <div class="col-md-6">
              	<div class="form-group">
				<label for="tipo_peso"></label>
                 <input type="radio" id="tipo_peso" value="2" name="tipo_peso" onClick="validar_peso(document.formulario.peso_base.value); btnguardar.disabled=false;" >  PESO TARA 
                
                 </div>
                 </div>
                  
              
              </div><!--- FIN ROW----->
              
                     
       <br>
       <div class="row"><!--- INICIO ROW----->
          <div class="col-md-6">
         <div class="form-group">
              <label>PESO BRUTO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_bruto"  name="peso_bruto"  placeholder="PESO BRUTO" autocomplete="off" value="<?PHP echo $peso_bruto1;?>" readonly style="background:#FFF;" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-6">
         <div class="form-group">
              <label>PESO TARA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_tara"  name="peso_tara"  placeholder="PESO TARA" autocomplete="off" style="background:#FFF;" value="<?PHP echo $peso_tara_url; echo $_SESSION['peso_tara1'];?>" onKeyUp="validar_peso(document.formulario.peso_base.value);" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
                  </div>
          </div>
            
          </div><!--- FIN ROW----->
                 
       <br>
       <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="observaciones">Observación</label>
             <textarea name="observacion2" class="form-control input-lg" rows="3" placeholder="Observaciones" autocomplete="off" id="observacion2" style="text-transform:uppercase;"><?PHP echo $observacion1;?></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
		

<br><br>
                         
         
          
               	  <table width="220" border="0" align="right">
                  
                  
				   	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" onClick="cancelar()" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="button" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right" disabled>  </button></td>
              	    </tr>
           	      </table> 
            
           </form> 
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

<!-- PERMITE MODIFICAR PARAMETROS ANTES DE ALMACENAR EN INVENTARIO -->
<div class="modal fade" id="modalvariables">
	<form id="fvariables" name="fvariables" action="f_almacenaje2.php" method="post">
  	<input type="hidden" name="insertarvar">  
    <input type="hidden" name="guardar_id_valmacenaje">  
    <input type="hidden" name="guardar_id_variable" value="<?PHP echo $_POST['id_variable']; ?>">
    <input type="hidden" name="guardar_peso_vol">
    <input type="hidden" name="guardar_humedad">    
    <input type="hidden" name="guardar_temperatura">    
	<input type="hidden" name="guardar_grano_entero">
    <input type="hidden" name="guardar_grano_quebrado">
    <input type="hidden" name="guardar_dan_hongo"> 
    <input type="hidden" name="guardar_impureza">  
    <input type="hidden" name="guardar_grano_chico"> 
    <input type="hidden" name="guardar_grano_picado"> 
    <input type="hidden" name="guardar_plaga_viva"> 
    <input type="hidden" name="guardar_plaga_muerta">                             
    <input type="hidden" name="guardar_stress_crack">
    <input type="hidden" name="guardar_olor">  
    <input type="hidden" name="guardar_vapor">
    <input type="hidden" name="guardar_nom_analista"> 
    <input type="hidden" name="peso_tara1">              
 		 
         <div class="modal-dialog">
          <div class="modal-content">                        
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h3 class="modal-title">Modificar Parametros</h3>
            </div>            
          <div class="modal-body"> 
           <div class="row"><!--- INICIO ROW----->
                        
             <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">CODIGO</label>
               <input type="text" class="form-control input-lg" value="<?PHP if ($_SESSION['$id_almacenaje1']=="") echo $buscar_bascula; else echo $_SESSION['$id_almacenaje1'];?>" id="id_valmacenaje" name="id_valmacenaje" autocomplete="off" style="background:#FFF;" readonly >
              </div>
       </div>
         <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">VARIABLE</label>
               <?php
						 $id_var="VAR-000".$id_empresa;
						 $tabla=mysql_query("SELECT * FROM tab_variables WHERE id_variable!='$id_var' and id_empresa='$id_empresa'");
						  ?>
                      <select name="id_variable" class="form-control input-lg chosen"  size="1" id="id_variable" >
                            <option value="<?PHP echo $id_variable1?>"><?PHP echo $nom_variable; ?></option>
						 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									if($nom_variable==$valor['nom_variable']){
										$nombre_cliente="SELECCIONE OPCION";
										$codigo_cliente="VAR-000";
									}else{
										$codigo_cliente= $valor['id_variable'];
										$nombre_cliente= $valor["nom_variable"];
									}
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
              <label>PESO VOLUMETRICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_vol"  name="peso_vol"  value="<?PHP echo $mostrar_pesovol; ?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.peso_base.value);" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">KG</span>
                  </div>
      		</div>
          </div>
         
            <div class="col-md-4">
         <div class="form-group">
              <label>HUMEDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="humedad"  name="humedad" value="<?PHP echo $mostrar_humedad;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.humedad_base.value);" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>TEMPERATURA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="temperatura"  name="temperatura" value="<?PHP echo $mostrar_temperatura; ?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.temperatura_base.value);" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">°</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
 
       <br>
            <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>GRANO ENTERO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_entero"  name="grano_entero" value="<?PHP echo $mostrar_grano_entero;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_entero_base.value);" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">%</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO QUEBRADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_quebrado"  name="grano_quebrado"  value="<?PHP echo $mostrar_grano_quebrado;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_quebrado_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>DAÑO POR HONGO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="dan_hongo"  name="dan_hongo" value="<?PHP echo $mostrar_dan_hongo;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.dan_hongo_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
                <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>IMPUREZA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="impureza"  name="impureza"  value="<?PHP echo $mostrar_impureza;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.impureza_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO CHICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_chico"  name="grano_chico"  value="<?PHP echo $mostrar_grano_chico;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_chico_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>GRANO PICADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_picado"  name="grano_picado"  value="<?PHP echo $mostrar_grano_picado;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_picado_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4">
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
                 <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>PLAGA VIVA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_viva"  name="plaga_viva"  value="<?PHP echo $mostrar_plaga_viva;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.plaga_viva_base.value);" >
              <span class="input-group-addon">UNIDADES</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PLAGA MUERTA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_muerta"  name="plaga_muerta"  value="<?PHP echo $mostrar_plaga_muerta;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.plaga_muerta_base.value);" >
              <span class="input-group-addon">UNIDADES</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>STRESS CRACK </label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="stress_crack"  name="stress_crack"  value="<?PHP echo $mostrar_stress_crack;?>" autocomplete="off" onKeyUp="validar_peso(document.formulario.stress_crack_base.value);" onkeypress="mascara(this, '##.##')" maxlength="5">
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>OLOR</label>
              <input type="text" class="form-control input-lg" id="olor"  name="olor"  value="<?PHP echo $mostrar_olor;?>" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         <div class="col-md-4">
         <div class="form-group">
              <label>VAPOR</label>
              <input type="text" class="form-control input-lg" id="vapor"  name="vapor" value="<?PHP echo $mostrar_vapor;?>" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         </div>
         <div class="row">
         <div class="col-md-12">
         <div class="form-group">
              <label>ANALISTA</label>
              <input type="text" class="form-control input-lg" id="analista"  name="analista" value="<?PHP echo $mostrar_nom_analista; ?>" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         </div><!--- FIN ROW----->             
            <br>
         		<button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
               	<button class="btn btn-primary" type="button" onClick="validarvar();">Guardar</button>
    </div>
    <div>               
    </form>
</div>


<!-- FIN DEL MODAL TRANSPORTISTA -->

 <?php 
// Inserta transportista
//$_SESSION['$id_almacenaje1']="";
 if(isset($_POST['insertarvar']) && $_POST['insertarvar']=="guardarvar"){
		include('insertar_variables.php');
		echo" <script language='javascript'>";
		echo" alert('Datos actualizados correctamente...');";
		echo"location.href='f_almacenaje2.php';";
		echo" </script>";
  }
//$_SESSION['$id_almacenaje1']="";  
mysql_close();
?>
</body> 
</html>