<?php include_once 'app/view/backend/menupadrao.php'; ?>

<div class="main-content">
    
<?php    
    $conta = new ContaBanco(Conf::pegCnxPadrao());
    $titulo = 'Cadastrar conta bancária';
    if (isset ($_GET['idconta'])) {
        $titulo = 'Editar conta bancária';
        $conta->setIdContaBanco($_GET['idconta']);
        $conta->getDados();       
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
        <li class="active"><?=$titulo?></li>
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
                    <form id="fmCadConta" class="form-horizontal" role="form" name="fmCadConta" method="post" action="app/control/backend/contaGravar.php">
                        <input type="hidden" id="idContaBanco" name="idContaBanco" value="<?= $conta->getIdContaBanco() ?>" />
                        <div class="form-group">
                            <label for="idBanco" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Banco:</label>
                            <div class="col-sm-9">
                                <select id="idBanco" class="col-xs-10 col-sm-5" name="idBanco">                              
                                    <?php
                                      $banco = new Banco(Conf::pegCnxPadrao());
                                      Utilitarios::preencheComboDB($banco->getCadastrados(),$conta->getIdBanco());
                                    ?>
                                </select>
                            </div>  
                        </div>
                        <div class="form-group">
                            <label for="descricao" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Descrição da conta:</label>
                            <div class="col-sm-9">
                                <input type="text" id="descricao" class="col-xs-10 col-sm-5 obrigatorio" name="descricao" value="<?= $conta->getDescricao()?>" maxlength="200" title="Descrição da conta"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="agencia" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Agência:</label>
                            <div class="col-sm-9">
                                <input type="text" id="agencia" class="col-xs-10 col-sm-5 obrigatorio" name="agencia" value="<?= $conta->getAgencia()?>" maxlength="200" title="Agência"/>                                 
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="agenciaDig" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Dígito:</label>
                            <div class="col-sm-9">                                
                                <input type="text" id="agenciaDig" class="col-xs-10 col-sm-1 obrigatorio" name="agenciaDig" value="<?= $conta->getAgenciaDig()?>" maxlength="200" title="Dígito da agência"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="conta" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Conta:</label>
                            <div class="col-sm-9">
                                <input type="text" id="conta" class="col-xs-10 col-sm-5 obrigatorio" name="conta" value="<?=$conta->getConta()?>" maxlength="200" title="Conta"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contaDig" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Dígito:</label>
                            <div class="col-sm-9">                                
                                <input type="text" id="contaDig" class="col-xs-10 col-sm-1 obrigatorio" name="contaDig" value="<?= $conta->getContaDig()?>" maxlength="200" title="Dígito da conta"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="saldoInicial" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Saldo inicial:</label>
                            <div class="col-sm-9">
                                <input type="text" id="saldoInicial" class="col-xs-10 col-sm-5" name="saldoInicial" value="<?= $conta->getSaldoInicial()?>" maxlength="200" title="Saldo inicial" onkeypress="return(MascaraMoeda(this,'.',',',event))" />
                            </div>
                        </div>
                        
                        <br />
                        
                        <fieldset>
                            <legend>&nbsp;&nbsp;<strong>Informações da agência:</strong></legend>                                

                            <div class="form-group">
                                <label for="gerente" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Nome do gerente:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="gerente" class="col-xs-10 col-sm-5 obrigatorio" name="gerente" value="<?= $conta->getGerente()?>" maxlength="200" title="Nome do gerente da agência"/>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="telefone" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Telefone:</label>
                                <div class="col-sm-9">
                                    <input type="text" id="telefone" class="col-xs-10 col-sm-5 telefone" name="telefone" value="<?= Utilitarios::removeMascara($conta->getTelefone()) ?>" maxlength="200" title="Telefone"/>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="cep" class="col-sm-2 control-label no-padding-right"><strong>Cep:</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" id="cep" class="col-xs-10 col-sm-5 cep" name="cep" value="<?=$conta->getCep()?>" onBlur="getEndereco('cep','logradouro','bairro','cidade','uf','pais','msgcep')" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-sm-2 control-label no-padding-right" style="font-weight: bold"></label>
                                <div class="col-sm-9"><div id="msgcep"></div></div>
                            </div>

                            <div class="form-group">
                                <label for="logradouro" class="col-sm-2 control-label no-padding-right"><strong>Logradouro:</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" id="logradouro" class="col-xs-10 col-sm-5" name="logradouro" value="<?=$conta->getLogradouro()?>"  />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="numero" class="col-sm-2 control-label no-padding-right"><strong>Número:</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" id="numero" class="col-xs-10 col-sm-5" name="numero" value="<?=$conta->getNumero()?>" />
                                </div>
                            </div>                            

                            <div class="form-group">
                                <label for="bairro" class="col-sm-2 control-label no-padding-right"><strong>Bairro:</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" id="bairro" class="col-xs-10 col-sm-5" name="bairro" value="<?=$conta->getBairro()?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="cidade" class="col-sm-2 control-label no-padding-right"><strong>Cidade:</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" id="cidade" class="col-xs-10 col-sm-5" name="cidade" value="<?=$conta->getCidade()?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="uf" class="col-sm-2 control-label no-padding-right"><strong>UF:</strong></label>
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
                                <label for="pais" class="col-sm-2 control-label no-padding-right"><strong>País:</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" id="pais" class="col-xs-10 col-sm-5" name="pais" value="<?=$conta->getPais()?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label  for="pontoReferencia" class="col-sm-2 control-label no-padding-right"><strong>Referência:</strong></label>
                                <div class="col-sm-9">
                                    <input type="text" id="pontoReferencia" class="col-xs-10 col-sm-5" name="pontoReferencia" value="<?=$conta->getPontoReferencia()?>" maxlength="100" />
                                </div>
                            </div>
                        </fieldset> 
                        
                        <hr />
                        <div id="divButoes"><br />                        
                        <button class="btn btn-info" type="button" id="btnLista" name="btnLista">
                            <i class="ace-icon fa fa-arrow-left icon-on-right bigger-125"></i>
                            <strong>Contas cadastradas</strong>
                        </button>&nbsp;&nbsp;
                        
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
<script type="text/javascript" src="js/backend/contaBancaria.js"></script>
<script type="text/javascript">
$('document').ready(function(){ 
    $('#uf').val('<?=$conta->getUf()?>');        
});
</script>

</div>