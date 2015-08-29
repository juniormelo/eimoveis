<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $obj = new UsuarioPapel(Conf::pegCnxPadrao());
            $obj->setIdPapel($_POST['idPapel']);
            $obj->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $obj->preecheObjetoVerificaAdm();
            $resultados = array(array('idpapel' => $obj->getIdPapel(),'papel' => $obj->getPapel()));
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>