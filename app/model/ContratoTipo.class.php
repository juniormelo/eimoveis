<?php

class ContratoTipo extends Modelo {
    protected $idContratoTipo;
    protected $descricao;
    protected $receita;
    
    public function getTabela(){
        return "contratotipo";
    }
    
    public function getIdContratoTipo() {
        return $this->idContratoTipo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getReceita() {
        return $this->receita;
    }

    public function setIdContratoTipo($idContratoTipo) {
        $this->idContratoTipo = $idContratoTipo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setReceita($receita) {
        $this->receita = $receita;
    }    
}

?>
