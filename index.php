<?php
//router
session_start();
$path = $_SERVER["REQUEST_URI"];

include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/controller/ControllerVeiculo.php";
$ControllerVeiculo = new ControllerVeiculo();
include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/controller/ControllerAluguel.php";
$ControllerAluguel = new ControllerAluguel();
include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/controller/Controllerusuario.php";
$ControllerUsuario = new ControllerUsuario();

if(empty($_SESSION["path"])){
    $_SESSION["path"] = $path;
}

switch($path){
    case "/aluguel_carros/":
        include_once($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/view/viewLogin.php");
        break;
    case "/aluguel_carros/home/":
        include_once($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/view/viewAlugueis.php");
        break;
    case "/aluguel_carros/home/addVeiculo":
        if(!empty($_POST["nomeVeiculo"])){
            $ControllerVeiculo->addVeiculo();
        }
        break;
    case "/aluguel_carros/home/excluirVeiculo":
        if(!empty($_POST["id"])){
            $ControllerVeiculo->excluirVeiculo();
        }
        break;
    case "/aluguel_carros/home/updateVeiculo":
        if(!empty($_POST["id_veiculo_edit"]) && !empty($_POST["nome_veiculo_edit"])){
            $ControllerVeiculo->editVeiculo();
        }
        break;
    case "/aluguel_carros/home/alugarVeiculo":
        if(!empty($_POST["id"])){
            $ControllerVeiculo->alugarVeiculo();
            $ControllerAluguel->addAluguel();
        }
        break;
    case "/aluguel_carros/home/devolverVeiculo":
        if(!empty($_POST["id"])){
            $ControllerVeiculo->devolveVeiculo();
            $ControllerAluguel->inativaAluguel();
        }
        break;
    case "/aluguel_carros/login":
        $ControllerUsuario->Login();
        break;
    case "/aluguel_carros/home/sair":
        $ControllerUsuario->Sair();
        break;
    case "/aluguel_carros/cadastro":
        $ControllerUsuario->Cadastrar();
        break;
    default:
        include_once($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/view/view404.php");
        break;
}