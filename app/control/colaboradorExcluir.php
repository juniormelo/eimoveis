<?php      
    include_once '../../config.php';
    try {
        $colaborador = new Funcionario(Conf::pegCnxPadrao());
        $colaborador->setIdFuncionario($_POST['idFuncionario']);
        $colaborador->_delete();
        $retorno =  array('status'=>'OK');
    } catch (PDOException $e) {
        $retorno =  array('status'=>'ERRO');
    }
    echo json_encode($retorno);
?>