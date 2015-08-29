<?php

class FormasPagto extends Modelo {
    protected $idFormaPagto;
    protected $idPessoaProprietario;
    protected $descricao;
    
    public function getTabela(){
        return "formaspagto";
    }
    
    public function getIdFormaPagto() {
        return $this->idFormaPagto;
    }

    public function getIdPessoaProprietario() {
        return $this->idPessoaProprietario;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdFormaPagto($idFormaPagto) {
        $this->idFormaPagto = $idFormaPagto;
    }

    public function setIdPessoaProprietario($idPessoaProprietario) {
        $this->idPessoaProprietario = $idPessoaProprietario;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
}

?>
