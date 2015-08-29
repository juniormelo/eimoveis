<?php      
    include_once '../../../config.php';
    try {
        $usuario = new Usuario(Conf::pegCnxPadrao());
        $usuario->setIdUsuario($_POST['idUsuarioRedef']);
        $usuario->setSenha($_POST['senhaRedef']);
        $usuario->alterarSenha();
        $status = 'OK';       
        $retorno =  array('status'=>$status);        
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>