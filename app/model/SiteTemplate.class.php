<?php

class SiteTemplate extends Modelo {
    protected $idTemplate;
    protected $nome;
    protected $tipo;
    protected $ativo;
    
    public function getTabela(){
        return "sitetemplate";
    }
    
    public function getIdTemplate() {
        return $this->idTemplate;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function setIdTemplate($idTemplate) {
        $this->idTemplate = $idTemplate;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }
}

?>
