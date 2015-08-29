<?php

class TipoLog extends Modelo {
    protected $idTipoLog;
    protected $descricao;
    
    public function getTabela(){
        return "tipolog";
    }
    
    public function getIdTipoLog() {
        return $this->idTipoLog;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdTipoLog($idTipoLog) {
        $this->idTipoLog = $idTipoLog;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

}

?>
