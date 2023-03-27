function letras(e,elemento){
tecla=(document.all) ? e.keyCode :e.which;
if(tecla==8)return true;
patron=/[A-Za-z\s]/;
t=string.fromCharCode(tecla);
return patron.test(t);
}
