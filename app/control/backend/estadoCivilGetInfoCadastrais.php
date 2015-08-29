<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $estadoCivil = new EstadoCivil(Conf::pegCnxPadrao());            
            $estadoCivil->_preecheObjeto($_POST['idEstadoCivil']);
            $resultados = array(array('idEstadoCivil' => $estadoCivil->getIdEstadoCivil(),'descricao' => $estadoCivil->getDescricao()));
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>