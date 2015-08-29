<?php  
    include_once '../../../config.php';                
    $obj = new Imovel(Conf::pegCnxPadrao());
    $obj->setUf($_POST['uf']);
    $obj->setIdCategoria($_POST['categoria']);
    Utilitarios::preencheComboDB($obj->getTipoAnuncioComAnuncio(),null,'Todos',true);
?>