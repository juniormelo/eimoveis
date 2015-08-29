<?php
    SiteVisita::registraVisita();
    $imovel = new Imovel(Conf::pegCnxPadrao());
    $dataSet = $imovel->pesquisarComAnuncio(40);
    $titulo = '';
    $descricao = '';
    //include_once 'app/view/frontend/topoprincipal.php';
    include_once 'app/view/frontend/topopadrao.php';
?>
<div class="container contents">
    <div class="row">
        <div class="span12">
            <div class="main">
                <section class="advance-search ">
                    <h3 class="search-heading"><i class="icon-search"></i>Encontre seu imóvel</h3>
                    <div class="as-form-wrap">
                        <form class="advance-search-form clearfix" action="" method="get">

                            <div class="option-bar large">
                                <label for="uf">Estado:</label>
                                <span class="selectwrap">                                        
                                    <select id="uf" name="uf" style="width: 100%">
                                        <option></option>
                                        <?php
                                        $imovel = new Imovel(Conf::pegCnxPadrao());
                                        Utilitarios::preencheComboDB($imovel->getUfComAnuncio());
                                        ?>
                                    </select>
                                </span>
                            </div>

                            <div class="option-bar large">                                
                                <label for="categoria">Imóvel:</label>
                                <span class="selectwrap">
                                    <select id="categoria" name="categoria" style="width: 100%">
                                        <option></option>
                                    </select>
                                </span>
                            </div>

                            <div class="option-bar large last">                                
                                <label for="finalidade">Finalidade:</label>
                                <span class="selectwrap">
                                    <select id="finalidade" name="finalidade" style="width: 100%">
                                        <option></option>
                                    </select>
                                </span>
                            </div>

                            <div class="option-bar large">                                
                                <label for="cidade">Cidade:</label>
                                <span class="selectwrap">
                                    <select id="cidade" name="cidade" style="width: 100%">
                                        <option></option>
                                    </select>
                                </span>
                            </div>

                            <div class="option-bar large">                               
                                <label for="bairro">Bairro:</label>
                                <span class="selectwrap">
                                    <select id="bairro" name="bairro" style="width: 100%">
                                        <option></option>
                                    </select>
                                </span>
                            </div>

                            <div class="option-bar large last" style="text-align: left;">
                                <span><a id="pesquisar" href="javascript:redirecionaPesquisaImovel();" class="real-btn btn"><strong>Pesquisar</strong></a></span>
                            </div>

                        </form>
                    </div>
                </section><!-- End .advance-search -->
                <?php if (1 == 0) : ?>
                <section class="featured-properties-carousel clearfix">
                    <div class="narrative">
                        <h3><strong>Imóveis em destaque</strong></h3>
                        <p><strong>Veja nossos imoveis em destaque.</strong></p>
                    </div>
                    <div class="carousel es-carousel-wrapper">
                        <div class="es-carousel">
                            <ul class="clearfix">

                                <?php if (sizeof($dataSet) > 0) {foreach ($dataSet as $linha) { if ($linha['posicao'] == 'D') { $titulo = substr($linha['titulo'], 0, 28); $titulo = (strlen($titulo) == 28) ? $titulo . '...' : $titulo; $descricao = substr($linha['descricao'], 0, 65); $descricao = (strlen($descricao) == 65) ? $descricao . '...' : $descricao; ?>
                                    <li>
                                        <figure>
                                            <a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>" title="<?= $linha['titulo'] ?>">
                                                <img src="images/upload/<?= $linha['img'] ?>" alt="<?= $linha['titulo'] ?>" title="<?= $linha['titulo'] ?>" style="width: 250px; height: 150px" >
                                            </a>
                                        </figure>
                                        <h4><a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>" title="<?= $linha['titulo'] ?>"><strong><?= $titulo ?></strong></a></h4>
                                        <p><?=$descricao?>&nbsp;&nbsp;&nbsp;<a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>"><strong>+ Detalhes</strong><i class="icon-caret-right"></i></a></p>
                                        <span class="price"><strong><?= $linha['tipoAnuncio'] ?></strong></span>
                                        <span class="price"><strong><?= 'R$ ' . number_format($linha['valor'], 2, ',', '.') ?></strong></span>
                                    </li>
                                <?php } } } ?>

                            </ul>
                        </div>
                        <div class="es-nav"><span class="es-nav-prev"></span><span class="es-nav-next"></span></div></div>
                </section><!-- End .eatured-properties-carousel -->
                
                <?php endif; ?>
                
                <hr />

                <section class="property-items">

                    <!--<div class="narrative">
                        <h2>Estamos oferecendo as melhores ofertas de imóveis</h2>
                       <p>Veja os nossos Últimas propriedades listadas e verificar as instalações neles, já vendeu mais de 5.000 casas e ainda estamos indo em ritmo muito bom. Gostaríamos muito que você olhar para estas propriedades, e esperamos que você vai encontrar algo match-capazes de suas necessidades.</p>
                    </div>-->

                    <div class="property-items-container clearfix"><br />
                        
                        <?php if (sizeof($dataSet) > 0) { 
                                foreach ($dataSet as $linha) {
                                    
                                    //if ($linha['posicao'] == 'N') { 
                                        $titulo = substr($linha['titulo'], 0, 40); $titulo = (strlen($titulo) == 40) ? $titulo . '...' : $titulo; 
                                        $descricao = substr($linha['descricao'], 0, 145); $descricao = (strlen($descricao) == 145) ? $descricao . '...' : $descricao; 
                        ?>
                            <div class="span6">
                                <article class="property-item clearfix">
                                    <h4><a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>" title="<?= $linha['titulo'] ?>"><?= $titulo ?></a></h4>

                                    <figure>
                                        <a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>" title="<?= $linha['titulo'] ?>">
                                            <img src="images/upload/<?= $linha['img'] ?>"  alt="<?= $linha['titulo'] ?>" title="<?= $linha['titulo'] ?>" style="width: 300px; height: 200px;">
                                        </a>
                                        <small><strong><i>&nbsp;&nbsp;&nbsp;Anúnciado em <?= $linha['dataCadastro'] ?></i></strong></small>
                                    </figure>

                                    <div class="detail">
                                        <h5 class="price"><strong><?= 'R$ ' . number_format($linha['valor'], 2, ',', '.') ?> - <?= $linha['tipoAnuncio'] ?></strong></h5>
                                        <p>
                                            <?= $descricao ?>
                                            <!--<br/><strong><i>Anúnciado em <?php //$linha['dataCadastro'] ?></i></strong>-->
                                        </p>
                                        <a class="btn btn-blue" href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>"><strong>+ Detalhes</strong> <i class="icon-caret-right"></i></a>
                                    </div>

                                    <div class="property-meta">
                                        <span><i class="icon-area"></i><?=($linha['area_total']=='')?0:$linha['area_total']?>&nbsp;M2</span>
                                        <span><i class="icon-bed"></i><?=($linha['quarto']=='')?0:$linha['quarto']?>&nbsp;Quarto(s)</span>
                                        <span><i class="icon-bath"></i><?=($linha['banheiro']=='')?0:$linha['banheiro']?>&nbsp;Banheiro(s)</span>
                                        <span><i class="icon-garage"></i><?=($linha['garagem']=='')?0:$linha['garagem']?>&nbsp;Garagem</span>
                                    </div>
                                </article>
                            </div><!-- End .span6 -->
                        <?php } } //} ?>                                                                                        

                    </div><!-- End .property-items-container -->
                    <!--<div class="pagination">
                        <a href="#" class="real-btn current">1</a> <a href="#" class="real-btn">2</a>
                    </div>-->
                </section><!-- End .property-items -->
            </div><!-- End .main -->
        </div><!-- End span12 -->
    </div><!-- End .row -->
</div><!-- End .contents -->