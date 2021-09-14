<?php
class Veiculo
{
    private $nome;
    private $id;
    private $alugado;

    public function __construct($nome, $alugado){
        $this->nome = $nome;
        $this->alugado = $alugado;
    }

    public function getNome(){
        return $this->nome;
    }

    public function getId(){
        return $this->id;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function setAlugado($alugado){
        $this->alugado = $alugado;
    }

    public function getAlugado($alugado){
        $this->alugado = $alugado;
    }

    public static function getVeiculos(){
        $con = new PDO("mysql:host=localhost;dbname=aluguel_carros", "root", "");
        $sql = "SELECT id, alugado, nome, id_dono, id_usuario as usando FROM veiculo v LEFT JOIN aluguel a ON v.id = a.id_veiculo AND nome is NOT NULL AND a.status = '1' ORDER BY id";
        $rs = $con->prepare($sql);
        if($rs->execute()){
            if($rs->rowCount() > 0){
                return($rs->fetchAll());
            }
        }
    }

    public function addVeiculo($veiculo){
        $nome = $veiculo->getNome();
        $con = new PDO("mysql:host=localhost;dbname=aluguel_carros", "root", "");
        $sql = "INSERT INTO veiculo (nome, alugado, id_dono) VALUES (:nome, 0, :dono)";
        $rs = $con->prepare($sql);
        $rs->bindParam(":nome", $nome);
        $rs->bindParam(":dono", $_SESSION["id_usuario"]);
        $rs->execute();
    }

    public static function excluirVeiculo(){
        $con = new PDO("mysql:host=localhost;dbname=aluguel_carros", "root", "");
        $sql = "DELETE FROM veiculo WHERE id = :id";
        $rs = $con->prepare($sql);
        $rs->bindParam(":id", $_POST["id"]);
        $rs->execute();
    }

    public static function editVeiculo(){
        $con = new PDO("mysql:host=localhost;dbname=aluguel_carros", "root", "");
        $sql = "UPDATE veiculo SET nome = :nome WHERE id = :id";
        $rs = $con->prepare($sql);
        $rs->bindParam(":id", $_POST["id_veiculo_edit"]);
        $rs->bindParam(":nome", $_POST["nome_veiculo_edit"]);
        $rs->execute();
    }

    public static function alugarVeiculo(){
        $con = new PDO("mysql:host=localhost;dbname=aluguel_carros", "root", "");
        $sql = "UPDATE veiculo SET alugado = '1' WHERE id = :id";
        $rs = $con->prepare($sql);
        $rs->bindParam(":id", $_POST["id"]);
        $rs->execute();
    }

    public static function devolveVeiculo(){
        $con = new PDO("mysql:host=localhost;dbname=aluguel_carros", "root", "");
        $sql = "UPDATE veiculo SET alugado = '0' WHERE id = :id";
        $rs = $con->prepare($sql);
        $rs->bindParam(":id", $_POST["id"]);
        $rs->execute();
    }
}
?>