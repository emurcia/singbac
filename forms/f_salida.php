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

$peso_tara_url=$_GET['peso_bruto'];
$id_cliente11=$_SESSION['$id_cliente1'];
echo $id_lote11= $_SESSION['$id_lote1'];	
$id_silo11= $_SESSION['$id_silo1'];	
$id_servicio11=$_SESSION['$id_servicio1'];
$id_transportista11=$_SESSION['$id_transportista1'];
$peso_teorico11=$_SESSION['$peso_teorico1'];
$peso_bruto11=$_SESSION['$peso_bruto1'];
		
if($id_cliente11==""){
	$nombre_cliente1="SELECCIONE CLIENTE / EMPRESA";
	}
if($id_lote11==""){
	$nom_lote1="SELECCIONE LOTE";
	}
if($id_silo11==""){
	$nom_silo1="SELECCIONE SILO";
	}
if($id_servicio11==""){
	$nom_servicio1="SERVICIOS DEL LOTE";
	}	
if($id_transportista11==""){
	$nom_transportista1="SELECCIONE TRANSPORTISTA";
	}

if($id_subproducto1==""){
	$nom_subproducto1="SELECCIONE SUBPRODUCTO";
	}		
			

$tabla_cli=mysql_query("SELECT * FROM tab_cliente Where id_cliente='".$_SESSION['$id_cliente1']."' and id_empresa='$id_empresa';");
						 		while($valor1=mysql_fetch_array($tabla_cli)){
									$nombre_cliente1= $valor1["nom_cliente"];
																	
								}
$tabla_lote=mysql_query("SELECT * FROM tab_lote Where id_lote='".$_SESSION['$id_lote1']."' and id_empresa='$id_empresa';");
						 		while($valor2=mysql_fetch_array($tabla_lote)){
									$nom_lote1= $valor2["num_lote"];
								}
$tabla_silo=mysql_query("SELECT * FROM tab_silo Where id_silo='".$_SESSION['$id_silo1']."' and id_empresa='$id_empresa';");
						 		while($valor3=mysql_fetch_array($tabla_silo)){
									$nom_silo1= $valor3["nom_silo"];
								}	

$tabla_subproducto=mysql_query("SELECT a.* FROM tab_subproducto as a, tab_lote as b WHERE a.id_producto=b.id_producto and b.id_lote = '".$_SESSION['$id_lote1']."' and b.id_cliente = '".$_SESSION['$id_cliente1']."'");
						 		while($valorr=mysql_fetch_array($tabla_subproducto)){
									$nom_subproducto1= $valorr["nom_subproducto"];
								}
/*$tabla_servicio=mysql_query("SELECT * FROM tab_servicio Where id_servicio='".$_SESSION['$id_servicio1']."' and id_empresa='$id_empresa';");
						 		while($valor4=mysql_fetch_array($tabla_servicio)){
									$nom_servicio1= $valor4["nom_servicio"];
								}																								
*/
$tabla_transportista=mysql_query("SELECT * FROM tab_transportista Where id_transportista='".$_SESSION['$id_transportista1']."' and id_empresa='$id_empresa';");
						 		while($valor5=mysql_fetch_array($tabla_transportista)){
									$nom_transportista1= $valor5["nom_transportista"]." ".$valor5["ape_transportista"];;
								}								
									

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
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora_entrada=date("H:i:s");
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<script src="../assets/javascript/jquery.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<script src="../assets/javascript/chosen.jquery.js"></script>
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
<link href="../images/favicon.ico" rel="icon">
</head> 
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

<script type="text/javascript">
function guardar(){
		document.formulario.bandera.value='ok';
		document.formulario.submit();
			
}// fin guardar

function tara(cod){
		document.formulario.busca.value="tara";	
		document.formulario.cod_prod_modif.value=cod;
//	document.formulario.action="http://localhost/bascula/?parametro="+cod+"&direccion=http://190.143.196.3/sylos/forms/f_salida2.php";//capturar el Tara.
		
		document.formulario.action="http://192.168.178.161/bascula/?parametro="+cod+"&direccion=http://localhost/silos/forms/f_salida2.php";//capturar el Tara.
		document.formulario.submit();
	} 

function cancelar(){
	document.formulario.btnguardar.disabled=false;
	}
function activar_textos() //funcionar para activas las cajas de textos
  {
		if(document.formulario.disabled=!document.formulario.disabled){
			document.getElementById('formulario_responsable').style.display = 'block';//Mostrar contenido
			return;
  		}else{
			document.getElementById('formulario_responsable').style.display = 'none';//oculta contenido
			return;
		}
  }	


function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
  function datos(){
	 window.open('../reportes/Rp_despacho_vehiculo_vacio.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}

function validarum()
{	
	document.ftransportista.insercliente.value=document.formulario.id_cliente2.value;
	document.ftransportista.inserlote.value=document.formulario.id_lote2.value;
	document.ftransportista.insersilo.value=document.formulario.id_silo2.value;	
	document.ftransportista.inserservicio.value=document.formulario.id_servicio2.value;	
	document.ftransportista.pesoteorico.value=document.formulario.peso_teorico.value;			
	document.ftransportista.pesobruto.value=document.formulario.peso_tara.value;				
	document.ftransportista.insertarum.value='guardarum';
	document.ftransportista.submit();
}

</script>

<script type="text/javascript">
       $(document).ready(function() {
	  
		   $('#id_cliente2').change(function() {//inicio1
			 $.post('lote_select.php', {id_cliente_busca:document.formulario.id_cliente2.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
			
				$('#feedback2').load('select_silo.php').show();
				$('#id_lote2').change(function() {//inicio2
		   		$.post('select_silo.php', {id_lote_busca:document.formulario.id_lote2.value}, 
			 	function(result) {
				$('#feedback2').html(result).show();
				
						//$('#feedback3').load('select_servicio.php').show();
						$('#id_silo2').change(function() {//inicio3
						$.post('select_servicio_almacenaje.php', {id_lote_busca:document.formulario.id_lote2.value, id_cliente_busca:document.formulario.id_cliente2.value}, 
						function(result) {
						$('#feedback3').html(result).show();
						
						$('#id_servicio2').change(function() {//inicio5
						$.post('select_subproducto_salida.php', {id_lote_busca:document.formulario.id_lote2.value, id_cliente_busca:document.formulario.id_cliente2.value}, 
						function(result) {
						$('#feedback5').html(result).show();	
						
						
								//$('#feedback3').load('select_servicio.php').show();
								$('#id_subproducto2').change(function() {//inicio4
								$.post('piloto_select.php', {id_servicio_busca:document.formulario.id_servicio2.value, id_cliente_busca:document.formulario.id_cliente2.value}, 
								function(result) {
								$('#feedback4').html(result).show();																					 
									
									
																														 
										}); 									 
									});//fin5
									
								}); 									 
								});//fin4
									
																												 
							}); 									 
						});//fin3	
						
																														 
					}); 									 
				});//fin2
				
				 }); 									 
		  });//fin1
		 		  
       });

</script>
<script>
        $(document).ready(function(){
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
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
 <?php	              
					$sql = "SELECT * FROM tab_contador where id_empresa='$id_empresa'"; 
					$result = mysql_query($sql); //usamos la conexion para dar un resultado a la variable
					if ($result> 0){ //si la variable tiene al menos 1 fila entonces seguimos con el codigo
					    while ($fila = mysql_fetch_array($result)) 
						{
							$cont_total=$fila['total'];
							$cod_entrada=$fila['salida_almacen'];
							$transaccion=$cont_total+1;
							//echo " ".$fila['idEmpleado'];
							$entrada=$cod_entrada+1; 	
						//	$transaccion=$transaccion+1;
						}
					}
					
	// codigo del kardex
$Result2 = mysql_query("SELECT MAX(id_kardex) as a  FROM tab_kardex where id_empresa='$id_empresa'  ORDER BY id_kardex") or die(mysql_error());
$dec3=mysql_fetch_assoc($Result2);
$a2=substr($dec3['a'],7,7);
if ($a2<9)
	{
	$num1 = "$a2"+"1";
	$nu1= "KARDEX-000000".$num1.$id_empresa;
	}else{if ($a2<99){
			$num1 = "$a2"+"1";
			$nu1= "KARDEX-00000".$num1.$id_empresa;
		}else{if($a2<999){
				$num1 = "$a2"+"1";
				$nu1= "KARDEX-0000".$num1.$id_empresa;
				}else{if($a2<9999){
					$num1 = "$a2"+"1";
					$nu1= "KARDEX-000".$num1.$id_empresa;
					}else{if($a2<99999){
						$num1 = "$a2"+"1";
						$nu1= "KARDEX-00".$num1.$id_empresa;
						}else{if($a2<999999){
							$num1 = "$a2"+"1";
							$nu1= "KARDEX-0".$num1.$id_empresa;
							}else{if($a2<9999999){
									$num1 = "$a2"+"1";
									$nu1= "KARDEX-".$num1.$id_empresa;
									}
								}
						}
					}
				}
			}
	}								
?>					
           
           <?php
$Result1 = mysql_query("SELECT MAX(id_salida) as a  FROM tab_salida where id_empresa='$id_empresa' ORDER BY id_salida") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],8,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "DESPACH-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "DESPACH-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "DESPACH-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "DESPACH-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "DESPACH-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "DESPACH-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "DESPACH-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}		   
		

$bandera = $_POST['bandera'];
if($pingresar==1){		
 if($bandera=="ok")
   {//inicio if bandera ok
   // INICIA EL GUARDADO DE INFORMACION 
         $_POST['id_variable']="VAR-0001";
		 $transaccion2=$_POST['transaccion1'];
		 $codigo1="1";
		 $id_almacenaje1=$nu;
		 $entrada;
		 $id_cliente1=$_POST['id_cliente2'];
		 $id_lote1=$_POST['id_lote2'];		
		 $id_silo1=$_POST['id_silo2'];	
		 $id_servicio1="SERV-001".$id_empresa;
		 $fecha_entrada1=parseDateMysql($_POST['fecha_entrada']);
		 $hora_entrada1=$_POST['hora_entrada'];	
		 $fecha_salida1=parseDateMysql($_POST['fecha_salida']);
		 $hora_salida1=$_POST['hora_salida'];
		 $peso_teorico1=$_POST['peso_teorico'];	
		 $tipo_peso1=$_POST['tipo_peso'];	
		 $peso_bruto1=$_POST['peso_bruto'];		 	 	 	
		 $peso_tara1=$_POST['peso_tara'];
		 $id_variable1=$_POST['id_variable'];
 		 $peso_vol1=$_POST['peso_vol'];
		 $humedad1=$_POST['humedad'];
		 $temperatura1=$_POST['temperatura'];
		 $grano_entero1=$_POST['grano_entero'];
		 $grano_quebrado1=$_POST['grano_quebrado'];
		 $dan_hongo1=$_POST['dan_hongo'];
		 $impureza1=$_POST['impureza'];
		 $grano_chico1=$_POST['grano_chico'];
		 $grano_picado1=$_POST['grano_picado'];
		 $plaga_viva1=$_POST['plaga_viva'];
		 $plaga_muerta1=$_POST['plaga_muerta'];
		 $stress_crack1	=$_POST['stress_crack'];
		 $olor1=strtoupper($_POST['olor']);
		 $observacion1=strtoupper($_POST['observacion']);
		 $destino1=strtoupper($_POST['destino']);
		 $id_transportista1=$_POST['id_piloto2'];
		 $vapor1=strtoupper($_POST['vapor']);
		 $id_subproducto1=strtoupper($_POST['id_subproducto2']);
		 
		 
		 $id_entrada1="ALMACEN-0000000".$id_empresa;
		 $peso_sin_humedad="0";
		 
		 if (isset($_POST['despacho_ajuste']) && $_POST['despacho_ajuste'] == '1')
      	$despacho_ajuste1="1";
   			else
      	$despacho_ajuste1="0";
		 
// VALIDAR SI EN EL LOTE YA FUE ALMACENADO EL PRODUCTO, PARA REALIZAR LA SALIDA
$consulta="SELECT * FROM tab_almacenaje WHERE id_lote='".$id_lote1."' and id_empresa='$id_empresa'";

$resultado=mysql_query($consulta,$con) or die (mysql_error());
if (mysql_num_rows($resultado)>0)
{
$existe="si";
//echo "Exite al menos un registro";
} else {
$nom_lote1="SELECT * FROM tab_lote WHERE id_lote='".$id_lote1."' and id_empresa='$id_empresa'";
$resultado2=mysql_query($nom_lote1,$con);
$row_lote1=mysql_fetch_assoc($resultado2);	
$nom_lote1=$row_lote1['num_lote'];
$existe="no";	
//	echo "No Existen registros";
}

if($existe=="si"){
		 
	$sql= ("UPDATE `tab_contador` SET `total`='$transaccion2',`salida_almacen`='$entrada' WHERE codigo='$codigo1' and id_empresa='$id_empresa'");
			
			mysql_query("insert into tab_salida(id_salida, entrada, id_cliente, id_lote, id_silo, id_servicio, fecha_entrada, hora_entrada, fecha_salida, hora_salida, peso_teorico, tipo_peso, peso_bruto, peso_tara, id_variable, peso_vol, humedad, temperatura, grano_entero, grano_quebrado, dan_hongo, impureza, grano_chico, grano_picado, plaga_viva, plaga_muerta, stress_crack, olor, destino, observacion,  bandera, id_transportista, vapor, peso_sin_humedad, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica, despacho_ajuste, id_subproducto) values ('$id_almacenaje1', '$entrada', '$id_cliente1','$id_lote1', '$id_silo1', '$id_servicio1','$fecha_entrada1', '$hora_entrada1', '$fecha_salida1','$hora_salida1', '$peso_teorico1', '$tipo_peso1','$peso_bruto1', '$peso_tara1', '$id_variable1', '$peso_vol1', '$humedad1', '$temperatura1', '$grano_entero1', '$grano_quebrado1', '$dan_hongo1', '$impureza1', '$grano_chico1', '$grano_picado1', '$plaga_viva1', '$plaga_muerta1', '$stress_crack1', '$olor1', '$destino1', '$observacion1',  '1', '$id_transportista1', '$vapor1', '$peso_sin_humedad','$id_empresa', '$id_usuario',0, '$fecha_entrada', '$hora','$id_usuario','$fecha_entrada','$hora', '$despacho_ajuste1', '$id_subproducto1')",$con); 
				   
				   mysql_query("insert into tab_kardex(id_kardex, id_almacenaje, id_salida, fecha, hora, id_empresa) values ('$nu1', '$id_entrada1', '$id_almacenaje1', '$fecha_entrada1', '$hora_entrada1', '$id_empresa')",$con); 
					  if(mysql_error())
					  { 
					  $guarda="1";
						
					  }
					  else{
					  	mysql_query($sql,$con);
						$guarda="2";
				  }
 	}else{
		$guarda="3"; // no hay espacio
		}
   }//fin de bandera
}else {$error="4"; // no tiene permisos
   }//fin bandera ok	
	
?>   

<body class="container" <?PHP if($guarda == "2") echo "onload='datos()';"; ?> > 


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

if($guarda=="1"){
	echo '<div class="alert alert-danger">
 						  <a href="f_salida.php" class="alert-link"> Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
unset($_SESSION['$id_cliente1']);
unset($_SESSION['$id_lote1']);
unset($_SESSION['$id_silo1']);
unset($_SESSION['$id_servicio1']);
unset($_SESSION['$id_transportista1']);
unset($_SESSION['$peso_bruto1']);
unset($_SESSION['$peso_teorico1']);	
unset($_SESSION['$id_subproducto2']);	
					  
	}
 if($guarda == "2")
 {
	 echo '<div class="alert alert-success">
 						  <a href="f_salida.php" class="alert-link">Datos almacenados con éxito !!! Haga click para continuar .....</a>
						  </div>';
unset($_SESSION['$id_cliente1']);
unset($_SESSION['$id_lote1']);
unset($_SESSION['$id_silo1']);
unset($_SESSION['$id_servicio1']);
unset($_SESSION['$id_transportista1']);
unset($_SESSION['$peso_bruto1']);
unset($_SESSION['$peso_teorico1']);						  
}

if($guarda == "3")
 {
	 echo '<div class="alert alert-success">
 						  <a href="f_salida.php" class="alert-link">El Lote '.$nom_lote1.' no contiene producto almacenado !!! Haga click para continuar .....</a>
						  </div>';
}
if($error==4){
echo '<div class="alert alert-danger">
 						  <a href="f_salida.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';
}

?>

           <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>DESPACHO DE GRANOS BASICOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form role="form" name="formulario"  method="post" action="f_salida.php">
           <input type="hidden"  name="bandera" value="0">
           <input type="hidden"  name="variable" value="0"> 
           <input type="hidden"  name="reporte" value="<?PHP echo $nu; ?>">             
 			<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif">                       
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-4">
              <div class="form-group">
               <label for="transaccion">TRANSACCION</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $transaccion;?>" id="transaccion1"   name="transaccion1" autocomplete="off" style="background:#FFF;" readonly>
                      
                              
                  </div>
              </div>
              <div class="col-md-4">
              <div class="form-group">
               <label for="entrada">ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $entrada;?>" id="entrada1"  name="entrada1" autocomplete="off" style="background:#FFF;" readonly>
                        
                              
                  </div>
              </div>
              
              <div class="col-md-4">
              <div class="form-group">
               <label for="moneda_servicio">FECHA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $fecha ;?>" id="fecha_entrada" name="fecha_entrada" autocomplete="off" readonly style="background:#FFF;">
                      
                              
                  </div>
              </div>
              </div><!--- FIN ROW----->
           
         
            <div class="row"><!--- INICIO ROW----->
              <div class="col-md-4">
              <div class="form-group">
               <label for="moneda_servicio">HORA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $hora;?>" id="hora_entrada" name="hora_entrada" autocomplete="off" readonly style="background:#FFF;">
              </div>
              </div>
              <div class="col-md-4">
              <div class="form-group">
               <label for="moneda_servicio">FECHA SALIDA</label>
               <input type="text" class="form-control input-lg" id="fecha_salida" name="fecha_salida" autocomplete="off" readonly style="background:#FFF;">
                      
                  </div>
              </div>
              <div class="col-md-4">
              <div class="form-group">
               <label for="moneda_servicio">HORA SALIDA</label>
               <input type="text" class="form-control input-lg"  id="hora_salida" name="hora_salida" autocomplete="off" readonly style="background:#FFF;">
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
           
         
            <div class="row"><!--- INICIO ROW----->
              <div class="col-md-4">
              <div class="form-group">
               <label for="moneda_servicio">CLIENTE</label>
                         <?php
						 $id_cli="CLI-000".$id_empresa;
						$tabla=mysql_query("SELECT * FROM tab_almacenaje as a, tab_cliente as b WHERE a.id_cliente=b.id_cliente and a.id_cliente!='$id_cli' and b.bandera='0' group by b.id_cliente");
						 //      $tabla=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente!='CLI-000'");
						  ?>
                      <select name="id_cliente2" class="form-control input-lg chosen" size="1" id="id_cliente2">
                            <option value="<?PHP echo $id_cliente11; ?>"><?php echo $nombre_cliente1;?></option>
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
               <div class="col-md-4">
              <div class="form-group">
               <label for="moneda_servicio">LOTE</label>
                <div id="feedback"><select class="chosen" name="id_lote2" id="id_lote2" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="<?php echo $id_lote11; ?>"><?PHP echo $nom_lote1; ?></option></select></div>
                  </div>
              </div>
             
              
              <div class="col-md-4">
              <div class="form-group">
               <label for="moneda_servicio">SILO</label>
        		 <div id="feedback2"><select class="chosen" name="id_silo2" id="id_silo2" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="<?PHP echo $id_silo11; ?>"><?PHP echo $nom_silo1; ?></option> </select></div>
                  </div>
              </div>
               </div>
              
               <div class="row"><!--- INICIO ROW----->
              
              <div class="col-md-4" >
              <div class="form-group">
               <label for="moneda_servicio">SERVICIOS DEL LOTE</label>
                 <?PHP
               $tabla_servicio=mysql_query("SELECT * FROM tab_servicio as a, tab_detalle_servicio as b WHERE a.id_servicio=b.id_servicio and b.id_lote = '".$_SESSION['$id_lote1']."' and b.id_cliente = '".$_SESSION['$id_cliente1']."' and a.id_empresa='".$id_empresa."' and a.bandera=0");
			   
			   ?>
              <div id="feedback3"> <select size="5" name="id_servicio2" id="id_servicio2" class="form-control input-lg" style="height: auto; background:#FFF;" > 
              <option value="<?PHP echo $id_servicio11; ?>"><?PHP echo $nom_servicio1; ?></option>
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
             
             
               
                 <div class="col-md-4">
              <div class="form-group">
               <label for="moneda_servicio">SUBPRODUCTO</label>
        		 <div id="feedback5"><select class="chosen" name="id_subproducto2" id="id_subproducto2" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="<?PHP echo $id_subproducto1; ?>"><?PHP echo $nom_subproducto1; ?></option> </select></div>
                  </div>
              </div>
               <div class="col-md-4">
              <div class="form-group">
               <label for="moneda_servicio">PILOTO</label>
                 <div class="input-group">
        		 <div id="feedback4"><select class="chosen"  name="id_piloto2" id="id_piloto2" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="<?PHP echo $id_transportista11; ?>"><?PHP echo $nom_transportista1; ?></option> </select>
                 </div>
                 <span class="input-group-addon"> <button class="btn btn-default" type="button" id="btnbus" title="Agregar Transportista" data-toggle="modal" data-target="#modaltransportista">Nuevo</button></span>
            	</div>
                </div>
			</div>
             
           </div><!--- FIN ROW----->

   
           <br>
           <!-- PARA CAPTURA LOS PESOS -->
           <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>PESO TEORICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_teorico"  name="peso_teorico"  placeholder="PESO TEORICO" autocomplete="off" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
            
          <div class="col-md-4">
         <div class="form-group">
              <label>PESO BRUTO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_bruto"  name="peso_bruto"  placeholder="PESO BRUTO" autocomplete="off" readonly style="background:#FFF;" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PESO TARA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_tara"  name="peso_tara"  placeholder="PESO TARA" autocomplete="off" style="background:#FFF;" value="<?PHP echo $peso_tara_url, $peso_bruto11;; ?>" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW-----> 
           <br>
        <div class="row"><!--- INICIO ROW----->
        <div class="col-md-4">
          <div class="form-group">
             <label for="observacion">DESTINO</label>
             <textarea name="destino" class="form-control" rows="3" placeholder="DESTINO DEL PRODUCTO" autocomplete="off" id="destino" style="text-transform:uppercase"></textarea>
             
          </div>
          </div>
        
          <div class="col-md-4">
          <div class="form-group">
             <label for="direccion_comprador">OBSERVACION</label>
             <textarea name="observacion" class="form-control" rows="3" placeholder="OBSERVACIONES" autocomplete="off" id="observacion" style="text-transform:uppercase"></textarea>
          </div>
          </div>
        
        
              <div class="col-md-2">
              <div class="form-group">
              <label for="opciones"> PESO A REALIZAR </label>
                	 <div>
                     </br>
                 <input type="radio" id="tipo_peso" value="1" name="tipo_peso" onClick="peso_bruto.disabled = false;  peso_tara.disabled=true; fecha_salida.value=''; hora_salida.value=''; " disabled>  PESO BRUTO 
                 </div>
                 </div>
                 </div>
              
               <div class="col-md-2">
              	<div class="form-group">
                 </br></br>
				<input type="radio" id="tipo_peso" value="2" name="tipo_peso" onClick="btnguardar.disabled=false;"  >  PESO TARA 
                
                 </div>
                 </div>
          
          </div><!--- FIN ROW----->
          
          <div class="checkbox">
              <label>
              <input type="checkbox" value="1" name="despacho_ajuste" >DESPACHO POR AJUSTE?
              </label>
          </div>
		

<br><br>
      
           	  <table width="220" border="0" align="right">
 		   	    <tr>
              	      <td width="100"><button type="reset" onClick="cancelar()" id="btnsub" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="submit" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right" disabled>  </button></td>
              	    </tr>
           	      </table> 
            
           </form> 
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
<!--  INICIA MODAL DEL TRANSPORTISTA -->
<?php
$Result1 = mysql_query("SELECT MAX(id_transportista) as a  FROM tab_transportista where id_empresa='$id_empresa' ORDER BY id_transportista") or die(mysql_error());
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
 ?>

<!-- INSERTAR MOTORISTA EN LA TABLA -->

<div class="modal fade" id="modaltransportista">
	<form id="ftransportista" name="ftransportista" action="f_salida.php" method="post">
  	<input type="hidden" name="insertarum">
  	<input type="hidden" name="insercliente">
  	<input type="hidden" name="inserlote"> 
  	<input type="hidden" name="insersilo">
  	<input type="hidden" name="inserservicio">  
  	<input type="hidden" name="pesoteorico">
  	<input type="hidden" name="pesobruto">                           
    
        <div class="modal-dialog">
          <div class="modal-content">                        
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            	<h3 class="modal-title">Agregar Transportista</h3>
            </div>            
          <div class="modal-body"> 
           <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">CODIGO</label>
                       <input type="text" class="form-control input-lg" style="text-transform:uppercase; background:#FFF;" id="codigounidad"  name="codigounidad" autocomplete="off" readonly value="<?PHP echo $nu; ?>">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
         
            <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">NOMBRE</label>
                       <input type="text" class="form-control input-lg" style="text-transform:uppercase;" id="nom_transportista" placeholder="Nombres del Motorista"   name="nom_transportista" autocomplete="off" required>
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">APELLIDO</label>
                       <input type="text" class="form-control input-lg" style="text-transform:uppercase;" id="ape_transportista" placeholder="Apellidos del Motorista"   name="ape_transportista" autocomplete="off" required >
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">PLACA</label>
                       <input type="text" class="form-control input-lg" id="placa_vehiculo" style="text-transform:uppercase;" placeholder="Placa del vehiculo"   name="placa_vehiculo" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
         		<button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
               	<button class="btn btn-primary" type="button" onClick="validarum();">Guardar</button>
    </div>
    <div>               
    </form>
</div>

<!-- FIN DEL MODAL TRANSPORTISTA -->


 <?php 
// Inserta transportista
 if(isset($_POST['insertarum']) && $_POST['insertarum']=="guardarum"){

		include('insertar_transportista.php');
		
		echo" <script language='javascript'>";
			echo" alert('Datos del Piloto almacenados correctamente...');";
			echo"location.href='f_salida.php';";
			echo" </script>";
		
  }
?>
</body> 
</html>
<?php 
mysql_close($con);
?>