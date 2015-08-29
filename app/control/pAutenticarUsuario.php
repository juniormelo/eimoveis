<?php        
    include_once 'pSeguranca.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include_once '../../config.php';        
        $usuario = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
        $senha   = (isset($_POST['senha'])) ? $_POST['senha'] : '';        
        if (validaUsuario($usuario, $senha)) {            
            if ($_SESSION['bloqueado']) {
                header("Location: ../../administracao.php?action=".md5(2));
            } else {
                header("Location: ../../sistema.php");
            }            
        } else {
            //$action = md5(0);
            header("Location: ../../administracao.php?action=".md5(0));
        }
    } else {
        header("Location: ../../administracao.php");
    }
?>