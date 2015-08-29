<?php      
    include_once '../../../config.php';
    try {
        $status = 'ERRO';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $obj = new ImovelCategoria(Conf::pegCnxPadrao());
            $obj->setDados($_POST);
            $id = $obj->_salvar();
            $id = (empty ($id)) ? $obj->getIdCategoria() : $id;
            $status = 'OK';
        }
        $retorno =  array('status'=>$status,'id'=>$id);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>