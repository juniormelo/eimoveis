<?php

class ContaBanco extends Modelo {
    protected $idContaBanco;
    protected $idPessoaProprietario;
    protected $idBanco;    
    protected $descricao;
    protected $agencia;
    protected $agenciaDig;
    protected $conta;
    protected $contaDig;
    protected $telefone;
    protected $gerente;
    protected $saldoInicial;
    protected $saldoAtual;
    protected $cep;
    protected $logradouro;
    protected $numero;
    protected $bairro;
    protected $cidade;
    protected $uf;
    protected $pais;
    protected $pontoReferencia;
    
    public function getTabela(){
        return "contabanco";
    }
    
    public function getDados() {                     
        $sql = 'select * from contabanco where idContaBanco = :idContaBanco and idPessoaProprietario=:idPessoaProprietario';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idContaBanco", $this->idContaBanco);
        $consulta->liga("idPessoaProprietario", $_SESSION['idPessoaProprietario']);
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
        }
    }
    
    public function getCadastradas() {                     
        $sql = 'select idContaBanco, descricao from contabanco where idPessoaProprietario=:idPessoaProprietario order by descricao';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);        
        $consulta->liga("idPessoaProprietario", $_SESSION['idPessoaProprietario']);
        return $consulta->getResultados();
    }
    
    public function getSaldo() {                     
        $sql = "select contabanco.idContaBanco, concat(banco.descricao, ' ',contabanco.conta,'-',contabanco.contaDig, ' (',contabanco.descricao,')') as descricao,".
               "coalesce(contabanco.saldoAtual,0) as saldo from contabanco inner join banco on contabanco.idBanco = banco.idBanco where ".
                "contabanco.idPessoaProprietario=:idPessoaProprietario order by descricao";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);        
        $consulta->liga("idPessoaProprietario", $_SESSION['idPessoaProprietario']);
        return $consulta->getResultados();
    }
    
   /**
     * Este metodo consulta os clientes de um determinado dono do dacadastro
     * @param idPessoaProprietario
     */
    public function getConsultarContas() {
        $criterio  = (empty ($this->descricao)) ? '' : " or contabanco.descricao = :descricao" ;
        $criterio .= (empty ($this->idBanco)) ? '' : " or banco.descricao like :idBanco" ;        
        $criterio .= (empty ($this->agencia)) ? '' : " or contabanco.agencia = :agencia" ;        
        $criterio .= (empty ($this->conta)) ? '' : " or contabanco.conta = :conta" ;        
        
        $sql = "select contabanco.idContaBanco, contabanco.descricao, concat(contabanco.agencia,'-',contabanco.agenciaDig) as agencia,".
               "concat(contabanco.conta, '-', contabanco.contaDig) as conta,contabanco.saldoAtual, banco.descricao as banco from contabanco ".
               'inner join banco on contabanco.idBanco = banco.idBanco '.
               'where contabanco.idPessoaProprietario=:idPessoaProprietario ';                
        
        if (empty ($criterio)) {
            $sql .= '  order by contabanco.idContaBanco desc limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (contabanco.idContaBanco is null ".$criterio.") order by contabanco.descricao";
        }
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);        
        
        if (!empty ($criterio)) {
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
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function getIdContaBanco() {
        return $this->idContaBanco;
    }

    public function getIdPessoaProprietario() {
        return $this->idPessoaProprietario;
    }

    public function getIdBanco() {
        return $this->idBanco;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getAgencia() {
        return $this->agencia;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getGerente() {
        return $this->gerente;
    }

    public function getSaldoInicial() {
        return $this->saldoInicial;
    }

    public function getSaldoAtual() {
        return $this->saldoAtual;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getUf() {
        return $this->uf;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getPontoReferencia() {
        return $this->pontoReferencia;
    }

    public function setIdContaBanco($idContaBanco) {
        $this->idContaBanco = $idContaBanco;
    }

    public function setIdPessoaProprietario($idPessoaProprietario) {
        $this->idPessoaProprietario = $idPessoaProprietario;
    }

    public function setIdBanco($idBanco) {
        $this->idBanco = $idBanco;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setAgencia($agencia) {
        $this->agencia = $agencia;
    }

    public function setConta($conta) {
        $this->conta = $conta;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setGerente($gerente) {
        $this->gerente = $gerente;
    }

    public function setSaldoInicial($saldoInicial) {
        $this->saldoInicial = $saldoInicial;
    }

    public function setSaldoAtual($saldoAtual) {
        $this->saldoAtual = $saldoAtual;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    public function setNumero($numero) {
        $this->numero = $numero;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function setPontoReferencia($pontoReferencia) {
        $this->pontoReferencia = $pontoReferencia;
    }
    
    public function getAgenciaDig() {
        return $this->agenciaDig;
    }

    public function getContaDig() {
        return $this->contaDig;
    }

    public function setAgenciaDig($agenciaDig) {
        $this->agenciaDig = $agenciaDig;
    }

    public function setContaDig($contaDig) {
        $this->contaDig = $contaDig;
    }
    
    public function getConta() {
        return $this->conta;
    }

    
}

?>
