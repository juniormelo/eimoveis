<?php      
    include_once '../../../config.php';
    try {
        $credenciado = new Pessoa(Conf::pegCnxPadrao());
        $credenciado->setIdPessoa($_POST['idPessoa']);
        $retorno =  array('status' => $credenciado->alterarStatusCredenciado());        
    } catch (PDOException $e) {        
        $retorno =  array('status' => 'ERRO');
    }
    echo json_encode($retorno);
?>