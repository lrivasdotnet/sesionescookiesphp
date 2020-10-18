<?php
class MiConexion{
    private $host, $db, $user, $password;
    public function __construct(){
        $this->host='localhost';
        $this->db='base02';
        $this->user='root';
        $this->password="";
    }
    function conectar(){
        try{
            $connection = "mysql:host=".$this->host.";dbname=" . $this->db;
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false];
            $pdo = new PDO($connection,$this->user,$this->password);
            return $pdo;
        }catch(PDOException $e){
            print_r('Error connection: ' . $e->getMessage());
        }
    }
}
?>
