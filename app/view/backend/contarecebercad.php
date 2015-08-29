<?php include_once 'app/view/backend/menufinanceiro.php'; ?>

<div class="main-content">
    
<?php    
    $cr = new ContaReceber(Conf::pegCnxPadrao());
    $titulo = 'Lançamento de conta a receber';
    if (isset ($_GET['idbanco'])) {
        $titulo = 'Editar lançamento';
        $cr->setIdBanco($_GET['idbanco']);
        $cr->getDados();        
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
                    <form id="fmCadContaReceber" class="form-horizontal" role="form" name="fmCadContaReceber" method="post" action="app/control/backend/contaReceberGravar.php">
                        <input type="hidden" id="idContaReceber" name="idContaReceber" value="<?= $cr->getIdContaReceber() ?>" />
                        
                        <div class="form-group">
                            <label for="idPessoa" class="col-sm-2 control-label no-padding-right"><strong>Cliente:</strong></label>
                            <div class="col-sm-9">
                                <select id="idPessoa" name="idPessoa" class="col-xs-10 col-sm-5">                                
                                    <?php
                                      $c = new Pessoa(Conf::pegCnxPadrao());
                                      Utilitarios::preencheComboDB($c->getPessoas(),$cr->getIdPessoa());
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="documento" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Documento:</label>
                            <div class="col-sm-9">
                                <input type="text" id="documento" class="col-xs-10 col-sm-5" name="documento" value="<?= $cr->getDocumento() ?>" maxlength="100" title="Documento"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="descricao" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Descrição da conta:</label>
                            <div class="col-sm-9">
                                <input type="text" id="descricao" class="col-xs-10 col-sm-5 obrigatorio" name="descricao" value="<?= $cr->getDescricao()?>" maxlength="200" title="Descrição da conta"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="parcela" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Parcela(s):</label>
                            <div class="col-sm-9">
                                <input type="text" id="parcela" class="col-xs-10 col-sm-5 obrigatorio" name="parcela" value="<?= $cr->getParcela()?>" maxlength="200" title="Parcela"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="valorNominal" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Valor nominal:</label>
                            <div class="col-sm-9">
                                <input type="text" id="valorNominal" class="col-xs-10 col-sm-5 obrigatorio" name="valorNominal" value="<?= $cr->getValorNominal()?>" maxlength="200" title="Valor nominal" onkeypress="return(MascaraMoeda(this,'.',',',event))"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="idConta" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Conta:</label>
                            <div class="col-sm-9">
                                <select id="idConta" name="idConta" class="col-xs-10 col-sm-5">                                    
                                    <?php
                                      $cb = new ContaBanco(Conf::pegCnxPadrao());
                                      Utilitarios::preencheComboDB($cb->getCadastradas(),$cr->getIdPlanoConta());
                                    ?>
                                </select>
                            </div>
                        </div>                        
                        
                        <div class="form-group">
                            <label for="idPlanoConta" class="col-sm-2 control-label no-padding-right"><strong>Plano de contas:</strong></label>
                            <div class="col-sm-9">
                                <select id="idPlanoConta" name="idPlanoConta" class="col-xs-10 col-sm-5">                                    
                                    <?php
                                      $pc = new PlanoDeConta(Conf::pegCnxPadrao());
                                      Utilitarios::preencheComboDB($pc->getCadastrados(),$cr->getIdPlanoConta());
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="dataVencimento" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Vencimento:</label>
                            <div class="col-sm-9">
                                <input type="text" id="dataVencimento" class="col-xs-10 col-sm-5 data" name="dataVencimento" value="<?= $cr->getDataVencimento()?>" maxlength="200" title="Plano de Conta"/>
                            </div>
                        </div>
                                                                        
                        <div class="form-group">
                            <label for="dataCompetencia" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Competência:</label>
                            <div class="col-sm-9">
                                <input type="text" id="dataCompetencia" class="col-xs-10 col-sm-5 data" name="dataCompetencia" value="<?= $cr->getDataCompetencia()?>" maxlength="200" title="Plano de Conta"/>
                            </div>
                        </div>                        
                        
                        <div class="form-group">
                            <label for="obsLancamento" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Observação:</label>
                            <div class="col-sm-9">                                      
                                <textarea id="obsLancamento" class="col-xs-10 col-sm-5" name="obsLancamento" rows="6" ><?= $cr->getObsLancamento()?></textarea>
                            </div>
                        </div>
                                                
                        <hr />
                        <div id="divButoes"><br />                        
                        <button class="btn btn-info" type="button" id="btnLista" name="btnLista">
                            <i class="ace-icon fa fa-arrow-left icon-on-right bigger-125"></i>
                            <strong>Contas cadastrados</strong>
                        </button>&nbsp;&nbsp;
                        
                        <button class="btn btn-light" type="button" id="btnNovo" name="btnNovo">
                            <i class="ace-icon fa fa-pencil-square-o bigger-125"></i>
                            <strong>Nova</strong>
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
<script type="text/javascript" src="js/backend/contareceber.js"></script>

</div>