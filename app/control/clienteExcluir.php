<?php      
    include_once '../../config.php';
    try {
        $pessoa = new Pessoa(Conf::pegCnxPadrao());
        $pessoa->setIdPessoa($_POST['idPessoa']);        
        $pessoa->_delete();
        $retorno =  array('status'=>'OK');        
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>