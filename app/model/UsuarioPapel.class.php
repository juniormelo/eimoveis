<?php

class UsuarioPapel extends Modelo {
    protected $idPapel;
    protected $idPessoaProprietario;
    protected $papel;
    
    public function getTabela(){
        return "usuariopapel";
    }
    
    public function consultar() {
        $criterio = (empty ($this->papel)) ? '' : " or papel like :papel" ;
        
        $sql = 'select idpapel, idpessoaproprietario, codigo, papel from usuariopapel '.
                'where idpessoaproprietario = :idPessoaProprietario';
        
        if (empty ($criterio)) {
            $sql .= ' order by idpapel desc limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (idpapel is null ".$criterio.") order by papel";
        }
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        
        if (!empty ($criterio)) {
            if (!empty ($this->papel)) {
                $consulta->liga("papel", $this->papel.'%');
            }            
        }
        
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function getCadastrados() {
        $sql = "select idPapel, papel from usuariopapel where idpessoaproprietario = :idPessoaProprietario";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);        
        return $consulta->getResultados();
        
        //return new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
    }
    
    public function excluir() {
        $sql = "delete from usuariopapel where idpapel = :idpapel and idpessoaproprietario = :idPessoaProprietario and codigo <> 'adm'";
        $delete = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $delete->liga("idpapel", $this->idPapel);
        $delete->liga("idPessoaProprietario", $this->idPessoaProprietario);        
        $delete->executa();        
    }
    
    public function preecheObjetoVerificaAdm() {
        $sql = 'select idpapel, papel from usuariopapel '.
                'where idpapel = :idpapel and idpessoaproprietario = :idPessoaProprietario and codigo <> :codigo ';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idpapel", $this->idPapel);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        $consulta->liga("codigo", 'adm');
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
        }
    }
    
    public function preecheObjeto() {
        $sql = 'select idpapel, papel from usuariopapel '.
                'where idpapel = :idpapel and idpessoaproprietario = :idPessoaProprietario';        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idpapel", $this->idPapel);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
        }
    }

    public function getIdPapel() {
        return $this->idPapel;
    }

    public function getPapel() {
        return $this->papel;
    }

    public function setIdPapel($idPapel) {
        $this->idPapel = (int) $idPapel;
    }

    public function setPapel($papel) {
        $this->papel = $papel;
    }
    
    function getIdPessoaProprietario() {
        return $this->idPessoaProprietario;
    }

    function setIdPessoaProprietario($idPessoaProprietario) {
        $this->idPessoaProprietario = (int) $idPessoaProprietario;
    }

}

?>
