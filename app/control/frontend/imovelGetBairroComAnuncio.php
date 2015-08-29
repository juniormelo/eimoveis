<?php  
    include_once '../../../config.php';                
    $obj = new Imovel(Conf::pegCnxPadrao());
    $obj->setUf($_POST['uf']);
    $obj->setIdCategoria($_POST['categoria']);
    $obj->set_tipoAnuncio($_POST['finalidade']);
    $obj->setCidade($_POST['cidade']);
    Utilitarios::preencheComboDB($obj->getBairroComAnuncio(),null,'Todos',true);
?>
