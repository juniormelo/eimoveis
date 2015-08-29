<?php

    $anuncio = new Anuncio(Conf::pegCnxPadrao());
    $anuncio->setIdAnuncio(isset($_GET['id'])?$_GET['id']:'0');    
    $dataSet = $anuncio->getAnuncio();
    if (sizeof($dataSet)) {
        $anuncio->registrarVisualizacao();
        $anuncio->setIdImovel($dataSet[0]['idImovel']);
        $dataSetImg   = $anuncio->getImagensAnuncio();
        $dataSetCarac = $anuncio->getCaracteristicas();
        $dataSetProx  = $anuncio->getProximidades();
        
        $area_total = '0';
        $quarto = '0';
        $banheiro = '0';
        $garagem = '0';
        
        foreach ($dataSetCarac as $linha) { 
            if ($linha['codigo'] == 'area_total') {
                $area_total = $linha['descricao'];
                break;
            }
        }
        
        foreach ($dataSetCarac as $linha) { 
            if ($linha['codigo'] == 'quarto') {
                $quarto = $linha['descricao'];
                break;
            }
        }
        
        foreach ($dataSetCarac as $linha) { 
            if ($linha['codigo'] == 'banheiro') {
                $banheiro = $linha['descricao'];
                break;
            }
        }
        
        foreach ($dataSetCarac as $linha) { 
            if ($linha['codigo'] == 'garagem') {
                $garagem = $linha['descricao'];
                break;
            }
        }
    }
    
?>

<?php include_once 'app/view/frontend/topopadrao.php'; ?>

<div class="container contents lisitng-grid-layout">

        <div class="row">
            
            <div class="span9 main-wrap">
               
                <!-- Main Content -->
                <div class="main">
                    
                    <?php if (sizeof($dataSet) > 0) { ?>
                     
                    <section id="overview">
                        
                        <?php if (sizeof($dataSetImg) > 0) { ?>
                            <div id="property-detail-flexslider" class="clearfix">
                                <div class="flexslider">

                                    <ul class="slides">
                                        <?php $primeira_img = ''; foreach ($dataSetImg as $linhaImg) : $primeira_img = ($linhaImg['foto'] != '' && $primeira_img == '') ? $linhaImg['foto'] : $primeira_img; ?>  
                                        
                                            <li data-thumb="<?= 'images/upload/'.$linhaImg['foto'] ?>">
                                                <a href="<?= 'images/upload/'.$linhaImg['foto'] ?>" class="swipebox">
                                                    <img style="width: 800px; height: 385px" src="<?= 'images/upload/'.$linhaImg['foto'] ?>" alt="<?=$linhaImg['descricao']?>">
                                                </a>
                                            </li>
                                        
                                        <?php endforeach; ?>
                                    </ul>

                                </div>
                            </div>
                        <?php } else { ?>
                            <br /><h1 style="color: red; font-style: italic;">O anúnciante não disponibilizou imagens!</h1>
                        <?php }  ?>

                        <article class="property-item clearfix">

                            <div class="wrap clearfix">
                                <h4 class="title">
                                    <?php //($dataSet[0]['titulo'] != '')?$dataSet[0]['titulo']:'Sem título'?>
                                    <?= $dataSet[0]['logradouro'].', '.$dataSet[0]['bairro'].' - '.$dataSet[0]['cidade'].'/'.$dataSet[0]['uf'] ?>
                                </h4>
                                <h5 class="price">
                                    <span class="status-label">
                                        <?= $dataSet[0]['tipoAnuncio'] ?>
                                    </span>
                                    <span>
                                        <?= ($dataSet[0]['valor'] == '' || $dataSet[0]['valor'] <= 0)?'<i>Valor a consultar</i>':'R$ '.number_format($dataSet[0]['valor'],2,',','.') ?> <small></small>
                                    </span>
                                </h5>
                            </div>

                            <div class="property-meta clearfix">
                                <span><i class="icon-area"></i><?=$area_total?>&nbsp;M2</span>                                
                                <span><i class="icon-bed"></i><?=$quarto?>&nbsp;Quarto(s)</span>
                                <span><i class="icon-bath"></i><?=$banheiro?>&nbsp;Banheiro(s)</span>
                                <span><i class="icon-garage"></i><?=$garagem?>&nbsp;Garagem</span>
                                <?php if (($dataSet[0]['qtdVisita']+1) > 1) { ?>
                                    <span><?=($dataSet[0]['qtdVisita']+1)?> visitas registradas</span>
                                <?php } else { ?>
                                    <span><?=($dataSet[0]['qtdVisita']+1)?> visita registrada</span>
                                <?php }  ?>
                                <!-- Print Icon -->                              
                                <span class=""><a href="javascript:void(0)" id="ircontatoanunciante">Contato com anunciante</a></span>
                            </div>

                            <div class="content clearfix">
                                <?php if ($dataSet[0]['descricao'] != '') { ?>                                    
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$dataSet[0]['descricao']?></p>
                                <?php } ?>
                            </div>
                            
                            <?php if (sizeof($dataSetCarac)) { ?>
                                <div class="features">
                                    <h4 class="title">Características</h4>
                                    <ul class="arrow-bullet-list clearfix">
                                        <?php foreach ($dataSetCarac as $linhaCarac) : ?>
                                            <li><a href="javascript:void(0);"><?= ($linhaCarac['descricao'] != '')?$linhaCarac['descricao'].'&nbsp;'.$linhaCarac['caracteristica']:$linhaCarac['caracteristica']?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php } ?>
                            
                            <?php if (sizeof($dataSetProx)) : ?>
                                <div class="features">
                                    <h4 class="title">Proximidades</h4>
                                    <ul class="arrow-bullet-list clearfix">
                                        <?php foreach ($dataSetProx as $linhaProx) { ?>                                        
                                            <li><a href="javascript:void(0);"><?= ($linhaProx['descricao'] != '')?'<strong>'.$linhaProx['proximidade'].'</strong>'.'<strong>:</strong>&nbsp;<i>'.$linhaProx['descricao'].'</i>':'<strong>'.$linhaProx['proximidade'].'</strong>' ?></a></li>
                                        <?php } ?>                                            
                                    </ul>
                                   
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($dataSet[0]['exibirMapa'] == 'S') : ?>
                             <div class="features">
                                <h4 class="title">Como chegar</h4>   
                                <div class="map" id="map" style="height: 360px; width: 100%;"></div>
                             </div>
                            <?php endif; ?>
                        </article>

                        <!-- <div class="property-video">
                            <span class="video-label">Property Video</span>
                            <a href="http://vimeo.com/70301553" class="pretty-photo" title="Video">
                                <div class="play-btn"></div>
                                <img src="images/temp-images/property-video-image.jpg" alt="700 Front Street, Key West, FL">
                            </a>
                        </div> -->
                        
                        
                        
                        
                        <?php if ($dataSet[0]['exibirMapa'] == 'S') { ?>
                        <div class="map-wrap clearfix">   <!-- id ou class property_map -->                         
                            <!--<span class="map-label">Como chegar</span>-->
                            <!--<div  id="property_map" >
                            </div>-->
                            
                            <!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>-->
                            <script type="text/javascript">
                                // Google Map
                                /*function initialize()
                                {
                                    var geocoder  = new google.maps.Geocoder();
                                    var map;
                                    var latlng = new google.maps.LatLng(-37.817917, 144.965065);
                                    var infowindow = new google.maps.InfoWindow();
                                    var myOptions = {
                                        zoom: 17,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    };

                                    map = new google.maps.Map(document.getElementById("property_map"), myOptions);

                                    geocoder.geocode( { 'location': latlng },
                                        function(results, status) {
                                            if (status == google.maps.GeocoderStatus.OK)
                                            {
                                                map.setCenter(results[0].geometry.location);
                                                var marker = new google.maps.Marker({
                                                    map: map,
                                                    position: results[0].geometry.location
                                                });
                                                //alert(results[0].formatted_address);
                                                //infowindow.setContent(results[0].formatted_address);
                                                //infowindow.open(map, marker);
                                            }
                                            else
                                            {
                                                alert("Geocode was not successful for the following reason: " + status);
                                            }
                                        });

                                }

                                initialize();*/
                            </script>

                            <div class="share-networks clearfix">
                                <span class="share-label">Compartilhar</span>
                                <span><a target="_blank" href="https://www.facebook.com"><i class="icon-facebook"></i>Facebook</a></span>
                                <span><a target="_blank" href="https://twitter.com"><i class="icon-twitter"></i>Twitter</a></span>
                                <span><a target="_blank" href="https://plus.google.com"><i class="icon-google-plus"></i>Google</a></span>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="agent-detail clearfix">

                            <div class="left-box">
                                <h3><?=$dataSet[0]['responsavel']?></h3>
                                <figure>
                                    <a href="#">
                                        <!--<img src="images/temp-images/agent-john.jpg"  alt="agent pic">-->
                                        <img src="<?= ($dataSet[0]['logo']!='') ? 'images/upload/'.$dataSet[0]['logo']:'images/semimagem.jpg' ?>" alt="<?=$dataSet[0]['responsavel']?>" width="210" height="210" />
                                    </a>
                                </figure>
                                <!--<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl…</p>-->
                                <ul class="contacts-list">                                    
                                    <li class=""><strong>CRECI:</strong>&nbsp;</li>
                                    <li class=""><strong>Contato:</strong>&nbsp;</li>
                                    <li class=""><strong>Telefone(s):</strong>&nbsp;<?= $dataSet[0]['telefone1'].($dataSet[0]['telefone2'] != '')?' '.$dataSet[0]['telefone2']:'' ?></li>
                                    <li class=""><strong><?= $dataSet[0]['email'] ?></strong></li>                                    
                                    <li class=""></li>                                    
                                </ul>
                            </div>

                            <div class="contact-form">

                                <h3 style="font-weight: bold">Contato</h3>

                                <form name="frmContatoAnuncio" id="frmContatoAnuncio" class="contact-form-small" method="post" action="javascript:void(0)">
                                    <input type="hidden" id="idAnuncioContato" name="idAnuncioContato" value="<?=$anuncio->getIdAnuncio()?>" />                                    
                                    <input type="text" name="nome" id="nome" class="" placeholder="Informe o seu nome" title="* Por favor, informe o seu nome">
                                    <input type="text" name="email" id="email" class="email" placeholder="Informe um e-mail valido" title="* Por favor, informe um e-mail valido">
                                    <input type="text" name="telefone" id="telefone" class="Telefone" placeholder="Telefone para contato" title="* Por favor, informe o telefone para contato.">
                                    <textarea name="mensagem" id="mensagem" class="required" title="* Por favor informe a sua mensagem" placeholder="Por favor, informe a sua mensagem"></textarea>
                                    <!--<input type="hidden" name="target" value="robot@psdtohtmlwp.com">
                                    <input type="hidden" name="action" value="send_message_to_agent">
                                    <input type="hidden" name="property_title" value="700 Front Street, Key West, FL">
                                    <input type="hidden" name="property_permalink" value="http://www.960demo.com/realhomes-html/property.php">-->
                                    <input type="submit" value="Enviar mensagem" name="btnContatoAnuncio" id="btnContatoAnuncio" class="real-btn">
                                </form>                                
                                <!--<div id="msgContato"></div>-->
                            </div>
                        </div>

                    </section>
                     <?php } else { ?>                        
                        <p class="error"><strong>Atenção:</strong> Anúncio inexistente!<i class="icon-remove"></i></p>
                        <p class="info"><a href="index.php?action=pesquisarimovel"><strong>Clique aqui para retornar à pesquisa de imoveis!</strong></a><i class="icon-remove"></i></p>                        
                     <?php } ?>
                </div><!-- End Main Content -->

            </div> <!-- End span9 -->
            

            <?php include_once 'app/view/frontend/formpesquisalateral.php'; ?>
            
            <div class="span3 sidebar-wrap">
                                
                <?php if (sizeof($dataSet) > 0) { ?>
                    <!-- Sidebar -->
                    <aside class="sidebar">

                        <section class="widget advance-search">
                            <h3 class="title search-heading">Informações do anúncio</h3>
                            <ul>                            
                                <li><strong>Código:</strong>&nbsp;<?= $dataSet[0]['codigo'] ?></li>
                                <li><strong>Imóvel:</strong>&nbsp;<?= $dataSet[0]['categoriaImovel'] ?></li>
                                <li><strong>Finalidade:</strong>&nbsp;<?= $dataSet[0]['tipoAnuncio'] ?></li>
                                <li><strong>Valor :</strong>&nbsp;<?= ($dataSet[0]['valor'] == '' || $dataSet[0]['valor'] <= 0)?'<i>Sob consulta</i>':'R$ '.number_format($dataSet[0]['valor'],2,',','.') ?></li>
                                <li><strong>Publicação:</strong>&nbsp;dd/mm/aaaa</li>
                                <li><strong>Visitas:</strong>&nbsp;<?=($dataSet[0]['qtdVisita']+1)?></li>
                            </ul>
                        </section>                    

                        <section class="widget advance-search">
                            <h3 class="title search-heading">Dicas de segurança</h3>
                            <ul>                            
                                <li>1 - Visite o imóvel antes de fechar o negócio;</li>                                   
                                <li>2 - Dica para fazer um bom negócio;</li>                                   
                                <li>3 - Verifique o estado de conservação;</li>                                   
                                <li>4 - Evite fornecer mais dados que os necessários.</li>  
                            </ul>
                        </section>

                    </aside><!-- End Sidebar -->
                <?php } ?>

            </div>
            
        </div><!-- End contents row -->

    </div><!-- End Content -->
    
<script>
    <?php if ($dataSet[0]['exibirMapa'] == 'S') : ?>
        //$(function(){
        window.onload = function(){
            initMap(<?= "'".$dataSet[0]['logradouro'].', 0,'.$dataSet[0]['cidade'].', '.$dataSet[0]['uf']."'" ?>,'map');
            addMarker(<?= "'".$dataSet[0]['logradouro'].', '.$dataSet[0]['numLogradouro'].', '.$dataSet[0]['cidade'].' - '.$dataSet[0]['uf']."'" ?>,'<img src="images/upload/<?= $primeira_img ?>" style="height: 40px; width: 60px;" /> ');            
        }
     //});
    <?php endif; ?>
</script>