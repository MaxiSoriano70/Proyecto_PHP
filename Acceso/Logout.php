<?php
	include "..\Lib\CONEXION.php";
?>
<?php
    include "..\Lib\FUNCIONES.php";
?>
<?php
session_start();
$iIdUsuario=$_SESSION["iIdUsuario"];
$sql="UPDATE usuarios SET dUltimaFechaLogin=now() WHERE iIdUsuario=?";
$cmd=preparar_query($conexionDB,$sql,[$iIdUsuario]);
session_destroy();
header("location:/Instituto/Compra_En_Salta/Index.php");
?>
<?php
/*session_start();
session_destroy();
header("location:/Instituto/Compra_En_Salta/Index.php");*/
?>