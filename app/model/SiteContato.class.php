<?php

class SiteContato extends Modelo {
    protected $idContato;
    protected $_data;
    protected $nome;
    protected $email;
    protected $telefone;
    protected $mensagem;
    protected $assunto;
    protected $_idPessoaResposta;
    protected $_dataResposta;
    protected $_resposta;
    
    public function getTabela() {
        return 'sitecontato';
    }
    
    public function getIdContato() {
        return $this->idContato;
    }

    public function get_data() {
        return $this->_data;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function getMensagem() {
        return $this->mensagem;
    }

    public function get_idPessoaResposta() {
        return $this->_idPessoaResposta;
    }

    public function get_dataResposta() {
        return $this->_dataResposta;
    }

    public function get_resposta() {
        return $this->_resposta;
    }

    public function setIdContato($idContato) {
        $this->idContato = $idContato;
    }

    public function set_data($_data) {
        $this->_data = $_data;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    public function set_idPessoaResposta($_idPessoaResposta) {
        $this->_idPessoaResposta = $_idPessoaResposta;
    }

    public function set_dataResposta($_dataResposta) {
        $this->_dataResposta = $_dataResposta;
    }

    public function set_resposta($_resposta) {
        $this->_resposta = $_resposta;
    }
    
    public function getAssunto() {
        return $this->assunto;
    }

    public function setAssunto($assunto) {
        $this->assunto = $assunto;
    }

}

?>
