<?php

class ImovelCategoria extends Modelo {
    protected $idCategoria;
    protected $descricao;
        
    
    public function getTabela(){
        return "imovelcategoria";
    }
    
    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function getCadastradas() {
        $sql = "select idCategoria,descricao from imovelcategoria order by descricao";  
        $consulta = new Consulta(Conf::pegCnxPadrao(), $sql);
        return $consulta->getResultados();
    }
    
    public function consultar() {
        $criterio  = (empty ($this->descricao)) ? '' : " descricao like :descricao";        
        $sql = "select idCategoria,descricao from imovelcategoria";
        $sql .= (empty ($criterio)) ? ' order by descricao limit '.Conf::$PAGINACAO : ' where '.$criterio.' order by descricao';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        if ((!empty ($criterio)) && (!empty ($this->descricao))) {
            $consulta->liga("descricao", $this->descricao.'%');
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
    
}

?>
