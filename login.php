<?php
  session_start();
  require("config/config.php");
  if($_POST){
      $usuario = $_POST["usuario"];
      $password = $_POST["password"];

      $objeto = new MiConexion();
      $comando = "select * from usuarios WHERE usuario='$usuario' AND password=md5('$password')";
      $query = $objeto->conectar()->query($comando);
      $filas = $query->rowCount();

      if($filas==0){
          echo "El usuario o contraseña no es correcta";
      }else{
          $_SESSION["usuario"] = $usuario;
          echo "
            <script>alert('Bienvenido $usuario');
            location.replace('index.php');</script>
          ";
      }
  }

  echo "
  <form method='post' action='login.php'>
  Usuario: <input type='text' name='usuario'><br>
  Password: <input type='password' name='password'><br>
  <input type='submit' value='Iniciar Sesion'>
  </form>
  ";
?>
