<?php

class ContaReceber extends Modelo {
    protected $idContaReceber;
    protected $idPessoaProprietario;
    protected $idPlanoConta;
    protected $documento;
    protected $descricao;
    protected $dataLancamento;
    protected $dataVencimento;
    protected $dataCompetencia;
    protected $idConta;
    protected $valorNominal;
    protected $parcela;
    protected $parcelas;
    protected $dataPagamento;
    protected $desconto;
    protected $multa;
    protected $juros;
    protected $valorPago;
    protected $idPessoa;
    protected $situacao;
    protected $obsLancamento;
    protected $obsPagamento;
    protected $idUsuarioCad;
    protected $idUsuarioAlt;
    protected $dataAlt;
    protected $idUsuarioCan;
    protected $dataCan;
    
    public function getTabela(){
        return 'contareceber';
    }
    
    public function getDados() {                     
        $sql = 'select * from contapagar where idContaReceber = :$idContaReceber and idPessoaProprietario=:idPessoaProprietario';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idContaReceber", $this->idContaReceber);
        $consulta->liga("idPessoaProprietario", $_SESSION['idPessoaProprietario']);
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
        }
    }
    
   /**
     * Este metodo consulta os clientes de um determinado dono do dacadastro
     * @param idPessoaProprietario
     */
    public function consultar() {
        $criterio = '';
        /*$criterio  = (empty ($this->descricao)) ? '' : " or contabanco.descricao = :descricao" ;
        $criterio .= (empty ($this->idBanco)) ? '' : " or banco.descricao like :idBanco" ;        
        $criterio .= (empty ($this->agencia)) ? '' : " or contabanco.agencia = :agencia" ;        
        $criterio .= (empty ($this->conta)) ? '' : " or contabanco.conta = :conta" ;     */   
        
        $sql = "select idContaReceber, documento, descricao, concat(parcela, '/', coalesce(parcelas,1)) as parcela, valorNominal, DATE_FORMAT(dataVencimento,'%d/%m/%Y') as dataVencimento, situacao, dataVencimento as ordem from contareceber where idPessoaProprietario=:idPessoaProprietario ";
        
        if (empty ($criterio)) {
            $sql .= '  order by ordem asc limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (idContaReceber is null ".$criterio.") order by descricao";
        }
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);        
        
        /*if (!empty ($criterio)) {
            if (!empty ($this->descricao)) {
                $consulta->liga("descricao", $this->descricao.'%');
            }
            
            if (!empty ($this->idBanco)) {
                $consulta->liga("idBanco", $this->idBanco.'%');
            }
            
            if (!empty ($this->agencia)) {
                $consulta->liga("agencia", $this->agencia);
            }
            
            if (!empty ($this->conta)) {
                $consulta->liga("conta", $this->descricao);
            }           
        } */
        return $this->transformaEmArray($consulta->getResultados());
    }        
    
    public function getIdContaReceber() {
        return $this->idContaReceber;
    }

    public function getIdPessoaProprietario() {
        return $this->idPessoaProprietario;
    }

    public function getIdPlanoConta() {
        return $this->idPlanoConta;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getDataLancamento() {
        return $this->dataLancamento;
    }

    public function getDataVencimento() {
        return $this->dataVencimento;
    }

    public function getDataCompetencia() {
        return $this->dataCompetencia;
    }

    public function getIdConta() {
        return $this->idConta;
    }

    public function getValorNominal() {
        return $this->valorNominal;
    }

    public function getParcela() {
        return $this->parcela;
    }

    public function getParcelas() {
        return $this->parcelas;
    }

    public function getDataPagamento() {
        return $this->dataPagamento;
    }

    public function getDesconto() {
        return $this->desconto;
    }

    public function getMulta() {
        return $this->multa;
    }

    public function getJuros() {
        return $this->juros;
    }

    public function getValorPago() {
        return $this->valorPago;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getSituacao() {
        return $this->situacao;
    }    

    public function getIdUsuarioCad() {
        return $this->idUsuarioCad;
    }

    public function getIdUsuarioAlt() {
        return $this->idUsuarioAlt;
    }

    public function getDataAlt() {
        return $this->dataAlt;
    }

    public function getIdUsuarioCan() {
        return $this->idUsuarioCan;
    }

    public function getDataCan() {
        return $this->dataCan;
    }

    public function setIdContaReceber($idContaReceber) {
        $this->idContaReceber = (filter_var($idContaReceber, FILTER_VALIDATE_INT)) ? $idContaReceber : 0;
    }

    public function setIdPessoaProprietario($idPessoaProprietario) {
        $this->idPessoaProprietario = $idPessoaProprietario;
    }

    public function setIdPlanoConta($idPlanoConta) {
        $this->idPlanoConta = $idPlanoConta;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setDataLancamento($dataLancamento) {
        $this->dataLancamento = Utilitarios::formataData_AnoMesDia($dataLancamento);
    }

    public function setDataVencimento($dataVencimento) {
        $this->dataVencimento = Utilitarios::formataData_AnoMesDia($dataVencimento);
    }

    public function setDataCompetencia($dataCompetencia) {
        $this->dataCompetencia = Utilitarios::formataData_AnoMesDia($dataCompetencia);
    }

    public function setIdConta($idConta) {
        $this->idConta = $idConta;
    }

    public function setValorNominal($valorNominal) {
        $this->valorNominal = $valorNominal;
    }

    public function setParcela($parcela) {
        $this->parcela = $parcela;
    }

    public function setParcelas($parcelas) {
        $this->parcelas = $parcelas;
    }

    public function setDataPagamento($dataPagamento) {
        $this->dataPagamento = $dataPagamento;
    }

    public function setDesconto($desconto) {
        $this->desconto = $desconto;
    }

    public function setMulta($multa) {
        $this->multa = $multa;
    }

    public function setJuros($juros) {
        $this->juros = $juros;
    }

    public function setValorPago($valorPago) {
        $this->valorPago = $valorPago;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setSituacao($situacao) {
        $this->situacao = $situacao;
    }
   
    public function setIdUsuarioCad($idUsuarioCad) {
        $this->idUsuarioCad = $idUsuarioCad;
    }

    public function setIdUsuarioAlt($idUsuarioAlt) {
        $this->idUsuarioAlt = $idUsuarioAlt;
    }

    public function setDataAlt($dataAlt) {
        $this->dataAlt = $dataAlt;
    }

    public function setIdUsuarioCan($idUsuarioCan) {
        $this->idUsuarioCan = $idUsuarioCan;
    }

    public function setDataCan($dataCan) {
        $this->dataCan = $dataCan;
    }
    
    public function getDocumento() {
        return $this->documento;
    }

    public function setDocumento($documento) {
        $this->documento = $documento;
    }
    
    public function getObsLancamento() {
        return $this->obsLancamento;
    }

    public function getObsPagamento() {
        return $this->obsPagamento;
    }

    public function setObsLancamento($obsLancamento) {
        $this->obsLancamento = $obsLancamento;
    }

    public function setObsPagamento($obsPagamento) {
        $this->obsPagamento = $obsPagamento;
    }

}

?>

