<?php

class Pais extends Modelo {
    protected $idPais;
    protected $nome;
    protected $sigla;
    
    public function getTabela(){
        return "endpais";
    }
    
    public function getIdPais() {
        return $this->idPais;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getSigla() {
        return $this->sigla;
    }

    public function setIdPais($idPais) {
        $this->idPais = $idPais;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setSigla($sigla) {
        $this->sigla = $sigla;
    }    
}

?>
