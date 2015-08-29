<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $pessoa = new Pessoa(Conf::pegCnxPadrao());
            $pessoa->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);            
            $pessoa->setCpf_cnpj($_POST['consulta']);
            $pessoa->setRazao($_POST['consulta']);
            $pessoa->setEmail($_POST['consulta']);
            $pessoa->setTipo($_POST['consulta']);       
            $resultados = $pessoa->getConsultarClientes();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>
