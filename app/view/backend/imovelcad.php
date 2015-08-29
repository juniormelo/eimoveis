<?php 
    Sessao::temPermissao('imovelcad');
    include_once 'app/view/backend/menupadrao.php'; 
?>

<div class="main-content">
    
<?php
    $imovel = new Imovel(Conf::pegCnxPadrao());
    $proprietario = new Pessoa(Conf::pegCnxPadrao());
    $pTerceiro = false;
    $ePessoaFisica = false;
    $titulo = 'Cadastrar imóvel';
    if (isset ($_GET['idimovel'])) {
        $titulo = 'Editar imóvel';
        $idImovel = (int) $_GET['idimovel'];
        $imovel->setIdImovel($idImovel);        
        $imovel->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
        $imovel->preencheObjeto();
        $idImovel = $imovel->getIdImovel();        
        if ($imovel->getIdPessoaProprietario() != $imovel->getIdProprietarioImovel()) {
            $proprietario->_preecheObjeto($imovel->getIdProprietarioImovel());
            $pTerceiro = true;
            $ePessoaFisica = ($proprietario->getTipo() == 'F') ? true : false ;            
        }
        $imovelCarac = new ImovelCaracteristica(Conf::pegCnxPadrao());
        $imovelCarac->setIdImovel($idImovel);
        $dsetCaracteristicas = $imovelCarac->getCaracteristicas();
        
        $imovelProx = new ImovelProximidade(Conf::pegCnxPadrao());
        $imovelProx->setIdImovel($idImovel);
        $dsetProx = $imovelProx->getProximidades();        
        
        $imovelFoto = new ImovelFoto(Conf::pegCnxPadrao());
        $imovelFoto->setIdImovel($idImovel);
        $dsetFoto = $imovelFoto->getFotos();        
    }    
?>

<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="sistema.php">Início</a>
        </li>
        <li class="active">Imóveis</li>
    </ul>					
</div>

<div class="page-content">

    <div class="page-header">
        <!--<h1 style="text-align: center; font-weight: bold">-->
        <h1>
            <?=$titulo?>
            <!--<small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                overview &amp; stats
            </small>-->
        </h1>
    </div><!-- /.page-header -->
    
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12"><br />
                    <form id="fmCadImovel" class="form-horizontal" role="form" name="fmCadImovel" method="post" enctype="multipart/form-data" action="app/control/imovelGravar.php">
                        <div class="tabbable">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active">
                                    <a data-toggle="tab" href="#info">
                                        <!--<i class="green ace-icon fa fa-home bigger-120"></i>-->
                                        <strong>Informações</strong>
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#endereco">
                                        <strong>Endereço</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#caracteristicas">
                                        <strong>Caracteristicas</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#proximidade">
                                        <strong>Proximidades</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#imagens">
                                        <strong>Imagens</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#proprietario">
                                        <strong>Proprietário</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#anuncio">
                                        <strong>Anunciar</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="info" class="tab-pane in active">
                                    <fieldset>
                                        <legend><strong>Informações gerais</strong></legend>
                                        <?php if (isset ($_GET['idimovel'])) : ?>
                                            <input type="hidden" id="idImovel" name="idImovel" value="<?= $imovel->getIdImovel(); ?>" />
                                        <?php endif; ?> 

                                        <?php if ($imovel->get_codigo() != '') :?>                                     
                                            <div id="" class="form-group">
                                                <label class="col-sm-2 control-label no-padding-right" for="codigo"><strong>Código: </strong></label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="codigo" class="col-xs-10 col-sm-5" name="codigo" title="Código" value="<?= $imovel->get_codigo(); ?>" readonly="" disabled="" />
                                                </div>
                                            </div>
                                        <?php endif;?>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="idCategoria"><strong>Categoria: </strong></label>
                                            <div class="col-sm-9">
                                                <select id="idCategoria" class="col-xs-10 col-sm-5" name="idCategoria">
                                                    <option value="-1">-- Selecione uma categoria --</option>
                                                    <?php
                                                        $categoria = new ImovelCategoria(Conf::pegCnxPadrao());
                                                        Utilitarios::preencheComboDB($categoria->getCadastradas(),$imovel->getIdCategoria());
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="descricao"><strong>Descrição: </strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="descricao" class="obrigatorio col-xs-10 col-sm-5" name="descricao" title="Descrição" value="<?= $imovel->getDescricao(); ?>" placeholder="Descrição do imóvel"/>
                                            </div>
                                        </div>
                                            
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="observacao"><strong>Observações: </strong></label>
                                            <div class="col-sm-9">
                                                <textarea id="observacao" class="col-xs-10 col-sm-5" name="observacao" rows="5" cols="50" ><?= $imovel->getObservacao(); ?></textarea>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div id="endereco" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Dados de Endereço</strong></legend>                                            
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="cep"><strong>Cep: </strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="cep" class="cep" name="cep" class="col-xs-10 col-sm-5" value="<?=$imovel->getCep();?>" onBlur="getEndereco('cep','logradouro','bairro','cidade','uf','pais','msgcep')" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="proCep" class="col-sm-2 control-label no-padding-right" style="font-weight: bold"></label>
                                            <div class="col-sm-9"><div id="msgcep"></div></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="logradouro"><strong>Logradouro: </strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="logradouro" class="col-xs-10 col-sm-5" name="logradouro" value="<?= $imovel->getLogradouro(); ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="numLogradouro"><strong>Número: </strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="numLogradouro" class="col-xs-10 col-sm-5" name="numLogradouro" value="<?= $imovel->getNumLogradouro(); ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="complemento"><strong>Complemento: </strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="complemento" class="col-xs-10 col-sm-5" name="complemento" value="<?= $imovel->getComplemento(); ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="bairro"><strong>Bairro: </strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="bairro" class="col-xs-10 col-sm-5" name="bairro" value="<?= $imovel->getBairro(); ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="cidade"><strong>Cidade: </strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="cidade" class="col-xs-10 col-sm-5" name="cidade" value="<?= $imovel->getCidade(); ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="uf"><strong>UF: </strong></label>
                                            <div class="col-sm-9">
                                                <select id="uf" class="col-xs-10 col-sm-5" name="uf">
                                                    <option value="AC">AC</option><option value="AL">AL</option><option value="AM">AM</option>
                                                    <option value="AP">AP</option><option value="BA">BA</option><option value="CE">CE</option>
                                                    <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                                                    <option value="MA">MA</option><option value="MG">MG</option><option value="MS">MS</option>
                                                    <option value="MT">MT</option><option value="PA">PA</option><option value="PB">PB</option>
                                                    <option value="PE">PE</option><option value="PI">PI</option><option value="PR">PR</option>
                                                    <option value="RJ">RJ</option><option value="RN">RN</option><option value="RO">RO</option>
                                                    <option value="RR">RR</option><option value="RS">RS</option><option value="SC">SC</option>
                                                    <option value="SE">SE</option><option value="SP">SP</option><option value="TO">TO</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="pais"><strong>País: </strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="pais" class="col-xs-10 col-sm-5" name="pais" value="<?= $imovel->getPais(); ?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="pontoReferencia"><strong>Referência: </strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="pontoReferencia" class="col-xs-10 col-sm-5" name="pontoReferencia" value="<?= $imovel->getPontoReferencia(); ?>" />
                                            </div>
                                        </div>
                                        
                                    </fieldset>
                                </div>

                                <div id="caracteristicas" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Adicione as caracteristica do imóvel</strong></legend>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="idCaracteristica"><strong>Caracteristica:</strong></label>
                                            <div class="col-sm-9">
                                                <select id="idCaracteristica" class="col-xs-10 col-sm-5" >
                                                    <option value="-1"> -- Selecione uma caracteristica -- </option>
                                                    <?php
                                                        $caracteristica = new ImovelCaracteristicaTipo(Conf::pegCnxPadrao());
                                                        Utilitarios::preencheComboDB($caracteristica->getCadastradas());
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" id="seqCaracteristica" name="seqCaracteristica" />
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="idCaracteristica"><strong>Descrição:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="desCaracteristica" class="col-xs-10 col-sm-5" name="desCaracteristica" />
                                                &nbsp;&nbsp;
                                                <!--<button type="button" id="btnAddCaracteristica" class="button medium green" name="btnAddCaracteristica"><strong>Adicionar</strong></button>-->
                                                <button class="btn btn-sm btn-primary" type="button" id="btnAddCaracteristica" name="btnAddCaracteristica">
                                                    <i class="ace-icon fa fa-plus icon-on-right bigger-125"></i>
                                                    <strong>Adicionar</strong>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <hr />
                                        <table id="tblCaracteristicas" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Caracteristica</th>
                                                    <th>Descrição</th>
                                                    <th>Excluir</th>
                                                </tr>
                                            </thead>                  
                                          <tbody>
                                              <?php  if (isset ($_GET['idimovel'])) { if (sizeof($dsetCaracteristicas) > 0) { $i = 1; foreach ($dsetCaracteristicas as $linha) { ?>
                                              <tr id="<?=$linha['idCaracteristica'];?>"><td><?=$i++;?></td><td><input type="hidden" name="idCaracteristica[]" value="<?= $linha['idCaracteristica']; ?>" /><?= $linha['caracteristica']; ?></td><td><input type="hidden" name="caracteristica[]" value="<?=utf8_encode($linha['descricao']);?>" /><?=$linha['descricao'];?></td><td><a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>
                                              <?php }}} else { ?>
                                              <tr><td colspan="4" align="center"><strong><i>Nenhuma caracteristica cadastrada!</i></strong></td></tr>
                                              <?php } ?>
                                          </tbody>
                                        </table>
                                        
                                    </fieldset>
                                </div>

                                <div id="proximidade" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Adicione as proximidades do imóvel</strong></legend>
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="idProximidade"><strong>Proximidade:</strong></label>
                                            <div class="col-sm-9">
                                                <select id="idProximidade" class="col-xs-10 col-sm-5">
                                                    <option value="-1"> -- Selecione uma proximidade -- </option>
                                                    <?php
                                                        $proximidade = new ImovelProximidadeTipo(Conf::pegCnxPadrao());
                                                        Utilitarios::preencheComboDB($proximidade->getCadastradas());
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <input type="hidden" id="seqProximidade" name="seqProximidade" />
                                        
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label no-padding-right" for="desProximidade"><strong>Descrição:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="desProximidade" class="col-xs-10 col-sm-5" name="desProximidade" />
                                                &nbsp;&nbsp;
                                                <!--<button type="button" id="btnAddProximidade" class="button medium green" name="btnAddProximidade"><strong>Adicionar</strong></button>-->
                                                <button class="btn btn-sm btn-primary" type="button" id="btnAddProximidade" name="btnAddProximidade">
                                                    <i class="ace-icon fa fa-plus icon-on-right bigger-125"></i>
                                                    <strong>Adicionar</strong>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        
                                        <hr />
                                        <table id="tblProximidades" class="table table-striped table-bordered table-hover">
                                              <thead>
                                                  <tr>
                                                      <th>#</th>
                                                      <th>Proximidade</th>
                                                      <th>Descrição</th>
                                                      <th>Excluir</th>
                                                  </tr>
                                              </thead>                  
                                              <tbody>
                                                  <?php  if (isset ($_GET['idimovel'])) { if (sizeof($dsetProx) > 0) { $i = 1; foreach ($dsetProx as $linhaProx) { ?>
                                                  <tr id="<?= $linhaProx['idProximidade'] ?>"><td><?= $i++; ?></td><td><input type="hidden" name="idProximidade[]" value="<?= $linhaProx['idProximidade'] ?>" /><?= $linhaProx['proximidade']; ?></td><td><input type="hidden" name="proximidade[]" value="<?= utf8_encode($linhaProx['descricao']) ?>" /><?= $linhaProx['descricao'] ?></td><td><a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>
                                                  <?php }}} else { ?>
                                                  <tr><td colspan="4" align="center"><strong><i>Nenhuma proximidade cadastrada!</i></strong></td></tr>
                                                  <?php } ?>
                                              </tbody>
                                          </table>
                                        
                                    </fieldset>                        
                                </div>

                                <div id="imagens" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Adicione imagens do imóvel</strong></legend>
                                        
                                        <div class="alert alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">
                                                <i class="ace-icon fa fa-times"></i>
                                            </button>
                                            <strong>
                                                <i class="ace-icon fa fa-times"></i>
                                                Dica 1 - 
                                            </strong>
                                            Insira as imagens do imóvel com extenção ".jpg" com até 2Mb.
                                            
                                        </div>
                                        
                                        <div class="alert alert-warning">
                                            <button type="button" class="close" data-dismiss="alert">
                                                    <i class="ace-icon fa fa-times"></i>
                                            </button>
                                            <strong>
                                                <i class="ace-icon fa fa-times"></i>
                                                Dica 2 - 
                                            </strong>
                                            A imagem com a menor ordem será considerada como principal no portal.
                                            
                                        </div>
                                        <!--<p>
                                              <span style="color: red; font-weight: bold;">(*) - Insira as imagens do imóvel com extenção ".jpg" com até 2Mb.</span><br/>
                                              <span style="color: blue; font-weight: bold;">(*) - A imagem com a menor ordem será considerada como principal no portal.</span><br/>
                                          </p>-->
                                          
                                          <table id="tblImagens" class="table table-striped table-bordered table-hover">
                                              <thead>
                                                  <tr><th><strong>Ordem</strong></th><th><strong>Imagem</strong></th><th><strong>Descrição</strong></th><th><strong>Excluir</strong></th></tr>
                                              </thead>
                                              <tbody>
                                                  <?php  if (isset ($_GET['idimovel'])) { if (sizeof($dsetFoto) > 0) { foreach ($dsetFoto as $linhaFoto) { ?>
                                                  <tr>                          
                                                      <td width="3%">
                                                          <input type="hidden" name="codImgCad[]" value="<?= $linhaFoto['idFoto'] ?>" />
                                                          <input type="hidden" name="nomeImgCad[]" value="<?= $linhaFoto['foto'] ?>" />
                                                          <input type="text" name="ordemImgCad[]" value="<?= $linhaFoto['ordem'] ?>" class="input-mini" />
                                                      </td>
                                                      <td width="25%" style="text-align: center;">
                                                          <img src="images/upload/<?= $linhaFoto['foto'] ?>" width="125" height="100" />
                                                      </td>
                                                      <td width="3%">
                                                          <input type="text" name="descImgCad[]" value="<?= $linhaFoto['descricao'] ?>" class="input-sm"/>
                                                      </td>                          
                                                      <td width="3%">
                                                          <a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>
                                                      </td>
                                                  </tr>
                                                  <?php } } } ?>
                                                  <tr>
                                                      <td width="3%">
                                                          <input type="hidden" name="codImg[]" value="0" />
                                                          <input type="hidden" name="nomeImg[]" value="i_img_nv" />
                                                          <input type="text" name="ordemImg[]" value="1" class="input-mini"/>
                                                      </td>
                                                      <td width="25%">
                                                          <input type="file" name="img[]" id="id-input-file-2" />
                                                      </td>
                                                      <td width="3%"><input type="text" name="descImg[]" class="input-sm"/></td>                          
                                                      <td width="3%"><a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td>
                                                  </tr>                      
                                              </tbody>
                                          </table>
                                        
                                          <div style="text-align: right; padding: 0px;"><hr />
                                              <!--<button type="button" id="btnVisualizarImg" class="button medium green" name="btnVisualizarImg"><strong>Visualizar imagens</strong></button>-->
                                              <!--<button type="button" id="btnAddImg" class="button medium green" name="btnAddImg"><strong>Adicionar</strong></button>-->
                                              <button class="btn btn-sm btn-primary" type="button" id="btnAddImg" name="btnAddImg">
                                                  <i class="ace-icon fa fa-plus icon-on-right bigger-125"></i>
                                                  <strong>Adicionar outra imagem</strong>
                                              </button>
                                          </div><br />
                                        
                                    </fieldset>                         
                                </div>
                                
                                <div id="proprietario" class="tab-pane">
                                    <fieldset>
                                        <!--<legend><strong>Dados do proprietário do imóvel</strong></legend>-->
                                        
                                        <fieldset>
                                            <legend><strong>Quem é o proprietário?</strong></legend>                                                                                        
                                            
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" id="terceiro" class="ace" name="tipoProprietario" <?=($pTerceiro) ? 'checked="checked"' : ''?> value="t" />
                                                    <span class="lbl"><strong> Terceiro</strong></span>
                                                </label>
                                            </div>
                                            
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" id="proprio" class="ace" name="tipoProprietario" <?=(!$pTerceiro) ? 'checked="checked"' : ''?>  value="p" />
                                                    <span class="lbl"><strong> <?=$_SESSION['razao']?></strong></span>                                                    
                                                </label>
                                            </div>
                                        </fieldset>
                                      
                                          <div id="dadosProprietario">
                                              <hr />
                                              <br />
                                              <fieldset>
                                                  <legend>&nbsp;&nbsp;&nbsp;<strong>Natureza?</strong></legend>
                                                  <div class="radio">
                                                      <label>
                                                          <input type="radio" id="fisica" class="tipo ace" name="tipo" <?=($ePessoaFisica) ? 'checked="checked"' : ''?> value="f"/>
                                                          <span class="lbl"><strong> Pessoa Fisica</strong></span>
                                                      </label>
                                                  </div>
                                                  
                                                  <div class="radio">
                                                      <label>
                                                          <input type="radio" id="juridica" class="tipo ace" name="tipo" <?=(!$ePessoaFisica) ? 'checked="checked"' : ''?> value="j"/>
                                                          <span class="lbl"><strong> Pessoa Juridica</strong></span>
                                                      </label>
                                                  </div>
                                                  
                                                  <br />
                                              </fieldset>
                                              
                                              <br />
                                              <fieldset>
                                                  <legend>&nbsp;&nbsp;&nbsp;<strong>Dados pessoais:</strong></legend>
                                                  <input type="hidden" id="idPessoa" name="idPessoa" value="<?=$proprietario->getIdPessoa()?>" />
                                                  
                                                  <!-- 
                                                  <div class="form-group">
                                                        <label class="col-sm-2 control-label no-padding-right" for="cidade"><strong>Cidade: </strong></label>
                                                        <div class="col-sm-9">
                                                            <input type="text" id="cidade" class="col-xs-10 col-sm-5" name="cidade" value="<?= $imovel->getCidade(); ?>" />
                                                        </div>
                                                    </div>
                                                  -->
                                                  
                                                 <div class="form-group" id="lblCpf">
                                                      <label class="col-sm-2 control-label no-padding-right" style="font-weight: bold" for="cpf_cnpj">CPF:</label>
                                                      <div class="col-sm-9">
                                                        <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="col-xs-10 col-sm-5" value="<?=$proprietario->getCpf_cnpj()?>" title="CPF" onblur="localizarPessoa()"/>
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group" id="lblRazao">
                                                      <label class="col-sm-2 control-label no-padding-right" style="font-weight: bold" for="razao">Nome:</label>
                                                      <div class="col-sm-9">
                                                        <input type="text" id="razao" class="col-xs-10 col-sm-5" name="razao" value="<?=$proprietario->getRazao()?>" maxlength="100" />
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group" id="lblFantasia">
                                                      <label for="fantasia" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Apelido:</label>
                                                      <div class="col-sm-9">
                                                        <input type="text" id="fantasia" class="col-xs-10 col-sm-5" name="fantasia" value="<?=$proprietario->getFantasia()?>" maxlength="100" />
                                                      </div>                                                      
                                                  </div>
                                                  
                                                  <div class="form-group" id="lblRg">
                                                      <label for="rg_ie" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">RG:</label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="rg_ie" class="col-xs-10 col-sm-5" name="rg_ie" value="<?=$proprietario->getRg_ie()?>" maxlength="14" />
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group" id="lblNascimento">
                                                      <label for="dtNascimento" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Nascimento:</label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="dtNascimento" class="col-xs-10 col-sm-5 data" name="dtNascimento" value="<?=Utilitarios::formataData_DiaMesAno(str_replace('//', '', $proprietario->getDtNascimento()))?>" />
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group" id="lblGenero">
                                                      <label for="genero" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Sexo:</label>
                                                      <div class="col-sm-9">
                                                          <select id="genero" class="col-xs-10 col-sm-5" name="genero">
                                                              <option value="M">Masculino</option>        
                                                              <option value="F">Feminino</option>        
                                                          </select>
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group" id="lblEstadoCivil">
                                                      <label for="estadoCivil" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Estado civil:</label>
                                                      <div class="col-sm-9">
                                                          <select id="idEstadoCivil" class="col-xs-10 col-sm-5" name="idEstadoCivil">                              
                                                              <?php
                                                                $estadoCivil = new EstadoCivil(Conf::pegCnxPadrao());
                                                                Utilitarios::preencheComboDB($estadoCivil->getCadastrados(),$proprietario->getIdEstadoCivil());
                                                              ?>
                                                          </select>
                                                      </div>
                                                  </div>
                                              </fieldset>
                                              
                                              <br />
                                              <fieldset>
                                                  <legend>&nbsp;&nbsp;&nbsp;<strong>Contato:</strong></legend>
                                                  <div class="form-group">
                                                      <label for="telefone" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Telefone:</label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="telefone" class="col-xs-10 col-sm-5 telefone" name="telefone" value="<?=$proprietario->getTelefone()?>" maxlength="15" />
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="fax" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Fax:</label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="fax" class="col-xs-10 col-sm-5 telefone" name="fax" value="<?=$proprietario->getFax()?>" maxlength="15" />
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="celular" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Celular:</label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="celular" class="col-xs-10 col-sm-5 telefone" name="celular" value="<?=$proprietario->getCelular()?>" maxlength="15" />
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="email" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">E-mail:</label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="email" class="col-xs-10 col-sm-5" name="email" value="<?=$proprietario->getEmail()?>" maxlength="50" />
                                                      </div>
                                                  </div>
                                                  <div class="form-group">
                                                      <label for="site" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Site:</label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="site" class="col-xs-10 col-sm-5" name="site" value="<?=$proprietario->getSite()?>" maxlength="50" />
                                                      </div>
                                                  </div>
                                              </fieldset>
                                              
                                              <br />
                                              <fieldset>
                                                  <legend>&nbsp;&nbsp;&nbsp;<strong>Dados de endereço:</strong></legend>
                                                  <div class="form-group">
                                                      <label for="proCep" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Cep: </label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="proCep" class="col-xs-10 col-sm-5 cep" name="proCep" value="<?=$proprietario->getCep()?>" onBlur="getEndereco('proCep','proLogradouro','proBairro','proCidade','proUf','proPais','msgceppro')" />
                                                      </div>
                                                      
                                                  </div>                                                                                                    
                                                  
                                                  <div class="form-group">
                                                      <label for="proCep" class="col-sm-2 control-label no-padding-right" style="font-weight: bold"></label>
                                                      <div class="col-sm-9"><div id="msgceppro"></div></div>
                                                  </div>
                                                  
                                                  <div class="form-group">
                                                      <label for="proLogradouro" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Logradouro: </label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="proLogradouro" class="col-xs-10 col-sm-5" name="proLogradouro" value="<?=$proprietario->getLogradouro()?>"  />
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group">
                                                      <label for="proNumLogradouro" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Número: </label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="proNumLogradouro" class="col-xs-10 col-sm-5" name="proNumLogradouro" value="<?=$proprietario->getNumLogradouro()?>" />
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group">
                                                      <label for="proComplemento" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Complemento: </label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="proComplemento" class="col-xs-10 col-sm-5" name="proComplemento" value="<?=$proprietario->getComplemento()?>" />
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group">
                                                      <label for="proBairro" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Bairro: </label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="proBairro" class="col-xs-10 col-sm-5" name="proBairro" value="<?=$proprietario->getBairro()?>" />
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group">
                                                      <label for="proCidade" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Cidade: </label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="proCidade" class="col-xs-10 col-sm-5" name="proCidade" value="<?=$proprietario->getCidade()?>" />
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group">
                                                      <label for="proUf" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">UF: </label>
                                                      <div class="col-sm-9">
                                                          <select id="proUf" class="col-xs-10 col-sm-5" name="proUf">
                                                              <option value="AC">AC</option><option value="AL">AL</option><option value="AM">AM</option>
                                                              <option value="AP">AP</option><option value="BA">BA</option><option value="CE">CE</option>
                                                              <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                                                              <option value="MA">MA</option><option value="MG">MG</option><option value="MS">MS</option>
                                                              <option value="MT">MT</option><option value="PA">PA</option><option value="PB">PB</option>
                                                              <option value="PE">PE</option><option value="PI">PI</option><option value="PR">PR</option>
                                                              <option value="RJ">RJ</option><option value="RN">RN</option><option value="RO">RO</option>
                                                              <option value="RR">RR</option><option value="RS">RS</option><option value="SC">SC</option>
                                                              <option value="SE">SE</option><option value="SP">SP</option><option value="TO">TO</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group">
                                                      <label for="proPais" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">País: </label>
                                                      <div class="col-sm-9">
                                                        <input type="text" id="proPais" class="col-xs-10 col-sm-5" name="proPais" value="<?=$proprietario->getPais()?>" />
                                                      </div>
                                                  </div>
                                                  
                                                  <div class="form-group">
                                                      <label for="proPontoReferencia" class="col-sm-2 control-label no-padding-right" style="font-weight: bold">Referência: </label>
                                                      <div class="col-sm-9">
                                                          <input type="text" id="proPontoReferencia" class="col-xs-10 col-sm-5" name="proPontoReferencia" value="<?=$proprietario->getPontoReferencia()?>" size="40" />
                                                      </div>
                                                  </div>
                                              </fieldset>
                                              
                                              <br />
                                              <fieldset>
                                                  <legend>&nbsp;&nbsp;&nbsp;<strong>Outras informações:</strong></legend>
                                                  <div class="form-group">
                                                      <label for="proPontoReferencia" class="col-sm-2 control-label no-padding-right" style="font-weight: bold"></label>
                                                      <div class="col-sm-9">
                                                          <textarea id="proObservacao" class="col-xs-10 col-sm-5" name="proObservacao" rows="5" cols="50" ><?=$proprietario->getObservacao()?></textarea>
                                                      </div>
                                                  </div>
                                              </fieldset>
                                          </div>  
                                        
                                    </fieldset>
                                </div>
                                
                                <div id="anuncio" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Deseja anunciar o imóvel?</strong></legend>                                                                                                                        
                                        
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="sim" class="ace" name="temAnuncio" <?=($pTerceiro) ? 'checked="checked"' : ''?> value="S" />                                                
                                                <span class="lbl"><strong> Sim</strong></span>
                                            </label>
                                        </div>
                                        
                                        <div class="radio">
                                            <label>
                                                <input type="radio" id="nao" class="ace" name="temAnuncio" <?=(!$pTerceiro) ? 'checked="checked"' : ''?>  value="N" />
                                                <span class="lbl"><strong> Não</strong></span>
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>

                            </div>
                        </div>
                        <div id="divButoes"><br />                            
                            <?php if (Sessao::temPermissao('imovellista', false)) : ?>
                                <button class="btn btn-info" type="button" id="btnLista" name="btnLista">
                                    <i class="ace-icon fa fa-arrow-left icon-on-right bigger-125"></i>
                                    <strong>Imóveis cadastrados</strong>
                                </button>&nbsp;&nbsp;
                            <?php endif; ?>

                            <button class="btn btn-light" type="button" id="btnNovo" name="btnNovo">
                                <i class="ace-icon fa fa-pencil-square-o bigger-125"></i>
                                <strong>Novo</strong>
                            </button>&nbsp;&nbsp;&nbsp;&nbsp;

                            <button class="btn btn-success" type="button" id="btnSalvar" name="btnSalvar">
                                <i class="ace-icon fa fa-floppy-o bigger-125"></i>
                                <strong>Salvar</strong>
                            </button>                            
                        </div>
                    </form>    
                </div>
            </div>
        </div>
    </div>
    
</div><!-- /.page-content -->

<script type="text/javascript" src="js/imovel.js?versao=<?=time()?>"></script>
<script type="text/javascript">
$('document').ready(function(){
<?php if (isset ($_GET['return'])) { if ($_GET['return'] != '') { ?>
    alert(<?php echo "'".Utilitarios::descriptografa($_GET['return'])."'"; ?>);  
<?php } } if ($pTerceiro) { ?>
    $('#dadosProprietario').show();
<?php } else { ?>
    $('#dadosProprietario').hide();
<?php } if ($ePessoaFisica) { ?>
    mudaFormPessoaFisica();
<?php } else {?>
    mudaFormPessoaJuridica();
<?php } ?> 
    $('#uf').val('<?=$imovel->getUf()?>');
    $('#proUf').val('<?=$proprietario->getUf()?>');
    $('#genero').val('<?=$proprietario->getGenero()?>');
    $('#genero').val('<?=$proprietario->getGenero()?>');
    
    /*$('#id-input-file-1 , #id-input-file-2').ace_file_input({
            //no_file:'No File ...',
            no_file:'Nenhum imagem ...',
            btn_choose:'Escolher',
            btn_change:'Alterar',
            droppable:false,
            onchange:null,
            thumbnail:false, //| true | large
            whitelist:'gif|png|jpg|jpeg'
            //blacklist:'exe|php'
            //onchange:''
            //
    });*/
    //pre-show a file name, for example a previously selected file
    //$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
                                
});
</script>

</div>