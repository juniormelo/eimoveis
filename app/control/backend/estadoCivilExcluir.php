<?php      
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $estadoCivil = new EstadoCivil(Conf::pegCnxPadrao());
            $estadoCivil->setIdEstadoCivil($_POST['idEstadoCivil']);
            $estadoCivil->_delete();
            $status = 'OK';
        }
        $retorno = array('status'=>$status);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>