<?php include_once 'app/view/backend/menuusuario.php'; ?>

<div class="main-content">
    <?php if (Sessao::temPermissao('usuariogrupolista')) : ?>
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
                <li class="active">Grupos de usuários</li>
            </ul>					
        </div>

        <div class="page-content">

            <div class="page-header">
                <!--<h1 style="text-align: center; font-weight: bold">-->
                <h1>
                    Grupos cadastrados
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

                            <!--<h4 class="pink">
                                    <i class="ace-icon fa fa-hand-o-right green"></i>
                                    <a href="#modal-form" role="button" class="blue" data-toggle="modal"> Janela de Baixa </a>
                            </h4>-->

                            <?= Utilitarios::exibirMensagem() ?>

                            <input type="text" id="txtConsulta" class="input-large" placeholder="Pesquisar grupo" />

                            <button type="button" id="btnConsultar" class="btn btn-info btn-sm">
                                <i class="ace-icon fa fa-search icon-on-right bigger-110"></i><strong>Pesquisar</strong>
                            </button>&nbsp;&nbsp;
                            <button type="button" id="btnNovo" name="btnNovo" class="btn btn-success btn-sm" >
                                <i class="ace-icon fa fa-pencil-square-o bigger-110"></i><strong>Novo grupo</strong>
                            </button>
                            <div id="registros" style="text-align: right; font-weight: bold; padding: 1% 1% 1% 1%; display: none">0 registro(s) encontrado(s).</div>
                            <table id="tblGrupo" class="table table-striped table-bordered table-hover" style="display: none">
                                <thead>
                                    <tr>
                                        <th>#</th>                                
                                        <th>Grupo</th>                                
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" align="center">Nenhum registro encontrado</td>
                                    </tr>
                                </tbody> 
                            </table>
                            <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
                        </div>
                    </div>
                </div>

                <div id="modal-form-grupocad" class="modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="blue bigger"><strong>Cadastrar grupo</strong></h4>
                            </div>
                            <form id="frmcadgrupo" name="frmcadgrupo" method="post" action="javascript:void(0)">
                                <div class="modal-body">                                      
                                    <div class="row">                                            
                                        <div class="col-xs-12">                                        
                                            <input type="hidden" id="idPapel" name="idPapel">
                                            <div class="form-group">
                                                <label for="papel"><strong>Nome do grupo</strong></label>
                                                <div>
                                                    <input class="input-group-lg form-control" type="text" id="papel" name="papel" placeholder="Nome do grupo" value="" />
                                                </div>
                                            </div>
                                            <?= Utilitarios::msgAviso('<strong>*Dica:</strong> <i>Após cadastrar o grupo configure as permissões do mesmo..</i>') ?>
                                        </div>                                                                                                
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-sm btn-danger" data-dismiss="modal" id="btnCancelar">
                                        <i class="ace-icon fa fa-times"></i>
                                        Cancelar
                                    </button>                            

                                    <button class="btn  btn-sm btn-success" id="btnSalvar" name="btnSalvar">
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
        <script type="text/javascript" src="js/backend/usuariogrupo.js?versao=<?= time() ?>"></script>
    <?php endif; ?>
</div>