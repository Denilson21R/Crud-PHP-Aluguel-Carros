<?php
class Usuario
{
    private $login;
    private $senha;
    private $id;

    public function __construct($login, $senha){
        $this->login = $login;
        $this->senha = $senha;
    }

    public function getLogin(){
        return $this->login;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function getId(){
        return $this->id;
    }

    public function setLogin($login){
        $this->login = $login;
    }

    public function setSenha($senha){
        $this->login = $senha;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function verificaUsuario(){
        $con = new PDO("mysql:host=localhost;dbname=aluguel_carros", "root", "");
        $sql = "SELECT id FROM usuario WHERE login = :login AND senha = :senha";
        $rs = $con->prepare($sql);
        $rs->bindParam(":login", $this->login);
        $rs->bindParam(":senha", $this->senha);
        if($rs->execute()){
            if($rs->rowCount() === 1){
                while($row = $rs->fetch(PDO::FETCH_OBJ)){
                    return $row->id;
                }
            }
        }
    }

    public function Cadastrar(){
        $con = new PDO("mysql:host=localhost;dbname=aluguel_carros", "root", "");
        $sql = "INSERT INTO usuario (login, senha) VALUES (:login, :senha)";
        $rs = $con->prepare($sql);
        $rs->bindParam(":login", $this->login);
        $rs->bindParam(":senha", $this->senha);
        $rs->execute();
    }
}
?>