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
 
 $peso_bruto_url= $_GET['peso_bruto'];
 
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

// MOSTRAR LOS DATOS QUE SE HAN SELECCIONADO
$peso_bruto_url2=$_SESSION['$peso_url'];
$id_cliente11=$_SESSION['$id_cliente1']; 
$id_transportista11=$_SESSION['$id_transportista1'];
$tabla_cli=mysql_query("SELECT * FROM tab_cliente Where id_cliente='".$_SESSION['$id_cliente1']."' and id_empresa='$id_empresa';");
						 		while($valor1=mysql_fetch_array($tabla_cli)){
									$nombre_cliente1= $valor1["nom_cliente"];
									}
									
$tabla_transportista=mysql_query("SELECT * FROM tab_transportista Where id_transportista='".$_SESSION['$id_transportista1']."' and id_empresa='$id_empresa';");
						 		while($valor5=mysql_fetch_array($tabla_transportista)){
									$nom_transportista1= $valor5["nom_transportista"]." ".$valor5["ape_transportista"];
								}	
if($id_cliente11==""){
	$nombre_cliente1="SELECCIONE CLIENTE / EMPRESA";
	}

if($id_transportista11==""){
	$nom_transportista1="SELECCIONE TRANSPORTISTA";
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
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css"> 
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

function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
 
function tara(cod){
		document.formulario.busca.value="tara";	
		document.formulario.cod_prod_modif.value=cod;
//	document.formulario.action="http://localhost/bascula/?parametro="+cod+"&direccion=http://190.143.196.3/sylos/forms/f_bascula2.php";//capturar el Tara.		
		document.formulario.action="http://192.168.178.108/bascula/?parametro="+cod+"&direccion=http://localhost/silos/forms/f_bascula2.php";//capturar el Tara.
		document.formulario.submit();
	} 
	
function datos(){
	 window.open('../reportes/Rp_bascula_comprobante.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
}

function validarum()
{	
	document.ftransportista.peso_capturado.value=document.formulario.pesaje_realizado.value;
	document.ftransportista.insercliente.value=document.formulario.id_cliente2.value;
	document.ftransportista.insertarum.value='guardarum';
	document.ftransportista.submit();
}		
</script>

<script type="text/javascript">
       $(document).ready(function() {
       
		   $('#id_cliente2').change(function() {//Actualiza el select de los transportistas
			 $.post('select_transportista.php', {id_cliente_busca:document.formulario.id_cliente2.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
							
			 }); 									 
		  });//fin1
		  
		  $('#id_producto').change(function() {//Actualiza el select de los transportistas
			 $.post('select_subproducto.php', {id_producto_busca:document.formulario.id_producto.value}, 
			 function(result) {
				$('#feedback_subproducto').html(result).show();	
							
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
					$sql = "SELECT * FROM `tab_contador` where id_empresa='$id_empresa'"; 
					$result = mysql_query($sql); //usamos la conexion para dar un resultado a la variable
					if ($result> 0){ //si la variable tiene al menos 1 fila entonces seguimos con el codigo
					    while ($fila = mysql_fetch_array($result)) 
						{
							$cont_total=$fila['total'];
							$cod_entrada=$fila['servicio_bascula'];
							$transaccion=$cont_total+1;
							//echo " ".$fila['idEmpleado'];
							$entrada=$cod_entrada+1; 	
						//	$transaccion=$transaccion+1;
						}
					}
?>					
           
<?php
$Result1 = mysql_query("SELECT MAX(id_bascula) as a  FROM tab_bascula WHERE id_empresa='$id_empresa' ORDER BY id_bascula") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],5,7);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "BASC-000000".$num.$id_empresa;
	}else{if ($a1<99){
			$num = "$a1"+"1";
			$nu= "BASC-00000".$num.$id_empresa;
		}else{if($a1<999){
				$num = "$a1"+"1";
				$nu= "BASC-0000".$num.$id_empresa;
				}else{if($a1<9999){
					$num = "$a1"+"1";
					$nu= "BASC-000".$num.$id_empresa;
					}else{if($a1<99999){
						$num = "$a1"+"1";
						$nu= "BASC-00".$num.$id_empresa;
						}else{if($a1<999999){
							$num = "$a1"+"1";
							$nu= "BASC-0".$num.$id_empresa;
							}else{if($a1<9999999){
									$num = "$a1"+"1";
									$nu= "BASC-".$num.$id_empresa;
									}
								}
						}
					}
				}
			}
	}		   
		
// INICIA EL GUARDADO DE INFORMACION 
		 $bandera = $_POST['bandera'];
		 $codigo1=1;
		 $cod_nue_ser=$nu; // codigo interno de la bascula
		 $entrada; // numero de operaciones en la bascula
		 $id_cliente1=$_POST['id_cliente2'];
		 $id_transportista1=$_POST['id_transportista'];	
		 $id_producto1=$_POST['id_producto'];
		 $id_subproducto1=$_POST['id_subproducto'];
		 $fecha_entrada1=parseDateMysql($_POST['fecha_entrada']);
		 $hora_entrada1=$_POST['hora_entrada'];
		 $fecha_salida1=parseDateMysql($_POST['fecha_entrada']);
		 $hora_salida1=$_POST['hora_entrada'];
		 $opcion_peso1=$_POST['tipo_peso'];
		 $peso_bruto1=$_POST['peso_bruto'];
		 $peso_tara1=$_POST['peso_tara'];
		 $peso_unico1=$_POST['peso_unico'];
		 $observacion1=strtoupper($_POST['observacion']);
		 $destino1=strtoupper($_POST['destino']);		 
		 if($opcion_peso1==3){
			 $peso_bruto1=$peso_unico1;
			 $peso_tara1=0;
			}
			
if($pingresar==1){			
 if($bandera=="ok")
   {//inicio if bandera ok
$sql= mysql_query("UPDATE `tab_contador` SET `total`='$transaccion',`servicio_bascula`='$entrada' WHERE codigo='$codigo1' and id_empresa='$id_empresa'", $con);

$act=("UPDATE tab_transportista SET ocupado=1 WHERE id_transportista='$id_transportista1' and id_empresa='$id_empresa'");mysql_query($act,$con);

$prod=("UPDATE tab_producto SET ocupado=1 WHERE id_producto='$id_producto1' and id_empresa='$id_empresa'"); 
mysql_query($prod,$con);

$suprod=("UPDATE tab_subproducto SET ocupado=1 WHERE id_subproducto='$id_subproducto1' and id_empresa='$id_empresa'");mysql_query($suprod,$con);

mysql_query("insert into tab_bascula(id_bascula, entrada, id_cliente, id_transportista, id_producto, id_subproducto, fecha_entrada, hora_entrada, fecha_salida, hora_salida, opcion_peso, peso_bruto, peso_tara, peso_unico, destino, observacion, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values ('$cod_nue_ser', '$entrada', '$id_cliente1', '$id_transportista1', '$id_producto1', '$id_subproducto1', '$fecha_entrada1', '$hora_entrada1', '$fecha_salida1','$hora_salida1', '$opcion_peso1', '$peso_bruto1', '$peso_tara1', '$peso_unico1', '$destino1', '$observacion1', '$id_empresa', '$id_usuario',0, '$fecha_entrada', '$hora','$id_usuario','$fecha_entrada','$hora')",$con); 
		
		 if(mysql_error())
		  { 
			$error="1"; // error en datos
		  }
			  else
			  $guarda="2";
		     $error="2"; // datos almacenados
   	}
}else{ // fin bandera ok
	$error="4"; //no tiene permiso de escritura
	}//fin permiso
?> 
 

<body class="container" <?PHP if($guarda == 2) echo "onload='datos()';";?> > 

<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->

<nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

 
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
   
   <!-- menu -->
     <ul id="menu-bar">
     <?PHP
      $indicadorul = 0;
      $indicadorli = 1;
     // $consulta = mysql_query("SELECT * FROM tab_menu",$con);
	 $consulta = mysql_query("SELECT a.opcion_menu, a.url_menu, a.acceso_menu, a.nivel_menu FROM tab_menu as a, tab_detalle_menu as b, t_empresa as c WHERE a.id_menu=b.id_menu and b.id_nivel='".$acceso."' and b.id_empresa='$id_empresa' and c.estado='$estado' GROUP by a.id_menu",$con);
      while($fila = mysql_fetch_array($consulta)){
          if((($fila['acceso_menu']==0) || ($fila['acceso_menu']==$acceso)) && (!empty($acceso))){
              if(($fila['nivel_menu']==2) && ($indicadorul==0)){  echo "<ul class='dropdown-menu'>"; $indicadorul=1; }
              if(($fila['nivel_menu']==1) && ($indicadorul==1)){  echo "</ul>"; $indicadorul=0; }
              
              if(($fila['nivel_menu']==1) && ($indicadorli == 0)){echo "</li>";$indicadorli=1;}
               
              if($fila['id_menu']==1)//Menu de inicio(index.php) debe de ir sin 'forms/'
                  echo "<li><div align='left'><a  href='../".utf8_encode($fila['url_menu'])."'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
              else{
                  if($fila['nivel_menu']==2)
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a></li>";
                  else{
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".utf8_encode($fila['opcion_menu'])."</div></a>";
                      $indicadorli = 0;
                  }			  
              }
          }
      }

      echo "</li>";
     ?>

      <li><a><?PHP echo $_SESSION['nombre_usuario_silo']; ?></a></li>
      <li><a onClick="salirr()"><button type="button" class="btn btn-danger btn-xs">Cerrar Sesión</button></a></li>
          
</ul>
    </div>
    
</nav>


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

 if($error == "1")
 {
	  echo '<div class="alert alert-success">
 			<a href="f_bascula.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
unset($_SESSION['$id_cliente1']);
unset($_SESSION['$id_transportista1']);
unset($_SESSION['$peso_url']);

 }
 
 if($error == "2")
 {
	 echo '<div class="alert alert-success">
 						  <a href="f_bascula.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
unset($_SESSION['$id_cliente1']);
unset($_SESSION['$id_transportista1']);
unset($_SESSION['$peso_url']);
	  }
	  
if($error=="4"){
echo '<div class="alert alert-danger">
 						  <a href="f_bascula.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';
}
?> 
           <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>SERVICIO DE BASCULA</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form role="form" name="formulario"  method="post" action="f_bascula.php">
           <input type="hidden"  name="bandera" value="0">
 			<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif">   
           <input type="hidden"  name="reporte" value="<?PHP echo $nu; ?>"> 
                                
           
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="transaccion">TRANSACCION N°.</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $transaccion;?>" id="transaccion1"   name="transaccion1" autocomplete="off" style="background:#FFF;" disabled>
                      
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="entrada">SERVICIO N°.</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $entrada;?>" id="entrada1"  name="entrada1" autocomplete="off" style="background:#FFF;" disabled>
                        
                              
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
           
                   
            <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">CLIENTE</label>
                         <?php
						 $id_cli="CLI-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente!='$id_cli' and id_empresa='$id_empresa'");
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
               <label for="moneda_servicio">PILOTO</label>
                 <div class="input-group">
        		 <div id="feedback"><select  class="form-control input-lg chosen" name="id_transportista" id="id_transportista"><option value="<?PHP echo $id_transportista11; ?>"><?PHP echo $nom_transportista1; ?></option> </select>
                 </div>
                 <span class="input-group-addon"> <button class=" btn btn-default" type="button" id="btnbus" title="Agregar Transportista" data-toggle="modal" data-target="#modaltransportista">Nuevo</button></span>
            	</div>
                </div>
              </div>
              </div> <!-- FIN ROW -->
              
               <div class="row"><!--- INICIO ROW----->
              
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">PRODUCTO</label>
                         <?php
						 $id_pro="PROD-000".$id_empresa;
						       $tabla=mysql_query("SELECT * FROM tab_producto WHERE id_producto!='$id_pro' and id_empresa='$id_empresa'");
						  ?>
                      <select name="id_producto" class="form-control input-lg chosen" size="1" id="id_producto">
                            <option value="0">SELECCION PRODUCTO </option>
							 <?php 
								while($valor=mysql_fetch_array( $tabla)){
									$codigo_cliente= $valor['id_producto'];
									$nombre_cliente= $valor["nom_producto"];
									echo "<option value='$codigo_cliente'>";
									echo utf8_encode("$nombre_cliente");
									echo"</option>";
								}	
							?>
                          </select>
                              
                  </div>
              </div>
             
                  <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">SUBPRODUCTO</label>
                         
        		 <div id="feedback_subproducto"><select name="id_subproducto" class="chosen" id="id_subproducto" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="">SELECCIONE SUBPRODUCTO</option></select></div>
                  </div>
              </div>
           </div><!--- FIN ROW----->
           <br>
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">FECHA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $fecha;?>" id="fecha_entrada" name="fecha_entrada" autocomplete="off">
                      
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">HORA ENTRADA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $hora;?>" id="hora_entrada" name="hora_entrada" autocomplete="off">
                        
                              
                  </div>
              </div>
                         
           </div><!--- FIN ROW----->
           <br>
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">FECHA SALIDA</label>
               <input type="text" class="form-control input-lg" id="fecha_salida" name="fecha_salida" autocomplete="off" disabled style="background:#FFF;">
                      
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">HORA SALIDA</label>
               <input type="text" class="form-control input-lg"  id="hora_salida" name="hora_salida" autocomplete="off"disabled style="background:#FFF;">
             </div>
              </div>
             </div><!--- FIN ROW----->
           <br>
           <!-- PARA CAPTURA LOS PESOS -->
           <div class="row"><!--- INICIO ROW----->
              <div class="col-md-4">
              <div class="form-group">
              <label for="opciones"> PESO REALIZADO </label>
               <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" value="<?PHP echo $peso_bruto_url; echo $peso_bruto_url2; ?>" id="pesaje_realizado"  name="pesaje_realizado"  placeholder="PESO BRUTO" autocomplete="off"   style="background:#FFF;" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
              </div>
              </div>
              </div><!-- FIN DEL ROW -->
              
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-4">
              <div class="form-group">
             
               	 
                 <input type="radio" id="tipo_peso" value="1" name="tipo_peso" onClick="peso_bruto.disabled = false; peso_bruto.focus(); peso_unico.disabled=true; peso_tara.disable=true, fecha_salida.value=''; hora_salida.value=''; peso_unico.value=''; btnguardar.disabled=false; peso_tara.value=''; peso_bruto.value='<?PHP echo $peso_bruto_url; echo $peso_bruto_url2; ?>' ">  PESO BRUTO 
                </div>
                 </div>
              <div class="col-md-4">
              <div class="form-group">
                <label for="tipo_peso2"></label>
                 <input type="radio" id="tipo_peso" value="2" name="tipo_peso" onClick="peso_bruto.disabled = false; peso_tara.focus(); peso_bruto.value=''; peso_unico.disabled=true; peso_tara.disable=true, fecha_salida.value=''; hora_salida.value=''; peso_unico.value=''; peso_tara.value='<?PHP echo $peso_bruto_url; echo $peso_bruto_url2; ?>'; btnguardar.disabled=false; ">  PESO TARA
                 </div>
                 </div>
              
              <div class="col-md-4">
              <div class="form-group">
                <label for="tipo_peso2"></label>
                 <input type="radio" id="tipo_peso" value="3" name="tipo_peso" onClick="peso_unico.disabled = false;  peso_unico.focus(); fecha_salida.value=fecha_entrada.value; hora_salida.value=hora_entrada.value; peso_bruto.value=''; peso_tara.value=''; peso_unico.value='<?PHP echo $peso_bruto_url; echo $peso_bruto_url2; ?>'; btnguardar.disabled=false;"  >  PESO UNICO
                 </div>
                 </div>
              </div><!--- FIN ROW----->
       <br>
       <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>PESO BRUTO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_bruto"  name="peso_bruto"  placeholder="PESO BRUTO" autocomplete="off"   style="background:#FFF;" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
           <div class="col-md-4">
          <div class="form-group">
              <label>PESO TARA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_tara"  name="peso_tara"  placeholder="PESO TARA" autocomplete="off" style="background:#FFF;" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>PESO UNICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_unico"  name="peso_unico"  placeholder="PESO UNICO" autocomplete="off" style="background:#FFF;" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
       <br>
        <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="observacion">DESTINO</label>
             <input type="text" class="form-control input-lg" id="destino"  name="destino"  placeholder="DESTINO DEL PRODUCTO" autocomplete="off" style="text-transform:uppercase;" >
          </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
       <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="observacion">OBSERVACION</label>
             <textarea name="observacion" class="form-control input-lg" rows="3" placeholder="Observaciones" autocomplete="off" id="observacion" style="text-transform:uppercase;"></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
	
<br><br>
           	  <table width="220" border="0" align="right">
   			   	    <tr>
              	      <td width="100"><button type="reset" id="btnsub" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="button" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right" disabled>  </button></td>
              	    </tr>
           	      </table> 
            
           </form> 
</div>
</div>
</div>
<div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>VEHICULO EN COLA</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
  <div>
<?php
$id_bas="BASC-000".$id_empresa;
	 $sql = "SELECT * FROM tab_bascula WHERE id_bascula!='$id_bas' and (opcion_peso=1 or opcion_peso=2) and id_empresa='$id_empresa' order by fecha_entrada desc, hora_entrada desc ";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>   
     
                                
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='120px'><div align='left'><a href='#' title='Ordenar por Fecha'>FECHA</a></div></th>
                                <th width='125px'><div align='left'><a href='#' title='Odenar por Hora'>HORA </a></div></th>
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
			 $id_empresa_busca=$row['id_cliente'];
			 $id_producto_busca=$row['id_producto'];
			 $id_subproducto_busca=$row['id_subproducto'];
			 $id_motorista_busca=$row['id_transportista'];
			 $usuario_busca=$row['id_usuario2'];
			 $usuario_modifica=$row['id_usuario_modifica'];	
			 $fecha_imprime=parseDatePhp($row['fecha_entrada']);
			 $peso_neto=$row['peso_bruto']-$row['peso_tara']; //Calcular el peso neto
			 $fecha_imprime2=parseDatePhp($row['fecha_usuario']);
			 $fecha_imprime_modif=parseDatePhp($row['fecha_modifica']);	

			if($row['opcion_peso']==1)$peso="PESO BRUTO";
			if($row['opcion_peso']==2)$peso="PESO TARA";	 
									
			$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa_busca'";
			$select2=mysql_query($tabla2,$con);
			while($row2=mysql_fetch_array($select2)) {
			$nom_empresa=$row2['nom_cliente'];
			}
				$tabla3="SELECT * FROM tab_producto WHERE id_producto='$id_producto_busca'";
				$select3=mysql_query($tabla3,$con);
				while($row3=mysql_fetch_array($select3)) {
				$nom_producto=$row3['nom_producto'];
				}
					$tabla4="SELECT * FROM tab_subproducto WHERE id_subproducto='$id_subproducto_busca'";
					$select4=mysql_query($tabla4,$con);
					while($row4=mysql_fetch_array($select4)) {
					$nom_subproducto=$row4['nom_subproducto'];
					}
						$tabla5="SELECT * FROM tab_transportista WHERE id_transportista='$id_motorista_busca'";
						$select5=mysql_query($tabla5,$con);
						while($row5=mysql_fetch_array($select5)) {
						$nom_transportista=$row5['ape_transportista']." ".$row5['nom_transportista'];
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
		<td width='2%' align='center'><a onClick='tara(\"".$row['id_bascula']."\");' style='cursor:pointer' title='Completar Peso'><img src='../images/aceptar.png' width='28px' height='28px'></a></td>	   
         

		  
          <td width='auto' align='left'> $fecha_imprime</td>
		  <td width='auto' align='left'> $row[hora_entrada] </td>		  
		  <td width='auto' align='left'> $nom_empresa </td>
  		  <td width='auto' align='left'> $placa </td>	
 		  <td width='auto' align='left'> $nom_transportista </td>
		  <td width='auto' align='left'> $nom_producto </td>
		  <td width='auto' align='left'> $nom_subproducto </td>
		  <td width='auto' align='left'> $row[peso_bruto] </td>
		  <td width='auto' align='left'> $row[peso_tara] </td>
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
</div>


<br><br><br><br>
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->
<!--   FIN CUERPO   -->

<!--  INICIO FOOTER   -->
<div class="navbar navbar-inverse navbar-fixed-bottom">
   <div class="container"><br>
      <p style="text-align:center; color:#FFF; font-style:oblique;">
         Diseñado y Desarrollado Por <a style="color:#FFF; font-weight:bold" href="http://www.ie-networks.com/" target="_blank">Ie Networks</a> © 2017.
      </p>
   </div>
</div>
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
	<form id="ftransportista" name="ftransportista" action="f_bascula.php" method="post">
  	<input type="hidden" name="insertarum">
  	<input type="hidden" name="insercliente">
  	<input type="hidden" name="peso_capturado">    
  	    
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
            <div class="modal-footer">
         		<button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
               	<button class="btn btn-primary" type="button" onClick="validarum();">Guardar</button>
            </div>    
    </div>
    <div>               
    </form>
</div>
<!-- FIN DEL MODAL TRANSPORTISTA -->

 <?php 
// Inserta transportista
 if(isset($_POST['insertarum']) && $_POST['insertarum']=="guardarum"){
		include('insertar_transportista_bascula.php');
		echo" <script language='javascript'>";
		echo" alert('Datos del Piloto almacenados correctamente...');";
		echo"location.href='f_bascula.php';";
		echo" </script>";
  }
?>
</body> 
</html>

<?PHP
mysql_close($con);
?>
