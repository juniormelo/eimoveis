<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $tipoAnuncio = new AnuncioTipo(Conf::pegCnxPadrao());            
            $tipoAnuncio->_preecheObjeto($_POST['idTipo']);
            $resultados = array(array('idTipo' => $tipoAnuncio->getIdTipo(),'descricao' => $tipoAnuncio->getDescricao()));
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>