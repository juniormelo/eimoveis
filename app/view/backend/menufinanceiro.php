<div id="sidebar" class="sidebar responsive">
        <script type="text/javascript">
            try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        </script>

        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <button class="btn btn-success">
                        <i class="ace-icon fa fa-signal"></i>
                </button>

                <button class="btn btn-info">
                        <i class="ace-icon fa fa-pencil"></i>
                </button>

                <!-- #section:basics/sidebar.layout.shortcuts -->
                <button class="btn btn-warning">
                        <i class="ace-icon fa fa-users"></i>
                </button>

                <button class="btn btn-danger">
                        <i class="ace-icon fa fa-cogs"></i>
                </button>
                <!-- /section:basics/sidebar.layout.shortcuts -->
            </div>

            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                    <span class="btn btn-success"></span>

                    <span class="btn btn-info"></span>

                    <span class="btn btn-warning"></span>

                    <span class="btn btn-danger"></span>
            </div>
        </div><!-- /.sidebar-shortcuts -->

        <ul class="nav nav-list">
            <li class="active">
                <a href="sistema.php">
                        <i class="menu-icon fa fa-tachometer"></i>
                        <span class="menu-text"> Início </span>
                </a>
                <b class="arrow"></b>
            </li>
            
            <li class="">
                <a href="sistema.php?action=financeiro">
                    <i class="menu-icon fa fa-credit-card"></i>
                    <span class="menu-text"> <strong>Financeiro</strong> </span>                    
                </a>
            </li>
            <li class="">
                <a href="sistema.php?action=contasaldo">
                    <i class="menu-icon fa "></i>
                    <span class="menu-text"> Contas </span>                    
                </a>
            </li> 
            <li class="">
                <a href="#">
                    <i class="menu-icon fa "></i>
                    <span class="menu-text"> Contas a pagar </span>                    
                </a>
            </li>
            <li class="">
                <a href="sistema.php?action=contareceber">
                    <i class="menu-icon fa "></i>
                    <span class="menu-text"> Contas a receber </span>                    
                </a>
            </li>
            <li class="">
                <a href="sistema.php?action=lancamento">
                    <i class="menu-icon fa "></i>
                    <span class="menu-text"> Lançamento avulso</span>
                </a>
            </li>                       
            <li class="">
                <a href="#">
                    <i class="menu-icon fa "></i>
                    <span class="menu-text"> Transferências </span>                    
                </a>
            </li>            
            <li class="">
                <a href="#">
                    <i class="menu-icon fa "></i>
                    <span class="menu-text"> Fluxo de Caixa </span>
                </a>
            </li>
                       
                <li class="">
                        <a href="#" class="dropdown-toggle">
                                <i class="menu-icon fa fa-bar-chart-o"></i>
                                <span class="menu-text"> Relatórios </span>

                                <b class="arrow fa fa-angle-down"></b>
                        </a>

                        <b class="arrow"></b>

                        <ul class="submenu">
                                <li class="">
                                        <a href="sistema.php?action=imoveiscaptacao">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                Diversos
                                        </a>

                                        <b class="arrow"></b>
                                </li>
                                <li class="">
                                        <a href="sistema.php?action=imoveiscaptacao">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                Diversos
                                        </a>

                                        <b class="arrow"></b>
                                </li>
                                <li class="">
                                        <a href="sistema.php?action=imoveiscaptacao">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                Diversos
                                        </a>

                                        <b class="arrow"></b>
                                </li>
                                <li class="">
                                        <a href="sistema.php?action=imoveiscaptacao">
                                                <i class="menu-icon fa fa-caret-right"></i>
                                                Diversos
                                        </a>

                                        <b class="arrow"></b>
                                </li>

                        </ul>
                </li>

        </ul><!-- /.nav-list -->

        <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <!-- /section:basics/sidebar.layout.minimize -->
        <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        </script>
</div>