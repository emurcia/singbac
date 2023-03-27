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
?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.format.js"></script>
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
 
/*	
function eliminar(cod_producto){/*funcion eliminar registro 
	document.formulario.busca.value="eliminarproducto";	
	if(confirm("Seguro que desea eliminar el registro?")){
		document.formulario.cod_prod_eliminar.value=cod_producto;
		document.formulario.submit();
		}
	}	
*/

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
	$bandera_eli = $_POST['bandera_acciones'];
	if($bandera_eli=="oki"){
	
	  $id_eliminar=$_POST['id_eliminar'];
	  $nombre_usuario=$_POST['nombre_usuario'];
	  $con_usuario=md5($_POST['con_usuario']);

	 $activo=1;
	 $empresa=$id_empresa;
	 $eliminar=1;
	 
$usu_utilizado=mysql_query("SELECT * from tab_variables where id_variable='$id_eliminar' and id_empresa='$empresa'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']==0){ // no ha sido utilizado
		$lleno=0;
  }else{ // Posse datos
  	 	$lleno=1;
  }	 
	 
	 
if ($lleno==0){
$resultado = eliminar_su("tab_variables","id_variable",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
if($resultado==1){
	$mensaje="1"; // Registro Eliminado
	
	}else{
	$mensaje="2"; // No posee permisos	
		
		}
	}
if($lleno==1){
	$mensaje="3";
	
	}
	
}// fin de bandera

?>


<body class="container" onLoad="document.formulario.nom_variable.focus();"> 


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
$Result1 = mysql_query("SELECT MAX(id_variable) as a  FROM tab_variables where id_empresa='$id_empresa' ORDER BY id_variable") or die(mysql_error());
$dec2=mysql_fetch_assoc($Result1);
$a1=substr($dec2['a'],4,3);
if ($a1<9)
	{
	$num = "$a1"+"1";
	$nu= "VAR-00".$num.$id_empresa;
	}else{
		if ($a1<99){
			$num = "$a1"+"1";
			$nu= "VAR-0".$num.$id_empresa;
		}else{
			 if($a1<999){
				$num = "$a1"+"1";
				$nu= "VAR-".$num.$id_empresa;
				}
			}
	}		   
		

// INICIA EL GUARDADO DE INFORMACION 
		 $bandera = $_POST['bandera'];
		 $cod_nue_ser=$nu; // codigo interno de la bascula
		 $nom_variable1=strtoupper($_POST['nom_variable']);
		 $peso_vol1=$_POST['peso_volumetrico'];
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
		 $stress_crack1=$_POST['stress_crack'];			 		 		 
		 $olor1=strtoupper($_POST['olor']);			 	 	 		 
		 $observacion1=strtoupper($_POST['observacion']);
			
if($pingresar==1){		
 if($bandera=="ok")
   {//inicio if bandera ok
   $cliente_utilizado=mysql_query("SELECT count(*) as existe from tab_variables where nom_variable='$nom_variable1' and id_empresa='$id_empresa'"); // VERIFICA SI YA EXISTE EL NOMBRE DE LA VARIABLE
$cliente_utilizado2 = mysql_fetch_array($cliente_utilizado);
if($cliente_utilizado2['existe']!=0){ // no ha sido utilizado
	$error=5; // Cliente ya existe
  }else{ // Posse datos		
mysql_query("insert into tab_variables(id_variable, nom_variable, peso_vol, humedad, temperatura, grano_entero, grano_quebrado, dan_hongo, impureza, grano_chico, grano_picado, plaga_viva, plaga_muerta, stress_crack, olor, observacion, id_empresa, id_usuario2, ocupado, fecha_usuario, hora_usuario, id_usuario_modifica, fecha_modifica, hora_modifica) values ('$cod_nue_ser', '$nom_variable1', '$peso_vol1', '$humedad1', '$temperatura1', '$grano_entero1', '$grano_quebrado1', '$dan_hongo1', '$impureza1','$grano_chico1', '$grano_picado1', '$plaga_viva1', '$plaga_muerta1', '$stress_crack1','$olor1', '$observacion1', '$id_empresa', '$id_usuario',0, '$fecha', '$hora','$id_usuario','$fecha','$hora')",$con); 
	if(mysql_error())
		  { 
			$error="1"; // error en datos
		  }
			  else
		     $error="2"; // datos almacenados
		}
	
   }
}else{ // fin bandera ok
	   $error="4"; //no tiene permiso de escritura
	   }//fin permiso
	
	
?>
<?PHP
if($error == 1)
 {
echo '<div class="alert alert-success">
<a href="f_variables.php" class="alert-link">Error en el procesamiento de datos!!! Haga click para continuar .....</a>
   </div>';
 }
 
 if($error == 2)
 {
echo '<div class="alert alert-success">
 	<a href="f_variables.php" class="alert-link">Datos almacenados con éxito!!! Haga click para continuar .....</a>
	  </div>';
	  }
	  
if($mensaje==1){
echo '<div class="alert alert-success">
 						  <a href="f_variables.php" class="alert-link"> Registro Eliminado correctamente!!! Haga click para continuar .....</a>
						  </div>';	  
}
if($mensaje==2){
echo '<div class="alert alert-danger">
 						  <a href="f_variables.php" class="alert-link"> No Posee permisos para Eliminar el registro!!! Haga click para continuar .....</a>
						  </div>';
}

if($mensaje==3){
echo '<div class="alert alert-danger">
 						  <a href="f_variables.php" class="alert-link"> Variable no se puede eliminar, ya se realizó transacciones el en sistema!!! Haga click para continuar .....</a>
						  </div>';

}
if($error==4){
echo '<div class="alert alert-danger">
 		<a href="f_variables.php" class="alert-link"> El Usuario no tiene permiso para ingresar datos!!!</a>
	 </div>';

}
if($error==5){
echo '<div class="alert alert-danger">
 						  <a href="f_variables.php" class="alert-link"> Nombre de Variable ya existe!!!</a>
						  </div>';
}
?>   
<div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>VARIABLES DE CONTROL</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form role="form" name="formulario"  method="post" action="f_variables.php">
           <input type="hidden"  name="bandera" value="0">
 			<input type="hidden" name="busca">
			<input type="hidden" name="cod_prod_eliminar"> 
            <input type="hidden" name="cod_prod_modif">            
           
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="transaccion">CODIGO</label>
               <input type="text" class="form-control input-lg" value="<?PHP echo $nu;?>" id="codigo"   name="codigo" autocomplete="off" style="background:#FFF;" readonly>
                      
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label for="entrada">NOMBRE DE CATEGORIA</label>
               <input type="text" class="form-control input-lg" id="nom_variable" style="text-transform:uppercase;"  name="nom_variable" autocomplete="off" >
                            
                  </div>
              </div>
            </div><!--- FIN ROW----->
         <br>
       <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>PESO VOLUMETRICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_volumetrico"  name="peso_volumetrico"  placeholder="PESO VOLUMETRICO" onkeypress="mascara(this, '##.##')" maxlength="5" autocomplete="off" >
              <span class="input-group-addon">KILOGRAMOS</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>HUMEDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="humedad"  name="humedad"  placeholder="HUMEDAD" onkeypress="mascara(this, '##.##')" maxlength="5" autocomplete="off" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>TEMPERATURA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="temperatura"  name="temperatura"  placeholder="TEMPERATURA" onkeypress="mascara(this, '##.##')" maxlength="5" autocomplete="off" >
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
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_entero"  name="grano_entero"  placeholder="GRANO ENTERO" onkeypress="mascara(this, '##.##')" maxlength="5" autocomplete="off" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO QUEBRADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_quebrado"  name="grano_quebrado"  placeholder="GRANO QUEBRADO" onkeypress="mascara(this, '#.##')" maxlength="4" autocomplete="off" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>DAÑO POR HONGO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="dan_hongo"  name="dan_hongo"  placeholder="TEMPERATURA" onkeypress="mascara(this, '#.##')" maxlength="4" autocomplete="off"  >
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
              <input type="text" class="form-control input-lg soloNUMEROS" id="impureza"  name="impureza"  placeholder="IMPUREZA" onkeypress="mascara(this, '#.##')" maxlength="4" autocomplete="off" >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO CHICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_chico"  name="grano_chico"  placeholder="GRANO CHICO" onkeypress="mascara(this, '#.##')" maxlength="4" autocomplete="off"  >
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>GRANO PICADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_picado"  name="grano_picado"  placeholder="GRANO PICADO" onkeypress="mascara(this, '#.##')" maxlength="4" autocomplete="off">
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
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_viva"  name="plaga_viva"  placeholder="PLAGA VIVA" autocomplete="off" >
              <span class="input-group-addon">UNIDADES</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PLAGA MUERTA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_muerta"  name="plaga_muerta"  placeholder="PLAGA MUERTA" autocomplete="off"  >
              <span class="input-group-addon">UNIDADES</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>STRESS CRACK </label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="stress_crack"  name="stress_crack"  placeholder="STRESS CRACK"  autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5">
              <span class="input-group-addon">PORCENTAJE</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>OLOR</label>
              <input type="text" class="form-control input-lg" id="olor"  name="olor"  placeholder="OLOR" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         </div><!--- FIN ROW----->
          <br>
       <div class="row"><!--- INICIO ROW----->
          <div class="col-md-12">
          <div class="form-group">
             <label for="observacion">OBSERVACION</label>
             <textarea name="observacion" class="form-control" rows="3" placeholder="OBSERVACIONES" autocomplete="off" id="observacion" style="text-transform:uppercase;"></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
		

<br><br>
                         
              	  <table width="220" border="0" align="right">
			   	    <tr>
            	      <td width="100"><button type="reset" id="btnsub" class="btn btn-danger btn-lg pull-right"> Cancelar </button></td>
              	      <td width="20">&nbsp;</td>

              	      <td width="100"><input type="button" name="btnguardar" onclick="guardar()" value="Guardar" class="btn btn-primary btn-lg pull-right">  </button></td>
              	    </tr>
           	      </table> 
            
           </form> 
</div>
</div>
</div>

</div>
<div class="container-fluid">
  <div class="row" >
  
    <div class="col-md-13" >
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>VARIABLES DE CONTROL</strong></div> <!-- PANEL 1 --->
           <div class="panel-body"  >

<div>

<?php
$id_variab="VAR-000".$id_empresa;
	/*echo"<script>alert('llega al php');</script>";*/ 	 
	 $sql = "SELECT * FROM tab_variables as u WHERE 1=1 and id_empresa='$id_empresa' and id_variable!='$id_variab'";
 	 $result = mysql_query($sql,$con);
	 echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='200px'><div align='left'><a href='#' title='Ordenar por Cliente'>NOMBRE DE LA VARIABLE</a></div></th>
                                <th width='150px'><div align='left'><a href='#' title='Odenar por Peso Volumétrico'>PESO VOLUMETRICO</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Humedad'>HUMEDAD</a></div></th>	
								<th width='150px'><div align='left'><a href='#' title='Odenar por Temperatura'>TEMPERATURA</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Grano Entero'>GRANO ENTERO</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Grano Quebrado'>GRANO QUEBRADO</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Daño por Hongo'>DAÑO POR HONGO</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Grano Entero'>IMPUREZA</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Grano Chico'>GRANO CHICO</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Grano Picado'>GRANO PICADO</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Plaga Viva'>PLAGA VIVA</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Plaga Muerta'>PLAGA MUERTA</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Stress Crack'>STRESS CRACK</a></div></th>
								<th width='150px'><div align='left'><a href='#' title='Odenar por Olor'>OLOR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>CREADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA CREADO</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Creado por'>MODIFICADO POR</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Fecha Creado'>FECHA  MODIFICACION</a></div></th>
								<th width='200px'><div align='left'><a href='#' title='Odenar por Hora Creado'>HORA MODIFICACION</a></div></th>
	  												
        </tr>
        </thead>
        <tbody>";

			if ($result > 0){	
		    $correlativo = 1;
			$contar2++;
		while ($row = mysql_fetch_assoc($result)) 
                            {	
							 $nivel_busca=$row['id_nivel'];
							 $usuario_busca=$row['id_usuario2'];
							 $usuario_modifica=$row['id_usuario_modifica'];							 
							 $fecha_imprime=parseDatePhp($row[fecha_usuario]);
							 $fecha_imprime_modif=parseDatePhp($row[fecha_modifica]);
							 	
														 
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
		<td width='2%' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_variable']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a></td>	   
         
          <td width='auto' align='left'> $row[nom_variable] </td>
		  <td width='auto' align='left'> $row[peso_vol] </td>
		  <td width='auto' align='left'> $row[humedad] </td>
		  <td width='auto' align='left'> $row[temperatura] </td>
		  <td width='auto' align='left'> $row[grano_entero] </td>		  		  		  
  		  <td width='auto' align='left'> $row[grano_quebrado] </td>
		  <td width='auto' align='left'> $row[dan_hongo] </td>
		  <td width='auto' align='left'> $row[impureza] </td>		  
		  <td width='auto' align='left'> $row[grano_chico] </td>		  
		  <td width='auto' align='left'> $row[grano_picado] </td>		  
		  <td width='auto' align='left'> $row[plaga_viva] </td>		  
		  <td width='auto' align='left'> $row[plaga_muerta] </td>		  
		  <td width='auto' align='left'> $row[stress_crack] </td>
		  <td width='auto' align='left'> $row[olor] </td>		  		  
		  <td width='auto' align='left'> $nombre_usuario</td>	
		  <td width='auto' align='left'> $fecha_imprime </td>						  
		  <td width='auto' align='left'> $row[hora_usuario] </td>
		  <td width='auto' align='left'> $nombre_usuario_modif</td>	
		  <td width='auto' align='left'> $fecha_imprime_modif </td>						  
		  <td width='auto' align='left'> $row[hora_modifica] </td>		  		  
		  
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
<div class="navbar navbar-inverse navbar-fixed-bottom">
   <div class="container">
      <p class="navbar-text">
         Diseñado y Desarrollado Por <a href="http://www.ie-networks.com/">Ie Networks</a> © 2017.
      </p>
   </div>
</div>
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
                       <input type="text" name="nombre_usuario" class="form-control input-lg" placeholder="Usuario" autocomplete="off">
                     </div>	
                  </div>
             </div><!--- FIN ROW----->  
             <div class="row"><!--- INICIO ROW----->
                 <div class="col-md-12">
                   <div class="form-group">
                       <label for="contra">CONTRASEÑA</label>
                       <input type="password" name="con_usuario" class="form-control input-lg" placeholder="Contraseña" autocomplete="off">
                     </div>
                  </div>
             </div><!--- FIN ROW----->              
            <br>
         		<button class="btn btn-danger" data-dismiss="modal">Cerrar</button>
               	<button class="btn btn-primary" onClick="elimina()">Eliminar Registro</button>
    </div>
    <div>               
    </form>
</div>

</body> 
</html>


  <?php 
  // Eliminar producto	
  mysql_close();
?>