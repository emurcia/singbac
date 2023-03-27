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
 $id_usuario=$_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];
 
 		$peso_bruto_url1=$_GET['peso_bruto'];
 		 list($peso_bruto_url, $quitar) = split(' ', $peso_bruto_url1);
		$id_cliente11=$_SESSION['$id_cliente1'];
		$id_lote11= $_SESSION['$id_lote1'];	
		$id_silo11= $_SESSION['$id_silo1'];	
		//$id_servicio11=$_SESSION['$id_servicio1'];
		$id_transportista11=$_SESSION['$id_transportista1'];
		$peso_teorico11=$_SESSION['$peso_teorico1'];
		$peso_bruto11=$_SESSION['$peso_bruto1'];
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

							
																								
$tabla_transportista=mysql_query("SELECT * FROM tab_transportista Where id_transportista='".$_SESSION['$id_transportista1']."' and id_empresa='$id_empresa';");
						 		while($valor5=mysql_fetch_array($tabla_transportista)){
									$nom_transportista1= $valor5["nom_transportista"]." ".$valor5["ape_transportista"];
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

$tabla6="SELECT p.humedad FROM tab_producto as p join tab_lote as l on p.id_producto=l.id_producto where l.id_lote='".$_SESSION['$id_lote1']."' and l.id_empresa='$id_empresa' and l.bandera='0'";
$select6 = mysql_query($tabla6,$con);
$row6 = mysql_fetch_array($select6, MYSQL_ASSOC);
$variable=$row6['humedad'];
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
<script src="../assets/javascript/chosen.jquery.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">

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
		if(document.formulario.id_variable.value=="VAR-000"){
			document.formulario.variable.value="VAR-000";
		 }
		
		document.formulario.bandera.value='ok';
		document.formulario.submit();
		
}// fin guardar

function tara(cod){
		document.formulario.busca.value="tara";	
		document.formulario.cod_prod_modif.value=cod;
	//	document.formulario.action="http://localhost/bascula/?parametro="+cod+"&direccion=http://190.143.196.3/sylos/forms/f_almacenaje2.php";//capturar el Tara.
		document.formulario.action="http://192.168.178.161/bascula/?parametro="+cod+"&direccion=http://localhost/silos/forms/f_almacenaje2.php";//capturar el Tara.
		document.formulario.submit();
	} 



function cancelar(){
	document.formulario.btnguardar.disabled=false;
	document.location.href='f_almacenaje.php';
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


function cerrar() //funcionar para activas las cajas de textos
  {
	document.getElementById('formulario_responsable').style.display = 'none';//oculta contenido
		
  }	

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
 function datos(){
	 window.open('../reportes/Rp_recepcion_vehiculo.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
	 if (window.confirm("Desea imprimir el informe de calidad?")) { 
  window.open('../reportes/Rp_recepcion_calidad.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}
}

function validarum()
{	
	document.ftransportista.insercliente.value=document.formulario.id_cliente2.value;
	document.ftransportista.inserlote.value=document.formulario.id_lote2.value;
	document.ftransportista.insersilo.value=document.formulario.id_silo2.value;	
	//	document.ftransportista.inserservicio.value=document.formulario.id_servicio2.value;	
	document.ftransportista.pesoteorico.value=document.formulario.peso_teorico.value;			
	document.ftransportista.pesobruto.value=document.formulario.peso_bruto.value;				
	document.ftransportista.insertarum.value='guardarum';
	document.ftransportista.submit();
}
</script>

<script type="text/javascript">
// FUNCION PARA ACTIVAR SI EL PRODUCTO TIENE HUMEDAD
function estadohumedad(str)
{
  if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				//document.getElementById("formulario_responsable").innerHTML = "";
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","gethumedad.php?q="+str,true);
        xmlhttp.send();
    }

}

// COMPLETA LAS LISTAS DE SELECCION CON PROPIEDAD CHOSEN
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
						
						
								//$('#feedback3').load('select_servicio.php').show();
								$('#id_servicio2').change(function() {//inicio4
								$.post('piloto_select.php', {id_lote_busca:document.formulario.id_lote2.value, id_cliente_busca:document.formulario.id_cliente2.value}, 
								function(result) {
								$('#feedback4').html(result).show();																					 
									}); 									 
								});//fin4
																												 
							}); 									 
						});//fin3	
																						 
					}); 
		   var humedad45 = "";
	       humedad45 = $('#id_lote2').val();
	  	   estadohumedad(humedad45);									 
				});//fin2
				
				 }); 									 
		  });//fin1
		 		  
       });


	  // FUNCION PARA ENVIAR LAS ALERTAS COMPARANDO LAS VARIABLES 

	   function validar_peso(str){
		   var a = str;
		 
		   if(parseFloat(document.formulario.peso_vol.value) > parseFloat(document.formulario.peso_base.value) && document.formulario.pasa1.value==0)
		   {
			   alert('El Peso Volumetrico ingresado es mayor a lo permitido');
			   document.formulario.pasa1.value=1;
			   //return 0;
		   }
		    
		   if(parseFloat(document.formulario.humedad.value) > parseFloat(document.formulario.humedad_base.value) && document.formulario.pasa2.value==0)
		   {
			    alert('La humedad ingresada es mayor a lo permitido');
 			    document.formulario.pasa2.value=1;
				return;

		   }
		   if(parseFloat(document.formulario.temperatura.value) > parseFloat(document.formulario.temperatura_base.value) && document.formulario.pasa3.value==0)
		   {
			    alert('La Temperatura ingresada es mayor a lo permitido');
			   document.formulario.pasa3.value=1;				
				return;
		   }

		   if(parseFloat(document.formulario.grano_entero.value) > parseFloat(document.formulario.grano_entero_base.value) && document.formulario.pasa4.value==0)
		   {
			    alert('El porcentaje de Grano entero ingresado es mayor a lo permitido');
			   document.formulario.pasa4.value=1;				
				return;
		   }
 		 if(parseFloat(document.formulario.grano_quebrado.value) > parseFloat(document.formulario.grano_quebrado_base.value) && document.formulario.pasa5.value==0)
		   {
			    alert('El porcentaje de Grano quebrado ingresado es mayor a lo permitido');
			   document.formulario.pasa5.value=1;				
				return;
		   }
			if(parseFloat(document.formulario.dan_hongo.value) > parseFloat(document.formulario.dan_hongo_base.value) && document.formulario.pasa6.value==0)
		   {
			    alert('El porcentaje de daño por hongo ingresado es mayor a lo permitido');
			   document.formulario.pasa6.value=1;				
				return;
		   }
		   if(parseFloat(document.formulario.impureza.value) > parseFloat(document.formulario.impureza_base.value) && document.formulario.pasa7.value==0)
		   {
			    alert('El porcentaje de impureza ingresado es mayor a lo permitido');
			   document.formulario.pasa7.value=1;				
				return;
		   }	
 			if(parseFloat(document.formulario.grano_chico.value) > parseFloat(document.formulario.grano_chico_base.value) && document.formulario.pasa8.value==0)
		   {
			    alert('El porcentaje de grano chico ingresado es mayor a lo permitido');
			   document.formulario.pasa8.value=1;				
				return;
		   }		  
		   if(parseFloat(document.formulario.grano_picado.value) > parseFloat(document.formulario.grano_picado_base.value) && document.formulario.pasa9.value==0)
		   {
			    alert('El porcentaje de grano picado ingresado es mayor a lo permitido');
			   document.formulario.pasa9.value=1;				
				return;
		   }	
		   if(parseFloat(document.formulario.plaga_viva.value) > parseFloat(document.formulario.plaga_viva_base.value) && document.formulario.pasa10.value==0)
		   {
			    alert('El porcentaje de plaga viva ingresado es mayor a lo permitido');
			   document.formulario.pasa10.value=1;				
				return;
		   }
		   if(parseFloat(document.formulario.plaga_muerta.value) > parseFloat(document.formulario.plaga_muerta_base.value) && document.formulario.pasa11.value==0)
		   {
			    alert('El porcentaje de plaga muerta ingresado es mayor a lo permitido');
			   document.formulario.pasa11.value=1;				
				return;
		   }
		   if(parseFloat(document.formulario.stress_crack.value) > parseFloat(document.formulario.stress_crack_base.value)&& document.formulario.pasa12.value==0)
		   {
			    alert('El porcentaje de Stress Crack ingresado es mayor a lo permitido');
			   document.formulario.pasa12.value=1;				
				return;
		   }				   	   		   		   
		   
	   }
	   
</script>
<script>
        $(document).ready(function(){
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
</script>
  <script type="text/javascript">
       $(document).ready(function() {
	  
		   $('#id_lote2').change(function() {//inicio1
			 $.post('mostrar_productos.php', {id_cliente_busca:document.formulario.id_lote2.value}, 
			 function(result) {
				$('#feedback_productos').html(result).show();	
			 }); 									 
		  });//fin1
		 		  
       });
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

 <?php	              
					$sql = "SELECT * FROM `tab_contador` where id_empresa='$id_empresa'"; 
					$result = mysql_query($sql); //usamos la conexion para dar un resultado a la variable
					if ($result> 0){ //si la variable tiene al menos 1 fila entonces seguimos con el codigo
					    while ($fila = mysql_fetch_array($result)) 
						{
							$cont_total=$fila['total'];
							$cod_entrada=$fila['entrada_almacen'];
							$transaccion=$cont_total+1;
							$entrada=$cod_entrada+1; 	
						}
					}
?>					
           
<?php
$Result1 = mysql_query("SELECT MAX(id_almacenaje) as a  FROM tab_almacenaje where id_empresa='$id_empresa' ORDER BY id_almacenaje asc ") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],8,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "ALMACEN-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "ALMACEN-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "ALMACEN-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "ALMACEN-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "ALMACEN-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "ALMACEN-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "ALMACEN-".$num.$id_empresa;
									}
								}
						}
					}
				}
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
		

$bandera = $_POST['bandera'];

 $variable_mostrar = $_POST['variable'];

	
   if($variable_mostrar=="VAR-000"){
	         $_POST['id_variable']="VAR-0001";
			 }else{
			 $id_variable1=$_POST['id_variable'];	 
			 }
 	

if($pingresar=="1"){
 if($bandera=="ok")
   {//inicio if bandera ok
   // INICIA EL GUARDADO DE INFORMACION 
 		 
		 $transaccion2=$_POST['transaccion1'];
		 $codigo1="1";
		 $id_almacenaje1=$nu;
		  $id_kardex1=$nu1;
		 $entrada; 
		 $entrada=$_POST['entrada1']; 
		 $id_cliente1=$_POST['id_cliente2'];
		 $id_lote1=$_POST['id_lote2'];		
		 $id_silo1=$_POST['id_silo2'];	
		 $id_servicio1="SERV-001".$id_empresa;
		 $fecha_entrada1=parseDateMysql($_POST['fecha_entrada']);
		 $hora_entrada1=$_POST['hora_entrada'];	
		 $fecha_salida1=$fecha_entrada1;
		 $hora_salida1=$hora_entrada1;
		 if($_POST['peso_teorico']==""){$peso_teorico1="0.00";}else{$peso_teorico1=$_POST['peso_teorico'];}
		// $peso_teorico1=$_POST['peso_teorico'];	
		 $tipo_peso1=$_POST['tipo_peso'];	
		  if($_POST['peso_bruto']==""){$peso_bruto1="0.00";}else{$peso_bruto1=$_POST['peso_bruto'];}
		// $peso_bruto1=$_POST['peso_bruto'];	
		if($_POST['peso_tara']==""){$peso_tara1="0.00";}else {$peso_tara1=$_POST['peso_tara'];}	 	 	 		 	 	 	
		// $peso_tara1=$_POST['peso_tara'];
		 $id_variable1=$_POST['id_variable'];
 		// $peso_vol1=$_POST['peso_vol'];
		 //$humedad1=$_POST['humedad'];
		 //$temperatura1=$_POST['temperatura'];
		 //$grano_entero1=$_POST['grano_entero'];
		 //$grano_quebrado1=$_POST['grano_quebrado'];
		 //$dan_hongo1=$_POST['dan_hongo'];
		 //$impureza1=$_POST['impureza'];
		 //$grano_chico1=$_POST['grano_chico'];
		 //$grano_picado1=$_POST['grano_picado'];
		 //$plaga_viva1=$_POST['plaga_viva'];
		 //$plaga_muerta1=$_POST['plaga_muerta'];
		// $stress_crack1	=$_POST['stress_crack'];
		  if($_POST['peso_vol']==""){$peso_vol1="0.00";}else {$peso_vol1=$_POST['peso_vol'];}	 	 	 	
 		// $peso_vol1=$_POST['peso_vol'];
 		 if($_POST['humedad']==""){$humedad1="0.00";}else {$humedad1=$_POST['humedad'];}	 	 	 	
		// $humedad1=$_POST['humedad'];
		 if($_POST['temperatura']==""){$temperatura1="0.00";}else {$temperatura1=$_POST['temperatura'];}	 	 	 	
		// $temperatura1=$_POST['temperatura'];
		 if($_POST['grano_entero']==""){$grano_entero1="0.00";}else {$grano_entero1=$_POST['grano_entero'];}	 	 	 	
		//$grano_entero1=$_POST['grano_entero'];
		 if($_POST['grano_quebrado']==""){$grano_quebrado1="0.00";}else {$grano_quebrado1=$_POST['grano_quebrado'];}	 	 	 	
		// $grano_quebrado1=$_POST['grano_quebrado'];
		 if($_POST['dan_hongo']==""){$dan_hongo1="0.00";}else {$dan_hongo1=$_POST['dan_hongo'];}	 	 	 	
		// $dan_hongo1=$_POST['dan_hongo'];
		 if($_POST['impureza']==""){$impureza1="0.00";}else {$impureza1=$_POST['impureza'];}	 	 	 	
		// $impureza1=$_POST['impureza'];
		 if($_POST['grano_chico']==""){$grano_chico1="0.00";}else {$grano_chico1=$_POST['grano_chico'];}	 	 	 	
		// $grano_chico1=$_POST['grano_chico'];
		 if($_POST['grano_picado']==""){$grano_picado1="0.00";}else {$grano_picado1=$_POST['grano_picado'];}	 	 	 	
		// $grano_picado1=$_POST['grano_picado'];
		 if($_POST['plaga_viva']==""){$plaga_viva1="0.00";}else {$plaga_viva1=$_POST['plaga_viva'];}	 	 	 	
		// $plaga_viva1=$_POST['plaga_viva'];
		 if($_POST['plaga_muerta']==""){$plaga_muerta1="0.00";}else {$plaga_muerta1=$_POST['plaga_muerta'];}	 	 	 	
		// $plaga_muerta1=$_POST['plaga_muerta'];
		 if($_POST['stress_crack']==""){$stress_crack1="0.00";}else {$stress_crack1=$_POST['stress_crack'];}	 	 	 	
		 //$stress_crack1=$_POST['stress_crack'];
		
		 $olor1=strtoupper($_POST['olor']);
		 $observacion1=strtoupper($_POST['observacion']);
		 $id_transportista1=$_POST['id_piloto2'];
		 $vapor1=strtoupper($_POST['vapor']);
		 if($_POST['analista']==""){$$analista1="";}else {$$analista1=$_POST['analista'];}	 	 	 	
		 $analista1=strtoupper($_POST['analista']);		 
		  $id_salida1="DESPACH-0000000".$id_empresa;	
		 $neto_sin_humedad=0;

   //VERIFICAR EL ESPACIO EN CADA SILO 
   
// EXTRAE DATOS DEL PESO NETO  QUITAR COMENTARIOS A TODOS LOS (1)   
//$suma_lote_no=mysql_query("SELECT SUM(peso_bruto) AS suma_peso, SUM(peso_tara) AS suma_tara FROM `tab_almacenaje` WHERE id_silo='$id_silo1' and id_lote='$id_lote1' and id_empresa='$id_empresa'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO (1)

// EXTRAE DATOS DEL PESO NETO SIN HUMEDAD
$suma_lote=mysql_query("SELECT SUM(neto_sin_humedad) AS suma_peso FROM `tab_almacenaje` WHERE id_silo='$id_silo1' and id_lote='$id_lote1' and id_empresa='$id_empresa'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO

$row_suma = mysql_fetch_assoc($suma_lote);
 $acumulado_lote=$row_suma['suma_peso']; //SUMA EL PESO BRUTO
// $acumulado_tara=$row_suma['suma_tara'];// SUMA EL PESO TARA (1)
// $total_bruto=$acumulado_lote-$acumulado_tara;// PESO NETO (1)
 $total_bruto= $acumulado_lote;
 
 // SUMA EL EPACIO QUE SE HA SACADO EN EL LOTE (2)
// $suma_lote2=mysql_query("SELECT SUM(peso_bruto) AS suma_peso, SUM(peso_tara) AS suma_tara FROM `tab_salida` WHERE id_silo='$id_silo1' and id_lote='$id_lote1' and id_empresa='$id_empresa'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO
$suma_lote2=mysql_query("SELECT SUM(neto_sin_humedad) AS suma_peso2 FROM `tab_salida` WHERE id_silo='$id_silo1' and id_lote='$id_lote1' and id_empresa='$id_empresa'",$con);

 $row_suma2 = mysql_fetch_assoc($suma_lote2);
 $acumulado_lote2=$row_suma2['suma_peso']; //SUMA EL PESO BRUTO
// $acumulado_tara2=$row_suma2['suma_tara'];// SUMA EL PESO TARA (2)
// $total_bruto2=$acumulado_lote2-$acumulado_tara2; //PESO NETO (2)
 $total_bruto2=$acumulado_lote2;

$cant_lote=mysql_query("SELECT * FROM tab_lote WHERE id_lote='$id_lote1' and id_empresa='$id_empresa'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO
$row_lote = mysql_fetch_assoc($cant_lote);
$capacidad_lote=$row_lote['cant_producto'];
$nombre_lote=$row_lote['num_lote'];

// AL ESPACIO DEL LOTE LE RESTO LO ALMACENADO Y LE RESTO LAS SALIDAS PARA OBTENER EL NUEVO ESPACIO DE ALMACENAMIENTO
 $resta1=$capacidad_lote-$total_bruto+$total_bruto2;
 $espacio_lote=$resta1-$peso_bruto1;
 
 if($peso_bruto1>$capacidad_lote){
	 $resta1=$peso_bruto1-$capacidad_lote;
//	 $espacio_lote=$capacidad_lote;
	}
	
 if($espacio_lote>=0){

$sql= ("UPDATE `tab_contador` SET `total`='$transaccion2',`entrada_almacen`='$entrada' WHERE codigo='$codigo1' and id_empresa='$id_empresa'");

$cli=("UPDATE tab_cliente SET ocupado=1 WHERE id_cliente='$id_cliente1' and id_empresa='$id_empresa'"); 
mysql_query($cli,$con);

$lot=("UPDATE tab_lote SET ocupado=1 WHERE id_lote='$id_lote1' and id_empresa='$id_empresa'");
mysql_query($lot,$con);

$silo=("UPDATE tab_silo SET ocupado=1 WHERE id_silo='$id_silo1' and id_empresa='$id_empresa'");
mysql_query($silo,$con);

$serv=("UPDATE tab_servicio SET ocupado=1 WHERE id_servicio='$id_servicio1' and id_empresa='$id_empresa'");
mysql_query($serv,$con);

$trans=("UPDATE tab_transportista SET ocupado=1 WHERE id_transportista='$id_transportista1' and id_empresa='$id_empresa'");mysql_query($trans,$con);
			
		mysql_query("insert into tab_almacenaje(id_almacenaje, entrada, id_cliente, id_lote, id_silo, id_servicio, fecha_entrada, hora_entrada, fecha_salida, hora_salida, peso_teorico, tipo_peso, peso_bruto, peso_tara, id_variable, peso_vol, humedad, temperatura, grano_entero, grano_quebrado, dan_hongo, impureza, grano_chico, grano_picado, plaga_viva, plaga_muerta, stress_crack, olor, observacion, bandera, id_transportista, vapor, nom_analista, neto_sin_humedad, id_empresa, neto_sin_humedad_maximo, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values ('$id_almacenaje1', '$entrada', '$id_cliente1','$id_lote1', '$id_silo1', '$id_servicio1','$fecha_entrada1', '$hora_entrada1', '$fecha_salida1','$hora_salida1', '$peso_teorico1', '$tipo_peso1','$peso_bruto1', '$peso_tara1', '$id_variable1', '$peso_vol1', '$humedad1', '$temperatura1', '$grano_entero1', '$grano_quebrado1', '$dan_hongo1', '$impureza1', '$grano_chico1', '$grano_picado1', '$plaga_viva1', '$plaga_muerta1', '$stress_crack1', '$olor1', '$observacion1', '1', '$id_transportista1', '$vapor1', '$analista1','$neto_sin_humedad','$id_empresa',0, '$id_usuario',0, '$fecha_entrada', '$hora','$id_usuario','$fecha_entrada','$hora')",$con) or die(mysql_error()); 
		
	$sql_kardex=("insert into tab_kardex(id_kardex, id_almacenaje, id_salida, fecha, hora, id_empresa) values ('$id_kardex1', '$id_almacenaje1', '$id_salida1', '$fecha_entrada1', '$hora_entrada1', '$id_empresa')"); 
	
					  if(mysql_error())
					  { 
					  $guarda="1";
					  echo mysql_error();
						
					  }
					  else{
						  mysql_query($sql,$con);
					  	  mysql_query($sql_kardex,$con);						
						  $guarda="2";
					  }
 	}else{
		$guarda="3"; // no hay espacio
		}
   }//fin de bandera
}else {$error="4"; // no tiene permisos
   }
?>  

<body class="container" <?PHP if($guarda == "2") echo "onload='datos()';";?> > 


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
 						  <a href="f_almacenaje.php" class="alert-link"> Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
unset($_SESSION['$id_cliente1']);
unset($_SESSION['$id_lote1']);
unset($_SESSION['$id_silo1']);
unset($_SESSION['$id_servicio1']);
unset($_SESSION['$id_transportista1']);
unset($_SESSION['$peso_bruto1']);
unset($_SESSION['$peso_teorico1']);
	}
 if($guarda == "2")
 {
	echo '<div class="alert alert-success">
	<a href="f_almacenaje.php" class="alert-link">Datos almacenados con éxito,  aun tiene un espacio disponible en el lote '.$nombre_lote.' de '.$espacio_lote.' Kilogramos.   !!! Haga click para continuar .....</a>
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
	<a href="f_almacenaje.php" class="alert-link">Registro no Almacenado, El Lote '.$nombre_lote.' es sobregirado en '.(-1)*($espacio_lote).' Kilogramos. !!! Haga click para continuar .....</a>
						  </div>';
}

if($error=="4"){
echo '<div class="alert alert-danger">
 						  <a href="f_almacenaje.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';
}
?>

           <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>RECEPCION DE GRANOS BASICOS</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form role="form" name="formulario"  method="post" action="f_almacenaje.php">
           <input type="hidden"  name="bandera" value="0">
           <input type="hidden"  name="variable" value="0"> 
           <input type="hidden"  name="variable2" value="0">            
           <input type="hidden"  name="reporte" value="<?PHP echo $nu; ?>">  
            
 			<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif">                       
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="transaccion">TRANSACCION</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $transaccion;?>" id="transaccion1"   name="transaccion1" autocomplete="off" style="background:#FFF;" readonly>
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="entrada">ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $entrada;?>" id="entrada1"  name="entrada1" autocomplete="off" style="background:#FFF;" readonly >
                 </div>
              </div>
           </div><!--- FIN ROW----->
<div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">FECHA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $fecha;?>" id="fecha_entrada" name="fecha_entrada" autocomplete="off" style="background:#FFF;" readonly>
              </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">HORA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $hora;?>" id="hora_entrada" name="hora_entrada" autocomplete="off" style="background:#FFF;" readonly>
              </div>
              </div>
           </div><!--- FIN ROW----->           
           
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">CLIENTE</label>
                         <?php
						$id_cli="CLI-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_cliente Where id_cliente!='$id_cli' and id_empresa='$id_empresa' and bandera=0;");
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
               <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">LOTE</label>
                <div id="feedback"><select class="chosen" name="id_lote2" id="id_lote2" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="<?php echo $id_lote11; ?>"><?PHP echo $nom_lote1; ?></option></select></div>
                  </div>
              </div>
              </div>
                         
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">SILO</label>
               <div id="feedback2"><select class="chosen" name="id_silo2" id="id_silo2" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="<?PHP echo $id_silo11; ?>"><?PHP echo $nom_silo1;?> </option> 
                </select></div>
                  </div>
              </div>
              <div class="col-md-6" >
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
           </div><!--- FIN ROW----->
            <br>
           <!-- PARA CAPTURA LOS PESOS -->
           <div class="row"><!--- INICIO ROW----->
          <div class="col-md-6">
         <div class="form-group">
              <label>PESO TEORICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_teorico"  name="peso_teorico"  placeholder="PESO TEORICO" autocomplete="off" value="<?PHP echo $peso_teorico11; ?>" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
           <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">PILOTO</label>
                 <div class="input-group">
        		 <div id="feedback4"><select  class="chosen" name="id_piloto2" id="id_piloto2" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="<?PHP echo $id_transportista11; ?>"><?PHP echo $nom_transportista1; ?></option> </select>
                 </div>
                 <span class="input-group-addon"> <button type="button" class="btn btn-default" id="btnbus" title="Agregar Transportista" data-toggle="modal" data-target="#modaltransportista">Nuevo</button></span>
            	</div>
                </div>
              </div>
          </div>	<!-- FIN -->
          <br>
           <div class="row"><!--- INICIO ROW----->
              <div class="col-md-4">
              <div class="form-group">
              <label for="opciones"> PESO A REALIZAR </label>
              </div>
              </div>
              </div><!-- FIN DE ROW -->
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
          	 <div>
                 <input type="radio" id="tipo_peso" value="1" name="tipo_peso" onClick="peso_bruto.disabled = false;  peso_tara.disabled=true; btnguardar.disabled=false; if(document.formulario.id_piloto2.value=='TRANS-000') alert('Seleccione Piloto'); ">  PESO BRUTO 
                 </div>
                 </div>
                 </div>
              
               <div class="col-md-6">
              	<div class="form-group">
				<label for="tipo_peso"></label>
                 <input type="radio" id="tipo_peso" value="2" name="tipo_peso" disabled >  PESO TARA 
                
                 </div>
                 </div>
             </div><!--- FIN ROW----->
                     <div class="row"><!--- INICIO ROW----->
          <div class="col-md-6">
         <div class="form-group">
              <label>PESO BRUTO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_bruto"  name="peso_bruto"  placeholder="PESO BRUTO" autocomplete="off"  style="background:#FFF;" value="<?PHP echo $peso_bruto_url, 		$peso_bruto11;?>">
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-6">
         <div class="form-group">
              <label>PESO TARA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_tara"  name="peso_tara"  placeholder="PESO TARA" autocomplete="off" readonly style="background:#FFF;" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW-----> 
          
       <br>
       <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="direccion_comprador">OBSERVACION</label>
             <textarea name="observacion" class="form-control" rows="3" placeholder="Observaciones" autocomplete="off" id="observacion" style="text-transform:uppercase"></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
          
<?PHP  if($variable=="1"){
echo '<label><input type="checkbox" name="numedad" id="humedad" onclick="activar_textos()" value="0"> CONTROL DE CALIDAD </label>
';
} 
       
?>
       <div id="txtHint" class="checkbox">
       </div>    
            
          	<div  style='display:none;' id="formulario_responsable">
     		<div class="row" >
  		   	<div class="col-md-12">
        		
			<div class="panel-heading bg-info"><strong>CONTROL DE CALIDAD</strong></div> <!-- PANEL 1 --->  
           	<div class="panel-body" >
                  
           <div class="row"><!--- INICIO ROW----->
                        
             <div class="col-md-4">
              <div class="form-group">
              <!-- DEFINICION DE VARIABLES -->
               <input type="hidden" name="peso_base" value="0">
               <input type="hidden" name="humedad_base" value="0">  
               <input type="hidden" name="temperatura_base" value="0">  
               <input type="hidden" name="grano_entero_base" value="0">  
               <input type="hidden" name="grano_quebrado_base" value="0">
               <input type="hidden" name="dan_hongo_base" value="0">                
               <input type="hidden" name="impureza_base" value="0">               
               <input type="hidden" name="grano_chico_base" value="0">
               <input type="hidden" name="grano_picado_base" value="0">
               <input type="hidden" name="plaga_viva_base" value="0">
               <input type="hidden" name="plaga_muerta_base" value="0">               
               <input type="hidden" name="stress_crack_base" value="0">
               <input type="hidden" name="pasa1" value="0">
               <input type="hidden" name="pasa2" value="0">
               <input type="hidden" name="pasa3" value="0">
               <input type="hidden" name="pasa4" value="0">
               <input type="hidden" name="pasa5" value="0">
               <input type="hidden" name="pasa6" value="0">              
               <input type="hidden" name="pasa7" value="0">
               <input type="hidden" name="pasa8" value="0">  
			   <input type="hidden" name="pasa9" value="0">
               <input type="hidden" name="pasa10" value="0">              
               <input type="hidden" name="pasa11" value="0">
               <input type="hidden" name="pasa12" value="0">               
               <label for="moneda_servicio">CATEGORIA</label>
                         <?php
						 $id_var="VAR-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_variables WHERE id_variable!='$id_var' and id_empresa='$id_empresa'");
						  ?>
                      <select name="id_variable" class="form-control input-lg chosen"  size="1" id="id_variable" >
                            <option value="VAR-000">SELECCION CATEGORIA </option>
							 <?php 
								while($valor=mysql_fetch_array($tabla)){
									$codigo_variable= $valor['id_variable'];
									$nombre_variable= $valor["nom_variable"];

									echo "<option value='$codigo_variable' onClick='document.formulario.peso_base.value=\"".$valor['peso_vol']."\"; validar_peso(document.formulario.peso_base.value); document.formulario.humedad_base.value=\"".$valor['humedad']."\"; validar_peso(document.formulario.humedad_base.value); document.formulario.temperatura_base.value=\"".$valor['temperatura']."\"; validar_peso(document.formulario.temperatura_base.value); document.formulario.grano_entero_base.value=\"".$valor['grano_entero']."\"; validar_peso(document.formulario.grano_entero_base.value); document.formulario.grano_quebrado_base.value=\"".$valor['grano_quebrado']."\"; validar_peso(document.formulario.grano_quebrado_base.value); document.formulario.dan_hongo_base.value=\"".$valor['dan_hongo']."\"; validar_peso(document.formulario.dan_hongo_base.value); document.formulario.impureza_base.value=\"".$valor['impureza']."\"; validar_peso(document.formulario.impureza_base.value); document.formulario.grano_chico_base.value=\"".$valor['grano_chico']."\"; validar_peso(document.formulario.grano_chico_base.value); document.formulario.grano_picado_base.value=\"".$valor['grano_picado']."\"; validar_peso(document.formulario.grano_picado_base.value); document.formulario.plaga_viva_base.value=\"".$valor['plaga_viva']."\"; validar_peso(document.formulario.plaga_viva_base.value); document.formulario.plaga_muerta_base.value=\"".$valor['plaga_muerta']."\"; validar_peso(document.formulario.plaga_muerta_base.value); document.formulario.stress_crack_base.value=\"".$valor['stress_crack']."\"; validar_peso(document.formulario.stress_crack_base.value); document.formulario.pasa1.value=0; document.formulario.pasa2.value=0; document.formulario.pasa3.value=0; document.formulario.pasa4.value=0; document.formulario.pasa5.value=0; document.formulario.pasa6.value=0; document.formulario.pasa7.value=0; document.formulario.pasa8.value=0; document.formulario.pasa9.value=0;  document.formulario.pasa10.value=0; document.formulario.pasa11.value=0; document.formulario.pasa12.value=0;' >";
									
									echo utf8_encode("$nombre_variable");
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
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_vol"  name="peso_vol"  placeholder="PESO VOLUMETRICO" autocomplete="off" onKeyUp="validar_peso(document.formulario.peso_base.value);" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
         
            <div class="col-md-4">
         <div class="form-group">
              <label>HUMEDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="humedad"  name="humedad"  placeholder="HUMEDAD" autocomplete="off" onKeyUp="validar_peso(document.formulario.humedad_base.value);"  onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>TEMPERATURA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="temperatura"  name="temperatura"  placeholder="TEMPERATURA" autocomplete="off" onKeyUp="validar_peso(document.formulario.temperatura_base.value);" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">GRADOS</span>
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
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_entero"  name="grano_entero"  placeholder="GRANO ENTERO" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_entero_base.value);" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO QUEBRADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_quebrado"  name="grano_quebrado"  placeholder="GRANO QUEBRADO" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_quebrado_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>DAÑO POR HONGO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="dan_hongo"  name="dan_hongo"  placeholder="TEMPERATURA" autocomplete="off" onKeyUp="validar_peso(document.formulario.dan_hongo_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">PORCENTAJE</span>
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
              <input type="text" class="form-control input-lg soloNUMEROS" id="impureza"  name="impureza"  placeholder="IMPUREZA" autocomplete="off" onKeyUp="validar_peso(document.formulario.impureza_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO CHICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_chico"  name="grano_chico"  placeholder="GRANO CHICO" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_chico_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>GRANO PICADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_picado"  name="grano_picado"  placeholder="GRANO PICADO" autocomplete="off" onKeyUp="validar_peso(document.formulario.grano_picado_base.value);" onkeypress="mascara(this, '#.##')" maxlength="4">
              <span class="input-group-addon">PORCENTAJE</span>
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
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_viva"  name="plaga_viva"  placeholder="PLAGA VIVA" autocomplete="off" onKeyUp="validar_peso(document.formulario.plaga_viva_base.value);" >
              <span class="input-group-addon">UNIDADES</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PLAGA MUERTA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_muerta"  name="plaga_muerta"  placeholder="PLAGA MUERTA" autocomplete="off" onKeyUp="validar_peso(document.formulario.plaga_muerta_base.value);" >
              <span class="input-group-addon">UNIDADES</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>STRESS CRACK </label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="stress_crack"  name="stress_crack"  placeholder="STRESS CRACK" autocomplete="off" onKeyUp="validar_peso(document.formulario.stress_crack_base.value);" onkeypress="mascara(this, '##.##')" maxlength="5">
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>OLOR</label>
              <input type="text" class="form-control input-lg" id="olor"  name="olor"  placeholder="OLOR" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         <div class="col-md-4">
         <div class="form-group">
              <label>VAPOR</label>
              <input type="text" class="form-control input-lg" id="vapor"  name="vapor"  placeholder="VAPOR" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         <div class="col-md-4">
         <div class="form-group">
              <label>ANALISTA</label>
              <input type="text" class="form-control input-lg" id="analista"  name="analista"  placeholder="ANALISTA" autocomplete="off" style="text-transform:uppercase;" >
         </div>
      	 </div>
         </div><!--- FIN ROW----->
       <br>
                         
         </div></div></div></div>
          
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
<?PHP include("footer.php");  ?>

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
	<form id="ftransportista" name="ftransportista" action="f_almacenaje.php" method="post">
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
                       <input type="text" class="form-control input-lg" style="text-transform:uppercase; background:#FFF;" id="codigounidad"  name="codigounidad" autocomplete="off" readonly  value="<?PHP echo $nu; ?>">
                     </div>
                  </div>
             </div><!--- FIN ROW----->  
         
            <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="usuario">NOMBRE</label>
                       <input type="text" class="form-control input-lg" style="text-transform:uppercase;"id="nom_transportista" placeholder="Nombres del Motorista"   name="nom_transportista" autocomplete="off" required>
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
		echo"location.href='f_almacenaje.php';";
		echo" </script>";
  }

?>
</body> 
</html>
<?PHP mysql_close(); ?>