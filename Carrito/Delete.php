<?php
	include "..\Helpers\Header.php";
?>
<?php
	if(!empty($_GET['iIdProducto']) and $_GET['iIdCarritoCompra']){
		/*TRAEMOS EL iIdProducto e iICarritoCompra*/
		$iIdCarritoCompra=$_GET['iIdCarritoCompra'];
		$iIdProducto=$_GET['iIdProducto'];
		$sqldelete="DELETE FROM det_carrito WHERE iIdProducto=? AND iIdCarritoCompra=?";
		$cmd=preparar_query($conexionDB,$sqldelete,[$iIdProducto,$iIdCarritoCompra]);
		/*SUMAMOS EL DETALLE DE CARRITO*/
      	$sqlTotal="SELECT SUM(fSubtotal) AS Total FROM det_carrito WHERE iIdCarritoCompra=?";
      	$cmdTotal=preparar_select($conexionDB,$sqlTotal,[$iIdCarritoCompra]);
      	$Total=$cmdTotal->fetch_assoc();/*Esto se utiliza cuando devuelve un valor*/
      	/*ACTUALIZAMOS EL CARRITO*/
      	$sqlTot="UPDATE carritoscompras SET fTotal=? WHERE iIdCarritoCompra=?";
      	$cmdtot=preparar_select($conexionDB,$sqlTot,[$Total['Total'],$iIdCarritoCompra]);
      	/*VERIFICAMOS QUE EL CARRITO DE COMPRAS QUEDO EN 0O NO*/
      	if ($Total['Total']==0){
   			$cmdtot=preparar_select($conexionDB,$sqlTot,[0,$iIdCarritoCompra]);
        echo'<script type="text/Javascript">alert("Su Carrito de compras a quedado vacio")</script>';
        echo '<script>location.href="/Instituto/Compra_En_Salta/Carrito/Index.php"</script>';
  		  }
  		  else{
   			$cmdtot=preparar_select($conexionDB,$sqlTot,[$Total['Total'],$iIdCarritoCompra]);
        echo'<script type="text/Javascript">alert("Producto eliminado correctamente")</script>';
        echo '<script>location.href="/Instituto/Compra_En_Salta/Carrito/Index.php"</script>';
            
        }
	}
?>
<?php
	include '..\Helpers\Footer.php';
?>