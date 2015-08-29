<?php
Sessao::temPermissao('anunciocad');
include_once 'app/view/backend/menupadrao.php';
$anuncio = new Anuncio(Conf::pegCnxPadrao());
$titulo = 'Anunciar';
$temImagens = false;
if (isset($_GET['idanuncio'])) {
    $titulo = 'Editar anuncio';
    $anuncio->set_idPessoaProprietario($_SESSION['idPessoaProprietario']);
    $anuncio->setIdAnuncio($_GET['idanuncio']);
    $anuncio->preecheObjeto();
    
    $temImagens = (sizeof($anuncio->get_imagens()) > 0);    
}

$imovel = new Imovel(Conf::pegCnxPadrao());
$imovel->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
$imovel->setIdImovel($anuncio->getIdImovel());
$imoveis = $imovel->getSemAnuncio();
?>

<div class="main-content">

    <div class="breadcrumbs" id="breadcrumbs">
        <script type="text/javascript">
            try {
                ace.settings.check('breadcrumbs', 'fixed')
            } catch (e) {
            }
        </script>

        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="sistema.php">Início</a>
            </li>
            <li class="active">Anúncio</li>
        </ul>					
    </div>

    <div class="page-content">

        <!-- <div class="page-header">
            <h1 style="text-align: center; font-weight: bold">
            <h1>
                <?= $titulo ?>
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    overview &amp; stats
                </small>
            </h1>
        </div>--><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <?php if (sizeof($imoveis) > 0) { ?>                    
                    <form id="frmAnunciar" class="form-horizontal" role="form" name="frmanuncio" method="post" enctype="multipart/form-data" action="app/control/backend/anuncioGravar.php">
                        <!-- PAGE CONTENT BEGINS -->            
                        <div class="row">
                            <div class="col-xs-12">

                                <!-- -->

                                <div class="widget-box">
                                    <div class="widget-header widget-header-blue widget-header-flat">
                                        <h4 class="widget-title lighter"><strong>Siga os passos abaixo para publicar o seu anúncio</strong></h4>
                                        <!--<div class="widget-toolbar">
                                            <label>
                                                <small class="green">
                                                    <b>Validation</b>
                                                </small>
                                                <input id="skip-validation" type="checkbox" class="ace ace-switch ace-switch-4" />
                                                <span class="lbl middle"></span>
                                            </label>
                                        </div>-->
                                    </div>

                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <!-- #section:plugins/fuelux.wizard -->
                                            <div id="fuelux-wizard" data-target="#step-container">
                                                <!-- #section:plugins/fuelux.wizard.steps -->
                                                <ul class="wizard-steps">
                                                    <li data-target="#step1" id="step1_t" class="active">
                                                        <span class="step">1</span>
                                                        <span class="title">Informações do anúncio</span>
                                                    </li>

                                                    <li data-target="#step2" id="step2_t">
                                                        <span class="step">2</span>
                                                        <span class="title">Seleção de imagens</span>
                                                    </li>

                                                    <li data-target="#step3" id="step3_t">
                                                        <span class="step">3</span>
                                                        <span class="title">Contato</span>
                                                    </li>

                                                    <li data-target="#step4" id="step4_t">
                                                        <span class="step">4</span>
                                                        <span class="title">Publicação</span>
                                                    </li>
                                                </ul>

                                                <!-- /section:plugins/fuelux.wizard.steps -->
                                            </div>

                                            <hr />

                                            <!-- #section:plugins/fuelux.wizard.container -->
                                            <div class="step-content pos-rel" id="step-container">                                                
                                                <div class="step-pane active" id="step1">
                                                    <!--<h3 class="lighter block green">Insira as seguintes informações</h3><hr/>-->
                                                    <!--<fieldset><legend>Informações do anúncio:</legend>-->
                                                    <?php if (isset($_GET['idanuncio'])) : ?>
                                                        <input type="hidden" id="idAnuncio" name="idAnuncio" value="<?= $anuncio->getIdAnuncio() ?>" />
                                                    <?php endif; ?>

                                                    <?php if ($anuncio->get_codigo() != '') : ?>                                                            
                                                        <div class="form-group">
                                                            <label for="codigo" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Código:</label>
                                                            <div class="col-xs-12 col-sm-5">
                                                                <input type="text" id="codigo" class="obrigatorio width-100" name="codigo" title="Código" value="<?= $anuncio->get_codigo() ?>" readonly="" disabled=""/>
                                                            </div>
                                                        </div>                                                            
                                                    <?php endif; ?>

                                                    <div class="form-group">
                                                        <label for="idTipo" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Finalidade:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <select id="idTipo" class="width-100" name="idTipo">
                                                                <option value="0"> -- Selecione a finalidade -- </option>
                                                                <?php
                                                                $tipo = new AnuncioTipo(Conf::pegCnxPadrao());
                                                                Utilitarios::preencheComboDB($tipo->getCadastrados(), $anuncio->getIdTipo());
                                                                ?>                
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="idImovel" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Imóvel:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <select id="idImovel" class="width-100" name="idImovel">
                                                                <option value="0"> -- Selecione um imóvel -- </option>
                                                                <?php Utilitarios::preencheComboDB($imoveis, $anuncio->getIdImovel()); ?>
                                                            </select>
                                                            <!--&nbsp;&nbsp;<a href="javascript:exibirInfoImovel()"><strong>[ Exibir informações sobre o imóvel ]</strong></a>-->
                                                            <h4 class="pink" id="linkinfoimovel" style="display: none">
                                                                <i class="ace-icon fa fa-hand-o-right green"></i>
                                                                <a href="javascript:exibirInfoImovel();" role="button" class="blue" data-toggle="modal"> Exibir informações sobre o imóvel </a>
                                                            </h4>                                                            
                                                        </div>
                                                    </div>

                                                    <!--<div class="form-group">
                                                        <label for="posicao" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Posição:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <select id="posicao" class="width-100" name="posicao">            
                                                                <option value="B">Banner</option>
                                                                <option value="D">Destaque</option>
                                                                <option value="N" selected="selected">Normal</option>
                                                            </select>
                                                        </div>
                                                    </div>-->

                                                    <div class="form-group">
                                                        <label for="exibirMapa" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Exibir mapa:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <select id="exibirMapa" class="width-100" name="exibirMapa">
                                                                <option value="S">Sim</option>
                                                                <option value="N">Não</option>                                                                
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="valor" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Valor R$:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <input type="text" id="valor" class="obrigatorio width-100 decimal" name="valor" title="Valor" value="<?= Utilitarios::formatarMoeda($anuncio->getValor()) ?>" placeholder="Informe o valor do anúncio" onkeypress="return(MascaraMoeda(this,'.',',',event))"/>
                                                            
                                                            <div class="help-block col-xs-12 col-sm-reset inline">
                                                                <?=Utilitarios::msgAviso('<strong>ATENÇÃO:</strong> Se você deixar o campo valor vazio ou zerado, aparecerá <strong><i>"Valor sob consulta"</i></strong> no seu anúncio.')?>
                                                            </div>
                                                            <!--<div class="help-block col-xs-12 col-sm-reset inline">*Se o valor for igual a 0 (zero), aparecerá <strong>"Valor sob consulta"</strong> no anúncio.</div>-->
                                                            <!--<span style="font-weight: bold; color: red;"></span>-->

                                                        </div>
                                                        
                                                    </div>
                                                    

                                                    <div class="form-group">
                                                        <label for="titulo" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Título:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <input type="text" id="titulo" class="obrigatorio width-100" name="titulo" title="Título" value="<?= $anuncio->getTitulo() ?>" placeholder="Informe o título do anúncio"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="descricao" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Descrição:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <textarea id="descricao" name="descricao" rows="5" class="width-100" cols="60" placeholder="Informe a descrição do anúncio"><?= $anuncio->getDescricao() ?></textarea>
                                                        </div>
                                                    </div>
                                                    <!--</fieldset>-->

                                                </div>

                                                <div class="step-pane" id="step2">
                                                    <div>
                                                        <div id="msgimagem" style="display: none;">
                                                            <?=  Utilitarios::msgAviso('<strong>DICA:</strong> Como você já percebeu carregamos as imagens do imóvel para você, caso exista alguma imagem que não queira que apareça no seu anuncio basta excluir no botão vermelho, se achar interessante adicionar mais imagens, clique no botão abaixo "Adicionar outra imagem".') ?>
                                                        </div><br>    
                                                        <table id="tblImagens" class="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th><strong>Ordem</strong></th>
                                                                    <th><strong>Imagem</strong></th>
                                                                    <th><strong>Descrição</strong></th>
                                                                    <th><strong>Excluir</strong></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>                                                                
                                                                <?php if ($temImagens) { foreach ($anuncio->get_imagens() as $linhaFoto) : ?>
                                                                    <tr>                          
                                                                        <td width="1%">
                                                                            <input type="hidden" name="codImgCad[]" value="<?= $linhaFoto['idanuncioimagem'] ?>" />
                                                                            <input type="hidden" name="nomeImgCad[]" value="<?= $linhaFoto['imagem'] ?>" />
                                                                            <input type="text" name="ordemImgCad[]" value="<?= $linhaFoto['ordem'] ?>" class="input-mini" />
                                                                        </td>
                                                                        <td width="10%" style="text-align: center;">
                                                                            <img src="images/upload/<?= $linhaFoto['imagem'] ?>" width="125" height="100" />
                                                                        </td>
                                                                        <td width="15%">
                                                                            <input type="text" name="descImgCad[]" value="<?= $linhaFoto['descimagem'] ?>" class="input-sm"/>
                                                                        </td>                          
                                                                        <td width="1%">
                                                                            <a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                                                        </td>
                                                                    </tr>                                                                
                                                                <?php endforeach; } else { ?>
                                                                    <tr>
                                                                        <td width="1%">
                                                                            <input type="hidden" name="codImg[]" value="0" />
                                                                            <input type="hidden" name="nomeImg[]" value="i_img_nv" />
                                                                            <input type="text" name="ordemImg[]" value="1" class="input-mini"/>
                                                                        </td>
                                                                        <td width="10%">
                                                                            <input type="file" name="img[]" id="id-input-file-2" />
                                                                        </td >
                                                                        <td width="15%"><input type="text" name="descImg[]" class="width-100"/></td>                          
                                                                        <td width="1%"><a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>                                                            
                                                        </table>
                                                        
                                                        <div style="text-align: right; padding: 0px;"><hr />                                                            
                                                            <button class="btn btn-sm btn-primary" type="button" id="btnAddImg" name="btnAddImg">
                                                                <i class="ace-icon fa fa-plus icon-on-right bigger-125"></i>
                                                                <strong>Adicionar outra imagem</strong>
                                                            </button>
                                                        </div>
                                                        
                                                        <!--<div class="alert alert-success">
                                                            <button type="button" class="close" data-dismiss="alert">
                                                                <i class="ace-icon fa fa-times"></i>
                                                            </button>

                                                            <strong>
                                                                <i class="ace-icon fa fa-check"></i>
                                                                Well done!
                                                            </strong>

                                                            You successfully read this important alert message.
                                                            <br />
                                                        </div>-->

                                                        <!--<div class="alert alert-danger">
                                                            <button type="button" class="close" data-dismiss="alert">
                                                                <i class="ace-icon fa fa-times"></i>
                                                            </button>

                                                            <strong>
                                                                <i class="ace-icon fa fa-times"></i>
                                                                Oh snap!
                                                            </strong>

                                                            Change a few things up and try submitting again.
                                                            <br />
                                                        </div>-->

                                                        <!--<div class="alert alert-warning">
                                                            <button type="button" class="close" data-dismiss="alert">
                                                                <i class="ace-icon fa fa-times"></i>
                                                            </button>
                                                            <strong>Warning!</strong>

                                                            Best check yo self, you're not looking too good.
                                                            <br />
                                                        </div>-->

                                                        <!--<div class="alert alert-info">
                                                            <button type="button" class="close" data-dismiss="alert">
                                                                <i class="ace-icon fa fa-times"></i>
                                                            </button>
                                                            <strong>Heads up!</strong>

                                                            This alert needs your attention, but it's not super important.
                                                            <br />
                                                        </div>-->
                                                    </div>
                                                </div>

                                                <div class="step-pane" id="step3">
                                                    <!--<h3 class="blue lighter">Informações de contato</h3>-->
                                                    <div class="center"></div>                                                    
                                                    <!--<fieldset><legend>Informações de contato:</legend>-->                                                    

                                                    <div class="form-group">
                                                        <label for="telefone1" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Telefone 1:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <input type="text" id="telefone1" class="obrigatorio width-100 telefone" name="telefone1" title="Telefone 1" value="<?= $anuncio->getTelefone1() ?>" placeholder="Telefone para contato"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="telefone2" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Telefone 2:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <input type="text" id="telefone2" class="obrigatorio width-100 telefone" name="telefone2" title="Telefone 2" value="<?= $anuncio->getTelefone2() ?>" placeholder="Telefone para contato"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="email" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">E-mail:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <input type="text" id="email" class="obrigatorio width-100" name="email" title="E-mail" value="<?= $anuncio->getEmail() ?>" placeholder="Informe um e-mail para contato"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="responsavel" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Responsável:</label>
                                                        <div class="col-xs-12 col-sm-5">
                                                            <input type="text" id="responsavel" class="obrigatorio width-100" name="responsavel" title="Responsável" value="<?= $anuncio->getResponsavel() ?>" placeholder="Nome do responsável"/>
                                                        </div>
                                                    </div>

                                                    <!--<div class="form-group">
                                                            <label for="inputError2" class="col-xs-12 col-sm-3 control-label no-padding-right" style="font-weight: bold;">Input with error</label>

                                                            <div class="col-xs-12 col-sm-5">
                                                                    <span class="input-icon block">
                                                                            <input type="text" id="inputError2" class="width-100" />                                                                            
                                                                    </span>
                                                            </div>
                                                            <div class="help-block col-xs-12 col-sm-reset inline"> Error tip help! Error tip help! Error tip help! </div>
                                                    </div>-->
                                                    <!--</fieldset>-->                                                    
                                                </div>

                                                <div class="step-pane" id="step4">
                                                    <div class="center">
                                                        <h2 class="green"><strong>Parabéns!</strong></h2>
                                                        <h4>Seu anúncio está pronto para ser publicado! Clique em <strong><i>"Concluir"</i></strong> para finalizar!</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- /section:plugins/fuelux.wizard.container -->
                                            <hr />
                                            <div class="wizard-actions">
                                                <!-- #section:plugins/fuelux.wizard.buttons -->
                                                <button type="button" class="btn btn-info" id="btnLista">
                                                    <i class="ace-icon fa fa-arrow-left"></i>
                                                    <strong>Meus anúncios</strong>
                                                </button>
                                                <button type="button" class="btn btn-prev">
                                                    <i class="ace-icon fa fa-arrow-left"></i>
                                                    Voltar
                                                </button>

                                                <button type="button" class="btn btn-success btn-next" data-last="Concluir" id="btnAvancar"> <!-- btn-next -->
                                                    Avançar
                                                    <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                                </button>

                                                <!-- /section:plugins/fuelux.wizard.buttons -->
                                            </div>
                                            <!-- /section:plugins/fuelux.wizard -->
                                        </div><!-- /.widget-main -->
                                    </div><!-- /.widget-body -->
                                </div>
                            </div>
                        </div>
                    </form>
                
                    <div id="modal-info-imovel" class="modal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="blue bigger"><strong>Informações do imóvel</strong></h4>
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-xs-12" >
                                            <div class="carregando" ><img src="images/ajax-loader.gif"><br />carregando...</div>
                                            <div id="infoimovel"></div>                                            
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-sm btn-danger" data-dismiss="modal">
                                        <i class="ace-icon fa fa-times"></i>
                                        <strong>Fechar</strong>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                } else {
                    Utilitarios::msgAtencao('TODOS OS SEUS IMÓVEIS CADASTRADOS JÁ ESTÃO ANUNCIADOS.');
                    Utilitarios::msgSucesso('<strong>DICA 1:</strong> Se deseja criar um novo anúncio para um imóvel existente, você deve cancelar o anúncio que está utilizando o IMÓVEL desejado.');
                    Utilitarios::msgSucesso('<strong>DICA 2:</strong> Se não tem o imóvel cadastrado clique <a href="sistema.php?action=imovelcad">AQUI</a>');
                    Utilitarios::msgAviso('<a href="sistema.php?action=anunciolista">Clique aqui para retornar aos seus anúncios.</a>');
                }
                ?>
            </div>
        </div>
    </div>
    <?php if (sizeof($imoveis) > 0) : ?>                  

        <script type="text/javascript" src="js/backend/anuncio.js"></script>
        <script type="text/javascript">
            $('document').ready(function(){
                <?php if (isset ($_GET['return'])) : if ($_GET['return'] != '') : ?>
                        
                    alert(<?= "'".Utilitarios::descriptografa($_GET['return'])."'"; ?>);
                    
                <?php endif; endif; ?>                    
            });
            
            <?php if ($anuncio->getIdTipo() != '') : ?> 

                $('#idTipo').val('<?= $anuncio->getIdTipo() ?>');
                
            <?php endif; if ($anuncio->getPosicao() != '') : ?> 
                
                $('#posicao').val('<?= $anuncio->getPosicao() ?>'); 
                
            <?php endif; if ($anuncio->getExibirMapa() != '') : ?>
                
                $('#exibirMapa').val('<?= $anuncio->getExibirMapa() ?>');
                
            <?php endif; ?>                
        </script>

    <?php endif; ?>
</div>