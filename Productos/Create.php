<?php
	include "..\Helpers\Header.php";
?>
<?php
    include "..\Helpers\Menu.php";
?>
<?php
$msj="";
if(!empty($_POST)){
	$codigo=$_POST["CODIGO"];
	$nombre=$_POST["NOMBRE"];
	$descripcion=$_POST["DESCRIPCION"];
	$precio=$_POST["PRECIO"];
	$stock=$_POST["STOCK"];
	$stockminimo=$_POST["STOCKMINIMO"];
    $Categoria=$_POST["CATEGORIA"];
	//CONSULTA
	$sqlprepare="INSERT INTO productos(sCodigo,sNombre,sDescripcion,fPrecio,iStock,iStockMinimo) VALUES (?,?,?,?,?,?)";
	$cmd=preparar_query($conexionDB,$sqlprepare,[$codigo,$nombre,$descripcion,$precio,$stock,$stockminimo]);
    $iIdProducto=$cmd->insert_id;
    $sqlcategoria="INSERT INTO producto_categoria (iIdProducto,iIdCategoria) VALUES (?,?)";
    $cmdcategoria=preparar_query($conexionDB,$sqlcategoria,[$iIdProducto,$Categoria]);
	if($cmdcategoria){
        echo'<script type="text/Javascript">alert("Producto Agregada Correctamente")</script>';
        echo '<script>location.href="/Instituto/Compra_En_Salta/Productos/Index.php"</script>';
	}
	else{
		$msj="Error". $sqlcategoria ." ". $cmdcategoria->error;
	}
}
?>
<style><?php include 'css/Agregar-Productos.css'; ?></style>
<main>
    <section class="Agregar-Producto">
        <H2><b>AGREGAR PRODUCTOS</b></H2>
        <form method="POST" action="Create.php">
        CODIGO <br>
        <input class="Control" type="text" name="CODIGO" required> <br>
        NOMBRE <br>
        <input class="Control" type="text" name="NOMBRE" required> <br>
        DESCRIPCION <br>
        <textarea class="Control" type="text" name="DESCRIPCION" required></textarea> <br>
        PRECIO <br>
        <input class="Control" type="number" name="PRECIO" required> <br>
        STOCK <br>
        <input class="Control" type="number" name="STOCK" min="0" max="1000" required> <br>
        STOCK MINIMO<br>
        <input class="Control" type="number" name="STOCKMINIMO" required> <br>
        CATEGORIA
        <select class="Control" name="CATEGORIA" required>
            <option value="1">Kits de Partido</option>
            <option value="2">Formación</option>
            <option value="3">Ropa de Ocio</option>
            <option value="4">Accesorios</option>
            <option value="5">Ideas de Regalo</option>
        </select>
        <input class="Boton1" type="submit" value="Guardar"> <br>
        <input class="Boton2" type="reset" value="Cancelar"> <br>
        <a class="Boton3" href="Index.php">Volver a la lista de Productos</a> <br>
        </form>
    </section>
</main>
<?php
	include '..\Helpers\Footer.php';
?>