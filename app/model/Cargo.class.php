<?php

class Cargo extends Modelo {
    protected $idCargo;
    protected $descricao;
    
    public function getCadastrados() {
        $consulta = new Consulta(Conf::pegCnxPadrao(), 'select idCargo,descricao from cargo order by descricao');
        return $consulta->getResultados();
    }
    
    public function consultar() {
        $criterio  = (empty ($this->descricao)) ? '' : " descricao like :descricao";        
        $sql = "select idCargo,descricao from cargo";
        $sql .= (empty ($criterio)) ? ' order by descricao limit '.Conf::$PAGINACAO : ' where '.$criterio.' order by descricao';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        if ((!empty ($criterio)) && (!empty ($this->descricao))) {
            $consulta->liga("descricao", $this->descricao.'%');
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function getTabela(){
        return "cargo";
    }
    
    public function getIdCargo() {
        return $this->idCargo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdCargo($idCargo) {
        $this->idCargo = $idCargo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
}

?>
