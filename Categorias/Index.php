<?php
    include "..\Helpers\Header.php";
?>
<?php
    include "..\Helpers\Menu.php";
?>
<?php
    $sql="SELECT iIdCategoria,sNombre,sDescripcion,bEliminado FROM categorias".($_SESSION["isAdmin"]=0?"where bEliminado=0":"");
    $categorias= preparar_select($conexionDB,$sql);
    $campos=$categorias->fetch_fields();
?>
<style><?php include 'css/T-Categorias.css'; ?></style>
<div class="Titulo-Tabla-Categorias">
    <div class="Titulo">
        <h2><b>Listado de Categorias</b></h2>
    </div>
    <div class="Boton-A">
        <a class="btn btn-success" href="Create.php"><span class="icon-plus-circle"></span> Agregar Usuario</a>
    </div>
</div>
<main class="Tabla-Categorias">
    <center>
        <table>
            <thead>
                <tr>
                    <th>CATEGORIA</th>
                    <th>DESCRIPCION</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($categorias as $fila){
                    echo '<tr>';
                    echo '<td data-titulo="Nombre: ">'.$fila['sNombre'].'</td>';
                    echo '<td data-titulo="Descripción: ">'.$fila['sDescripcion'].'</td>';
                    echo '<td>
                    <div class="Botones-U">
                        <a class="btn btn-warning mx-1" href="Update.php?iIdCategoria='.$fila['iIdCategoria'].'"><span class="icon-edit"></span> Modificar</a>';
                        if ($fila["bEliminado"]==0){
                            echo '
                        <a class="btn btn-danger mx-1" href="Delete.php?iIdCategoria='.$fila['iIdCategoria'].'"><span class="icon-trash-o"></span> Eliminar</a>';
                        }
                        else{
                            echo '
                        <a class="btn btn-secondary mx-1" href="Recuperar.php?iIdCategoria='.$fila['iIdCategoria'].'"><span class="icon-check-circle-o"></span> Recuperar</a>'; 
                        }
                    echo '<a class="btn btn-info" href=Productos.php?iIdCategoria='.$fila['iIdCategoria'].'"><span class="icon-tag"></span> Productos</a>
                    </div>
                    </td>
                </tr>'; 
                }
                ?>
            </tbody>
        </table>
    </center>
</main>
<?php
    include '..\Helpers\Footer.php';
?>