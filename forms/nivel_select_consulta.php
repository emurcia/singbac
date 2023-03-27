<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<script src="http://code.jquery.com/jquery.js"></script> 
<script src="../js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../assets/stylesheet/caja_buscar.css">
<link href="../assets/stylesheet/demo_table.css" rel="stylesheet" type="text/css" /> 
<script language="javascript" type="text/javascript" src="../assets/javascript/jquery-1.4.4.min.js"></script>
<script type="text/javascript" language="javascript" src="../assets/javascript/jquery.dataTables.js"></script>  
<script type="text/javascript" src="../assets/javascript/jquery.uploadify.js"></script>
<link rel="stylesheet" type="text/css" href="../menu/styles.css">
<link href="../images/favicon.ico" rel="icon">
<script>
	 var BOTON = 0;	
    $(document).ready(function() {
    	$('#tblInstituciones').dataTable( {
    		"sPaginationType": "full_numbers",
			
	 });


    
});
</script>
<?php 
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");


  $id_nivel = mysql_real_escape_string($_POST['id_nivel_busca']);
  if(($id_nivel !="" and $id_nivel!="0"))//entra cuando ocurre el change de municipio
  {
     $sql = "SELECT a.* FROM tab_menu as a, tab_detalle_menu as b WHERE b.id_menu!=1 and b.id_menu!=50 and b.id_menu!=51 and b.id_nivel='".$id_nivel."' and a.id_menu IN(SELECT b.id_menu FROM tab_detalle_menu as b WHERE  b.id_nivel='".$id_nivel."' and b.id_menu!=1 and b.id_menu!=50 and b.id_menu!=51) GROUP BY a.id_menu";
$result = mysql_query($sql, $con);
   echo"<div id='feedback2' class='responsive' ><table width='auto' align='center' cellpadding='5' cellspacing='0' class='display' id='tblInstituciones' >";

	echo"<thead>                     
          <tr>            
            <th width='8%'><div align='center'>ACCIONES</div></th>

            <th width='auto'><div align='left'><a href='#' title='Ordenar por Codigo'>CODIGO</a></div></th>
            <th width='auto'><div align='left'><a href='#' title='Odenar por Opciones'>OPCIONES DEL MENU</a></div></th>
            <th width='auto'><div align='left'><a href='#' title='Odenar por Nivel'>NIVEL DEL MENU</a></div></th>            		
           									
        </tr>
        </thead>
        <tbody>";

		if ($result> 0){	
		    $correlativo = 1;
			$contar2++;
		while ($row = mysql_fetch_array($result)) 
		{
			 $opcion=utf8_encode($row["opcion_menu"]);
		
		if($row['nivel_menu']=="1"){
			$nivel_menu="OPCION PRINCIPAL";
			}else {
			$nivel_menu="OPCION SECUNDARIA";
				}
											
		echo"<tr>
		<td width='4%' align='center'><a data-toggle='modal' data-target='#ventana4' onClick='eliminar(\"".$row['id_menu']."\");' style='cursor:pointer' title='Eliminar registro'><img src='../images/trash-icon.png' width='28px' height='28px'></a></td>
   
         
          <td width='auto' align='left'> $row[id_menu]</td>
		  <td width='auto' align='left'> $opcion </td>
  		  <td width='auto' align='left'> $nivel_menu </td>		  
		  
		</tr>";
		$contar++;
		
		
		
		
		
		}
		$correlativo++;		

		echo"</tbody>
	</table>
	";

}



	?>
    <!--Fin si se ha seleccionado administrador-->

<?php
//echo $correlativo;

echo "Total de Registros" ." ".$contar;
 
  }
?>

