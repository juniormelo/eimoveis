<?php

class OfertaCandidato extends Modelo {
    protected $idOfertaCandidato;
    protected $idOferta;
    protected $idPessoa;
    protected $dataCadOferta;
    
    public function getTabela(){
        return "ofertacandidato";
    }
    
    public function getIdOfertaCandidato() {
        return $this->idOfertaCandidato;
    }

    public function getIdOferta() {
        return $this->idOferta;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getDataCadOferta() {
        return $this->dataCadOferta;
    }

    public function setIdOfertaCandidato($idOfertaCandidato) {
        $this->idOfertaCandidato = $idOfertaCandidato;
    }

    public function setIdOferta($idOferta) {
        $this->idOferta = $idOferta;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setDataCadOferta($dataCadOferta) {
        $this->dataCadOferta = $dataCadOferta;
    }    
}

?>
