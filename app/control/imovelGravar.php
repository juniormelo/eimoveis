<?php
    include_once '../../config.php';
    try {
        $cnx = Conf::pegCnxPadrao();
        $util = new Utilitarios();        
        $imovel = new Imovel($cnx);        
        $imovelCarac = new ImovelCaracteristica($cnx);
        $imovelProx = new ImovelProximidade($cnx);

        $cnx->iniTransacao();

        //verificando o proprietario
        $proprietarioCadDiferente = false;
        $idPessoaProprietarioImovel = $_SESSION['idPessoaProprietario']; //o proprio e o proprietario (uma imobiliaria esta cadastrando um imovel caso a mesma seja proprietario do imovel o id vai ser o dela)
        if (strtolower($_POST['tipoProprietario']) == 't') { //terceiro
            $pessoa = new Pessoa($cnx);
            $pessoa->setTipo($_POST['tipo']);
            $pessoa->setIdEstadoCivil((isset ($_POST['idEstadoCivil'])) ? $_POST['idEstadoCivil']: '0');
            $pessoa->setCpf_cnpj($_POST['cpf_cnpj']);
            $pessoa->setRg_ie($_POST['rg_ie']);            
            $pessoa->setDtNascimento($_POST['dtNascimento']);            
            $pessoa->setIdPessoa($_POST['idPessoa']);
            $pessoa->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
            $pessoa->setRazao($_POST['razao']);
            $pessoa->setFantasia($_POST['fantasia']);
            $pessoa->setGenero($_POST['genero']);            
            $pessoa->setCep($util->removeMascara($_POST['proCep']));
            $pessoa->setLogradouro($_POST['proLogradouro']);
            $pessoa->setNumLogradouro($_POST['proNumLogradouro']);
            $pessoa->setComplemento($_POST['proComplemento']);
            $pessoa->setPontoReferencia($_POST['proPontoReferencia']);
            $pessoa->setBairro($_POST['proBairro']);
            $pessoa->setCidade($_POST['proCidade']);
            $pessoa->setUf($_POST['proUf']);
            $pessoa->setPais($_POST['proPais']);
            $pessoa->setObservacao($_POST['proObservacao']);
            $pessoa->setTelefone($_POST['telefone']);
            $pessoa->setFax($_POST['fax']);
            $pessoa->setCelular($_POST['celular']);
            $pessoa->setEmail($_POST['email']);
            $pessoa->setSite($_POST['site']);
            $pessoa->setFlagCliente('S');

            $proprietarioCadDiferente = ($_SESSION['idPessoaProprietario'] == $pessoa->getIdPessoaProprietarioDB()) ? false : true;

            if ($proprietarioCadDiferente) {
                $pessoa->setIdPessoa('');
            } else {
                $pessoa->setIdPessoa($_POST['idPessoa']);
            }                        
            $idPessoaProprietarioImovel = $pessoa->_salvar();
            $idPessoaProprietarioImovel = (empty ($idPessoaProprietarioImovel)) ? $pessoa->getIdPessoa() : $idPessoaProprietarioImovel;
        }

        $imovel->setDados($_POST);        
        $imovel->setCep($util->removeMascara($imovel->getCep()));
        $imovel->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
        $imovel->setIdProprietarioImovel($idPessoaProprietarioImovel);

        if ($proprietarioCadDiferente) { //caso o proprietario de cadastro seja diferente cadastra o mesmo imovel para outro proprietario de cadastro
            $imovel->setIdImovel('');
        }

        $idImovel = $imovel->_salvar();
        $idImovel = (empty ($idImovel)) ? $imovel->getIdImovel() : $idImovel;

        //gravando as caracteristicas.
        if (isset ($_POST['idCaracteristica'])) {
            $idCaracteristicas = $_POST['idCaracteristica'];
            $caracteristicas = $_POST['caracteristica'];
            $imovelCarac->setIdImovel($idImovel);
            $imovelCarac->excluirCaracteristicasDoImovel();
            for ($i = 0; $i < count($idCaracteristicas); $i++) {
                $imovelCarac->setIdCaracteristica($idCaracteristicas[$i]);
                $imovelCarac->setDescricao($caracteristicas[$i]);
                $imovelCarac->_salvar();
            }
        }

        //gravando as proximidades.
        if (isset ($_POST['idProximidade'])) {
            $idProximidades = $_POST['idProximidade'];
            $proximidades = $_POST['proximidade'];
            $imovelProx->setIdImovel($idImovel);
            $imovelProx->excluirProximidadesDoImovel();
            for ($i = 0; $i < count($idProximidades); $i++) {
                $imovelProx->setIdProximidade($idProximidades[$i]);
                $imovelProx->setDescricao($proximidades[$i]);
                $imovelProx->_salvar();
            }
        }

        $msg = 'Imóvel salvo com sucesso!';

        ////////////////////////////////////////////////////////////////////////
        //GRAVAÇÃO DAS IMAGENS//////////////////////////////////////////////////
        ////////////////////////////////////////////////////////////////////////
        //Tamanho máximo do arquivo (em Bytes)        
        $tamanho = 2; //2Mb
        $_UP['tamanho'] = 1024 * 1024 * $tamanho;

        //extensões permitidas
        $_UP['extensoes'] = array('jpg', 'JPG');
        
        $imagem = new ImovelFoto($cnx);
        
        //caso ja exista imagem cadastrada atualizar as mesmas
        if (isset ($_POST['ordemImgCad'])) {
            //remove as imagens existentes
            $imagem->setIdImovel($idImovel);
            $imagem->excluirFotosDoImovel();

            $ordemImg = $_POST['ordemImgCad'];
            $codImg   = $_POST['codImgCad'];
            $nomeImg  = $_POST['nomeImgCad'];
            $descImg  = $_POST['descImgCad'];

            for ($i = 0; $i < count($_POST['ordemImgCad']); $i++) {
                if ($codImg[$i] > 0 && $nomeImg[$i] != 'i_img_nv') {
                    $img = $nomeImg[$i]; 
                    $imagem->setIdImovel($idImovel);                            
                    $imagem->setOrdem((empty ($ordemImg[$i])) ? 1 : $ordemImg[$i]);
                    $imagem->setDescricao($descImg[$i]);
                    $imagem->setFoto($img);
                    $imagem->_salvar();
                }            
            }
        }                
        
        $temImagens = ($_FILES) ? ((count($_FILES) == 1 && $_FILES['img']['name'][0] == '') ? false : true) : false;

        if ($temImagens) {            
            $ordemImg = $_POST['ordemImg'];            
            $descImg  = $_POST['descImg'];
            
            //caso o diretorio do banco de upload nao exista o sistema criará automaticamente
            $diretorio = '../../images/upload/';
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
                    $img = $idImovel.'_'.md5($arquivo['tmp_name'][$i]).'.jpg'; 
                    $imagem->setIdImovel($idImovel);                            
                    $imagem->setOrdem((empty ($ordemImg[$i])) ? 1 : $ordemImg[$i]);
                    $imagem->setDescricao($descImg[$i]);
                    $imagem->setFoto($img);
                    $imagem->_salvar();                    
                    //copia a imagem para o servidor
                    $img = $diretorio.$img; 
                    (copy($arquivo['tmp_name'][$i],$img));
                }
                $podeExecutar = true;
            }
        }
        $cnx->fimTransacao();
    } catch (PDOException $e) {
        $cnx->fimTransacao();
        $msg = 'Erro ao tentar salvar o imóvel!';
    }    
    header('Location: ../../sistema.php?action=imovelcad&idimovel='.$idImovel.'&return='.$util->criptografa($msg));    
?>