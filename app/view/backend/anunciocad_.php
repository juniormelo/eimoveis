<?php
include_once 'app/view/backend/menupadrao.php';

$cnx = Conf::pegCnxPadrao();

$anuncio = new Anuncio($cnx);
$titulo = 'Anunciar';
if (isset ($_GET['idanuncio'])) {
    $titulo = 'Editar anuncio';
    $anuncio->set_idPessoaProprietario($_SESSION['idPessoaProprietario']);
    $anuncio->setIdAnuncio($_GET['idanuncio']);
    $anuncio->preecheObjeto();
}

$imovel = new Imovel($cnx);
$imovel->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
$imovel->setIdImovel($anuncio->getIdImovel());
$imoveis = $imovel->getSemAnuncio();

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
        <li class="active"><?=$titulo?></li>
    </ul>					
</div>
    
<div class="page-content">    
    
    <div class="page-header">
        <!--<h1 style="text-align: center; font-weight: bold">-->
        <h1>
            <?=$titulo?>
            <!--<small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                overview &amp; stats
            </small>-->
        </h1>
    </div><!-- /.page-header -->
<?php if (sizeof($imoveis) > 0) { ?>
<form action="javascript: void(0)" id="frmAnunciar" class="formpadrao">
    
    <fieldset><legend>Informações do anúncio:</legend>
        <?php if (isset ($_GET['idanuncio'])) : ?>
        <input type="hidden" id="idAnuncio" name="idAnuncio" value="<?=$anuncio->getIdAnuncio()?>" />
        <?php endif; if ($anuncio->get_codigo() != '') : ?>
        <p><label for="codigo">Código:</label><input type="text" id="codigo" class="obrigatorio small" name="codigo" title="Código" value="<?=$anuncio->get_codigo()?>" readonly="" disabled=""/></p>
        <?php endif; ?>
        <p><label for="idTipo">Finalidade:</label>
            <select id="idTipo" class="medium" name="idTipo">
                <option value="0"> -- Selecione a finalidade -- </option>
                <?php 
                    $tipo = new AnuncioTipo($cnx);                
                    Utilitarios::preencheComboDB($tipo->getCadastrados(), $anuncio->getIdTipo());
                ?>                
            </select>
        </p>
        <p><label for="idImovel">Imóvel:</label>
            <select id="idImovel" class="medium" name="idImovel">
                <option value="0"> -- Selecione um imóvel -- </option>
                <?php Utilitarios::preencheComboDB($imoveis,$anuncio->getIdImovel()); ?>
            </select>
            <!--&nbsp;&nbsp;<a href="javascript:exibirInfoImovel()"><strong>[ Exibir informações sobre o imóvel ]</strong></a>-->
        </p>
        <p><label for="posicao">Posicionamento:</label>
            <select id="posicao" class="medium" name="posicao">            
                <option value="B">Banner</option>
                <option value="D">Destaque</option>
                <option value="N" selected="selected">Normal</option>
            </select>
        </p>
        
        <p><label for="exibirMapa">Exibir mapa:</label>
            <select id="exibirMapa" class="medium" name="exibirMapa">
                <option value="N">Não</option>
                <option value="S">Sim</option>
            </select>
        </p>
        <p><label for="valor">Valor R$:</label><input type="text" id="valor" class="obrigatorio small decimal" name="valor" title="Valor" value="<?=number_format($anuncio->getValor(),2,',','.')?>" /><span style="font-weight: bold; color: red;">&nbsp;&nbsp;[ Se o valor for igual a 0 (zero), aparecerá "Valor sob consulta" no anúncio.]</span></p>
        <p><label for="titulo">Título:</label><input type="text" id="titulo" class="obrigatorio medium" name="titulo" title="Título" value="<?=$anuncio->getTitulo()?>" /></p>
        <p><label for="descricao">Descrição:</label><textarea id="descricao" name="descricao" rows="5" cols="60"><?=$anuncio->getDescricao()?></textarea></p>
    </fieldset>
    <fieldset><legend>Informações de contato:</legend>
        <p><label for="telefone1">Telefone 1:</label><input type="text" id="telefone1" class="obrigatorio small telefone" name="telefone1" title="Telefone 1" value="<?=$anuncio->getTelefone1()?>" /></p>
        <p><label for="telefone2">Telefone 2:</label><input type="text" id="telefone2" class="obrigatorio small telefone" name="telefone2" title="Telefone 2" value="<?=$anuncio->getTelefone2()?>" /></p>
        <p><label for="email">E-mail:</label><input type="text" id="email" class="obrigatorio medium" name="email" title="E-mail" value="<?=$anuncio->getEmail()?>" /></p>
        <p><label for="responsavel">Responsável:</label><input type="text" id="responsavel" class="obrigatorio medium" name="responsavel" title="Responsável" value="<?=$anuncio->getResponsavel()?>" /></p>
    </fieldset>        
    <div style="text-align: right;">        
        <!--<button id="btnNovo" class="button medium blue" name="btnNovo"><strong>Novo</strong></button></div>
        <button id="btnAnunciar" class="button medium blue" name="btnAnunciar"><strong>Anunciar</strong></button></div>
        <button id="btnAnuncios" class="button medium green" name="btnAnuncios"><strong>Meus anúncios</strong></button>-->
        
        <button type="button" id="btnNovo" class="button medium blue" name="btnNovo"><strong>Novo</strong></button>    
        <button type="button" id="btnAnunciar" class="button medium blue" name="btnAnunciar"><strong>Salvar</strong></button>
        <button type="button" id="btnLista" class="button medium white" name="btnLista"><strong>Meus anúncios</strong></button>
    </div>
    <!--<div id="fundo">
        <div id="janela" class="grid_12">
            <h1 style="text-align: center;"><strong>.::Informações do imóvel::.</strong></h1>
            <a href="javascript:close()"><img width="20" class="close" src="images/delete.png" alt="Fechar" title="Fechar" /></a>
            <div id="corpo"><hr /><fieldset><table id="tblInfoImovel" class="tabelapadrao ajustar"><tbody></tbody></table></fieldset></div>
        </div>
    </div>-->
</form>
<script type="text/javascript" src="js/backend/anuncio.js"></script>
<script type="text/javascript">
    $('#idTipo').val('<?=$anuncio->getIdTipo()?>');
    <?php if ($anuncio->getPosicao() != '') { ?>$('#posicao').val('<?=$anuncio->getPosicao()?>');<?php } ?>
    $('#exibirMapa').val('<?=$anuncio->getExibirMapa()?>');
</script>
<?php 
} else { 
    echo '<br />';
    Utilitarios::msgAviso('ATENÇÃO: TODOS OS SEUS IMÓVEIS CADASTRADOS JÁ ESTÃO ANUNCIADOS.'); 
    Utilitarios::msgSucesso('DICA 1: Se deseja criar um novo anúncio para um imóvel já existente, cancele o anúncio que está utilizando o IMÓVEL desejado.'); 
    Utilitarios::msgSucesso('DICA 2: Se não tem o imóvel cadastrado clique <a href="sistema.php?action=imovelcad">AQUI</a>'); 
    
}
?>

</div>
</div>