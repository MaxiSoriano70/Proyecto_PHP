$('.Header-Der').click(function(e) {
 e.preventDefault();
});

$(document).ready(function () {

/*OCULTAMOS EL BOTON DE EDITAR*/
 $('#ha').css('visibility','hidden');

/*OCULTAMOS LOS INPUTS DE LA CARD-B EL BOTON EDITAR Y MOSTRAMOS EL MENSAJE*/
 $('.Inputs-b').css('display','none');
 $('.Vacio-b').css('display','block');
 $('#hb').css('visibility','hidden');

/*OCULTAMOS LOS INPUTS DE LA CARD-C EL BOTON EDITAR Y MOSTRAMOS EL MENSAJE*/
 $('.Inputs-c').css('display','none');
 $('.Vacio-c').css('display','block');
 $('#hc').css('visibility','hidden');

/*FUNCTION PRA CAMBIAR DE LA CARD-A LA CARD-B CUANDO HAGAN CLICK EN CONTINUAR*/
 $('.b-a').on('click',function() {
  $('.Inputs-a').css('display','none');
  $('#sn-a').html($('#Email').val());
  $('#sn-b').html($('#Nombre').val()+' '+$('#Apellido').val());
  $('#sn-c').html($('#Dni').val());
  $('#sn-d').html($('#Contacto').val());
  /*MOSTAMOS EL CONTENEDOR DONDE SE VISUALIZAN LOS DATOS DE LOS INPUTS Y MOSTRAMOS EL BOTON EDITAR*/
  $('.Oculto-a').css('display','block');
  $('#ha').css('visibility','visible');
  /*MOSTRAMOS LOS INPUTS-B*/
  $('.Inputs-b').css('display','block');
  $('.Vacio-b').css('display','none');
 });

/*FUNCTION PRA CAMBIAR DE LA CARD-B LA CARD-C CUANDO HAGAN CLICK EN CONTINUAR*/
 $('.b-b').on('click',function() {
  $('.Inputs-b').css('display','none');
  $('#sn-e').html($('#Direccion').val());
  $('#sn-f').html($('#Ciudad').val());
  $('#sn-g').html($('#Postal').val());
  /*MOSTRAMOS EL CONTENEDOR DONDE SE VISUALIZAN LOS DATOS DE LOS INPUTS Y MOSTRAMOS EL BOTON EDITAR*/
  $('.Oculto-b').css('display','block');
  $('#hb').css('visibility','visible');
  /*MOSTRAMOS LOS INPUTS-C, ESCONDEMOS EL SELECT DE EFECTIVO Y TARJETA, ESXONDEMOS EL VACIO C Y EL BOTON DE PAGAR*/
  $('.Inputs-c').css('display','block');
  $('.Cont-Abajo').css('display','none');
  $('.Inputs-Efectivo').css('display','none');
  $('.Vacio-c').css('display','none');
  $('.bp').css('display','none');
 });

/*AL HACER CLICK EN EDITAR-A PARA DESPLECGAR LOS INPUTS*/
 $('#ha').click(function(){
  $('.Inputs-a').css('display','block');
  $('.p-vacio-a').css('display','none');
  $('.Oculto-a').css('display','none');
 });
/*AL HACER CLICK EN EDITAR-B PARA DESPLECGAR LOS INPUTS*/
 $('#hb').click(function(){
  $('.Inputs-b').css('display','block');
  $('.p-vacio-b').css('display','none');
  $('.Oculto-b').css('display','none');
 });
/*AL HACER CLICK EN EDITAR-C PARA DESPLECGAR LOS INPUTS*/
 $('#hc').click(function(){
  $('.Inputs-c').css('display','block');
  $('.p-vacio-c').css('display','none');
  $('.Oculto-c').css('display','none');
 });

 $('#Efectivo').click(function() {
   $('.Cont-Abajo').css('display','none');
   $('.Inputs-Efectivo').css('display','block');
   $('.bp').css('display','block');
 });

 $('#Tarjeta-Cred').click(function() {
   $('.Cont-Abajo').css('display','block');
   $('.Inputs-Efectivo').css('display','none');
   $('.bp').css('display','block');
 });

});