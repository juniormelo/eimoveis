<?php

class ServicoGrupo extends Modelo {
    protected $idGrupo;
    protected $descricao;
    
    public function getTabela(){
        return "servicogrupo";
    }
    
    public function getIdGrupo() {
        return $this->idGrupo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdGrupo($idGrupo) {
        $this->idGrupo = $idGrupo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

}

?>
