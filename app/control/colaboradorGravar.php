<?php      
    include_once '../../config.php';
    try {
        $colaborador = new Funcionario(Conf::pegCnxPadrao());
        $colaborador->setDados($_POST);
        $colaborador->setFlagCliente('N');
        $colaborador->setTipo('F');
        $colaborador->setIdPessoa($_POST['idFuncionario']);
        $colaborador->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);       

        $proprietarioCadDiferente = ($_SESSION['idPessoaProprietario'] == $colaborador->getIdPessoaProprietarioDB()) ? false : true;

        if ($proprietarioCadDiferente) {
            $colaborador->setIdPessoa('');
            $colaborador->setIdFuncionario('');
        } else {
            $colaborador->setIdPessoa($_POST['idFuncionario']);
            $colaborador->setIdFuncionario($_POST['idFuncionario']);
        }
        //var_dump($colaborador);
        $idFuncionario = $colaborador->_salvar();
        $idFuncionario = (empty ($idFuncionario)) ? $colaborador->getIdFuncionario() : $idFuncionario;
        $retorno =  array('status'=>'OK','idFuncionario'=>$idFuncionario);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO', 'ERRO'=>$e);
    }
    echo json_encode($retorno);
?>