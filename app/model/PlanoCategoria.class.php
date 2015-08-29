<?php

class PlanoCategoria extends Modelo {
    protected $idCategoria;
    protected $descricao;
    
    public function getTabela(){
        return "planocategoria";
    }
    
    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

}

?>
