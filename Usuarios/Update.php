<?php
    include "..\Helpers\Header.php";
?>
<?php
    include "..\Helpers\Menu.php";
?>
<?php
    if($_GET["iIdUsuario"]!=""){//SI COMIENZA 1 CAMBIARIA QUI
        $iIdUsuarioActual=$_GET['iIdUsuario'];
        $sql="SELECT * FROM usuarios WHERE iIdUsuario=?";
        $datos=preparar_select($conexionDB,$sql,[$iIdUsuarioActual]);
        if($datos->num_rows>0){
            $fila=$datos->fetch_assoc();
        }
        else{
            echo "Error: ".$sql." ".$cmd->error;
        }
    }
    else{
        if(!empty($_POST)){
            $iIdUsuario=$_POST['iIdUsuario'];
            $sLogin=$_POST['txtsLogin'];
            $sClave=$_POST['txtsClave'];
            $sNombre=$_POST['txtsNombre'];
            $sApellido=$_POST['txtsApellido'];
            $sEmail=$_POST['txtsEmail'];
            $iDNI=$_POST['txtiDNI'];
            $iContacto=$_POST['txtiCONTACTO'];
            $sql="UPDATE usuarios SET sLogin=?,sClave=?,sNombre=?,sApellido=?,sEmail=?,iDNI=?,iContacto=?,dUltimaFechaLogin=now() WHERE iIdUsuario=?";
            $cmd=preparar_query($conexionDB,$sql,[$sLogin,$sClave,$sNombre,$sApellido,$sEmail,$iDNI,$iContacto,$iIdUsuario]);
            if($cmd){
            echo'<script type="text/Javascript">alert("Usuario Modificado Correctamente")</script>';
            echo '<script>location.href="/Instituto/Compra_En_Salta/Usuarios/Index.php"</script>';
            }
            else{
            echo "Error: ".$sql." ".$cmd->error;
            }
        }
    }
?>
<style><?php include 'css/Modificar-Usuarios.css'; ?></style>
<main>
    <section class="Modificar-Usuario">
        <H2><b>MODIFICAR USUARIO</b></H2>
        <form method="POST" action="Update.php">
        <input type="hidden" name="iIdUsuario" value="<?php echo $fila["iIdUsuario"]; ?>"/>
        LOGIN <br>
        <input class="Control" type="text" name="txtsLogin" value="<?php echo $fila["sLogin"]; ?>"> <br>
        CLAVE <br>
        <input class="Control" type="text" name="txtsClave" value="<?php echo $fila["sClave"]; ?>"> <br>
        NOMBRE <br>
        <input class="Control" type="text" name="txtsNombre" value="<?php echo $fila["sNombre"]; ?>"> <br>
        APELLIDO <br>
        <input class="Control" type="text" name="txtsApellido" value="<?php echo $fila["sApellido"]; ?>"> <br>
        EMAIL <br>
        <input class="Control" type="text" name="txtsEmail" value="<?php echo $fila["sEmail"]; ?>"> <br>
        DNI<br>
        <input class="Control" type="number" name="txtiDNI" value="<?php echo $fila["iDNI"]; ?>"> <br>
        CONTACTO<br>
        <input class="Control" type="number" name="txtiCONTACTO" value="<?php echo $fila["iContacto"]; ?>"> <br>
        <input class="Boton1" type="submit" value="Guardar"> <br>
        <a class="Boton2" href="index.php">Volver a la lista de Usuarios</a> <br>
        </form>
    </section>
</main>
<?php
    include '..\Helpers\Footer.php';
?>