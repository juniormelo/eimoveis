<?php

class PlanoDeConta extends Modelo {
    protected $idPlanoConta;
    protected $idPessoaProprietario;
    protected $tipo;
    protected $codigo;
    protected $descricao;
        
    public function getTabela(){
        return "planodeconta";
    }  
    
    public function getCadastrados() {
        $sql = "select idPlanoConta, concat(codigo, ' - ', descricao) as descricao from planodeconta order by descricao";
        $consulta = new Consulta(Conf::pegCnxPadrao(), $sql);
        return $consulta->getResultados();
    }
    
    public function getDados() {                     
        $sql = 'select * from planodeconta where idPlanoConta = :idPlanoConta and (idPessoaProprietario=:idPessoaProprietario or idPessoaProprietario is null)';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPlanoConta", $this->idPlanoConta);
        $consulta->liga("idPessoaProprietario", $_SESSION['idPessoaProprietario']);
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
        }
    }
    
    /**
     * Este metodo consulta os clientes de um determinado dono do dacadastro
     * @param idPessoaProprietario
     */
    public function getConsultarPlanos() {
        $criterio  = (empty ($this->codigo)) ? '' : " or codigo = :codigo" ;
        $criterio .= (empty ($this->descricao)) ? '' : " or descricao like :descricao" ;        
        
        $sql = 'select * from planodeconta where (idPessoaProprietario=:idPessoaProprietario or idPessoaProprietario is null)';
        
        if (empty ($criterio)) {
            $sql .= '  order by idPlanoConta desc limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (idPlanoConta is null ".$criterio.") order by descricao";
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
    
    public function getIdPlanoConta() {
        return $this->idPlanoConta;
    }

    public function getIdPessoaProprietario() {
        return $this->idPessoaProprietario;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdPlanoConta($idPlanoConta) {
        $this->idPlanoConta = $idPlanoConta;
    }

    public function setIdPessoaProprietario($idPessoaProprietario) {
        $this->idPessoaProprietario = $idPessoaProprietario;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}

?>
