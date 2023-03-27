# Introducción
Este es el código fuente completo de aplicación SINGBAC (Sistema de Inventario de Granos Básicos).
Está hecho en php puro (estructurado monolítico)
# Requisitos
- PHP 5.6
- Mysql 5
# Instalación
Para linux clonar todo el contenido del proyecto en la carpeta /var/www/html/ 

Y sólo despues de restaurar la base de datos, colocar los datos de conexión en los siguientes 2 ficheros:
- conexion/conexion.inc: 
En este archivo sólo colocar en nombre de la base de datos en la tercera línea.


- conexion/conexion.php: 
En este otro archivo en la línea 7 colocar los datos del usuario de la base de datos.


# Información 
La tabla **t_usuarios** agregar o quitar los usuarios que se consideren convenientes.

La tabla **tab_menu** contiene todas las rutas a los formularios, no tocar de no ser necesario.

La ubicación de todos los formularios, pantallas, están en la carpeta **form**
