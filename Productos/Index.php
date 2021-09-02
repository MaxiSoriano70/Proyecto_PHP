<?php
	include "..\Helpers\Header.php";
?>
<?php
	include "..\Helpers\Menu.php";
?>
<?php
	//$sql="select iIdProducto,sCodigo,sNombre,sDescripcion,iStock,iStockMinimo,fPrecio from Productos where bEliminado=0";
	$sql="SELECT iIdProducto,sCodigo,sNombre,sDescripcion,iStock,iStockMinimo,fPrecio,bEliminado FROM Productos".($_SESSION["isAdmin"]=0?"where bEliminado=0":"");
	$productos= preparar_select($conexionDB,$sql);
	/*$campos=$productos->fetch_fields();*/
?>
<style><?php include 'css/T-Productos.css'; ?></style>
<div class="Titulo-Tabla-Productos">
    <div class="Titulo">
        <h2><b>Listado de Productos</b></h2>
    </div>
    <div class="Boton-A">
        <a class="btn btn-success" href="Create.php"><span class="icon-plus-circle"></span> Agregar Usuario</a>
    </div>
</div>
<main class="Tabla-Productos">
    <center>
        <table>
            <thead>
                <tr>
                    <th>CODIGO</th>
                    <th>NOMBRE</th>
                    <th>DESCRIPCION</th>
                    <th>PRECIO</th>
                    <th>STOCK</th>
                    <th>STOCK MINIMO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($productos as $fila){
                    echo '<tr>';
                    echo '<td data-titulo="Codigo: ">'.$fila['sCodigo'].'</td>';
                    echo '<td data-titulo="Nombre: ">'.$fila['sNombre'].'</td>';
                    echo '<td data-titulo="Descripción: ">'.$fila['sDescripcion'].'</td>';
                    echo '<td data-titulo="Precio: ">'.$fila['fPrecio'].'</td>';
                    echo '<td data-titulo="Stock: ">'.$fila['iStock'].'</td>';
                    echo '<td data-titulo="Stock Minino: ">'.$fila['iStockMinimo'].'</td>';
                    echo '<td>
                    <div class="Botones-U">
                        <a class="btn btn-warning mx-1" href="Update.php?iIdProducto='.$fila['iIdProducto'].'"><span class="icon-edit"></span> Modificar</a>';
                        if ($fila["bEliminado"]==0){
                            echo '
                        <a class="btn btn-danger mx-1" href="Delete.php?iIdProducto='.$fila['iIdProducto'].'"><span class="icon-trash-o"></span> Eliminar</a>';
                        }
                        else{
                            echo '
                        <a class="btn btn-secondary mx-1" href="Recuperar.php?iIdProducto='.$fila['iIdProducto'].'"><span class="icon-check-circle-o"></span> Recuperar</a>'; 
                        }
                    echo '<a class="btn btn-info" href="Imagenes.php?iIdProducto='.$fila['iIdProducto'].'"><span class="icon-image"></span> Imagen</a>
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