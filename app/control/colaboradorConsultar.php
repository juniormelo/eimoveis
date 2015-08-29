<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $colaborador = new Funcionario(Conf::pegCnxPadrao());
            $colaborador->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);            
            $colaborador->setCpf_cnpj($_POST['consulta']);
            $colaborador->setRazao($_POST['consulta']);            
            $colaborador->setIdCargo($_POST['consulta']);       
            $resultados = $colaborador->consultar();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>
