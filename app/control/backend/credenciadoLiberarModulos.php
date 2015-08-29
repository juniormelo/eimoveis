<?php
    include_once '../../../config.php';
    if ( (Sessao::eSuperAdm()) && (isset($_POST)) ) {
        try {             
            $retorno =  array('status'=>'NO');
            if (isset ($_POST['idCredenciado'])) {
                $acesso = new AcessoCredenciado(Conf::pegCnxPadrao());            
                $acesso->liberar($_POST);                
                $retorno =  array('status'=>((count($_POST) > 1)?'OK':'NO'));
            }
        } catch (PDOException $e) {
            $retorno =  array('status'=>'ERRO');  
        }
    } else {
        $retorno =  array('status'=>'PERMISSAO');  
    }
    
    echo json_encode($retorno);
?>