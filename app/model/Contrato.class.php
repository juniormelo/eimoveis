<?php

class Contrato extends Modelo {
    protected $idContrato;
    protected $idPessoa;
    protected $idTipo;
    protected $idImovel;
    protected $dataContrato;
    protected $dataInicio;
    protected $dataFim;
    protected $parcelas;
    protected $valor;
    protected $juros;
    protected $multa;
    protected $desconto;
    protected $valorTotal;
    
    public function getTabela(){
        return "contrato";
    }
    
    public function getIdContrato() {
        return $this->idContrato;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getIdTipo() {
        return $this->idTipo;
    }

    public function getIdImovel() {
        return $this->idImovel;
    }

    public function getDataContrato() {
        return $this->dataContrato;
    }

    public function getDataInicio() {
        return $this->dataInicio;
    }

    public function getDataFim() {
        return $this->dataFim;
    }

    public function getParcelas() {
        return $this->parcelas;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getJuros() {
        return $this->juros;
    }

    public function getMulta() {
        return $this->multa;
    }

    public function getDesconto() {
        return $this->desconto;
    }

    public function getValorTotal() {
        return $this->valorTotal;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    public function setIdImovel($idImovel) {
        $this->idImovel = $idImovel;
    }

    public function setDataContrato($dataContrato) {
        $this->dataContrato = $dataContrato;
    }

    public function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    public function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    public function setParcelas($parcelas) {
        $this->parcelas = $parcelas;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setJuros($juros) {
        $this->juros = $juros;
    }

    public function setMulta($multa) {
        $this->multa = $multa;
    }

    public function setDesconto($desconto) {
        $this->desconto = $desconto;
    }

    public function setValorTotal($valorTotal) {
        $this->valorTotal = $valorTotal;
    }    
}

?>
