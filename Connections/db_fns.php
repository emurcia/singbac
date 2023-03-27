<?
//funcion que restablece la conexion

function db_connect()
{
   $result = @mysql_pconnect("localhost","rramirez","rramirez123*" ); // cambiar a nombre y usuario que sea asignado para el sitio
   if (!$result)
      return false;
   if (!@mysql_select_db("singbac"))
   
      return false;

   return $result;
}


//funcion que desplegara la informacion de la variable $result
function db_result_to_array($result)
{
   $res_array = array();
// Extrae la fila de resultado 
   for ($count=0; $row = @mysql_fetch_array($result); $count++)
     $res_array[$count] = $row;

   return $res_array;
}
?>

