<?php
	include "..\Helpers\Header.php";
?>
<?php
    include "..\Helpers\Menu.php";
?>
<?php
    $sql="SELECT iIdUsuario,sLogin,sClave,sNombre,sApellido,sEmail,iDNI,iContacto,bEliminado FROM usuarios".($_SESSION["isAdmin"]=0?"where bEliminado=0":"");
    $usuarios=preparar_select($conexionDB,$sql);
    $campos=$usuarios->fetch_fields();
?>
<style><?php include 'css/T-Usuarios.css'; ?></style>
<div class="Titulo-Tabla-Usuarios">
    <div class="Titulo">
        <h2><b>Listado de Usuarios</b></h2>
    </div>
    <div class="Boton-A">
        <a class="btn btn-success" href="Create.php"><span class="icon-plus-circle"></span> Agregar Usuario</a>
    </div>
</div>
<main class="Tabla-Usuarios">
    <center>
        <table>
            <thead>
                <tr>
                    <th>USUARIO</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>EMAIL</th>
                    <th>DNI</th>
                    <th>CONTACTO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
            	<?php
		        foreach($usuarios as $fila){
		            echo '<tr>';
                    echo '<td data-titulo="Usuario: ">'.$fila['sLogin'].'</td>';
                    echo '<td data-titulo="Nombre: ">'.$fila['sNombre'].'</td>';
                    echo '<td data-titulo="Apellido: ">'.$fila['sApellido'].'</td>';
                    echo '<td data-titulo="Email: ">'.$fila['sEmail'].'</td>';
                    echo '<td data-titulo="DNI: ">'.$fila['iDNI'].'</td>';
                    echo '<td data-titulo="Contacto: ">'.$fila['iContacto'].'</td>';
		            echo '<td>
                    <div class="Botones-U">
                        <a class="btn btn-warning mx-1" href="Update.php?iIdUsuario='.$fila['iIdUsuario'].'"><span class="icon-edit"></span> Modificar</a>';
                        if ($fila["bEliminado"]==0){
                            echo '
                        <a class="btn btn-danger mx-1" href="Delete.php?iIdUsuario='.$fila['iIdUsuario'].'"><span class="icon-trash-o"></span> Eliminar</a>';
                        }
                        else{
                            echo '
                        <a class="btn btn-secondary mx-1" href="Recuperar.php?iIdUsuario='.$fila['iIdUsuario'].'"><span class="icon-check-circle-o"></span> Recuperar</a>'; 
                        }
                    echo 
                    '</div>
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