<?php

class PessoaJuridica extends Pessoa {
    protected $idPessoaJuridica;
    protected $cnpj;
    protected $ie;
    protected $dtFundacao;
    protected $flagImobiliaria='S';
    protected $creci;
    
    public function getTabela(){
        return "pessoajuridica";
    }
    
    public function getIdPessoaJuridica() {
        return $this->idPessoaJuridica;
    }

    public function getCnpj() {
        return $this->cnpj;
    }

    public function getIe() {
        return $this->ie;
    }

    public function getDtFundacao() {
        return $this->dtFundacao;
    }

    public function getFlagImobiliaria() {
        return $this->flagImobiliaria;
    }

    public function getCreci() {
        return $this->creci;
    }

    public function setIdPessoaJuridica($idPessoaJuridica) {
        $this->idPessoaJuridica = $idPessoaJuridica;
    }

    public function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    public function setIe($ie) {
        $this->ie = $ie;
    }

    public function setDtFundacao($dtFundacao) {
        $this->dtFundacao = $dtFundacao;
    }

    public function setFlagImobiliaria($flagImobiliaria) {
        $this->flagImobiliaria = $flagImobiliaria;
    }

    public function setCreci($creci) {
        $this->creci = $creci;
    }
    
    public function getIdPessoaProprietarioDB() {
        $sql = 'select pessoa.idPessoaProprietario from pessoajuridica inner join pessoa
               on pessoajuridica.idPessoaJuridica = pessoa.idPessoa where pessoajuridica.idPessoaJuridica = 
               :idPessoaJuridica and pessoajuridica.cnpj = :cnpj';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaJuridica", $this->idPessoaFisica);
        $consulta->liga("cnpj", $this->cpf);      
        $dataSet = $consulta->getResultados();
        if ($dataSet) {
            foreach ($dataSet as $linha) {
                return $linha['idPessoaProprietario'];
            }
        } else {
            return -1;
        }
    }
}
?>
