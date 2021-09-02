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
    if(!empty($_GET["iIdProducto"])){
        $iIdProducto=$_GET["iIdProducto"];

      $sql="SELECT i.sNombreArchivo,i.sPath FROM Producto_Imagen pi LEFT JOIN Imagenes i ON pi.iIdImagen=i.iIdImagen WHERE i.bEliminado=0 AND iIdProducto=?";
      $vim=preparar_select($conexionDB,$sql,[$iIdProducto]);
    }
?>
<?php
    if(!empty($_POST["iIdproductoAñadido"])){
     if (empty($_SESSION["iIdUsuario"])){
        echo '<script>location.href="/Instituto/Compra_En_Salta/Helpers/L-R-Carrito.php"</script>';
     }
     else{
      $Usuario=$_SESSION["iIdUsuario"];
      $iIdproductoAñadido=$_POST["iIdproductoAñadido"];
      $iCantidad=$_POST["iCantidad"];
      /*TRAEMOS EL PRECIO DEL PRODUCTO*/
      $sqlPrecio="SELECT fPrecio FROM Productos WHERE iIdProducto=?";
      $cmdPrecio=preparar_select($conexionDB,$sqlPrecio,[$iIdproductoAñadido]);
      $Precio_P=$cmdPrecio->fetch_assoc();/*Recupera un Valor*/
      $Precio_Producto=$Precio_P["fPrecio"];
      /*COMPARAMOS SI EL CARRITO ESTA PENDIENTE O NO*/
      $sql="SELECT count(*) as Total FROM carritoscompras cc WHERE cc.sEstado='Pendiente' AND iIdUsuario=?";
      $cmd=preparar_select($conexionDB,$sql,[$Usuario]);
      $x=$cmd->fetch_assoc();/*Recupera una fila nada mas*/
      $Pachorrita=$x["Total"];
      /*SI NO ESTA PENDIENTE LO PASAMOS A PENDIENTE*/
      if ($Pachorrita==0){
        $sqlcreate="INSERT INTO carritoscompras (iIdUsuario,sEstado) VALUES (?,'Pendiente')";
        $cmdcreate=preparar_query($conexionDB,$sqlcreate,[$Usuario]);
      }
      /*RECUPERAMOS EL ID DE CARRITO*/
      $sqlIdCarrito="SELECT iIdCarritoCompra FROM carritoscompras cc WHERE cc.sEstado='Pendiente' AND cc.iIdUsuario=?";
      $cmdIdCarrito=preparar_select($conexionDB,$sqlIdCarrito,[$Usuario]);
      $y=$cmdIdCarrito->fetch_assoc();
      $iIdCarritoCompra=$y["iIdCarritoCompra"];
      /*RECUPERAMOS EL DET_CARRITO*/
      $sqlComparar="SELECT iIdProducto,iCantidad,fSubtotal FROM det_carrito WHERE iIdCarritoCompra=?";
      $cmdComparar=preparar_select($conexionDB,$sqlComparar,[$iIdCarritoCompra]);
      /*COMPARAMOS SI EL PRODUCTO YA ESTA EN EL CARRITO*/
      $Pachorra=0;
      foreach ($cmdComparar as $Compara){
        /*SI ESTA LO ACTUALIZAMOS*/
        if($Compara["iIdProducto"]==$iIdproductoAñadido){
        $sqlUpdate="UPDATE det_carrito SET iCantidad=?,fSubtotal=? WHERE iIdProducto=?";
        $suma=($iCantidad+$Compara["iCantidad"]);
        $subtotal=($suma*$Precio_Producto);
        $cmdUpdate=preparar_query($conexionDB,$sqlUpdate,[$suma,$subtotal,$iIdproductoAñadido]);
        $Pachorra++;
        }
      }
      /*SI NO ESTA LO INSERTAMOS*/
      if ($Pachorra==0) {
        $sqlInsert="INSERT det_carrito (iIdProducto,iIdCarritoCompra,iCantidad,fPrecio,fSubtotal) VALUES (?,?,?,?,?)";
        $Sub=($iCantidad*$Precio_Producto);
        $cmdInsert=preparar_query($conexionDB,$sqlInsert,[$iIdproductoAñadido,$iIdCarritoCompra,$iCantidad,$Precio_Producto,$Sub]);
      }
      /*SUMAMOS EL DETALLE DE CARRITO*/
      $sqlTotal="SELECT SUM(fSubtotal) AS Total FROM det_carrito WHERE iIdCarritoCompra=?";
      $cmdTotal=preparar_select($conexionDB,$sqlTotal,[$iIdCarritoCompra]);
      $Total=$cmdTotal->fetch_assoc();/*Esto se utiliza cuando devuelve un valor*/
      /*ACTUALIZAMOS EL TOTAL DEL CARRITO*/
      $sqlTot="UPDATE carritoscompras SET fTotal=? WHERE iIdCarritoCompra=?";
      $ctot=preparar_query($conexionDB,$sqlTot,[$Total['Total'],$iIdCarritoCompra]);
       if($ctot){
        echo'<script type="text/Javascript">alert("Producto Agregado al Carrito Correctamente")</script>';
       }
       else{
        $msj="Error". $sqlTot ." ". $ctot->error;
       }
      }
    }
?>
<style><?php include 'css/Detalle-Producto.css'; ?></style>
<div class="detalle-producto">
<div class="contenedor-slider">
  <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
    <?php 
      $contador = 0; 
      foreach ($vim as $img) {
    ?>
      <div class="carousel-item <?php echo $contador == 0 ? "active" : "";?>">
        <img src="../Imagenes/Productos/<?php echo $img['sNombreArchivo']?>" class="d-block w-100">
      </div>
    <?php 
    $contador++; 
    } 
    $contador; 
    ?>
    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: #89072b; color: #f3b30b;"></span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: #89072b; color: #f3b30b;"></span>
    </a>
    </div>
  </div>
</div>
  <div class="descripcion">
    <?php
    $sql="SELECT * FROM productos WHERE iIdProducto=?";
    $Productos=preparar_select($conexionDB,$sql,[$iIdProducto]);
    foreach ($Productos as $Producto){
    ?>  
    <div class="Titulo-D">
        <b><?php echo $Producto["sDescripcion"];?></b>
    </div>
    <div class="Codigo-D">
        <b class="Cod-D">Codigo:</b><?php echo $Producto["sCodigo"];?>
    </div>
    <div class="Descr-D">
        <?php echo $Producto["sDescr"];?>
    </div>
    <div class="Precio-D">
        <b><span class="Pre-D">Precio</span> $ <?php echo $Producto["fPrecio"];?></b>
    </div>
    <div class="Tarjeta-D">
        <span class="icon-credit-card"></span> Paga en hasta 12 cuotas
    </div>
    <div class="Tarjetas-D">
        <span class="icon-visa"></span>
        <span class="icon-mastercard"></span>
    </div>
	<form name="Añadir" method="POST" action="Detalle-Producto.php?iIdProducto=<?php echo $Producto["iIdProducto"];?>">
    <input type="hidden" name="iIdproductoAñadido" value="<?php echo $Producto["iIdProducto"];?>">
    <div class="Cantidad-D">
        <div class="Cant-Text">
            <span class="C-Text"><b>Cantidad </b></span>
            <div id="brs" class="input-group py-1" style="max-width: 120px;">
             <div class="input-group-prepend">
                <button class="btn btn-dark js-btn-minus" type="button">&minus;</button>
             </div>
            <input type="number" min="1" max="<?php echo $producto["iStock"];?>" value="1" name="iCantidad" class="form-control text-center" value="1" min="1" placeholder="1" aria-label="Example text with button addon" aria-describedby="button-addon1">
             <div class="input-group-append">
                <button class="btn btn-dark js-btn-plus" type="button">&plus;</button>
             </div>
            </div>
        </div>
        <div class="Stock-D">
            <span class="Stock-Text"><b>Stock:</b></span><?php echo $Producto["iStock"];?>
        </div>
    </div>
	<div class="Botones">
        <button class="Añadir-Carrito" type="submit"><span class="icon-cart-plus"></span> Añadir</button>   
    </div>
    <div class="Botones">
        <a class="Ir-Carrito" href="/Instituto/Compra_En_Salta/Carrito/Index.php">Ir al Carrito <span class="icon-shopping-cart"></span></a>   
    </div>
    <div class="Botones">
        <a class="Seguir-Comprando" href="../Index.php"><span class="icon-arrow-left"></span> Seguir Comprando</a>
    </div>
	</form>
    <?php
    }
    ?>
  </div>
</div>
<?php
    include "../Helpers/Footer.php";
?>
<script src="../Styles/js/jquery-ui.js"></script>
<script src="../Styles/js/jquery.magnific-popup.min.js"></script>

<script src="../Styles/js/owl.carousel.min.js"></script>
<script src="../Styles/js/aos.js"></script>
<script src="../Styles/js/main.js"></script>