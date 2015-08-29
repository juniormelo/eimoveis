<?php

class Funcionario extends Pessoa {
    protected $idFuncionario;
    protected $idCargo;
    protected $carteiraTrab;
    protected $dtAdmissao;
    protected $dtDemissao;
    protected $motivoDemissao;
    protected $salario;
    protected $pis_pasep;
    protected $cnh;
    protected $_dtCadastro;
    protected $observacao;
    
    public function getTabela() {
        return 'funcionario';
    }

    public function consultar() {
        $criterio  = (empty ($this->cpf_cnpj)) ? '' : ' or pessoa.cpf_cnpj = :cpf_cnpj' ;
        $criterio .= (empty ($this->razao)) ? '' : ' or pessoa.razao like :razao' ;
        $criterio .= (empty ($this->idCargo)) ? '' : ' or cargo.descricao like :cargo' ;
        
        $sql = "select funcionario.idFuncionario,pessoa.cpf_cnpj,pessoa.razao,pessoa.email,
               cargo.descricao as cargo from funcionario inner join pessoa on funcionario.idFuncionario = 
               pessoa.idPessoa inner join cargo on funcionario.idCargo = cargo.idCargo where 
               pessoa.idPessoaProprietario = :idPessoaProprietario";
       
        if (empty ($criterio)) {
            $sql .= ' limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (funcionario.idFuncionario is null ".$criterio.")";
        }
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        
        if (!empty ($criterio)) {
            if (!empty ($this->cpf_cnpj)) {
                $consulta->liga("cpf_cnpj", $this->cpf_cnpj);
            }
            if (!empty ($this->razao)) {
                $consulta->liga("razao", $this->razao.'%');
            }
            if (!empty ($this->idCargo)) {
                $consulta->liga("cargo", $this->idCargo.'%');
            }
        }
        
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function preencheObj() {
        $sql = "select funcionario.idFuncionario,funcionario.idCargo,funcionario.carteiraTrab,funcionario.dtAdmissao,
               funcionario.salario,funcionario.pis_pasep,funcionario.cnh,pessoa.idPessoa,pessoa.idPessoaProprietario,
               pessoa.tipo,pessoa.razao,pessoa.fantasia,pessoa.cpf_cnpj,pessoa.rg_ie,pessoa.dtNascimento,pessoa.idEstadoCivil,
               pessoa.flagCliente,pessoa.flagCorretor,pessoa.flagImobiliaria,pessoa.creci,pessoa.genero,pessoa.dtCadastro,
               pessoa.dtUltimaAlteracao,pessoa.cep,pessoa.logradouro,pessoa.numLogradouro,pessoa.complemento,pessoa.pontoReferencia,
               pessoa.bairro,pessoa.cidade,pessoa.uf,pessoa.pais,pessoa.observacao,pessoa.telefone,pessoa.fax,pessoa.celular,
               pessoa.email,pessoa.site from funcionario inner join pessoa on funcionario.idFuncionario = pessoa.idPessoa
               where funcionario.idFuncionario = :idFuncionario and pessoa.idPessoaProprietario = :idPessoaProprietario";
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idFuncionario", $this->idFuncionario);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        
        foreach ($consulta->getResultados() as $value) {
            $this->setDados($value);
        }        
    }        
    
    public function getIdFuncionario() {
        return $this->idFuncionario;
    }

    public function getIdCargo() {
        return $this->idCargo;
    }

    public function getCarteiraTrab() {
        return $this->carteiraTrab;
    }

    public function getDtAdmissao() {
        return $this->dtAdmissao;
    }

    public function getDtDemissao() {
        return $this->dtDemissao;
    }

    public function getMotivoDemissao() {
        return $this->motivoDemissao;
    }

    public function getSalario() {
        return $this->salario;
    }

    public function getPis_pasep() {
        return $this->pis_pasep;
    }

    public function getCnh() {
        return $this->cnh;
    }

    public function get_dtCadastro() {
        return $this->_dtCadastro;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function setIdFuncionario($idFuncionario) {
        $this->idFuncionario = $idFuncionario;
    }

    public function setIdCargo($idCargo) {
        $this->idCargo = $idCargo;
    }

    public function setCarteiraTrab($carteiraTrab) {
        $this->carteiraTrab = $carteiraTrab;
    }

    public function setDtAdmissao($dtAdmissao) {
        if (!empty ($dtAdmissao)) {
            $this->dtAdmissao = Utilitarios::formataData_AnoMesDia($dtAdmissao);;
        }
    }

    public function setDtDemissao($dtDemissao) {
        $this->dtDemissao = $dtDemissao;
    }

    public function setMotivoDemissao($motivoDemissao) {
        $this->motivoDemissao = $motivoDemissao;
    }

    public function setSalario($salario) {
        $this->salario = $salario;
    }

    public function setPis_pasep($pis_pasep) {
        $this->pis_pasep = $pis_pasep;
    }

    public function setCnh($cnh) {
        $this->cnh = $cnh;
    }

    public function set_dtCadastro($_dtCadastro) {
        $this->_dtCadastro = $_dtCadastro;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }
    
}

?>
