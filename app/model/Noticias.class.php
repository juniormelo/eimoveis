<?php

class Noticias extends Modelo {
    protected $idNoticia;
    protected $ativa;
    protected $idUsuario;
    protected $dataPublicacao;
    protected $link;
    protected $fonte;
    protected $autor;
    protected $titulo;
    protected $imagem;
    protected $conteudo;
    
    public function getTabela(){
        return "noticias";
    }
    
    public function getIdNoticia() {
        return $this->idNoticia;
    }

    public function getAtiva() {
        return $this->ativa;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getDataPublicacao() {
        return $this->dataPublicacao;
    }

    public function getLink() {
        return $this->link;
    }

    public function getFonte() {
        return $this->fonte;
    }

    public function getAutor() {
        return $this->autor;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function getConteudo() {
        return $this->conteudo;
    }

    public function setIdNoticia($idNoticia) {
        $this->idNoticia = $idNoticia;
    }

    public function setAtiva($ativa) {
        $this->ativa = $ativa;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setDataPublicacao($dataPublicacao) {
        $this->dataPublicacao = $dataPublicacao;
    }

    public function setLink($link) {
        $this->link = $link;
    }

    public function setFonte($fonte) {
        $this->fonte = $fonte;
    }

    public function setAutor($autor) {
        $this->autor = $autor;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }

    public function setConteudo($conteudo) {
        $this->conteudo = $conteudo;
    }
}

?>
