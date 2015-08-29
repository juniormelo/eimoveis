<?php

class Cidade extends Modelo {
    protected $idCidade;
    protected $nome;
    protected $idUf;
    
    public function getTabela(){
        return "endcidade";
    }
    
    public function getIdCidade() {
        return $this->idCidade;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getIdUf() {
        return $this->idUf;
    }

    public function setIdCidade($idCidade) {
        $this->idCidade = $idCidade;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setIdUf($idUf) {
        $this->idUf = $idUf;
    }
}

?>
