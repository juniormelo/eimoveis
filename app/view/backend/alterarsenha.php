<?php include_once 'app/view/backend/menupadrao.php'; ?>

<div class="main-content">

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
            <li class="active">Alteração de senha</li>
        </ul>					
    </div>

    <div class="page-content">

        <div class="page-header">
            <!--<h1 style="text-align: center; font-weight: bold">-->
            <h1>
                Alteração de senha
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
                        <form id="frmAlterarSenha" name="fmCadBanco" class="form-horizontal" role="form" action="javascript: void(0)">

                            <div class="form-group">
                                <label for="senhaAtual" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Senha atual:</label>
                                <div class="col-sm-9">
                                    <input type="password" id="senhaAtual" class="col-xs-10 col-sm-5" name="senhaAtual" title="Senha atual"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="senhaNova" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Nova senha:</label>
                                <div class="col-sm-9">
                                    <input type="password" id="senhaNova" class="col-xs-10 col-sm-5" name="senhaNova" title="Nova senha"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="senhaConfirme" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Confirme a nova senha:</label>
                                <div class="col-sm-9">
                                    <input type="password" id="senhaConfirme" class="col-xs-10 col-sm-5" name="senhaConfirme" title="Confirme a nova senha"/>
                                </div>
                            </div>

                            <hr />
                            <div id="divButoes"><br />                                                



                                <button class="btn btn-success" type="button" id="btnAlterar" name="btnAlterar">
                                    <i class="ace-icon fa fa-floppy-o bigger-125"></i>
                                    <strong>Alterar senha</strong>
                                </button>
                            </div><br />
                        </form>    
                    </div>
                </div>
            </div>
        </div>    
    </div><!-- /.page-content -->
    <script type="text/javascript" src="js/backend/usuario.js"></script>

</div>
