<?php include_once 'app/view/backend/menufinanceiro.php'; ?>

<div class="main-content">
   
<?php    
    $titulo = 'Lançamento avulso';
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
                    <form id="fmCadContaReceber" class="form-horizontal" role="form" name="fmCadContaReceber" method="post" action="app/control/backend/lancamentoGravar.php">                       
                        <div class="form-group">
                            <label for="tipo" class="col-sm-2 control-label no-padding-right"><strong>Lançamento:</strong></label>
                            <div class="col-sm-9">
                                <select id="tipo" name="tipo" class="col-xs-10 col-sm-5">                                
                                    <option value="D">Débito</option>
                                    <option value="C">Crédito</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="idPessoa" class="col-sm-2 control-label no-padding-right"><strong>Pessoa:</strong></label>
                            <div class="col-sm-9">
                                <select id="idPessoa" name="idPessoa" class="col-xs-10 col-sm-5">                                
                                    <?php
                                      $c = new Pessoa(Conf::pegCnxPadrao());
                                      Utilitarios::preencheComboDB($c->getPessoas());
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="documento" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Documento:</label>
                            <div class="col-sm-9">
                                <input type="text" id="documento" class="col-xs-10 col-sm-5" name="documento" value="" maxlength="100" title="Documento"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="valor" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Valor:</label>
                            <div class="col-sm-9">
                                <input type="text" id="valor" class="col-xs-10 col-sm-5 obrigatorio" name="valor" value="" maxlength="200" title="Valor" onkeypress="return(MascaraMoeda(this,'.',',',event))"/>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="idConta" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Conta:</label>
                            <div class="col-sm-9">
                                <select id="idConta" name="idConta" class="col-xs-10 col-sm-5">                                    
                                    <?php
                                      $cb = new ContaBanco(Conf::pegCnxPadrao());
                                      Utilitarios::preencheComboDB($cb->getCadastradas());
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
                                      Utilitarios::preencheComboDB($pc->getCadastrados());
                                    ?>
                                </select>
                            </div>
                        </div>                                               
                        
                        <div class="form-group">
                            <label for="historico" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Histórico:</label>
                            <div class="col-sm-9">                                      
                                <textarea id="historico" class="col-xs-10 col-sm-5" name="historico" rows="6" ></textarea>
                            </div>
                        </div>
                                                
                        <hr />
                        <div id="divButoes"><br />
                            
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
<script type="text/javascript" src="js/backend/lancamento.js"></script>

</div>