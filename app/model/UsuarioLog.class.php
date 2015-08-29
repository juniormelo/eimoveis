<?php

class UsuarioLog extends Modelo {
    protected $idLog;
    protected $idUsuario;
    protected $idTipoLog;
    protected $dataHora;
    
    public function getTabela(){
        return "usuariolog";
    }
    
    public function getIdLog() {
        return $this->idLog;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getIdTipoLog() {
        return $this->idTipoLog;
    }

    public function getDataHora() {
        return $this->dataHora;
    }

    public function setIdLog($idLog) {
        $this->idLog = $idLog;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setIdTipoLog($idTipoLog) {
        $this->idTipoLog = $idTipoLog;
    }

    public function setDataHora($dataHora) {
        $this->dataHora = $dataHora;
    }
    
}

?>
