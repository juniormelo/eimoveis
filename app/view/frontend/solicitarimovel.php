<?php include_once 'app/view/frontend/topopadrao.php'; ?>
<div class="container contents single">
        <div class="row">
            <div class="span9 main-wrap">
                <!-- Main Content -->
                <div class="main">
                    <div class="inner-wrapper">
                        <article id="post-122" class="post-122 page type-page status-publish hentry clearfix">
                        </article>
                        
                        <section class="contact-details clearfix">
                            <h2><strong>Solicite agora mesmo um imóvel de sua preferência.</strong></h2>
                            <h5>Nossos parceiros serão acionados e poderão entrar em contato com você.</h5>
                        </section>                        
                        
                        <section id="contact-form"> 
                            
                            <h3 class="form-heading">Descreva um imóvel de acordo com as suas necessidades</h3>
                            <form  action="javascript:void(0);" id="formSolicitarImovel" class="form-horizontal" role="form">
                                <p>
                                    <label for="nome"><strong>Seu nome:</strong></label>
                                    <input type="text" id="nome" name="nome" class="" placeholder="Por favor, informe seu nome">
                                </p>
                                
                                <p>
                                    <label for="telefone"><strong>Telefone fixo:</strong></label>
                                    <input type="text" id="telefone" name="telefone" class="telefone" placeholder="Por favor, informe um telefone fixo">
                                </p>
                                
                                <p>
                                    <label for="celular"><strong>Telefone móvel:</strong></label>
                                        <input type="text" id="celular" name="celular" class="telefone" placeholder="Por favor, informe um telefone móvel">
                                </p>

                                <p>
                                    <label for="email"><strong>E-mail:</strong></label>
                                    <input type="text" id="email" name="email" class="email " placeholder="Por favor, informe um endereço de email válido">
                                </p>
                                
                                <p>
                                    <label for="cidade"><strong>Cidade(s) de interesse:</strong></label>
                                    <input type="text" id="cidade_" name="cidade_" class="" placeholder="Informe a(s) cidade(s) de sua preferência">
                                </p>
                                
                                <p>
                                    <label for="bairro"><strong>Bairro(s) de interesse:</strong></label>
                                    <input type="text" id="bairro_" name="bairro_" class="" placeholder="Informe o(s) bairro(s) de sua preferência">
                                </p>
                                
                                <p>
                                    <label for="uf"><strong>Estado(s) de interesse:</strong></label>
                                    <input type="text" id="uf_" name="uf_" class="" placeholder="Informe o(s) estado(s) de sua preferência">
                                </p>
                                
                                <p> 
                                    <label for="finalidade"><strong>O que deseja:</strong></label>
                                    <select id="finalidade_" name="finalidade_">
                                        <option value="">-- Selecione uma opção --</option>
                                        <option value="A">Alugar</option>
                                        <option value="AC">Alugar ou Comprar</option>
                                        <option value="C">Comprar</option>
                                        <option value="T">Temporada</option>
                                    </select>
                                </p>
                                
                                <p>
                                    <label for="imovel"><strong>Tipos de imóveis que procura:</strong></label>
                                    <input type="text" id="imovel" name="imovel" class="" placeholder="Casa, apartamento, terreno etc.">
                                </p>
                                
                                <p>
                                    <label for="uf"><strong>Se quiser pode informar uma faixa de preço:</strong></label>
                                    <input type="text" id="valorMin" name="valorMin" class="decimal" placeholder="Preço mínimo"> à&nbsp;
                                    <input type="text" id="valorMax" name="valorMax" class="decimal" placeholder="Preço máximo">
                                </p>
                                
                                <p>
                                    <label for="comment"><strong>É importante especificar as caracteristicas do imóvel procurado:</strong></label>                                    
                                    <textarea name="descricao" id="comment" class="" rows="10" cols="15" placeholder="Especifique aqui mais caracteristica sobre o imóvel que está procurando..."></textarea>
                                </p>
                                
                                <p>
                                    <span><a id="btnSolicitar" class="btn-blue btn"><strong>Enviar solicitação</strong></a></span>                                    
                                </p>
                                
                            </form>
                        </section>

                    </div>
                </div><!-- End Main Content -->

            </div> <!-- End span9 -->

            <?php include_once 'app/view/frontend/formpesquisalateral.php'; ?>

        </div><!-- End contents row -->

    </div><!-- End Content -->