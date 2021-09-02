<?php
	include "..\Helpers\Header.php";
?>
<?php
	if(!empty($_GET['iIdProducto_Imagen'])){
		$iIdProducto_Imagen=$_GET['iIdProducto_Imagen'];
		$iIdImagen=$_GET['iIdImagen'];
		$iIdProducto=$_GET['iIdProducto'];
		$sql="UPDATE producto_imagen SET bEliminado=1 WHERE iIdProducto_Imagen=?";
		$cmd=preparar_query($conexionDB,$sql,[$iIdProducto_Imagen]);
		if($cmd){
			$sql="DELETE FROM imagenes WHERE iIdImagen=?";
			$cmd=preparar_query($conexionDB,$sql,[$iIdImagen]);
			echo'<script type="text/Javascript">alert("Imagen Eliminada Correctamente")</script>';
			header("location: ../Productos/Imagenes.php?iIdProducto=$iIdProducto");
		}
		else{
			echo "Error: ".$sql." ".$cmd->error;
		}
	}
?>
<?php
	include '..\Helpers\Footer.php';
?>