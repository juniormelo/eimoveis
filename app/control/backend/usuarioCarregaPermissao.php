<?php      
    include_once '../../../config.php';     
    $retorno =  array('status' => 'ERRO');      
    if ((isset($_POST)) && (isset($_SESSION['idPessoaProprietario']))) {
        try {                                    
            $usuario = new Usuario(Conf::pegCnxPadrao());
            $usuario->setIdUsuario($_POST['idUsuario']);            
            $usuario->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);           
                
            if ($_POST['idPapel_atual'] == $_POST['idPapel_alt']) {
                $usuario->setIdPapel($_POST['idPapel_atual']);
                $resultados = $usuario->getPermissoes();
                
                if (sizeof($resultados) == 0) {
                    $resultados = $usuario->getPermissoesGrupo();
                }
            } else {               
                $usuario->setIdPapel($_POST['idPapel_alt']);
                $resultados = $usuario->getPermissoesGrupo();
            }                        
            
            $retorno = array('status' => 'OK', 'resultados' => $resultados);
        } catch (PDOException $e) {        
            $retorno = array('status' => 'ERRO');
        }
    }   
    echo json_encode($retorno);      
?>