<div id="sidebar" class="sidebar responsive">
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'fixed')
        } catch (e) {
        }
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

        <?php if (Sessao::eSuperAdm(false)) : ?>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-desktop"></i>
                    <span class="menu-text"> Administração </span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="sistema.php?action=credenciadolista">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Credenciados
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="sistema.php?action=tipoanuncio">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Tipos de anúncio
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="sistema.php?action=cargo">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Cargos
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="sistema.php?action=estadocivil">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Estado civil
                        </a>
                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="sistema.php?action=caracteristicaimovel">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Caracteristica do imóvel
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="sistema.php?action=proximidadeimovel">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Proximidades do imóvel
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="sistema.php?action=categoriaimovel">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Categoria do imóvel
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="sistema.php?action=noticialista">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Notícias
                        </a>

                        <b class="arrow"></b>
                    </li>

                </ul>
            </li>
        <?php endif; ?>
            
        <?php if (Sessao::temPermissao('cadastro', false)) : ?>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-list"></i>
                    <span class="menu-text"> Cadastros </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <?php if (Sessao::temPermissao('imovellista', false) || Sessao::temPermissao('imovelcad', false)) : ?>

                        <li class="">                    
                            <a href="sistema.php?action=<?=(Sessao::temPermissao('imovellista', false))?'imovellista':'imovelcad'?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Imóveis
                            </a>

                            <b class="arrow"></b>
                        </li>

                    <?php endif; if (Sessao::temPermissao('clientelista', false) || Sessao::temPermissao('clientecad', false)) :?>

                        <li class="">
                            <a href="sistema.php?action=<?=(Sessao::temPermissao('clientelista', false))?'clientelista':'clientecad'?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Clientes
                            </a>

                            <b class="arrow"></b>
                        </li>

                    <?php endif; if (Sessao::temPermissao('colaboradorlista', false) || Sessao::temPermissao('colaboradorcad', false)) :?>

                        <li class="">
                            <a href="sistema.php?action=<?=(Sessao::temPermissao('colaboradorlista', false))?'colaboradorlista':'colaboradorcad'?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Colaboradores
                            </a>

                            <b class="arrow"></b>
                        </li>

                    <?php endif; if (Sessao::temPermissao('bancoslista', false) || Sessao::temPermissao('bancoscad', false)) :?>

                        <li class="">
                            <a href="sistema.php?action=<?=(Sessao::temPermissao('bancoslista', false))?'bancoslista':'bancoscad'?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Bancos
                            </a>

                            <b class="arrow"></b>
                        </li>

                    <?php endif; if (Sessao::temPermissao('contaslista', false)) : ?>

                        <li class="">
                            <a href="sistema.php?action=contaslista">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Contas Bancárias
                            </a>

                            <b class="arrow"></b>
                        </li>

                    <?php endif; if (Sessao::temPermissao('fornecedorlista', false)) : ?>

                        <li class="">
                            <a href="sistema.php?action=fornecedorlista">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Fornecedores
                            </a>

                            <b class="arrow"></b>
                        </li>

                    <?php endif; if (Sessao::temPermissao('planocontaslista', false)) : ?>

                        <li class="">
                            <a href="sistema.php?action=planocontaslista">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Plano de Contas
                            </a>

                            <b class="arrow"></b>
                        </li>

                    <?php endif; if (Sessao::temPermissao('formapagtolista', false) || Sessao::temPermissao('formapagtocad', false)) :?>

                        <li class="">
                            <a href="sistema.php?action=<?=(Sessao::temPermissao('formapagtolista', false))?'formapagtolista':'formapagtocad'?>">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Formas de pagamento
                            </a>

                            <b class="arrow"></b>
                        </li>

                    <?php endif; ?>

                </ul>
            </li>
        <?php endif; ?>
        
        <?php if (Sessao::temPermissao('anuncio', false)) : ?>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-bullhorn"></i>
                    <span class="menu-text"> Anúncios </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <?php if (Sessao::temPermissao('anunciolista', false)) : ?>
                        <li class="">
                            <a href="sistema.php?action=anunciolista">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Meus anúncios
                            </a>

                            <b class="arrow"></b>
                        </li>

                    <?php endif; if (Sessao::temPermissao('anunciocad', false)) : ?>
                        <li class="">
                            <a href="sistema.php?action=anunciocad">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Anunciar
                            </a>

                            <b class="arrow"></b>
                        </li>
                    <?php endif; ?>
                </ul>
            </li>														
        <?php endif; ?>
        
        <?php if (Sessao::temPermissao('locacao', false)) : ?>
            <li class="">
                <a href="sistema.php?action=locacao">
                    <i class="menu-icon fa fa-exchange"></i>
                    <span class="menu-text"> Locação </span>
                </a>
            </li>
        <?php endif; ?>
        
        <?php if (Sessao::temPermissao('comercial', false)) : ?>
            <li class="">
                <a href="sistema.php?action=comercial">
                    <i class="menu-icon fa fa-users"></i>
                    <span class="menu-text"> Comercial </span>
                </a>
            </li>
        <?php endif; ?>
            
        <?php if (Sessao::temPermissao('vistoria', false)) : ?>
            <li class="">
                <a href="sistema.php?action=vistoria">
                    <i class="menu-icon fa fa-check-square-o"></i>
                    <span class="menu-text"> Vistoria </span>
                </a>                        
            </li>
        <?php endif; ?>
            
        <?php if (Sessao::temPermissao('cobranca', false)) : ?>
            <li class="">
                <a href="sistema.php?action=cobranca">
                    <i class="menu-icon fa fa-book"></i>
                    <span class="menu-text"> Cobrança </span>                                
                </a>                        
            </li>
        <?php endif; ?>
        
        <?php if (Sessao::temPermissao('financeiro', false)) : ?>
            <li class="">
                <a href="sistema.php?action=financeiro">
                    <i class="menu-icon fa fa-credit-card"></i>
                    <span class="menu-text"> Financeiro </span>                               
                </a>                    
            </li>
        <?php endif; ?>
            
        <?php if (Sessao::temPermissao('gerusuario', false)) : ?>    
            <li class="">
                <a href="sistema.php?action=usuariolista">
                    <i class="menu-icon fa fa-users"></i>
                    <span class="menu-text"> Ger. Usuários </span>                               
                </a>                    
            </li>
        <?php endif; ?>
        
        <?php if (Sessao::temPermissao('relatorio', false)) : ?>
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

                </ul>
            </li>
        <?php endif; ?>
            
        <?php if (Sessao::temPermissao('ferramentas', false)) : ?>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-cogs"></i>
                    <span class="menu-text"> Ferramentas </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="sistema.php?action=imoveiscaptacao">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Captação de imóveis
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="sistema.php?action=imoveissolicitados">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Imóveis solicitados
                        </a>

                        <b class="arrow"></b>
                    </li>

                </ul>
            </li>
        <?php endif; ?>
        
        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-bolt"></i>
                <span class="menu-text"> Sistema </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="sistema.php?action=alterarsenha">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Alterar senha
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="#">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Meu perfil
                    </a>

                    <b class="arrow"></b>
                </li>
                
                <li class="">
                    <a href="#">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Configurações
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
        try {
            ace.settings.check('sidebar', 'collapsed')
        } catch (e) {
        }
    </script>
</div>