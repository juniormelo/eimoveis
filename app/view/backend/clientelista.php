<?php 
    Sessao::temPermissao('clientelista'); 
    include_once 'app/view/backend/menupadrao.php'; 
?>

<div class="main-content">

<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="sistema.php">Início</a>
        </li>
        <li class="active">Clientes</li>
    </ul>					
</div>

<div class="page-content">

    <div class="page-header">
        <!--<h1 style="text-align: center; font-weight: bold">-->
        <h1>
            Clientes cadastrados
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
                    <input type="text" id="txtConsulta" class="input-large" placeholder="Pesquisar cliente" />
                    
                    <button type="button" id="btnConsultar" class="btn btn-info btn-sm">
                        <i class="ace-icon fa fa-search icon-on-right bigger-110"></i><strong>Pesquisar</strong>
                    </button>
                    
                    <?php if (Sessao::temPermissao('clientecad', false)) : ?>
                        &nbsp;&nbsp;
                        <button type="button" id="btnNovo" name="btnNovo" class="btn btn-success btn-sm">
                            <i class="ace-icon fa fa-pencil-square-o bigger-110"></i><strong>Novo cliente</strong>
                        </button>
                    <?php endif; ?>
                        
                    <div id="registros" style="text-align: right; font-weight: bold; padding: 1% 1% 1% 1%; display: none">0 registro(s) encontrado(s).</div>
                    <table id="tblClientes" class="table table-striped table-bordered table-hover" style="display: none">
                        <thead>
                            <tr>
                                <th>#</th>                
                                <th>Natureza</th>
                                <th>CPF/CNPJ</th>
                                <th>Razão</th>
                                <th>E-mail</th>                
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" align="center">Nenhum registro encontrado</td>
                            </tr>
                        </tbody> 
                    </table>
                    <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
                </div>
            </div>
        </div>
    </div>    
</div><!-- /.page-content -->
<script type="text/javascript" src="js/cliente.js"></script>
</div>