<?php
	include "..\Helpers\Header.php";
?>
<?php
    include "..\Helpers\Menu.php";
?>
<?php
$msj="";
if(isset($_POST["USUARIO"]))
{
	$usuario=$_POST["USUARIO"];
	$contraseña=$_POST["CONTRASEÑA"];
	$nombre=$_POST["NOMBRE"];
	$apellido=$_POST["APELLIDO"];
	$email=$_POST["EMAIL"];
	$dni=$_POST["DNI"];
    $contacto=$_POST["CONTACTO"];
	//CONSULTA
	$sqlprepare="INSERT INTO usuarios(sLogin,sClave,sNombre,sApellido,sEmail,iDNI,iContacto) VALUES (?,?,?,?,?,?,?)";
	$cmd=preparar_query($conexionDB,$sqlprepare,[$usuario,$contraseña,$nombre,$apellido,$email,$dni,$contacto]);
	if($cmd){
        echo'<script type="text/Javascript">alert("Usuario Agregado Correctamente")</script>';
        echo '<script>location.href="/Instituto/Compra_En_Salta/Usuarios/Index.php"</script>';
	}
	else{
		$msj="Error". $sql ." ". $cmd->error;
	}
}
?>
<style><?php include 'css/Agregar-Usuarios.css'; ?></style>
<main>
    <section class="Agregar-Usuario">
        <H2><b>AGREGAR USUARIO</b></H2>
        <form method="POST" action="Create.php">
        LOGIN <br>
        <input class="Control" type="text" name="USUARIO" required> <br>
        CLAVE <br>
        <input class="Control" type="text" name="CONTRASEÑA" required> <br>
        NOMBRE <br>
        <input class="Control" type="text" name="NOMBRE" required> <br>
        APELLIDO <br>
        <input class="Control" type="text" name="APELLIDO" required> <br>
        EMAIL <br>
        <input class="Control" type="text" name="EMAIL" required> <br>
        DNI<br>
        <input class="Control" type="number" name="DNI" required> <br>
        CONTACTO<br>
        <input class="Control" type="number" name="CONTACTO" required> <br>
        <input class="Boton1" type="submit" value="Agregar Usuario"> <br>
        <input class="Boton2" type="reset" value="Cancelar"> <br>
        <a class="Boton3" href="Index.php">Volver a la lista de Usuarios</a> <br>
        </form>
    </section>
</main>
<?php
	include '..\Helpers\Footer.php';
?>