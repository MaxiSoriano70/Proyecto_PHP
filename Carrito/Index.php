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
    if (empty($_SESSION["iIdUsuario"])){
        include "../Helpers/Loguearse-Registrarse.php";
    }
    else{
    /*RECUPERAMOS EL iIdUsuario PARA OBTENER EL CARRITO*/
    $Usuario=$_SESSION["iIdUsuario"];
    $sql_Total="SELECT fTotal FROM carritoscompras WHERE iIdUsuario=? AND sEstado='Pendiente'";
    $cmd_Total=preparar_select($conexionDB,$sql_Total,[$Usuario]);
    $T=$cmd_Total->fetch_assoc();
    if(empty($T['fTotal'])){
        include "../Helpers/Carrito-Vacio.php";
    }
    else{
    $sql="SELECT iIdCarritoCompra FROM carritoscompras WHERE iIdUsuario=? AND sEstado='Pendiente'";
    $cmd_carrito=preparar_select($conexionDB,$sql,[$Usuario]);
    $rcmd_carrito=$cmd_carrito->fetch_assoc();
    $iIdCarritoCompra=$rcmd_carrito['iIdCarritoCompra'];
    /*RECUPERAMOS IMAGEN Y EL CONTENIDO QUE VA A IR EN LA TABLA DE DETALLE CARRITO*/
    $sql_Detalle="SELECT p.sNombre,dc.iIdProducto,iIdCarritoCompra,iCantidad,iStock,dc.fPrecio,fSubtotal,i.sNombreArchivo FROM det_carrito dc INNER JOIN productos p INNER JOIN Producto_Imagen pi ON p.iIdProducto=pi.iIdProducto INNER JOIN Imagenes i ON pi.iIdImagen=i.iIdImagen WHERE pi.iOrden=1 AND p.bEliminado=0 AND i.bEliminado=0 AND dc.iIdCarritoCompra=? AND dc.iIdProducto=p.iIdProducto";
    $cmd_Detalle=preparar_select($conexionDB,$sql_Detalle,[$iIdCarritoCompra]);
?>
<style><?php include 'css/Carrito.css'; ?></style>
<div class="Carrito">
  <div class="Tabla-Carrito">
    <div class="Titulo-T-C">
        <b>CARRITO DE COMPRAS</b>
    </div>
    <main class="Tabla-Productos">
    <center>
        <table>
            <thead>
                <tr>
                    <th>PRODUCTO</th>
                    <th>NOMBRE</th>
                    <th>PRECIO UNI.</th>
                    <th>CANTIDAD</th>
                    <th>SUBTOTAL</th>
                    <th>ACCIÓN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($cmd_Detalle->num_rows>0) {
                ?>
                <?php
                    $Total=0;
                    foreach ($cmd_Detalle as $titulo) {
                ?>
                <tr>
                <td data-titulo="Producto: ">
                    <img class="IMG-C" src="/Instituto/Compra_En_Salta_Bootstrap/imagenes/Productos/<?php echo $titulo['sNombreArchivo'] ?>">
                </td>
                <td data-titulo="Nombre: "><?php echo $titulo['sNombre'] ?></td>
                <td data-titulo="Precio Unitario: "><?php echo $titulo['fPrecio'] ?>
                <input type="hidden" id="PrecioN<?php echo $titulo['iIdProducto']?>" value="<?php echo $titulo['fPrecio']?>">
                </td>
                <td data-titulo="Cantidad: ">
                <div id="brs" class="input-group mb-3 ml-auto mr-auto" style="max-width: 120px;">
                 <div class="input-group-prepend">
                  <button class="btn btn-warning js-btn-minus" type="button" onblur="Subtotal(<?php echo $titulo['iIdProducto']?>);">&minus;</button>
                 </div>
                 <input type="number" class="form-control text-center" id="CantidadN<?php echo $titulo['iIdProducto']?>" min="1" max="<?php echo $titulo['iStock']?>" name="Cant[]" value="<?php echo $titulo['iCantidad']?>" 
                 onblur="Subtotal(<?php echo $titulo['iIdProducto']?>);">
                 <div class="input-group-append">
                  <button class="btn btn-warning js-btn-plus" type="button" onblur="Subtotal(<?php echo $titulo['iIdProducto']?>);">&plus;</button>
                 </div>
                </div>
                </td>
                <td data-titulo="Subtotal: " id="SubtotalN<?php echo $titulo['iIdProducto']?>">
                <?php 
                echo $titulo['fSubtotal']; 
                $Total=$Total+$titulo['fSubtotal'];
                ?>
                </td>
                <td>
                 <div class="Botones-U">
                    <?php
                        echo '<a class="btn btn-danger" href="Delete.php?iIdCarritoCompra='.$iIdCarritoCompra.'&iIdProducto='.$titulo['iIdProducto'].'"><span class="icon-trash-o"></span> Eliminar</a>';
                    ?>
                 </div>
                </td>
                </tr>
            <?php
                }
            }
            ?>
            </tbody>
        </table>
    </center>
    </main>
    <div class="Cont-V">
        <a class="btn btn-info" href="Vaciar-Carrito.php">Vaciar Carrito</a>
    </div>
  </div>
<?php
$sql_cantidad="SELECT sum(iCantidad) AS Resultado FROM det_carrito WHERE iIdCarritoCompra=?";
$cmd_cantidad=preparar_select($conexionDB,$sql_cantidad,[$iIdCarritoCompra]);
$cantidad=$cmd_cantidad->fetch_assoc();
?>
  <div class="Resumen-de-Compra">  
    <div class="Titulo-R">
        <b>RESUMEN DE TU COMPRA</b>
    </div>
    <div class="Resumen-R">
        <span class="Res-R">Resumen de tu Carrito:</span><b><span id="Cant_Pro">
            <?php
                echo $cantidad['Resultado'];
                if ($cantidad['Resultado']>1) {
            ?>
                </span><span class="Producto-R">Productos</span></b>
            <?php
                }
                else{
            ?>
                </span><span class="Producto-R">Producto</span></b>
            <?php
            } 
            ?>
    </div>
    <div class="Codigo-R">
        CÓDIGO PROMOCIONAL
    </div>
    <div class="Input-R">
        <input class="Input-C" type="number" name="CODIGO" placeholder="Ingresa tu código promocional">
    </div>
    <div class="Boton-Aplicar-R">
        <button class="Aplicar-R" type="submit" type="submit">Aplicar Cupón</button>
    </div>
    <div class="Entreg-R">
        Entrega aún no calculado
    </div>
    <div class="Total-C-R">
        TOTAL DE CARRITO
    </div>
    <div class="Total-P-R">
        <span class="T-P-R">TOTAL PARCIAL:</span> <b>$ <span class="fResultado"><?php echo $Total ?></span></b>
    </div>
    <div class="Total-CA-R">
        <span class="T-CA-R">TOTAL:</span> <b><span class="fResultado"><?php echo $Total ?></span></b>
    </div>
	<div class="Botones">
        <a class="Proceder-Pago" href="/Instituto/Compra_En_Salta/Carrito/Comprar.php">Proceder al Pago</a>   
    </div>
    <div class="Botones">
        <a class="Seguir-Comprando" href="../Index.php"><span class="icon-arrow-left"></span> Seguir Comprando</a>
    </div>
  </div>
</div>
<script><?php include 'js/index.js'; ?></script>
<?php
    }
}
?>
<?php
    include "../Helpers/Footer.php";
?>
<script src="../Styles/js/jquery-ui.js"></script>
<script src="../Styles/js/jquery.magnific-popup.min.js"></script>

<script src="../Styles/js/owl.carousel.min.js"></script>
<script src="../Styles/js/aos.js"></script>
<script src="../Styles/js/main.js"></script>