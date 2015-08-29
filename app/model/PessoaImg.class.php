<?php

class PessoaImg extends Modelo {
    protected $idImg;
    protected $idPessoa;
    protected $img;
    
    public function getTabela(){
        return "pessoaimg";
    }
    
    public function getIdImg() {
        return $this->idImg;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getImg() {
        return $this->img;
    }

    public function setIdImg($idImg) {
        $this->idImg = $idImg;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = $idPessoa;
    }

    public function setImg($img) {
        $this->img = $img;
    }
    
}

?>
