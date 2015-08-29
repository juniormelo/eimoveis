<?php
    include_once '../../../config.php';
    $retorno =  array('status'=>'NO');   
    if (isset($_POST)) {
        try {             
            if ((isset ($_SESSION['idPessoaProprietario'])) && (isset($_POST['idUsuario']))) {
                $usuario = new Usuario(Conf::pegCnxPadrao());            
                $usuario->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
                $usuario->setIdUsuario($_POST['idUsuario']);                
                $usuario->retirarPermissoes();
                $retorno = array('status'=>'OK');
            }
        } catch (PDOException $e) {
            $retorno =  array('status' => 'ERRO : '.$e);  
        }
    }
    echo json_encode($retorno);
?>