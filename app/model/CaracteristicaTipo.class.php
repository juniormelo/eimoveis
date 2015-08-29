<?php

class CaracteristicaTipo extends Modelo {
    protected $idCaracteristica;
    protected $descricao;
    
    public function getTabela(){
        return "imovelcaracteristicatipo";
    }
    
    public function getIdCaracteristica() {
        return $this->idCaracteristica;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdCaracteristica($idCaracteristica) {
        $this->idCaracteristica = $idCaracteristica;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

}

?>
