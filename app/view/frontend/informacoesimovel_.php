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
    }
?>

<?php if (sizeof($dataSet) > 0) { ?>
<div class="breadcrumbs">
    <div class="bread-top">        
        <h2><strong><?=($dataSet[0]['titulo'] != '')?$dataSet[0]['titulo']:'Sem título'?><br><span class="area"><?=$dataSet[0]['cidade'].'/'.$dataSet[0]['uf'].' - '.$dataSet[0]['logradouro'].', '.$dataSet[0]['bairro'].'.' ?></span></strong></h2>
        <span class="left"><a href="javascript:history.back(1)">Voltar para a pesquisa de imóveis.</a></span>
    </div>
</div>
<?php } ?>

<section id="content">        
<?php if (sizeof($dataSet) > 0) { ?>
    <?php if (sizeof($dataSetImg) > 0) { ?>
    <div id="galleria">
        <?php $primeira_img = ''; foreach ($dataSetImg as $linhaImg) { $primeira_img = ($linhaImg['foto'] != '' && $primeira_img == '') ? $linhaImg['foto'] : $primeira_img; ?>  
        <a href="<?= 'images/upload/'.$linhaImg['foto'] ?>">
            <img width="100" height="100"src="<?= 'images/upload/'.$linhaImg['foto'] ?>"
            <?php if ($linhaImg['descricao'] != '') { ?>
                ,data-title="Informação:"
                data-description="<?=$linhaImg['descricao']?>"
            <?php } ?>
            >
        </a>       
        <?php } ?>
    </div>
 <?php } else { ?>
    <br /><h1 style="color: red; font-style: italic;">O anúnciante não disponibilizou imagens!</h1>
 <?php } ?>      
    
<?php if ($dataSet[0]['descricao'] != '') { ?>
    <br /><h2><strong>Anúncio:</strong></h2>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$dataSet[0]['descricao']?></p>
<?php } ?>        
    
    <br /><h2><strong>Características:</strong></h2>
    <ul class="caracteristicas">
    <?php if (sizeof($dataSetCarac)) { foreach ($dataSetCarac as $linhaCarac) { ?>
        <li><?= ($linhaCarac['descricao'] != '')?'<strong>'.$linhaCarac['caracteristica'].'</strong>'.'<strong>:</strong>&nbsp;<i>'.$linhaCarac['descricao'].'</i>':'<strong>'.$linhaCarac['caracteristica'].'</strong>' ?></li>
    <?php } } else { ?>
        <li><i>Nenhuma característica informada.</i></li>
    <?php }?>        
    </ul>
        
    <h2><strong>Próximo a:</strong></h2>
    <ul class="proximo_a">
    <?php if (sizeof($dataSetProx)) { foreach ($dataSetProx as $linhaProx) { ?>
        <li><?= ($linhaProx['descricao'] != '')?'<strong>'.$linhaProx['proximidade'].'</strong>'.'<strong>:</strong>&nbsp;<i>'.$linhaProx['descricao'].'</i>':'<strong>'.$linhaProx['proximidade'].'</strong>' ?></li>
    <?php } } else { ?>
        <li><i>Nenhuma proximidade informada.</i></li>
    <?php } ?> 
    </ul>    
    
    <?php if ($dataSet[0]['exibirMapa'] == 'S') { ?>
    <h2><strong>Como chegar:</strong></h2>
    <div class="map" id="map" style="height: 350px; width: 100%;"></div>
    <?php } ?>
    
    <br />
    <div class="painelInfo">
        <h2 style="background:url(images/email.png) no-repeat left top; padding-left:50px;"><strong>Entre em contato com o anunciante:</strong></h2>
        <div id="note"></div>
        <div>
            <img src="<?= ($dataSet[0]['logo']!='') ? 'images/upload/'.$dataSet[0]['logo']:'images/semimagem.jpg' ?>" title="<?=$dataSet[0]['responsavel']?>" width="120" height="110" />
            <p style="font-size: 20px;font-weight: bold"><?=$dataSet[0]['responsavel']?></p>
            <p style="font-size: 14px;"><strong>E-mail:</strong>&nbsp;<?= $dataSet[0]['email'] ?></p>
            <p style="font-size: 14px;"><strong>Fone(s):</strong>&nbsp;<?= $dataSet[0]['telefone1'].' / '.$dataSet[0]['telefone2'] ?></p>
            <p style="font-size: 14px;"><strong>CRECI:</strong>&nbsp;<?php //$dataSet[0]['email'] ?></p>
        </div>
        <div id="msgContato" style="width:93%; display: none;"></div>        
        <form action="javascript:void(0);" id="formAnuncioContato" class="contactForm">
            <input type="hidden" id="idAnuncio" name="idAnuncio" value="<?= isset($_GET['id'])?$_GET['id']:'0' ?>" />
            <table style="width: 100%">
                <tr>
                    <td><h4>Nome:</h4></td>
                    <td><h4>Telefone:</h4></td>
                    <td><h4>E-mail:</h4></td>
                </tr>
                <tr>
                    <td><input type="text" id="nome" name="nome" value="Nome" onblur="if (this.value == ''){this.value = 'Nome'; }" onfocus="if (this.value == 'Nome') {this.value = '';}" ></td>
                    <td><input type="text" id="telefone" name="telefone" class="telefone" value="Telefone" onblur="if (this.value == ''){this.value = 'Telefone'; }" onfocus="if (this.value == 'Telefone') {this.value = '';}"></td>
                    <td><input type="text" id="email" name="email" value="E-mail" onblur="if (this.value == ''){this.value = 'E-mail'; }" onfocus="if (this.value == 'E-mail') {this.value = '';}"></td>
                </tr>
            </table>            
            <textarea id="mensagem" name="mensagem" rows="10" cols="20" onblur="if (this.value == ''){this.value = 'Sua Mensagem'; }" onfocus="if (this.value == 'Sua Mensagem') {this.value = '';}">Sua Mensagem</textarea>
            <p><input type="submit" id="btnContatoAnuncio" name="submit" class="submit" value="Enviar mensagem"></p>
        </form>
    </div>    
<?php } else { ?>
    <h1><strong>Anúncio inexistente!</strong></h1><br />
    <a href="index.php?action=pesquisarimovel"><strong>Clique aqui para retornar à pesquisa de imoveis!</strong></a>
<?php } ?>
</section>

<?php if (sizeof($dataSet) > 0) { ?>
<aside id="sidebar">    
    <div class="subscribe">
        <h3 style="font-weight: bold;">Anunciante:</h3>
        <div class="anunciante">
            <div style="text-align: center;">
                <img src="<?= ($dataSet[0]['logo'] != '')?'images/upload/'.$dataSet[0]['logo']:'images/semimagem.jpg' ?>" title="<?=$dataSet[0]['responsavel']?>" width="120" height="110" />
            </div>
            <h3><strong><?=$dataSet[0]['responsavel']?></strong><br><span><strong>Fone(s): </strong><?= $dataSet[0]['telefone1'].' / '.$dataSet[0]['telefone2'] ?></span><br /><span><strong>CRECI: </strong>00000</span></h3>
            <h3 style="background:url(images/email.png) no-repeat left top; padding-left:50px;">
                <a href="javascript:void(0)" id="btnIrParaMensagem" ><strong>Enviar uma mensagem.</strong></a>
            </h3>
            <h5><a href="javascript:void(0)"><strong>+Anuncios deste anunciante.</strong></a></h5>
        </div>        
    </div>
    <div class="subscribe">
        <h3 style="background:url(images/info.png) no-repeat left top; padding-left:50px;">Informações do anúncio:</h3><br />
        <table class="tabelaInfoAnuncio">
            <tr>
                <td><strong>Código:</strong></td>
                <td>&nbsp;<?= $dataSet[0]['codigo'] ?></td>
            </tr>
            <tr>
                <td><strong>Imóvel:</strong></td>
                <td>&nbsp;<?= $dataSet[0]['categoriaImovel'] ?></td>
            </tr>
            <tr>
                <td><strong>Finalidade:</strong></td>
                <td>&nbsp;<?= $dataSet[0]['tipoAnuncio'] ?></td>
            </tr>
            <tr>
                <td><strong>Valor :</strong></td>
                <td>&nbsp;<?= ($dataSet[0]['valor'] == '' || $dataSet[0]['valor'] <= 0)?'<i>Sob consulta</i>':'R$ '.number_format($dataSet[0]['valor'],2,',','.') ?></td>
            </tr>
            <tr>
                <td><strong>Publicação:</strong></td>
                <td>&nbsp;dd/mm/aaaa</td>
            </tr>
            <tr>
                <td><strong>Visitas:</strong></td>
                <td>&nbsp;<?=($dataSet[0]['qtdVisita']+1)?></td>
            </tr>
        </table>
    </div>
    <div class="subscribe">
        <h3 style="background:url(images/dicas_verde.png) no-repeat left top; padding-left:50px;">Dica(s) para fazer um bom negórcio:</h3><br />   
        <hr  /><br />
        <ul class="lista_dicas">
            <li>1 - Visite o imóvel antes de fechar o negócio;</li>                                   
            <li>2 - Dica para fazer um bom negócio;</li>                                   
            <li>3 - Verifique o estado de conservação;</li>                                   
            <li>4 - Evite fornecer mais dados que os necessários.</li>                                   
        </ul><br />
        <div style="text-align: right; font-weight: bold;"><a href="#">+ Dicas</a></div>
    </div>
</aside>
<?php include_once 'app/view/frontend/barralateral.php'; } ?>
<script>    
    <?php if (sizeof($dataSet) > 0) { if (sizeof($dataSetImg) > 0) { ?>
    Galleria.loadTheme('js/galleria.classic.min.js'); //Load the classic theme    
    Galleria.run('#galleria'); //Initialize Galleria
    <?php } if ($dataSet[0]['exibirMapa'] == 'S') { ?>
    $(function(){
        window.onload = function(){
            initMap(<?= "'".$dataSet[0]['logradouro'].', 0,'.$dataSet[0]['cidade'].', '.$dataSet[0]['uf']."'" ?>,'map');
            addMarker(<?= "'".$dataSet[0]['logradouro'].', '.$dataSet[0]['numLogradouro'].', '.$dataSet[0]['cidade'].' - '.$dataSet[0]['uf']."'" ?>,'<img src="images/upload/<?= $primeira_img ?>" style="height: 40px; width: 60px;" /> ');            
        }
     });
    <?php } } ?>
</script>