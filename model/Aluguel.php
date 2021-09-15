<?php
class Aluguel
{
    private $id;
    private $idVeiculo;
    private $idUsuario;

    public function __construct($id, $idVeiculo, $idUsuario){
        $this->id = $id;
        $this->idVeiculo = $idVeiculo;
        $this->idUsuario = $idUsuario;
    }

    public static function addAluguel(){
        $ini_array = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/config.php.ini");
        $str_db = 'mysql:host='.$ini_array["host"].';dbname='.$ini_array["db"];
        $con = new PDO($str_db, $ini_array["user"], $ini_array["senha"]);
        $sql = "INSERT INTO aluguel (id_veiculo, id_usuario, status) VALUES (:veiculo, :usuario, '1')";
        $rs = $con->prepare($sql);
        $rs->bindParam(":veiculo", $_POST["id"]);
        $rs->bindParam(":usuario", $_SESSION["id_usuario"]);
        $rs->execute();
    }

    public static function inativaAluguel(){
        $ini_array = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/config.php.ini");
        $str_db = 'mysql:host='.$ini_array["host"].';dbname='.$ini_array["db"];
        $con = new PDO($str_db, $ini_array["user"], $ini_array["senha"]);
        $sql = "UPDATE aluguel SET status = '0' WHERE id_veiculo = :id_veiculo AND id_usuario = :id_usuario";
        $rs = $con->prepare($sql);
        $rs->bindParam(":id_veiculo", $_POST["id"]);
        $rs->bindParam(":id_usuario", $_SESSION["id_usuario"]);
        $rs->execute();
    }

}
?>