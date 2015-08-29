<?php
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $banco = new Banco(Conf::pegCnxPadrao());            
            $banco->setDados($_POST);            
            $banco->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $banco->_salvar();
            //$status = 'OK';            
            $_SESSION['msg'] = Utilitarios::msgSucesso('Banco salvo com sucesso!',true);            
            header("Location: ../../../sistema.php?action=bancoslista");
        }
        //$retorno =  array('status'=>$status);
    } catch (PDOException $e) {        
        $_SESSION['msg'] = Utilitarios::msgErro('Erro ao tentar salvar',true);
        header("Location: ../../../sistema.php?action=bancoslista");
    }
    //echo json_encode($retorno);
?>