<?php
    include_once '../../../config.php';
    $retorno =  array('status'=>'NO');
    if (isset($_POST)) {
        try {             
            if (isset ($_SESSION['idPessoaProprietario'])) {
                $usuario = new Usuario(Conf::pegCnxPadrao());            
                $usuario->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
                $usuario->setIdUsuario($_POST['idUsuario']);
                $usuario->setIdPapel($_POST['idPapel_atual']);
                $usuario->aplicarPermissoes($_POST);
                $retorno = array('status'=>'OK');
            }
        } catch (PDOException $e) {
            $retorno =  array('status' => 'ERRO : '.$e);  
        }
    }
    echo json_encode($retorno);
?>