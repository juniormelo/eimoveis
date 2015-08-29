<?php
    Sessao::temPermissao('gerusuario');
    include_once 'app/view/backend/menuusuario.php';
    $usuario = new Usuario(Conf::pegCnxPadrao());    
    $usuario->setIdUsuario((isset($_GET['id']))?((int) $_GET['id']):0);
    $usuario->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
    $usuario->preencheObj();
?>

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
            <li class="active">Permissões do usuário</li>
        </ul>					
    </div>

    <div class="page-content">

        <div class="page-header">
            <!--<h1 style="text-align: center; font-weight: bold">-->
            <h1>
                Permissões do usuário <strong><?= $usuario->getLogin() ?></strong>
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
                    <div class="col-xs-12">
                        <?= Utilitarios::exibirMensagem() ?>
                    </div>                        
                    <div class="col-xs-12 col-lg-4">                                            
                        <div class="form-group">
                            <label for="form-field-username"><strong>Alterar grupo</strong></label>
                            <div>
                                <select name="idPapel_alt" id="idPapel_alt" class="input-group-lg form-control">
                                    <?php
                                        $grupo = new UsuarioPapel(Conf::pegCnxPadrao());    
                                        $grupo->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
                                        Utilitarios::preencheComboDB($grupo->getCadastrados(), $usuario->getIdPapel(), '-- Selecione um grupo --');
                                    ?>
                                </select>
                            </div>
                        </div>                                                                                                                
                    </div>

                    <!--<div class="col-xs-12 col-lg-4">                                            
                        <div class="form-group">
                            <label for="form-field-username"><strong>Módulo</strong></label>
                            <div>
                                <select name="modulo" id="modulo" class="input-group-lg form-control">
                                </select>
                            </div>
                        </div>                                                                                                                
                    </div>-->

                    <div class="col-xs-12 col-lg-4">                                            
                        <div class="form-group">
                            <div style="padding-top: 7%">
                                <button type="button" id="btnAplicPermissao" name="btnAplicPermissao" class="btn btn-success btn-sm">
                                    <i class="ace-icon fa fa-bolt bigger-110"></i><strong>Aplicar permissões</strong>
                                </button>&nbsp;&nbsp;
                                <button type="button" id="btnRetPermissao" name="btnRetPermissao" class="btn btn-danger btn-sm">
                                    <i class="ace-icon fa fa-ban bigger-110"></i><strong> Retirar todas</strong>
                                </button>
                            </div>                                
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <form name="frmUsuarioPermissoes" id="frmUsuarioPermissoes" method="post" action="javascript:void(0)">
                            <input type="hidden" name="idUsuario" id="idUsuario" value="<?=$usuario->getIdUsuario()?>">
                            <input type="hidden" name="idPapel_atual" id="idPapel_atual" value="<?=$usuario->getIdPapel()?>">
                            <table id="tblpermissoes" class="table table-striped table-bordered table-hover" style="<?=($usuario->getIdPapel() > 0) ? '':'display: none'?>">
                                <thead>
                                    <tr>
                                        <th>Módulo</th>
                                        <th>Permissão</th>
                                        <th>Permitido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  if (($usuario->getIdUsuario() > 0) && ($usuario->getIdPapel() > 0)) :  foreach ($usuario->getPermissoes(false) as $permissao) :  ?>
                                        <tr>                                                
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <span class="lbl"><strong><?=utf8_encode($permissao['modulo'])?></strong></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <span class="lbl"><strong><?=utf8_encode($permissao['descricao'])?></strong></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="permissoes[]" value="<?=$permissao['idPapelPermissao']?>" type="checkbox" <?=($permissao['permitido'] == 'S')?'checked=""':''?> class="ace ckbpermissao" /><span class="lbl"></span>
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                </tbody> 
                            </table>
                            <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
                        </form>
                    </div>
                </div>
            </div>                            
        </div>    
    </div><!-- /.page-content -->
    <script type="text/javascript" src="js/backend/usuario.js?versao=<?= time() ?>"></script>    
</div>