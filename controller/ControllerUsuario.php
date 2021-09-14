<?php
session_start();
include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/model/Usuario.php";

$action = $_POST["action"];
switch ($action) {
    case "login":
        if(!empty($_POST["login"]) && !empty($_POST["senha"])){
            $usuario = new Usuario($_POST["login"],$_POST["senha"]);
            $id = $usuario->verificaUsuario();
            if(!empty($id)){
                $usuario->setId($id);
                $_SESSION["id_usuario"] = $usuario->getId();
                $_SESSION["login_usuario"] = $usuario->getLogin();
                echo true;
            }else{
                echo null;
            }
        }
        break;
    case "logoff":
        unset($_SESSION["id_usuario"]);
        unset($_SESSION["login_usuario"]);
        echo true;
        break;
    case "cadastro":
        if(!empty($_POST["login-cadastro"]) && !empty($_REQUEST["senha-cadastro"])){
            $usuario = new Usuario($_POST["login-cadastro"],$_POST["senha-cadastro"]);
            $id = $usuario->verificaUsuario();
            if(empty($id)){
                $usuario->Cadastrar();
            }else{
                echo $id;
            }
        }
        break;
}