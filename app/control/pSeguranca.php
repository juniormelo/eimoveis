<?php
    $_SG['caseSensitive'] = false;
    $_SG['validaSempre']  = true;
    function validaUsuario($pusuario, $psenha) {
	$nusuario = trim(str_replace("'", "", addslashes($pusuario)));
	$nsenha   = trim(str_replace("'", "", addslashes($psenha)));
        /*$sql = "select usuario.idUsuario,usuario.idPessoa,usuario.idPapel,usuario.login,".
               "usuario.bloqueado,pessoa.idPessoaProprietario,pessoa.razao as nome,".
               "(select p.razao from pessoa as p where p.idpessoa = pessoa.idPessoaProprietario) as razao ".
               "from usuario inner join pessoa on usuario.idPessoa = ".
               "pessoa.idPessoa where usuario.login=:login and usuario.senha = md5(:senha)"; */       
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("login", $nusuario);
        $consulta->liga("senha", $nsenha);
        foreach ($consulta->getResultados() as $linha) {
            $_SESSION['idUsuario'] = $linha['idUsuario'];
            $_SESSION['idPessoa']  = $linha['idPessoa'];
            $_SESSION['idPapel']   = $linha['idPapel'];
            $_SESSION['login']     = $linha['login'];
            $_SESSION['bloqueado'] = ($linha['bloqueado'] == 'S') ? true : false ;            
            $_SESSION['razao'] = $linha['razao'];
            $_SESSION['nome'] = $linha['nome'];
            $_SESSION['idPessoaProprietario'] = $linha['idPessoaProprietario'];
            $usuario = new Usuario(Conf::pegCnxPadrao());
            $usuario->setIdUsuario($linha['idUsuario']);
            $usuario->registrarAcesso();
            var_dump($_SESSION);
            
            return true;
        }
        return false;
    }
    function protegePagina() {
        global $_SG;
        if (!isset($_SESSION['idUsuario']) OR !isset($_SESSION['login'])) {
            logOut();
        } else {
            if (empty ($_SESSION['idUsuario']) || empty ($_SESSION['login'])) {
                logOut();
            }
        }
    }
    function logOut() {
        //global $_SG;        
        session_destroy();
        unset($_SESSION['idUsuario'],$_SESSION['idPessoa'],$_SESSION['idPapel'],$_SESSION['login'],$_SESSION['bloqueado'],$_SESSION['idPessoaProprietario']);	
        header("Location: administracao.php");
    }
?>