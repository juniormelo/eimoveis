<?php      
    include_once '../../../config.php';    
    if (isset ($_SESSION['idPessoaProprietario'])) {
        $colaborador = new Usuario(Conf::pegCnxPadrao());
        $colaborador->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
        if (isset ($_POST['idUsuario'])) {
            if (!empty ($_POST['idUsuario'])) {
                $colaborador->setIdUsuario($_POST['idUsuario']);
            }
        }
        //echo "teste teste teste";
        Utilitarios::preencheComboDB($colaborador->getColaboradoresCadUsuario());
    }    
?>