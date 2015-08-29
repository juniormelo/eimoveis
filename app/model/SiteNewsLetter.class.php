<?php

class SiteNewsLetter extends Modelo {
    protected $idNewsLetter;
    protected $nome;
    protected $email;
    protected $_data;
    
    public function getTabela(){
        return 'sitenewsletter';
    }
        
    public function assinar(){
        $sql = "call sp_assinar_news(:pNome,:pEmail);";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("pNome", $this->nome);
        $consulta->liga("pEmail", $this->email);
        foreach ($consulta->getResultados() as $linha) {
            return $linha['RESULT'];
        }
    }
    
    public function getIdNewsLetter() {
        return $this->idNewsLetter;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function get_data() {
        return $this->_data;
    }

    public function setIdNewsLetter($idNewsLetter) {
        $this->idNewsLetter = $idNewsLetter;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function set_data($_data) {
        $this->_data = $_data;
    }
    
}

?>
