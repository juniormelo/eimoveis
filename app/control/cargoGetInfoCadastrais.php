<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $cargo = new Cargo(Conf::pegCnxPadrao());            
            $cargo->_preecheObjeto($_POST['idCargo']);
            $resultados = array(array('idTipo' => $cargo->getIdCargo(),'descricao' => $cargo->getDescricao()));
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>