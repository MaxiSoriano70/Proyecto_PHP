function Subtotal(Idproducto){
	var precio=document.getElementById('PrecioN'+Idproducto).value;
	var aux=document.getElementById('CantidadN'+Idproducto).value;
  /*Restringimos que si ingresa un numero menor o igual a 0 pone automaticamnete 1*/
  if (aux<=0){
    var cantidad=document.getElementById('CantidadN'+Idproducto).value=1;
  }
  var cantidad=document.getElementById('CantidadN'+Idproducto).value;
	var calculo=(precio*cantidad);
	document.getElementById('SubtotalN'+Idproducto).innerHTML=calculo;

	$.ajax({
    url: 'Update.php',
    data: 'Action=Cambiar&Producto_id='+Idproducto+'&Cantidad='+cantidad+'&Subtotal='+calculo,
    type: 'post',
    dataType: 'json',
    success: function(data) {
       console.log(data);
       var Total=data.Total;
       var Productos=data.Resultado;
       $('.fResultado').html(Total);
       $('#Cant_Pro').html(Productos);
       if (Productos>1){
        $('.Producto-R').html("Productos");
       }
       else{
        $('.Producto-R').html("Producto");
       }
    }
  });
}