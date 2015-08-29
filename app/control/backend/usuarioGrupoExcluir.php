<?php      
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $grupo = new UsuarioPapel(Conf::pegCnxPadrao());
            $grupo->setIdPapel($_POST['idPapel']);
            $grupo->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $grupo->excluir();
            $status = 'OK';
        }
        $retorno = array('status'=>$status);
    } catch (PDOException $e) { 
        echo $e;
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>