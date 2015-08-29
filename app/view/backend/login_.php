<?php  ob_start("ob_gzhandler"); session_start(); session_destroy(); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>e-imóveis Brasil - Login</title>
<meta name="viewport" content="width=device-width; initial-scale=1.0" />
<link href="css/css_back_end.css" type="text/css" rel="stylesheet" media="screen" /> <!-- General style -->
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/meioMask.js"></script>
<script type="text/javascript" src="js/sistema.js"></script>
<script type="text/javascript">
$(document).ready(function(){  
    $('#usuario').focus();
    $('#btnConectar').click(function(){
        if($('#usuario').val().length == 0){
            alert('Informe o Usuário!');
            $('#usuario').focus();
            return false;            
        } else {
            if($('#senha').val().length == 0){
                alert('Informe a Senha!');
                $('#senha').focus();
                 return false;
            }
        }
    });
    <?php if (isset ($_GET['action'])) { if ($_GET['action'] == md5(0)) { ?>
            alert('Nome de usuário ou senha Inválidos!');
    <?php } elseif($_GET['action'] == md5(1)) { ?>
            alert('ATENÇÃO: Falha ao tentar se conectar a base de dados!');
    <?php } elseif($_GET['action'] == md5(2)) { ?>
            alert('ATENÇÃO: Não é possivel acessar o sistema, o seu usuário foi bloqueado!');
    <?php } elseif($_GET['action'] == md5(3)) { ?>
            alert('ATENÇÃO: É necessário fazer login!');
    <?php }}?>
});
</script>
</head>
<body>    
    <div id="carregGeral" class="carregGeral"><img src="images/ajax-loader.gif" alt="" /><p>Carregando...</p></div>
    <div id="toTop">&uArr;</div>
    <div id="page_wrap">
        <h1 class="logo"><a href="administracao.php">Painel de controle</a></h1>
        <div id="login-box" class="login-popup"></div>        
        <header><nav id="smoothmenu1" class="ddsmoothmenu"><br /><br /><br /></nav></header>
        <div id="page_container">
            <div style="width: 290px; margin: auto;">
                <form id="fmLogin" class="formpadrao" method="post" action="app/control/usuarioAutenticar.php">
                    <br /><h1 style="text-align: center; font-weight: bold;">Área administrativa</h1>
                    <fieldset>
                        <p style="padding-top: 15px;"><!--<label for="usuario">--><span style="display:block;float:left;cursor:pointer;font:12px Tahoma,sans-serif;font-weight:bold;color:#555;width:50px;vertical-align:middle;padding:5px;text-align:right;margin-right:10px">Usuário:</span> <!--</label>--><input type="text" id="usuario"  name="usuario" title="Usuário" /></p>
                    <p><!--<label for="senha">--><span style="display:block;float:left;cursor:pointer;font:12px Tahoma,sans-serif;font-weight:bold;color:#555;width:50px;vertical-align:middle;padding:5px;text-align:right;margin-right:10px">Senha:</span> <!--</label>--><input type="password" id="senha"  name="senha" title="Senha" /><br />
                    <p>
                        <a href="#"><strong>Esqueceu sua senha?</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <button type="submit" id="btnConectar" class="button medium blue" name="btnConectar"><strong>Conectar</strong></button>
                    </p>
                    </fieldset>
                </form>
            </div>
        </div>
        
        <footer>
            <div id="footer_wrap"></div>
            <div id="copy_right"><p>&copy; 2012. Todos os direitos reservados. <strong>e-imóveis brasil</strong></p></div>
        </footer>  
    </div>
</body>
</html>
<?php ob_end_flush(); ?>