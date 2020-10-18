<?php
  include_once("ClaseEstudiantes.php");
  $objeto = new ClaseEstudiantes();
  $arreglo = array();
  $arreglo["estudiantes"] = array();
  $filtro = "";
  if(isset($_GET["filtro"])){
      $filtro = $_GET["filtro"];
  }

  $resultado = $objeto->obtenerEstudiantes($filtro);
  if($resultado->rowCount()){
      while ($cadaFila = $resultado->fetch(PDO::FETCH_ASSOC)){
          $item=array(
              "carnet" => $cadaFila['carnet'],"nombre" => $cadaFila['nombre'],
              "apellido" => $cadaFila['apellido']);
          array_push($arreglo["estudiantes"], $item);
      }

  }

    //Creamos el archivo temporal
    $contenido = json_encode($arreglo);
    $archivo = "reporte_".date("YmdHis").".json";
    $rutaArchivo = "./$archivo";
    $idArchivo = fopen("$archivo","w");
    fwrite($idArchivo,$contenido);
    fclose($idArchivo);
    //Fin
    //Forzamos la descarga
    $nombreArchivo = basename($rutaArchivo);
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header("Content-disposition: attachment; filename=$nombreArchivo");
    readfile($rutaArchivo);
    unlink($rutaArchivo);
    //Fin
?>
