<?php      
    include_once '../../config.php';
    try {
        $usuario = new Usuario(Conf::pegCnxPadrao());
        $usuario->setIdUsuario($_SESSION['idUsuario']);
        $usuario->setSenha($_POST['senhaNova']);
        if ($usuario->getSenhaAtualDB() == md5($_POST['senhaAtual'])) {
            $usuario->alterarSenha();
            $status = 'OK';
        } else {
            $status = 'NO';
        }
        $retorno =  array('status'=>$status);        
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>