<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_silos_connections = "localhost";
$database_silos_connections = "silos";
$username_silos_connections = "root";
$password_silos_connections = "rootroot";
$silos_connections = mysql_pconnect($hostname_silos_connections, $username_silos_connections, $password_silos_connections) or trigger_error(mysql_error(),E_USER_ERROR); 
?>