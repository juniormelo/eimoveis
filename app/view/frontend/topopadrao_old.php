<div id="featured">
    <div class="flexslider clearfix">
        <ul class="slides">
            <li><a href="#"><img src="images/featured/featured-1.jpg" alt="Image" /></a>
                <div class="flex-caption">
                    <h3>Glass house</h3>
                    <p>&mdash; Lorem set magna ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod dipisicing...</p>
                    <span class="price"><a href="#">$ 100,500.00</a></span>
                    <span class="buynow"><a href="#">Buy Now!</a></span>
                </div>
            </li>
            <li><a href="#"><img src="images/featured/featured-2.jpg" alt="Image" /></a>
                <div class="flex-caption">
                    <h3>House in Florida</h3>
                    <p>&mdash; Lorem set magna ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod dipisicing...</p>
                    <span class="price"><a href="#">$90,500.00</a></span>
                    <span class="buynow"><a href="#">Buy Now!</a></span>
                </div>
            </li>
            <li><a href="#"><img src="images/featured/featured-3.jpg" alt="Image" /></a>
                <div class="flex-caption">
                    <h3>Mountain chalet</h3>
                    <p>&mdash; Lorem set magna ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod dipisicing...</p>
                    <span class="price"><a href="#">$ 200,500.00</a></span>
                    <span class="buynow"><a href="#">Buy Now!</a></span>
                </div>
            </li>
            <li><a href="#"><img src="images/featured/featured-4.jpg" alt="Image" /></a>
                <div class="flex-caption">
                    <h3>Living room in Italy</h3>
                    <p>&mdash; Lorem set magna ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod dipisicing...</p>
                    <span class="price"><a href="#">$ 230,500.00</a></span>
                    <span class="buynow"><a href="#">Buy Now!</a></span>
                </div>
            </li>
            <li><a href="#"><img src="images/featured/featured-3.jpg" alt="Image" /></a>
                <div class="flex-caption">
                    <h3>Mountain chalet</h3>
                    <p>&mdash; Lorem set magna ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod dipisicing...</p>
                    <span class="price"><a href="#">$ 200,500.00</a></span>
                    <span class="buynow"><a href="#">Buy Now!</a></span>
                </div>
            </li>
            <li><a href="#"><img src="images/featured/featured-4.jpg" alt="Image" /></a>
                <div class="flex-caption">
                    <h3>Living room in Italy</h3>
                    <p>&mdash; Lorem set magna ipsum dolor sit amet, consect etur adipisicing elit, sed do eiusmod dipisicing...</p>
                    <span class="price"><a href="#">$ 230,500.00</a></span>
                    <span class="buynow"><a href="#">Buy Now!</a></span>
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="find_property">
    <h2><strong>Encontre o seu imóvel</strong></h2>
    <form action="#" method="post">
        <ul>            
            <li>
                <label for="uf">Estado:</label><br>
                <select id="uf" name="uf" class="location">
                    <option></option>
                    <?php
                        $imovel = new Imovel(Conf::pegCnxPadrao());
                        Utilitarios::preencheComboDB($imovel->getUfComAnuncio());
                    ?>
                </select>	
            </li>
            <li class="s-2 first">
                <label for="categoria">Imóvel:</label> <br>
                <select id="categoria" name="min-bed" class="min-bed">
                    <option></option>
                </select>
            </li>
            <li class="s-2">
                <label for="finalidade">Finalidade:</label> <br>
                <select id="finalidade" name="property-type" class="property-type">
                    <option></option>
                </select>
            </li>            
            <li>
                <label for="cidade">Cidade:</label> <br>
                <select id="cidade" name="location" class="location">
                    <option></option>
                </select>	
            </li>
            <li>
                <label for="bairro">Bairro:</label> <br>
                <select id="bairro" name="location" class="location">
                    <option></option>
                </select>	
            </li>            
        </ul>
        <p>
            <span><a id="pesquisar" href="javascript:redirecionaPesquisaImovel();" class="search"><strong>Pesquisar</strong></a></span>
            <!--<span><a id="btnNaoEncontrei" href="javascript:void();" class="search"><strong>Não encontrei</strong></a></span>-->
        </p>
    </form>    
</div>