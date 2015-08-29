<?php

class Pessoa extends Modelo {
    protected $idPessoa;
    protected $idPessoaProprietario;
    protected $tipo;
    protected $razao;
    protected $fantasia;
    protected $cpf_cnpj;
    protected $rg_ie;
    protected $dtNascimento;
    protected $idEstadoCivil;
    protected $flagCliente='N';
    protected $flagCorretor='N';
    protected $flagImobiliaria='N';
    protected $creci;    
    protected $genero;
    protected $dtCadastro;
    protected $dtUltimaAlteracao;
    protected $cep;
    protected $logradouro;
    protected $numLogradouro;
    protected $complemento;
    protected $pontoReferencia;
    protected $bairro;
    protected $cidade;
    protected $uf;
    protected $pais;
    protected $observacao;
    protected $visivel='S';
    protected $telefone;
    protected $fax;
    protected $celular;
    protected $email;
    protected $site;
    protected $flagCredenciado='N';
    protected $foto;
    
    public function getTabela() {
        return 'pessoa';
    }
    
    public function getIdPessoaProprietarioDB() {
        $sql = 'select idPessoaProprietario from pessoa where idPessoa = 
               :idPessoa and cpf_cnpj = :cpf_cnpj';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoa", $this->idPessoa);
        $consulta->liga("cpf_cnpj", $this->cpf_cnpj);
        $dataSet = $consulta->getResultados();
        if ($dataSet) {
            foreach ($dataSet as $linha) {
                return $linha['idPessoaProprietario'];
            }
        } else {
            return -1;
        }
    }
    
    /**
    * Utilizado para buscar uma pessoa no banco de dados (independente do dono do cadastro).
     *retorna um array associativo pronto para converter para JSON
     * @param cpf_cnpj
    */
    public function getInfoPessoa() {        
        $sql = "select idPessoa,idPessoaProprietario,tipo,razao,fantasia,cpf_cnpj,rg_ie,date_format(dtNascimento,
               '%d/%m/%Y') as dtNascimento,idEstadoCivil,flagCliente,flagCorretor,flagImobiliaria,creci,genero,
               dtCadastro,dtUltimaAlteracao,cep,logradouro,numLogradouro,complemento,pontoReferencia,bairro,cidade,
               uf,pais,observacao,visivel,telefone,fax,celular,email,site from pessoa where idPessoa <> 
               idPessoaProprietario and cpf_cnpj=:cpf_cnpj order by dtCadastro desc limit 1";
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);        
        $consulta->liga("cpf_cnpj", $this->cpf_cnpj);
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    /**
     * Este metodo consulta os clientes de um determinado dono do dacadastro
     * @param idPessoaProprietario
     */
    public function getConsultarClientes() {
        $criterio  = (empty ($this->cpf_cnpj)) ? '' : " or cpf_cnpj = :cpf_cnpj" ;
        $criterio .= (empty ($this->razao)) ? '' : " or razao like :razao" ;
        $criterio .= (empty ($this->email)) ? '' : " or email like :email" ;
        $criterio .= (empty ($this->tipo)) ? '' : " or tipo like :tipo" ;
        
        $sql = "select idPessoa,case tipo when 'J' then 'Juridica' else 'Fisica' end as tipo,
               razao,fantasia,cpf_cnpj,email from pessoa where idPessoa <> idPessoaProprietario 
               and idPessoaProprietario=:idPessoaProprietario and flagCliente=:flagCliente";
        
        if (empty ($criterio)) {
            $sql .= ' order by razao limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (idPessoa is null ".$criterio.") order by razao";
        }
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        $consulta->liga("flagCliente", 'S');
        
        if (!empty ($criterio)) {
            if (!empty ($this->cpf_cnpj)) {
                $consulta->liga("cpf_cnpj", $this->cpf_cnpj);
            }
            if (!empty ($this->razao)) {
                $consulta->liga("razao", $this->razao.'%');
            }
            if (!empty ($this->email)) {
                $consulta->liga("email", $this->email.'%');
            }
            if (!empty ($this->tipo)) {
                $consulta->liga("tipo", $this->tipo);
            }
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    /**
     * Este metodo preenche um cliente de um determinado dono do dacadastro
     * @param idPessoaProprietario
     * @param idPessoa
     */
    public function preencheObjCliente() {
        $sql = "select idPessoa,idPessoaProprietario,tipo,razao,fantasia,cpf_cnpj,rg_ie,dtNascimento,
	       idEstadoCivil,flagCliente,flagCorretor,flagImobiliaria,creci,genero,dtCadastro,
               dtUltimaAlteracao,cep,logradouro,numLogradouro,complemento,pontoReferencia,bairro,
               cidade,uf,pais,observacao,visivel,telefone,fax,celular,email,site from pessoa where 
               idPessoa <> idPessoaProprietario and idPessoa=:idPessoa and 
               idPessoaProprietario=:idPessoaProprietario and flagCliente=:flagCliente";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        $consulta->liga("idPessoa", $this->idPessoa);
        $consulta->liga("flagCliente", 'S');
        $this->idPessoa = null;
        $this->idPessoaProprietario = null;
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);            
        }
    }
    
    /**
     * Utilizado para buscar as informações de um cliente (do dono do cadastro)
     * @param idPessoaProprietario
     * @param idPessoa
     */
    public function getInfoCliente() {
        $sql = "select idPessoa,idPessoaProprietario,tipo,razao,fantasia,cpf_cnpj,rg_ie,date_format(dtNascimento,
               '%d/%m/%Y') as dtNascimento,idEstadoCivil,flagCliente,flagCorretor,flagImobiliaria,creci,genero,
               dtCadastro,dtUltimaAlteracao,cep,logradouro,numLogradouro,complemento,pontoReferencia,bairro,cidade,
               uf,pais,observacao,visivel,telefone,fax,celular,email,site from pessoa where idPessoa <> idPessoaProprietario 
               and idPessoa=:idPessoa and idPessoaProprietario=:idPessoaProprietario and flagCliente=:flagCliente";
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);        
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        $consulta->liga("idPessoa", $this->idPessoa);
        $consulta->liga("flagCliente", 'S');
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function preencheObjCredenciado() {
        $sql = "select idPessoa,idPessoaProprietario,tipo,razao,fantasia,cpf_cnpj,rg_ie,dtNascimento,
	       idEstadoCivil,flagCliente,flagCorretor,flagImobiliaria,creci,genero,dtCadastro,
               dtUltimaAlteracao,cep,logradouro,numLogradouro,complemento,pontoReferencia,bairro,
               cidade,uf,pais,observacao,visivel,telefone,fax,celular,email,site,foto 
               from pessoa where idPessoa=:idPessoa and flagCredenciado='S'";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);        
        $consulta->liga("idPessoa", $this->idPessoa);
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
        }
    }
    
    public function getConsultarCredenciados() {
        $criterio  = (empty ($this->cpf_cnpj)) ? '' : " or cpf_cnpj = :cpf_cnpj" ;
        $criterio .= (empty ($this->razao)) ? '' : " or razao like :razao" ;
        $criterio .= (empty ($this->email)) ? '' : " or email like :email" ;
        $criterio .= (empty ($this->tipo)) ? '' : " or tipo like :tipo" ;
        
        $sql = "select idPessoa,case tipo when 'J' then 'Juridica' else 'Fisica' end as tipo,
               razao,fantasia,cpf_cnpj,email,credenciadoBloqueado from pessoa 
               where flagCredenciado='S'";
        
        if (empty ($criterio)) {
            $sql .= ' order by razao limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (idPessoa is null ".$criterio.") order by razao";
        }
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        
        if (!empty ($criterio)) {
            if (!empty ($this->cpf_cnpj)) {
                $consulta->liga("cpf_cnpj", $this->cpf_cnpj);
            }
            if (!empty ($this->razao)) {
                $consulta->liga("razao", $this->razao.'%');
            }
            if (!empty ($this->email)) {
                $consulta->liga("email", $this->email.'%');
            }
            if (!empty ($this->tipo)) {
                $consulta->liga("tipo", $this->tipo);
            }
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
            
    public function getPessoas() {        
        $sql = "select idPessoa, razao from pessoa where idPessoaProprietario=:idPessoaProprietario";        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $_SESSION['idPessoaProprietario']);                
        return $consulta->getResultados();
    }
            
    public function atualizaIdProprietarioCredenciado() {
        $sql = "update pessoa set idPessoaProprietario=:idPessoaProprietario where idPessoa=:idPessoa";
        $comando = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $comando->liga("idPessoaProprietario", $this->idPessoa);
        $comando->liga("idPessoa", $this->idPessoa);
        $comando->executa();
    }
    
    public function alterarStatusCredenciado() {
        $sql = "call sp_credenciado_altera_status(:pIdPessoa);";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("pIdPessoa", (empty ($this->idPessoa)) ? 0 : $this->idPessoa);        
        foreach ($consulta->getResultados() as $linha) {            
            return $linha['RESULT'];
        }
    }
    
    /**
     * Procedure que sincroniza as informações da tabela acesso para tabela
     * credenciado, executar toda vez que for criado um novo acesso no sistema.
     * Essa procedure já é utilizada na procedure sp_credenciado_get_modulos.
     * @return type
     */
    public function sincronizaAcessosCredenciado() {       
        $sql = "call sp_credenciado_sincroniza_acessos(:pIdPessoa);";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("pIdPessoa", (empty ($this->idPessoa)) ? 0 : $this->idPessoa);
        $consulta->getResultados();
        foreach ($consulta->getResultados() as $linha) {            
            return $linha['RESULT'];
        }
    }
    
    /**
     * Retorna os modulos do credenciado, Essa procedure já utiliza a
     * sp_credenciado_sincroniza_acessos.
     * @return modulo, liberado
     */
    public function getModulos() {       
        $sql = "call sp_credenciado_get_modulos(:pIdPessoaCredenciado);";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("pIdPessoaCredenciado", (empty ($this->idPessoa)) ? 0 : $this->idPessoa);
        return $consulta->getResultados();        
    }
    
    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getIdPessoaProprietario() {
        return $this->idPessoaProprietario;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getRazao() {
        return $this->razao;
    }

    public function getFantasia() {
        return $this->fantasia;
    }

    public function getCpf_cnpj() {
        return $this->cpf_cnpj;
    }

    public function getRg_ie() {
        return $this->rg_ie;
    }

    public function getDtNascimento() {
        //return Utilitarios::formataData_DiaMesAno($this->dtNascimento);
        return $this->dtNascimento;
    }

    public function getIdEstadoCivil() {
        return $this->idEstadoCivil;
    }

    public function getFlagCliente() {
        return $this->flagCliente;
    }

    public function getFlagCorretor() {
        return $this->flagCorretor;
    }

    public function getFlagImobiliaria() {
        return $this->flagImobiliaria;
    }

    public function getCreci() {
        return $this->creci;
    }

    public function getGenero() {
        return $this->genero;
    }

    public function getDtCadastro() {
        return $this->dtCadastro;
    }

    public function getDtUltimaAlteracao() {
        return $this->dtUltimaAlteracao;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getNumLogradouro() {
        return $this->numLogradouro;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getPontoReferencia() {
        return $this->pontoReferencia;
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

    public function getObservacao() {
        return $this->observacao;
    }

    public function getVisivel() {
        return $this->visivel;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getFax() {
        return $this->fax;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getSite() {
        return $this->site;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setIdPessoaProprietario($idPessoaProprietario) {
        $this->idPessoaProprietario = $idPessoaProprietario;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function setRazao($razao) {
        $this->razao = $razao;
    }

    public function setFantasia($fantasia) {
        $this->fantasia = $fantasia;
    }

    public function setCpf_cnpj($cpf_cnpj) {
        $this->cpf_cnpj = Utilitarios::removeMascara($cpf_cnpj);
    }

    public function setRg_ie($rg_ie) {
        $this->rg_ie = $rg_ie;
    }

    public function setDtNascimento($dtNascimento) {
        //echo 'vem assim: '.$dtNascimento.'<br />';
        //die(Utilitarios::formataData_AnoMesDia($dtNascimento));
        $this->dtNascimento = Utilitarios::formataData_AnoMesDia($dtNascimento);
    }

    public function setIdEstadoCivil($idEstadoCivil) {
        $this->idEstadoCivil = $idEstadoCivil;
    }

    public function setFlagCliente($flagCliente) {
        $this->flagCliente = strtoupper($flagCliente);
    }

    public function setFlagCorretor($flagCorretor) {
        $this->flagCorretor = $flagCorretor;
    }

    public function setFlagImobiliaria($flagImobiliaria) {
        $this->flagImobiliaria = $flagImobiliaria;
    }

    public function setCreci($creci) {
        $this->creci = $creci;
    }

    public function setGenero($genero) {
        $this->genero = $genero;
    }

    public function setDtCadastro($dtCadastro) {
        $this->dtCadastro = $dtCadastro;
    }

    public function setDtUltimaAlteracao($dtUltimaAlteracao) {
        $this->dtUltimaAlteracao = $dtUltimaAlteracao;
    }

    public function setCep($cep) {
        $this->cep = Utilitarios::removeMascara($cep);
    }

    public function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    public function setNumLogradouro($numLogradouro) {
        $this->numLogradouro = $numLogradouro;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    public function setPontoReferencia($pontoReferencia) {
        $this->pontoReferencia = $pontoReferencia;
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

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }

    public function setVisivel($visivel) {
        $this->visivel = $visivel;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setFax($fax) {
        $this->fax = $fax;
    }

    public function setCelular($celular) {
        $this->celular = $celular;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setSite($site) {
        $this->site = $site;
    }      
    
    public function getFlagCredenciado() {
        return $this->flagCredenciado;
    }

    public function setFlagCredenciado($flagCredenciado) {
        $this->flagCredenciado = $flagCredenciado;
    }
    
    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

}
?>
