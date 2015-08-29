<?php

class ImovelCaracteristica extends Modelo {
    protected $idImovelCaracteristica;
    protected $idImovel;
    protected $idCaracteristica;    
    protected $descricao;

    public function getTabela(){
        return "imovelcaracteristica";
    }

    public function getIdImovelCaracteristica() {
        return $this->idImovelCaracteristica;
    }

    public function getIdImovel() {
        return $this->idImovel;
    }

    public function getIdCaracteristica() {
        return $this->idCaracteristica;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdImovelCaracteristica($idImovelCaracteristica) {
        $this->idImovelCaracteristica = $idImovelCaracteristica;
    }

    public function setIdImovel($idImovel) {
        $this->idImovel = $idImovel;
    }

    public function setIdCaracteristica($idCaracteristica) {
        $this->idCaracteristica = $idCaracteristica;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }
    
    public function getCaracteristicas() {
        $sql = 'SELECT imovelcaracteristica.idImovelCaracteristica,imovelcaracteristica.idCaracteristica,
               imovelcaracteristicatipo.descricao AS `caracteristica`,imovelcaracteristica.descricao FROM 
               imovelcaracteristica INNER JOIN imovel ON imovelcaracteristica.idImovel = imovel.idImovel 
               INNER JOIN imovelcaracteristicatipo ON imovelcaracteristica.idCaracteristica = 
               imovelcaracteristicatipo.idCaracteristica WHERE imovelcaracteristica.idImovel = '.$this->idImovel;
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idImovel", $this->idImovel);        
        return $consulta->getResultados();
    }
    
    public function excluirCaracteristicasDoImovel() {
        $sql = 'delete from imovelcaracteristica where idImovel=:idImovel';        
        $delete = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $delete->liga("idImovel", $this->idImovel);
        $delete->executa();
    }

}

?>