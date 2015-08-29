<?php
    include_once '../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $cargo = new Cargo(Conf::pegCnxPadrao());
            $cargo->setDados($_POST);            
            $cargo->_salvar();
            $status = 'OK';
        }
        $retorno =  array('status'=>$status);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>$e);
    }
    echo json_encode($retorno);
?>