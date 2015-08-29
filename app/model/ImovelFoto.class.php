<?php

class ImovelFoto extends Modelo {
    protected $idFoto;
    protected $idImovel;
    protected $ordem;
    protected $descricao;
    protected $foto;
   
    public function getTabela(){
        return "imovelfoto";
    }
    
    public function getIdFoto() {
        return $this->idFoto;
    }

    public function getIdImovel() {
        return $this->idImovel;
    }

    public function getOrdem() {
        return $this->ordem;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setIdFoto($idFoto) {
        $this->idFoto = $idFoto;
    }

    public function setIdImovel($idImovel) {
        $this->idImovel = $idImovel;
    }

    public function setOrdem($ordem) {
        $this->ordem = $ordem;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }
    
    public function excluirFotosDoImovel() {
        $sql = "delete from imovelfoto where idImovel = :idImovel";
        $delete = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $delete->liga("idImovel", $this->idImovel);
        $delete->executa();
    }
    
    public function getFotos() {
        $sql = 'select idFoto,ordem,descricao,foto from imovelfoto where idImovel = :idImovel order by ordem';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idImovel", $this->idImovel);
        return $consulta->getResultados();
    }

}

?>
