<?php
    SiteVisita::registraVisita();
    $imovel = new Imovel(Conf::pegCnxPadrao());
    $dataSet = $imovel->pesquisarComAnuncio();
    $titulo = '';    
    $estilo = '';
    $qtd_anuncio_n = 0;
    $controle_estilo = 1;
    include_once 'app/view/frontend/topopadrao.php'; 
?>
<div class="intro">
    <ul>
        <li class="first">
            <img src="images/serv-2.png" alt=""/>
            <strong>Imóveis em destaque</strong>
        </li>
        <!--<li class="first"><a href="#"><img src="images/serv-1.png" alt=""/>Gestão de Propriedade</a></li>
        <li><a href="#"><img src="images/serv-2.png" alt=""/>Renting Collection</a></li>
        <li><a href="#"><img src="images/serv-3.png" alt=""/>Serviços imobiliários</a></li>
        <li><a href="#"><img src="images/serv-4.png" alt=""/>Seguros e Financiamentos</a></li-->
    </ul>
</div>
<div class="anuncio_destaque">
    <ul id="mycarousel" class="jcarousel-skin-tango">
    <?php if (sizeof($dataSet) > 0) { foreach ($dataSet as $linha) { $titulo = substr($linha['titulo'], 0,20 ); $titulo = (strlen($titulo) == 20) ? $titulo.'...' : $titulo; if ($linha['posicao'] == 'D') { ?>
        <li class="mosaic-block1 circle">
            <a href="images/preview/work_2_l.jpg." rel="" title="Image Title Here" class="mosaic-overlay."></a>
            <img src="images/upload/<?= $linha['img'] ?>" width="202" height="161" alt="" />
            <span><?= $titulo ?></span><br>
            <small><a href="javascript:void(0)"><?= $linha['tipoAnuncio'] ?></a></small>
            <p><span class="row">Categoria: </span><span class="row1"><a href="javascript:void(0)"><?= $linha['categoriaImovel'] ?></a></span></p>
            <p><span class="row">Localizado em: </span><span class="row1"><?= $linha['cidade'].'/'.$linha['uf'] ?></span></p>
            <!--<p><span class="row">Rooms: </span><span class="row1">3 Bebs, 2 Baths</span></p>-->
            <span class="price"><strong><?= 'R$ '.number_format($linha['valor'],2,',','.') ?></strong></span>
            <span class="readmore"><a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>">+ informações</a></span>
         </li>
    <?php } } } ?>
    </ul>    
</div>
<section id="content">        
    <div class="intro"><ul><li class="first"><img src="images/serv-3.png" alt=""/>Mais anúncios</li></ul></div>
<?php if (sizeof($dataSet) > 0) { foreach ($dataSet as $linha) { $titulo = substr($linha['titulo'], 0,20); $titulo = (strlen($titulo) == 20) ? $titulo.'...' : $titulo; if ($linha['posicao'] == 'N') { ?>
<?php $qtd_anuncio_n++; if ($controle_estilo == 1) { $estilo = 'property-selling first'; $controle_estilo = 2; } else { $estilo = 'property-selling'; $controle_estilo = 1; } ?>    
    <div class="<?= $estilo ?>">
        <a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>"><img src="images/upload/<?= $linha['img'] ?>" width="202" height="240" alt="" /></a>
        <h3><?= $titulo ?></h3>
        <div class="item-row"><span>Categoria: </span> <a href="javascript:void(0)"><strong><?= $linha['categoriaImovel'] ?></strong></a></div>
        <div class="item-row"><span>Localizado em:</span> <strong><?= $linha['cidade'].'/'.$linha['uf'] ?></strong></div>
        <div class="item-row"><span>Finalidade: </span> <strong><?= $linha['tipoAnuncio'] ?></strong></div>
        <span class="price"><strong><?= 'R$ '.number_format($linha['valor'],2,',','.') ?></strong></span>
        <span class="readmore"><a href="index.php?action=informacoesimovel&id=<?=$linha['idAnuncio']?>">+ informações</a></span>
    </div>
<?php } } } ?>    
    <?php if (1 == 0) { //se aumentar o numero de anuncio normal na pagina inicial aumentar tambem esse numero ?>
    <ul class="pagination">
        <!--<div id="carregando_normal" class="carregando" style="text-align: center; display: none;"><img src="images/ajax-loader.gif"><br />carregando...</div>-->
        <li><a id="btnMaisAnuncio" href="javascript: homeMaisAnuncios();"><strong>+ Mais resultados</strong></a></li>
    </ul>
    <?php } ?>
</section>
<?php include_once 'app/view/frontend/barralateral.php'; ?>
