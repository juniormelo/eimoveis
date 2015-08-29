<?php

class ImovelProximidadeTipo extends Modelo {
    protected $idProximidade;
    protected $descricao;
    
    public function getTabela(){
        return "imovelproximidadetipo";
    }
    
    public function getIdProximidade() {
        return $this->idProximidade;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdProximidade($idProximidade) {
        $this->idProximidade = $idProximidade;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function getCadastradas() {
        $sql = "select idProximidade, descricao from imovelproximidadetipo order by descricao";
        $consulta = new Consulta(Conf::pegCnxPadrao(), $sql);
        return $consulta->getResultados();
    }
    
    public function consultar() {
        $criterio  = (empty ($this->descricao)) ? '' : " descricao like :descricao";        
        $sql = "select idProximidade,descricao from imovelproximidadetipo";
        $sql .= (empty ($criterio)) ? ' order by descricao limit '.Conf::$PAGINACAO : ' where '.$criterio.' order by descricao';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        if ((!empty ($criterio)) && (!empty ($this->descricao))) {
            $consulta->liga("descricao", $this->descricao.'%');
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
    
}
?>
