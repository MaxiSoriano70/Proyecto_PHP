<?php
	include "..\Helpers\Header.php";
?>
<?php
	if(!empty($_GET['iIdProducto'])){
		$iIdProducto=$_GET['iIdProducto'];
		$sql="UPDATE productos SET bEliminado=1 WHERE iIdProducto=?";
		$cmd=preparar_query($conexionDB,$sql,[$iIdProducto]);
		if($cmd){
			echo'<script type="text/Javascript">alert("Producto Eliminada Correctamente")</script>';
        	echo '<script>location.href="/Instituto/Compra_En_Salta/Productos/Index.php"</script>';
		}
		else{
			echo "Error: ".$sql." ".$cmd->error;
		}
	}
?>
<?php
	include '..\Helpers\Footer.php';
?>