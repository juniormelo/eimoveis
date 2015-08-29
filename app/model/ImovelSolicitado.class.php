<?php

class ImovelSolicitado extends Modelo {
    protected $idImovelSolicitado;
    protected $nome;
    protected $telefone;
    protected $celular;
    protected $email;
    protected $cidade;
    protected $bairro;
    protected $uf;
    protected $imovel;
    protected $finalidade;
    protected $valorMin;
    protected $valorMax;
    protected $descricao;
    protected $_dataSolicitacao;
    protected $_visitas;
    
    public function getTabela(){
        return "imovelsolicitado";
    }
    
    public function consultar() {
        $criterio  = (empty ($this->uf) || $this->uf == 0) ? '' : ' and uf = :uf';
        $criterio  .= (empty ($this->finalidade) || $this->finalidade == 0) ? '' : ' and finalidade = :finalidade';
        
        $sql = "select idImovelSolicitado, nome, finalidade, imovel, uf, dataSolicitacao from imovelsolicitado";
        
        $sql .= (empty ($criterio)) ? '' : ' where idImovelSolicitado is not null'.$criterio.' order by descricao';
        
        $sql .= ' order by dataSolicitacao desc';
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        
        if ((!empty ($criterio)) && (!empty ($this->uf) || $this->uf != 0)) {
            $consulta->liga("uf", $this->uf);
        }
               
        if ((!empty ($criterio)) && (!empty ($this->finalidade) || $this->finalidade != 0)) {
            $consulta->liga("finalidade", $this->finalidade);
        }
               
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function getIdImovelSolicitado() {
        return $this->idImovelSolicitado;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getUf() {
        return $this->uf;
    }

    public function getImovel() {
        return $this->imovel;
    }

    public function getFinalidade() {
        return $this->finalidade;
    }

    public function getValorMin() {
        return $this->valorMin;
    }

    public function getValorMax() {
        return $this->valorMax;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function get_dataSolicitacao() {
        return $this->_dataSolicitacao;
    }

    public function setIdImovelSolicitado($idImovelSolicitado) {
        $this->idImovelSolicitado = $idImovelSolicitado;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }

    public function setImovel($imovel) {
        $this->imovel = $imovel;
    }

    public function setFinalidade($finalidade) {
        $this->finalidade = $finalidade;
    }

    public function setValorMin($valorMin) {
        $this->valorMin = $valorMin;
    }

    public function setValorMax($valorMax) {
        $this->valorMax = $valorMax;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function set_dataSolicitacao($_dataSolicitacao) {
        $this->_dataSolicitacao = $_dataSolicitacao;
    }

    public function get_visitas() {
        return $this->_visitas;
    }

    public function set_visitas($_visitas) {
        $this->_visitas = $_visitas;
    }
    
    public function getCelular() {
        return $this->celular;
    }

    public function setCelular($celular) {
        $this->celular = $celular;
    }
    
}

?>
