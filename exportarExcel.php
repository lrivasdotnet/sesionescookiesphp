<?php
  include_once("ClaseEstudiantes.php");
  $objeto = new ClaseEstudiantes();
  $arreglo = array();
  $arreglo["estudiantes"] = array();
  $filtro = "";
  if(isset($_GET["filtro"])){
      $filtro = $_GET["filtro"];
  }

  $html = "<table style=\"width:600px;border:solid 1px;\">
  <tr>
    <td width=\"20px\">#</td>
    <td width=\"80px\">Carnet</td>
    <td width=\"250px\">Nombre</td>
    <td width=\"250px\">Apellido</td>
  </tr>";
  $resultado = $objeto->obtenerEstudiantes($filtro);
  if($resultado->rowCount()){
      $i=0;
      while ($cadaFila = $resultado->fetch(PDO::FETCH_ASSOC)){
        $i++;
        $html .= "
        <tr>
          <td>$i</td>
          <td>$cadaFila[carnet]</td>
          <td>$cadaFila[nombre]</td>
          <td>". utf8_decode($cadaFila["apellido"]) ."</td>
        </tr>
        ";
      }
  }
  $html .= "</table>";

    //Creamos el archivo temporal
    $contenido = $html;
    $archivo = "reporte_".date("YmdHis").".xls";
    $rutaArchivo = "./$archivo";
    $idArchivo = fopen("$archivo","w");
    fwrite($idArchivo,$contenido);
    fclose($idArchivo);
    //Fin
    //Forzamos la descarga
    $nombreArchivo = basename($rutaArchivo);
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=$nombreArchivo");
    readfile($rutaArchivo);
    unlink($rutaArchivo);
    //Fin
?>
