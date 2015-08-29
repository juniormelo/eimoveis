<?php

class SiteParceiro  extends Modelo {
    protected $idParceiro;
    protected $idPessoa;
    protected $dataParceria;
    protected $bloqueado;
    
    public function getTabela(){
        return "siteparceiro";
    }
    
    public function getIdParceiro() {
        return $this->idParceiro;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getDataParceria() {
        return $this->dataParceria;
    }

    public function getBloqueado() {
        return $this->bloqueado;
    }

    public function setIdParceiro($idParceiro) {
        $this->idParceiro = $idParceiro;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setDataParceria($dataParceria) {
        $this->dataParceria = $dataParceria;
    }

    public function setBloqueado($bloqueado) {
        $this->bloqueado = $bloqueado;
    }

}

?>
