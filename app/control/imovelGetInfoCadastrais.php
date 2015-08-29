<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $imovel = new Imovel(Conf::pegCnxPadrao());
            $imovel->setIdImovel($_POST['idImovel']);        
            $imovel->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);            
            $resultados = $imovel->getInfoCadastrais();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }              
    } catch (PDOException $e) {
        $status = 'ERRO';
    }    
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>
