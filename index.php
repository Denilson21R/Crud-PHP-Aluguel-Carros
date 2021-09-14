<?php
//router
session_start();
$path = $_SERVER["REQUEST_URI"];

include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/controller/ControllerVeiculo.php";
$ControllerVeiculo = new ControllerVeiculo();
include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/controller/ControllerAluguel.php";
$ControllerAluguel = new ControllerAluguel();

if(empty($_SESSION["path"])){
    $_SESSION["path"] = $path;
}
if($path == "/aluguel_carros/"){
    include_once($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/view/viewLogin.php");
}else if($path == "/aluguel_carros/home/"){
    include_once($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/view/viewAlugueis.php");
}else if($path == "/aluguel_carros/home/addVeiculo" && !empty($_POST["nomeVeiculo"])){
    $ControllerVeiculo->addVeiculo();
}else if($path == "/aluguel_carros/home/excluirVeiculo" && !empty($_POST["id"])){
    $ControllerVeiculo->excluirVeiculo();
}else if($path == "/aluguel_carros/home/updateVeiculo" && !empty($_POST["id_veiculo_edit"]) && !empty($_POST["nome_veiculo_edit"])){
    $ControllerVeiculo->editVeiculo();
}else if($path == "/aluguel_carros/home/alugarVeiculo" && !empty($_POST["id"])){
    $ControllerVeiculo->alugarVeiculo();
    $ControllerAluguel->addAluguel();
}else if($path == "/aluguel_carros/home/devolverVeiculo" && !empty($_POST["id"])){
    $ControllerVeiculo->devolveVeiculo();
    $ControllerAluguel->inativaAluguel();
}else{
    include_once($_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/view/view404.php");
}