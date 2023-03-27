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

$tabla="SELECT *  FROM tab_bascula where id_bascula='$buscar_bascula' and id_empresa='$id_empresa'";
$select = mysql_query($tabla,$con);
while($row = mysql_fetch_array($select))
{
	
// EXTRAER DATOS PARA REALIZAR EL TARA
		 $id_bascula1=$row['id_bascula'];
		 $entrada1=$row['entrada'];
		 $id_cliente1=$row['id_cliente'];
		 $id_transportista1=$row['id_transportista'];	
		 $id_producto1=$row['id_producto'];
		 $id_subproducto1=$row['id_subproducto'];
		 $fecha_entrada1=parseDatePhp($row['fecha_entrada']);
		 $hora_entrada1=$row['hora_entrada'];
		// $peso_bruto1=$row['peso_bruto'];
	     $observacion1=$row['observacion'];
		 if($row['opcion_peso']==1){
		 $_SESSION['opcion_peso']=1;
		 $peso_almacenado=$row['peso_bruto'];
		 }
		 if($row['opcion_peso']==2){
		 $_SESSION['opcion_peso']=2;	 
		 $peso_almacenado=$row['peso_tara'];
		 }
}	

$tabla2="SELECT *  FROM tab_cliente where id_cliente='$id_cliente1' and id_empresa='$id_empresa'";
$select2 = mysql_query($tabla2,$con);
while($row2 = mysql_fetch_array($select2))
{
	$nom_cliente1=$row2['nom_cliente'];
}
$tabla3="SELECT *  FROM tab_transportista where id_transportista='$id_transportista1' and id_empresa='$id_empresa'";
$select3 = mysql_query($tabla3,$con);
while($row3 = mysql_fetch_array($select3))
{
	$nom_transportista1=$row3['nom_transportista']." ".$row3['ape_transportista'];
}
$tabla4="SELECT *  FROM tab_producto where id_producto='$id_producto1' and id_empresa='$id_empresa'";
$select4 = mysql_query($tabla4,$con);
while($row4 = mysql_fetch_array($select4))
{
	$nom_producto1=$row4['nom_producto'];
}
$tabla5="SELECT *  FROM tab_subproducto where id_subproducto='$id_subproducto1' and id_empresa='$id_empresa'";
$select5 = mysql_query($tabla5,$con);
while($row5 = mysql_fetch_array($select5))
{
	$nom_subproducto1=$row5['nom_subproducto'];
}
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
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers"
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
 function cancelar(){
		document.location.href='f_bascula.php';	
	}
 
  function datos(){
	 window.open('../reportes/Rp_bascula_final.php?id='+document.formulario.reporte.value,target="_blank",'directories=no,status=yes, titlebar=no, Width=800; Height:600, scrollbars=yes, resizeable=no, directories=no, toolbar=no menubar=no, top=50,left=200');
	
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

 if($pingresar==1){		
 if($bandera=="ok")
   {//inicio if bandera ok
     $cod2=$_POST['id_bascula2'];
	 $fecha_salida2= parseDateMysql($_POST['fecha_salida']);
 	 $hora_salida2=$_POST['hora_salida'];
 	 $peso_tara2=$_POST['peso_tara'];
	 $peso_bruto2=$_POST['peso_bruto'];
 	 $observacion3=strtoupper($_POST['observacion2']);
	
	 if($_SESSION['opcion_peso']==1){
		 $peso_tara3=$peso_tara2;
		 $peso_bruto3=$peso_bruto2;
		 
		 }
		 if($_SESSION['opcion_peso']==2){
		 $peso_bruto3=$peso_tara2;
		 $peso_tara3=$peso_bruto2;	 
		 }


	if(isset($cod2)){
		$sql= ("UPDATE `tab_bascula` SET `fecha_salida`='$fecha_salida2',`hora_salida`='$hora_salida2' ,`opcion_peso` ='4',  `peso_bruto`='$peso_bruto3', `peso_tara`='$peso_tara3', `observacion`='$observacion3', id_usuario_modifica='$id_usuario', fecha_modifica='$fecha_entrada', hora_modifica='$hora'  WHERE id_bascula='$cod2'");
		mysql_query($sql,$con);
 if(mysql_error())
		  { 
			$error="1"; // error en datos
		  }
			  else
			  $act= ("UPDATE tab_bascula SET ocupado=1 WHERE id_bascula='$cod2' and id_empresa='$id_empresa'");
	 		  mysql_query($act,$con);
			  unset($_SESSION['opcion_peso']);
			  $guarda="2";
		      $error="2"; // datos almacenados

	}
	}
}else{ // fin bandera ok
	$error="4"; //no tiene permiso de escritura
	}//fin permiso
				   
					
?>  

<body class="container" <?PHP if($guarda == 2) echo "onload='datos()';"; ?> > 

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

 if($error == 1)
 {
	  echo '<div class="alert alert-success">
 			<a href="f_bascula_cola.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
						  </div>';
 }
 
 if($error == 2)
 {
	 	
	 echo '<div class="alert alert-success">
 						  <a href="f_bascula_cola.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
						  </div>';
	  }
	  
if($error==4){
echo '<div class="alert alert-danger">
 						  <a href="f_bascula_cola.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
						  </div>';
}
?>
 <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>SERVICIO DE BASCULA</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form role="form" name="formulario"  method="post" action="f_bascula2.php">
           <input type="hidden"  name="bandera" value="0">
 			<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif">  
            <input type="hidden"  name="reporte" value="<?PHP echo $_POST['id_bascula2']; ?>">           
           
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
               <label>MOTORISTA</label>
              <input type="text" class="form-control input-lg" value="<?PHP echo $nom_transportista1;?>" id="transportista2"  name="transportista2" autocomplete="off" style="background:#FFF;" readonly>
                  </div>
              </div>
              </div> <!-- FIN ROW -->
              
               <div class="row"><!--- INICIO ROW----->
              
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">PRODUCTO</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $nom_producto1;?>" id="producto2"  name="producto2" autocomplete="off" style="background:#FFF;" readonly>
                              
                  </div>
              </div>
             
                  <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">SUBPRODUCTO</label>
                <input type="text" class="form-control input-lg" value="<?PHP echo $nom_subproducto1;?>" id="subproducto2"  name="subproducto2" autocomplete="off" style="background:#FFF;" readonly>
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
               <input type="text" class="form-control input-lg" value="<?PHP echo $fecha;?>" id="fecha_salida" name="fecha_salida" autocomplete="off" style="background:#FFF;" >
                      
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="moneda_servicio">HORA SALIDA</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $hora;?>" id="hora_salida" name="hora_salida" autocomplete="off" style="background:#FFF;" >
                        
                              
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
                 <input type="radio" id="tipo_peso" value="1" name="tipo_peso" disabled>  PESO INICIAL 
                 </div>
                 </div>
                 </div>
              
               <div class="col-md-6">
              	<div class="form-group">
				<label for="tipo_peso"></label>
                 <input type="radio" id="tipo_peso" value="2" name="tipo_peso" checked >  PESO FINAL 
                
                 </div>
                 </div>
                  
              
              </div><!--- FIN ROW----->
              
                     
       <br>
       <div class="row"><!--- INICIO ROW----->
          <div class="col-md-6">
         <div class="form-group">
              <label>PESO INICIAL</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_bruto"  name="peso_bruto"  placeholder="PESO BRUTO" autocomplete="off" value="<?PHP echo $peso_almacenado;?>" readonly style="background:#FFF;" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-6">
         <div class="form-group">
              <label>PESO FINAL</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_tara"  name="peso_tara"  placeholder="PESO TARA" autocomplete="off" style="background:#FFF;" value="<?PHP echo $peso_tara_url; ?>" >
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

              	      <td width="100"><input type="button" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
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

