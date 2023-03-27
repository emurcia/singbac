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
$_SESSION['cod_entrada']=$id_agencia_recibe;
$loginSQL=mysql_query("SELECT * FROM tab_almacenaje where entrada='$id_agencia_recibe' AND id_empresa='$id_empresa'",$con);
$fila_usu = mysql_fetch_array($loginSQL, MYSQL_ASSOC);
$peso_vol=$fila_usu['peso_vol'];
$humedad=$fila_usu['humedad'];
$temperatura=$fila_usu['temperatura'];
$grano_entero=$fila_usu['grano_entero'];
$grano_quebrado=$fila_usu['grano_quebrado'];
$dan_hongo=$fila_usu['dan_hongo'];
$impureza=$fila_usu['impureza'];
$grano_chico=$fila_usu['grano_chico'];
$grano_picado=$fila_usu['grano_picado'];
$plaga_viva=$fila_usu['plaga_viva'];
$plaga_muerta=$fila_usu['plaga_muerta'];
$stress_crack=$fila_usu['stress_crack'];
$olor=$fila_usu['olor'];
$vapor=$fila_usu['vapor'];
	
?>


 <!--------- INICIA MODAL ACTUALIZAR USUARIOS ------>
     
  <div class="container-fluid">
  <div class="row" >
  
  <div class="col-md-13">
        <div class="panel panel-primary">
           <div class="panel-heading"><strong>ACTUALIZAR INDICADORES</strong> <button type="button" class='close' data-dismiss="modal" aria-hidden="true">&times;</button></div> <!-- PANEL 1 --->
           <div class="panel-body" >

          <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>PESO VOLUMETRICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="peso_volg"  name="peso_volg"  value="<?PHP echo $peso_vol; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">KG</span>
                  </div>
      		</div>
          </div>
         
            <div class="col-md-4">
         <div class="form-group">
              <label>HUMEDAD</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="humedadg"  name="humedadg" value="<?PHP echo $humedad;?>" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>TEMPERATURA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="temperaturag"  name="temperaturag" value="<?PHP echo $temperatura; ?>" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">°</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
 
       <br>
            <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>GRANO ENTERO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_enterog"  name="grano_enterog" value="<?PHP echo $grano_entero;?>" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5" >
              <span class="input-group-addon">%</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO QUEBRADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_quebradog"  name="grano_quebradog"  value="<?PHP echo $grano_quebrado;?>" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>DAÑO POR HONGO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="dan_hongog"  name="dan_hongog" value="<?PHP echo $dan_hongo;?>" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
                <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>IMPUREZA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="impurezag"  name="impurezag"  value="<?PHP echo $impureza;?>" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>GRANO CHICO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_chicog"  name="grano_chicog"  value="<?PHP echo $grano_chico;?>" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4" >
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>GRANO PICADO</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="grano_picadog"  name="grano_picadog"  value="<?PHP echo $grano_picado;?>" autocomplete="off" onkeypress="mascara(this, '#.##')" maxlength="4">
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <br>
                 <div class="row"><!--- INICIO ROW----->
          <div class="col-md-4">
         <div class="form-group">
              <label>PLAGA VIVA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_vivag"  name="plaga_vivag"  value="<?PHP echo $plaga_viva;?>" autocomplete="off">
              <span class="input-group-addon">UNIDADES</span>
                  </div>
      		</div>
          </div>
            <div class="col-md-4">
         <div class="form-group">
              <label>PLAGA MUERTA</label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="plaga_muertag"  name="plaga_muertag"  value="<?PHP echo $plaga_muerta;?>" autocomplete="off" >
              <span class="input-group-addon">UNIDADES</span>
                  </div>
                  </div>
          </div>
            <div class="col-md-4">
          <div class="form-group">
              <label>STRESS CRACK </label>
              <div class="input-group">
              <input type="text" class="form-control input-lg soloNUMEROS" id="stress_crackg"  name="stress_crackg"  value="<?PHP echo $stress_crack;?>" autocomplete="off" onkeypress="mascara(this, '##.##')" maxlength="5">
              <span class="input-group-addon">%</span>
                  </div>
                  </div>
          </div>
          </div><!--- FIN ROW----->
          <div class="row"><!--- INICIO ROW----->
         <div class="col-md-4">
         <div class="form-group">
              <label>OLOR</label>
              <input type="text" class="form-control input-lg" id="olorg"  name="olorg"  value="<?PHP echo $olor;?>" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         <div class="col-md-4">
         <div class="form-group">
              <label>VAPOR</label>
              <input type="text" class="form-control input-lg" id="vaporg"  name="vaporg" value="<?PHP echo $vapor;?>" autocomplete="off" style="text-transform:uppercase;" >
              
         </div>
      	 </div>
         </div>  
          <div class="checkbox">
              <label>
                <input type="checkbox" value="" onclick="activar_textos()"> Autorización
              </label>
          </div>
                
          <button type="button" disabled id="btnguardar_act"  name="btnguardar_act" class="btn btn-primary glyphicon glyphicon-saved center pull-right" data-toggle="modal" data-target="#actualizar" value="Guardar">  Guardar</button>
</div>
</div>
</div>
</div>


