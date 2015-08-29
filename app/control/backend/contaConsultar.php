<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $obj = new ContaBanco(Conf::pegCnxPadrao());
            $obj->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);            
            $obj->setIdBanco($_POST['consulta']);                        
            $obj->setAgencia($_POST['consulta']);            
            $obj->setConta($_POST['consulta']);            
            $resultados = $obj->getConsultarContas();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>