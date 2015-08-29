<?php  
    include_once '../../../config.php';                
    $obj = new Imovel(Conf::pegCnxPadrao());
    $obj->setUf($_POST['uf']);
    Utilitarios::preencheComboDB($obj->getCategoriaComAnuncio(),null,'Todos',true);
?>
