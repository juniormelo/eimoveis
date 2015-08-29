<?php
    include_once '../../config.php';
    try {
        $cnx = Conf::pegCnxPadrao();
        $imovel = new Imovel($cnx);       
        $imovel->setIdImovel($_POST['idImovel']);
        $imovel->moverParaLixeira($_POST['idImovel']);        
        $status = 'OK';
    } catch (PDOException $e) {
        $cnx->fimTransacao();
        $status = 'ERRO';
    }
    echo json_encode(array('status' => $status));
?>