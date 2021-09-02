<?php
    include "../Helpers/Header.php";
?>
<?php
    include "../Helpers/Menu.php";
?>
<?php
    include "../Helpers/Info.php";
?>
<?php
 if (!empty($_SESSION['iIdUsuario'])){
 $iIdUsuario=$_SESSION['iIdUsuario'];
 $sqlv="SELECT i.sNombreArchivo,p.sNombre, dc.iCantidad,dc.fSubtotal FROM Productos p INNER JOIN imagenes i INNER JOIN producto_imagen pi INNER JOIN det_carrito dc INNER JOIN carritoscompras c ON p.iIdProducto=pi.iIdProducto AND i.iIdImagen=pi.iIdImagen AND p.iIdProducto=dc.iIdProducto AND dc.iIdCarritoCompra=c.iIdCarritoCompra WHERE pi.iOrden=1 AND c.sEstado='Pendiente' AND c.iIdUsuario=?";
 $cmdv=preparar_select($conexionDB,$sqlv,[$iIdUsuario]);

 $sinfo="SELECT sNombre,sApellido,sEmail,iDNI,iContacto,sDomicilio,iCodigoPostal,sCiudad FROM Usuarios WHERE iIdUsuario=?";
 $cinfo=preparar_select($conexionDB,$sinfo,[$iIdUsuario]);
 $rinfo=$cinfo->fetch_assoc();

 if (!empty($_POST)){
  $Usuario=$_POST['iIdUsuario'];
  $sEmail=$_POST['sEmail'];
  $sNombre=$_POST['sNombre'];
  $sApellido=$_POST['sApellido'];
  $iDni=$_POST['iDNI'];
  $iContacto=$_POST['iContacto'];
  $sDireccion=$_POST['sDomicilio'];
  $iCodigo_Postal=$_POST['iCodigo_Postal'];
  $sCiudad=$_POST['sCiudad'];
  $Retiro=$_POST['Retiro-Domicilio'];
  $Forma_Pago=$_POST['Forma_Pago'];
  $Efectivo=$_POST['Efectivo'];
  $Tarjeta=$_POST['Tarjeta'];
  $sTitular=$_POST['sTitular'];
  $iNumero=$_POST['iNumero'];
  $sVencimiento=$_POST['sVencimiento'];
  $sClave=$_POST['sClave'];

  $sqlus="UPDATE Usuarios SET sEmail=?,sNombre=?,sApellido=?,iDNI=?,iContacto=?,sDomicilio=?,iCodigoPostal=?,sCiudad=? WHERE iIdUsuario=?";
  $cmdus=preparar_query($conexionDB,$sqlus,[$sEmail,$sNombre,$sApellido,$iDni,$iContacto,$sDireccion,$iCodigo_Postal,$sCiudad,$Usuario]);

  $sqlc="SELECT iIdCarritoCompra FROM carritoscompras WHERE sEstado='Pendiente' AND iIdUsuario=?";
  $cmdc=preparar_select($conexionDB,$sqlc,[$Usuario]);
  $rc=$cmdc->fetch_assoc();
  $iIdCarritoCompra=$rc['iIdCarritoCompra'];
  if ($Forma_Pago=="1"){
   $sqlfp="INSERT INTO formas_pagos (iIdTipo_Pago) values (?)";
   $cmdfp=preparar_query($conexionDB,$sqlfp,[$Forma_Pago]);
   $iIdForma_Pago=$cmdfp->insert_id;

   $sqlee="UPDATE carritoscompras SET iIdMetodo_Envio=?,iIdForma_Pago=?,sEstado='Pagado' WHERE iIdCarritoCompra=?";
   $cmdee=preparar_query($conexionDB,$sqlee,[$Retiro,$iIdForma_Pago,$iIdCarritoCompra]);

   if ($cmdee){
    echo '<script>location.href="/Instituto/Compra_En_Salta/Index.php"</script>';
   }
  }
  else{
   $iCupon=rand(100760,390123);
   $iAutorizacion=rand(120760,200123);

   $sqlt="INSERT INTO tarjetas (iIdTipo,iCupon,iAutorizacion) VALUES (?,?,?)";
   $cmdt=preparar_query($conexionDB,$sqlt,[$Tarjeta,$iCupon,$iAutorizacion]);
   $iIdTarjeta_Credito=$cmdt->insert_id;

   $sqlfp="INSERT INTO formas_pagos (iIdTipo_Pago,iIdTarjeta) values (?,?)";
   $cmdfp=preparar_query($conexionDB,$sqlfp,[$Forma_Pago,$iIdTarjeta_Credito]);
   $iIdForma_Pago=$cmdfp->insert_id;

   $sqlee="UPDATE carritoscompras SET iIdMetodo_Envio=?,iIdForma_Pago=?,sEstado='Pagado' WHERE iIdCarritoCompra=?";
   $cmdee=preparar_query($conexionDB,$sqlee,[$Retiro,$iIdForma_Pago,$iIdCarritoCompra]);

   if ($cmdee){
    echo '<script>location.href="/Instituto/Compra_En_Salta/Index.php"</script>';
   }
  }
 }
}
 else{
  echo '<script>location.href="/Instituto/Compra_En_Salta/Index.php"</script>';
 }
?>
<style><?php include 'css/Compra.css';?></style>

<div class="Cont-Cards">

 <div class="Cont-Izq">
 <form name="ship" method="POST" action="Comprar.php">
 <input type="hidden" name="iIdUsuario" value="<?php echo $iIdUsuario; ?>">
  <div id="Card-a" class="Card-abc">
   <div class="Header">
    <div class="Header-Izq"><b>1 - Datos Personales</b></div> 
    <a href="" id="ha" class="Header-Der"><span class="icon-pencil"></span></a>
   </div>
   <div class="Inputs-a">
    <div class="form__div">
     <input type="email" id="Email" name="sEmail" class="form__input" placeholder=" " value="<?php echo $rinfo['sEmail']; ?>" required>
     <label for="" class="form__label">Email</label>
    </div>
    <div class="Flexible">
     <div class="form__div-div">
      <input type="text" id="Nombre" name="sNombre" class="form__input-div" placeholder=" " value="<?php echo $rinfo['sNombre']; ?>" required>
      <label for="" class="form__label">Nombre</label>
     </div>
     <div class="form__div-div">
      <input type="text" id="Apellido" name="sApellido" class="form__input-div" placeholder=" " value="<?php echo $rinfo['sApellido']; ?>" required>
      <label for="" class="form__label">Apellido</label>
     </div>
    </div>
    <div class="Flexible">
     <div class="form__div-div">
      <input type="number" id="Dni" name="iDNI" class="form__input-div" placeholder=" " value="<?php echo $rinfo['iDNI']; ?>" required>
      <label for="" class="form__label">DNI</label>
     </div>
     <div class="form__div-div">
      <input type="number" id="Contacto" name="iContacto" class="form__input-div" placeholder=" " value="<?php echo $rinfo['iContacto']; ?>" required>
      <label for="" class="form__label">Contacto</label>
     </div>
    </div>
    <div class="Boton">
     <div class="Boton-Cont b-a">Continuar</div>
    </div>
   </div>

   <div class="Oculto-a">
    <p id="pe" class="p-oculto-a"><b>Email:</b> <span id="sn-a"></span></p>
    <p id="pna" class="p-oculto-a"><b>Nombre y Apellido:</b> <span id="sn-b"></span></</p>
    <p id="pdni" class="p-oculto-a"><b>Dni:</b> <span id="sn-c"></span></</p>
    <p id="pto" class="p-oculto-a"><b>Telefono:</b> <span id="sn-d"></span></</p>
   </div>

  </div>


  <div id="Card-b" class="Card-abc">
   <div class="Header">
    <div class="Header-Izq"><b>2 - Entrega - Retiro</b></div> 
    <a href="" id="hb" class="Header-Der"><span class="icon-pencil"></span></a>
   </div>
   <div class="Inputs-b">
    <div class="form__div">
     <input type="text" name="sDomicilio" id="Direccion" class="form__input" placeholder=" " value="<?php echo $rinfo['sDomicilio']; ?>" required>
     <label for="" class="form__label">Direccion</label>
    </div>
    <div class="Flexible">
     <div class="form__div-div">
      <input type="number" name="iCodigo_Postal" id="Postal" class="form__input-div" placeholder=" " value="<?php echo $rinfo['iCodigoPostal']; ?>" required>
      <label for="" class="form__label">Codigo Postal</label>
     </div>
     <div class="form__div-div">
      <input type="text" id="Ciudad" name="sCiudad" class="form__input-div" placeholder=" " value="<?php echo $rinfo['sCiudad']; ?>" required>
      <label for="" class="form__label">Ciudad</label>
     </div>
    </div>
    <div class="Radio-L-D">
      <input type="radio" name="Retiro-Domicilio" id="Retiro_Local" value="1">
      <label for="Retiro_Local">RETIRO DE LOCAL</label>
      <input type="radio" name="Retiro-Domicilio" id="Entrega_Domicilio" value="2">
      <label for="Entrega_Domicilio">ENTREGA A DOMICILIO</label>
    </div>

    <div class="Boton">
     <div class="Boton-Cont b-b">Continuar</div>
    </div>
   </div>
   <div class="Oculto-b">
    <p class="p-oculto-b"><b>Direccion:</b> <span id="sn-e"></span></</p>
    <p class="p-oculto-b"><b>Ciudad:</b> <span id="sn-f"></span></</p>
    <p class="p-oculto-b"><b>Codigo Postal:</b> <span id="sn-g"></span></</p>
   </div>

   <div class="Vacio-b">
    <p class="p-vacio-b"><b class="text-warning">¡Atencion!</b> No hay Datos Seleccionados</p>
   </div>

  </div>


  <div id="Card-c" class="Card-abc">
   <div class="Header">
    <div class="Header-Izq"><b>3 - Pagos</b></div> 
    <a href="" id="hc" class="Header-Der"><span class="icon-pencil"></span></a>
   </div>
   <div class="Inputs-c">

   <div class="Radio-F-P">
      <input type="radio" name="Forma_Pago" id="Efectivo" value="1">
      <label for="Efectivo">EFECTIVO</label>
      <input type="radio" name="Forma_Pago" id="Tarjeta-Cred" value="2">
      <label for="Tarjeta-Cred">TARJETA DE CREDITO</label>
    </div>

   <div class="Inputs-Efectivo">
    <select name="Efectivo" id="" class="form-control Nombre-Tarjeta">
     <option>Selecione una metodo de pago</option>
     <option value="1">Rapipago</option>
     <option value="2">Pago Facil</option>
     <option value="3">Mercado Pago</option>
     <option value="4">Tranferencia Bancaria</option>
    </select>
   </div>

   <div class="Cont-Abajo">
    <select name="Tarjeta" class="form-control Nombre-Tarjeta">
     <option>Selecione una tarjeta</option>
     <option value="1">Visa</option>
     <option value="2">Mastercard</option>
     <option value="3">Discover</option>
     <option value="4">American Express</option>
    </select> 

    <div class="Flexible">
     <div class="form__div-div">
      <input type="text" name="sTitular" class="form__input-div" placeholder=" ">
      <label for="" class="form__label">Titular de Tarjeta</label>
     </div>
     <div class="form__div-div">
      <input type="number" name="iNumero" class="form__input-div" placeholder=" ">
      <label for="" class="form__label">Numero</label>
     </div>
    </div>
    <div class="Flexible">
     <div class="form__div-div">
      <input type="month" name="sVencimiento" class="form__input-div" placeholder=" ">
      <label for="" class="form__label">Vencimiento</label>
     </div>
     <div class="form__div-div">
      <input type="number" name="sClave" class="form__input-div" placeholder=" ">
      <label for="" class="form__label">Clave</label>
     </div>
    </div>
   </div>

   <div class="Boton">
    <button type="submit" class="Boton-Cont bp">Pagar</button>
   </div>
  </div> 
  <div class="Vacio-c">
  <p class="p-vacio-c"><b class="text-warning">¡Atencion!</b> No hay Datos Seleccionados</p>
  </div>
 </div>
 </form>
 </div>

<div class="Cont-Der">
 <div class="Card-d">
  <div class="Head"><b>Resumen de Compra</b></div>
  <?php $total=0; ?>
  <?php foreach ($cmdv as $Productos) { ?>
  <div class="Mini-Card">
   <div class="Presentacion">
    <img src="/Instituto/Compra_En_Salta/Imagenes/Productos/<?php echo $Productos['sNombreArchivo']?>" alt="" class="img-min">
    <p class="Desc-min"><?php echo $Productos['sNombre']?></p>
   </div>
   <?php $can=$Productos["iCantidad"];?>
   <p class="Unidad-min text-center"><?php echo $Productos['iCantidad']; if ($can>1) {echo ' Unidades';} else {echo ' Unidad';}?></p>
   <p class="Subt-min">$ <?php echo $Productos['fSubtotal']?></p>
   <?php $total=$total+$Productos['fSubtotal']?>
  </div>
  <?php } ?>
  <div class="Subtotal">
   <div class="Sub-Izq">Subtotal</div>
   <div class="Sub-Der">$ <?php echo $total; ?></div>
  </div>
  <div class="Total">
   <div class="Tot-Izq">TOTAL</div>
   <div class="Tot-Der">$ <?php echo $total; ?></div>
  </div>
 </div>
</div>
</div>
<?php
    include "../Helpers/Footer.php";
?>
<script><?php include 'js/Comprar.js'; ?></script>
<script src="../Styles/js/jquery-ui.js"></script>
<script src="../Styles/js/jquery.magnific-popup.min.js"></script>

<script src="../Styles/js/owl.carousel.min.js"></script>
<script src="../Styles/js/aos.js"></script>
<script src="../Styles/js/main.js"></script>