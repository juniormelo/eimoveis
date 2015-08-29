<?php      
    include_once '../../../config.php';
    $retorno =  array('status' => 'ERRO');
    if (isset($_POST)) {
        try {
            $usuario = new Usuario(Conf::pegCnxPadrao());
            $usuario->setIdUsuario($_POST['idUsuario']);        
            $retorno =  array('status' => $usuario->alterarStatus());        
        } catch (PDOException $e) {        
            $retorno =  array('status' => 'ERRO');
        }
    }
    echo json_encode($retorno);
?>