<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/model/Veiculo.php";

class ControllerVeiculo{

    public function __construct(){
    }

    public function getVeiculos(){
        $veiculos = Veiculo::getVeiculos();
        return $veiculos;
    }

    public function addVeiculo(){
        $veiculo = new Veiculo($_POST["nomeVeiculo"],0);
        $veiculo->addVeiculo($veiculo);
    }

    public function excluirVeiculo(){
        $veiculos = Veiculo::excluirVeiculo();
        return $veiculos;
    }

    public function editVeiculo(){
        $veiculos = Veiculo::editVeiculo();
    }

    public function alugarVeiculo(){
        $veiculos = Veiculo::alugarVeiculo();
    }

    public function devolveVeiculo(){
        $veiculos = Veiculo::devolveVeiculo();
    }
}