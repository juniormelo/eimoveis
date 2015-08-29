<?php

class ImovelProximidade extends Modelo {
    protected $idImovelProximidade;
    protected $idImovel;
    protected $idProximidade;    
    protected $descricao;
    
    public function getTabela(){
        return "imovelproximidade";
    }
    
    public function getIdImovelProximidade() {
        return $this->idImovelProximidade;
    }

    public function getIdImovel() {
        return $this->idImovel;
    }

    public function getIdProximidade() {
        return $this->idProximidade;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setIdImovelProximidade($idImovelProximidade) {
        $this->idImovelProximidade = $idImovelProximidade;
    }

    public function setIdImovel($idImovel) {
        $this->idImovel = $idImovel;
    }

    public function setIdProximidade($idProximidade) {
        $this->idProximidade = $idProximidade;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getProximidades() {
        $sql = 'SELECT imovelproximidade.idImovelProximidade,imovelproximidade.idProximidade,
               imovelproximidadetipo.descricao AS `proximidade`,imovelproximidade.descricao FROM 
               imovelproximidade INNER JOIN imovel ON imovelproximidade.idImovel = imovel.idImovel 
               INNER JOIN imovelproximidadetipo ON imovelproximidade.idProximidade = 
               imovelproximidadetipo.idProximidade WHERE imovelproximidade.idImovel = '.$this->idImovel;
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idImovel", $this->idImovel);
        return $consulta->getResultados();
    }

    public function excluirProximidadesDoImovel() {
        $sql = 'delete from imovelproximidade where idImovel=:idImovel';
        $delete = new ComandoPreparado(Conf::pegCnxPadrao(),$sql);
        $delete->liga("idImovel", $this->idImovel);
        $delete->executa();
    }

}
?>
