<?php

class Acesso extends Modelo {
    protected $idAcesso;
    protected $modulo;
    protected $acesso;
    protected $descricao;
    protected $observacao;
    
    public function getTabela(){
        return "acesso";
    }       
    
    function getIdAcesso() {
        return $this->idAcesso;
    }

    function getModulo() {
        return $this->modulo;
    }

    function getAcesso() {
        return $this->acesso;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getObservacao() {
        return $this->observacao;
    }

    function setIdAcesso($idAcesso) {
        $this->idAcesso = $idAcesso;
    }

    function setModulo($modulo) {
        $this->modulo = $modulo;
    }

    function setAcesso($acesso) {
        $this->acesso = $acesso;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setObservacao($observacao) {
        $this->observacao = $observacao;
    }


}

?>
