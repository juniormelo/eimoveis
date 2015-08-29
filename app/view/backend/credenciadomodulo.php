<?php    
    include_once 'app/view/backend/menupadrao.php';     
    Sessao::eSuperAdm(); 
    $credenciado = new Pessoa(Conf::pegCnxPadrao());
    $credenciado->setIdPessoa($_GET['id']);
    $modulos = $credenciado->getModulos();
    if (sizeof($modulos) > 0) {
        $idPessoaCredenciado = $modulos[0]['idPessoaCredenciado'];
    } else {
        $idPessoaCredenciado = 0;
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
            <li class="active">Liberação de módulos</li>
        </ul>					
    </div>

    <div class="page-content">

        <div class="page-header">
            <!--<h1 style="text-align: center; font-weight: bold">-->
            <h1>
                Liberação de módulos
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

                    <div class="col-xs-12 col-lg-12">                              
                        <div class="form-group">
                            <button class="btn btn-info" type="button" id="btnLista" name="btnLista">
                                <i class="ace-icon fa fa-arrow-left icon-on-right bigger-125"></i>
                                <strong>Credenciados cadastrados</strong>
                            </button>&nbsp;&nbsp;

                            <button type="button" id="btnLiberarMod" name="btnLiberarMod" class="btn btn-success">
                                <i class="ace-icon fa fa-bolt bigger-110"></i><strong>Liberar módulos</strong>
                            </button>&nbsp;&nbsp;

                            <button type="button" id="btnBloquearMod" name="btnBloquearMod" class="btn btn-danger">
                                <i class="ace-icon fa fa-ban bigger-110"></i><strong> Bloquear módulos</strong>
                            </button>                                
                        </div>
                    </div>

                    <div class="col-xs-12">                            
                        <form name="frmLibModulos" id="frmLibModulos" method="post" action="javascript:void(0)">
                            <input name="idCredenciado" id="idCredenciado" type="hidden" value="<?=$idPessoaCredenciado?>"/>
                            <table id="tblmodulos" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>                                
                                        <th>Modulo</th>
                                        <th>Liberado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (sizeof($modulos) > 0) { $i = 0; foreach ($modulos as $modulo) : $i++;?>
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label>                                                        
                                                        <span class="lbl"> <?=$i?> </span>
                                                    </label>
                                                </div>
                                            </td>                                                                            
                                            <td>                                                
                                                <div class="checkbox">
                                                    <label>                                                        
                                                        <span class="lbl"> <?=$modulo['modulo']?> </span>
                                                    </label>
                                                </div>                                                
                                            </td>                                                                            
                                            <td>                                                
                                                <div class="checkbox">
                                                    <label>
                                                        <input name="modulo[]" value="<?=$modulo['modulo']?>" type="checkbox" <?=($modulo['liberado']=='S')?'checked=""':''?> class="ace" />
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
                            <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
                        </form>
                    </div>
                </div>
            </div>                            
        </div>    
    </div><!-- /.page-content -->
    <script type="text/javascript" src="js/backend/credenciado.js"></script>
</div>