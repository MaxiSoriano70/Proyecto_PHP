<?php
    include "Helpers/Header.php";
?>
<?php
    include "Helpers/Menu.php";
?>
<?php
    include "Helpers/Info.php";
?>
<?php
    include "Helpers/Slider.php";
?>
<?php
    include "Helpers/Bienvenidos.php";
?>
<?php
    include "Helpers/Buscador.php";
?>
<?php
    include "Helpers/Categorias.php";
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
    }
   }
?>
<style><?php include "Styles/Productos.css"; ?></style>
<main class="Contenedor-Productos">    
    <h1 class="Titulo-Productos">PRODUCTOS</h1>
    <div class="Productos">
    <?php
    if(!empty($_GET["iIdCategoria"])){
        $iIdCategoria=$_GET["iIdCategoria"];
        $sql="SELECT p.*,i.sNombreArchivo,sPath FROM productos p INNER JOIN producto_imagen pi ON p.iIdProducto=pi.iIdProducto INNER JOIN imagenes i ON pi.iIdImagen=i.iIdImagen INNER JOIN producto_categoria pc ON p.iIdProducto=pc.iIdproducto WHERE pc.iIdCategoria=? AND pi.iOrden=1 AND p.bEliminado=0 AND i.bEliminado=0";
        $productos=preparar_select($conexionDB,$sql,[$iIdCategoria]);
    }
    else{
        $sql="SELECT p.*,i.sNombreArchivo,sPath FROM productos p INNER JOIN producto_imagen pi ON p.iIdProducto=pi.iIdProducto INNER JOIN imagenes i ON pi.iIdImagen=i.iIdImagen WHERE pi.iOrden=1 AND p.bEliminado=0 AND i.bEliminado=0";
        $productos=preparar_select($conexionDB,$sql);
    }
    foreach ($productos as $producto){
    ?>
        <div class="Carta-Productos">
            <div class="Imagen">
            <a href="Productos/Detalle-Producto.php?iIdProducto=<?php echo $producto['iIdProducto'];?>">
                <img src="/Instituto/Compra_En_Salta/Imagenes/Productos/<?php echo $producto["sNombreArchivo"];?>">
            </a>
            </div>
                <h4><?php echo $producto["sNombre"];?></h4>
                <p><?php echo $producto["sDescripcion"];?></p>
                <p>$<?php echo $producto["fPrecio"];?></p>
            <form name="Añadir" method="POST" action="Index.php">
            <input type="hidden" name="iIdproductoAñadido" value="<?php echo $producto["iIdProducto"];?>">
                <div id="brs" class="input-group ml-auto mr-auto py-1" style="max-width: 120px;">
                 <div class="input-group-prepend">
                  <button class="btn btn-outline-warning js-btn-minus" type="button">&minus;</button>
                 </div>
                <input class="form-control text-center" type="number" name="iCantidad" min="1" max="<?php echo $producto["iStock"];?>" value="1" placeholder="1" aria-label="Example text with button addon" aria-describedby="button-addon1">
                 <div class="input-group-append">
                  <button class="btn btn-outline-warning js-btn-plus" type="button">&plus;</button>
                 </div>
                </div>
                <div class="C-Carrito">
                    <button class="Añadir-Carrito" type="submit"><span class="icon-cart-plus"></span> Añadir</button>
                </div>
            </form>
        </div>
    <?php
    }
    ?>
    </div>
</main>

<?php
    include "helpers/Footer.php";
?>
<script src="Styles/js/jquery-ui.js"></script>
<script src="Styles/js/jquery.magnific-popup.min.js"></script>

<script src="Styles/js/owl.carousel.min.js"></script>
<script src="Styles/js/aos.js"></script>
<script src="Styles/js/main.js"></script>