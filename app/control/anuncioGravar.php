<?php      
    include_once '../../config.php';
    try {
        $anuncio = new Anuncio(Conf::pegCnxPadrao());       
        $anuncio->setIdUsuarioAlt($_SESSION['idUsuario']);
        $anuncio->setDados($_POST);
        $valor = str_replace('.', '', $_POST['valor']);
        $valor = str_replace(',', '.', $valor);
        $anuncio->setValor($valor);
        $idAnuncio = $anuncio->_salvar();
        $idAnuncio = (empty ($idAnuncio)) ? $anuncio->getIdAnuncio() : $idAnuncio;
        $retorno =  array('status'=>'OK','idAnuncio'=>$idAnuncio);
    } catch (PDOException $e) {        
        $retorno =  array('status'=>'ERRO', 'idAnuncio'=>$idAnuncio);
    }
    echo json_encode($retorno);
?>