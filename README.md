# Introducción
Este es el código fuente completo de aplicación SINGBAC (Sistema de Inventario de Granos Básicos).
Está hecho en php puro (estructurado monolítico)

# Requisitos
- PHP 5.6
- Mysql 5


# Instalación

Para linux clonar todo el contenido del proyecto en la carpeta /var/www/html/ 

Y para correrlo visitar en el navegador: http://localhost/

---------------------------------------------------------------------------------------

Para windows es necesario descargar xampp, descargue del siguiente enlace:
https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/5.6.40/xampp-windows-x64-5.6.40-1-VC11-installer.exe/download

Luego de instalada la aplicación abrirla (XAMPP Control Panel) y encender APACHE y MYSQL (Click al botón start de cada uno)

Cree y Copie todo el contenido a la carpeta C:/xampp/htdocs/singbac/

Para correrlo visite en el navegador: http://localhost/singbac/

---------------------------------------------------------------------------------------

Y sólo despues de restaurar la base de datos, colocar los datos de conexión en los siguientes 2 ficheros:
- conexion/conexion.inc: 
En este archivo sólo colocar en nombre de la base de datos en la tercera línea.


- conexion/conexion.php: 
En este otro archivo en la línea 7 colocar los datos del usuario de la base de datos.


# Información 
La tabla **t_usuarios** agregar o quitar los usuarios que se consideren convenientes.

La tabla **tab_menu** contiene todas las rutas a los formularios, no tocar de no ser necesario.

La ubicación de todos los formularios, pantallas, están en la carpeta **forms**.

La base de datos la puede encontrar en la carpeta: **base de datos/singbac.sql**
