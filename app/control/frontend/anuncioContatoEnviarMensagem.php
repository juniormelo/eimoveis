<?php
    $status = 'ERRO';
    try {
        include_once '../../../config.php';
        if (isset ($_POST['idAnuncioContato'])) {
            $anuncio = new Anuncio(Conf::pegCnxPadrao());
            if ($_POST['idAnuncioContato'] > 0 && $anuncio->estaAtivo($_POST['idAnuncioContato'])) {
                $msg = new AnuncioContato(Conf::pegCnxPadrao());
                $msg->setDados($_POST);
                $msg->setIdAnuncio($_POST['idAnuncioContato']);
                $status = ($msg->_salvar())?'OK':'ERRO';
            }
        }
    } catch (PDOException $e) {
        $status = 'ERRO';
    }
    echo json_encode(array('status' => $status));
?>
