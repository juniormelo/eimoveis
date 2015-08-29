<?php
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $pc = new PlanoDeConta(Conf::pegCnxPadrao());            
            $pc->setDados($_POST);            
            $pc->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $pc->_salvar();
            //$status = 'OK';            
            $_SESSION['msg'] = Utilitarios::msgSucesso('Plano de contas salvo com sucesso!',true);            
            header("Location: ../../../sistema.php?action=planocontaslista");
        }
        //$retorno =  array('status'=>$status);
    } catch (PDOException $e) {        
        $_SESSION['msg'] = Utilitarios::msgErro('Erro ao tentar salvar o plano de contas',true);
        header("Location: ../../../sistema.php?action=planocontaslista");
    }
    //echo json_encode($retorno);
?>