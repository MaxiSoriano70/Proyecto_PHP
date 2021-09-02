<?php
	include "..\Helpers\Header.php";
?>
<?php
    include "..\Helpers\Menu.php";
?>
<?php
    if(!empty($_GET["iIdCategoria"])){
        $iIdCategoria=$_GET["iIdCategoria"];
    }
    else{
        if(!empty($_POST)){
            $iIdCategoria=$_POST["iIdCategoria"];
            $sqldelete='DELETE FROM producto_categoria WHERE iIdCategoria=?';
            $delete=preparar_query($conexionDB,$sqldelete,[$iIdCategoria]);
            $sqlprepare='INSERT INTO producto_categoria(iIdCategoria,iIdProducto) VALUES (?,?)';
            foreach($_POST['ids'] as $iid){
                $cmd=preparar_query($conexionDB,$sqlprepare,[$iIdCategoria,$iid]);
            }
        }
    }
    $sql="SELECT iIdProducto,sCodigo,sNombre,sDescripcion,fPrecio FROM Productos";
    $productos= preparar_select($conexionDB,$sql);
    $campos=$productos->fetch_fields();
?>
<style><?php include 'css/T-Productos-Categorias.css'; ?></style>
<div class="Titulo-Tabla-Productos-Categorias">
    <h2><b>Listado de Productos</b></h2>
</div>
<form method="POST" action="Productos.php">
<input type="hidden" name="iIdCategoria" value="<?php echo $iIdCategoria;?>">
<main class="Tabla-Categorias-Producto">
    <center>
        <table>
            <thead>
                <tr>
                <th class="text-center">Selección</th>
                <?php 
                foreach($campos as $campo){
                    echo '<th class="text-center">'.substr($campo->name,1).'</th>';
                }
                ?>
                </tr>
            </thead>
            <tbody>
            <?php
            foreach($productos as $fila){
            echo '<tr>';
            $aux=$fila["iIdProducto"];
            $sql1 = "SELECT count(*) as cantidad FROM producto_categoria pc where pc.iIdCategoria=? and pc.iIdProducto=?";
            $productosXCat=preparar_select($conexionDB,$sql1,[$iIdCategoria,$aux]);
            $catxproductos=$productosXCat->fetch_assoc();
            if ($catxproductos["cantidad"] == 0){
                echo '<td data-titulo="Selección: "><input class="Marcar-Producto" type="checkbox" name="ids[]" value="'.$fila['iIdProducto'].'"></td>';
            }
            else{
                echo '<td data-titulo="Selección: "><input class="Marcar-Producto" type="checkbox" name="ids[]" value="'.$fila['iIdProducto'].'" checked></td>';
            }
            foreach ($campos as $campo){
                echo '<td data-titulo="'.substr($campo->name,1).'">'.$fila[$campo->name].'</td>';
            }
            echo '</tr>';
            }
            ?>
            </tbody>
        </table>
    </center>
</main>
<div class="Botones-Categorias-Productos">
    <div class="Boton-C-T">
        <input class="btn btn-success mx-1" type="submit" value="Guardar">
    </div>
    <div class="Boton-C-T">
        <input class="btn btn-warning mx-1" type="reset" value="Cancelar">
    </div>
    <div class="Boton-C-T">
        <a class="btn btn-info mx-1" href="index.php">Volver a la Lista de Categorias</a>
    </div>
</div>
</form>
<?php
    include '..\Helpers\Footer.php';
?>