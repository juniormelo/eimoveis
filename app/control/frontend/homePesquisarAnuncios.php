<?php  
    include_once '../../../config.php';                
    $imovel = new Imovel(Conf::pegCnxPadrao());
    $consulta = $imovel->pesquisarComAnuncio();
    $dataSet = $consulta->getResultados();
    $titulo = '';
    $anuncio_destaque = '';
    $tem_anuncio_destaque = 'no';
    $anuncio_normal   = '';
    $tem_anuncio_normal   = 'no';
    $controle_estilo = 1;
    $estilo = '';
    //$js = '<script type="text/javascript" src="js/custom.js"></script>';
    
    if (sizeof($dataSet) > 0) {
        $anuncio_destaque = $js.'<ul id="mycarousel" class="jcarousel-skin-tango">';
        
        foreach ($dataSet as $linha) {
            $titulo = substr($linha['titulo'], 0,20 );
            $titulo = (strlen($titulo) == 20) ? $titulo.'...' : $titulo;
            
            if ($linha['posicao'] == 'D') { //anuncios em destaque    //images/property/property-1.jpg              
                $anuncio_destaque .= '<li class="mosaic-block1 circle">'.
                    '<a href="images/preview/work_2_l.jpg." rel="" title="Image Title Here" class="mosaic-overlay."></a>
                        <img src="images/upload/'.$linha['img'].'" alt="" />'.
                    '<span>'.$titulo.'</span><br>'.
                    '<small><a href="leasing.html">'.$linha['tipoAnuncio'].'</a></small>'.
                    '<p><span class="row">Categoria: </span><span class="row1"><a href="#">'.$linha['categoriaImovel'].'</a></span></p>'.
                    '<p><span class="row">Localizado em: </span><span class="row1">'.$linha['cidade'].'/'.$linha['uf'].'</span></p>'.
                    '<!--<p><span class="row">Rooms: </span><span class="row1">3 Bebs, 2 Baths</span></p>-->'.
                    '<span class="price"> R$ '.number_format($linha['valor'],2,',','.').'</span>'.
                    '<span class="readmore"><a href="index.php?action=informacoesimovel">+ informações</a></span>'.
                    '</li>';
                $tem_anuncio_destaque = 'ok';
            } elseif ($linha['posicao'] == 'N') { //anuncios normais
                if ($controle_estilo == 1) {
                    $estilo = 'property-selling first';
                    $controle_estilo = 2;
                } else {
                    $estilo = 'property-selling';
                    $controle_estilo = 1;
                }
                $anuncio_normal .= '<div class="'.$estilo.'">'.
                                   '<a href="details.html"><img src="images/property/property-selling-1.jpg" alt="" /></a>'.
                                   '<h3><a href="details.html">'.$titulo.'</a></h3>'.
                                   '<div class="item-row"><span>Categoria: </span> <a href="#"><strong>'.$linha['categoriaImovel'].'</strong></a></div>'.
                                   '<div class="item-row"><span>Localizado em:</span> <strong>'.$linha['cidade'].'/'.$linha['uf'].'</strong></div>'.
                                   '<div class="item-row"><span>Finalidade: </span> <strong>'.$linha['tipoAnuncio'].'</strong></div>'.
                                   '<span class="price"> R$ '.number_format($linha['valor'],2,',','.').'</span>'.
                                   '<span class="readmore"><a href="index.php?action=informacoesimovel">+ informações</a></span>'.
                                   '</div>';
                $tem_anuncio_normal = 'ok';
            }                        
        }
        
        $anuncio_destaque .= '</ul>';        
        
        $status = 'ok';
        //GERA O JSON        
    } else {
        $status = 'no';
    }
    echo json_encode(array('status' => $status,
                    'tem_anuncio_destaque' => $tem_anuncio_destaque, 
                    'anuncio_destaque' => $anuncio_destaque, 
                    'tem_anuncio_normal' => $tem_anuncio_normal,
                    'anuncio_normal' => $anuncio_normal
        ));
?>