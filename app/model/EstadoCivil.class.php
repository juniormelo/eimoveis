<?php

class EstadoCivil extends Modelo {
    protected $idEstadoCivil;
    protected $descricao;
    
    public function getTabela(){
        return "estadocivil";
    }
    
    public function getIdEstadoCivil() {
        return $this->idEstadoCivil;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdEstadoCivil($idEstadoCivil) {
        $this->idEstadoCivil = $idEstadoCivil;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function getCadastrados() {
        $sql = "select idEstadoCivil, descricao from estadocivil order by descricao";
        $consulta = new Consulta(Conf::pegCnxPadrao(), $sql);
        return $consulta->getResultados();
    }
    
    public function consultar() {
        $criterio  = (empty ($this->descricao)) ? '' : " descricao like :descricao";        
        $sql = "select idEstadoCivil,descricao from estadocivil";
        $sql .= (empty ($criterio)) ? ' order by descricao limit '.Conf::$PAGINACAO : ' where '.$criterio.' order by descricao';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        if ((!empty ($criterio)) && (!empty ($this->descricao))) {
            $consulta->liga("descricao", $this->descricao.'%');
        }
        return $this->transformaEmArray($consulta->getResultados());
    }

}

?>
