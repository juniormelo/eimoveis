<?php

class Logradouro extends Modelo {
    protected $idLogradouro;
    protected $cep;
    protected $logradouro;
    protected $idBairro;
    
    public function getTabela(){
        return "endlogradouro";
    }
    
    public function getIdLogradouro() {
        return $this->idLogradouro;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getIdBairro() {
        return $this->idBairro;
    }

    public function setIdLogradouro($idLogradouro) {
        $this->idLogradouro = $idLogradouro;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    public function setIdBairro($idBairro) {
        $this->idBairro = $idBairro;
    }
}

?>
