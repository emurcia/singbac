<?PHP
	echo "Ruta del Servidor: ".$_SERVER['DOCUMENT_ROOT']."</br>";
	echo "Ruta del Host: ".$_SERVER['HTTP_HOST']."</br>";
	echo "Puerto del servidor: ".$_SERVER['SERVER_PORT']."</br>";
	echo "URL Relativa: ".$_SERVER['REQUEST_URI']."</br>";
	echo "PHP_SELF: ".$_SERVER['PHP_SELF']."</br>";
?>