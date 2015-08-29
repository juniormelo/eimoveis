<?php

class Configuracao extends Modelo {
    protected $frontEndOnline;
    protected $backEndOnline;
    
    public function getTabela(){
        return "configuracao";
    }
    
    public function getFrontEndOnline() {
        return $this->frontEndOnline;
    }

    public function getBackEndOnline() {
        return $this->backEndOnline;
    }
   
    public function setFrontEndOnline($frontEndOnline) {
        $this->frontEndOnline = $frontEndOnline;
    }

    public function setBackEndOnline($backEndOnline) {
        $this->backEndOnline = $backEndOnline;
    }  
}

?>
