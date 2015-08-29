<?php include_once 'app/view/backend/menufinanceiro.php'; ?>

<div class="main-content">
    
<?php if (Sessao::temPermissao('contareceber')) : ?>

<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="sistema.php">Início</a>
        </li>
        <li class="active">Contas a receber</li>
    </ul>					
</div>

<div class="page-content">

    <div class="page-header">
        <!--<h1 style="text-align: center; font-weight: bold">-->
        <h1>
            Contas a receber
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
                    
                    <?= Utilitarios::exibirMensagem() ?>
                    
                    <input type="text" id="txtConsulta" class="input-large" placeholder="Pesquisar conta" />
                    
                    <button type="button" id="btnConsultar" class="btn btn-info btn-sm">
                        <i class="ace-icon fa fa-search icon-on-right bigger-110"></i><strong>Pesquisar</strong>
                    </button>&nbsp;&nbsp;
                    <button type="button" id="btnNovo" name="btnNovo" class="btn btn-success btn-sm">
                        <i class="ace-icon fa fa-pencil-square-o bigger-110"></i><strong>Nova conta</strong>
                    </button>
                    
                    <h4 class="pink">
                            <i class="ace-icon fa fa-hand-o-right green"></i>
                            <a href="#modal-form" role="button" class="blue" data-toggle="modal"> Janela de Baixa </a>
                    </h4>
                    <h4 class="pink">
                            <i class="ace-icon fa fa-hand-o-right green"></i>
                            <a href="#modal-info" role="button" class="blue" data-toggle="modal"> Janela de informações </a>
                    </h4>
                    
                    <div id="registros" style="text-align: right; font-weight: bold; padding: 1% 1% 1% 1%; display: none">0 registro(s) encontrado(s).</div>
                    <table id="tblContaReceber" class="table table-striped table-bordered table-hover" style="display: none">                      
                        <thead>
                            <tr>
                                <th>Doc.</th>
                                <th>Descrição</th>
                                <!--<th>Parcela</th>-->
                                <th>Valor</th>
                                <th>Vencimento</th>
                                <!--<th>Situação</th>-->
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" align="center">Nenhum registro encontrado</td>
                            </tr>
                        </tbody> 
                    </table>
                    <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
                </div>
            </div>
                           
            <div id="modal-form" class="modal" tabindex="-1">
                <div class="modal-dialog">
                        <div class="modal-content">
                                <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="blue bigger"><strong>Baixar conta</strong></h4>
                                </div>

                                <div class="modal-body">                                      
                                    <div class="row">
                                        <div class="col-xs-12">                                            
                                            <div class="form-group">
                                                <label for="form-field-username"><strong>Conta</strong></label>
                                                <div >
                                                    <!--<input class="input-group-lg form-control" type="text" id="form-field-username" placeholder="Username" value="alexdoe" disabled="" />-->
                                                    <select id="idConta" name="idConta" class="input-group-lg form-control">  
                                                        <?php
                                                            $cb = new ContaBanco(Conf::pegCnxPadrao());
                                                            Utilitarios::preencheComboDB($cb->getCadastradas());
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>                                        
                                        <div class="col-xs-12 col-lg-6">                                            
                                            <div class="form-group">
                                                <label for="form-field-username"><strong>Valor</strong></label>
                                                <div>
                                                    <input class="input-group-lg form-control" type="text" id="form-field-username" placeholder="Username" value="0,00" disabled=""/>
                                                </div>
                                            </div>
                                                                                        
                                            <div class="form-group">
                                                <label for="form-field-username"><strong>Juros (%)</strong></label>
                                                <div>
                                                    <input class="input-group-lg form-control" type="text" id="form-field-username" placeholder="Username" value="0,00" />
                                                </div>
                                            </div>
                                                                                        
                                            <div class="form-group">
                                                <label for="form-field-username"><strong>Multa (%)</strong></label>
                                                <div>
                                                    <input class="input-group-lg form-control" type="text" id="form-field-username" placeholder="Username" value="0,00" />
                                                </div>
                                            </div>                                                                                        
                                        </div>                                        
                                        
                                        <div class="col-xs-12 col-lg-6">                                                                                        
                                            
                                            <div class="form-group">
                                                <label for="form-field-username"><strong>Desconto R$</strong></label>
                                                <div>
                                                    <input class="input-group-lg form-control" type="text" id="form-field-username" placeholder="Username" value="0,00" />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="form-field-username"><strong>Total a pagar</strong></label>
                                                <div>
                                                    <input class="input-group-lg form-control" type="text" id="form-field-username" placeholder="Username" value="0,00" disabled=""/>
                                                </div>
                                            </div>                                           
                                            
                                            <div class="form-group">
                                                <label for="form-field-username"><strong>forma de pagamento</strong></label>
                                                <div>
                                                    <input class="input-group-lg form-control" type="text" id="form-field-username" placeholder="Username" value="" />
                                                </div>
                                            </div>
                                                                                        
                                        </div>
                                        
                                        <div class="col-xs-12">
                                            <div class="form-group">
                                                <label for="form-field-first"><strong>Observações</strong></label>
                                                <div>
                                                    <textarea id="obsLancamento" class="input-group-lg form-control" name="obsLancamento" rows="1" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                        <button class="btn btn-sm btn-danger" data-dismiss="modal">
                                                <i class="ace-icon fa fa-times"></i>
                                                Cancelar
                                        </button>

                                        <button id="btnBaixa" class="btn btn-sm btn-success">
                                                <i class="ace-icon fa fa-check"></i>
                                                Baixar
                                        </button>
                                </div>
                        </div>
                </div>
        </div>
            
        <div id="modal-info" class="modal" tabindex="-1">
            <div class="modal-dialog">
                    <div class="modal-content">
                            <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="blue bigger"><strong>Informações da conta</strong></h4>
                            </div>

                            <div class="modal-body">                                      
                                <div class="row">                                                                                                                        

                                    <div class="col-xs-12 infoConta">                                                                                                                    
                                        
                                        
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-sm btn-success" data-dismiss="modal">
                                        <i class="ace-icon fa fa-check"></i>
                                        OK
                                </button>                                   
                            </div>
                    </div>
            </div>
        </div>

        </div>
    </div>    
</div><!-- /.page-content -->
<script type="text/javascript" src="js/backend/contareceber.js"></script>
<?php endif; ?>

</div>