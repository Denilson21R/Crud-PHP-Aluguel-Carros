<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/aluguel_carros/model/Aluguel.php";

class ControllerAluguel{

    public function __construct(){
    }

    public function addAluguel(){
        $aluguel = Aluguel::addAluguel();
    }

    public function inativaAluguel(){
        $aluguel = Aluguel::inativaAluguel();
    }
    
}