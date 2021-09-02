<?php
    include "../Helpers/Header.php";
?>
<?php
    include "../Helpers/Menu.php";
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
        echo'<script type="text/Javascript">alert("Te has Registrado Correctamente")</script>';
        echo '<script>location.href="/Instituto/Compra_En_Salta/Acceso/Login.php"</script>';
    }
    else{
        $msj="Error". $sql ." ". $cmd->error;
    }
}
?>
<style><?php include 'css/Insert.css'; ?></style>
<div class="contenedor-insertar">
    <div class="insertar">
        <div class="header-section-insert">
            <span class="icon-user-plus"></span>
            <h2><b>Registrarte</b></h2>
        </div>
        <form name="inscripcion" method="POST" action="Registro.php">
            <div class="form-group-insert">
                <input class="form-control-insert" type="text" name="USUARIO" required>
                <label class="f-control" for="">Usuario</label><br>
            </div>
            <div class="form-group-insert">
                <input class="form-control-insert" type="text" name="CONTRASEÑA" required>
                <label class="f-control" for="">Contraseña</label><br>
            </div>
            <div class="form-group-insert">
                <input class="form-control-insert" type="text" name="NOMBRE" required>
                <label class="f-control" for="">Nombre</label><br>
            </div>
            <div class="form-group-insert">
                <input class="form-control-insert" type="text" name="APELLIDO" required>
                <label class="f-control" for="">Apellido</label><br>
            </div>
            <div class="form-group-insert">
                <input class="form-control-insert" type="text" name="EMAIL" required>
                <label class="f-control" for="">Email</label><br>
            </div>
            <div class="form-group-insert">
                <input class="form-control-insert" type="number" name="DNI" required>
                <label class="f-control" for="">Dni</label><br>
            </div>
            <div class="form-group-insert">
                <input class="form-control-insert" type="number" name="CONTACTO" required>
                <label class="f-control" for="">Contacto</label><br>
            </div>
            <div class="mensaje-insert">
            </div>
            <div class="btn-group">
                <input class="Cargar" type="submit" value="Registrarse">
                <input class="Cancelar" type="reset" value="Cancelar">
            </div>
        </form>
    </div>
</div>
<?php
    include "../Helpers/Footer.php";
?>