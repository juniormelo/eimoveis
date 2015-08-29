<?php
    include_once '../../../config.php';
    $retorno =  array('status'=>'NO');
    if (isset($_POST)) {
        try {             
            if (isset ($_SESSION['idPessoaProprietario'])) {
                $grupo = new UsuarioPapelPermissao(Conf::pegCnxPadrao());            
                $grupo->set_idPessoaCredenciado($_SESSION['idPessoaProprietario']);
                $grupo->aplicarPermissoes($_POST);
                $retorno =  array('status'=>'OK');
            }
        } catch (PDOException $e) {
            $retorno =  array('status'=>'ERRO');  
        }
    }
    echo json_encode($retorno);
?>