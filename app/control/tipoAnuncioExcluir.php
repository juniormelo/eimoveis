<?php      
    include_once '../../config.php';
    try {
        $anuncioTipo = new AnuncioTipo(Conf::pegCnxPadrao());
        $anuncioTipo->setIdTipo($_POST['idTipo']);        
        $anuncioTipo->_delete();
        $retorno =  array('status'=>'OK');        
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>