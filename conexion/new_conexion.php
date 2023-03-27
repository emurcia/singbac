<?PHP
$hostname_conexion = "localhost";
$database_conexion = "singbacnet";
$username_conexion = "UsrDesarrollos'";
$password_conexion = "root00-2017*";
$con = mysqli_connect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysqli_error(),E_USER_ERROR);
?>