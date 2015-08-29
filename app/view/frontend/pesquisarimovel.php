<?php
    $imovel = new Imovel(Conf::pegCnxPadrao());
    $imovel->setUf(isset($_GET['uf'])?$_GET['uf']:'');
    $imovel->setIdCategoria(isset($_GET['categoria'])?$_GET['categoria']:'');
    $imovel->set_tipoAnuncio(isset($_GET['finalidade'])?$_GET['finalidade']:'');
    $imovel->setCidade(isset($_GET['cidade'])?$_GET['cidade']:'');
    $imovel->setBairro(isset($_GET['bairro'])?$_GET['bairro']:'');
    $dataSet = $imovel->pesquisarComAnuncio();
    $titulo = '';
    $descricao = '';
?>

<?php include_once 'app/view/frontend/topopadrao.php'; ?>
    <!-- Content -->
    <div class="container contents lisitng-grid-layout">
        <div class="row">
                      
            <?php include_once 'app/view/frontend/formpesquisalateral.php'; ?>                        
            
            <div class="span9 main-wrap">

                <!-- Main Content -->
                <div class="main">

                    <section class="listing-layout">
                        <?php if (sizeof($dataSet) > 0) { ?>
                            <h3 class="title-heading"><i><?=(sizeof($dataSet)>1)?'A sua pesquisa encontrou '.sizeof($dataSet).' anúncios':'A sua pesquisa encontrou '.sizeof($dataSet).' anúncio'?>.</i></h3>
                        <?php } else { ?>
                            <div class="intro"><ul><li class="first"><img src="images/serv-3.png" alt=""/>Nenhum imóvel encontrado.</li></ul></div>
                        <?php } ?>

                        <!--<div class="view-type clearfix">
                            <a class="list active" href="simple-listing.html"></a>
                            <a class="grid" href="grid-listing.html"></a>
                        </div>-->

                        <div class="list-container clearfix">
                            <?php 
                            if (sizeof($dataSet) > 0) { foreach ($dataSet as $linha) { 
                                $titulo = substr($linha['titulo'], 0,50 ); $titulo = (strlen($titulo) == 50) ? $titulo.'...' : $titulo;
                                $descricao = substr($linha['descricao'], 0,213 ); $descricao = (strlen($descricao) == 213) ? $descricao.'...' : $descricao;          
                             ?> 
                            
                                <div class="span6 ">
                                    <article class="property-item clearfix">

                                        <h4><a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>" title="<?= $titulo ?>"><strong><?= $titulo ?></strong></a></h4>

                                        <figure>
                                            <a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>" title="<?= $titulo ?>">
                                                <!-- class="attachment-property-thumb-image wp-post-image" -->
                                                <img src="images/upload/<?= $linha['img'] ?>" alt="<?= $titulo ?>" title="<?= $titulo ?>" style="width: 250px; height: 150px">                                            
                                            </a>                                            
                                            <figcaption><strong><?= $linha['tipoAnuncio'] ?></strong></figcaption>                                            
                                        </figure>

                                        <div class="detail">
                                            <h5 class="price">
                                                <strong><?= ($linha['valor'] == '' || $linha['valor'] <= 0)?'<i>Valor sob consulta</i> ':'R$ '.number_format($linha['valor'],2,',','.') ?><small> - <?= $linha['categoriaImovel'] ?></small></strong>
                                            </h5>
                                            <p>
                                                &nbsp;&nbsp;&nbsp;&nbsp;<?= $descricao ?>                                                
                                            </p>
                                            <p style="text-align: right; font-weight: bold">
                                                <i>Anúnciado em <?= $linha['dataCadastro'] ?>.</i>
                                            </p>
                                            <!--<a class="more-details" href="javascript:void(0);"><strong><i>Anúnciado em <?php //$linha['dataCadastro'] ?></i></strong></a><br />-->
                                            <a class="btn btn-blue" href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>"><strong>+ Detalhes</strong> <i class="icon-caret-right"></i></a>
                                        </div>

                                        <div class="property-meta">
                                            <span><i class="icon-area"></i><?=($linha['area_total']=='')?0:$linha['area_total']?>&nbsp;M2</span>
                                            <span><i class="icon-bed"></i><?=($linha['quarto']=='')?0:$linha['quarto']?>&nbsp;Quarto(s)</span>
                                            <span><i class="icon-bath"></i><?=($linha['banheiro']=='')?0:$linha['banheiro']?>&nbsp;Banheiro(s)</span>
                                            <span><i class="icon-garage"></i><?=($linha['garagem']=='')?0:$linha['garagem']?>&nbsp;Garagem</span>
                                            
                                            <?php if ($linha['qtdVisita'] > 1) { ?>
                                                <span><i>Este anúncio já foi visto <?=($linha['qtdVisita'])?> vezes.</i></span>
                                            <?php } else { ?>
                                                <span><i></i></span>
                                            <?php } ?>
                                        </div>

                                    </article>
                                </div>
                            
                            <?php } } ?>                              
                                                                                    
                        </div>

                        <!-- <div class="pagination">.
                            <a href="#" class="real-btn current">1</a>
                            <a href="#" class="real-btn">2</a>
                        </div> -->
                    </section>

                </div><!-- End Main Content -->

            </div> <!-- End span9 -->

        </div><!-- End contents row -->

    </div>
    <!-- End Content -->