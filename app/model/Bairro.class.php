<?php

class Bairro extends Modelo {
    protected $idBairro;
    protected $bairro;
    protected $idCidade;
    
    public function getTabela(){
        return "endbairro";
    }
    
    public function getIdBairro() {
        return $this->idBairro;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getIdCidade() {
        return $this->idCidade;
    }

    public function setIdBairro($idBairro) {
        $this->idBairro = $idBairro;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setIdCidade($idCidade) {
        $this->idCidade = $idCidade;
    }
}

?>
