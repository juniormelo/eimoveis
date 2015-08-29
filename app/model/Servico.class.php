<?php

class Servico extends Modelo {
    protected $idServico;
    protected $idGrupo;
    protected $idPessoa;
    protected $descricao;
    protected $observacao;
    protected $link;
    protected $ativo;
    
    public function getTabela(){
        return "servico";
    }
    
    public function getIdServico() {
        return $this->idServico;
    }

    public function getIdGrupo() {
        return $this->idGrupo;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function getLink() {
        return $this->link;
    }

    public function getAtivo() {
        return $this->ativo;
    }

    public function setIdServico($idServico) {
        $this->idServico = $idServico;
    }

    public function setIdGrupo($idGrupo) {
        $this->idGrupo = $idGrupo;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function setAtivo($ativo) {
        $this->ativo = $ativo;
    }
    
}

?>
