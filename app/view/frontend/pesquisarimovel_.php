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
<section style="border: 1px solid gainsboro;  margin-bottom: 20px; padding-bottom: 30px;">
    <h2 style="background:url(images/search.png) no-repeat left; padding-top: 10px;padding-left:40px;font-weight: bold;">Encontre o seu imóvel:</h2><br/>
    <form action="#" method="post" style="padding-left: 25px;">
        <label for="uf"><strong>Estado:</strong></label>
        <select id="uf" name="uf" style="width: 20%;">
            <option></option>
            <?php
                $imovel = new Imovel(Conf::pegCnxPadrao());
                Utilitarios::preencheComboDB($imovel->getUfComAnuncio());
            ?>
        </select>&nbsp;&nbsp;
        <label for="categoria"><strong>Imóvel:</strong></label>
        <select id="categoria" style="width: 20%;">
            <option></option>                   
        </select>&nbsp;&nbsp;
        <label for="finalidade"><strong>Finalidade:</strong></label>
        <select id="finalidade" style="width: 20%;">
            <option></option>                                     
        </select><br /><br />
        <label for="cidade"><strong>Cidade:</strong></label>
        <select id="cidade" style="width: 20%;">
            <option></option>                   
        </select>&nbsp;&nbsp;
        <label for="bairro"><strong>Bairro:</strong></label>
        <select id="bairro" style="width: 20%;">
            <option></option>                    
        </select>        
        &nbsp;&nbsp;<button type="button" id="btnPesquisar" class="button yellow medium">Pesquisar</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="button" class="btnSolicitarImovel button blue medium">Não encontrei o imóvel</button>
    </form> 
</section>
<section id="content">
    <?php if (sizeof($dataSet) > 0) { ?>
    <div class="intro"><ul><li class="first"><img src="images/serv-3.png" alt=""/><?=(sizeof($dataSet)>1)?sizeof($dataSet).' Imóveis encontrados':sizeof($dataSet).' Imóvel encontrado'?></li></ul></div>
    <?php } else {?>
    <div class="intro"><ul><li class="first"><img src="images/serv-3.png" alt=""/>Nenhum imóvel encontrado.</li></ul></div>
    <?php } ?>
    <div id="anuncio_normal">
    <?php 
    if (sizeof($dataSet) > 0) { foreach ($dataSet as $linha) { 
        $titulo = substr($linha['titulo'], 0,30 ); $titulo = (strlen($titulo) == 30) ? $titulo.'...' : $titulo;
        $descricao = substr($linha['descricao'], 0,213 ); $descricao = (strlen($descricao) == 213) ? $descricao.'...' : $descricao;          
     ?>    
        <div class="property">
            <a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>"><img src="images/upload/<?= $linha['img'] ?>" width="202" height="177" alt="" /></a>
            <h3><strong><?= $titulo ?></strong><br><span><?= $linha['cidade'].'/'.$linha['uf'] ?></span></h3>
            <p><strong>Valor: </strong><span class="price"><strong><?= ($linha['valor'] == '' || $linha['valor'] <= 0)?'<i>Sob consulta</i>':'R$ '.number_format($linha['valor'],2,',','.') ?></strong></span></p>
            <p><?= $descricao ?></p>           
            <span class="link_btn"><a href="index.php?action=informacoesimovel&id=<?= $linha['idAnuncio'] ?>">+ informações</a></span>            
        </div>
    <?php } } ?>        
        <!--<ul class="pagination">
            <li class="page">pagína 2 of 20</li>
            <li><a href="#">&laquo;</a></li>
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">&raquo;</a></li>
            <li><a href="#">ultima</a></li>
        </ul>-->
    <?php ?>
    </div>
</section>
<?php include_once 'app/view/frontend/barralateral.php'; ?>