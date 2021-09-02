<style><?php include 'css/Menu.css';?></style>
<header>
    <a href="/Instituto/Compra_En_Salta/Index.php">
    <img src="/Instituto/Compra_En_Salta/Imagenes/Logos/roma_negro.png" alt="">
    <h1><b>AS ROMA</b></h1>
    </a>
    <input type="checkbox" id="boton_menu">
    <label for="boton_menu" class="icon-bars"></label>
    <div class="Menu">
        <ul>
            <li><a href="#"><span class="icon-home"></span></a></li>
            <li><a href="#">QATAR AIRWAYS</a></li>
            <li><a href="#">NIKE</a></li>
            <li><a href="#">HYUNDAI</a></li>
            <?php
                if(!isset($_SESSION["iIdUsuario"])){
                    echo '<li><a href="/Instituto/Compra_En_Salta/Acceso/Login.php"><span class="icon-user-o"></span> INICIAR SESION </a></li>';  
                }
                else{
            ?>
            <li class="Submenu"><a href="#"><span class="icon-user-o"></span><?php 
                echo " ".$_SESSION["sLogin"]." ";
            ?> 
            <span class="icon-chevron-down"></span></a>
                <ul>
                    <li><a href="#"><span class="icon-user-circle-o"></span> Mi Cuenta</a></li>
                    <li><a href="/Instituto/Compra_En_Salta/Carrito/Index.php"><span class="icon-shopping-cart"></span> Mi Carrito</a></li>
                    <li><a href="#"><span class="icon-file-text-o"></span> Mis Ordenes</a></li>
                    <li><a href="/Instituto/Compra_En_Salta/Acceso/Logout.php"><span class="icon-sign-out"></span> Cerrar Sesion</a></li>
                </ul>
            </li>
            <?php
                    }
            ?>
        </ul>
    </div>
</header>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script><?php include 'js/menu.js'; ?></script>