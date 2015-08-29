<?php include_once 'app/view/backend/menupadrao.php'; Sessao::eSuperAdm(); ?>

<div class="main-content">
    
<?php
    $util = new Utilitarios();
    $cnx = Conf::pegCnxPadrao();
    $credenciado = new Pessoa($cnx);
    $titulo = 'Cadastrar credenciado';
    if (isset ($_GET['idcredenciado'])) {
        $credenciado->setIdPessoa($_GET['idcredenciado']);
        $credenciado->preencheObjCredenciado();
        if ($credenciado->getIdPessoa() != '') {
            $titulo = 'Editar credenciado';
        }    
    }
    $ePessoaJuridica = ($credenciado->getTipo() == 'J') ? true : false ;
    $eImobiliaria  = ($credenciado->getFlagImobiliaria() == 'S') ? true : false ;
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
        <li class="active">Credenciados</li>
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
                    <form id="fmCadCredenciado" class="form-horizontal" role="form" name="fmCadCredenciado" method="post" enctype="multipart/form-data" action="app/control/backend/credenciadoGravar.php">
                    <div class="tabbable">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active">
                                <a data-toggle="tab" href="#info">
                                    <!--<i class="green ace-icon fa fa-home bigger-120"></i>-->
                                    <strong>Informações</strong>
                                </a>
                            </li>

                            <li>
                                <a data-toggle="tab" href="#contato">
                                    <strong>Contato</strong>
                                    <!--<span class="badge badge-danger">4</span>-->
                                </a>
                            </li>
                            
                            <li>
                                <a data-toggle="tab" href="#endereco">
                                    <strong>Endereço</strong>
                                    <!--<span class="badge badge-danger">4</span>-->
                                </a>
                            </li>
                            
                            <?php if ($credenciado->getIdPessoa() == '') : ?>
                                <li>
                                    <a data-toggle="tab" href="#acessosistema">
                                        <strong>Acesso ao sistema</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <li>
                                <a data-toggle="tab" href="#outrasinfo">
                                    <strong>Outras infor.</strong>
                                    <!--<span class="badge badge-danger">4</span>-->
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="info" class="tab-pane in active">
                                
                                <fieldset>
                                    <legend><strong>Natureza?</strong></legend>                                    
                                    <div class="radio">
                                        <label>                                            
                                            <input type="radio" <?=(!$ePessoaJuridica) ? 'checked="checked"' : ''?> id="fisica" class="tipo ace" name="tipo" value="f"/>
                                            <span class="lbl"><strong> Pessoa Fisica</strong></span>
                                        </label>
                                    </div>
                                    
                                    <div class="radio">
                                        <label>                                            
                                            <input type="radio" <?=($ePessoaJuridica) ? 'checked="checked"' : ''?> id="juridica" class="tipo ace" name="tipo" value="j"/>
                                            <span class="lbl"><strong> Pessoa Juridica</strong></span>
                                        </label>
                                    </div>
                                </fieldset>                                                                
                                
                                <div id="dadosPessoaFisica" style="display: none;">
                                    <br />
                                    <fieldset>
                                        <legend><strong>É imobiliária?</strong></legend>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" <?=($eImobiliaria) ? 'checked="checked"' : ''?> id="imobiliariaSim" class="tipo ace" name="flagImobiliaria" value="S"/>
                                                <span class="lbl"><strong> Sim</strong></span>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" <?=(!$eImobiliaria) ? 'checked="checked"' : ''?> id="imobiliariaNao" class="tipo ace" name="flagImobiliaria" value="N"/>
                                                <span class="lbl"><strong> Não</strong></span>
                                            </label>
                                        </div>                                     
                                    </fieldset>
                                    <br />
                                    <fieldset>
                                        <legend><strong>Logo da empresa:</strong></legend>
                                        <p style="font-weight: bold; color: red">(*) - Insira a imagem da logo com extenção ".jpg" e com tamanho de até 2Mb.</p>
                                        <div style="border-style: solid; border-color: black; width: 160px; height: 200px;">
                                            <?php if ($credenciado->getFoto() != '') { ?>
                                            <input type="hidden" name="foto" value="<?= $credenciado->getFoto() ?>">
                                            <?php } ?>
                                            <img src="<?=($credenciado->getFoto() != '')?'images/upload/'.$credenciado->getFoto():'images/semimagem.jpg' ?>" title="<?=($credenciado->getFoto() != '')?'Logo do credenciado':'Sem logo' ?>" width="159" height="199" />
                                        </div>
                                        <p><input type="file" name="img[]" /></p>
                                    </fieldset>
                                </div>
                                <br />
                                <fieldset>
                                    <legend><strong>Dados pessoais:</strong></legend>          
                                    <input type="hidden" id="idPessoa" name="idPessoa" value="<?=$credenciado->getIdPessoa()?>" />
                                                                        
                                    <div id="lblCpf" class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="cpf_cnpj"><strong>CPF:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="obrigatorio col-xs-10 col-sm-5" value="<?=$credenciado->getCpf_cnpj()?>" title="CPF" onblur="localizarPessoa()"/>
                                        </div>
                                    </div>
                                    
                                    <div id="lblRazao" class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="razao"><strong>Nome:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="razao" class="obrigatorio col-xs-10 col-sm-5" name="razao" value="<?=$credenciado->getRazao()?>" maxlength="100" title="Razão"/>
                                        </div>
                                    </div>
                                    
                                    <div id="lblFantasia" class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="fantasia"><strong>Apelido:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="fantasia" class="col-xs-10 col-sm-5" name="fantasia" value="<?=$credenciado->getFantasia()?>" maxlength="100" />
                                        </div>
                                    </div>
                                    
                                    <div id="lblRg" class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="rg_ie"><strong>RG:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="rg_ie" class="col-xs-10 col-sm-5" name="rg_ie" value="<?=$credenciado->getRg_ie()?>" maxlength="14" />
                                        </div>
                                    </div>
                                    
                                    <div id="lblNascimento" class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="dtNascimento"><strong>Nascimento:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="dtNascimento" class="col-xs-10 col-sm-5 data" name="dtNascimento" value="<?=$util->formataData_DiaMesAno(str_replace('//', '', $credenciado->getDtNascimento()))?>" />
                                        </div>
                                    </div>                                    
                                    
                                    <div id="lblGenero" class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="genero"><strong>Sexo:</strong></label>
                                        <div class="col-sm-9">
                                            <select id="genero" class="col-xs-10 col-sm-5" name="genero">
                                                <option value="M">Masculino</option>        
                                                <option value="F">Feminino</option>        
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div id="lblEstadoCivil"class="form-group">
                                        <label class="col-sm-1 control-label no-padding-right" for="idEstadoCivil"><strong>Estado civil:</strong></label>
                                        <div class="col-sm-9">
                                            <select id="idEstadoCivil" class="col-xs-10 col-sm-5" name="idEstadoCivil">                              
                                                <?php
                                                    $estadoCivil = new EstadoCivil(Conf::pegCnxPadrao());
                                                    $util->preencheComboDB($estadoCivil->getCadastrados(),$credenciado->getIdEstadoCivil());
                                                ?>
                                            </select>
                                        </div>
                                    </div>                      
                                </fieldset>                                                                
                                
                            </div>

                            <div id="contato" class="tab-pane">
                                <fieldset>
                                    <legend><strong>Contato:</strong></legend>
                                    
                                    <div id="lblTelefone" class="form-group">
                                        <label for="telefone" class="col-sm-1 control-label no-padding-right"><strong>Telefone:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="telefone" class="col-xs-10 col-sm-5 telefone" name="telefone" value="<?=$credenciado->getTelefone()?>" maxlength="15" />
                                        </div>                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="fax" class="col-sm-1 control-label no-padding-right"><strong>Fax:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="fax" class="col-xs-10 col-sm-5 telefone" name="fax" value="<?=$credenciado->getFax()?>" maxlength="15" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="celular" class="col-sm-1 control-label no-padding-right"><strong>Celular:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="celular" class="col-xs-10 col-sm-5 telefone" name="celular" value="<?=$credenciado->getCelular()?>" maxlength="15" />
                                        </div>                                        
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="email" class="col-sm-1 control-label no-padding-right"><strong>E-mail:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="email" class="col-xs-10 col-sm-5 obrigatorio" name="email" value="<?=$credenciado->getEmail()?>" maxlength="50" />
                                        </div>                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="site" class="col-sm-1 control-label no-padding-right"><strong>Site:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="site" class="col-xs-10 col-sm-5" name="site" value="<?=$credenciado->getSite()?>" maxlength="50" />
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div id="endereco" class="tab-pane">
                                <fieldset>
                                    <legend><strong>Dados de endereço:</strong></legend>                                
                                    
                                    <div class="form-group">
                                        <label for="cep" class="col-sm-1 control-label no-padding-right"><strong>Cep:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="cep" class="col-xs-10 col-sm-5 cep" name="cep" value="<?=$credenciado->getCep()?>" onBlur="getEndereco('cep','logradouro','bairro','cidade','uf','pais','msgcep')" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="proCep" class="col-sm-2 control-label no-padding-right" style="font-weight: bold"></label>
                                        <div class="col-sm-9"><div id="msgcep"></div></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="logradouro" class="col-sm-1 control-label no-padding-right"><strong>Logradouro:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="logradouro" class="col-xs-10 col-sm-5" name="logradouro" value="<?=$credenciado->getLogradouro()?>"  />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="numLogradouro" class="col-sm-1 control-label no-padding-right"><strong>Número:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="numLogradouro" class="col-xs-10 col-sm-5" name="numLogradouro" value="<?=$credenciado->getNumLogradouro()?>" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="complemento" class="col-sm-1 control-label no-padding-right"><strong>Complem.:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="complemento" class="col-xs-10 col-sm-5" name="complemento" value="<?=$credenciado->getComplemento()?>" />
                                        </div>
                                    </div>
                                  
                                    <div class="form-group">
                                        <label for="bairro" class="col-sm-1 control-label no-padding-right"><strong>Bairro:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="bairro" class="col-xs-10 col-sm-5" name="bairro" value="<?=$credenciado->getBairro()?>" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="cidade" class="col-sm-1 control-label no-padding-right"><strong>Cidade:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="cidade" class="col-xs-10 col-sm-5" name="cidade" value="<?=$credenciado->getCidade()?>" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="uf" class="col-sm-1 control-label no-padding-right"><strong>UF:</strong></label>
                                        <div class="col-sm-9">
                                            <select id="uf" name="uf" class="col-xs-10 col-sm-5">
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
                                        <label for="pais" class="col-sm-1 control-label no-padding-right"><strong>País:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="pais" class="col-xs-10 col-sm-5" name="pais" value="<?=$credenciado->getPais()?>" />
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label  for="pontoReferencia" class="col-sm-1 control-label no-padding-right"><strong>Referência:</strong></label>
                                        <div class="col-sm-9">
                                            <input type="text" id="pontoReferencia" class="col-xs-10 col-sm-5" name="pontoReferencia" value="<?=$credenciado->getPontoReferencia()?>" maxlength="100" />
                                        </div>
                                    </div>
                                </fieldset>                               
                            </div>
                            
                            <?php if ($credenciado->getIdPessoa() == '') : ?>
                                <div id="acessosistema" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Acesso ao sistema:</strong></legend>

                                        <div class="form-group">
                                            <label for="dominio" class="col-sm-1 control-label no-padding-right"><strong>Dominio:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="dominio" class="col-xs-10 col-sm-5 obrigatorio" name="dominio" title="Dominio do credenciado"/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="usuario" class="col-sm-1 control-label no-padding-right"><strong>Usuário:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="usuario" class="col-xs-10 col-sm-5 obrigatorio" name="usuario" title="Usuário"/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="senha" class="col-sm-1 control-label no-padding-right"><strong>Senha:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="password" id="senha" class="col-xs-10 col-sm-5 obrigatorio" name="senha"  title="Senha" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="confirme" class="col-sm-1 control-label no-padding-right"><strong>Confirma:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="password" id="confirma" class="col-xs-10 col-sm-5 obrigatorio" name="confirma"  title="Confirmação da senha"/>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            <?php endif; ?>
                            
                            <div id="outrasinfo" class="tab-pane">
                                <fieldset>
                                    <legend><strong>Outras informações:</strong></legend>                                    
                                    <textarea id="observacao" name="observacao" rows="6" cols="60" ><?=$credenciado->getObservacao()?></textarea>
                                </fieldset>
                            </div>
                        </div>
                </div>
                        <div id="divButoes"><br />
                            <!--<button type="button" id="btnLista" class="button medium white" name="btnLista"><strong>Credenciados cadastrados</strong></button>-->
                            <button class="btn btn-info" type="button" id="btnLista" name="btnLista">
                                <i class="ace-icon fa fa-arrow-left icon-on-right bigger-125"></i>
                                <strong>Credenciados cadastrados</strong>
                            </button>&nbsp;&nbsp;
                                    
                            <!--<button type="button" id="btnNovo" class="button medium blue" name="btnNovo"><strong>Novo</strong></button>    -->
                            <button class="btn btn-light" type="button" id="btnNovo" name="btnNovo">
                                <i class="ace-icon fa fa-pencil-square-o bigger-125"></i>
                                <strong>Novo</strong>
                            </button>&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <!--<button id="btnSalvar" class="button medium blue" name="btnSalvar"><strong>Salvar</strong></button>-->                                    
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


<script type="text/javascript" src="js/backend/credenciado.js?versao=<?=time()?>"></script>

<script type="text/javascript">
$('document').ready(function(){ 
    $('#uf').val('<?=$credenciado->getUf()?>');    
    $('#genero').val('<?=$credenciado->getGenero()?>');
<?php if ($ePessoaJuridica) { ?>
    mudaFormPessoaJuridica();
<?php } else {?>
    mudaFormPessoaFisica();
<?php } if ($eImobiliaria) { ?> 
    //$('input[id=imobiliariaSim]').radioSel('S');
    $('input[id=imobiliariaSim]').val('S');
<?php } else { ?> 
    //$('input[id=imobiliariaSim]').radioSel('N');
    $('input[id=imobiliariaSim]').val('N');
<?php } if (isset ($_GET['return'])) { if ($_GET['return'] != '') { ?> 
    alert(<?php echo "'".$util->descriptografa($_GET['return'])."'"; ?>);
<?php } } ?> 
});
</script>

</div>