<?php

class ContratoDetalhes extends Modelo {
    protected $idContratoDetalhes;
    protected $idContrato;
    protected $parcela;
    protected $valor;
    protected $juros;
    protected $multa;
    protected $desconto;
    protected $totalPago;
    protected $dataVencimento;
    protected $dataPagamento;
    protected $idFormaPagto;
    
    public function getTabela(){
        return "contratodetalhes";
    }
    
    public function getIdContratoDetalhes() {
        return $this->idContratoDetalhes;
    }

    public function getIdContrato() {
        return $this->idContrato;
    }

    public function getParcela() {
        return $this->parcela;
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

    public function getTotalPago() {
        return $this->totalPago;
    }

    public function getDataVencimento() {
        return $this->dataVencimento;
    }

    public function getDataPagamento() {
        return $this->dataPagamento;
    }

    public function getIdFormaPagto() {
        return $this->idFormaPagto;
    }

    public function setIdContratoDetalhes($idContratoDetalhes) {
        $this->idContratoDetalhes = $idContratoDetalhes;
    }

    public function setIdContrato($idContrato) {
        $this->idContrato = $idContrato;
    }

    public function setParcela($parcela) {
        $this->parcela = $parcela;
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

    public function setTotalPago($totalPago) {
        $this->totalPago = $totalPago;
    }

    public function setDataVencimento($dataVencimento) {
        $this->dataVencimento = $dataVencimento;
    }

    public function setDataPagamento($dataPagamento) {
        $this->dataPagamento = $dataPagamento;
    }

    public function setIdFormaPagto($idFormaPagto) {
        $this->idFormaPagto = $idFormaPagto;
    }    
}

?>
