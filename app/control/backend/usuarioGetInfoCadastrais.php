<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $obj = new Usuario(Conf::pegCnxPadrao());            
            $obj->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $obj->setIdUsuario($_POST['idUsuario']);
            $resultados = $obj->getInfoUsuario();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>