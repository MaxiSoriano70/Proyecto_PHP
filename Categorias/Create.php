<?php
    include "..\Helpers\Header.php";
?>
<?php
    include "..\Helpers\Menu.php";
?>
<?php
$msj="";
if(!empty($_POST)){
    $nombre=$_POST["NOMBRE"];
    $descripcion=$_POST["DESCRIPCION"];
    //CONSULTA
    $sqlprepare="INSERT INTO categorias (sNombre,sDescripcion) VALUES (?,?)";
    $cmd=preparar_query($conexionDB,$sqlprepare,[$nombre,$descripcion]);
    if($cmd){
        echo'<script type="text/Javascript">alert("Categoria Agregada Correctamente")</script>';
        echo '<script>location.href="/Instituto/Compra_En_Salta/Categorias/Index.php"</script>';
    }
    else{
        $msj="Error". $sql ." ". $cmd->error;
    }
}
?>
<style><?php include 'css/Agregar-Categorias.css'; ?></style>
<main>
    <section class="Agregar-Categoria">
        <H2><b>AGREGAR CATEGORIAS</b></H2>
        <form method="POST" action="Create.php">
        NOMBRE <br>
        <input class="Control" type="text" name="NOMBRE" required> <br>
        DESCRIPCION <br>
        <textarea class="Control" type="text" name="DESCRIPCION" required></textarea> <br>
        <input class="Boton1" type="submit" value="Guardar"> <br>
        <input class="Boton2" type="reset" value="Cancelar"> <br>
        <a class="Boton3" href="Index.php">Volver a la lista de Categorias</a> <br>
        </form>
    </section>
</main>
<?php
    include '..\Helpers\Footer.php';
?>