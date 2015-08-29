<?php      
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        $idEstadoCivil = 0;
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $estadoCivil = new EstadoCivil(Conf::pegCnxPadrao());
            $estadoCivil->setDados($_POST);        
            $idEstadoCivil = $estadoCivil->_salvar();
            $idEstadoCivil = (empty ($idEstadoCivil)) ? $estadoCivil->getIdAnuncio() : $idEstadoCivil;
            $status = 'OK';
        }
        $retorno =  array('status'=>$status,'idEstadoCivil'=>$idEstadoCivil);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>