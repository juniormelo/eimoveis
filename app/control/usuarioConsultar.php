<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $usuario = new Usuario(Conf::pegCnxPadrao());
            $usuario->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);            
            $usuario->setLogin($_POST['consulta']);
            $usuario->setIdPessoa($_POST['consulta']);
            $usuario->setIdPapel($_POST['consulta']);
            $resultados = $usuario->consultar();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>
