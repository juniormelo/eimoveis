<?php      
    include_once '../../config.php';
    try {
        $pessoa = new Pessoa(Conf::pegCnxPadrao());
        $pessoa->setDados($_POST);
        $pessoa->setFlagCliente('S');
        $pessoa->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);       

        $proprietarioCadDiferente = ($_SESSION['idPessoaProprietario'] == $pessoa->getIdPessoaProprietarioDB()) ? false : true;

        if ($proprietarioCadDiferente) {
            $pessoa->setIdPessoa('');
        } else {
            $pessoa->setIdPessoa($_POST['idPessoa']);
        }
        
        $idPessoa = $pessoa->_salvar();
        $idPessoa = (empty ($idPessoa)) ? $pessoa->getIdPessoa() : $idPessoa;
        $retorno =  array('status'=>'OK','idPessoa'=>$idPessoa);
    } catch (PDOException $e) {        
        $retorno =  array('status' => 'ERRO', 'ERRO' => $e->getMessage());
    }
    echo json_encode($retorno);
?>