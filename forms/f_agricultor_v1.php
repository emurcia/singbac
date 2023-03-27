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
 $id_usuario = $_SESSION['id_usuario_silo']; // id_usuario en bd
 $_SESSION['activo_usuario_silo']; // = 0 (inactivo para usar el sistema); = 1 (activo para usar el sistema)
 $acceso =$_SESSION['nivel_silo'];
 $nom_sistema=$_SESSION['nom_sistema'];

 
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
$fecha=date('Y').'/'.date('m').'/'.date('d');
$hora=date("H:i:s");
$fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
$hora_entrada=date("H:i:s");



?>
<?PHP
$correo_usuario = $_POST['correo_usuario'];
//$nombre_act = $_POST['nom_usuario_act'];
$pass_usuario = $_POST['pass_usuario'];

?>

<!DOCTYPE html> 
<html> 
<head > 
<title><?PHP echo $nom_sistema; ?></title> 
<meta name="viewport" content="width=device-width, initial-scale=1.0" http-equiv="Content-Type"  charset="utf-8"> 

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

<script src="../assets/javascript/chosen.jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/stylesheet/chosen.css">
<script type="text/javascript" src="../assets/javascript/jquery.maskedinput.min.js" ></script>

</head> 
<script>
  	$(document).ready(function() {
	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers",
			"sScrollX": "100%"
	 });
	 });
	 
	 	 
function guardar(){


	 document.formulario.bandera.value='ok';
	 document.formulario.submit();

		
}// fin guardar

function guardar_act(){
		document.formulario_actualizar.bandera_actualizar.value='yes';
		document.formulario_actualizar.submit();
			
}// fin guardar



function validarEmail(valor) {
  if (/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i.test(valor)){
 //  alert("La dirección de email " + valor + " es correcta!.");
  } else {
   alert("La dirección de email " + valor + " es incorrecta!.");
   document.formulario.correo_usuario.value="";
   document.formulario.correo_usuario.focus();
  }
}
</script>	
 
<script>

function activar_textos() //funcionar para activas las cajas de textos
  {
		if(document.formulario_actualizar.disabled=!document.formulario_actualizar.disabled){
			document.getElementById('formulario_responsable').style.display = 'block';//Mostrar contenido
		//	document.formulario.ape_responsable.focus();
			return;
  		}else{
			document.getElementById('formulario_responsable').style.display = 'none';//oculta contenido
			return;
		}
  }	


  function activar_boton() //funcionar para activas las cajas de textos
  {
		
		if (document.formulario_actualizar.activar.checked==false){
			document.formulario_actualizar.btnguardar_act.disabled=true;
			}else{
				document.formulario_actualizar.btnguardar_act.disabled=false;
				}
			
  }	
  </script>
<script>
function salirr()
 {	 
    document.formulario.bandera.value="oki";
    document.formulario.submit();       
 }
   function index()
 {	 	
		document.location.href="f_principal.php";
    		     
 }
</script>
   

<script>
function modificar(str2)
{
							
	document.formulario_actualizar.id_modificar.value = str2;
	$.post('mostrar_act_agricultor.php',{id_agricultor_busca:document.formulario_actualizar.id_modificar.value}, 
			 function(result) {
				 	 
				$('#feedback').html(result).show();	
		  });//fin1
				
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
 <script type="text/javascript">
        $(document).ready(function(){
            $.mask.definitions['~']='[726]';
             $(".DUI").mask("99999999-9", {placeholder: "_"});
			  $(".TELEFONO").mask("9999-9999", {placeholder: "_"});

            $('.soloLetras').keypress(function(tecla) {
                if((tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && tecla.keyCode !=08 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32) return false;
            });

            $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57)) return false;
            });
        });
    </script>     

<script>
        $(document).ready(function(){
			$(".chosen").chosen({width: "100%", height:"100%"}); 
       });
</script>

<?PHP
	 $bandera_act = $_POST["bandera_actualizar"];
		
	if($bandera_act=="yes"){
		$nombre_act2=strtoupper($_POST['nom_agricultor_act']);
		$ape_act2=strtoupper($_POST['ape_agricultor_act']);
		$tel_act2=strtoupper($_POST['tel_agricultor_act']);
		$dir_act2=strtoupper($_POST['dir_agricultor_act']);
		if($_POST["nino_agricultor_act"]==""){$nin="0";}else{$nin=$_POST["nino_agricultor_act"];}
		if($_POST["adul_agricultor_act"]==""){$adul="0";}else{$adul=$_POST["adul_agricultor_act"];}
		if($_POST["adulmayor_agricultor_act"]==""){$adulmayor="0";}else{$adulmayor=$_POST["adulmayor_agricultor_act"];}
		$viveres_act2=strtoupper($_POST['viveres_agricultor_act']);
		$nombre_usuario_act=$_POST['usu_responsable']; // CORREO
	 	$con_usuario_act=md5($_POST['cont_responsable']);
		
	  $activo=1;
	  $empresa=$id_empresa;
	  $modificar=1;
 	  $cod2= $_POST["dui_agricultor_act"];
	// $_SESSION['codigo']=$cod2;

$resultado = autorizar_mod($nombre_usuario_act,$con_usuario_act,$activo,$empresa,$modificar);	
if($resultado==1){
		$guarda="400"; // Guarda
	}else {$error="500"; //No posee permisos para actualizar
		}

}// fin de bandera

 if($guarda==400) // incia la actualizaccón
   {//inicio actualizar
   $tabla5="SELECT *  FROM t_usuarios where correo_usuario='$nombre_usuario_act' and pass_usuario='$con_usuario_act' and id_empresa='$id_empresa'";
$select5 = mysql_query($tabla5);
while($row5 = mysql_fetch_array( $select5 ))
{
	$usuario_actualiza=$row5['id_usuario'];
}
   
   if(isset($cod2)){
		$sql= ("UPDATE tab_agricultor SET nom_agricultor='$nombre_act2', ape_agricultor='$ape_act2', tel_agricultor='$tel_act2', direccion='$dir_act2', id_usuario_modifica='$usuario_actualiza', fecha_modifica='$fecha', hora_modifica='$hora', ninos='$nin', adultos='$adul', terceraedad='$adulmayor', canasta='$viveres_act2' WHERE dui_agricultor='$cod2' and id_empresa='$id_empresa'");
		mysql_query($sql,$con);
	}
	if(mysql_error())
		  { 
			$error="1";
		  }
			  else
			$error="6";
					  
   } // fin actualizar
?>

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
	 
$usu_utilizado=mysql_query("SELECT * from tab_agricultor where dui_agricultor='$id_eliminar'"); // VERIFICA SI EL LOTE YA TIENE DATOS
$usu_utilizado2 = mysql_fetch_array($usu_utilizado);
if($usu_utilizado2['ocupado']==0){ // no ha sido utilizado
		$lleno=0;
  }else{ // Posse datos
  	 	$lleno=1;
  }	 
	 
	 
if ($lleno==0){
//$resultado = eliminar_su("tab_agricultor","dui_agricultor",$id_eliminar,$nombre_usuario,$con_usuario,$activo,$empresa,$eliminar);	
mysql_query("UPDATE tab_agricultor SET eliminado='1' WHERE dui_agricultor='$id_eliminar'");
if(!mysql_error())
		  { 
			$mensaje="1";
		  }
			  else
			$mensaje="2";
}			
/*if($resultado==1){
	$mensaje="1"; // Registro Eliminado
	
	}else{
	$mensaje="2"; // No posee permisos	
		
		}
	}
	
if($lleno==1){
	$mensaje="3";
	
	}
	*/
}// fin de bandera

?>



<body class="container"> 


<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->
<!-----inicio menu ---->

<?PHP include("menu.php");?>

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
// INICIA EL GUARDADO DE INFORMACION 
		 $bandera = $_POST['bandera'];
		 $zona1=$_POST["zona"];
		 $dui_agricultor1=$_POST["dui_agricultor"];
		 $nom_agricultor1  = strtoupper($_POST["nom_agricultor"]);
		 $ape_agricultor1  = strtoupper($_POST["ape_agricultor"]);
	     	$dir_agricultor1  = strtoupper($_POST["dir_agricultor"]);
		 $propiedad1=$_POST["propiedad"];
		 if($_POST["area_cultiva"]=="")
		 {$area_cultiva1="0.00";
		 }else{$area_cultiva1=$_POST["area_cultiva"];}
		// echo $area_cultiva1;
		 $oficio1=$_POST["oficio"];
		 $tel_agricultor1  = $_POST["tel_agricultor"];
		 $direccion1  = strtoupper($_POST["direccion"]);
		if($_POST["nino_agricultor"]==""){$nin1="0";}else{$nin1=$_POST["nino_agricultor"];}
		if($_POST["adul_agricultor"]==""){$adul1="0";}else{$adul1=$_POST["adul_agricultor"];}
		if($_POST["adulmayor_agricultor"]==""){$adulmayor1="0";}else{$adulmayor1=$_POST["adulmayor_agricultor"];}
		$viveres2=strtoupper($_POST['viveres_agricultor']);
		 		
if($pingresar==1){
	
if($bandera=="ok")
   {//
$mun_utilizado=mysql_query("SELECT count(*) as existe from tab_agricultor where dui_agricultor='$dui_agricultor1'"); // VERIFICA SI YA TIENE DATOS
$mun_utilizado2 = mysql_fetch_array($mun_utilizado);
if($mun_utilizado2['existe']!=0){ // no ha sido utilizado
	$error=5; // ya existe
  }else{ // pasa a guardar
 
mysql_query("insert into tab_agricultor(zona, dui_agricultor, nom_agricultor, ape_agricultor, propiedad, area_cultiva, oficio, tel_agricultor, direccion, id_usuario_ingreso, fecha_ingreso, hora_ingreso, id_usuario_modifica, fecha_modifica, hora_modifica, id_empresa, eliminado, ninos, adultos, terceraedad, canasta) values ('$zona1', '$dui_agricultor1', '$nom_agricultor1', '$ape_agricultor1', '$propiedad1', '$area_cultiva1', '$oficio1', '$tel_agricultor1', '$direccion1', '$id_usuario', '$fecha', '$hora','$id_usuario','$fecha','$hora','$id_empresa','0','$nin1','$adul1','$adulmayor1','$viveres2')",$con);     
				   
		 if(mysql_error())
		  { 
			//$error="1"; // error en datos
			echo mysql_error();
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
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Ocurrió un error en el procesamiento de los datos!!!", function () {location.href = 'f_agricultor.php';
					});
</script>				
 <?PHP
 }
 
 if($error == 2)
 {
	// $act= ("UPDATE tab_depto SET ocupado=1 WHERE dui_depto='$dui_depto1' and id_empresa='$id_empresa'");
//	 mysql_query($act,$con);
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Datos almacenados con éxito!!!", function () {location.href = 'f_agricultor.php';
					});
</script>				
 <?PHP
}

if($error == 5)
 {
	// $act= ("UPDATE tab_depto SET ocupado=1 WHERE dui_depto='$dui_depto1' and id_empresa='$id_empresa'");
//	 mysql_query($act,$con);
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Dui ya existe en la base de datos!!!", function () {location.href = 'f_agricultor.php';
					});
</script>				
 <?PHP
}
	  
if($mensaje==1){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  Datos eliminados con éxito!!!", function () {
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
if($mensaje==2){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  No posee permisos para eliminar registro!!!", function () {
					});
</script>				
 <?PHP
}

if($mensaje==3){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b> El usuario no se puede eliminar, ya realizó transacciones en el sistema!!!", function () {
					});
</script>				
 <?PHP

}
if($error==4){
?>
<script>
	  alertify.alert("<b> <?PHP echo $nom_sistema; ?>  </b>  El Usuario no tiene permiso para ingresar datos!!!", function () {
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


<!-- Inicia paginacion para mostrar los usuarios -->

  <div class="container-fluid">
  <div class="row" >
      <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading contains-buttons"><strong>DATOS DEL AGRICULTOR</strong> <a class="btn btn-sm btn-success  center pull-right"  data-toggle="modal" data-target="#modal_registro"><i class="glyphicon glyphicon-plus-sign"></i>  Nuevo </a></div> <!-- PANEL 1 --->
           <div class="panel-body" >
 				<div>
					<?php
					$nivel_busca="";
					$usuario_busca="";
					
					 if($id_usuario!='USU-0351'){
					 	
                                             $sql = "SELECT * FROM `tab_agricultor` WHERE id_usuario_ingreso='$id_usuario' and eliminado='0'";
                                            }else{
                                          $sql = "SELECT * FROM `tab_agricultor` WHERE eliminado='0'";
                                        
                                           }
						 $result = mysql_query($sql);
                       echo"<div class='responsive'><table width='auto' style='table-layout:fixed' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";
                    
                        echo"<thead>                     
                              <tr>            
                                
                                <th width='130px'><div align='left'>ACCIONES</div></th>
                                <th width='200px'><div align='left'><a href='#' title='Ordenar por Dui'>DUI</a></div></th>
                                <th width='250px'><div align='left'><a href='#' title='Odenar por Nombre'>NOMBRE</a></div></th>
                                                                <th width='250px'><div align='left'><a href='#' title='Odenar por Apellido'>APELLIDO</a></div></th>
                                                                <th width='250px'><div align='left'><a href='#' title='Odenar por Zona'>ZONA</a></div></th>
                                                                <th width='250px'><div align='left'><a href='#' title='Odenar por Oficio'>PROFESION / OFICIO</a></div></th>
                                                                <th width='250px'><div align='left'><a href='#' title='Odenar por Propiedad'>PROPIEDAD</a></div></th>  
                                                                <th width='250px'><div align='left'><a href='#' title='Odenar por Area'>AREA</a></div></th>                                                                                                                                
								<th width='250px'><div align='left'><a href='#' title='Odenar por Teléfono'>TELEFONO</a></div></th>
								<th width='250px'><div align='left'><a href='#' title='Odenar por Direccion'>DIRECCION</a></div></th>								
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
                                $correlativo1 = 1;
                                $contar4=0;
								
							while ($row = mysql_fetch_assoc($result)) 
                            {	
							// $nivel_busca=$row['id_nivel'];
							 $usuario_busca=$row['id_usuario_ingreso'];
							 $usuario_modifica=$row['id_usuario_modifica'];							 
							 $fecha_imprime=parseDatePhp($row[fecha_ingreso]);
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
                            <td width='60px' align='letf'>
							<a data-toggle='modal' data-target='#modal_actualizar' onClick='modificar(\"".$row['dui_agricultor']."\");'  style='cursor:pointer' class='btn btn-primary glyphicon glyphicon-edit' title='Modificar'></a>
							<a data-toggle='modal' data-target='#modal_eliminar' onClick='eliminar(\"".$row['dui_agricultor']."\");' style='cursor:pointer' class='btn btn-danger glyphicon glyphicon-trash' title='Eliminar'></a></td>
							  <td width='auto' align='left'> $row[dui_agricultor] </td>
                              <td width='auto' align='left'> $row[nom_agricultor] </td>
                               <td width='auto' align='left'> $row[ape_agricultor] </td>
                               <td width='auto' align='left'> $row[zona] </td>
                               <td width='auto' align='left'> $row[oficio] </td> 
                               <td width='auto' align='left'> $row[propiedad] </td>
                               <td width='auto' align='left'> $row[area_cultiva] </td>                                                              
                              <td width='auto' align='left'> $row[tel_agricultor] </td>		
                              <td width='auto' align='left'> $row[direccion] </td>		                              	  						  
							  <td width='auto' align='left'> $nombre_usuario</td>	
							  <td width='auto' align='left'> $fecha_imprime </td>						  
							  <td width='auto' align='left'> $row[hora_ingreso] </td>
							  <td width='auto' align='left'> $nombre_usuario_modif</td>	
							  <td width='auto' align='left'> $fecha_imprime_modif </td>						  
							  <td width='auto' align='left'> $row[hora_modifica] </td>
                              </tr>";
                            $contar4++;
							
                            }
								
							
                            $correlativo++;		
                    
                            echo"</tbody>
                        </table>
                        ";
                    
                    }
                       ?>
    <!--Fin si se ha seleccionado administrador-->

					<?php

					echo "Total de Registros" ." ".$contar4;
					 
					?>
  
</div>
</div>
</div>
</div>
</div>
</div>
</div>             


</div>
</div>
<br>
<br>
<br>
<!--  INICIO FOOTER   -->
<?php include('footer.php'); ?>
<!-- FIN FOOTER  -->

</body>
</html>

<!--------- INICIA MODAL INGRESO DE USUARIOS ------>
<div class="modal fade" id="modal_registro">
<br>
        <div class="modal-dialog">
          <div class="modal-content">                        
                        
          <div class="modal-body">
  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>REGISTRO DE AGRICULTORES</strong> <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <form action="f_agricultor.php" class="formusu" method="post" name="formulario" role="form">  
        <input name="bandera" value="0" type="hidden" />     
	       <input type="hidden"  name="busca">
           <input type="hidden" name="dui_prod_eliminar"> 
           <input type="hidden" name="dui_prod_modif">          
                  
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label for="cliente"> MUNICIPIO</label>
                       
                      <select name="zona" class="form-control input-lg chosen" size="1" id="zona">
                            <option value="SELECCIONE">SELECCIONE</option>
                            <option value="EL BALSAMO">EL BALSAMO</option>
                            <option value="CANDELARIA ARRIBA">CANDELARIA ARRIBA</option>
                            <option value="CANDELARIA ABAJO">CANDELARIA ABAJO</option>
                            <option value="BARRIO SAN CAYETANO">BARRIO SAN CAYETANO</option>
                            <option value="BARRIO ISTEPEQUE">BARRIO ISTEPEQUE</option>
                            <option value="LA ENTREVISTA">LA ENTREVISTA</option>
                            <option value="LOS MANGOS">LOS MANGOS</option>
                            <option value="CERRO GRANDE">CERRO GRANDE</option>
                            <option value="DESVIO">DESVIO</option>
                            <option value="VUELTA EL GLOBO">VUELTA EL GLOBO</option>
                            <option value="SANTA ELENA">SANTA ELENA</option>
                            <option value="LAS ISLETAS">LAS ISLETAS</option>
                            <option value="SAN VICENTE">SAN VICENTE</option>
                            <option value="TEPETITAN">TEPETITAN</option> 
                            <option value="GUADALUPE">GUADALUPE</option>                                                       
							 
                    </select>
                              
                  </div>
              </div>
                         
        
              <div class="col-md-6">
              <div class="form-group">
               <label>DUI:</label>
               <input type="text" class="form-control input-lg DUI" style="text-transform:uppercase" id="dui_agricultor" name="dui_agricultor" placeholder="DUI" autocomplete="off" required/>           
                  </div>
              </div>
            
              
           </div><!--- FIN ROW----->
               <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>NOMBRE:</label>
               <input type="text" class="form-control input-lg soloLetras" style="text-transform:uppercase" id="nom_agricultor" name="nom_agricultor" placeholder="NOMBRE" autocomplete="off" required/>           
                  </div>
              </div>
            
              <div class="col-md-6">
              <div class="form-group">
               <label>APELLIDO:</label>
               <input type="text" class="form-control input-lg soloLetras" id="ape_agricultor"  name="ape_agricultor" placeholder="DIRECCION" style="text-transform:uppercase" autocomplete="off" required/>    
                  </div>
              </div>
           </div><!--- FIN ROW----->
                  <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>PROPIEDAD:</label>
                <select name="propiedad" class="form-control input-lg chosen" size="1" id="propiedad">
                            <option value="0">SELECCIONE</option>
                            <option value="PROPIA">PROPIA</option>
                            <option value="ALQUILADA">ALQUILADA</option>
                           							 
                    </select>          
                  </div>
              </div>
            
              <div class="col-md-6">
              <div class="form-group">
               <label>AREA QUE CULTIVA:</label>
               <input type="text" class="form-control input-lg soloNumeros" id="area_cultiva"  name="area_cultiva" placeholder="AREA QUE CULTIVA"  autocomplete="off" required/>    
                  </div>
              </div>
           </div><!--- FIN ROW----->
               <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>OFICIO:</label>
                <select name="oficio" class="form-control input-lg chosen" size="1" id="oficio">
                            <option value="0">SELECCIONE</option>
                            <option value="AGRICULTOR">AGRICULTOR</option>
                            <option value="AMA DE CASA">AMA DE CASA</option>
                            <option value="JORNALERO">JORNALERO</option>
                            <option value="GANADERO">GANADERO</option>
                            <option value="DOMESTICOS">DOMESTICOS</option>
                            
                           							 
                    </select>          
                  </div>
              </div>
            
              <div class="col-md-6">
              <div class="form-group">
               <label>TELEFONO:</label>
               <input type="text" class="form-control input-lg TELEFONO" id="tel_agricultor"  name="tel_agricultor" placeholder="TELEFONO" style="text-transform:uppercase" autocomplete="off" required/>    
                  </div>
              </div>
           </div><!--- FIN ROW----->
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>DIRECCION:</label>
                 <textarea name="direccion" class="form-control input-lg" rows="2" placeholder="DIRECCION" autocomplete="off" id="direccion" style="text-transform:uppercase;"></textarea>  
                  </div>
              </div>
           </div><!--- FIN ROW----->
            <div class="row"><!--- INICIO ROW----->
          <div class="col-md-3">
          <div class="form-group">
             <label>NIÑOS:</label>
               <input type="text" class="form-control input-lg" id="nino_agricultor" name="nino_agricultor" placeholder="NIÑOS" autocomplete="off" required/>  
          </div>
          </div>
          <div class="col-md-3">
          <div class="form-group">
             <label>ADULTOS:</label>
               <input type="text" class="form-control input-lg" id="adul_agricultor" name="adul_agricultor" placeholder="ADULTOS" autocomplete="off" required/>  
          </div>
          </div>
          <div class="col-md-3">
          <div class="form-group">
             <label>+ 60 AÑOS:</label>
               <input type="text" class="form-control input-lg" id="adulmayor_agricultor" name="adulmayor_agricultor" placeholder="+ 60 AÑOS" autocomplete="off" required/>  
          </div>
          </div>
           <div class="col-md-3">
          <div class="form-group">
             <label>VIVERES?:</label>
               <input type="text" class="form-control input-lg" id="viveres_agricultor" name="viveres_agricultor" placeholder="VIVERES" value="SI" autocomplete="off" required/>  
          </div>
          </div>
          </div><!--- FIN ROW----->
          
           
                       

<br>
             
         <button type="submit" name="btnguardar" class="btn btn-primary glyphicon glyphicon-saved center pull-right" onclick="guardar()">  Guardar</button>
                       
           </form> 
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>


<!--------- FIN MODAL INGRESO DE USUARIOS ------>



 <!-- INICIA ACTUALIZAR -->
<div class="modal fade" id="modal_actualizar" >

<form name="formulario_actualizar" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post" >
<input type="hidden" name="bandera_actualizar" value="">
<input type="hidden" name="id_modificar" value="" >
<input type="hidden" name="usuario" value="0">

     <div class="modal-dialog">
          <div class="modal-content">                        
                        
          <div id="feedback" class="modal-body" > </div> 
    
		<br>
     
      
   <div  style='display:none;'  id="formulario_responsable">
                            
                        
          <div class="modal-body">
  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
        <div class="panel-heading"><strong>AUTORIZACIÓN</strong></div> <!-- PANEL 1 --->
           <div class="panel-body" >
     	<div class="row" >
  		   <div class="col-md-12">
        		
           					<div class="panel-body" >
           				    <div class="row"><!--- INICIO ROW----->
                      		<div class="col-md-6">
                              <div class="form-group">
                                    <label for="origen_servicio">USUARIO</label>
                                    <input type="text" class="form-control input-lg" id="usu_responsable" placeholder="Usuario"  name="usu_responsable" autocomplete="off" >
                              </div>
                            </div>
                           <div class="col-md-6">
                              <div class="form-group">
                                    <label for="origen_servicio">CONTRASEÑA</label>
                                    <input type="password" class="form-control input-lg" id="cont_responsable" placeholder="Nombre del Encargado"  name="cont_responsable" autocomplete="off" >
                              </div>
                            </div>
                          </div><!--- FIN ROW----->  
                          
                          <div class="checkbox">
                     
            
              <label>
                <input type="checkbox" name="activar" onclick="activar_boton()">Realizar modificación? </label>
          </div> 
                           </div>
     
      </div>  
      </div>
      </div>
      </div>
       </div>
      </div>  
      </div>
      </div>
      </div>
      </div>
      </div>
                 
    </form>
    
</div>

<!-- FIN ACTUALIZAR -->
 
 <!-- INICIA ELIMINAR REGISTRO -->
<div class="modal fade" id="modal_eliminar">
<form name="formulario_delete" action="<?PHP echo $_SERVER['PHP_SELF']; ?>" method="post">
<input type="hidden" name="id_eliminar" value="0">
<input type="hidden" name="bandera_acciones" value="">
            <div class="modal-dialog">
          <div class="modal-content">                        
                        
          <div class="modal-body">
  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
        <div class="panel-heading"><strong>AUTORIZACIÓN</strong> <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button></div> <!-- PANEL 1 --->
           <div class="panel-body" >
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
            <button class="glyphicon glyphicon-erase btn btn-danger center pull-right" onClick="elimina()">  Eliminar</button>
    </div>
    <div>    
     <div>            
    </form>
</div>
</div></div></div></div></div></div></div> </div> 

</body> 
</html>


  <?php 
  // Eliminar producto	
  mysql_close();
?>
