<?php  
    include_once '../../../config.php';                
    $obj = new Imovel(Conf::pegCnxPadrao());
    $obj->setUf($_POST['uf']);
    $obj->setIdCategoria($_POST['categoria']);
    $obj->set_tipoAnuncio($_POST['finalidade']);
    Utilitarios::preencheComboDB($obj->getCidadeComAnuncio(),null,'Todos',true);
?>
