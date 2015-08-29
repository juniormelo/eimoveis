<?php      
    include_once '../../config.php';
    try {
        $usuario = new Usuario(Conf::pegCnxPadrao());
        $usuario->setIdUsuario($_POST['idUsuario']);        
        $usuario->_delete();
        $retorno =  array('status'=>'OK');        
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>