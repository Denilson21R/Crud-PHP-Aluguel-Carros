<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/model/Usuario.php";

class ControllerUsuario{
    public function __construct(){
    }

    public function Login(){
        if(!empty($_POST["login"]) && !empty($_POST["senha"])){
            $usuario = new Usuario($_POST["login"],$_POST["senha"]);
            $id = $usuario->verificaUsuario();
            if(!empty($id)){
                $usuario->setId($id);
                $_SESSION["id_usuario"] = $usuario->getId();
                $_SESSION["login_usuario"] = $usuario->getLogin();
            }
        }
    }

    public function Sair(){
        unset($_SESSION["id_usuario"]);
        unset($_SESSION["login_usuario"]);
    }

    public function Cadastrar(){
        if(!empty($_POST["login-cadastro"]) && !empty($_REQUEST["senha-cadastro"])){
            $usuario = new Usuario($_POST["login-cadastro"],$_POST["senha-cadastro"]);
            $id = $usuario->verificaUsuario();
            if(empty($id)){
                $usuario->Cadastrar();
            }else{
                echo $id;
            }
        }
    }
}
