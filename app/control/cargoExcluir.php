<?php      
    include_once '../../config.php';
    try {
        $cargo = new Cargo(Conf::pegCnxPadrao());
        $cargo->setIdCargo($_POST['idCargo']);
        $cargo->_delete();
        $retorno =  array('status'=>'OK');        
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>