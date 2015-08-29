<?php
    include_once '../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $anuncioTipo = new AnuncioTipo(Conf::pegCnxPadrao());
            $anuncioTipo->setDados($_POST);            
            $anuncioTipo->_salvar();
            $status = 'OK';
        }
        $retorno =  array('status'=>$status);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>$e);
    }
    echo json_encode($retorno);
?>