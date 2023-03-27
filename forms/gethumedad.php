<?php
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");
include("../function/functions.inc");
?>
<!DOCTYPE html>
<html>
<head>


</head>
<body>

<?php
$q = $_GET['q'];
$sql = "SELECT p.humedad FROM tab_producto as p join tab_lote as l on p.id_producto=l.id_producto where l.id_lote= '".$q."'";
$result = mysql_query($sql,$con);

$row =  mysql_fetch_array($result, MYSQL_ASSOC);


//echo "R =".intval($row['humedad']);

if(intval($row['humedad'])==1)
{

echo '<label><input type="checkbox" name="numedad" id="humedad" onclick="activar_textos()" value="0">CONTROL DE CALIDAD </label>
';
}
else {


	}

?>
</body>
</html>