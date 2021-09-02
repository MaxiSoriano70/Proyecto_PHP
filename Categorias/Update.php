<?php
    include "..\Helpers\Header.php";
?>
<?php
    include "..\Helpers\Menu.php";
?>
<?php
    if(!empty($_GET["iIdCategoria"])){
        $iIdCategoriaActual=$_GET['iIdCategoria'];
        $sql="SELECT * FROM categorias WHERE iIdCategoria=?";
        $datos=preparar_select($conexionDB,$sql,[$iIdCategoriaActual]);
        if($datos->num_rows>0){
            $fila=$datos->fetch_assoc();
        }
        else{
            echo "Error: ".$sql." ".$cmd->error;
        }
    }
    else{
        if(!empty($_POST)){
            $iIdCategoria=$_POST['iIdCategoria'];
            $sNombre=$_POST['txtsNombre'];
            $sDescripcion=$conexionDB->real_escape_string($_POST['sDescripcion']);
            $sql="UPDATE categorias SET sNombre=?,sDescripcion=?,dFechaAlta=now() WHERE iIdCategoria=?";
            $cmd=preparar_query($conexionDB,$sql,[$sNombre,$sDescripcion,$iIdCategoria]);
            if($cmd){
            echo'<script type="text/Javascript">alert("Categoria Modificada Correctamente")</script>';
            echo '<script>location.href="/Instituto/Compra_En_Salta/Categorias/Index.php"</script>';
            }
            else{
            echo "Error: ".$sql." ".$cmd->error;
            }
        }
    }
?>
<style><?php include 'css/Modificar-Categorias.css'; ?></style>
<main>
    <section class="Modificar-Categoria">
        <H2><b>MODIFICAR CATEGORIAS</b></H2>
        <form method="POST" action="Update.php">
        <input type="hidden" name="iIdCategoria" value="<?php echo $fila["iIdCategoria"]; ?>"/>
        NOMBRE <br>
        <input class="Control" type="text" name="txtsNombre" value="<?php echo $fila["sNombre"]; ?>"> <br>
        DESCRIPCION <br>
        <textarea class="Control" type="text" name="sDescripcion"><?php echo $fila["sDescripcion"]; ?></textarea> <br>
        <input class="Boton1" type="submit" value="Guardar"> <br>
        <a class="Boton2" href="Index.php">Volver a la lista de Categorias</a> <br>
        </form>
    </section>
</main>
<?php
    include '..\Helpers\Footer.php';
?>