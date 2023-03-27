<nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation">
  <!-- El logotipo y el icono que despliega el menú se agrupan
       para mostrarlos mejor en los dispositivos móviles -->
<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
      <span class="sr-only">Desplegar navegación</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>

 
    <!-- Agrupar los enlaces de navegación, los formularios y cualquier
       otro elemento que se pueda ocultar al minimizar la barra -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
   
   <!-- menu -->
    <ul id="menu-bar">
     <?PHP
      $indicadorul = 0;
      $indicadorli = 1;
     // $consulta = mysql_query("SELECT * FROM tab_menu",$con);
	 $consulta = mysql_query("SELECT a.opcion_menu, a.url_menu, a.acceso_menu, a.nivel_menu FROM tab_menu as a, tab_detalle_menu as b, t_empresa as c WHERE a.id_menu=b.id_menu and b.id_nivel='".$acceso."' and b.id_empresa='$id_empresa' and c.estado='$estado' GROUP by a.id_menu ",$con);
      while($fila = mysql_fetch_array($consulta)){
          if((($fila['acceso_menu']==0) || ($fila['acceso_menu']==$acceso)) && (!empty($acceso))){
              if(($fila['nivel_menu']==2) && ($indicadorul==0)){  echo "<ul class='dropdown-menu'>"; $indicadorul=1; }
              if(($fila['nivel_menu']==1) && ($indicadorul==1)){  echo "</ul>"; $indicadorul=0; }
              
              if(($fila['nivel_menu']==1) && ($indicadorli == 0)){echo "</li>";$indicadorli=1;}
               
              if($fila['id_menu']==1)//Menu de inicio(index.php) debe de ir sin 'forms/'
                  echo "<li><div align='left'><a  href='../".utf8_encode($fila['url_menu'])."'>".($fila['opcion_menu'])."</div></a></li>";
              else{
                  if($fila['nivel_menu']==2)
                      echo "<li> <a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".($fila['opcion_menu'])."</div></a></li>";
                  else{
                      echo "<li><a href='".utf8_encode($fila['url_menu'])."'><div align='left'>".($fila['opcion_menu'])."</div></a>";
                      $indicadorli = 0;
                  }			  
              }
          }
      }
 
      echo "</li>";
      $cerrarsesion=('Cerrar Sesión');
      ?>
      
     <li><a><?PHP echo $_SESSION['nombre_usuario_silo']; ?></a></li>
      <li><a onClick="salirr()"><button type="button" class="btn btn-danger btn-xs"><?PHP echo $cerrarsesion; ?></button></a></li>
    
</ul>
</div>
    
</nav>