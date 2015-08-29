<?php
    try {
        include_once '../../config.php';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $imovel = new Imovel(Conf::pegCnxPadrao());
            $imovel->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $imovel->set_codigo($_POST['consulta']);
            $imovel->setIdCategoria($_POST['consulta']);
            $imovel->setDescricao($_POST['consulta']);            
            $resultados = $imovel->consultar();            
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';        
        } else {
            $status = 'NO';
            $resultados = null;
        }        
    } catch (PDOException $e) {
        echo $e->getMessage();
        $status = 'ERRO';
        $resultados = null;
    }
    $dados = array('status' => $status, 'resultados' => $resultados);
    echo json_encode($dados);
?>
