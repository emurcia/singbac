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
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");
$ano=date('Y');
$bandera = $_POST['bandera1'];
$codigo1="1";

?>
<?PHP
$correo_usuario = $_POST['correo_usuario'];
$pass_usuario = $_POST['pass_usuario'];
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

    	$('#tblInstituciones1').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX":"100%"
	 });
	 
     $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=09 && tecla.keyCode !=127 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
            });
		
});
</script>

<script>
function habilitar_select1(){
	document.formulario.id_silo.disabled=false;
	}

	
function habilitar_select2(){
	document.formulario.id_origen.disabled=false;
	}

function habilitar_select3(){
	document.formulario.id_producto.disabled=false;
	}	

function habilitar_select4(){
	document.formulario.lista.disabled=false;
	}	
		
function guardar(){
var tmsel = document.getElementById('dos').length;
var t="";

			t=document.getElementById('dos').options[0].value;
			document.formulario.pasar_parametro.value=t;
				for(var z = 1; z < tmsel; z++)
				{
				t = t + "/" + document.getElementById('dos').options[z].value;
				document.formulario.pasar_parametro.value=t;
				}
		
	
		document.formulario.bandera.value='ok';
		document.formulario.submit();

		
}// fin guardar

function enviar(cod){
		document.formulario.busca.value="actualizarlote";	
		document.formulario.cod_prod_modif.value=cod;
		document.formulario.action='f_mod_lote.php';//redireccionar a musuario.php
		document.formulario.submit();
	}
	

  
function mascara(t, mask){
 var i = t.value.length;
 var saida = mask.substring(1,0);
 var texto = mask.substring(i)
 if (texto.substring(0,1) != saida){
 t.value += texto.substring(0,1);
 }
 }  
 
function agregar(){
document.formulario.btnguardar.disabled=false;
var sel="";
var aa = document.formulario.lista.options.selectedIndex;
var rec = new Array();

if(aa !=-1){
var x = document.getElementById("dos");
var option = document.createElement("option");
var x1 = document.getElementById("uno");
option.text = x1.options[x1.selectedIndex].value;
x.add(option);
var x = document.getElementById("uno");
x.remove(x.selectedIndex);
}
else
alert("no hay opciones selecciondas");
}


function quitar(){

var sel="", aa = document.formulario.sel2.options.selectedIndex, rec = new Array();

if(aa !=-1){
var x = document.getElementById("uno");
var option = document.createElement("option");

var x1 = document.getElementById("dos");
option.text = x1.options[x1.selectedIndex].value;
x.add(option);
var x = document.getElementById("dos");
x.remove(x.selectedIndex);
}
else
alert("no hay opciones selecciondas");
}

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
  </script>
<script type="text/javascript">
       $(document).ready(function() {
		   $('#id_producto').change(function() {//inicio1
			 $.post('lote_sub_producto.php', {id_producto_busca:document.formulario.id_producto.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
			 }); 									 
		  });//fin1
       });
</script> 
<script type="text/javascript">
       $(document).ready(function() {
		   $('#id_origen').change(function() {//inicio1
			 $.post('capacidad_silo.php', {id_silo_buscar:document.formulario.id_silo.value}, 
			 function(result) {
				$('#feedback2').html(result).show();	
			 }); 									 
		  });//fin1
       });
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
	 
$usu_utilizado=mysql_query("SELECT * from tab_lote where id_lote='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']=="0"){ // no ha sido utilizado
		$lleno="0";
  }else{ // Posse datos
  	 	$lleno="1";
  }	 
	 
	 
if ($lleno=="0"){
$resultado = eliminar_su("tab_lote","id_lote",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
if($resultado=="1"){
	mysql_query("DELETE FROM `tab_detalle_servicio` where id_lote='$id_eliminar' and id_empresa='$empresa'");
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


<body class="container" >
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
// VERIFICAR CAMBIO DE AÑO
$Result_ano = mysql_query("SELECT max(substr(num_lote,-4,4)) as aaaa  FROM tab_lote ORDER BY id_lote and id_empresa='$id_empresa'") or die(mysql_error());
$an=mysql_fetch_assoc($Result_ano);
$an1=$an['aaaa'];
if ($ano!=$an1){
$transaccion="1";
$sql= mysql_query("UPDATE `tab_contador` SET `num_lote`='$transaccion' WHERE codigo='$codigo1' and id_empresa='$id_empresa'");

}else{
	$sql = "SELECT * FROM `tab_contador` where id_empresa='$id_empresa'"; 
		$result = mysql_query($sql); //usamos la conexion para dar un resultado a la variable
			if ($result> 0){ //si la variable tiene al menos 1 fila entonces seguimos con el codigo
				 while ($fila = mysql_fetch_array($result)) 
					{
							$num_lotes=$fila['num_lote'];
							$transaccion=$num_lotes+1;
							 	
						}
					}
	
$Result1 = mysql_query("SELECT MAX(id_lote) as a  FROM tab_lote where id_empresa='$id_empresa' ORDER BY id_lote asc ") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],4,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "LOT-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "LOT-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "LOT-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "LOT-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "LOT-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "LOT-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "LOT-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}
}

/*

$Result1 = mysql_query("SELECT max(id_lote) as a  FROM tab_lote ORDER BY id_lote and id_empresa='$id_empresa'") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],4,3);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "LOT-00".$num.$id_empresa;
	}else{
		if ($a1<99){
			$num = "$a1"+"1";
			$nu= "LOT-0".$num.$id_empresa;
		}else{
			 if($a1<999){
				$num = "$a1"+"1";
				$nu= "LOT-".$num.$id_empresa;
				}
			}
	} */


$Result3 = mysql_query("SELECT MAX(id_inventario) as aaa  FROM tab_inventario where id_empresa='$id_empresa' ORDER BY id_inventario asc ") or die(mysql_error());
$dec3=mysql_fetch_assoc($Result3);
$a3=substr($dec3['aaa'],4,7);
if ($a3<9)
	{
	$num3 = "$a3"+"1";
	$in= "INV-000000".$num3.$id_empresa;
	}else{if ($a3<99){
			$num3 = "$a3"+"1";
			$in= "INV-00000".$num3.$id_empresa;
		}else{if($a3<999){
				$num3 = "$a3"+"1";
				$in= "INV-0000".$num3.$id_empresa;
				}else{if($a3<9999){
					$num3 = "$a3"+"1";
					$in= "INV-000".$num3.$id_empresa;
					}else{if($a3<99999){
						$num3 = "$a3"+"1";
						$in= "INV-00".$num3.$id_empresa;
						}else{if($a3<999999){
							$num3 = "$a3"+"1";
							$in= "INV-0".$num3.$id_empresa;
							}else{if($a3<9999999){
									$num3 = "$a3"+"1";
									$in= "INV-".$num3.$id_empresa;
									}
								}
						}
					}
				}
			}	
	}
   

/*			
$Result3 = mysql_query("SELECT MAX(id_inventario) as a  FROM tab_inventario Where id_empresa='$id_empresa' ORDER BY id_inventario") or die(mysql_error());
$dec3=mysql_fetch_assoc($Result3);
$a3=substr($dec3['a'],4,3);
if ($a3<9)
	{
	$num2 = "$a3"+"1";
	$in= "INV-00".$num2.$id_empresa;
	}else{
		if ($a3<99){
			$num2 = "$a3"+"1";
			$in= "INV-0".$num2.$id_empresa;
		}else{
			 if($a3<999){
				$num2 = "$a3"+"1";
				$in= "INV-".$num2.$id_empresa;
				}
			}
	}
	
	*/										

// INICIA EL GUARDADO DE INFORMACION 
		$bandera = $_POST['bandera'];
	 	$id_lote1=$nu;
		$in;
 		$num_lote1=$_POST['num_lote'].$ano;
		$id_cliente1=$_POST["id_cliente"];	
		$id_producto1=$_POST["id_producto"];
		$id_subproducto1=$_POST["id_subproducto"];		
		$cant_producto1=$_POST["cant_producto"];		 			 	 		 	
		$id_origen1=$_POST["id_origen"];
		$id_silo1=$_POST["id_silo"];		
		$servicios=$_POST["pasar_parametro"];
		$movimiento1=0;
		$peso_sin_humedad1=0;	
		$transaccion2=$_POST['num_lote'];	
		
if($pingresar=="1"){		 
    if($bandera=="ok")
   {//inicio if bandera ok

//VERIFICAR EL ESPACIO EN CADA SILO   
$suma_lote=mysql_query("SELECT SUM(cant_producto) AS suma_peso FROM `tab_detalle_servicio` WHERE id_silo='$id_silo1' and bandera=0 and num_servicio=1",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO, 0 ACTIVO, 1 INACTIVO
$row_suma = mysql_fetch_assoc($suma_lote);
$id_suma1=$row_suma['suma_peso'];

$cant_lote=mysql_query("SELECT * FROM tab_silo WHERE id_silo='$id_silo1' and id_empresa='$id_empresa' and bandera=0",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO; 0 ACTIVO, 1 INACTIVO
$row_suma = mysql_fetch_assoc($cant_lote);
$capacidad_silo=$row_suma['cap_silo'];
$nombre_silo=$row_suma['nom_silo'];

$espacio_silo=$capacidad_silo-$id_suma1;
if($espacio_silo>=$cant_producto1){

$num_servicio="0";
//PROCEDIMIENTO PARA ALMACENAR EN LA TABLA DETALLE SERVICIOS
	$string_to_array= split("/",$servicios);
	foreach ($string_to_array as $value):
           $value;
		   $num_servicio++;
		   


/*
$Result5 = mysql_query("SELECT MAX(id_detalle) as aa  FROM tab_detalle_servicio Where id_empresa='$id_empresa' ORDER BY id_detalle") or die(mysql_error());
$dec5=mysql_fetch_assoc($Result5);
$a5=substr($dec5['aa'],4,3);
if ($a5<9)
	{
	$num5 = "$a5"+"1";
	$det= "DET-00".$num5.$id_empresa;
	}else{
		if ($a5<99){
			$num5 = "$a5"+"1";
			$det= "DET-0".$num5.$id_empresa;
		}else{
			 if($a5<999){
				$num3 = "$a5"+"1";
				$det= "DET-".$num5.$id_empresa;
				}
			}
	}	
	*/
$Result5 = mysql_query("SELECT MAX(id_detalle) as aa  FROM tab_detalle_servicio where id_empresa='$id_empresa' ORDER BY id_detalle asc ") or die(mysql_error());
$dec5=mysql_fetch_assoc($Result5);
$a5=substr($dec5['aa'],4,7);
if ($a5<9)
	{
	$num5 = "$a5"+"1";
	$det= "DET-000000".$num5.$id_empresa;
	}else{if ($a5<99){
			$num5 = "$a5"+"1";
			$det= "DET-00000".$num5.$id_empresa;
		}else{if($a5<999){
				$num5 = "$a5"+"1";
				$det= "DET-0000".$num5.$id_empresa;
				}else{if($a5<9999){
					$num5 = "$a5"+"1";
					$det= "DET-000".$num5.$id_empresa;
					}else{if($a5<99999){
						$num5 = "$a5"+"1";
						$det= "DET-00".$num5.$id_empresa;
						}else{if($a5<999999){
							$num5 = "$a5"+"1";
							$det= "DET-0".$num5.$id_empresa;
							}else{if($a5<9999999){
									$num5 = "$a5"+"1";
									$det= "DET-".$num5.$id_empresa;
									}
								}
						}
					}
				}
			}	
	}
   
//EXTRAER EL CODIGO DEL SERVICIO
$result = mysql_query("SELECT * FROM tab_servicio WHERE nom_servicio ='".$value."' and id_empresa='$id_empresa'");
			while($row = mysql_fetch_array($result)) {
     		$guarda= $row['id_servicio'];

			$almace=("insert into tab_detalle_servicio(id_detalle, id_lote, num_lote, id_cliente, id_producto, id_subproducto, cant_producto, id_origen, id_servicio, id_silo, id_empresa, bandera, num_servicio) values('$det','$id_lote1', '$num_lote1', '$id_cliente1' , '$id_producto1', '$id_subproducto1', '$cant_producto1', '$id_origen1', '$guarda', '$id_silo1', '$id_empresa',0,'$num_servicio')");
			mysql_query($almace,$con);
			
		}
    endforeach;
$comentario_lote="LOTE ACTIVO";
mysql_query("insert into tab_lote(id_lote, num_lote, id_cliente, id_producto, id_subproducto, cant_producto, id_origen, id_silo, id_empresa, bandera, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica, id_usuario_desactiva, fecha_desactiva, hora_desactiva, comentario_cierre) values('$id_lote1', '$num_lote1', '$id_cliente1' , '$id_producto1', '$id_subproducto1', '$cant_producto1', '$id_origen1', '$id_silo1', '$id_empresa', 0, '$id_usuario',0, '$fecha', '$hora', '$id_usuario', '$fecha', '$hora', '$id_usuario', '$fecha', '$hora', '$comentario_lote')",$con);
			
$sql_lote=("insert into tab_inventario(id_inventario, id_lote, capacidad_lote, movimiento_lote, peso_sin_humedad, id_empresa) values ('$in', '$id_lote1', '$cant_producto1','$movimiento1', '$peso_sin_humedad1', '$id_empresa')");
			
if(mysql_error())
		  { 
			$error="1"; // error en datos
		  }
			  else
			 mysql_query($sql_lote,$con);
			$resta=$espacio_silo-$cant_producto1;
		     $error="2"; // datos almacenados
					  
	}else{ //  por si el espacio es mayor que el silo
		$error="6";
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
 			<a href="f_lote.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == "2")
 {
	$sql= mysql_query("UPDATE `tab_contador` SET `num_lote`='$transaccion2' WHERE codigo='$codigo1' and id_empresa='$id_empresa'");
	 	
	 echo '<div class="alert alert-success">
 						  <a href="f_lote.php" class="alert-link">Datos almacenados con éxito, tiene un espacio disponible en el silo '.$nombre_silo.' de '.$resta.' Kilogramos; !!! Haga click para continuar .....
						  </div>';
	  }
	  
if($mensaje=="1"){
echo '<div class="alert alert-success">
 						  <a href="f_lote.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje=="2"){
echo '<div class="alert alert-danger">
 						  <a href="f_lote.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje=="3"){
echo '<div class="alert alert-danger">
 						  <a href="f_lote.php" class="alert-link"> El Usuario no se puede eliminar, ya realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
if($error=="4"){
echo '<div class="alert alert-danger">
 						  <a href="f_lote.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';

}
if($error=="5"){
echo '<div class="alert alert-danger">
 						  <a href="f_lote.php" class="alert-link"> Cliente ya existe!!!</a>
						  </div>';

}

if ($error=="6"){
echo '<div class="alert alert-warning alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Adventencia!</strong> La cantidad del lote supera el espacio del silo.
		</div>';
	
}
?>
   
 <div class="container-fluid">
  <div class="row" >
  
 <div class="container-fluid">
  <div class="row" >
     <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Registro de Lotes</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           <form role="form" id="loginForm" name="formulario"  method="post" action="f_lote.php">
           <input type="hidden"  name="bandera" value="0">
           <input type="hidden"  name="busca">
           <input type="hidden"  name="pasar_parametro" value=""> 
                  
           <input type="hidden" name="cod_prod_eliminar"> 
           <input type="hidden" name="cod_prod_modif"> 
              <div class="row"><!--- INICIO ROW----->
             <div class="col-md-6">
         
           <div class="form-group">
              <label>Número de Lote</label>
             <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="num_lote" placeholder="Código del Lote"   name="num_lote" autocomplete="off" value="<?PHP echo $transaccion; ?>" style="background:#FFF" readonly>
              <span class="input-group-addon"><?PHP echo $ano;?></span>
              </div>
             </div>
       </div>
       <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">Cliente ó Empresa</label>
                         <?php
						 $id_cli="CLI-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_cliente WHERE bandera=0 and id_cliente!='$id_cli'  and id_empresa='$id_empresa'");
						  ?>
                      <select name="id_cliente" class="form-control input-lg chosen" size="1" id="id_cliente" onChange="habilitar_select1();" >
                            <option value="0">CLIENTE / EMPRESA </option>
							 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_cliente= $valor['id_cliente'];
									$nombre_cliente= $valor["nom_cliente"];
									echo "<option value='$codigo_cliente'>";
									echo utf8_encode("$nombre_cliente");
									echo"</option>";
								}	
							?>
                          </select>
                              
                  </div>
              </div>
              
          </div><!--- FIN ROW-----> 
		 <br>	
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="origen">SILO</label>
                         <?php
						 $id_sil="SILO-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_silo WHERE id_silo!='$id_sil' and id_empresa='$id_empresa' and bandera=0 ORDER BY nom_silo asc");
						  ?>
                      <select name="id_silo" class="form-control input-lg chosen" size="1" id="id_silo" onChange="habilitar_select2();" >
                            <option value="0">SELECCIONE SILO</option>
							 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_origen= $valor['id_silo'];
									$nombre_origen= $valor["nom_silo"];
									echo "<option value='$codigo_origen'>";
									echo utf8_encode("$nombre_origen");
									echo"</option>";
								}	
							?>
                          </select>
                              
                  </div>
              </div>
             
          <div class="col-md-6">
              <div class="form-group">
               <label for="origen">Origen del Producto</label>
                         <?php
						 $id_ori="ORIGEN-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_origen WHERE id_origen!='$id_ori' and id_empresa='$id_empresa'");
						  ?>
                      <select name="id_origen" class="form-control input-lg chosen" size="1" id="id_origen"  onChange="habilitar_select3();"  >
                            <option value="0">SELECCIONE ORIGEN </option>
							 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_origen= $valor['id_origen'];
									$nombre_origen= $valor["nom_origen"];
									echo "<option value='$codigo_origen'>";
									echo utf8_encode("$nombre_origen");
									echo"</option>";
								}	
							?>
                          </select>
                              
                  </div>
              </div>
              
           </div><!--- FIN ROW----->
           <br>
          <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">Producto</label>
                         <?php
						 $id_prod='PROD-000'.$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_producto WHERE id_producto!='$id_prod' and id_empresa='$id_empresa'");
						  ?>
                      <select name="id_producto" class="form-control input-lg chosen" size="1"  id="id_producto" onChange="habilitar_select4();" >
                            <option value="0">SELECCIONE PRODUCTO </option>
							 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_producto= $valor['id_producto'];
									$nombre_producto= $valor["nom_producto"];
									echo "<option value='$codigo_producto'>";
									echo utf8_encode("$nombre_producto");
									echo"</option>";
								}	
							?>
                          </select>
                              
                  </div>
              </div>
                  <div class="col-md-6">
              <div class="form-group">
               <label for="sub_producto">Sub Producto</label>
                <div id="feedback"><select name="id_subproducto" id="id_subproducto" class="form-control input-lg chosen" ><option value="0"> SELECCIONE SUB PRODUCTO</option></select>
                 </div>
              </div>
              </div>
              </div> <!-- FIN DE ROW -->
              <br>
         <div class="row"> <!-- Inicia Row -->
         
         
              <div class="col-md-6">
      		 <div class="form-group">
              <label>Espacio Disponible en el SILO</label>
              <div id="feedback2">
             <div class="input-group">
              <input type="text" class="form-control input-lg" id="espacio_disponible" name="espacio_disponible" placeholder="Espacio dispobible en el SILO"style="background:#FFF" value="<?PHP echo $an1; ?>" readonly>
              <span class="input-group-addon">Kilogramos</span> </div>
              </div>
              </div>
       		 </div>
                 <div class="col-md-6">
      		 <div class="form-group">
              <label>Cantidad de Producto</label>
             <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="cant_producto" placeholder="Cantidad de Producto"   name="cant_producto" autocomplete="off" value="<?PHP echo $cant_producto1; ?>" required>
              <span class="input-group-addon">Kilogramos</span>
              </div>
              </div>
       		 </div>
           </div><!--- FIN ROW-----> 
     
          <br>
          <div class="row"><!--- INICIO ROW----->
			<div class="col-md-6">
              <div class="form-group"> 
              <?php
			  $id_ser="SERV-000".$id_empresa;
				$tabla=mysql_query("SELECT * FROM tab_servicio WHERE id_servicio!='$id_ser' and id_empresa='$id_empresa' and bandera=0");
				?>
              <label for="nombre_servicio">Servicios ofrecidos</label>   
              
            <select size="5" name="lista" id="uno" class="form-control input-lg" style="height: auto; background:#FFF;" disabled>
             			<?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_servicio= $valor['id_servicio'];
									$nombre_servicio= $valor["nom_servicio"];
									$precio_servicio= $valor["precio_servicio"];
									echo "<option value='$nombre_servicio'>";
									echo utf8_encode("$nombre_servicio");
									echo"</option>";
								}	
						?>
            </select>
			</div>
            <button type="button" class="btn btn-toolbar btn-lg" onClick="agregar()"> Agregar </button>
            
 	</div>
<div class="col-md-6">
   			<div class="form-group">  
            <label for="nombre_servicio"> Servicio seleccionado </label> 
            <select class="form-control input-lg" style="height:auto; background:#FFF;" size="5" name="sel2" id="dos">
            </select>
			</div>
            <button type="button" class="btn btn-toolbar btn-lg" onClick="quitar()">  Quitar </button>

</div>
</div>
   <br>    
       
     	
          <table width="220" border="0" align="right">
              	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" onClick="cancelar()" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="submit" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right" disabled>  </button></td>
           	    </tr>
       	      </table> 	   
            
           </form> 
</div>
</div>
</div>

<!-------  LOTES ACTIVOS  -------->
 <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Lotes Activos</strong></div> <!-- PANEL 1 --->
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
		<td width='60px' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_lote']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a>
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

<!-------  LOTES INACTIVOS  -------->
 <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Lotes Inactivos</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 
<div>
<?php
$id_lot2="LOT-000".$id_empresa;
$sql2="SELECT l.num_lote, l.fecha_usuario, l.hora_usuario, l.cant_producto, l.id_usuario_desactiva, l.fecha_desactiva, l.hora_desactiva, c.nom_cliente, s.nom_silo, o.nom_origen, pro.nom_producto, spro.nom_subproducto,  u.nombre_usuario FROM tab_lote as l, tab_cliente as c, tab_silo as s, tab_origen as o, tab_producto as pro, tab_subproducto as spro, t_usuarios as u WHERE l.id_lote!='$id_lot2' and l.id_empresa='$id_empresa' and l.bandera=1 and l.id_cliente=c.id_cliente and l.id_silo=s.id_silo and l.id_origen=o.id_origen AND l.id_producto=pro.id_producto and l.id_subproducto=spro.id_subproducto and l.id_usuario2=u.id_usuario group by l.id_silo, l.id_producto, l.id_cliente, l.num_lote ORDER BY l.fecha_usuario desc, l.hora_usuario desc";
$result2 = mysql_query($sql2, $con);

 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones1' >";
                    
                        echo"<thead>                     
                              <tr>   
							   
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
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>CERRADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA CIERRE</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA CIERRE</a></div></th>
													
        </tr>
        </thead>
        <tbody>";

			if ($result2 > 0){	
		    $correlativo = 1;
			$contar2++;
		while ($row2 = mysql_fetch_assoc($result2)) 
                            {	
							 $fecha_imprime=parseDatePhp($row2['fecha_usuario']);
							 $usuario_desactiva=$row2['id_usuario_desactiva'];							 
							 $fecha_desactiva=parseDatePhp($row2['fecha_desactiva']);
							 $cant_dos2=number_format($row2['cant_producto'], 2, ".", ",");
							
		$sql_usuario = "SELECT * FROM t_usuarios WHERE id_usuario='$usuario_desactiva' and id_empresa='$id_empresa'";
								$result_us = mysql_query($sql_usuario,$con);
								if ($result_us > 0){	
                               		while ($row_usuario = mysql_fetch_assoc($result_us)){
									 $nombre_usuario_des=$row_usuario['nombre_usuario'];
									}
								}										
		echo"<tr>
	      <td width='auto' align='left'> $row2[num_lote]</td>
		  <td width='auto' align='left'> $row2[nom_cliente] </td>
 		  <td width='auto' align='left'> $row2[nom_silo] </td>
		  <td width='auto' align='left'> $row2[nom_origen] </td>
		  <td width='auto' align='left'> $row2[nom_producto] </td>
		  <td width='auto' align='left'> $row2[nom_subproducto] </td>		  
		  <td width='auto' align='left'> $cant_dos2 </td>	
		  <td width='auto' align='left'> $row2[nombre_usuario]</td>	
		  <td width='auto' align='left'> $fecha_imprime </td>						  
		  <td width='auto' align='left'> $row2[hora_usuario] </td>
	 	  <td width='auto' align='left'> $nombre_usuario_des</td>	
		  <td width='auto' align='left'> $fecha_desactiva </td>						  
		  <td width='auto' align='left'> $row2[hora_desactiva] </td>			  
		  

		</tr>";
		$contar1++;
		
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

echo "Total de Registros" ." ".$contar1;
 
?>
  
</div>
       
</div>
</div>
</div>
</div>  <!--- FIN LOTES INACTIVOS -->


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
    </div>            
    </form>
</div>



</body> 
</html>


  <?php 
  mysql_close($con);
?>