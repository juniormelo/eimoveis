<?php      
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $obj = new UsuarioPapel(Conf::pegCnxPadrao());
            $obj->setDados($_POST);
            $obj->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $id = $obj->_salvar();
            $status = 'OK';
        }
        $retorno =  array('status'=>$status);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>$status);
    }
    echo json_encode($retorno);
?>