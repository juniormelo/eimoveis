<?php

class OfertaEmprego extends Modelo {
    protected $idOferta;
    protected $idPessoa;
    protected $escricao;
    protected $dataOferta;
    protected $dataLimiteOferta;
    protected $bloqueada;
    
    public function getTabela(){
        return "ofertaemprego";
    }
    
    public function getIdOferta() {
        return $this->idOferta;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getEscricao() {
        return $this->escricao;
    }

    public function getDataOferta() {
        return $this->dataOferta;
    }

    public function getDataLimiteOferta() {
        return $this->dataLimiteOferta;
    }

    public function getBloqueada() {
        return $this->bloqueada;
    }

    public function setIdOferta($idOferta) {
        $this->idOferta = $idOferta;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setEscricao($escricao) {
        $this->escricao = $escricao;
    }

    public function setDataOferta($dataOferta) {
        $this->dataOferta = $dataOferta;
    }

    public function setDataLimiteOferta($dataLimiteOferta) {
        $this->dataLimiteOferta = $dataLimiteOferta;
    }

    public function setBloqueada($bloqueada) {
        $this->bloqueada = $bloqueada;
    }

}

?>
