<?php include_once 'app/view/backend/menufinanceiro.php'; ?>

<div class="main-content">
    
<?php if (Sessao::temPermissao('contasaldo')) : ?>
    
<?php 
    $c = new ContaBanco(Conf::pegCnxPadrao());
    $contas = $c->getSaldo();
    $total = 0;
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
        <li class="active">Saldo das contas</li>
    </ul>					
</div>

<div class="page-content">

    <div class="page-header">
        <!--<h1 style="text-align: center; font-weight: bold">-->
        <h1>
            Saldo das contas
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
                                        
                    <table id="tblContaSaldo" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Conta</th>                                
                                <th>Saldo</th>                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($contas) { foreach ($contas as $conta) : $total = $total + $conta['saldo']; ?>
                                <tr>
                                    <td><?= $conta['descricao'] ?></td>                                
                                    <td><?= 'R$ '.Utilitarios::formatarMoeda($conta['saldo']) ?></td>                   
                                </tr>                                
                            <?php endforeach; ?>
                                <tr>
                                    <td colspan="2"></td>                                    
                                </tr>
                                <tr>
                                    <td></td>                                
                                    <td><?= 'R$ '.Utilitarios::formatarMoeda($total) ?></td> 
                                </tr>
                            <?php  } else { ?>
                            
                                <tr>
                                    <td colspan="3" align="center">Nenhuma conta cadastrada</td>
                                </tr>
                            
                            <?php } ?>
                        </tbody> 
                    </table>  
                                                            
                </div>
                
            </div>
        </div>
    </div>    
</div><!-- /.page-content -->
<?php endif; ?>

</div>