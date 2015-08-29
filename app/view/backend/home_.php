<?php $_SESSION['app'] = 'BACK'; //if(Sessao::temPermissao('')) { ?>
<div style="position: relative; float: left; width: 45%;">
    <h1><strong>Bem vindo ao painel de controle!</strong></h1>
    <section class="icons">
        <ul>
            <?php if(Sessao::temPermissao('home_icon_imoveis',true)) { ?>
            <li>
                <a href="?action=imovellista">
                    <img src="images/imoveis.png" title="Imóveis cadastrados" />
                    <span><strong>Imóveis</strong></span>
                </a>
            </li>
            <?php } if(Sessao::temPermissao('home_icon_clientes',true)) { ?>
            <li>
                <a href="?action=clientelista">
                    <img src="images/clientes.png" title="Clientes cadastrados" />
                    <span><strong>Clientes</strong></span>
                </a>
            </li>
            <?php } if(Sessao::temPermissao('home_icon_anuncios',true)) { ?>
            <li>
                <a href="?action=anunciolista">
                    <img src="images/anuncios.png" title="Meus anúncios" />
                    <span><strong>Anúncios</strong></span>
                </a>
            </li>
            <?php } if(Sessao::temPermissao('home_icon_anunciar',true)) { ?>
            <li>
                <a href="?action=anunciocad">
                    <img src="images/anunciar3.png" title="Anunciar" />
                    <span><strong>Anunciar</strong></span>
                </a>
            </li>
            <?php } if(Sessao::temPermissao('home_icon_sair',true)) { ?>
            <li>
                <a href="administracao.php">
                    <img src="images/sair2.png" title="Sair do sistema" />
                    <span><strong>Sair</strong></span>
                </a>
            </li>
            <?php } ?>
        </ul>
    </section>         
</div>
<?php if(Sessao::temPermissao('home_painel',true)) { ?>
<div style="position: relative; float: right; width: 48%;">
<br />
<table class="tabelapadrao">
    <thead>
        <tr>
            <th colspan="4" style="text-align: center;"><strong>-- Painel de informações --</strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong> - Visitas ao portal hoje</strong></td>
            <td>0</td>
            <td><strong></strong></td>
            <td></td>
        </tr>
        <tr>
            <td><strong> - Total de anuncios</strong></td>
            <td>88</td>
            <td><strong> - Anúncios do mês</strong></td>
            <td>27</td>
        </tr>
        <tr>
            <td><strong> - Anuncios ativos</strong></td>
            <td>10</td>
            <td><strong> - Anuncios encerrando hoje</strong></td>
            <td>3</td>
        </tr>
        <tr>
            <td><strong> - Visitas aos anúncios de hoje</strong></td>
            <td>19</td>
            <td><strong> - Entraram em contato hoje</strong></td>
            <td>3</td>
        </tr>
        <tr>
            <td><strong> - Retorno aos contatos</strong></td>
            <td>1</td>
            <td><strong> - Contatos não respondidos</strong></td>
            <td>7</td>
        </tr>
        <tr>
            <td><strong></strong></td>
            <td></td>
            <td><strong></strong></td>
            <td></td>
        </tr>
    </tbody>    
</table>
</div>
<?php } ?>
<br />
<?php //} ?>
