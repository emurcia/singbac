<?php 
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");
@session_start();
$id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

$id_silo = $_POST['id_silo_buscar'];
// ESTRAER EL ESPACIO DE SILO
$espacio_silo=mysql_query("SELECT cap_silo as capacidad_silo FROM tab_silo WHERE id_silo= '".$id_silo."' and bandera=0 and id_empresa='".$id_empresa."'",$con);
$row=mysql_fetch_assoc($espacio_silo);
$cantidad_silo=$row['capacidad_silo'];

// EXTRAER DATO QUE YA FUE ASIGNADO A LOS LOTES
$consulta=mysql_query("SELECT sum(cant_producto) as cantidad FROM tab_detalle_servicio WHERE id_silo= '".$id_silo."' and num_servicio=1 and bandera=0 and id_empresa='".$id_empresa."'",$con);
$valor=mysql_fetch_assoc($consulta);
$espacio_ocupado=$valor['cantidad'];

//DISPONIBILIDAD DEL SILO

$resta	= $cantidad_silo-$espacio_ocupado;
//echo $resta;
echo " <div class='input-group'>
              <input type='text' class='form-control input-lg' id='espacio_disponible' name='espacio_disponible' value=' $resta' style='background:#FFF' readonly>
              <span class='input-group-addon'>Kilogramos</span>
              </div>";



?>