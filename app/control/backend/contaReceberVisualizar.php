<?php
    
    try {
        include_once '../../../config.php';        
        if (isset ($_SESSION['idPessoaProprietario'])) {
            $cr = new ContaReceber(Conf::pegCnxPadrao());
            $cr->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);                                    
            $cr->setIdContaReceber($_POST['idContaReceber']);            
            $cr->getDados();
            var_dump($cr);
        } else {
            Utilitarios::msgAtencao('Falha ao tentar exibir as informações da conta!');
        }            
    } catch (PDOException $e) {
        Utilitarios::msgAtencao('Erro ao tentar exibir as informações da conta.');        
    }    
?>