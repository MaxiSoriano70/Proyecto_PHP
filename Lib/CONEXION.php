<?php
//Creamos una Conexion
	require_once("CONFIGURACION.php");
	$conexionDB=new mysqli(HOST,USER,PASSWORD,DATABASE);
	if ($conexionDB->connect_error)
	{
		die("Ocurrio un error al intentar conectar a MySQL.");
	}
?>