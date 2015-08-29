<?php

class AnuncioTipo extends Modelo {
    protected $idTipo;
    protected $descricao;
    
    public function getTabela(){
        return "anunciotipo";
    }
    
    public function getIdTipo() {
        return $this->idTipo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function getCadastrados() {        
        $sql = "select idTipo,descricao from anunciotipo order by descricao";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        return $consulta->getResultados();
    }
    
    public function consultar() {
        $criterio  = (empty ($this->descricao)) ? '' : " descricao like :descricao";        
        $sql = "select idTipo,descricao from anunciotipo";
        $sql .= (empty ($criterio)) ? ' order by descricao limit '.Conf::$PAGINACAO : ' where '.$criterio.' order by descricao';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        if ((!empty ($criterio)) && (!empty ($this->descricao))) {
            $consulta->liga("descricao", $this->descricao.'%');
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
    
}

?>
