<?php

class PessoaPlano extends Modelo {
    protected $idPessoaPlano;
    protected $idPessoa;
    protected $idPlano;
    protected $dataAquisicao;
    protected $dataConsolidacao;
    
    public function getTabela(){
        return "pessoaplano";
    }
    
    public function getIdPessoaPlano() {
        return $this->idPessoaPlano;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getIdPlano() {
        return $this->idPlano;
    }

    public function getDataAquisicao() {
        return $this->dataAquisicao;
    }

    public function getDataConsolidacao() {
        return $this->dataConsolidacao;
    }

    public function setIdPessoaPlano($idPessoaPlano) {
        $this->idPessoaPlano = $idPessoaPlano;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setIdPlano($idPlano) {
        $this->idPlano = $idPlano;
    }

    public function setDataAquisicao($dataAquisicao) {
        $this->dataAquisicao = $dataAquisicao;
    }

    public function setDataConsolidacao($dataConsolidacao) {
        $this->dataConsolidacao = $dataConsolidacao;
    } 
}

?>
