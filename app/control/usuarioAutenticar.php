<?php        
    include_once '../../config.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {        
        $usuario = new Usuario(Conf::pegCnxPadrao());
        $usuario->setLogin((isset($_POST['usuario'])) ? $_POST['usuario'] : '');
        $usuario->setSenha((isset($_POST['senha'])) ? $_POST['senha'] : '');        
        if($usuario->autentica()) { 
            //$_SESSION['bloqueado'] = ($usuario->getBloqueado() == 'S') ? true : false;
            
            if ($usuario->get_credenciadoBloqueado()) {
                header("Location: ../../administracao.php?action=".md5(4));
            } else if ($usuario->getBloqueado()) {
                header("Location: ../../administracao.php?action=".md5(2));
            } else {
                $_SESSION['idUsuario'] = $usuario->getIdUsuario();
                $_SESSION['idPessoa'] = $usuario->getIdPessoa();
                $_SESSION['idPapel'] = $usuario->getIdPapel();
                $_SESSION['login'] = $usuario->getLogin();                
                $_SESSION['razao'] = $usuario->getRazao();
                $_SESSION['idPessoaProprietario'] = $usuario->getIdPessoaProprietario();
                //$_SESSION['permissao'] = array(1,2,3);
                $_SESSION['eSuperAdm'] = $usuario->get_superAdm();
                $_SESSION['logado'] = true;
                $_SESSION['permissao'] = $usuario->get_permissoes();
                $_SESSION['msg'] = '';
                
                $usuario->registrarAcesso();
                //Auditoria::Auditar('Usuário entrou na area administrativa.');                
                header("Location: ../../sistema.php");
            }            
        } else {
            //Auditoria::Auditar('Acesso negado. Usuario não conseguiu logar.');
            header("Location: ../../administracao.php?action=".md5(0));
        }        
    } else {
        //Auditoria::Auditar('Acesso negado. Tentativa de invasão.Autenticação não foi requisitada pela aplicação.');        
        header("Location: ../../administracao.php");
    }
?>