<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $obj = new ImovelSolicitado(Conf::pegCnxPadrao());
            $obj->setUf($_POST['uf']);
            $obj->setFinalidade($_POST['interesse']);
            $resultados = $obj->consultar();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>
