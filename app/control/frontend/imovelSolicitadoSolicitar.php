<?php
    $status = 'ERRO';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            include_once '../../../config.php';          
            $sol = new ImovelSolicitado(Conf::pegCnxPadrao());
            $sol->setDados($_POST);
            $sol->setUf($_POST['uf_']);
            $sol->setCidade($_POST['cidade_']);
            $sol->setBairro($_POST['bairro_']);
            $sol->setFinalidade($_POST['finalidade_']);
            $sol->setValorMax(Utilitarios::formatarMoeda($_POST['valorMax']));
            $sol->setValorMin(Utilitarios::formatarMoeda($_POST['valorMin']));
            $status = ($sol->_salvar())?'OK':'ERRO';        
        } catch (PDOException $e) {
            $status = 'ERRO: '.$e;
        }        
    }
    echo json_encode(array('status' => $status));
?>
