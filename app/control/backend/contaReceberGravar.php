<?php
    include_once '../../../config.php';
    try {
        $status = 'ERRO';
        if ((isset ($_SESSION['idPessoaProprietario'])) && (isset($_POST)) ) {
            $conta = new ContaReceber(Conf::pegCnxPadrao());
            
            $parcelas = (int) $_POST['parcela'];            
            if ((empty($parcelas)) || ($parcelas < 1)) {
                $parcelas = 1;
            }                       
            
            for ($parcela = 1; $parcela <= $parcelas; $parcela++) {
                $conta->setDados($_POST);            
                $conta->setSituacao('ABERTO');
                $conta->setParcela($parcela);
                $conta->setParcelas($parcelas);
                $conta->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
                $conta->_salvar();            
            }
            
            $_SESSION['msg'] = Utilitarios::msgSucesso('Conta salva com sucesso!',true);            
            header("Location: ../../../sistema.php?action=contareceber");
        }
        //$retorno =  array('status'=>$status);
    } catch (PDOException $e) {        
        $_SESSION['msg'] = Utilitarios::msgErro('Erro ao tentar salvar',true);
        header("Location: ../../../sistema.php?action=contareceber");
    }
    //echo json_encode($retorno);
?>