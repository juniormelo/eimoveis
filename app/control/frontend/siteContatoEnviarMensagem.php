<?php
    $status = 'ERRO';
    try {
        include_once '../../../config.php';
        $contato = new SiteContato(Conf::pegCnxPadrao());
        $contato->setDados($_POST);
        $status = ($contato->_salvar())?'OK':'ERRO';
    } catch (PDOException $e) {
        $status = 'ERRO';
    }
    echo json_encode(array('status' => $status));
?>
