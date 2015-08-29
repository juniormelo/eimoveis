<?php

class Contato extends Modelo {
    protected $idContato;
    protected $idPessoa;
    protected $idTipo;
    protected $descricao;
    
    public function getTabela(){
        return "contato";
    }
    
    public function getIdContato() {
        return $this->idContato;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getIdTipo() {
        return $this->idTipo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdContato($idContato) {
        $this->idContato = $idContato;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}

?>
