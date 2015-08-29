<?php include_once 'app/view/backend/menufinanceiro.php'; ?>

<div class="main-content">
    
<?php if (Sessao::temPermissao('contasbancarias')) : ?>

<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="sistema.php">Início</a>
        </li>
        <li class="active">Situação das contas bancárias</li>
    </ul>					
</div>

<div class="page-content">

    <div class="page-header">
        <!--<h1 style="text-align: center; font-weight: bold">-->
        <h1>
            Situação das contas bancárias
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
                    <div id="registros" style="text-align: right; font-weight: bold; padding: 1% 1% 1% 1%; display: none">0 registro(s) encontrado(s).</div>
                    <table id="tblContas" class="table table-striped table-bordered table-hover" style="display: none">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Descrição</th>
                                <th>Banco</th>                                                
                                <th>Agência</th>
                                <th>Conta</th>
                                <th>Saldo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="7" align="center">Nenhum registro encontrado</td>
                            </tr>
                        </tbody> 
                    </table>
                    <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
                </div>
            </div>
        </div>
    </div>    
</div><!-- /.page-content -->
<script type="text/javascript" src="js/backend/contaBancaria.js"></script>
<?php endif; ?>

</div>