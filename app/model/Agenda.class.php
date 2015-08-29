<?php

class Agenda extends Modelo {
    protected $idCompromisso;
    protected $idCategoria;
    protected $titulo;
    protected $prioridade;
    protected $dataInicio;
    protected $horaInicio;
    protected $dataFim;
    protected $horaFim;
    protected $descricao;
    protected $dataCadastro;
    protected $dataConclusao;
    protected $idPessoa;
    protected $status;
    
    public function getTabela(){
        return "agenda";
    }
    
    public function getIdCompromisso() {
        return $this->idCompromisso;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getPrioridade() {
        return $this->prioridade;
    }

    public function getDataInicio() {
        return $this->dataInicio;
    }

    public function getHoraInicio() {
        return $this->horaInicio;
    }

    public function getDataFim() {
        return $this->dataFim;
    }

    public function getHoraFim() {
        return $this->horaFim;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getDataCadastro() {
        return $this->dataCadastro;
    }

    public function getDataConclusao() {
        return $this->dataConclusao;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setIdCompromisso($idCompromisso) {
        $this->idCompromisso = $idCompromisso;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setPrioridade($prioridade) {
        $this->prioridade = $prioridade;
    }

    public function setDataInicio($dataInicio) {
        $this->dataInicio = $dataInicio;
    }

    public function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    public function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    public function setHoraFim($horaFim) {
        $this->horaFim = $horaFim;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setDataCadastro($dataCadastro) {
        $this->dataCadastro = $dataCadastro;
    }

    public function setDataConclusao($dataConclusao) {
        $this->dataConclusao = $dataConclusao;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

}

?>
