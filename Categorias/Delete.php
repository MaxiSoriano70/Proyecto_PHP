<?php
	include "..\Helpers\Header.php";
?>
<?php
	if(!empty($_GET['iIdCategoria'])){
		$iIdCategoria=$_GET['iIdCategoria'];
		$sql="UPDATE categorias SET bEliminado=1 WHERE iIdCategoria=?";
		$cmd=preparar_query($conexionDB,$sql,[$iIdCategoria]);
		if($cmd){
			echo'<script type="text/Javascript">alert("Categoria Eliminada Correctamente")</script>';
        	echo '<script>location.href="/Instituto/Compra_En_Salta/Categorias/Index.php"</script>';
		}
		else{
			echo "Error: ".$sql." ".$cmd->error;
		}
	}
?>
<?php
	include '..\Helpers\Footer.php';
?>