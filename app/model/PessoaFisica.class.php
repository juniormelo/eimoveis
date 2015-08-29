<?php

class PessoaFisica extends Pessoa {
    protected $idPessoaFisica;
    protected $idEstadoCivil;
    protected $cpf;
    protected $rg;    
    protected $dtNascimento;
    protected $flagCorretor='N';
    protected $creci;

    public function getTabela(){
        return "pessoafisica";
    }
    
    public function getIdPessoaFisica() {
        return $this->idPessoaFisica;
    }

    public function getIdEstadoCivil() {
        return $this->idEstadoCivil;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getRg() {
        return $this->rg;
    }

    public function getDtNascimento() {
        return $this->dtNascimento;
    }

    public function getFlagCorretor() {
        return $this->flagCorretor;
    }

    public function getCreci() {
        return $this->creci;
    }

    public function setIdPessoaFisica($idPessoaFisica) {
        $this->idPessoaFisica = $idPessoaFisica;
    }

    public function setIdEstadoCivil($idEstadoCivil) {
        $this->idEstadoCivil = $idEstadoCivil;
    }

    public function setCpf($cpf) {
        $this->cpf = $cpf;
    }

    public function setRg($rg) {
        $this->rg = $rg;
    }

    public function setDtNascimento($dtNascimento) {
        $this->dtNascimento = $dtNascimento;
    }

    public function setFlagCorretor($flagCorretor) {
        $this->flagCorretor = $flagCorretor;
    }

    public function setCreci($creci) {
        $this->creci = $creci;
    }
    
    public function getIdPessoaProprietarioDB() {
        $sql = 'select pessoa.idPessoaProprietario from pessoafisica inner join pessoa
               on pessoafisica.idPessoaFisica = pessoa.idPessoa where pessoafisica.idPessoaFisica = 
               :idPessoaFisica and pessoafisica.cpf = :cpf';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaFisica", $this->idPessoaFisica);
        $consulta->liga("cpf", $this->cpf);      
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
