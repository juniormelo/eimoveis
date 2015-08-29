<?php      
    include_once '../../../config.php';    
    if (isset($_POST)) {       
        try {
            $cnx = Conf::pegCnxPadrao();
            $anuncio = new Anuncio($cnx);
            $cnx->iniTransacao();
            
            $anuncio->setIdUsuarioAlt($_SESSION['idUsuario']);
            $anuncio->setDados($_POST);            
            $valor = str_replace('.', '', $_POST['valor']);
            $valor = str_replace(',', '.', $valor);
            $anuncio->setValor($valor);                       
            
            $idAnuncio = $anuncio->_salvar();
            $idAnuncio = (empty ($idAnuncio)) ? $anuncio->getIdAnuncio() : $idAnuncio;
            $idImovel = $anuncio->getIdImovel();
            
            $msg = 'Seu anúncio foi publicado com sucesso!';
            
            //GRAVAÇÃO DAS IMAGENS//////////////////////////////////////////////
            //Tamanho máximo do arquivo (em Bytes)        
            $tamanho = 2; //2Mb
            $_UP['tamanho'] = 1024 * 1024 * $tamanho;

            //extensões permitidas
            $_UP['extensoes'] = array('jpg', 'JPG', 'jpeg', 'JPEG');

            $imagem = new AnuncioImagem($cnx);
            $img_imovel = new ImovelFoto($cnx);
            
            //caso ja exista imagem cadastrada atualizar as mesmas
            if (isset ($_POST['ordemImgCad'])) {
                //remove as imagens existentes
                $imagem->setIdAnuncio($idAnuncio);
                $imagem->excluirImagensDoAnuncio();    
                $ordemImg = $_POST['ordemImgCad'];
                $codImg   = $_POST['codImgCad'];
                $nomeImg  = $_POST['nomeImgCad'];
                $descImg  = $_POST['descImgCad'];

                for ($i = 0; $i < count($_POST['ordemImgCad']); $i++) {
                    if ($codImg[$i] > 0 && $nomeImg[$i] != 'i_img_nv') {
                        $img = $nomeImg[$i]; 
                        $imagem->setIdAnuncio($idAnuncio);                            
                        $imagem->setOrdem((empty ($ordemImg[$i])) ? 1 : $ordemImg[$i]);
                        $imagem->setDescricao($descImg[$i]);
                        $imagem->setImagem($img);
                        $imagem->_salvar();
                    }            
                }
            }  
            
            $temImagens = ($_FILES) ? ((count($_FILES) == 1 && $_FILES['img']['name'][0] == '') ? false : true) : false;

            if ($temImagens) {
                
                $ordemImg = $_POST['ordemImg'];            
                $descImg  = $_POST['descImg'];

                //caso o diretorio do banco de upload nao exista o sistema criará automaticamente
                $diretorio = '../../../images/upload/';
                if (!file_exists($diretorio)) {
                    mkdir($diretorio);
                }

                $podeExecutar = true; //flag de execução de bloco
                $extensao = ''; //extensao do arquivo corrente

                $arquivo = $_FILES['img'];            
                for ($i = 0; $i < count($arquivo['name']); $i++) {
                    $extensao = strtolower(end(explode('.', $arquivo['name'][$i])));                
                    if (array_search($extensao, $_UP['extensoes']) === false) {                    
                        $msg .= ' \n => A imagem "'.$arquivo['name'][$i].'" não foi gravada porque a extenção é invalida.';
                        $podeExecutar = false;
                    }

                    //verifica o tamanho do arquivo
                    if ($_UP['tamanho'] < $arquivo['size'][$i]) {        
                        $msg .= ' \n => A imagem "'.$arquivo['name'][$i].'" não foi gravada porque o tamanho é mario que '.$tamanho.'Mb.';                                        
                        $podeExecutar = false;
                    }

                    //persistir no banco de dados
                    if ($podeExecutar) {
                        //salva as novas imagens para o anuncio
                        $img = $idImovel.'_'.md5($arquivo['tmp_name'][$i]).'.jpg'; 
                        $imagem->setIdAnuncio($idAnuncio);
                        $imagem->setOrdem((empty ($ordemImg[$i])) ? 1 : $ordemImg[$i]);
                        $imagem->setDescricao($descImg[$i]);
                        $imagem->setImagem($img);
                        $imagem->_salvar();
                        
                        //salva as novas imagens no imovel                        
                        $img_imovel->setIdImovel($idImovel);                            
                        $img_imovel->setOrdem((empty ($ordemImg[$i])) ? 1 : $ordemImg[$i]);
                        $img_imovel->setDescricao($descImg[$i]);
                        $img_imovel->setFoto($img);
                        $img_imovel->_salvar();
                        
                        //copia a imagem para o servidor
                        $img = $diretorio.$img; 
                        (copy($arquivo['tmp_name'][$i],$img));
                    }
                    $podeExecutar = true;
                }
            }            
            
            $cnx->fimTransacao();
        } catch (Exception $e) {
            $cnx->fimTransacao();
            $msg = 'Erro ao tentar publicar o anúncio!';
        }
        //header('Location: ../../../sistema.php?action=anunciocad&idanuncio='.$idAnuncio.'&return='. Utilitarios::criptografa($msg));
        header('Location: ../../../sistema.php?action=anunciolista&return='. Utilitarios::criptografa($msg));
    } else {
        header('Location: ../../../sistema.php?action=anunciocad&idanuncio='.$idAnuncio.'&return='.Utilitarios::criptografa('Falha ao tentar executar a operação. Método de envio inválido!'));
    }
?>