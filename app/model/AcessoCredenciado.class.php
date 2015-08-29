<?php

class AcessoCredenciado extends Modelo {
    protected $idAcessoCredenciado;
    protected $idPessoaCredenciado;
    protected $idAcesso;
    protected $liberado;
    
    public function getTabela(){
        return "acessocredenciado";
    }

    public function bloquear() {
        $sql = "update acessocredenciado set liberado = 'N' where idPessoaCredenciado = :idPessoaCredenciado";
        $bloqueio = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $bloqueio->liga("idPessoaCredenciado", $this->idPessoaCredenciado);
        $bloqueio->executa();
    }
    
    public function liberar($modulos) {
        if (sizeof($modulos) > 0) {
            $this->idPessoaCredenciado = $modulos['idCredenciado'];
            $this->bloquear();
            $sql = ''; 
            if (count($modulos) > 1) {                
                foreach ($modulos['modulo'] as $modulo) {
                    $sql .= "update acessocredenciado ac inner join acesso c on ".
                           "ac.idAcesso = c.idAcesso set ac.liberado = 'S' where ".
                           "ac.idPessoaCredenciado = {$this->idPessoaCredenciado} ".
                           "and c.modulo = '{$modulo}'; ";
                }
                
                if (!empty($sql)) {
                    /*permissões do grupo*/
                    $sql .= "insert into usuariopapelpermissao (idPapel, idAcessoCredenciado, permitido) ".
                           "(select (select idPapel from usuario where idPessoa={$this->idPessoaCredenciado}), ".
                           "idAcessoCredenciado, 'S' from acessocredenciado as ac ".
                           "where ac.idPessoaCredenciado = {$this->idPessoaCredenciado} ".
                           "and ac.idAcessoCredenciado not in (select distinct upp.idAcessoCredenciado ".
		           "from usuariopapelpermissao as upp where upp.idPapel = ".
                           "(select u.idPapel from usuario as u where u.idPessoa={$this->idPessoaCredenciado}))); ";
                    
                    $sql .= "delete from usuariopermissao where idUsuario = (select idUsuario from usuario where idPessoa = {$this->idPessoaCredenciado}); ";
                    
                    /*permissoes do usuario*/
                    $sql .= "insert into usuariopermissao (idUsuario, idPapelPermissao, permitido) ".
                            "(select distinct (select idUsuario from usuario where idPessoa = {$this->idPessoaCredenciado}), ".
                            "idPapelPermissao, 'S' from usuariopapelpermissao); ";

                    $liberar = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
                    $liberar->executa();
                    unset($liberar);
                }
                                
            }
        }    
    }
    
    public function getModulos() {
        $sql = "select distinct a.modulo from acesso a inner join ".
               "acessocredenciado ac on a.idAcesso = ac.idAcesso ".
               "where ac.idPessoaCredenciado = :idPessoaCredenciado ".
               "and coalesce(ac.liberado,'N') = 'S'";
        $modulos = new ConsultaPreparado(Conf::pegCnxPadrao(), $sql);
        $modulos->liga("idPessoaCredenciado", $this->idPessoaCredenciado);
        return $modulos->getResultados(); 
    }
            
    function getIdAcessoCredenciado() {
        return $this->idAcessoCredenciado;
    }

    function getIdPessoaCredenciado() {
        return $this->idPessoaCredenciado;
    }

    function getIdAcesso() {
        return $this->idAcesso;
    }

    function getLiberado() {
        return $this->liberado;
    }

    function setIdAcessoCredenciado($idAcessoCredenciado) {
        $this->idAcessoCredenciado = $idAcessoCredenciado;
    }

    function setIdPessoaCredenciado($idPessoaCredenciado) {
        $this->idPessoaCredenciado = $idPessoaCredenciado;
    }

    function setIdAcesso($idAcesso) {
        $this->idAcesso = $idAcesso;
    }

    function setLiberado($liberado) {
        $this->liberado = $liberado;
    }


    
}

?>