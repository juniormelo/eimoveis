<?php
ob_start("ob_gzhandler");
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <!--<meta charset="utf-8" />-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>E-Imóves Admin - Login</title>

        <meta name="description" content="User login page" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="css/backend/bootstrap.min.css" />
        <link rel="stylesheet" href="css/backend/font-awesome.min.css" />

        <!-- text fonts -->
        <link rel="stylesheet" href="css/backend/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="css/backend/ace.min.css" />

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="../assets/css/ace-part2.min.css" />
        <![endif]-->
        <link rel="stylesheet" href="css/backend/ace-rtl.min.css" />

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="../assets/css/ace-ie.min.css" />
        <![endif]-->
        <link rel="stylesheet" href="css/backend/ace.onpage-help.css" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

        <!--[if lt IE 9]>
        <script src="../assets/js/html5shiv.js"></script>
        <script src="../assets/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="login-layout light-login">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center">

                                <h1 style="padding-top: 23%;">
                                    <i class="ace-icon fa fa-leaf green"></i>
                                    <span class="red">E-Imóves</span>
                                    <span class="white" id="id-text2" class="grey">Admin</span>
                                </h1>
                                <!--<h4 class="blue" id="id-company-text">&copy; Company Name</h4>-->
                            </div>

                            <div class="space-6"></div>

                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger">
                                                    <!--<i class="ace-icon fa fa-coffee green"></i>-->
                                                <strong>Informe o seu login e senha</strong>
                                            </h4>

                                            <div class="space-6"></div>

                                            <form id="fmLogin" method="post" action="app/control/usuarioAutenticar.php">
                                                <fieldset>
                                                    <label class="block clearfix"><!--<strong>Login:</strong>-->
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Login" />
                                                            <i class="ace-icon fa fa-user"></i>
                                                        </span>
                                                    </label>

                                                    <label class="block clearfix"><!--<strong>Senha:</strong>-->
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" />
                                                            <i class="ace-icon fa fa-lock"></i>
                                                        </span>
                                                    </label>

                                                    <div class="space"></div>

                                                    <div class="clearfix">

                                                        <!--<label class="inline">
                                                                <input type="checkbox" class="ace" />
                                                                <span class="lbl"> Remember Me</span>
                                                        </label>-->

                                                        <button type="submit" id="btnConectar" class="width-35 pull-right btn btn-sm btn-primary">
                                                            <i class="ace-icon fa fa-key"></i>
                                                            <span class="bigger-110"><strong>Entrar</strong></span>
                                                        </button>
                                                    </div>

                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>

                                           <!--<div class="social-or-login center">
                                                    <span class="bigger-110">Or Login Using</span>
                                            </div>

                                            <div class="space-6"></div>

                                            <div class="social-login center">
                                                    <a class="btn btn-primary">
                                                            <i class="ace-icon fa fa-facebook"></i>
                                                    </a>

                                                    <a class="btn btn-info">
                                                            <i class="ace-icon fa fa-twitter"></i>
                                                    </a>

                                                    <a class="btn btn-danger">
                                                            <i class="ace-icon fa fa-google-plus"></i>
                                                    </a>
                                            </div>-->
                                        </div><!-- /.widget-main -->

                                        <div class="toolbar clearfix">
                                            <div>
                                                <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                    <strong>Esqueceu sua senha?</strong>
                                                </a>
                                            </div>

                                            <!--<div>
                                                    <a href="#" data-target="#signup-box" class="user-signup-link">
                                                            I want to register
                                                            <i class="ace-icon fa fa-arrow-right"></i>
                                                    </a>
                                            </div>-->
                                        </div>
                                    </div><!-- /.widget-body -->
                                </div><!-- /.login-box -->

                                <div id="forgot-box" class="forgot-box widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header red lighter bigger">
                                                <i class="ace-icon fa fa-key"></i>
                                                <strong>Recuperar senha</strong>
                                            </h4>

                                            <div class="space-6"></div>

                                            <p style="font-weight: bold;">Digite seu e-mail para receber as instruções de recuperação:</p>

                                            <form>
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="email" class="form-control" placeholder="Email" />
                                                            <i class="ace-icon fa fa-envelope"></i>
                                                        </span>
                                                    </label>

                                                    <div class="clearfix">
                                                        <button type="button" class="width-35 pull-right btn btn-sm btn-danger">
                                                            <i class="ace-icon fa fa-lightbulb-o"></i>
                                                            <span class="bigger-110"><strong>Envie-me!</strong></span>
                                                        </button>
                                                    </div>
                                                </fieldset>
                                            </form>
                                        </div><!-- /.widget-main -->

                                        <div class="toolbar center">
                                            <a href="#" data-target="#login-box" class="back-to-login-link">
                                                <i class="ace-icon fa fa-arrow-left"></i>
                                                Voltar para o login                                                
                                            </a>
                                        </div>
                                    </div><!-- /.widget-body -->
                                </div><!-- /.forgot-box -->


                            </div><!-- /.position-relative -->

                            <!--<div class="navbar-fixed-top align-right">
                                    <br />
                                    &nbsp;
                                    <a id="btn-login-dark" href="#">Dark</a>
                                    &nbsp;
                                    <span class="blue">/</span>
                                    &nbsp;
                                    <a id="btn-login-blur" href="#">Blur</a>
                                    &nbsp;
                                    <span class="blue">/</span>
                                    &nbsp;
                                    <a id="btn-login-light" href="#">Light</a>
                                    &nbsp; &nbsp; &nbsp;
                            </div>-->
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.main-content -->
        </div><!-- /.main-container -->

        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script type="text/javascript">
            window.jQuery || document.write("<script src='js/backend/jquery.min.js'>" + "<" + "/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
            <script type="text/javascript">
            window.jQuery || document.write("<script src='../assets/js/jquery1x.min.js'>"+"<"+"/script>");
            </script>
        <![endif]-->
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='js/backend/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>

        <!-- inline scripts related to this page -->
        <script type="text/javascript">
            $(document).ready(function () {
                $('#usuario').focus();
                $('#btnConectar').click(function () {
                    if ($('#usuario').val().length == 0) {
                        alert('Informe o Login!');
                        $('#usuario').focus();
                        return false;
                    } else {
                        if ($('#senha').val().length == 0) {
                            alert('Informe a Senha!');
                            $('#senha').focus();
                            return false;
                        }
                    }
                    //$('#btnConectar span strong').html('Autenticando...')
                });

                <?php if (isset($_GET['action'])) { if ($_GET['action'] == md5(0)) { ?>
                            alert('ATENÇÃO:\n\n O usuário ou senha informados são inválidos!');
                <?php } elseif ($_GET['action'] == md5(1)) { ?>
                            alert('ATENÇÃO:\n\n Falha ao tentar se conectar a base de dados!');
                <?php } elseif ($_GET['action'] == md5(2)) { ?>
                            alert('ATENÇÃO:\n\n Não é possivel acessar o sistema, o seu usuário foi bloqueado.\n Para mais informações entre em contato com o administrador do sistema.');
                <?php } elseif ($_GET['action'] == md5(3)) { ?>
                            alert('ATENÇÃO:\n\n Para acessar o sistema é necessário fazer login!');
                <?php } elseif ($_GET['action'] == md5(4)) { ?>
                            alert('ATENÇÃO:\n\n O sistema esta temporariamente bloqueado para a sua empresa.\n Para mais informaçoes entre em contato com o administrador do sistema.');
                <?php } } ?>
            });

            jQuery(function ($) {
                $(document).on('click', '.toolbar a[data-target]', function (e) {
                    e.preventDefault();
                    var target = $(this).data('target');
                    $('.widget-box.visible').removeClass('visible');//hide others
                    $(target).addClass('visible');//show target
                });
            });

            //$('body').attr('class', 'login-layout light-login');
            //$('#id-text2').attr('class', 'grey');
            //$('#id-company-text').attr('class', 'blue');

            //you don't need this, just used for changing background
            jQuery(function ($) {
                /*$('#btn-login-dark').on('click', function(e) {
                 $('body').attr('class', 'login-layout');
                 $('#id-text2').attr('class', 'white');
                 $('#id-company-text').attr('class', 'blue');
                 
                 e.preventDefault();
                 });
                 
                 $('#btn-login-light').on('click', function(e) {
                 $('body').attr('class', 'login-layout light-login');
                 $('#id-text2').attr('class', 'grey');
                 $('#id-company-text').attr('class', 'blue');
                 
                 e.preventDefault();
                 });
                 
                 $('#btn-login-blur').on('click', function(e) {
                 $('body').attr('class', 'login-layout blur-login');
                 $('#id-text2').attr('class', 'white');
                 $('#id-company-text').attr('class', 'light-blue');
                 
                 e.preventDefault();
                 });*/

            });
        </script>
    </body>
</html>