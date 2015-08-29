<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $obj = new Banco(Conf::pegCnxPadrao());
            $obj->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);            
            $obj->setDescricao($_POST['consulta']);            
            $obj->setCodigo($_POST['consulta']);            
            $resultados = $obj->getConsultarBancos();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>