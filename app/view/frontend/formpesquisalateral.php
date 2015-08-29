<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="span3 sidebar-wrap">
    <!-- Sidebar -->
    <aside class="sidebar">

        <section class="widget advance-search">
            <h4 class="title search-heading">Pesquisar imóvel<i class="icon-search"></i></h4>
            <div class="as-form-wrap">
                <form class="advance-search-form clearfix" action="javascript:void(0);">

                    <!--<div class="option-bar">                        
                        <label for="uf">Por palavra-chave:</label>                        
                        <input type="text" id="palvrachave" name="palvrachave" placeholder="busque por palavra-chave" >                                                
                    </div>-->
                    
                    <div class="option-bar">
                        
                        <label for="uf">Estado:</label>
                        <span class="selectwrap">                                        
                            <select id="uf" name="uf">
                                <option></option>
                                <?php
                                    $imovel = new Imovel(Conf::pegCnxPadrao());
                                    Utilitarios::preencheComboDB($imovel->getUfComAnuncio());
                                ?>
                            </select>
                        </span>
                        
                    </div>                                       

                    <div class="option-bar">
                        
                        <label for="categoria">Imóvel:</label>
                        <span class="selectwrap">
                            <select id="categoria" name="categoria">
                                <option></option>
                            </select>
                        </span>
                        
                    </div>

                    <div class="option-bar">
                        
                        <label for="finalidade">Finalidade:</label>
                        <span class="selectwrap">
                            <select id="finalidade" name="finalidade">
                                <option></option>
                            </select>
                        </span>
                        
                    </div>

                    <div class="option-bar mini first">
                        <label for="cidade">Cidade:</label>
                        <span class="selectwrap">
                            <select id="cidade" name="cidade">
                                <option></option>
                            </select>
                        </span>
                    </div>

                    <div class="option-bar mini">
                        <label for="bairro">Bairro:</label>
                        <span class="selectwrap">
                            <select id="bairro" name="bairro">
                                <option></option>
                            </select>
                        </span><br />
                    </div>

                    <div class="">
                        <span><a id="pesquisar" href="javascript:redirecionaPesquisaImovel();" class="real-btn btn"><strong>Pesquisar</strong></a></span>
                        <!--<span><a id="btnFiltros" href="javascript:void(0);" class="btn-blue btn"><strong>+ Filtros</strong></a></span>-->
                    </div>
                </form>
            </div>
        </section>   
        
        <section class="widget advance-search">
            <h4 class="title search-heading">Não encontro o imóvel???</h4>
            <div class="as-form-wrap">
                <form class="advance-search-form clearfix" action="javascript:void(0);">

                    <div class="option-bar">                        
                        <h4>Não encontrou o imóvel que procura?</h4><br />                        
                    </div>                                                                               

                    <div class="">
                        <span><a id="btnImoSol" href="index.php?action=solicitarimovel" class="btn-blue btn"><strong>Então, clique aqui!</strong></a></span>                        
                    </div>
                </form>
            </div>
        </section>   

    </aside><!-- End Sidebar -->
</div>