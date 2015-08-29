<?php

class ImovelFavorito extends Modelo {
    protected $idFavorito;
    protected $idPessoa;
    protected $idAnuncio;
    protected $dataFavorito;
    
    public function getTabela(){
        return "imovelfavorito";
    }
    
    public function getIdFavorito() {
        return $this->idFavorito;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getIdAnuncio() {
        return $this->idAnuncio;
    }

    public function getDataFavorito() {
        return $this->dataFavorito;
    }

    public function setIdFavorito($idFavorito) {
        $this->idFavorito = $idFavorito;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setIdAnuncio($idAnuncio) {
        $this->idAnuncio = $idAnuncio;
    }

    public function setDataFavorito($dataFavorito) {
        $this->dataFavorito = $dataFavorito;
    }
}

?>
