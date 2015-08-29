<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../../config.php';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $grupo = new UsuarioPapel(Conf::pegCnxPadrao());
            $grupo->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $grupo->setPapel($_POST['consulta']);
            $resultados = $grupo->consultar();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';
        }
    } catch (PDOException $e) {
        $status = 'ERRO '. $e;
    }
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>
