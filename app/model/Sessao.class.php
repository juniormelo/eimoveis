<?php
class Sessao {    
    
    //USUARIO ADMINISTRADOR DE TODO O SISTEMA
    public static function eSuperAdm($redireciona = true) {        
        if(isset($_SESSION['eSuperAdm'])) {
            if($_SESSION['eSuperAdm']) {
                return true;
            } else if($redireciona) {
                header("Location: sistema.php?action=paginaprotegida");
            } else {
                return false;
            }
        } else if($redireciona) {
            header("Location: sistema.php?action=paginaprotegida");
        } else {
            return false; 
        }
    }
    
    //PESSOA FISICA OU JURIDICA CREDENCIADA, ESSE ACESSO É ADM PARA O SEU SUB-SISTEMA
    public static function eAdm() {
        if(isset($_SESSION['idPapel'])){
            if($_SESSION['idPapel'] == 2){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static function temPermissao($acesso, $redireciona = true) {
        if((isset($_SESSION['permissao']) && Sessao::logado()) || Sessao::eSuperAdm(false)) {
            if (in_array($acesso, $_SESSION['permissao']) || Sessao::eSuperAdm(false)) {
                return true;
            } else if ($redireciona) {
                header("Location: sistema.php?action=paginaprotegida");
            } else {
                return false;
            }
        } else if($redireciona) {
            header("Location: sistema.php?action=paginaprotegida");
        } else {
            return false;
        }
    }

    public static function logado() {        
        if (isset($_SESSION['logado'])) {
            return true;
        } else {
            return false;
        }
    }
    
    public static function existeUsuarioLogado() {        
        if(isset($_SESSION['logado'])) {
            return true;            
        } else {            
            session_destroy();
            unset($_SESSION['idUsuario'],$_SESSION['idPessoa'],$_SESSION['idPapel'],$_SESSION['login'],$_SESSION['bloqueado'],$_SESSION['idPessoaProprietario']);            
            header("Location: administracao.php?action=".md5(3));
        }
    }
    
}
?>
