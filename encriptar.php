<?php
   $cadena = "hola";
   $encriptadoMD5 = md5($cadena);
   $encriptadoBase64 = base64_encode($cadena);
   $desencriptarBase64 = base64_decode($encriptadoBase64);

   echo "
   <h1>
      Cadena Original: $cadena <br>
      Cadena en MD5: $encriptadoMD5 <br>
      Cadena con Base64: $encriptadoBase64 <br>
      Base64 desencriptado: $desencriptarBase64 <br>
   </h1>
   ";
?>
