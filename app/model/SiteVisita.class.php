<?php

class SiteVisita extends Modelo {
    protected $idVisita;
    protected $data;
    protected $ip;
    protected $pagina;
    protected $navegador;
    protected $versao;
    
    public function getTabela(){
        return 'sitevisita';
    }
    
    public static function registraVisita() {
        $sql = 'insert into sitevisita (ip,pagina,navegador,versao) values (:ip,:pagina,:navegador,:versao)';
        $registrar = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);

        $registrar->liga("ip", $_SERVER["REMOTE_ADDR"]);
        $registrar->liga("pagina", (isset ($_GET['action'])?$_GET['action']:'index'));
        $registrar->liga("navegador", Utilitarios::getNavegador());
        $registrar->liga("versao", Utilitarios::getVersaoNavegador());

        if (isset ($_SESSION['visita_registrada'])) {
            if (!$_SESSION['visita_registrada']) {
                $registrar->executa();
                $_SESSION['visita_registrada'] = true;
            }
        } else {
            $registrar->executa();
            $_SESSION['visita_registrada'] = true;
        }
    }

    public function getIdVisita() {
        return $this->idVisita;
    }

    public function getData() {
        return $this->data;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setIdVisita($idVisita) {
        $this->idVisita = $idVisita;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }
    
    public function getPagina() {
        return $this->pagina;
    }

    public function getNavegador() {
        return $this->navegador;
    }

    public function setPagina($pagina) {
        $this->pagina = $pagina;
    }

    public function setNavegador($navegador) {
        $this->navegador = $navegador;
    }
    
    public function getVersao() {
        return $this->versao;
    }

    public function setVersao($versao) {
        $this->versao = $versao;
    }

}

?>
