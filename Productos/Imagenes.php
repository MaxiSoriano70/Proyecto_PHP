<?php
	include "..\Helpers\Header.php";
?>
<?php
    include "..\Helpers\Menu.php";
?>
<?php
if(!empty($_GET["iIdProducto"])){
    $iIdProducto=$_GET["iIdProducto"];
}
else{
    if(!empty($_POST)){
        $sNombreArchivo=$_FILES["fileimage"]["name"];
        $sTipoExtension=$_FILES["fileimage"]["type"];
        $iIdProducto=$_POST["iIdProducto"];
        $iOrden=$_POST["txtsiOrden"];
        //MOVER EL ARCHIVO DE LUGAR TEMPORAL AL DESTINO,SISTEMA
        $sPath=$_SERVER["DOCUMENT_ROOT"]."/Instituto/Compra_En_Salta/Imagenes/Productos";
        //MOVERLO
        move_uploaded_file($_FILES["fileimage"]["tmp_name"],$sPath.'/'.$sNombreArchivo);
        $sql="INSERT INTO imagenes(sNombreArchivo,sTipoExtension,sPath) VALUES (?,?,?)";
        $cmd=preparar_query($conexionDB,$sql,[$sNombreArchivo,$sTipoExtension,$sPath]);
        if($cmd){
            $iIdImagen=$cmd->insert_id;
            $sql_img="INSERT INTO producto_imagen(iIdProducto,iIdImagen,iOrden) VALUES (?,?,?)";
            $cmd_img=preparar_query($conexionDB,$sql_img,[$iIdProducto,$iIdImagen,$iOrden]);
            if ($cmd_img){
                echo'<script type="text/Javascript">alert("Imagen Cargada Correctamente")</script>';
                header("location: /Instituto/Compra_En_Salta/Imagenes/Productos/Imagenes.php?iIdProducto=$iIdProducto");
            }
        }
    }
}
$sql="SELECT pi.*,i.sNombreArchivo FROM producto_imagen pi INNER JOIN imagenes i ON pi.iIdImagen=i.iIdImagen WHERE i.bEliminado=0 AND iIdProducto=?";
$imagenes=preparar_select($conexionDB,$sql,[$iIdProducto]);
?>
<style><?php include 'css/Agregar-Imagenes-Producto.css'; ?></style>
<main>
    <section class="Agregar-Imagen-Producto">
        <H2><b>AGREGAR IMAGEN A PRODUCTO</b></H2>
        <form method="POST" action="Imagenes.php" enctype="multipart/form-data">
        <input type="hidden" name="iIdProducto" value="<?php echo $iIdProducto; ?>"/>
        IMAGEN<br>
        <input class="Selecionar-Imagen" type="file" name="fileimage" id="fileimage"><br>
        ORDEN<br>
        <input class="Control" type="number" name="txtsiOrden" id="txtiOrden" min="1"><br>
        <input class="Boton1" type="submit" value="Agregar imagen al producto"> <br>
        <input class="Boton2" type="reset" value="Cancelar"> <br>
        <a class="Boton3" href="Index.php">Volver a la lista de Productos</a> <br>
        </form>
    </section>
</main>
<main class="Tabla-Imagenes">
    <center>
        <table>
            <thead>
                <tr>
                    <th>IMAGEN</th>
                    <th>NOMBRE</th>
                    <th>ORDEN</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if ($imagenes->num_rows>0){
                foreach ($imagenes as $imagen){
        echo'<tr>
            <td data-titulo="IMAGEN:"> <img class="IMG-T" src="/Instituto/Compra_En_Salta/Imagenes/Productos/'.$imagen["sNombreArchivo"].'"></td>
            <td data-titulo="NOMBRE:">'.$imagen["sNombreArchivo"].'</td>
            <td data-titulo="ORDEN:">'.$imagen["iOrden"].'</td>
            <td>
                <div>';
                if ($imagen["bEliminado"]==0){
                    echo '<a class="btn btn-danger" href="../Producto_Imagen/Delete.php?iIdProducto_Imagen='.$imagen["iIdProducto_Imagen"].'&iIdImagen='.$imagen["iIdImagen"].'&iIdProducto='.$imagen["iIdProducto"].'"><span class="icon-trash-o"></span> Eliminar</a>';
                }
                else{
                    echo '<a class="btn btn-secondary" href="../Producto_Imagen/Recuperar.php?iIdProducto_Imagen='.$imagen["iIdProducto_Imagen"].'&iIdImagen='.$imagen["iIdImagen"].'&iIdProducto='.$imagen["iIdProducto"].'"><span class="icon-check-circle-o"></span> Recuperar</a>';
                }
                echo'
                </div>
            </td>
        </tr>';
                }
            }
            ?>
            </tbody>
        </table>
    </center>
</main>
<?php
	include '..\Helpers\Footer.php';
?>