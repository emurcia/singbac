<?php
// El servidor con el formato: <computer>\<instance name> o
// <server>,<port> cuando se use un número de puerto diferente del de defecto
$server = '192.168.5.103/TF-INC-PBX' ;

// Connect to MSSQL
$link = mssql_connect( $server , 'UsrDesarrollos' , 'root00-2017' );

if (! $link ) {
die( 'Algo fue mal mientras se conectaba a MSSQL' );
}
?>
