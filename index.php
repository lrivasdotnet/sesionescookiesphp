<?php
    session_start();
    if(!isset($_SESSION["usuario"])){
        echo "<script>location.replace('login.php');</script>";
    }
    include_once("ClaseEstudiantes.php");
    $objeto = new ClaseEstudiantes();
    $accion = "";
    if(isset($_GET["accion"])){
        $accion = $_GET["accion"];
    }

    if(isset($_POST["accion"])){
        $accion = $_POST["accion"];
    }

    echo "
    <h1>MENU</h1>
    <ul>
    <li><a href='index.php'>Inicio</a></li>
    <li><a href='index.php?accion=agregar'>Nuevo</a></li>
    <li><a href='index.php?accion=todos'>Ver Todos</a></li>
    <li><a href='cerrar.php'>Cerrar Sesion</a></li>
    </ul>
    ";

    if($accion=="agregar"){
        if($_POST){
          $nombre = $_POST["nombre"];
          $apellido = $_POST["apellido"];
          $carnet = $_POST["carnet"];
          $item = array(
              'nombre' => $nombre,
              'apellido' => $apellido,
              'carnet' => $carnet
          );
          $resultado = $objeto->nuevoEstudiante($item);
          if($resultado["estado"]=="1"){
            echo "$resultado[mensaje]";
          }else{
            echo "Error: $resultado[mensaje]";
          }
        }

        echo "
        <form method='post' action='index.php?accion=agregar'>
        <h1>Agregar Nuevo</h1>
        <table border='0' id='tablaNuevo'>
             <tr>
                 <td><label>Carnet: </label></td>
                 <td><input type='number' name='carnet'></td>
             </tr>
             <tr>
                 <td><label>Nombre: </label></td>
                 <td><input type='text' name='nombre'></td>
             </tr>
             <tr>
                 <td><label>Apellido: </label></td>
                 <td><input type='text' name='apellido'></td>
             </tr>
             <tr>
               <td colspan='2'><center><input type='submit' value='Agregar Nuevo'></center></td>
             </tr>
        </table>
        </form>";

    }else if($accion=="modificar"){
      $carnet = "";
      $nombre ="";
      $apellido = "";
      if(isset($_GET["carnet"])){
        $carnet = $_GET["carnet"];
        $resultado = $objeto->datosEstudiante($carnet);
        $cadaFila = $resultado->fetch(PDO::FETCH_ASSOC);
        $nombre = $cadaFila["nombre"];
        $apellido = $cadaFila["apellido"];
      }

      if($_POST){
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $carnet = $_POST["carnet"];
        $item = array(
            'nombre' => $nombre,
            'apellido' => $apellido,
            'carnet' => $carnet
        );
        $resultado = $objeto->modificarEstudiante($item);
        if($resultado["estado"]=="1"){
          echo "$resultado[mensaje]";
        }else{
          echo "Error: $resultado[mensaje]";
        }
      }

      echo "
      <form method='post' action='index.php'>
      <input type='hidden' name='accion' value='modificar'>
      <h1>Modificar Nuevo</h1>
      <table border='0' id='tablaNuevo'>
           <tr>
               <td><label>Carnet: </label></td>
               <td><input type='number' name='carnet' value='$carnet' readonly></td>
           </tr>
           <tr>
               <td><label>Nombre: </label></td>
               <td><input type='text' name='nombre' value='$nombre'></td>
           </tr>
           <tr>
               <td><label>Apellido: </label></td>
               <td><input type='text' name='apellido' value='$apellido'></td>
           </tr>
           <tr>
             <td colspan='2'><center><input type='submit' value='Modificar'></center></td>
           </tr>
      </table>
      </form>";

    }else if($accion=="eliminar"){
      if($_GET){
        $carnet = $_GET["carnet"];
        $resultado = $objeto->eliminarEstudiante($carnet);
        if($resultado["estado"]=="1"){
          echo "<script>alert('$resultado[mensaje]');
          location.replace('index.php?accion=todos');</script>";
        }else{
          echo "Error: $resultado[mensaje]";
        }
      }
    }else if($accion=="todos"){
         //Mostrar Todo
        $filtro = "";
        if(isset($_GET["filtro"])){
            $filtro = $_GET["filtro"];
        }
        echo "
        <form method='get' action='index.php'>
        <input type='hidden' name='accion' value='todos'>
        <label>Buscar por nombre, apellido o carnet:
        <input type='text' name='filtro'  value='$filtro'></label>
        <br>
        <input type='submit' value='Buscar'>
        <a href='exportarEstudiantes.php?filtro=$filtro'>Exportar JSON</a>
        <a href='reportePDF.php?filtro=$filtro' target='_blank'>Reporte PDF</a>
        <a href='exportarExcel.php?filtro=$filtro'>Exportar EXCEL</a>
        </form>
        <table width='100%' border='1'>
        <tr>
          <td width='15%'>Carnet</td>
          <td width='70%'>Nombre Completo</td>
          <td>Opciones</td>
        </tr>
        ";
        $resultado = $objeto->obtenerEstudiantes($filtro);
        if($resultado->rowCount()){
            while ($cadaFila = $resultado->fetch(PDO::FETCH_ASSOC)){
                $carnet = $cadaFila["carnet"];
                echo "<tr>
                  <td>$carnet</td>
                  <td>$cadaFila[nombre] $cadaFila[apellido]</td>
                  <td>
                      <a href='index.php?accion=modificar&&carnet=$carnet'>Editar</a>
                      <a href='index.php?accion=eliminar&&carnet=$carnet'>Eliminar</a>
                  </td>
                  </tr>";
            }

        }else{
            echo "<tr><td colspan='3'>Sin registros que mostrar</td></tr>";
        }
        echo "</table>";
    }
?>
