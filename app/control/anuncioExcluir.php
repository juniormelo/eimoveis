<?php      
    include_once '../../config.php';
    try {
        $anuncio = new Anuncio(Conf::pegCnxPadrao());        
        $anuncio->set_idPessoaProprietario($_SESSION['idPessoaProprietario']);
        $anuncio->setIdAnuncio($_POST['idAnuncio']);        
        $anuncio->excluir();
        $retorno =  array('status'=>'OK');        
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>