<?php

class SitePublicidadeBanner extends Modelo {
    protected $idBanner;
    protected $idPublicidade;
    protected $imagem;
    protected $peso;
    
    public function getTabela(){
        return "sitepublicidadebanner";
    }
    
    public function getIdBanner() {
        return $this->idBanner;
    }

    public function getIdPublicidade() {
        return $this->idPublicidade;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function setIdBanner($idBanner) {
        $this->idBanner = $idBanner;
    }

    public function setIdPublicidade($idPublicidade) {
        $this->idPublicidade = $idPublicidade;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function setPeso($peso) {
        $this->peso = $peso;
    }

}

?>
