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
            <h4 class="title search-heading">Find Your Home<i class="icon-search"></i></h4>
            <div class="as-form-wrap">
                <form class="advance-search-form clearfix" action="#" method="get">

                    <div class="option-bar">
                        <label>Location</label>
            <span class="selectwrap">
                            <select name="location" id="select-location" class="search-select">
                                                                            <option value="any" selected="selected">Any</option>
                                <option value="miami">Miami</option>
                                <option value="newyork">New York</option>
                            </select>
                        </span>
                    </div>

                    <div class="option-bar">
                        <label>Status</label>
            <span class="selectwrap">
                <select name="status" id="select-status" class="search-select">
                    <option value="on-rent">On Rent</option>
                    <option value="on-sale">On Sale</option>
                    <option value="any" selected="selected">Any</option>
                </select>
            </span>
                    </div>

                    <div class="option-bar">
                        <label>Property Type</label>
            <span class="selectwrap">
                <select name="type" id="select-property-type" class="search-select">
                    <option value="condominium">Condominium</option>
                    <option value="single-family-home">Single Family Home</option>
                    <option value="villa">Villa</option>
                    <option value="any" selected="selected">Any</option>
                </select>
            </span>
                    </div>

                    <div class="option-bar mini first">
                        <label>Bedrooms</label>
            <span class="selectwrap">
                <select name="bedrooms" id="select-bedrooms" class="search-select">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="any" selected="selected">Any</option>
                </select>
            </span>
                    </div>

                    <div class="option-bar mini">
                        <label>Bathrooms</label>
            <span class="selectwrap">
                <select name="bathrooms" id="select-bathrooms" class="search-select">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="any" selected="selected">Any</option>
                </select>
            </span>
                    </div>

                    <div class="option-bar mini first">
                        <label>Min Price</label>
            <span class="selectwrap">
                <select name="min-price" id="select-min-price" class="search-select">
                    <option value="50000">$50,000</option>
                    <option value="100000">$100,000</option>
                    <option value="200000">$200,000</option>
                    <option value="300000">$300,000</option>
                    <option value="400000">$400,000</option>
                    <option value="500000">$500,000</option>
                    <option value="600000">$600,000</option>
                    <option value="700000">$700,000</option>
                    <option value="800000">$800,000</option>
                    <option value="900000">$900,000</option>
                    <option value="1000000">$1,000,000</option>
                    <option value="any" selected="selected">Any</option>
                </select>
            </span>
                    </div>

                    <div class="option-bar mini">
                        <label>Max Price</label>
            <span class="selectwrap">
                <select name="max-price" id="select-max-price" class="search-select">
                    <option value="100000">$100,000</option>
                    <option value="200000">$200,000</option>
                    <option value="300000">$300,000</option>
                    <option value="400000">$400,000</option>
                    <option value="500000">$500,000</option>
                    <option value="600000">$600,000</option>
                    <option value="700000">$700,000</option>
                    <option value="800000">$800,000</option>
                    <option value="900000">$900,000</option>
                    <option value="1000000">$1,000,000</option>
                    <option value="any" selected="selected">Any</option>
                </select>
            </span>
                    </div>

                    <!--<input type="submit" value="Search" class=" real-btn btn">-->
                    <span><a id="pesquisar" href="javascript:redirecionaPesquisaImovel();" class="real-btn btn"><strong>Pesquisar</strong></a></span>
                    <span><a id="pesquisar" href="javascript:redirecionaPesquisaImovel();" class="real-btn btn"><strong>+ Filtros</strong></a></span>
                </form>
            </div>
        </section>        
           
    </aside><!-- End Sidebar -->
</div>