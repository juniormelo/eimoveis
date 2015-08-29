<?php
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $conta = new ContaBanco(Conf::pegCnxPadrao());            
            $conta->setDados($_POST);            
            $conta->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $conta->_salvar();            
            $_SESSION['msg'] = Utilitarios::msgSucesso('Conta salva com sucesso!',true);            
            header("Location: ../../../sistema.php?action=contaslista");
        }
        //$retorno =  array('status'=>$status);
    } catch (PDOException $e) {        
        $_SESSION['msg'] = Utilitarios::msgErro('Erro ao tentar salvar',true);
        header("Location: ../../../sistema.php?action=contaslista");
    }
    //echo json_encode($retorno);
?>