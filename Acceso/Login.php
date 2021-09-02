<?php
    include "../Helpers/Header.php";
?>
<?php
    include "../Helpers/Menu.php";
?>
<?php
$msj="";
if(isset($_POST["USUARIO"]))/*DUDA PORQUE HACE CON SESSION*/
{
    $usuario=$_POST["USUARIO"];
    $contraseña=$_POST["CONTRASEÑA"];
    //CONSULTA
    $sql="SELECT * FROM usuarios WHERE sLogin=?";
    $datos=preparar_select($conexionDB,$sql,[$usuario]);
    if($datos->num_rows>0)
    {
        $fila=$datos->fetch_assoc();
        if($contraseña==$fila["sClave"])
        {
            $_SESSION["iIdUsuario"]=$fila["iIdUsuario"];
            $_SESSION["sLogin"]=$fila["sLogin"];
            $_SESSION["isAdmin"]=1;
            $_SESSION["sNombre"]=$fila["sNombre"];
            $_SESSION["sApellido"]=$fila["sApellido"];
            echo '<script>location.href="/Instituto/Compra_En_Salta/Index.php"</script>';
        }
        else
        {
            $msj="*Contraseña Incorrecta.</br>";
        }
    }
    else
    {
        $msj="*Usuario Incorrecto.</br>";
    }
}
?>
<style><?php include 'css/Login.css'; ?></style>
<div class="Logo">
    <img class="escudo" src="/Instituto/Compra_En_Salta_Pagina/Imagenes/roma_naranja.png">
</div>
<div class="Titulo">
    <h1>INICIO DE SESIÓN DE CLIENTE</h1>
</div>
<div class="Card">
    <div class="Card-Contenedor">
        <div class="Login-Contenedor">
            <div class="login">
                <div class="header-section">
                    <span class="icon-user"></span>
                </div>
                <div class="texto">
                    <h2>¿ESTÁS REGISTRADO EN ASROMASTORE.COM?</h2>
                    <p><b>Ingrese a continuación su correo electrónico y contraseña.</b></p>
                </div>
                <div class="contenedor-form">
                <form method="POST" action="Login.php">
                    <div class="form-group">
                        <input class="form-control" type="text" name="USUARIO" required>
                        <label class="f-control" for="">Usuario</label>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="CONTRASEÑA" required>
                        <label class="f-control" for="">Contraseña</label>
                    </div>
                    <div class="remember-group">
                        <input type="checkbox" name="boton_recordar" />
                        <label for="boton_recordar" class="remember-me">Recordar Usuario</label>
                    </div>
                    <div class="btn-group">
                        <input class="btn-login" type="submit" value="Ingresar">
                        <a href="#" class="forgot-password">¿Se te olvidó tu contraseña?</a>
                        <div class="clear"></div>
                    </div>
                </form>
                </div>
                <div class="mensaje-login">
                <?php
                    //Mensaje de Error
                    if(!empty($msj)){
                    echo "<b>".$msj."</b>";
                    }
                ?>
                </div>
                <div class="nota">
                    <p><b>NOTA: Si estaba registrado en la tienda AS Roma anterior, su registro sigue siendo válido, pero para acceder correctamente a su cuenta es necesario editar su contraseña.</b></p><br>
                    <p><b>En el primer intento de inicio de sesión, recibirá un correo electrónico con una nueva contraseña para usar.</b></p>
                </div>
            </div>
        </div>
        <div class="Registrarse">
            <div class="header-Registro">
                <span class="icon-user-plus"></span>
            </div>
            <div class="texto-Registro">
                <h2><b>REGISTRARSE</b></h2>
                <p><b>Cree una cuenta en asromastore.com, podrá realizar el proceso de pago más rápido, almacenar varias direcciones de envío, ver y rastrear sus pedidos en su cuenta y más.</b></p>
            </div>
            <div class="nota-Registro">
                <p><b>NOTA: Registrese para recibir un cupón de descuento del 10% para su primer pedido.</b></p><br>
                <p><b>Además también recibirás un boletin informativo con nuevos productos, descuentos, etc.</b></p>
            </div>
            <div class="Boton-Registro">
                <a class="btn-Registro" href="Registro.php">Registrarse</a>
            </div>
        </div>
    </div>
</div>
<?php
    include "../Helpers/Footer.php";
?>