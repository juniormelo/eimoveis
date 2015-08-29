<?php
    $status = 'NO';
    $resultados = null;
    try {
        include_once '../../config.php';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $anuncio = new Anuncio(Conf::pegCnxPadrao());
            $anuncio->set_idPessoaProprietario($_SESSION['idPessoaProprietario']);
            $anuncio->set_codigo($_POST['consulta']);
            $anuncio->setTitulo($_POST['consulta']);
            $anuncio->setIdTipo($_POST['consulta']);
            $resultados = $anuncio->consultar();
            $status = (sizeof($resultados) > 0) ? 'OK' : 'NO';  
        }
    } catch (PDOException $e) {
        $status = 'ERRO';
    }
    echo json_encode(array('status' => $status, 'resultados' => $resultados));
?>
