<?php
    include_once '../../config.php';
    try {
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $usuario = new Usuario(Conf::pegCnxPadrao());             
            $usuario->setDados($_POST);          
            $usuario->setBloqueado('N');
            $usuario->setLogado('N');
            /*
             * cadastrar o usuario sem papel, na procedure que grava o usuario 
             * vai jogar o papel para nulo, o papel será atribuido na configuração
             * das permissões.
             */
            $usuario->setIdPapel('0');                      
            $status = $usuario->gravar();
        } else {
            $status = 'ERRO';
        }
        $retorno =  array('status'=>$status);
    } catch (PDOException $e) {
        $retorno =  array('status'=>$e);
    }
    echo json_encode($retorno);
?>