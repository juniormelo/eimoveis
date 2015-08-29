<?php

class AnuncioProposta extends Modelo {
    protected $idProposta;
    protected $idAnuncio;
    protected $dataProposta;
    protected $proposta;
    protected $nome;
    protected $email;
    protected $telefone;
    protected $dataResposta;
    protected $resposta;
    
    public function getTabela(){
        return "AnuncioProposta";
    }
    
    public function getIdProposta() {
        return $this->idProposta;
    }

    public function getIdAnuncio() {
        return $this->idAnuncio;
    }

    public function getDataProposta() {
        return $this->dataProposta;
    }

    public function getProposta() {
        return $this->proposta;
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

    public function getDataResposta() {
        return $this->dataResposta;
    }

    public function getResposta() {
        return $this->resposta;
    }

    public function setIdProposta($idProposta) {
        $this->idProposta = $idProposta;
    }

    public function setIdAnuncio($idAnuncio) {
        $this->idAnuncio = $idAnuncio;
    }

    public function setDataProposta($dataProposta) {
        $this->dataProposta = $dataProposta;
    }

    public function setProposta($proposta) {
        $this->proposta = $proposta;
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

    public function setDataResposta($dataResposta) {
        $this->dataResposta = $dataResposta;
    }

    public function setResposta($resposta) {
        $this->resposta = $resposta;
    }
}

?>
