<?php
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
            <li class="active">Painel de controle</li>
        </ul>					
    </div>

    <div class="page-content">

        <div class="page-header">
            <h1>
                <!--Painel de controle -->
                <strong><?= $_SESSION['razao'] ?></strong>
                <small>
                    <!--<i class="ace-icon fa fa-angle-double-right"></i>-->
                    <!--overview &amp; stats-->
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="row">
                <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="alert alert-block alert-success">
                                <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                </button>

                                <i class="ace-icon fa fa-check green"></i>

                                Bem vindo ao 
                                <strong class="green">
                                        E-Imóveis Admin,
                                        <small>(v1.0)</small>
                                </strong>, o seu sistema de administração rico em recursos.
                        </div>						

                        <div class="row">
                            <div class="space-6"></div>

                            <div class="col-sm-7 infobox-container">
                                    <!-- #section:pages/dashboard.infobox -->
                                    <div class="infobox infobox-green">
                                            <div class="infobox-icon">
                                                    <i class="ace-icon fa fa-comments"></i>
                                            </div>

                                            <div class="infobox-data">
                                                    <span class="infobox-data-number">10</span>
                                                    <div class="infobox-content"><a href="#"><strong>Perguntas</strong></a></div>
                                            </div>

                                            <!-- #section:pages/dashboard.infobox.stat -->
                                            <!--<div class="stat stat-success">8%</div>-->

                                            <!-- /section:pages/dashboard.infobox.stat -->
                                    </div>

                                    <div class="infobox infobox-blue">
                                            <div class="infobox-icon">
                                                    <i class="ace-icon fa fa-bullhorn"></i>
                                            </div>

                                            <div class="infobox-data">
                                                    <span class="infobox-data-number">11</span>
                                                    <div class="infobox-content">Anúncios</div>
                                            </div>

                                            <!--<div class="badge badge-success">
                                                    +32%
                                                    <i class="ace-icon fa fa-arrow-up"></i>
                                            </div>-->
                                    </div>

                                    <div class="infobox infobox-pink">
                                            <div class="infobox-icon">
                                                    <i class="ace-icon fa fa-download"></i>
                                            </div>

                                            <div class="infobox-data">
                                                    <span class="infobox-data-number">8</span>
                                                    <div class="infobox-content">Encerrando hoje</div>
                                            </div>
                                            <!--<div class="stat stat-important">4%</div>-->
                                    </div>

                                    <div class="infobox infobox-red">
                                            <div class="infobox-icon">
                                                    <i class="ace-icon fa fa-flask"></i>
                                            </div>

                                            <div class="infobox-data">
                                                    <span class="infobox-data-number">7</span>
                                                    <div class="infobox-content">experiments</div>
                                            </div>
                                    </div>

                                    <div class="infobox infobox-orange2">
                                            <!-- #section:pages/dashboard.infobox.sparkline -->
                                            <div class="infobox-chart">
                                                    <span class="sparkline" data-values="196,128,202,177,154,94,100,170,224"></span>
                                            </div>

                                            <!-- /section:pages/dashboard.infobox.sparkline -->
                                            <div class="infobox-data">
                                                    <span class="infobox-data-number">6,251</span>
                                                    <div class="infobox-content">pageviews</div>
                                            </div>

                                            <div class="badge badge-success">
                                                    7.2%
                                                    <i class="ace-icon fa fa-arrow-up"></i>
                                            </div>
                                    </div>

                                    <div class="infobox infobox-blue2">
                                            <div class="infobox-progress">
                                                    <!-- #section:pages/dashboard.infobox.easypiechart -->
                                                    <div class="easy-pie-chart percentage" data-percent="42" data-size="46">
                                                            <span class="percent">42</span>%
                                                    </div>

                                                    <!-- /section:pages/dashboard.infobox.easypiechart -->
                                            </div>

                                            <div class="infobox-data">
                                                    <span class="infobox-text">traffic used</span>

                                                    <div class="infobox-content">
                                                            <span class="bigger-110">~</span>
                                                            58GB remaining
                                                    </div>
                                            </div>
                                    </div>

                                    <!-- /section:pages/dashboard.infobox -->
                                    <div class="space-6"></div>
                                    <!--
                                    <div class="infobox infobox-green infobox-small infobox-dark">
                                            <div class="infobox-progress">
                                                    <div class="easy-pie-chart percentage" data-percent="61" data-size="39">
                                                            <span class="percent">61</span>%
                                                    </div>

                                            </div>

                                            <div class="infobox-data">
                                                    <div class="infobox-content">Task</div>
                                                    <div class="infobox-content">Completion</div>
                                            </div>
                                    </div>

                                    <div class="infobox infobox-blue infobox-small infobox-dark">
                                            <div class="infobox-chart">
                                                    <span class="sparkline" data-values="3,4,2,3,4,4,2,2"></span>
                                            </div>

                                            <div class="infobox-data">
                                                    <div class="infobox-content">Earnings</div>
                                                    <div class="infobox-content">$32,000</div>
                                            </div>
                                    </div>

                                    <div class="infobox infobox-grey infobox-small infobox-dark">
                                            <div class="infobox-icon">
                                                    <i class="ace-icon fa fa-download"></i>
                                            </div>

                                            <div class="infobox-data">
                                                    <div class="infobox-content">Downloads</div>
                                                    <div class="infobox-content">1,205</div>
                                            </div>
                                    </div> -->

                            </div>

                            <div class="vspace-12-sm"></div>


                    </div><!-- /.row -->

                    <!--<div class="row">
                        <div class="col-xs-12">
                            <h3 class="header smaller lighter green">Acesso rápido</h3>
                            <p>						

                                <button class="btn btn-app btn-info btn-xs">
                                        <i class="ace-icon fa fa-info-circle bigger-160"></i>
                                        Imóveis
                                </button>
                                <button class="btn btn-app btn-info btn-xs">
                                        <i class="ace-icon fa fa-users bigger-160"></i>
                                        Clientes
                                </button>
                                <button class="btn btn-app btn-info btn-xs">
                                        <i class="ace-icon fa fa-bullhorn bigger-160"></i>
                                        Anúncios
                                </button>
                                <button class="btn btn-app btn-info btn-xs">
                                        <i class="ace-icon fa fa-bullhorn bigger-160"></i>
                                        Anunciar
                                </button>
                                <button class="btn btn-app btn-danger btn-xs">
                                        <i class="ace-icon fa fa-power-off bigger-160"></i>
                                        Sair
                                </button>                                                                        
                            </p>
                        </div>
                    </div>-->
                        <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->

</div>