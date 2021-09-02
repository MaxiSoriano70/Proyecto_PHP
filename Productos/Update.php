<?php
	include "..\Helpers\Header.php";
?>
<?php
	include "..\Helpers\Menu.php";
?>
<?php
	if(!empty($_GET["iIdProducto"])){//SI COMIENZA DE 1 CAMBIARIA AQUI
		$iIdProductoActual=$_GET['iIdProducto'];
		$sql="SELECT * FROM productos WHERE iIdProducto=?";
		$datos=preparar_select($conexionDB,$sql,[$iIdProductoActual]);
		if($datos->num_rows>0){
			$fila=$datos->fetch_assoc();
		}
		else{
			echo "Error: ".$sql." ".$cmd->error;
		}
	}
	else{
		if(!empty($_POST)){
			$iIdProducto=$_POST['iIdProducto'];
			$sCodigo=$_POST['txtsCodigo'];
			$sNombre=$_POST['txtsNombre'];
			$sDescripcion=$conexionDB->real_escape_string($_POST['sDescripcion']);
			$sDescr=$conexionDB->real_escape_string($_POST['sDescr']);
			$fPrecio=$_POST['txtfPrecio'];
			$iStock=$_POST['txtiStock'];
			$iStockMinimo=$_POST['txtiStockMinimo'];
			$sql="UPDATE productos SET sCodigo=?,sNombre=?,sDescripcion=?,sDescr=?,fPrecio=?,iStock=?,iStockMinimo=?,dFecha=now() WHERE iIdProducto=?";
			$cmd=preparar_query($conexionDB,$sql,[$sCodigo,$sNombre,$sDescripcion,$sDescr,$fPrecio,$iStock,$iStockMinimo,$iIdProducto]);
			if($cmd){
			echo'<script type="text/Javascript">alert("Producto Modificado Correctamente")</script>';
        	echo '<script>location.href="/Instituto/Compra_En_Salta/Productos/Index.php"</script>';
			}
			else{
			echo "Error: ".$sql." ".$cmd->error;
			}
		}
	}
?>
<style><?php include 'css/Modificar-Productos.css'; ?></style>
<main>
    <section class="Modificar-Producto">
        <H2><b>MODIFICAR PRODUCTOS</b></H2>
        <form method="POST" action="Update.php">
        <input type="hidden" name="iIdProducto" value="<?php echo $fila["iIdProducto"]; ?>"/>
        CODIGO <br>
        <input class="Control" type="text" name="txtsCodigo" value="<?php echo $fila["sCodigo"]; ?>"> <br>
        CODIGO <br>
        <input class="Control" type="text" name="txtsNombre" value="<?php echo $fila["sNombre"]; ?>"> <br>
        DESCRIPCION <br>
        <textarea class="Control" type="text" name="sDescripcion"><?php echo $fila["sDescripcion"]; ?></textarea> <br>
        DESCRIPCION DETALLADA<br>
        <textarea class="Control" type="text" name="sDescr"><?php echo $fila["sDescr"]; ?></textarea> <br>
        PRECIO <br>
        <input class="Control" type="number" name="txtfPrecio" value="<?php echo $fila["fPrecio"]; ?>"> <br>
        STOCK <br>
        <input class="Control" type="number" name="txtiStock" min="0" max="1000" value="<?php echo $fila["iStock"]; ?>"> <br>
        STOCK MINIMO<br>
        <input class="Control" type="number" name="txtiStockMinimo" value="<?php echo $fila["iStockMinimo"]; ?>"> <br>
        <input class="Boton1" type="submit" value="Guardar"> <br>
        <a class="Boton2" href="Index.php">Volver a la lista de Productos</a> <br>
        </form>
    </section>
</main>
<?php
	include '..\Helpers\Footer.php';
?>