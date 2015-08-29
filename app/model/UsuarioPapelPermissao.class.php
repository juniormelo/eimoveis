<?php

class UsuarioPapelPermissao extends Modelo {
    protected $idPapelPermissao;
    protected $idPapel;
    protected $idAcessoCredenciado;
    protected $permitido;
    protected $_idPessoaCredenciado;
    
    public function getTabela(){
        return "usuariopapelpermissao";
    }
    
    public function getPermissoes() {       
        $sql = "call sp_papel_get_permissoes(:pIdPessoaCredenciado, :pIdPapel);";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("pIdPessoaCredenciado", (empty ($this->_idPessoaCredenciado)) ? 0 : $this->_idPessoaCredenciado);
        $consulta->liga("pIdPapel", (empty ($this->idPapel)) ? 0 : $this->idPapel);        
        return $consulta->getResultados();        
    }
    
    public function aplicarPermissoes($permissoes) {        
        if (sizeof($permissoes) > 0) {
            $this->idPapel = $permissoes['idPapel'];            
            $this->retirarTodasPermissoes();
            $sql = ''; 
            if (sizeof($permissoes) > 1) {                
                foreach ($permissoes['permissoes'] as $permissao => $valor) {                    
                    $sql .= "update usuariopapelpermissao as upp inner join ".
                           "usuariopapel as up on upp.idPapel = up.idPapel ".
                           "set upp.permitido = 'S' where upp.idPapel = {$this->idPapel} ".
                           "and upp.idAcessoCredenciado = {$valor} ".
                           "and up.idPessoaProprietario = {$this->_idPessoaCredenciado}; ";                    
                }
                if (!empty($sql)) {
                    $liberar = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
                    /*$liberar->liga("idPapel", $this->idPapel);
                    $liberar->liga("idPessoaProprietario", $this->_idPessoaCredenciado);
                    $liberar->liga("idAcessoCredenciado", $valor);*/
                    $liberar->executa();
                    unset($liberar);
                }
            }
        }  
    }
    
    public function retirarTodasPermissoes() {
        $sql = "update usuariopapelpermissao as upp inner join usuariopapel as up ".
               "on upp.idPapel = up.idPapel set upp.permitido = 'N' where ".
               "upp.idPapel = :idPapel and up.idPessoaProprietario = :idPessoaProprietario";
        $bloqueio = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $bloqueio->liga("idPapel", $this->idPapel);
        $bloqueio->liga("idPessoaProprietario", $this->_idPessoaCredenciado);
        $bloqueio->executa();
    }
    
    function getIdPapelPermissao() {
        return $this->idPapelPermissao;
    }

    function getIdPapel() {
        return $this->idPapel;
    }

    function getIdAcessoCredenciado() {
        return $this->idAcessoCredenciado;
    }

    function getPermitido() {
        return $this->permitido;
    }

    function setIdPapelPermissao($idPapelPermissao) {
        $this->idPapelPermissao = $idPapelPermissao;
    }

    function setIdPapel($idPapel) {
        $this->idPapel = (int) $idPapel;
    }

    function setIdAcessoCredenciado($idAcessoCredenciado) {
        $this->idAcessoCredenciado = (int) $idAcessoCredenciado;
    }

    function setPermitido($permitido) {
        $this->permitido = $permitido;
    }
    
    function get_idPessoaCredenciado() {
        return $this->_idPessoaCredenciado;
    }

    function set_idPessoaCredenciado($_idPessoaCredenciado) {
        $this->_idPessoaCredenciado = (int) $_idPessoaCredenciado;
    }

}

?>
