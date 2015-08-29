<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include_once '../../config.php';
        try {
            $anuncio = new Anuncio(Conf::pegCnxPadrao());
            $anuncio->set_idPessoaProprietario($_SESSION['idPessoaProprietario']);
            $anuncio->setIdAnuncio($_POST['idAnuncio']);
            if ($_POST['status'] == 'Ativo') {
                $anuncio->inativar();
            } else {
                $anuncio->ativar();
            }
            $retorno =  array('status'=>'OK');
        } catch (PDOException $e) {
            $retorno =  array('status'=>'ERRO');
        }
        echo json_encode($retorno);
    } else {
        header("Location: ../../sistema.php");
    }
?>