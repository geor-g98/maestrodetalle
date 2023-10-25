<?php
include_once('clsProducto.php');
include_once('clsCategoria.php');
include('nav.php');
?>
<html>

<head>
  <title>Registro de Productos</title>
  <!-- Llamada a la CSS -->
  <link rel="stylesheet" href="estilo.css" type="text/css" />
</head>

<body>

  <center>
    <form id="form1" name="form1" method="post" action="frmProducto.php">
      <fieldset id="form">
        <legend>REGISTRO DE PRODUCTOS</legend>
        <table width="325" border="0">
          <tr>
            <td>&nbsp;</td>
            <td><?php if(isset($_GET['pid_producto'])) $cod=$_GET['pid_producto']; ?>
              <input name="txtIdProducto" type="hidden" value="<?php if(isset($_GET['pid_producto'])) echo $cod; ?>"
                id="txtIdProducto" />
              <label></label>
            </td>
          </tr>
          <tr>
            <td width="79">Descripcion</td>
            <td width="253"><label>
                <?php if(isset($_GET['pdescripcion'])) $des=$_GET['pdescripcion']; ?>
                <input name="txtDescripcion" type="text" value="<?php if(isset($_GET['pdescripcion'])) echo $des; ?>"
                  id="txtDescripcion" />
              </label></td>
          </tr>
          <tr>
            <td>Precio</td>
            <td><label>
                <?php if(isset($_GET['pprecio'])) $pre=$_GET['pprecio']; ?>
                <input name="txtPrecio" type="text" value="<?php if(isset($_GET['pprecio'])) echo $pre; ?>"
                  id="txtPrecio" />
              </label></td>
          </tr>

          <tr>
            <td>Categoria</td>
            <td><label>
                <?php    	 
   $c=new Categoria();
   $reg=$c->buscar();		
   echo "<select name=\"cboCategoria\" id=\"id_categoria\">";   
   while ($fila=mysqli_fetch_array($reg))
   {
   ?>
                <option
                  <?php if(isset($_GET['pcategoria']) && $_GET['pcategoria']==$fila['nombre']) echo "selected";  //else ?>
                  value="<?php echo $fila['id_categoria']; ?>">
                  <?php  echo $fila['nombre']; ?>
                </option>
                <?php 
   }
   echo "</select>"; 
   ?>

              </label></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><label></label></td>
          </tr>
          <tr>
            <td colspan="2">
              <label>
                <input type="submit" name="botones" value="Nuevo" />
                <input type="submit" name="botones" value="Guardar" />
                <input type="submit" name="botones" value="Modificar" />
                <input type="submit" name="botones" value="Eliminar" />
              </label>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              </p>
            </td>
          </tr>
        </table>
    </form>

    <?php
function buscar(){
  $obj= new Producto();	
  $resultado=$obj->buscar();
  mostrarRegistros($resultado);    
}
		   
if (!isset($_POST['botones']))	//analizar		 
  buscar();

function guardar()
{
	if($_POST['txtDescripcion'] && $_POST['txtPrecio'])
	{
		$obj= new Producto();
		$obj->setDescripcion($_POST['txtDescripcion']);
		$obj->setPrecio($_POST['txtPrecio']);
		$obj->setIdCategoria($_POST['cboCategoria']);
		if ($obj->guardar()){
			buscar();		  
			//echo "Producto Guardado..!!!";			
		}
		else
			echo "Error en los datos al guardar el Producto";
	}
	else
		echo "Descripcion y Categoria son obligatorios";
}	

function modificar()
{
	if($_POST['txtDescripcion'] && $_POST['txtPrecio'])
	{
		$obj= new Producto();
		$obj->setIdProducto($_POST['txtIdProducto']);
		$obj->setDescripcion($_POST['txtDescripcion']);
		$obj->setPrecio($_POST['txtPrecio']);
		$obj->setIdCategoria($_POST['cboCategoria']);
		if ($obj->modificar()){
		    buscar();
			//echo"Producto modificado..!!!";
			}
		else
			echo "Error al modificar el Producto..!!!";		
	}
	else
		echo "La descripcion son obligatorios...!!!";
}

function eliminar()
{
	if($_POST['txtIdProducto'])
	{
		$obj= new Producto();
		$obj->setIdProducto($_POST['txtIdProducto']);		
		if ($obj->eliminar()){
			buscar();
		  	//echo "Producto eliminado..!!!";
		}		
		else
			echo "Error al eliminar el Producto...!!!";		
	}
	else	
		echo "para eliminar el registro, debe introducir el codigo del producto..!!!";	
}

 function mostrarRegistros($registros)
 {
	echo "<table border='3' width='500'>";
	echo "<tr bgcolor='black' align='center'>
		   <td><font color='white'>Codigo</font></td>
	       <td><font color='white'>Descripcion </font></td>
		   <td><font color='white'> Precio</font></td>
		   <td><font color='white'> Categoria</font></td>
		   <td><font color='white'>*</font></td></tr>";
	while($fila=mysqli_fetch_object($registros))
	{
	echo "<tr>";
	echo "<td> <input type=\"text\" size=\"7\"  readonly=\"true\"  value=\" $fila->id_producto\" /> </td>";
	echo "<td> <input type=\"text\" size=\"30\" readonly=\"true\"  value=\"$fila->descripcion\" /> </td>";
	echo "<td> <input type=\"text\" size=\"8\"  readonly=\"true\"  value=\"$fila->precio\" /> </td>";
	echo "<td> <input type=\"text\" size=\"18\" readonly=\"true\"  value=\"$fila->nombre\" /> </td>";
    echo "<td><a href='frmProducto.php? pid_producto=$fila->id_producto&pdescripcion=$fila->descripcion&pprecio=$fila->precio&pcategoria=$fila->nombre'> << </a> </td>";
	echo "</tr>";
	}
	echo "</table>";
 }   
 

//hasta aqui el programa principal
if(isset($_POST['botones'])){
	switch($_POST['botones'])
  {
	case "Nuevo":{
	}break;

	case "Guardar":{
    guardar();
	}break;

	case "Modificar":{
    modificar();
	}break;

	case "Eliminar":{
     eliminar();
	}break;

	case "Buscar":{
     //buscar();
	}break;

  }
}
?>

</body>

</html>