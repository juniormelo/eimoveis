<?php
    include_once '../../config.php';
    $dados = array();  
    try {
        $pessoa = new Pessoa(Conf::pegCnxPadrao());
        $pessoa->setCpf_cnpj($_POST['cpf_cnpj']);
        $info = $pessoa->getInfoPessoa();
        $status = (sizeof($info) > 0) ? 'OK' : 'NO';
        $dados = array('status' => $status,'resultados' => $info);
    } catch (PDOException $e) {
        $dados = array('status' => 'ERRO','resultados' => NULL);
    }    
    echo json_encode($dados);
?>
