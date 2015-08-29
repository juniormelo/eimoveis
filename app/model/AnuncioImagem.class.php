<?php

class AnuncioImagem extends Modelo {
    protected $idAnuncioImagem;
    protected $idAnuncio;
    protected $ordem;
    protected $descricao;
    protected $imagem;
    
    public function getTabela(){
        return "anuncioimagem";
    }
    
    public function excluirImagensDoAnuncio() {
        $sql = "delete from anuncioimagem where idAnuncio = :idAnuncio";
        $delete = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $delete->liga("idAnuncio", $this->idAnuncio);
        $delete->executa();
    }
            
    function getIdAnuncioImagem() {
        return $this->idAnuncioImagem;
    }

    function getIdAnuncio() {
        return $this->idAnuncio;
    }

    function getOrdem() {
        return $this->ordem;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getImagem() {
        return $this->imagem;
    }

    function setIdAnuncioImagem($idAnuncioImagem) {
        $this->idAnuncioImagem = (int) $idAnuncioImagem;
    }

    function setIdAnuncio($idAnuncio) {
        $this->idAnuncio = (int) $idAnuncio;
    }

    function setOrdem($ordem) {
        $this->ordem = $ordem;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setImagem($imagem) {
        $this->imagem = $imagem;
    }

}

?>

