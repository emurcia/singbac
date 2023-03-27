<?PHP
ini_set('session.save_handler', 'files');
@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
$id_empresa=$_SESSION['id_empresa_silo'];

?>
<?PHP
date_default_timezone_set("America/El_Salvador");
 $fecha_entrada=date('Y').'/'.date('m').'/'.date('d');
 $hora_entrada=date("H:i:s");
$correo_usuario=$_SESSION['correo_usu'];
$hora_entra= $_SESSION['hora_entra'];
$resu=mysql_query("SELECT a.*, b.* FROM t_usuarios  as a, t_empresa as b WHERE a.id_empresa=b.id_empresa and a.correo_usuario = '$correo_usuario'",$con);
				$va=mysql_fetch_array($resu);
                
				$id_usuario1 = $va['id_usuario'];
				
		$sql= ("UPDATE tab_bitacora SET fecha_salida='$fecha_entrada', hora_salida='$hora_entrada', estado_bitacora='1' WHERE id_usuario='$id_usuario1' and id_empresa='$id_empresa' and estado_bitacora='0' and hora_entrada='$hora_entra'");
mysql_query($sql,$con);

session_unset();
session_destroy(); 
echo "<script language='javascript'>";
echo "document.location.href='../index.php';";
echo "</script>";

?>