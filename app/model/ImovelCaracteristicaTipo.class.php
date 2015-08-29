<?php

class ImovelCaracteristicaTipo extends Modelo {
    protected $idCaracteristica;
    protected $descricao;
    
    public function getTabela(){
        return "imovelcaracteristicatipo";
    }
    
    public function getIdCaracteristica() {
        return $this->idCaracteristica;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdCaracteristica($idCaracteristica) {
        $this->idCaracteristica = $idCaracteristica;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function getCadastradas() {
        $sql = "select idCaracteristica, descricao from imovelcaracteristicatipo order by descricao";
        $consulta = new Consulta(Conf::pegCnxPadrao(), $sql);
        return $consulta->getResultados();
    }
    
    public function consultar() {
        $criterio  = (empty ($this->descricao)) ? '' : " descricao like :descricao";        
        $sql = "select idCaracteristica,descricao from imovelcaracteristicatipo";
        $sql .= (empty ($criterio)) ? ' order by descricao limit '.Conf::$PAGINACAO : ' where '.$criterio.' order by descricao';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        if ((!empty ($criterio)) && (!empty ($this->descricao))) {
            $consulta->liga("descricao", $this->descricao.'%');
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
    
}

?>
