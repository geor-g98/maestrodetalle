<?php
ob_start();
include_once('clsConexion.php');
session_start();
include_once('clsCategoria.php');
include('nav.php');

if(!isset($_SESSION['busqueda'])){
 $_SESSION['busqueda']="hola";
}
?>

<html>

<head>
</head>
<title>Categorias de Productos</title>

<!-- Llamada a la CSS -->
<link rel="stylesheet" href="estilo.css" type="text/css" />

</head>

<body>
  <center>
    <form id="form2" name="formularioCate" method="post" action="frmCategoria.php">
      <fieldset id="form">
        <legend>ELIMINAR CATEGORIAS</legend>
        <table width="381" border="0">
          <tr>
            <td colspan="2">
              <div align="center" class="Estilo1"> </div>
            </td>
          </tr>
          <tr>
            <td width="72"></td>
            <td width="299"><label>
                <input name="txtIdCategoria" type="hidden" id="txtIdCategoria" />
              </label></td>
          </tr>
          <tr>
            <td>Nombre</td>
            <td><label>
                <input name="txtNombre" type="text" id="txtNombre" />
              </label></td>
          </tr>
          <tr>
            <td colspan="3"><label>
                <input name="btnAccion" type="submit" id="btnAccion" value="Guardar" />
                <input name="btnAccion" type="submit" id="btnAccion" value="Eliminar" />
                <input name="btnAccion" type="submit" id="btnAccion" value="Buscar" />
              </label></td>
          </tr>
          <tr>
            <td> Buscar </td>
            <td><input name="txtBuscar" type="text" id="txtBuscar" /> </td>
          </tr>
        </table>

        <?php
function guardar()
{
	if($_POST['txtNombre'])
	{
		$obj= new Categoria();
		$obj->setNombre($_POST['txtNombre']);
	    if ($obj->guardar())
			echo "Categoria guardada";
		else
			echo "Error al guardar el categoria";
	}
	else
			echo "El nombre es obligatorio";	
}	
function modificar()
{
	if($_POST['txtIdCategoria']&& $_POST['txtNombre'])
	{
        $obj= new Categoria();
		$obj->setNombre($_POST['txtNombre']);		
		if ($obj->modificar())
			echo "Categoria modificada";
		else
			echo "Error al modificar la categoria";		
	}
	else	
		echo "El id y nombre son obligatorios";	
}

function eliminar()
{
	if($_POST['txtIdCategoria'])
	{
		$obj= new Categoria();
		$obj->setIdCategoria($_POST['txtIdCategoria']);
		
		if ($obj->eliminar())
			echo "Categoria eliminada";
		else
			echo "Error al eliminar el categoria";		
	}
	else	
		echo "para eliminar la categoria, debe introducir el id de la categoria";	
}

function eliminar1()
{
		$j=1;
		$obj= new Categoria();
		 $resultado=$obj->buscarPorNombre($_SESSION['busqueda']);
		 while($reg=mysqli_fetch_object($resultado))
         {
			if(isset($_POST['hola'.$j]) && $_POST['hola'.$j])
			{
				$categ=new Categoria();
				$categ->setIdCategoria($reg->id_categoria);
				$categ->eliminar();
			}
 		$j++;
        }
}

function buscar()
{
        echo "<p>";
	    $obj= new Categoria();
	    $resultado=$obj->buscarPorNombre($_POST['txtBuscar']);	
		$_SESSION['busqueda']=$_POST['txtBuscar'];
        echo "<form id='form3' name='form3' method='post' action='frmCategoria.php'>";
	    echo"<table border ='1'>";
	    echo"<tr bgcolor='black'><td><font color='white'>IDCat</font></td><td><font color='white'>Nombre</font></td><td></td></tr>";
		$k=1;
	    while($reg=mysqli_fetch_object($resultado))
	        {
			echo"<tr>";
			echo"<td>$reg->id_categoria</td>";
			echo"<td>$reg->nombre</td>";
			echo "<td><input type='checkbox' name='hola";
			echo $k;
			echo"'></td>";
			echo"</tr>";
			$k++;
 		}
	    echo"</table></form>";       
       
}
//programa principal
if(isset($_POST['btnAccion'])){
	switch($_POST['btnAccion'])
{
	case "Guardar":guardar();
	               break;
	case "Modificar":modificar();
	               break;
	case "Eliminar":eliminar1();
	               break;
	case "Buscar":buscar();
	               break;			   			   			   
}
}
?>
    </form>
    <center>
</body>

</html>