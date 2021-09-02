<?php
    require_once "../lib/CONEXION.php";
    require "../lib/FUNCIONES.php";
    session_start();
?>
<?php
    if ($_POST['Action']=='Cambiar') {
        /*Recuperamos el iIdProducto*/
        $iIdProducto=$_POST['Producto_id'];
        /*Recuperamos la Cantidad*/
        $iCantidad=$_POST['Cantidad'];
        /*Recuperamos la Subtotal*/
        $fSubtotal=$_POST['Subtotal'];
        /*Recuperamos el carrrito del usuario*/
        $Usuario=$_SESSION["iIdUsuario"];
        $sql="SELECT iIdCarritoCompra FROM carritoscompras cc WHERE cc.sEstado='Pendiente' AND cc.iIdUsuario=?";
        $cmd_carrito=preparar_select($conexionDB,$sql,[$Usuario]);
        $rcmd_carrito=$cmd_carrito->fetch_assoc();
        $iIdCarritoCompra=$rcmd_carrito['iIdCarritoCompra'];
        /*Actualizamos el det_carrito*/
        $sqlUpdate="UPDATE det_carrito SET iCantidad=?,fSubtotal=? WHERE iIdProducto=?";
        $cmd_Update=preparar_query($conexionDB,$sqlUpdate,[$iCantidad,$fSubtotal,$iIdProducto]);
        /*Calculamos el total de det_carrito*/
        $sqlTotal="SELECT SUM(fSubtotal) AS Total,sum(iCantidad) AS Resultado FROM det_carrito WHERE iIdCarritoCompra=?";
        $cmd_Total=preparar_select($conexionDB,$sqlTotal,[$iIdCarritoCompra]);
        $Total=$cmd_Total->fetch_assoc();
        /*Uctualizamos el total del carrito de compras*/
        $sqlTotal="UPDATE carritoscompras SET fTotal=? WHERE iIdCarritoCompra=?";
        $cmd_Total=preparar_query($conexionDB,$sqlTotal,[$Total['Total'],$iIdCarritoCompra]);
        /*Enviamos*/
        echo json_encode($Total);
        /*Calculamos la cantidad de productos del carrito*/
    }
?>