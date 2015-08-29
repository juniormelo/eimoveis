<?php      
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        $id = 0;
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $obj = new ImovelProximidadeTipo(Conf::pegCnxPadrao());
            $obj->setDados($_POST);        
            $id = $obj->_salvar();
            $id = (empty ($id)) ? $obj->getIdCaracteristica() : $id;
            $status = 'OK';
        }
        $retorno =  array('status'=>$status,'id'=>$id);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>