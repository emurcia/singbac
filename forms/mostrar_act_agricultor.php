<script type="text/javascript" src="../assets/javascript/jquery.maskedinput.min.js" ></script>
<script>
 $(document).ready(function(){
            $.mask.definitions['~']='[7260]';
            $(".tel_agencia").mask("~999-9999", {placeholder: "_"});
            
            });
</script>
<?php 
ini_set('session.save_handler', 'files');
/***********esto es para cerrar sesion cuando se cierren todas las ventanas de la web**************/
//si es necesario cambiar la config. del php.ini desde tu script
ini_set("session.use_only_cookies","1");
ini_set("session.use_trans_sid","0");

@session_start();
include ("../conexion/conexion.php");
include ("../conexion/conexion.inc");

 $id_empresa=$_SESSION['id_empresa_silo']; // = id_empresa a la que pertenece 
$id_agencia_recibe = mysql_real_escape_string($_POST['id_agricultor_busca']);
$loginSQL=mysql_query("SELECT * FROM tab_agricultor where dui_agricultor='$id_agencia_recibe' AND id_empresa='$id_empresa'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$dui_mostrar=$fila_usu['dui_agricultor'];
$nom_mostrar=$fila_usu['nom_agricultor'];
$ape_mostrar=$fila_usu['ape_agricultor'];
$nucleo_mostrar=$fila_usu['nucleo_familiar'];
if($fila_usu['spmaiz']!=0){$spmaiz_motrar=1;}
if($fila_usu['spfrijol']!=0){$spfrijol_motrar=1;}
if($fila_usu['spsorgo']!=0){$spsorgo_motrar=1;}
if($fila_usu['spcafe']!=0){$spcafe_motrar=1;}
if($fila_usu['ssmaiz']!=0){$ssmaiz_motrar=1;}
if($fila_usu['ssfrijol']!=0){$ssfrijol_motrar=1;}
if($fila_usu['sssorgo']!=0){$sssorgo_motrar=1;}
if($fila_usu['sscafe']!=0){$sscafe_motrar=1;}
$area_mostrar=$fila_usu['area_cultiva'];
$propiedad_mostrar=$fila_usu['propiedad'];
if($fila_usu['invierno']!=0){$invierno_motrar=1;}
if($fila_usu['postrera']!=0){$postrera_motrar=1;}
if($fila_usu['apante']!=0){$apante_motrar=1;}
$depto_mostrar=$fila_usu['nom_depto'];
if ($depto_mostrar==''){$depto_mostrar='SAN VICENTE';}
$muni_mostrar=$fila_usu['nom_municipio'];
if ($muni_mostrar==''){$muni_mostrar='SAN CAYETANO ISTEPEQUE';}
$zona_mostrar=$fila_usu['zona'];
$tel_mostrar=$fila_usu['tel_agricultor'];
$dir_mostrar=$fila_usu['direccion'];
	
?>


 <!--------- INICIA MODAL ACTUALIZAR USUARIOS ------>
     
  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>ACTUALIZAR DATOS</strong> <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button></div> <!-- PANEL 1 --->
           <div class="panel-body" >
           
           <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>NOMBRE:</label>
               <input type="text" class="form-control input-lg soloLetras" style="text-transform:uppercase" name="nom_agricultoract" value="<? echo $nom_mostrar; ?>" autocomplete="off" required/>           
                  </div>
              </div>
            
              <div class="col-md-6">
              <div class="form-group">
               <label>APELLIDO:</label>
               <input type="text" class="form-control input-lg soloLetras" name="ape_agricultoract" value="<? echo $ape_mostrar; ?>" style="text-transform:uppercase" autocomplete="off" required/>    
                  </div>
              </div>
           </div><!--- FIN ROW----->
           
           
            <div class="row"><!--- INICIO ROW----->
            <div class="col-md-6">
              <div class="form-group">
               <label>DUI:</label>
               <input type="text" class="form-control input-lg DUI" style="text-transform:uppercase" name="dui_agricultoract" value="<? echo $dui_mostrar; ?>" autocomplete="off" readonly="readonly" required/>           
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label>NUCLEO FAMILIAR:</label>
               <input type="text" class="form-control input-lg soloNumeros" style="text-transform:uppercase" name="nucleo_familiaract" value="<? echo $nucleo_mostrar; ?>"  autocomplete="off" required/>           
                  </div>
              </div>
              </div><!--- FIN ROW----->
           
              <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>SIEMBRA PRINCIPAL:</label>
                <?PHP if($spmaiz_motrar=="1"){?>
              <span class="input-group-addon"><div class="input-group"><label><input type="checkbox"  name="spmaizact" value="1" checked> Maíz
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="spmaizact" value="0" > Maíz
    	  </label></div></span>
           <?PHP };?>
           
            <?PHP if($spfrijol_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="spfrijolact" value="1" checked> Frijol
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="spfrijolact" value="0" > Frijol
    	  </label></div></span>
           <?PHP };?>
           
           <?PHP if($spsorgo_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="spsorgoact" value="1" checked> Frijol
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="spsorgoact" value="0" > Sorgo
    	  </label></div></span>
           <?PHP };?>
           
            <?PHP if($spcafe_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="spcafeact" value="1" checked> Frijol
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="spcafeact" value="0" > Café
    	  </label></div></span>
           <?PHP };?>
         
          </div>
              </div>
           </div><!--- FIN ROW----->
             <div class="row"><!--- INICIO ROW----->
              <div class="col-md-12">
              <div class="form-group">
               <label>SIEMBRA SECUNDARIA:</label>
                <?PHP if($ssmaiz_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="ssmaizact" value="1" checked> Maíz
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="ssmaizact" value="0" > Maíz
    	  </label></div></span>
           <?PHP };?>
           
            <?PHP if($spfrijol_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="ssfrijolact" value="1" checked> Frijol
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="ssfrijolact" value="0" > Frijol
    	  </label></div></span>
           <?PHP };?>
           
           <?PHP if($spsorgo_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="sssorgoact" value="1" checked> Frijol
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="sssorgoact" value="0" > Sorgo
    	  </label></div></span>
           <?PHP };?>
           
            <?PHP if($spcafe_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="sscafeact" value="1" checked> Frijol
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="sscafeact" value="0" > Café
    	  </label></div></span>
           <?PHP };?> 
                  </div>
              </div>
           </div><!--- FIN ROW----->
           
           
                  <div class="row"><!--- INICIO ROW----->
                  <div class="col-md-6">
              <div class="form-group">
               <label>AREA QUE CULTIVA:</label>
               <input type="text" class="form-control input-lg soloNumeros" name="area_cultivaact" value="<? echo $area_mostrar; ?>"   autocomplete="off" required/>    
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label>TENENCIA DE PROPIEDAD:</label>
                <select name="propiedadact" class="form-control input-lg chosen"  size="1">
                            <option value="<? echo $propiedad_mostrar; ?>"><? echo $propiedad_mostrar; ?></option>
                            <option value="PROPIA">PROPIA</option>
                            <option value="ALQUILADA">ALQUILADA</option>
                            <option value="PRESTADA">PRESTADA</option>
                           							 
                    </select>          
                  </div>
              </div>
           </div><!--- FIN ROW----->
               <div class="row"><!--- INICIO ROW----->
              <div class="col-md-7">
              <div class="form-group">
               <label>EPOCA DE SIEMBRA:</label>
                <?PHP if($invierno_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="inviernoact" value="1" checked> Invierno
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="inviernoact" value="0" > Invierno
    	  </label></div></span>
           <?PHP };?>
           
            <?PHP if($postrera_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="postreraact" value="1" checked> Postrera
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="postreraact" value="0" > Postrera
    	  </label></div></span>
           <?PHP };?>
           
           <?PHP if($apante_motrar=="1"){?>
              <span class="input-group-addon "><div class="input-group"><label><input type="checkbox"  name="apanteact" value="1" checked> Apante
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon"><div class="input-group"><label><input type="checkbox" name="apanteact" value="0" > Apante
    	  </label></div></span>
           <?PHP };?>
                
                        
                  </div>
              </div>
           
              <div class="col-md-5">
              <div class="form-group">
               <label>DEPARTAMENTO:</label>
               <input type="text" class="form-control input-lg soloLetras" style="text-transform:uppercase" name="nom_deptoact" value="<? echo $depto_mostrar; ?>" autocomplete="off" />           
                  </div>
              </div>
             
              </div><!--- FIN ROW----->
              
            <div class="row"><!--- INICIO ROW----->
              <div class="col-md-6">
              <div class="form-group">
               <label>MUNICIPIO:</label>
               <input type="text" class="form-control input-lg soloLetras" name="nom_muniact" value="<? echo $muni_mostrar; ?>" style="text-transform:uppercase" autocomplete="off"/>    
                  </div>
              </div>
           
              <div class="col-md-6">
              <div class="form-group">
               <label for="cliente"> ZONA</label>
                      <select name="zonaact" class="form-control input-lg chosen" size="1" id="zonaact">
                            <option value="<? echo $zona_mostrar; ?>"><? echo $zona_mostrar; ?></option>
                            <option value="EL BALSAMO">EL BALSAMO</option>
                            <option value="CANDELARIA ARRIBA">CANDELARIA ARRIBA</option>
                            <option value="CANDELARIA ABAJO">CANDELARIA ABAJO</option>
                            <option value="BARRIO SAN CAYETANO">BARRIO SAN CAYETANO</option>
                            <option value="BARRIO ISTEPEQUE">BARRIO ISTEPEQUE</option>
                            <option value="LA ENTREVISTA">LA ENTREVISTA</option>
                            <option value="LOS MANGOS">LOS MANGOS</option>
                            <option value="CERRO GRANDE">CERRO GRANDE</option>
                            <option value="DESVIO">DESVIO</option>
                            <option value="VUELTA EL GLOBO">VUELTA EL GLOBO</option>
                            <option value="SANTA ELENA">SANTA ELENA</option>
                            <option value="LAS ISLETAS">LAS ISLETAS</option>
                            <option value="SAN VICENTE">SAN VICENTE</option>
                            <option value="TEPETITAN">TEPETITAN</option> 
                            <option value="GUADALUPE">GUADALUPE</option>                                                       
							 
                    </select>
                              
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
               <label>TELEFONO:</label>
               <input type="text" class="form-control input-lg tel_agencia" id="tel_agricultoract"  name="tel_agricultoract" value="<? echo $tel_mostrar; ?>" autocomplete="off" />    
                  </div>
              </div>
          
              <div class="col-md-6">
              <div class="form-group">
               <label>DIRECCION:</label>
                 <textarea name="direccionact" class="form-control input-lg" rows="2" autocomplete="off" id="direccionact" style="text-transform:uppercase;"><? echo $dir_mostrar; ?></textarea>  
                  </div>
              </div>
           </div><!--- FIN ROW----->
                          
          <div class="checkbox">
              <label>
                <input type="checkbox" value="" onclick="activar_textos()"> Autorización
              </label>
          </div>
                
          <button type="button" disabled id="btnguardar_act"  name="btnguardar_act" onclick="guardar_act()" class="btn btn-primary glyphicon glyphicon-saved center pull-right" value="Guardar">  Guardar</button>
</div>
</div>
</div>
</div>