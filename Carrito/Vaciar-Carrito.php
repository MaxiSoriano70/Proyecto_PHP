<?php
	include "..\Helpers\Header.php";
?>
<?php
 $Usuario=$_SESSION['iIdUsuario'];

 $sqlid="SELECT iIdCarritoCompra FROM carritoscompras cc WHERE cc.sEstado='Pendiente' AND cc.iIdUsuario=?";
 $cmdid=preparar_select($conexionDB,$sqlid,[$Usuario]);
 $rid=$cmdid->fetch_assoc();
 $iIdCarritoCompra=$rid['iIdCarritoCompra'];

 $sql_det="DELETE FROM det_carrito WHERE iIdCarritoCompra=?";
 $cmd_det=preparar_query($conexionDB,$sql_det,[$iIdCarritoCompra]);

 if ($cmd_det) {
  $sql_carr="DELETE FROM carritoscompras WHERE iIdCarritoCompra=?";
  $cmd_carr=preparar_query($conexionDB,$sql_carr,[$iIdCarritoCompra]);
  echo '<script>location.href="/Instituto/Compra_En_Salta/Carrito/Index.php"</script>';
 }
?>
<?php
	include '..\Helpers\Footer.php';
?>