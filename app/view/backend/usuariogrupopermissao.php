<?php
    Sessao::temPermissao('gerusuario');
    include_once 'app/view/backend/menuusuario.php';    
    $grupo = new UsuarioPapelPermissao(Conf::pegCnxPadrao());
    $grupo->setIdPapel($_GET['id']);
    $grupo->set_idPessoaCredenciado($_SESSION['idPessoaProprietario']);
    $permissoes = $grupo->getPermissoes();    
    
    if (sizeof($permissoes) > 0) {
        $idPapel = $permissoes[0]['idPapel'];
    } else {
        $idPapel = 0;
    }
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
            <li class="active">Permissões do grupo acessos</li>
        </ul>					
    </div>

    <div class="page-content">

        <div class="page-header">
            <!--<h1 style="text-align: center; font-weight: bold">-->
            <h1>
                Permissões do grupo <strong><?=(sizeof($permissoes) > 0) ? $permissoes[0]['papel'] : '' ?></strong>
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

                    <!--<div class="col-xs-12 col-lg-6">                                            
                        <div class="form-group">
                            <label for="form-field-username"><strong>Filtrar por módulo</strong></label>
                            <div>
                                <select name="modulo" id="modulo" class="input-group-lg form-control">
                                </select>
                            </div>
                        </div>                                                                                                                
                    </div>-->

                    <div class="col-xs-12 col-lg-6">                                            
                        <div class="form-group">
                            <div style="padding-top: 5%">
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
                        <form name="frmGrupoPermissoes" id="frmGrupoPermissoes" method="post" action="javascript:void(0)">
                            <input name="idPapel" id="idPapel" type="hidden" value="<?=$idPapel?>"/>
                            <table id="tblpermissões" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Módulo</th>
                                        <th>Permissão</th>
                                        <th>Permitido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (sizeof($permissoes) > 0) { foreach ($permissoes as $permissao) : ?>
                                        <tr>
                                            <td>                                                
                                                <div class="checkbox">
                                                    <label>                                                        
                                                        <span class="lbl"> <strong><?=utf8_encode($permissao['modulo'])?></strong> </span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>                                                
                                                <div class="checkbox">
                                                    <label>                                                        
                                                        <span class="lbl"> <?=utf8_encode($permissao['descricao'])?> </span>
                                                    </label>
                                                </div> 
                                            </td>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="permissoes[]" value="<?=$permissao['idAcessoCredenciado']?>" type="checkbox" <?=($permissao['permitido']=='S')?'checked=""':''?> class="ace ckbpermissao" />
                                                        <span class="lbl"> </span>
                                                    </label>
                                                </div>
                                            </td>                                            
                                        </tr>
                                    <?php endforeach; } else { ?>
                                        <tr>
                                            <td colspan="3" align="center">Nenhum registro encontrado</td>
                                        </tr>
                                    <?php } ?>
                                </tbody> 
                            </table>
                        </form>
                        <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
                    </div>
                </div>
            </div>                            
        </div>    
    </div><!-- /.page-content -->
    <script type="text/javascript" src="js/backend/usuariogrupo.js?versao=<?= time() ?>"></script>
</div>