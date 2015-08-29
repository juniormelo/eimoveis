<?php
    $status = 'NO';
    try {
        include_once '../../../config.php';                
        $news = new SiteNewsLetter(Conf::pegCnxPadrao());
        $news->setDados($_POST);
        $status = $news->assinar();
    } catch (PDOException $e) {
        $status = 'ERRO';
    }
    echo json_encode(array('status' => $status));
?>
