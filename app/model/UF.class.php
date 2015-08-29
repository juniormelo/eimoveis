<?php

class Uf extends Modelo {
    protected $idUf;
    protected $nome;
    protected $sigla;
    protected $idPais;
    
    public function getTabela(){
        return "enduf";
    }
    
    public function getIdUf() {
        return $this->idUf;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getSigla() {
        return $this->sigla;
    }

    public function getIdPais() {
        return $this->idPais;
    }

    public function setIdUf($idUf) {
        $this->idUf = $idUf;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setSigla($sigla) {
        $this->sigla = $sigla;
    }

    public function setIdPais($idPais) {
        $this->idPais = $idPais;
    }

}

?>
