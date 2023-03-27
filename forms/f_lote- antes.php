<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");


 $_SESSION['permiso_silo'];// = ok
 $_SESSION['nombre_usuario_silo'];// = 'nombre en bd del usuario'
 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
 $estado= $_SESSION['bandera_empresa'];
 $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];
 

if($_SESSION['permiso_silo']!='ok'){
	echo "<script language='javascript'>";
	echo "document.location.href='../index.php';";
	echo "</script>";
}
 

date_default_timezone_set("America/El_Salvador");
$ano=date('Y');


?>

<!DOCTYPE html> 
<html> 
<head> 
<title>SYLOS</title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../assets/stylesheet/caja_buscar.css">
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>

<link href="../images/favicon.ico" rel="icon">

</head> 

<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers"
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

function eliminar(cod_lote){/*funcion eliminar registro */
	document.formulario.busca.value="eliminarlote";	
	if(confirm("Seguro que desea eliminar el registro?")){
		document.formulario.cod_prod_eliminar.value=cod_lote;
		document.formulario.submit();
		}
	}

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
          //$('#feedback').load('usuario_nuevoCheck.php').show();
		  //$('#feedback2').load('usuario_nuevoCheck2.php').show();
		  
		   $('#id_producto').change(function() {//inicio1
			 $.post('lote_sub_producto.php', {id_producto_busca:document.formulario.id_producto.value}, 
			 function(result) {
				$('#feedback').html(result).show();	
			
				
			 }); 									 
		  });//fin1

		 		  
       });
</script>  

  
<?php
	$bandera = $_POST['bandera'];
    echo "<script language='javascript'>";
    if($bandera=="oki")
    {//inicio if bandera ok
	   //$stringEjecucion = mysql_query ("insert into t_bitacora(id_usu,entradaBitacora,horaBitacora,diaBitacora) values ('$id_empleado','0',CURTIME(),CURDATE());",$conexion);			
 	   session_unset();
	   session_destroy();     
       echo "document.location.href='../index.php';";
     }//Fin if bandera ok
	 echo "</script>";
?>

<body class="container" >
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
    <a class="navbar-brand" href="f_principal.php">Inicio</a>
  </div>
 
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
   
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Recepción <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="http://192.168.178.108/bascula/?direccion=http://localhost/silos/forms/f_almacenaje.php">Nuevo Peso</a></li>
          <li><a href="f_almacenaje_cola_(borrar).php">Completar Peso</a></li>          
        </ul>
      </li>
    </ul>
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Despacho <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="http://192.168.178.108/bascula/?direccion=http://localhost/silos/forms/f_salida.php">Nuevo Peso</a></li>
          <li><a href="f_salida_cola.php">Completar Peso</a></li>          
        </ul>
      </li>
    </ul>
	 <ul class="nav navbar-nav">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Báscula <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="http://192.168.178.108/bascula/?direccion=http://localhost/silos/forms/f_bascula.php">Nuevo Peso</a></li>
          <li><a href="f_bascula_cola.php">Completar Peso</a></li>          
        </ul>
      </li>
    </ul>
    
    
    <ul class="nav navbar-nav">
       
     </ul>         
    
     <ul class="nav navbar-nav">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Catalógo <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="f_cliente.php">Clientes</a></li>
          <li><a href="f_transportistas.php">Transportistas</a></li>
          <li><a href="f_origen.php">Origen</a></li>
          <li><a href="f_servicios.php">Servicios</a></li>
          <li><a href="f_silo.php">Silo</a></li>
          <li><a href="f_lote.php">Lote</a></li>          
        </ul>
      </li>
    </ul>
    
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Productos <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="f_producto.php">Productos</a></li>
          <li><a href="f_subproducto.php">Subproductos</a></li>          
                  
        </ul>
      </li>
    </ul>
    
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Herramientas <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="f_moneda_medida.php">Medidas de Pesos</a></li>
          <li><a href="f_variables.php">Variables de control</a></li>  
          <li><a href="f_usuarios.php">Usuarios</a></li>                   
        </ul>
      </li>
    </ul>
    
    <ul class="nav navbar-nav">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          Reportería <b class="caret"></b>
        </a>
        <ul class="dropdown-menu">
          <li><a href="f_rep_bascula.php">Servicio de Báscula</a></li>
          <li><a href="f_rep_bascula_producto.php">Báscula por Producto</a></li>           
          <li><a href="f_rep_almacen.php">Recepción de granos</a></li>  
          <li><a href="f_rep_despacho.php">Despacho de granos</a></li>                             
          <li><a href="f_rep_ingreso_lote.php">Ingreso por Lotes</a></li>
          <li><a href="f_rep_despacho_lote.php">Despacho por Lotes</a></li>
          <li><a href="f_rep_diario.php">Movimientos Diarios</a></li>
          <li><a href="f_rep_saldo.php">Saldos por Lotes</a></li>
          <li><a href="f_rep_calidad_entrada.php">Entrada Productos - Calidad </a></li>
          <li><a href="f_rep_calidad.php">Salida Productos - Calidad </a></li>                                        
          <li><a href="f_rep_ubicacion.php">Clientes por Ubicación</a></li>          
          <li><a href="f_rep_subproductos.php">Subproductos</a></li> 
          <li><a href="f_rep_usuarios.php">Usuarios</a></li>    
          <li><a href="f_rep_varios.php">Catalógo</a></li>   <!-- Crear formulario para hacer consultas de clientes, y todo lo del menu catalogo    -->                    
        </ul>
      </li>
    </ul>
    
       <ul class="nav navbar-nav">
      <li><a href="f_rep_cardex.php">Kardex</a></li>
     </ul>
    
    <ul class="nav navbar-nav navbar-right">
      <li><a href="#">Usuario: <?PHP echo $_SESSION['nombre_usuario_silo']; ?></a></li>
      <li><a onClick="salirr()"><button type="button" class="btn btn-danger btn-xs">Cerrar Sesión</button></a></li>
    </ul>
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
$Result1 = mysql_query("SELECT MAX(id_lote) as a  FROM tab_lote ORDER BY id_lote") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],4,3);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "LOT-00".$num;
	}else{
		if ($a1<99){
			$num = "$a1"+"1";
			$nu= "LOT-0".$num;
		}else{
			 if($a1<999){
				$num = "$a1"+"1";
				$nu= "LOT-".$num;
				}
			}
	}
			
$Result3 = mysql_query("SELECT MAX(id_inventario) as a  FROM tab_inventario ORDER BY id_inventario") or die(mysql_error());
$dec3=mysql_fetch_assoc($Result3);
$a3=substr($dec3['a'],4,3);
if ($a3<9)
	{
	$num2 = "$a3"+"1";
	$in= "INV-00".$num2;
	}else{
		if ($a3<99){
			$num2 = "$a3"+"1";
			$in= "INV-0".$num2;
		}else{
			 if($a3<999){
				$num2 = "$a3"+"1";
				$in= "INV-".$num2;
				}
			}
	}										

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
	
	 
    if($bandera=="ok")
   {//inicio if bandera ok
   
//VERIFICAR EL ESPACIO EN CADA SILO   
$suma_lote=mysql_query("SELECT SUM(cant_producto) AS suma_peso FROM `tab_detalle_servicio` WHERE id_silo='$id_silo1'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO
$row_suma = mysql_fetch_assoc($suma_lote);
$id_suma1=$row_suma['suma_peso'];

$cant_lote=mysql_query("SELECT * FROM tab_silo WHERE id_silo='$id_silo1'",$con); //EXTRAER LA SUMA DE LA CANTIDAD ALMACENADA EN EL SILO
$row_suma = mysql_fetch_assoc($cant_lote);
$capacidad_silo=$row_suma['cap_silo'];
$nombre_silo=$row_suma['nom_silo'];

$espacio_silo=$capacidad_silo-$id_suma1;
if($espacio_silo>=$cant_producto1){

//PROCEDIMIENTO PARA ALMACENAR EN LA TABLA DETALLE SERVICIOS
	$string_to_array= split("/",$servicios);
	foreach ($string_to_array as $value):
           $value;
					
			//EXTRAER EL CODIGO DEL SERVICIO
			$result = mysql_query("SELECT * FROM tab_servicio WHERE nom_servicio ='".$value."'");

			while($row = mysql_fetch_array($result)) {
     		$guarda= $row['id_servicio'];
	
			mysql_query("insert into tab_detalle_servicio(id_lote, num_lote, id_cliente, id_producto, id_subproducto, cant_producto, id_origen, id_servicio, id_silo) values('$id_lote1', '$num_lote1', '$id_cliente1' , '$id_producto1', '$id_subproducto1', '$cant_producto1', '$id_origen1', '$guarda', '$id_silo1')",$con);
}
    endforeach;

			
      		mysql_query("insert into tab_lote(id_lote, num_lote, id_cliente, id_producto, id_subproducto, cant_producto, id_origen, id_silo, id_empresa, bandera) values('$id_lote1', '$num_lote1', '$id_cliente1' , '$id_producto1', '$id_subproducto1', '$cant_producto1', '$id_origen1', '$id_silo1', '$id_empresa', 0)",$con);
			
			$sql_lote=("insert into tab_inventario(id_inventario, id_lote, capacidad_lote, movimiento_lote, peso_sin_humedad, id_empresa) values ('$in', '$id_lote1', '$cant_producto1','$movimiento1', '$peso_sin_humedad1', '$id_empresa')");
			
				   
					  if(mysql_error())
					  { 
						echo '<div class="alert alert-danger">
 						  <a href="f_lote.php" class="alert-link"> Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
					  }
					  else
					  mysql_query($sql_lote,$con);
					  $resta=$espacio_silo-$cant_producto1;
						  echo '<div class="alert alert-success">
 						  <a href="f_lote.php" class="alert-link">Datos almacenados con éxito, tiene un espacio disponible en el silo '.$nombre_silo.' de '.$resta.' Kilogramos; !!! Haga click para continuar .....</a>
						  </div>';
}else{
	echo '<div class="alert alert-warning alert-dismissable">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<strong>¡Adventencia!</strong> La cantidad del lote supera el espacio del silo.
		</div>';
	
}
   //fin bandera ok	
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
              <input type="text" class="form-control input-lg soloNUMEROS" id="num_lote" placeholder="Código del Lote"   name="num_lote" autocomplete="off" value="<?PHP echo $num; ?>" style="background:#FFF" readonly re>
              <span class="input-group-addon"><?PHP echo $ano;?></span>
              </div>
             </div>
       </div>
       <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">Cliente ó Empresa</label>
                         <?php
						       $tabla=mysql_query("SELECT * FROM tab_cliente WHERE id_cliente!='CLI-000'");
						  ?>
                      <select name="id_cliente" class="form-control input-lg" size="1" id="id_cliente" onChange="habilitar_select1();" >
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
						       $tabla=mysql_query("SELECT * FROM tab_silo WHERE id_silo!='SILO-000'");
						  ?>
                      <select name="id_silo" class="form-control input-lg" size="1" id="id_silo" style="background:#FFF;" onChange="habilitar_select2();"  disabled>
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
						       $tabla=mysql_query("SELECT * FROM tab_origen WHERE id_origen!='ORIGEN-000'");
						  ?>
                      <select name="id_origen" class="form-control input-lg" size="1" id="id_origen" style="background:#FFF;" onChange="habilitar_select3();"  disabled>
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
						       $tabla=mysql_query("SELECT * FROM tab_producto WHERE id_producto!='PROD-000'");
						  ?>
                      <select name="id_producto" class="form-control input-lg" size="1" style="background:#FFF;"  id="id_producto" onChange="habilitar_select4();" disabled>
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
                         
        		 <div id="feedback"><select name="id_subproducto" id="id_subproducto" style="width:100%; border: 1px solid #ddd; height: 46px; outline: 0; border-radius: 4px;"><option value="0"> SELECCIONE SUB PRODUCTO</option></select>
                 </div>
                  
              </div>
              </div>
              </div> <!-- FIN DE ROW -->
              <br>
              <div class="row"> <!-- Inicia Row -->
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
				$tabla=mysql_query("SELECT * FROM tab_servicio WHERE id_servicio!='SERV-000'");
				?>
              <label for="nombre_servicio">Servicios ofrecidos</label>   
              
            <select size="5" name="lista" id="uno" class="form-control input-lg" style="width:540px;height: 125px; background:#FFF;" disabled>
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
            <select class="form-control input-lg" style="width:540px;height:125px" size="5" name="sel2" id="dos">
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


</div>

   <div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>Lotes</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           

<div>
<?php
$sql = "SELECT * FROM `tab_lote` WHERE id_lote!='LOT-000' group by id_silo,id_producto, id_cliente, num_lote order by num_lote";
$result = mysql_query($sql, $con);
   echo"<div class='responsive' style='overflow:scroll;height:auto;width:auto;' ><table width='auto' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";

	echo"<thead>                     
          <tr>            
            <th width='1%'>&nbsp;</th>
            <th width='8%'><div align='center'>ACCIONES</div></th>

            <th width='auto'><div align='left'><a href='#' title='Ordenar por Lote'>LOTE</a></div></th>
            <th width='auto'><div align='left'><a href='#' title='Odenar por Cliente'>CLIENTE</a></div></th>
            <th width='auto'><div align='left'><a href='#' title='Odenar por Producto'>SILO</a></div></th>
            <th width='auto'><div align='left'><a href='#' title='Odenar por Producto'></a>ORIGEN</div></th>	
            <th width='auto'><div align='left'><a href='#' title='Odenar por Servicios'></a>PRODUCTO</div></th>						
            <th width='auto'><div align='left'><a href='#' title='Odenar por Cantidad'>CANTIDAD (Kg)</a></div></th>			
           									
        </tr>
        </thead>
        <tbody>";

		if ($result> 0){	
		    $correlativo = 1;
			$contar2++;
		while ($row = mysql_fetch_array($result)) 
		{
			 $id_empresa=$row['id_cliente'];
			 $id_producto=$row['id_producto'];
			 $id_origen=$row['id_origen'];
			 $id_lote=$row['id_lote'];
			 $id_silo=$row['id_silo'];			
			
			$tabla2="SELECT * FROM tab_cliente WHERE id_cliente='$id_empresa'";
			$select2=mysql_query($tabla2,$con);
			while($row2=mysql_fetch_array($select2)) {
			$nom_empresa=$row2['nom_cliente'];
			
				$tabla3="SELECT * FROM tab_producto WHERE id_producto='$id_producto' ";
				$select3=mysql_query($tabla3,$con);
				while($row3=mysql_fetch_array($select3)) {
				$nom_producto=$row3['nom_producto'];
				
					$tabla4="SELECT * FROM tab_origen WHERE id_origen='$id_origen'";
					$select4=mysql_query($tabla4,$con);
					while($row4=mysql_fetch_array($select4)) {
					$nom_origen=$row4['nom_origen'];
					
						
							
							$tabla6="SELECT * FROM tab_silo WHERE id_silo='$id_silo'";
							$select6=mysql_query($tabla6,$con);
							while($row6=mysql_fetch_array($select6)) {
							$nom_silo=$row6['nom_silo'];
					
					
											
		echo"<tr>
		<td width='1%' align='center'></td>	
		<td width='4%' align='center'><a onClick='eliminar(\"".$row['id_lote']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a></td>
   
         
          <td width='auto' align='left'> $row[num_lote]</td>
		  <td width='auto' align='left'> $nom_empresa </td>
 		  <td width='auto' align='left'> $nom_silo </td>
		  <td width='auto' align='left'> $nom_origen </td>
		  <td width='auto' align='left'> $nom_producto </td>		  
		  <td width='auto' align='left'> $row[cant_producto] </td>		  
		  
		</tr>";
		$contar++;
		
		}
		}
		}
		}
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
<div class="navbar navbar-inverse navbar-fixed-bottom">
   <div class="container">
      <p class="navbar-text">
         Diseñado y Desarrollado Por <a href="http://www.ie-networks.com/">Ie Networks</a> © 2017.
      </p>
   </div>
</div>
<!-- FIN FOOTER  -->

</body> 
</html>
	
<!--------------------ELIMINAR REGISTRO-------------------->

  <?php 
  // Eliminar lote	
if(isset($_POST['busca']) && $_POST['busca']=="eliminarlote"){

 $sql2="DELETE FROM `silos`.`tab_detalle_servicio` WHERE `tab_detalle_servicio`.id_lote=trim('$_POST[cod_prod_eliminar]');";	
 $sql="DELETE FROM `silos`.`tab_lote` WHERE `tab_lote`.id_lote=trim('$_POST[cod_prod_eliminar]');";		
		if(!$result=mysql_query($sql) ){
			die ('Ocurrio un error al ejecutar el sql['.$mysql_error().']');
			}
		 else{ 
		 	$result=mysql_query($sql2);
			echo" <script language='javascript'>";
			echo" alert('Registro eliminado...');";
			echo"location.href='f_lote.php';";
			echo" </script>";
		}
  }
  mysql_close();
?>