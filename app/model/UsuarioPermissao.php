<?php

class UsuarioPermissao extends Modelo {
    protected $idUsuarioPermissao;
    protected $idUsuario;
    protected $idPapelPermissao;
    protected $permitido;
    
    public function getTabela(){
        return "usuariopermissao";
    }
    
    function getIdUsuarioPermissao() {
        return $this->idUsuarioPermissao;
    }

    function getIdUsuario() {
        return $this->idUsuario;
    }

    function getIdPapelPermissao() {
        return $this->idPapelPermissao;
    }

    function getPermitido() {
        return $this->permitido;
    }

    function setIdUsuarioPermissao($idUsuarioPermissao) {
        $this->idUsuarioPermissao = (int) $idUsuarioPermissao;
    }

    function setIdUsuario($idUsuario) {
        $this->idUsuario = (int) $idUsuario;
    }

    function setIdPapelPermissao($idPapelPermissao) {
        $this->idPapelPermissao = (int) $idPapelPermissao;
    }

    function setPermitido($permitido) {
        $this->permitido = $permitido;
    }
    
}

?>