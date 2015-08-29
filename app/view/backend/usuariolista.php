<?php include_once 'app/view/backend/menuusuario.php'; ?>

<div class="main-content">
    
<?php if (Sessao::temPermissao('usuariolista')) : ?>

<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
            try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="sistema.php">Início</a>
        </li>
        <li class="active">Usuários</li>
    </ul>					
</div>

<div class="page-content">

    <div class="page-header">
        <!--<h1 style="text-align: center; font-weight: bold">-->
        <h1>
            Usuários cadastrados
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
                    
                    <input type="text" id="txtConsulta" class="input-large" placeholder="Pesquisar usuário" />
                    
                    <button type="button" id="btnConsultar" class="btn btn-info btn-sm">
                        <i class="ace-icon fa fa-search icon-on-right bigger-110"></i><strong>Pesquisar</strong>
                    </button>&nbsp;&nbsp;
                    <button type="button" id="btnNovo" name="btnNovo" class="btn btn-success btn-sm" >
                        <i class="ace-icon fa fa-pencil-square-o bigger-110"></i><strong>Novo usuário</strong>
                    </button>
                    <div id="registros" style="text-align: right; font-weight: bold; padding: 1% 1% 1% 1%; display: none">0 registro(s) encontrado(s).</div>
                    <table id="tblUsuario" class="table table-striped table-bordered table-hover" style="display: none">
                        <thead>
                            <tr>
                                <th>#</th>                                
                                <th>Usuário</th>
                                <th>Nome</th>                                
                                <th>Ultimo acesso</th>                                
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="5" align="center">Nenhum registro encontrado</td>
                            </tr>
                        </tbody> 
                    </table>
                    <div class="carregando" id="loadconsulta"><img src="images/ajax-loader.gif"><br />carregando...</div>
                </div>
            </div>
        </div>
        
        <div id="modal-form-usucad" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger"><strong>Cadastrar usuário</strong></h4>
                    </div>

                    <div class="modal-body">                                      
                        <div class="row">                                            
                            <div class="col-xs-12">
                                <form id="fmCadUsuario" name="fmCadUsuario" method="post" action="javascript:void(0);">                                    
                                    <div class="form-group">
                                        <label for=""><strong>Colaborador</strong></label>
                                        <div >                                            
                                            <select id="idPessoa" name="idPessoa" class="input-group-lg form-control">                                            
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="login"><strong>Login</strong></label>
                                        <div>
                                            <input class="input-group-lg form-control" type="text" id="login" name="login" placeholder="Nome do usuário" value="" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="senha"><strong>Senha</strong></label>
                                        <div>
                                            <input class="input-group-lg form-control" type="password" id="senha" name="senha" placeholder="senha" value="" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirme"><strong>Confirme a senha</strong></label>
                                        <div>
                                            <input class="input-group-lg form-control" type="password" id="confirme" name="confirme" placeholder="confirme a senha" value="" />
                                        </div>
                                    </div>                                                                        
                                    <?= Utilitarios::msgAviso('<strong>*Dica:</strong> <i>Após cadastrar o usuário configure as permissões do mesmo.</i>') ?>
                                </form>

                            </div>                                                                                                
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button id="btnCancelCadUsu" class="btn btn-sm btn-danger" data-dismiss="modal">
                            <i class="ace-icon fa fa-times"></i>
                            Cancelar
                        </button>                            

                        <button class="btn  btn-sm btn-success" id="btnSalvar" name="btnSalvar">
                            <i class="ace-icon fa fa-floppy-o bigger-125"></i>
                            <strong>Salvar</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="modal-form-usuinfo" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger"><strong>Informações do usuário</strong></h4>
                    </div>

                    <div class="modal-body">                                      
                        <div class="row">                            
                            <div class="col-xs-12" >
                                <div class="carregando" id="loadinfousu"><img src="images/ajax-loader.gif"><br />carregando...</div>
                                <div id="usuinfo"></div>    
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
                
        <div id="modal-form-usuredsenha" class="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="blue bigger"><strong>Redefinir senha</strong></h4>
                    </div>

                    <div class="modal-body">                                      
                        <div class="row">                                            
                            <div class="col-xs-12">
                                <form id="frmRedefSenha" name="frmRedefSenha" method="post" action="javascript:void(0)">
                                    <input type="hidden" id="idUsuarioRedef" name="idUsuarioRedef">                                

                                    <div class="form-group">
                                        <label for="senhaRedef"><strong>Senha</strong></label>
                                        <div>
                                            <input class="input-group-lg form-control" type="password" id="senhaRedef" name="senhaRedef" placeholder="Informe a nova senha" value="" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirmeRedf"><strong>Confirme a senha</strong></label>
                                        <div>
                                            <input class="input-group-lg form-control" type="password" id="confirmeRedf" name="confirmeRedf" placeholder="confirme a nova senha" value="" />
                                        </div>
                                    </div>
                                </form>
                            </div>                                                                                                
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-sm btn-danger" data-dismiss="modal" id="btnCancelRedefSenha">
                            <i class="ace-icon fa fa-times"></i>
                            Cancelar
                        </button>                            

                        <button class="btn  btn-sm btn-success" id="btnRedefSenha" name="btnRedefSenha">
                            <i class="ace-icon fa fa-floppy-o bigger-125"></i>
                            <strong>Confirmar</strong>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>    
</div><!-- /.page-content -->
<script type="text/javascript" src="js/backend/usuario.js?versao=<?=time()?>"></script>
<?php endif; ?>

</div>