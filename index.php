<?php 
    /*ob_start("ob_gzhandler");*/    
    include_once 'config.php';
    $_SESSION['app'] = 'FRONT';        
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>E-Imóveis Brasil</title>
    <link rel="shortcut icon" href="images/favicon.png" />
    <!-- Define a viewport to mobile devices to use - telling the browser to assume that the page is as wide as the device (width=device-width) and setting the initial page zoom level to be 1 (initial-scale=1.0) -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php if (isset($_GET['action'])) if ($_GET['action'] == 'informacoesimovel') { ?>
        <!-- mapa --><!--<script src="http://code.jquery.com/jquery-1.7.1.min.js" type="text/javascript"></script>-->
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
        <script src="js/gmaps.js" type="text/javascript"></script>
        <script src="js/markers.js" type="text/javascript"></script>
        <!-- mapa -->
    <?php }  ?>
        
    <!-- Google Web Font -->
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>

    <!-- Include the bootstrap stylesheet -->
    <link href="css/frontend/bootstrap.css" rel="stylesheet" media="all">

    <!-- Include the Bootstrap responsive utitlities stylesheet -->
    <link href="css/frontend/_responsive-utilities.css" rel="stylesheet" media="all">


    <!-- Include the Awesome Font stylesheet -->
    <link href="css/frontend/font-awesome.min.css" rel="stylesheet" media="all">

    <!-- Include the bootstrap responsive stylesheet -->
    <link href="css/frontend/responsive.css" rel="stylesheet" media="all">

    <!-- Flexslider stylesheet -->
    <link href="js/flexslider/flexslider.css" rel="stylesheet" media="all">

    <!-- Pretty Photo stylesheet -->
    <link href="js/prettyphoto/prettyPhoto.css" rel="stylesheet" media="all">

    <!-- Pretty Photo stylesheet -->
    <link href="js/swipebox/swipebox.css" rel="stylesheet" media="all">

    <!-- Include the site main stylesheet -->
    <link href="css/frontend/main.css" rel="stylesheet" media="all">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>
<body>

<!-- Start Header -->
<div class="header-wrapper">

    <div class="container"><!-- Start Header Container -->

        <header id="header" class="clearfix">

            <div id="header-top" class="clearfix">

                <!--<h2 id="contact-email">
                    <i class="email"></i> E-mail para : <a href="mailto:contato@eimoveisbrasil.com.br">contato@eimoveisbrasil.com.br</a>
                </h2>-->

                <!-- Social Navigation -->
                <ul class="social_networks clearfix">
                    <li class="facebook">
                        <a target="_blank" href="https://www.facebook.com"><i class="icon-facebook"></i></a>
                    </li>
                    <li class="twitter">
                        <a target="_blank" href="https://twitter.com"><i class="icon-twitter"></i></a>
                    </li>
                    <li class="gplus">
                        <a target="_blank" href="https://plus.google.com"><i class="icon-google-plus"></i></a>
                    </li>
                    <li class="rss">
                        <a target="_blank" href="#"> <i class="icon-rss"></i></a>
                    </li>
                </ul>

            </div>


            <!-- Logo -->
            <div id="logo">

                <a title="E-Imóveis Brasil" href="index.php">
                    <img src="images/logo.png" alt="E-Imóveis Brasil">
                </a>

                <div class="tag-line">
                    <span><strong>O seu portal imobiliário</strong></span>
                </div>
            </div>


            <div class="menu-and-contact-wrap">

                <!--<h2  class="contact-number"><i class="icon-phone"></i>(84) XXXX-XXXX <span class="outer-strip"></span></h2>-->
                <!-- Start Main Menu-->
                <nav class="main-menu">
                    <div class="menu-main-menu-container">
                        <ul id="menu-main-menu" class="clearfix">
                            <?php $classCurrent = 'class="current-menu-item current_page_item"'; ?>
                            <li <?php if (isset($_GET['action'])) { echo ($_GET['action'] === 'home' || $_GET['action'] === 'solicitarimovel') ? $classCurrent : '' ; } else { echo $classCurrent; } ?> >
                                <a href="index.php">Home</a>
                            </li>                                                                                                                
                            
                            <li <?= isset($_GET['action']) && ($_GET['action'] === 'pesquisarimovel' || $_GET['action'] === 'informacoesimovel') ? $classCurrent : '' ;?> >
                                <a href="index.php?action=pesquisarimovel">Imóveis</a>
                            </li>
                            
                            <li <?= isset($_GET['action']) && ($_GET['action'] === 'anunciar' || $_GET['action'] === 'anunciar') ? $classCurrent : '' ;?> >
                                <a href="index.php?action=anunciar">Anunciar</a>
                            </li>
                            
                            <li <?= isset($_GET['action']) && $_GET['action'] === 'parceiros' ? $classCurrent : '' ;?>>
                                <a href="index.php?action=parceiros">Parceiros</a>                                
                            </li>
                            
                            <li <?= isset($_GET['action']) && $_GET['action'] === 'sobre' ? $classCurrent : '' ;?> >
                                <a href="index.php?action=sobre">Sobre</a>                                
                            </li>                            
                            
                            <!--<li <?php //isset($_GET['action']) && $_GET['action'] === 'servicos' ? $classCurrent : '' ;?> >
                                <a href="#">Serviços</a>                                
                            </li>
                            
                            <li <?php //isset($_GET['action']) && $_GET['action'] === 'noticias' ? $classCurrent : '' ;?>>
                                <a href="index.php?action=noticias">Notícias</a>                                
                            </li>-->                            
                            
                            <li <?= isset($_GET['action']) && $_GET['action'] === 'contato' ? $classCurrent : '' ;?>>
                                <a href="index.php?action=contato">Contato</a>
                            </li>
                            
                            <li <?php //isset($_GET['action']) && $_GET['action'] === 'contato' ? $classCurrent : '' ;?>>
                                <a href="administracao.php"><strong>Área restrita</strong></a>
                            </li>
                        </ul>

                    </div>
                </nav><!-- End Main Menu -->

            </div><!-- End .menu-and-contact-wrap -->

        </header>

    </div> <!-- End Header Container -->

</div><!-- End Header -->

    <?php
        if (isset($_GET['action'])) {
            Utilitarios::mostraPageFrontend($_GET['action']);
        } else {
            include_once 'app/view/frontend/home.php';
        }
    ?>

<!--<div class="container page-carousel">
    <div class="row">
        <div class="span12">
            <section class="brands-carousel  clearfix">
                <h3><span>Parceiros</span></h3>
                <div class="jcarousel-container">
                    <div class="jcarousel-clip">
                        <ul class="brands-carousel-list clearfix">
                            <li>
                                <a target="_blank" href="http://themeforest.net/" title="themeforest">
                                    <img src="images/temp-images/logo-1.png" alt="themeforest" title="themeforest">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="http://photodune.net/" title="photodune">
                                    <img src="images/temp-images/logo-2.png" alt="photodune" title="photodune">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="http://activeden.net/" title="themeforest">
                                    <img src="images/temp-images/logo-3.png"  alt="activeden" title="activeden">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="http://graphicriver.net/" title="graphicriver">
                                    <img src="images/temp-images/logo-4.png"  alt="graphicriver" title="graphicriver">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="http://videohive.net/" title="videohive">
                                    <img src="images/temp-images/logo-5.png"  alt="videohive" title="videohive">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="http://themeforest.net/" title="themeforest">
                                    <img src="images/temp-images/logo-1.png" alt="themeforest" title="themeforest">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="http://photodune.net/" title="photodune">
                                    <img src="images/temp-images/logo-2.png"  alt="photodune" title="photodune">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="http://activeden.net/" title="activeden">
                                    <img  src="images/temp-images/logo-3.png"  alt="activeden" title="activeden">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="jcarousel-prev"></div>
                    <div class="jcarousel-next"></div>
                </div>
            </section>
        </div>
    </div>
</div>    -->


<footer id="footer-wrapper">

    <!--<div id="footer" class="container">

        <div class="row">

            <div class="span3">
                <section class="widget">
                    <h3 class="title">About Real Homes</h3>
                    <div class="textwidget">
                        <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>
                        <p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
                    </div>
                </section>
            </div>

            <div class="span3">
                <section class="widget">
                    <h3 class="title">Recent Posts</h3>
                    <ul>
                        <li>
                            <a href="#" title="Lorem Post With Image Format">Lorem Post With Image Format</a>
                        </li>
                        <li>
                            <a href="#" title="Example Video Blog Post">Example Video Blog Post</a>
                        </li>
                        <li>
                            <a href="#" title="Example Post With Gallery Post Format">Example Post With Gallery Post Format</a>
                        </li>
                        <li>
                            <a href="#" title="Example Post With Image Post Format">Example Post With Image Post Format</a>
                        </li>
                        <li>
                            <a href="#" title="Lorem Ipsum Dolor Sit Amet">Lorem Ipsum Dolor Sit Amet</a>
                        </li>
                    </ul>
                </section>
            </div>

            <div class="span3">
                <section class="widget">
                    <h3 class="title">Latest Tweets</h3>
                    <ul id="twitter_update_list">
                        <li>No Tweet Loaded !</li>
                    </ul>
                </section>

            </div>

            <div class="span3">
                <section class="widget"><h3 class="title">Contact Info</h3>
                    <div class="textwidget">
                        <p>3015 Grand Ave, Coconut Grove,<br>
                            Merrick Way, FL 12345</p>
                        <p>Fone: 123-456-7890</p>
                        <p>Email: <a href="mailto:contato@eimoveisbrasil.com.br">contato@eimoveisbrasil.com.br</a></p>
                    </div>
                </section>
            </div>
        </div>

    </div>-->

    <!-- Footer Bottom -->
    <div id="footer-bottom" class="container">

        <div class="row">
            <div class="span6">
                <p class="copyright"><strong>Copyright © 2015. Todos os direitos reservados.</strong></p>
            </div>
            <div class="span6">
                <p class="designed-by"><a href="index.php">E-Imóveis Brasil</a> - Desenvolvido pela <a target="_blank" href="index.php">equipe E-Imóveis Brasil</a></p></div>
        </div>

    </div>
    <!-- End Footer Bottom -->

</footer>


                <script src="js/jquery.min.js"></script>
                <script src="js/flexslider/jquery.flexslider.js"></script>
                <script src="js/elastislide/jquery.easing.1.3.js"></script>
                <script src="js/elastislide/jquery.elastislide.js"></script>
                <script src="js/prettyphoto/jquery.prettyPhoto.js"></script>
                <script src="js/swipebox/jquery.swipebox.min.js"></script>
                <script src="js/jquery.isotope.min.js"></script>
                <script src="js/jquery.jcarousel.min.js"></script>
                <script src="js/jquery.validate.min.js"></script>
                <script src="js/jquery.form.js"></script>
                <script src="js/jquery.selectbox.js"></script>
                <script src="js/jquery.transit.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/jquery-twitterFetcher.js"></script>
                <script src="js/custom.js"></script>
                
                <!--<script type="text/javascript" src="js/meioMask.js"></script>-->
                <script src="js/backend/jquery.maskedinput.min.js"></script>
                <script type="text/javascript" src="js/sistema.js?versao=<?=time()?>"></script>
                <script type="text/javascript" src="js/frontend.js?versao=<?=time()?>"></script>  

        </body>
</html>
<?php //ob_end_flush(); ?>