<?php

class Banco extends Modelo {
    protected $idBanco;
    protected $idPessoaProprietario;
    protected $codigo;
    protected $descricao;
    protected $logo;
    
    public function getCodigo() {
        return $this->codigo;
    }    
    
    public function getCadastrados() {
        $sql = "select idBanco, concat(codigo, ' - ', descricao) as descricao from banco order by descricao";
        $consulta = new Consulta(Conf::pegCnxPadrao(), $sql);
        return $consulta->getResultados();
    }
    
    public function getBanco() {                     
        $sql = 'select * from banco where idBanco = :idBanco and idPessoaProprietario=:idPessoaProprietario';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idBanco", $this->idBanco);
        $consulta->liga("idPessoaProprietario", $_SESSION['idPessoaProprietario']);
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
        }
    }
    
    /**
     * Este metodo consulta os clientes de um determinado dono do dacadastro
     * @param idPessoaProprietario
     */
    public function getConsultarBancos() {
        $criterio  = (empty ($this->codigo)) ? '' : " or codigo = :codigo" ;
        $criterio .= (empty ($this->descricao)) ? '' : " or descricao like :descricao" ;        
        
        $sql = 'select * from banco where (idPessoaProprietario=:idPessoaProprietario or idPessoaProprietario is null)';
        
        if (empty ($criterio)) {
            $sql .= '  order by idbanco desc limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (idBanco is null ".$criterio.") order by descricao";
        }
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);        
        
        if (!empty ($criterio)) {
            if (!empty ($this->codigo)) {
                $consulta->liga("codigo", $this->codigo);
            }
            if (!empty ($this->descricao)) {
                $consulta->liga("descricao", $this->descricao.'%');
            }            
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function getIdBanco() {
        return $this->idBanco;
    }

    public function getIdPessoaProprietario() {
        return $this->idPessoaProprietario;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getLogo() {
        return $this->logo;
    }

    public function setIdBanco($idBanco) {
        $this->idBanco = $idBanco;
    }

    public function setIdPessoaProprietario($idPessoaProprietario) {
        $this->idPessoaProprietario = $idPessoaProprietario;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setLogo($logo) {
        $this->logo = $logo;
    }
    
    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function getTabela(){
        return "banco";
    }

}

?>
