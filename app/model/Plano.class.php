<?php


class Plano extends Modelo {
    protected $idPlano;
    protected $idCategoria;
    protected $descricao;
    protected $pago;
    protected $qtdAnuncios;
    protected $periodoAnuncio;
    protected $valor;
    
    public function getTabela(){
        return "plano";
    }
    
    public function getIdPlano() {
        return $this->idPlano;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getPago() {
        return $this->pago;
    }

    public function getQtdAnuncios() {
        return $this->qtdAnuncios;
    }

    public function getPeriodoAnuncio() {
        return $this->periodoAnuncio;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setIdPlano($idPlano) {
        $this->idPlano = $idPlano;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setPago($pago) {
        $this->pago = $pago;
    }

    public function setQtdAnuncios($qtdAnuncios) {
        $this->qtdAnuncios = $qtdAnuncios;
    }

    public function setPeriodoAnuncio($periodoAnuncio) {
        $this->periodoAnuncio = $periodoAnuncio;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }
}

?>
