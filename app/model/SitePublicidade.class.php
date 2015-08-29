<?php

class SitePublicidade extends Modelo {
    protected $idPublidade;
    protected $idPessoa;
    protected $nivel;
    protected $bloqueado;
    
    public function getTabela(){
        return "siteparceiro";
    }
    
    public function getIdPublidade() {
        return $this->idPublidade;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getNivel() {
        return $this->nivel;
    }

    public function getBloqueado() {
        return $this->bloqueado;
    }

    public function setIdPublidade($idPublidade) {
        $this->idPublidade = $idPublidade;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    public function setBloqueado($bloqueado) {
        $this->bloqueado = $bloqueado;
    }

}

?>
