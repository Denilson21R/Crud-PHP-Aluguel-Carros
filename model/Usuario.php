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
        $senha = base64_encode($this->senha);
        $ini_array = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/config.php.ini");
        $str_db = 'mysql:host='.$ini_array["host"].';dbname='.$ini_array["db"];
        $con = new PDO($str_db, $ini_array["user"], $ini_array["senha"]);
        $sql = "SELECT id FROM usuario WHERE login = :login AND senha = :senha";
        $rs = $con->prepare($sql);
        $rs->bindParam(":login", $this->login);
        $rs->bindParam(":senha", $senha);
        if($rs->execute()){
            if($rs->rowCount() === 1){
                while($row = $rs->fetch(PDO::FETCH_OBJ)){
                    return $row->id;
                }
            }
        }
    }

    public function Cadastrar(){
        $senha = base64_encode($this->senha);
        $ini_array = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/config.php.ini");
        $str_db = 'mysql:host='.$ini_array["host"].';dbname='.$ini_array["db"];
        $con = new PDO($str_db, $ini_array["user"], $ini_array["senha"]);
        $sql = "INSERT INTO usuario (login, senha) VALUES (:login, :senha)";
        $rs = $con->prepare($sql);
        $rs->bindParam(":login", $this->login);
        $rs->bindParam(":senha", $senha);
        $rs->execute();
    }
}
?>