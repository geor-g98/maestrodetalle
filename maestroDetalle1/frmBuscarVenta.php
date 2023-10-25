<?php
ob_start();
include_once('clsCarro.php');
include('nav.php');
session_start();
?>
<?php
include_once("clsVenta.php");
include_once('clsDetalleVenta.php');
?>
<html>

<head>
  <title></title>

  <!-- Llamada a la CSS -->
  <link rel="stylesheet" href="estilo.css" type="text/css" />>

</head>

<body>

  <center>
    <form id="form1" method="post" action="frmBuscarVenta.php">
      <fieldset id="form">
        <legend>BUSQUEDA DE VENTAS </legend>
        <table width="342" border="0">
          <tr>
            <td colspan="2">
              <center><label>
                  <h3>BUSQUEDA POR NOMBRE O APELLIDO DEL CLIENTE</h3>
                </label></center>
              <center><label>Introduzca Nombre o Apellido</label>
                <input name="txtBuscarVen" type="text" id="txtBuscarVen" value="" size="33" />
              </center>
              <center><input type="submit" name="boton" class="btn" value="Buscar" /></center>
            </td>
          </tr>
        </table>
    </form>
  </center>
  <?php
if(isset($_POST['boton']) && $_POST['boton']=="Buscar")
{
  $obj= new Venta();	
  $resultado=$obj->buscarVenta($_POST['txtBuscarVen']);
  echo "<center><table border='3' bordercolor='#000000' width='500'>";
	echo "<tr bgcolor='black' align='center'>
	     <td><font color='white'>Codigo</font></td>
	     <td><font color='white'>Nombre</font></td>
	     <td><font color='white'>Apellidos</font></td>
	     <td><font color='white'>idVenta</font></td>
	     <td><font color='white'>Fecha</font></td>
	     <td><font color='white'>*</font></td></tr>";
	while($fila=mysqli_fetch_object($resultado))
	{
	$d=substr($fila->fecha,8,2);$m=substr($fila->fecha,5,2);$a=substr($fila->fecha,0,4);
	echo "<tr>";
	echo "<td> <input type=\"text\" size=\"5\"  readonly=\"true\"  value=\" $fila->id_cliente\" /> </td>";
	echo "<td> <input type=\"text\" size=\"10\" readonly=\"true\"  value=\"$fila->nombre\" /> </td>";
	echo "<td> <input type=\"text\" size=\"15\"  readonly=\"true\"  value=\"$fila->apellidos\" /> </td>";
	echo "<td> <input type=\"text\" size=\"5\" readonly=\"true\"  value=\"$fila->id_venta\" /> </td>";
	echo "<td> <input type=\"text\" size=\"10\" readonly=\"true\"  value=\"$fila->fecha\" /> </td>";
    echo "<td><a href='frmBuscarVenta.php? pid_cli=$fila->id_cliente&pnom_cli=$fila->nombre $fila->apellidos&pid_ven=$fila->id_venta&pfecha=$fila->fecha'> << </a> </td>";
	echo "</tr>";
	}
	echo "</table></center>";   
}
if(isset($_GET['pid_cli']))
{
	$_SESSION['cliente']=$_GET['pnom_cli'];
 	$_SESSION['idcliente']=$_GET['pid_cli'];
	$_SESSION['idventa']=$_GET['pid_ven'];
	$_SESSION['fecha']=$_GET['pfecha'];
	$_SESSION['carrito']=new Carrito();
	$au=new DetalleVenta();
	$res=$au->buscar($_GET['pid_ven']);
	while($l=mysqli_fetch_object($res))
	{
	   $_SESSION['carrito']->Insertar($l->id_producto,$l->cantidad,$l->preciov);
	}
	echo "<script> 
    opener.document.location.reload() 
    window.close() 
</script>";
}
?>
</body>

</html>