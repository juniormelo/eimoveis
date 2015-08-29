<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $pessoa = new Pessoa(Conf::pegCnxPadrao());
            $pessoa->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);            
            $pessoa->setIdPessoa($_POST['idPessoa']);                  
            $resultados = $pessoa->getInfoCliente();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>
