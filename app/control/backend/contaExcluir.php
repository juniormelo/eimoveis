<?php      
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $conta = new ContaBanco(Conf::pegCnxPadrao());
            $conta->setIdContaBanco($_POST['idConta']);
            $conta->_delete();
            $status = 'OK';
        }
        $retorno = array('status'=>$status);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>