<?php
    include_once '../../../config.php';

    try {        
        $status = 'ERRO';        
        if (isset ($_SESSION['idPessoaProprietario'])) {        
                                    
            $cnx = Conf::pegCnxPadrao();
            $obj = new Pessoa($cnx);
            $usuario = new Usuario($cnx);

            $obj->setDados($_POST);
            $obj->setIdPessoaProprietario((isset($_POST['idPessoa']))?$_POST['idPessoa']:0);
            $obj->setFlagCredenciado('S');            
            
            //Tamanho máximo do arquivo (em Bytes)        
            $tamanho = 2; //2Mb
            $_UP['tamanho'] = 1024 * 1024 * $tamanho;

            //extensões permitidas
            $_UP['extensoes'] = array('jpg', 'JPG');            
            
            $novaFoto = ($_FILES) ? ((count($_FILES) == 1 && $_FILES['img']['name'][0] == '') ? false : true) : false;
            $msg_logo = '';
            if ($novaFoto) {
                $arquivo = $_FILES['img'];
                /*caso o diretorio do banco de upload nao exista o sistema criará 
                 * automaticamente*/
                $diretorio = '../../../images/upload/';
                if (!file_exists($diretorio)) {
                    mkdir($diretorio);
                }

                $podeExecutar = true; //flag de execução de bloco
                $extensao = ''; //extensao do arquivo corrente

                $i = 0;
                $extensao = strtolower(end(explode('.', $arquivo['name'][$i])));                
                if (array_search($extensao, $_UP['extensoes']) === false) {                    
                    $msg_logo = ' \n => A imagem "'.$arquivo['name'][$i].'" não foi gravada porque a extenção é invalida.';
                    $podeExecutar = false;
                }

                //verifica o tamanho do arquivo
                if ($_UP['tamanho'] < $arquivo['size'][$i]) {        
                    $msg_logo .= ' \n => A imagem "'.$arquivo['name'][$i].'" não foi gravada porque o tamanho é mario que '.$tamanho.'Mb.';                                        
                    $podeExecutar = false;
                }

                //persistir no banco de dados
                if ($podeExecutar) {
                    $img = md5($arquivo['tmp_name'][$i]).'.jpg'; 
                    $obj->setFoto($img);                    
                    $img = $diretorio.$img; 
                    (copy($arquivo['tmp_name'][$i],$img));
                }
                $podeExecutar = true;
            }

            $inserindo = ($obj->getIdPessoa() == '') ?  true : false;
                        
            $id = $obj->_salvar();            
            
            if ($inserindo) {
                //colocando o proprietario do credenciado para ele mesmo
                $obj->setIdPessoa($id);
                $obj->atualizaIdProprietarioCredenciado();
                
                $usuario->setIdPessoa($id);
                $usuario->setIdPapel(2); //ADMINISTRADOR
                $usuario->setDominio($_POST['dominio']);
                $usuario->setLogin($_POST['usuario']);
                $usuario->setSenha($_POST['senha']);
                $usuario->setBloqueado('N');
                $usuario->setLogado('N');
                $usuario->setAcessos(0);                
                $usuario->gravar();
            }           
            $msg = 'Credenciado salvo com sucesso!'.$msg_logo;
        }        
        $retorno =  array('status'=>$status,'id'=>$id);
    } catch (PDOException $e) {
        //$cnx->fimTransacao();
        //$retorno =  array('status'=>'ERRO '.$e);
        $msg = 'Erro ao tentar salvar o credenciado!';
    }
    header('Location: ../../../sistema.php?action=credenciadocad&idcredenciado='.$id.'&return='.Utilitarios::criptografa($msg));    
?>