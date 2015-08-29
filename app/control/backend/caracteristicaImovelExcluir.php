<?php      
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $obj = new ImovelCaracteristicaTipo(Conf::pegCnxPadrao());
            $obj->setIdCaracteristica($_POST['id']);
            $obj->_delete();
            $status = 'OK';
        }
        $retorno = array('status'=>$status);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>