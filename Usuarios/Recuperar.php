<?php
	include "..\Helpers\Header.php";
?>
<?php
	if(!empty($_GET['iIdUsuario'])){
		$iIdUsuario=$_GET['iIdUsuario'];
		$sql="UPDATE usuarios SET bEliminado=0 WHERE iIdUsuario=?";
		$cmd=preparar_query($conexionDB,$sql,[$iIdUsuario]);
		if($cmd){
			echo'<script type="text/Javascript">alert("Usuario Recuperado Correctamente")</script>';
        	echo '<script>location.href="/Instituto/Compra_En_Salta/Usuarios/Index.php"</script>';
		}
		else{
			echo "Error: ".$sql." ".$cmd->error;
		}
	}
?>
<?php
	include '..\Helpers\Footer.php';
?>