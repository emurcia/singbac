<?php

// funcion para dividir cantidades en miles y en decimales
function get_price($p_format = 0){
    if ($p_format == 0){
      return $this->price;
    }elseif ($p_format == 1){
        return number_format($this->price, 2, ",", "."); // &euro; = €
    }
}



//La funcion quita_espacios quita los espacios de una cadena de caracteres
function quita_espacios($nombre)
{
	$tamanio = strlen ($nombre) ;
	$cadena_auxiliar = "";
	for ($x = 0;$x < $tamanio; $x++)
	{
		$cadena_auxiliar = $cadena_auxiliar . trim($nombre{$x});
		$nombre{$x};
	}
	return $cadena_auxiliar;
}
/*
function eliminar_su($table,$id_buscar,$valor_id,$nombre_usuario,$contrasena,$usuario_acti, $id_empre,$nivel){
$string_usuario = mysql_query("SELECT COUNT(*) AS num FROM t_usuarios WHERE correo_usuario = '$nombre_usuario' AND pass_usuario = '$contrasena' AND activo_usuario='$usuario_acti' AND id_empresa='$id_empre' AND id_nivel='$nivel';") or die(mysql_error());
	$rs_usuario = mysql_fetch_array($string_usuario, $con);
	if(!empty($rs_usuario['num'])){
		mysql_query("DELETE FROM $table WHERE $id_buscar = '$valor_id' AND id_empresa='$id_empre';") or die(mysql_error());	
		if(!mysql_error()){
			return 1;
		}else
			return 0;
	}	
	
}
*/

function eliminar_niveles($table,$id_buscar,$id_buscarnivel, $valor_id,$nombre_usuario,$contrasena,$usuario_acti, $id_empre,$eliminar,$nivel){
$string_usuario = mysql_query("SELECT COUNT(a.id_usuario) AS num, b.* FROM t_usuarios as a, tab_nivel as b WHERE a.correo_usuario = '$nombre_usuario' AND a.pass_usuario = '$contrasena' AND a.activo_usuario='$usuario_acti' AND a.id_empresa='$id_empre' AND a.id_nivel=b.id_nivel and b.eliminar='$eliminar';") or die(mysql_error());
	$rs_usuario = mysql_fetch_array($string_usuario, $con);
	if(!empty($rs_usuario['num'])){
		mysql_query("DELETE FROM $table WHERE $id_buscar = '$valor_id' and $id_buscarnivel='$nivel' AND id_empresa='$id_empre';") or die(mysql_error());	
		if(!mysql_error()){
			return 1;
		}else
			return 0;
	}	
	
}

function eliminar_su($table,$id_buscar,$valor_id,$nombre_usuario,$contrasena,$usuario_acti, $id_empre,$eliminar){
$string_usuario = mysql_query("SELECT COUNT(a.id_usuario) AS num, b.* FROM t_usuarios as a, tab_nivel as b WHERE a.correo_usuario = '$nombre_usuario' AND a.pass_usuario = '$contrasena' AND a.activo_usuario='$usuario_acti' AND a.id_empresa='$id_empre' AND a.id_nivel=b.id_nivel and b.eliminar='$eliminar';") or die(mysql_error());
	$rs_usuario = mysql_fetch_array($string_usuario, $con);
	if(!empty($rs_usuario['num'])){
		mysql_query("DELETE FROM $table WHERE $id_buscar = '$valor_id' AND id_empresa='$id_empre';") or die(mysql_error());	
		if(!mysql_error()){
			return 1;
		}else
			return 0;
	}	
	
}


// FUNCION PARA AUTORIZAR LA SALIDA DE PRODUCTO
function autorizar_su($nombre_usuario,$contrasena,$usuario_acti, $id_empre,$nivel){
$string_usuario = mysql_query("SELECT COUNT(*) AS num FROM t_usuarios WHERE correo_usuario = '$nombre_usuario' AND pass_usuario = '$contrasena' AND activo_usuario='$usuario_acti' AND id_empresa='$id_empre' AND id_nivel='$nivel';") or die(mysql_error());
	$rs_usuario = mysql_fetch_array($string_usuario, $con);
	if(!empty($rs_usuario['num'])){
		return 1;
		}else
		return 0;
	}

function autorizar_mod($nombre_usuario,$contrasena,$usuario_acti, $id_empre,$modificar){
$string_usuario = mysql_query("SELECT COUNT(a.id_usuario) AS num, b.* FROM t_usuarios as a, tab_nivel as b WHERE a.correo_usuario = '$nombre_usuario' AND a.pass_usuario = '$contrasena' AND a.activo_usuario='$usuario_acti' AND a.id_empresa='$id_empre' AND a.id_nivel=b.id_nivel and b.modificar='$modificar';") or die(mysql_error());
	$rs_usuario = mysql_fetch_array($string_usuario, $con);
	if(!empty($rs_usuario['num'])){
		return 1;
		}else
		return 0;
	}	



function acortar_texto($string, $length=NULL)
{
    //Si no se especifica la longitud por defecto es 50
    if ($length == NULL)
        $length = 50;
    //Primero eliminamos las etiquetas html y luego cortamos el string
    $stringDisplay = substr(strip_tags($string), 0, $length);
    //Si el texto es mayor que la longitud se agrega puntos suspensivos
    if (strlen(strip_tags($string)) > $length)
        $stringDisplay .= ' ...';
    return $stringDisplay;
}


/*Edad con meses calculadas*/
function edad_x_pavlo16($fecha_de_nacimiento)
						{
							
$fecha_de_nacimiento = $fecha_de_nacimiento; //"1984-03-05"; 
$fecha_actual = date ("Y-m-d"); 
//$fecha_actual = date ("2006-03-05"); //para pruebas 

//echo "<br>Hoy es $fecha_actual"; 
////echo "<br>Naciste el $fecha_de_nacimiento"; 

// separamos en partes las fechas 
$array_nacimiento = explode ( "-", $fecha_de_nacimiento ); 
$array_actual = explode ( "-", $fecha_actual ); 

$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años 
$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 
$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días 

//ajuste de posible negativo en $días 
if ($dias < 0) 
{ 
    --$meses; 

    //ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 
    switch ($array_actual[1]) { 
           case 1:     $dias_mes_anterior=31; break; 
           case 2:     $dias_mes_anterior=31; break; 
           case 3:  
                if (bisiesto($array_actual[0])) 
                { 
                    $dias_mes_anterior=29; break; 
                } else { 
                    $dias_mes_anterior=28; break; 
                } 
           case 4:     $dias_mes_anterior=31; break; 
           case 5:     $dias_mes_anterior=30; break; 
           case 6:     $dias_mes_anterior=31; break; 
           case 7:     $dias_mes_anterior=30; break; 
           case 8:     $dias_mes_anterior=31; break; 
           case 9:     $dias_mes_anterior=31; break; 
           case 10:     $dias_mes_anterior=30; break; 
           case 11:     $dias_mes_anterior=31; break; 
           case 12:     $dias_mes_anterior=30; break; 
    } 

    $dias=$dias + $dias_mes_anterior; 
} 

//ajuste de posible negativo en $meses 
if ($meses < 0) 
{ 
    --$anos; 
    $meses=$meses + 12; 
} 
//echo "<br>Tu edad es: $anos años con $meses meses y $dias días";


if($anos<=3)
$dato = $anos." años con ".$meses." meses y ".$dias." días";
else
if($anos>=4 and $anos <7)
$dato = $anos." años con ".$meses." meses";//.$dias." días";
else
$dato = $anos." años"; 

/*
if(((int)$meses == 0) && ((int)$anos == 0))
$dato =  $anos.utf8_encode(" años con ").abs($meses)." meses y ".(int)$cuenta_dias.utf8_encode(" días"); 							
else
$dato =  $anos.utf8_encode(" años con ").abs($meses)." meses ";							
*/

		return utf8_encode($dato);
		
						}

 

function bisiesto($anio_actual){ 
    $bisiesto=false; 
    //probamos si el mes de febrero del año actual tiene 29 días 
      if (checkdate(2,29,$anio_actual)) 
      { 
        $bisiesto=true; 
    } 
    return $bisiesto; 
} 
/*fin edad con meses calculadas*/


function calculaedad($fechanacimiento){
    list($ano,$mes,$dia) = explode("-",$fechanacimiento);
    $ano_diferencia  = date("Y") - $ano;
    $mes_diferencia = date("m") - $mes;
    $dia_diferencia   = date("d") - $dia;
    if ($dia_diferencia < 0 || $mes_diferencia < 0)
        $ano_diferencia--;
    return $ano_diferencia;
}


function edad_x_pavlo($fecha_de_nacimiento)
						{

$fecha_actual = date ("Y-m-d"); 

// separamos en partes las fechas 
$form1 = explode ( "-", $fecha_de_nacimiento ); 
$form2 = explode ( "-", $fecha_actual ); 

$anos = $form2[0] - $form1[0]; // calculamos años 
$meses = $form2[1] - $form1[1]; // calculamos meses 
// calculamos los dias 
$dias1 = mktime ( 0, 0, 0, date ("$form1[1]"), date ("$form1[2]"), date ("$form1[0]") );  
$dias2 = mktime ( 0, 0, 0, date ("$form2[1]"), date ("$form2[2]"), date ("$form2[0]") );  
$cuenta_dias = ( $dias2 - $dias1 ) / 86400; 

$anos = $anos -1;

if($anos<0) $anos = 0;

if(((int)$meses == 0) && ((int)$anos == 0))
$dato =  $anos.utf8_encode(" años con ").abs($meses)." meses y ".(int)$cuenta_dias.utf8_encode(" días"); 							
else
$dato =  $anos.utf8_encode(" años con ").abs($meses)." meses ";							


		return $dato;
						}



function edad_x_pavlo_varixfecha($fecha_de_nacimiento,$ifecha)
						{

//$fecha_actual = date ("Y-m-d"); 

$fecha_actual = $ifecha;
// separamos en partes las fechas 
$form1 = explode ( "-", $fecha_de_nacimiento ); 
$form2 = explode ( "-", $fecha_actual ); 

$anos = $form2[0] - $form1[0]; // calculamos años 
$meses = $form2[1] - $form1[1]; // calculamos meses 
// calculamos los dias 
$dias1 = mktime ( 0, 0, 0, date ("$form1[1]"), date ("$form1[2]"), date ("$form1[0]") );  
$dias2 = mktime ( 0, 0, 0, date ("$form2[1]"), date ("$form2[2]"), date ("$form2[0]") );  
$cuenta_dias = ( $dias2 - $dias1 ) / 86400; 

if(((int)$meses == 0) && ((int)$anos == 0))
$dato =  $anos.utf8_encode(" años con ").$meses." meses y ".(int)$cuenta_dias.utf8_encode(" días"); 							
else
$dato =  $anos.utf8_encode(" años con ").$meses." meses ";							


		return $dato;
						}
/* La funcion Gener_Codig genera el codigo utilizando el nombre 
de la institucion utilizando tres letras la primera la de enmedio y la ultima
ademas toma los ultimos dos numeros del año y tres corelativos*/

/* function Gener_Codig($nombre, $tb_tabla, $codigo)
{
	require('../conexion.php');

$anio2 = date("y");


//La funcion redondeado redondea un numero decimal a un numero entero
	function redondeado ($numero, $decimales) {
	   $factor = pow(10, $decimales);
	   return (round($numero*$factor)/$factor); } 

//Generar tres letras del nombre
$primera = substr($nombre,0,1); //Extrae primer letra
$segunda = substr($nombre,(redondeado((strlen($nombre)/2)-1,0)),1); //Extrae segunda letra
$tercera = substr($nombre,-1);//Extrae tercer letra
$letras  = $primera.$segunda.$tercera;//Unificar tres letras
$letras_anio = $letras.$anio2;
$codigo_generado = $letras_anio."001";
$codigo_generado2 = "";

$resultado = mysql_query("select * from $tb_tabla where $codigo = '$codigo_generado'");//Para saber si hay registros en la base de datos
$valor	= mysql_num_rows($resultado);
$correlativo1 = 0;
$correlativo2 = 0;
if ($valor > 0)
{
	$resultado1 = mysql_query("select $codigo from $tb_tabla");
	//Comprobar que el correlativo aumente si existe uno igual
	while ($fila00 = mysql_fetch_array($resultado1))
	{
		$codigo_generado2  = ($fila00["$codigo"]);
		$parte_uno	 	= substr($codigo_generado2,0,5);
		$correlativo1	= substr($codigo_generado2,-3);
		if ($parte_uno == $letras_anio)
		{ if($correlativo2 < $correlativo1)
			{$correlativo2 = $correlativo1;}
			}
		}
		$respuesta = $correlativo2+1;
		if (strlen($respuesta) == 1)
		{$var_codig_extraer = $letras_anio."00".$respuesta;}
			else
			if (strlen($respuesta) == 2)
			{$var_codig_extraer = $letras_anio."0".$respuesta;}
				else
				if (strlen($respuesta) == 3)
				{$var_codig_extraer = $letras_anio.$respuesta;}
	}
	else
	{$var_codig_extraer = $codigo_generado;}	
	
	return $var_codig_extraer;
}

*/
//tranformar fecha de dd-mm-YY a YY-mm-dd
function parseDateMysql($fecha){
$dia		  	 = substr($fecha,0,2); // Extrae los primeros dos numeros de la fecha correspondientes al dia
$mes  		  	 = substr($fecha,3,2); // Estrae los segundos dos numeros de la fecha correspondientes al mes
$anio 		  	 = substr($fecha,-4);  // Extrae los ultimos cuatro numeros de la fecha correspondientes al año
$var_fecha = $anio."-".$mes."-".$dia; //uniendo la fecha al formato que recibe MYSQL YYYY-MM-DD
return $var_fecha;
}

//tranformar fecha de YY-mm-dd a dd-mm-YY  
function parseDatePhp($fecha){
$anio		  	 = substr($fecha,0,4); // Extrae los primeros cuatro numeros de la fecha correspondientes al año
$mes  		  	 = substr($fecha,5,2); // Estrae los segundos dos numeros de la fecha correspondientes al mes
$dia		  	 = substr($fecha,-2);  // Extrae los ultimos cuatro numeros de la fecha correspondientes al dia
$var_fecha_n = $dia."-".$mes."-".$anio; //uniendo la fecha al formato que recibe MYSQL YYYY-MM-DD
return $var_fecha_n;
}

function fechaHastaMes($fecha){
$anio		  	 = substr($fecha,0,4); // Extrae los primeros cuatro numeros de la fecha correspondientes al año
$mes  		  	 = substr($fecha,5,2); // Estrae los segundos dos numeros de la fecha correspondientes al mes
$mes2 = "";
if($mes=="01") $mes2 = "ENERO";
if($mes=="02") $mes2 = "FEBRERO";
if($mes=="03") $mes2 = "MARZO";
if($mes=="04") $mes2 = "ABRIL";
if($mes=="05") $mes2 = "MAYO";
if($mes=="06") $mes2 = "JUNIO";
if($mes=="07") $mes2 = "JULIO";
if($mes=="08") $mes2 = "AGOSTO";
if($mes=="09") $mes2 = "SEPTIEMBRE";
if($mes=="10") $mes2 = "OCTUBRE";
if($mes=="11") $mes2 = "NOVIEMBRE";
if($mes=="12") $mes2 = "DICIEMBRE";
$dia		  	 = substr($fecha,-2);  // Extrae los ultimos cuatro numeros de la fecha correspondientes al dia
$var_fecha_n = $dia." DE ".$mes2; //uniendo la fecha al formato que recibe MYSQL YYYY-MM-DD
return $var_fecha_n;
}

function fechaSoloAnno($fecha){
$anio		  	 = substr($fecha,2,2); // Extrae los primeros cuatro numeros de la fecha correspondientes al año
$mes  		  	 = substr($fecha,5,2); // Estrae los segundos dos numeros de la fecha correspondientes al mes
$dia		  	 = substr($fecha,-2);  // Extrae los ultimos cuatro numeros de la fecha correspondientes al dia
$var_fecha_n = $anio; //uniendo la fecha al formato que recibe MYSQL YYYY-MM-DD
return $var_fecha_n;
}

function Quitar_espacio($espac){
$cadena =explode(" ","$espac");
$tamaño = count($cadena);
$espacios = $tamaño - 1;
return $espacios;}

/*
function Authorized($Limit, $Types, $Name, $Type) { 
  require('../conexion.php');
	
  $Valid = false;
  
  if (!empty($Name)) { 
    $arrGroups = Explode(",", $Types);  
    
	if($Type == 5 && $Limit < 1000) {
		$arrPrivileges = "";
		$resultSQL	= pg_query($pcondb, "SELECT * FROM tb_privilegio WHERE privilegio_colaborador = '".$_SESSION['INDES_Codetype']."'");
		while($row = pg_fetch_array($resultSQL)) {
			$arrPrivileges = $arrPrivileges.",".$row['privilegio_tipo'];
		}
		
		$arrPrivileges = Explode(",", $arrPrivileges); 
		
		if (in_array($Limit, $arrPrivileges)) { 
			$Valid = true;
		}
	} else if (in_array($Type, $arrGroups)) { 
		$Valid = true;
	} 
  } 
  return $Valid; 
}


function Restrict($Types, $Limit) {
	$Location = "../error/401.html";
	
	if (!((isset($_SESSION['INDES_Username'])) && (Authorized($Limit ,$Types, $_SESSION['INDES_Username'], $_SESSION['INDES_Usertype'])))) {
		$Char = "?";
		$Referrer = $_SERVER['PHP_SELF'];
		
		if (strpos($Location, "?")) $Char = "&";
		if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
			$Referrer .= "?" . $QUERY_STRING;
		$Location = $Location. $Char . "accesscheck=" . urlencode($Referrer);
		header("Location: ". $Location); 
		exit;
	}
}


function tiempo_laborar($fecha_ingre)
{
	$fechaInicio =$fecha_ingre;  
$fechaActual = date("d-m-Y");  
  $diaActual = substr($fechaActual, 0, 2);  
$mesActual = substr($fechaActual, 3, 5);  
$anioActual = substr($fechaActual, 6, 10);  
$diaInicio = substr($fechaInicio, 0, 2);  
$mesInicio = substr($fechaInicio, 3, 5);  
$anioInicio = substr($fechaInicio, 6, 10);  
  $b = 0;  
$mes = $mesInicio-1;  
if($mes==2){  
if(($anioActual%4==0 && $anioActual%100!=0) || $anioActual%400==0){  
$b = 29;  
}else{  
$b = 28;  
}  
}  
else if($mes<=7){  
if($mes==0){  
 $b = 31;  
}  
  else if($mes%2==0){  
  $b = 30;  
  }  
  else{  
  $b = 31;  
  }  
  }  
  else if($mes>7){  
  if($mes%2==0){  
  $b = 31;  
  }  
  else{  
  $b = 30;  
  }  
  }  
   if(($anioInicio>$anioActual) || ($anioInicio==$anioActual && $mesInicio>$mesActual) ||   
  ($anioInicio==$anioActual && $mesInicio == $mesActual && $diaInicio>$diaActual)){  
  //echo "La fecha de inicio ha de ser anterior a la fecha Actual";  
  }else{  
  if($mesInicio <= $mesActual){  
  $anios = $anioActual - $anioInicio;  
  if($diaInicio <= $diaActual){  
  $meses = $mesActual - $mesInicio;  
  $dies = $diaActual - $diaInicio;  
  }else{  
  if($mesActual == $mesInicio){  
  $anios = $anios - 1;  
  }  
  $meses = ($mesActual - $mesInicio - 1 + 12) % 12;  
  $dies = $b-($diaInicio-$diaActual);  
  }  
  }else{  
  $anios = $anioActual - $anioInicio - 1;  
  if($diaInicio > $diaActual){  
  $meses = $mesActual - $mesInicio -1 +12;  
  $dies = $b - ($diaInicio-$diaActual);  
  }else{  
  $meses = $mesActual - $mesInicio + 12;  
  $dies = $diaActual - $diaInicio;  
  }  
  }  
  if ($meses==1)
  $tiempo_laborar = "$anios AÑOS $meses MES $dies DIAS";
  //else if($anios<=2)
  else
  $tiempo_laborar = "$anios AÑOS $meses MESES $dies DIAS";
  
  }
	return utf8_encode($tiempo_laborar);
}


function edad($fecha_ingre)
{//Inicio funcion edad
	$fechaInicio =$fecha_ingre;  
    $fechaActual = date("d-m-Y");  
    $diaActual = substr($fechaActual, 0, 2);  
    $mesActual = substr($fechaActual, 3, 2);  
    $anioActual = substr($fechaActual, 6, 4);  
    $diaInicio = substr($fechaInicio, 0, 2);  
    $mesInicio = substr($fechaInicio, 3, 2);  
    $anioInicio = substr($fechaInicio, 6, 4);  
	
    $b = 0;  
    $mes = $mesInicio-1;  
    
	if($mes==2)
	{  
         if(($anioActual%4==0 && $anioActual%100!=0) || $anioActual%400==0) 
              $b = 29;  
		 else
              $b = 28;  
    }  
    else if($mes<=7)
	{   
         if($mes==0)
		 {  
            $b = 31;  
         }  
         else if($mes%2==0)
		 {  
            $b = 30;  
         }  
         else
		 {  
            $b = 31;  
         }  
    }   
    else if($mes>7)
	{  
         if($mes%2==0) 
            $b = 31;  
         else
            $b = 30;  
    }  
    
	if(($anioInicio>$anioActual) || ($anioInicio==$anioActual && $mesInicio>$mesActual) || ($anioInicio==$anioActual && $mesInicio == $mesActual && $diaInicio>$diaActual))
	{  
        //echo "La fecha de inicio ha de ser anterior a la fecha Actual";  
    }
	else
	{  
        if($mesInicio <= $mesActual)
		{  
           $anios = $anioActual - $anioInicio;  
           if($diaInicio <= $diaActual)
		   {  
               $meses = $mesActual - $mesInicio;  
               $dies = $diaActual - $diaInicio;  
           }
		   else
		   {  
		      //////////////echo $mesActual." y ".$mesInicio;
              if($mesActual == $mesInicio)
			  {  
                 $anios = $anios - 1;  
              }  
              $meses = ($mesActual - $mesInicio - 1 + 12) % 12;  
              $dies = $b-($diaInicio-$diaActual);  
           }  
        }
		else
		{  
            $anios = $anioActual - $anioInicio - 1;  
            if($diaInicio > $diaActual)
			{  
               $meses = $mesActual - $mesInicio -1 +12;  
               $dies = $b - ($diaInicio-$diaActual);  
            }
			else
			{  
               $meses = $mesActual - $mesInicio + 12;  
               $dies = $diaActual - $diaInicio;  
            }  
        }  
 
        $xedad = $anios;
  
    }
	return ($xedad);
}//Fin funcion edad


function meses($fecha_ingre)
{//Inicio funcion meses
    $fechaInicio =$fecha_ingre;  
    $fechaActual = date("d-m-Y");  
    
	$diaActual = substr($fechaActual, 0, 2);  
    $mesActual = substr($fechaActual, 3, 5);  
    $anioActual = substr($fechaActual, 6, 10);  
    
	$diaInicio = substr($fechaInicio, 0, 2);  
    $mesInicio = substr($fechaInicio, 3, 5);  
    $anioInicio = substr($fechaInicio, 6, 10);  
    
	$mes_de_sustraccion = -1;
	$resta_dias_negativa = $diaActual - $diaInicio;
	
	if($resta_dias_negativa >= 0)
	{
	   $mes_de_sustraccion = 0;
	}
	
	$resta_mes_negativa = $mesActual - $mesInicio;
	$meses_reales = 0;
	
	if($resta_mes_negativa >= 0)
	{
	   $meses_reales = $resta_mes_negativa + $mes_de_sustraccion;
	}
	else
	{
	   $meses_reales = $resta_mes_negativa + 12 + $mes_de_sustraccion;
	}
	
	return ($meses_reales);
}//Fin funcion meses


///////////////Inicio edad en base a fecha pibote
function edad2($fecha_ingre,$fecha_pibote)
{
	$fechaInicio =$fecha_ingre;  
$fechaActual = $fecha_pibote;  
  $diaActual = substr($fechaActual, 0, 2);  
$mesActual = substr($fechaActual, 3, 5);  
$anioActual = substr($fechaActual, 6, 10);  
$diaInicio = substr($fechaInicio, 0, 2);  
$mesInicio = substr($fechaInicio, 3, 5);  
$anioInicio = substr($fechaInicio, 6, 10);  
  $b = 0;  
$mes = $mesInicio-1;  
if($mes==2){  
if(($anioActual%4==0 && $anioActual%100!=0) || $anioActual%400==0){  
$b = 29;  
}else{  
$b = 28;  
}  
}  
else if($mes<=7){  
if($mes==0){  
 $b = 31;  
}  
  else if($mes%2==0){  
  $b = 30;  
  }  
  else{  
  $b = 31;  
  }  
  }  
  else if($mes>7){  
  if($mes%2==0){  
  $b = 31;  
  }  
  else{  
  $b = 30;  
  }  
  }  
   if(($anioInicio>$anioActual) || ($anioInicio==$anioActual && $mesInicio>$mesActual) ||   
  ($anioInicio==$anioActual && $mesInicio == $mesActual && $diaInicio>$diaActual)){  
  //echo "La fecha de inicio ha de ser anterior a la fecha Actual";  
  }else{  
  if($mesInicio <= $mesActual){  
  $anios = $anioActual - $anioInicio;  
  if($diaInicio <= $diaActual){  
  $meses = $mesActual - $mesInicio;  
  $dies = $diaActual - $diaInicio;  
  }else{  
  if($mesActual == $mesInicio){  
  $anios = $anios - 1;  
  }  
  $meses = ($mesActual - $mesInicio - 1 + 12) % 12;  
  $dies = $b-($diaInicio-$diaActual);  
  }  
  }else{  
  $anios = $anioActual - $anioInicio - 1;  
  if($diaInicio > $diaActual){  
  $meses = $mesActual - $mesInicio -1 +12;  
  $dies = $b - ($diaInicio-$diaActual);  
  }else{  
  $meses = $mesActual - $mesInicio + 12;  
  $dies = $diaActual - $diaInicio;  
  }  
  }  
 
  $xedad = $anios;
  
  }
	return ($xedad);
}
///////////////Fin edad en base a fecha pibote

//////////// INICIO NUMEROS A LETRAS
function num2letras($num, $fem = false, $dec = false) { 
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
   $entera=intval($num);
   $matuni[2]  = "DOS"; 
   $matuni[3]  = "TRES"; 
   $matuni[4]  = "CUATRO"; 
   $matuni[5]  = "CINCO"; 
   $matuni[6]  = "SEIS"; 
   $matuni[7]  = "SIETE"; 
   $matuni[8]  = "OCHO"; 
   $matuni[9]  = "NUEVE"; 
   $matuni[10] = "DIEZ"; 
   $matuni[11] = "ONCE"; 
   $matuni[12] = "DOCE"; 
   $matuni[13] = "TRECE"; 
   $matuni[14] = "CATORCE"; 
   $matuni[15] = "QUINCE"; 
   $matuni[16] = "DIECISEIS"; 
   $matuni[17] = "DIECISIETE"; 
   $matuni[18] = "DIECIOCHO"; 
   $matuni[19] = "DIECINUEVE"; 
   $matuni[20] = "VEINTE"; 
   $matunisub[2] = "DOS"; 
   $matunisub[3] = "TRES"; 
   $matunisub[4] = "CUATRO"; 
   $matunisub[5] = "QUIN"; 
   $matunisub[6] = "SEIS"; 
   $matunisub[7] = "SETE"; 
   $matunisub[8] = "OCHO"; 
   $matunisub[9] = "NOVE"; 

   $matdec[2] = "VEINT"; 
   $matdec[3] = "TREINTA"; 
   $matdec[4] = "CUARENTA"; 
   $matdec[5] = "CINCUENTA"; 
   $matdec[6] = "SESENTA"; 
   $matdec[7] = "SETENTA"; 
   $matdec[8] = "OCHENTA"; 
   $matdec[9] = "NOVENTA"; 
   $matsub[3]  = 'MILL'; 
   $matsub[5]  = 'BILL'; 
   $matsub[7]  = 'MILL'; 
   $matsub[9]  = 'TRILL'; 
   $matsub[11] = 'MILL'; 
   $matsub[13] = 'BILL'; 
   $matsub[15] = 'MILL'; 
   $matmil[4]  = 'MILLONES'; 
   $matmil[6]  = 'BILLONES'; 
   $matmil[7]  = 'DE BILLONES'; 
   $matmil[8]  = 'MILLONES DE MILLONES'; 
   $matmil[10] = 'TRILLONES'; 
   $matmil[11] = 'DE TRILLONES'; 
   $matmil[12] = 'MILLONES DE TRILLONES'; 
   $matmil[13] = 'DE TRILLONES'; 
   $matmil[14] = 'BILLONES DE TRILLONES'; 
   $matmil[15] = 'DE BILLONES DE TRILLONES'; 
   $matmil[16] = 'MILLONES DE BILLONES DE TRILLONES'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'MENOS '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' COMA'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' CERO'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' UNA' : ' UN'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'CERO ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'UNA'; 
         $subcent = 'AS'; 
      }else{ 
         $matuni[1] = $neutro ? 'UN' : 'UNO'; 
         $subcent = 'OS'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'I' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' Y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' CIENTO' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'IENT' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'CIENT' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' MIL'; 
         }elseif ($num > 1){ 
            $t .= ' MIL'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?N'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ONES'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   if($entera == "100")
     return ("CIEN");
   else
     return ucfirst($tex); 
} 
//////////// FIN NUMEROS A LETRAS
*/

?>
