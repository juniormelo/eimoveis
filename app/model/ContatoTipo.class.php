<?php

class ContatoTipo {
    protected $idTipo;
    protected $descricao;
    
    public function getTabela(){
        return "contatotipo";
    }
    
    public function getIdTipo() {
        return $this->idTipo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
}

?>
