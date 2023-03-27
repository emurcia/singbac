<script  languaje="javascript" type="text/javascript" >
	 var BOTON = 0;	
    $(document).ready(function() {
    $('.soloNUMEROS').keypress(function(tecla) {
                //alert(tecla.charCode);
                if((tecla.charCode < 48 || tecla.charCode > 57) && tecla.keyCode !=08 && tecla.keyCode !=09 && tecla.keyCode !=127 && tecla.keyCode !=37 && tecla.keyCode !=39 && tecla.charCode !=32 && tecla.charCode !=46) return false;
            });
		
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
$id_agencia_recibe = mysql_real_escape_string($_POST['id_entrada']);
$_SESSION['cod_almacenaje']=$id_agencia_recibe;


$loginSQL=mysql_query("SELECT * FROM tab_indicadoresrecepcion where id_almacenaje='$id_agencia_recibe' AND id_empresa='$id_empresa'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$humedad_ver=$fila_usu['humedad'];
if($fila_usu['humedad_rojo']!=0){$humedad_rojo_value=1;}
if($fila_usu['humedad_verde']!=0){$humedad_verde_value=1;}
$temperatura_ver=$fila_usu['temperatura'];
if($fila_usu['temperatura_rojo']!=0){$temperatura_rojo_value=1;}
if($fila_usu['temperatura_verde']!=0){$temperatura_verde_value=1;}
$grano_bola_ver=$fila_usu['grano_bola'];
if($fila_usu['grano_bola_rojo']!=0){$grano_bola_rojo_value=1;}
if($fila_usu['grano_bola_verde']!=0){$grano_bola_verde_value=1;}
$grano_chico_ver=$fila_usu['grano_chico'];
if($fila_usu['grano_chico_rojo']!=0){$grano_chico_rojo_value=1;}
if($fila_usu['grano_chico_verde']!=0){$grano_chico_verde_value=1;}
$grano_roto_ver=$fila_usu['grano_roto'];
if($fila_usu['grano_roto_rojo']!=0){$grano_roto_rojo_value=1;}
if($fila_usu['grano_roto_verde']!=0){$grano_roto_verde_value=1;}
$impureza_ver=$fila_usu['impureza'];
if($fila_usu['impureza_rojo']!=0){$impureza_rojo_value=1;}
if($fila_usu['impureza_verde']!=0){$impureza_verde_value=1;}
$otras_variedades_ver=$fila_usu['otras_variedades'];
if($fila_usu['otras_variedades_rojo']!=0){$otras_variedades_rojo_value=1;}
if($fila_usu['otras_variedades_verde']!=0){$otras_variedades_verde_value=1;}
$piedras_ver=$fila_usu['piedras'];
if($fila_usu['piedras_rojo']!=0){$piedras_rojo_value=1;}
if($fila_usu['piedras_verde']!=0){$piedras_verde_value=1;}
$infestacion_ver=$fila_usu['infestacion'];
if($fila_usu['infestacion_rojo']!=0){$infestacion_rojo_value=1;}
if($fila_usu['infestacion_verde']!=0){$infestacion_verde_value=1;}
$retencion_malla_ver=$fila_usu['retencion_malla'];
if($fila_usu['retencion_malla_rojo']!=0){$retencion_malla_rojo_value=1;}
if($fila_usu['retencion_malla_verde']!=0){$retencion_malla_verde_value=1;}
$calor_ver=$fila_usu['calor'];
if($fila_usu['calor_rojo']!=0){$calor_rojo_value=1;}
if($fila_usu['calor_verde']!=0){$calor_verde_value=1;}
$insecto_ver=$fila_usu['insecto'];
if($fila_usu['insecto_rojo']!=0){$insecto_rojo_value=1;}
if($fila_usu['insecto_verde']!=0){$insecto_verde_value=1;}
$hongo_ver=$fila_usu['hongo'];
if($fila_usu['hongo_rojo']!=0){$hongo_rojo_value=1;}
if($fila_usu['hongo_verde']!=0){$hongo_verde_value=1;}
$germinacion_ver=$fila_usu['germinacion'];
if($fila_usu['germinacion_rojo']!=0){$germinacion_rojo_value=1;}
if($fila_usu['germinacion_verde']!=0){$germinacion_verde_value=1;}
$peso_100_granos_ver=$fila_usu['peso_100_granos'];
if($fila_usu['peso_100_granos_rojo']!=0){$peso_100_granos_rojo_value=1;}
if($fila_usu['peso_100_granos_verde']!=0){$peso_100_granos_verde_value=1;}
$longitud_20_granos_ver=$fila_usu['longitud_20_granos'];
if($fila_usu['longitud_20_granos_rojo']!=0){$longitud_20_granos_rojo_value=1;}
if($fila_usu['longitud_20_granos_verde']!=0){$longitud_20_granos_verde_value=1;}
$densidad_ver=$fila_usu['densidad'];
if($fila_usu['densidad_rojo']!=0){$densidad_rojo_value=1;}
if($fila_usu['densidad_verde']!=0){$densidad_verde_value=1;}
$aflotoxinas_ver=$fila_usu['aflotoxinas'];
if($fila_usu['aflotoxinas_rojo']!=0){$aflotoxinas_rojo_value=1;}
if($fila_usu['aflotoxinas_verde']!=0){$aflotoxinas_verde_value=1;}
$fumonisinas_ver=$fila_usu['fumonisinas'];
if($fila_usu['fumonisinas_rojo']!=0){$fumonisinas_rojo_value=1;}
if($fila_usu['fumonisinas_verde']!=0){$fumonisinas_verde_value=1;}
$vomitoxinas_ver=$fila_usu['vomitoxinas'];
if($fila_usu['vomitoxinas_rojo']!=0){$vomitoxinas_rojo_value=1;}
if($fila_usu['vomitoxinas_verde']!=0){$vomitoxinas_verde_value=1;}
$stress_crack_ver=$fila_usu['stress_crack'];
if($fila_usu['stress_crack_rojo']!=0){$stress_crack_rojo_value=1;}
if($fila_usu['stress_crack_verde']!=0){$stress_crack_verde_value=1;}
$flotadores_ver=$fila_usu['flotadores'];
if($fila_usu['flotadores_rojo']!=0){$flotadores_rojo_value=1;}
if($fila_usu['flotadores_verde']!=0){$flotadores_verde_value=1;}
$elaborado_por_ver=$fila_usu['nom_analista'];
$observaciones_ver=$fila_usu['observaciones'];
	
?>


 <!--------- INICIA MODAL ACTUALIZAR USUARIOS ------>
     
  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>INGRESAR INDICADORES</strong> <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button></div> <!-- PANEL 1 --->
           <div class="panel-body" >

          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>HUMEDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="humedadg"  name="humedadg"  value="<?PHP echo $humedad_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              
              <?PHP if($humedad_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox"  name="humedad_rojog" value="1" checked> 
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="humedad_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($humedad_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="humedad_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="humedad_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>

              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>TEMPERATURA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="temperaturag"  value="<?PHP echo $temperatura_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
             <?PHP if($temperatura_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="temperatura_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="temperatura_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($temperatura_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="temperatura_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="temperatura_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO BOLA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="grano_bolag"  value="<?PHP echo $grano_bola_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <?PHP if($grano_bola_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_bola_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_bola_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($grano_bola_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_bola_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_bola_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
          
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>GRANO CHICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="grano_chicog"  value="<?PHP echo $grano_chico_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
            <?PHP if($grano_chico_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_chico_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_chico_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($grano_chico_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_chico_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_chico_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANOS ROTOS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="grano_rotog"  value="<?PHP echo $grano_roto_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
                <?PHP if($grano_roto_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_roto_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_roto_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($grano_roto_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_roto_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="grano_roto_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>IMPUREZAS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="impurezag"  value="<?PHP echo $impureza_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
            <?PHP if($impureza_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="impureza_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="impureza_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($impureza_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="impureza_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="impureza_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>OTRAS VARIEDADES</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="otras_variedadesg" value="<?PHP echo $otras_variedades_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <?PHP if($otras_variedades_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="otras_variedades_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="otras_variedades_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($otras_variedades_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="otras_variedades_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="otras_variedades_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PIEDRAS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="piedrasg"  value="<?PHP echo $piedras_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <?PHP if($piedras_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="piedras_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="piedras_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($piedras_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="piedras_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="piedras_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>INFESTACIÓN</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="infestaciong"  value="<?PHP echo $infestacion_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
                <?PHP if($infestacion_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="infestacion_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="infestacion_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($infestacion_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="infestacion_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="infestacion_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>RETENCION MALLA 1/4</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="retencion_mallag"  value="<?PHP echo $retencion_malla_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
               <?PHP if($retencion_malla_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="retencion_malla_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="retencion_malla_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($retencion_malla_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="retencion_malla_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="retencion_malla_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>CALOR</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="calorg" value="<?PHP echo $calor_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
             <?PHP if($calor_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="calor_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="calor_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($calor_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="calor_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="calor_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>INSECTO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="insectog" value="<?PHP echo $insecto_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <?PHP if($insecto_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="insecto_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="insecto_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($insecto_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="insecto_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="insecto_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>HONGO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="hongog" value="<?PHP echo $hongo_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <?PHP if($hongo_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="hongo_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="hongo_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($hongo_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="hongo_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="hongo_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GERMINACIÓN</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="germinaciong" value="<?PHP echo $germinacion_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <?PHP if($germinacion_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="germinacion_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="germinacion_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($germinacion_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="germinacion_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="germinacion_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PESO 100 GRANOS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="peso_100_granosg" value="<?PHP echo $peso_100_granos_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <?PHP if($peso_100_granos_rojo_value=="1"){?>
              <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="peso_100_granos_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="peso_100_granos_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($peso_100_granos_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="peso_100_granos_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="peso_100_granos_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
         
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>LONGITUD 20 GRANOS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="longitud_20_granosg" value="<?PHP echo $longitud_20_granos_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
           <?PHP if($longitud_20_granos_rojo_value=="1"){?>
           <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="longitud_20_granos_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="longitud_20_granos_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($longitud_20_granos_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="longitud_20_granos_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="longitud_20_granos_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>DENSIDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="densidadg"  value="<?PHP echo $densidad_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <?PHP if($densidad_rojo_value=="1"){?>
           <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="densidad_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="densidad_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($densidad_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="densidad_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="densidad_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>AFLOTOXINAS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="aflotoxinasg"  value="<?PHP echo $aflotoxinas_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
                <?PHP if($aflotoxinas_rojo_value=="1"){?>
           <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="aflotoxinas_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="aflotoxinas_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($aflotoxinas_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="aflotoxinas_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="aflotoxinas_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
           <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>FUMONISINAS</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="fumonisinasg"  value="<?PHP echo $fumonisinas_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
               <?PHP if($fumonisinas_rojo_value=="1"){?>
           <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="fumonisinas_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="fumonisinas_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($fumonisinas_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="fumonisinas_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="fumonisinas_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>VOMITOXINAS (DON)</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="vomitoxinasg"  value="<?PHP echo $vomitoxinas_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
              <?PHP if($vomitoxinas_rojo_value=="1"){?>
           <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="vomitoxinas_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="vomitoxinas_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($vomitoxinas_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="vomitoxinas_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="vomitoxinas_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>STRESS CRACK</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="stress_crackg" value="<?PHP echo $stress_crack_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
           <?PHP if($stress_crack_rojo_value=="1"){?>
           <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="stress_crack_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="stress_crack_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($stress_crack_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="stress_crack_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="stress_crack_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
          </div><!--- FIN ROW----->
               <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>FLOTADORES</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" name="flotadoresg"  value="<?PHP echo $flotadores_ver; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" placeholder="%" >
           <?PHP if($flotadores_rojo_value=="1"){?>
           <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="flotadores_rojog" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-danger"><div class="input-group btn-danger"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="flotadores_rojog" value="0" >
    	  </label></div></span>
           <?PHP };?>
          
           <?PHP if($flotadores_verde_value=="1"){?>
              <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="flotadores_verdeg" value="1" checked>
    	  </label></div></span>
		  <?PHP }else {; ?>
          <span class="input-group-addon btn-success"><div class="input-group btn-success"><label class="btn-danger"><input class="btn-danger" type="checkbox" name="flotadores_verdeg" value="0" >
    	  </label></div></span>
           <?PHP };?>
              </div>
          </div>
          </div>
            <div class="col-md-8">
         <div class="form-group">
              <label>ELABORADO POR</label>
              <input type="text" class="form-control input-lg" id="elaboradoporg"  name="elaboradoporg" value="<?PHP echo $elaborado_por_ver; ?>" autocomplete="off" style="text-transform:uppercase;" required>
          </div>
          </div>
          </div><!--- FIN ROW----->
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-12">
         <div class="form-group">
              <label>OBSERVACIONES</label>
              <textarea name="observacionesg" id="observacionesg" class="form-control input-lg" style="text-transform:uppercase;" rows="2" placeholder="OBSERVACIONES" autocomplete="off" ><?PHP echo $observaciones_ver; ?></textarea>
          </div>
          </div>
          </div><!--- FIN ROW----->
          
         <div class="row"><!--- INICIO ROW----->
         <div class="col-md-8">
          <div class="checkbox">
              <label>
                <input type="checkbox" name="activarbotonrecep" value="" onclick="activar_textosrecepcion()"> Autorización
              </label>
            </div>
            </div> 
            <div class="col-md-2"> 
<button type="button" disabled id="btnguardar_actrecepcion"  name="btnguardar_actrecepcion" class="btn btn-primary glyphicon glyphicon-saved center pull-right" data-toggle="modal" data-target="#actualizar" value="Guardar">  Guardar</button>
 </div> 
            <div class="col-md-2"> 
          <button type="button" id="btn_cerrar" name="btn_cerrar" class="btn btn-danger glyphicon glyphicon-remove center pull-right" data-dismiss="modal">  Cerrar</button>               

    		</div>
          
          </div>               
</div>
</div>
</div>
</div>


