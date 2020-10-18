<?php
include_once("config/config.php");
class ClaseEstudiantes extends MiConexion{
  //Inicio obtenerEstudiantes
  function obtenerEstudiantes($filtro){
      $comando = "select * from estudiantes WHERE nombre LIKE '%$filtro%' or
      apellido LIKE '%$filtro%' or carnet LIKE '%$filtro%'";
      $query = $this->conectar()->query($comando);
      return $query;
  }
  //Fin obtenerEstudiantes
  //Inicio datosEstudiante
  function datosEstudiante($id){
      $comando = "SELECT * FROM estudiantes WHERE carnet = :elCarnet";
      $query = $this->conectar()->prepare($comando);
      $query->execute(['elCarnet' => $id]);
      return $query;
  }
  //Fin datosEstudiante
  //Inicio nuevoEstudiante
  function nuevoEstudiante($aEstudiante){
      $aMensaje = array();
      try{
        $comando = "INSERT INTO estudiantes (carnet,nombre, apellido)
        VALUES (:carnet, :nombre, :apellido)";
        $query = $this->conectar()->prepare($comando);
        $query->execute(['carnet' => $aEstudiante['carnet'],
                        'nombre' => $aEstudiante['nombre'],
                        'apellido' => $aEstudiante['apellido']]);
        if($query->errorCode()=="00000"){
          $aMensaje["estado"] = "1";
          $aMensaje["mensaje"] = "Datos Almacenados con exito";
        }else{
          $aMensaje["estado"] = "0";
          $aMensaje["mensaje"] = "Error Interno: ". $query->errorInfo()[2];
        }
      }catch(Exception $e){
        $aMensaje["estado"] = "0";
        $aMensaje["mensaje"] = "Error interno: ". $e->getMessage();
      }
      return $aMensaje;
  }
  //Fin nuevoEstudiante
  //Inicio modificarEstudiante
  function modificarEstudiante($aEstudiante){
      $aMensaje = array();
      try{
        $comando = "UPDATE estudiantes SET nombre=:nombre, apellido=:apellido
        WHERE carnet=:carnet";
        $query = $this->conectar()->prepare($comando);
        $query->execute(['carnet' => $aEstudiante['carnet'],
                        'nombre' => $aEstudiante['nombre'],
                        'apellido' => $aEstudiante['apellido']]);
        if($query->errorCode()=="00000"){
          $aMensaje["estado"] = "1";
          $aMensaje["mensaje"] = "Datos Modificados con exito";
        }else{
          $aMensaje["estado"] = "0";
          $aMensaje["mensaje"] = "Error Interno: ". $query->errorInfo()[2];
        }
      }catch(Exception $e){
        $aMensaje["estado"] = "0";
        $aMensaje["mensaje"] = "Error interno: ". $e->getMessage();
      }
      return $aMensaje;
  }
  //Fin modificarEstudiante
  //Inicio eliminarEstudiante
  function eliminarEstudiante($id){
    $aMensaje = array();
    try{
      $comando = "DELETE FROM estudiantes WHERE carnet=:carnet";
      $query = $this->conectar()->prepare($comando);
      $query->execute(['carnet' => $id]);
      if($query->errorCode()=="00000"){
        $aMensaje["estado"] = "1";
        $aMensaje["mensaje"] = "Datos Eliminados con exito";
      }else{
        $aMensaje["estado"] = "0";
        $aMensaje["mensaje"] = "Error Interno: ". $query->errorInfo()[2];
      }
    }catch(Exception $e){
      $aMensaje["estado"] = "0";
      $aMensaje["mensaje"] = "Error interno: ". $e->getMessage();
    }
    return $aMensaje;
  }
  //Fin eliminarEstudiante
}
?>
