<?php include_once 'app/view/frontend/topopadrao.php'; ?>
<div class="container contents single">
        <div class="row">
            <div class="span9 main-wrap">
                <!-- Main Content -->
                <div class="main">
                    <div class="inner-wrapper">
                        <article id="post-122" class="post-122 page type-page status-publish hentry clearfix">
                        </article>
                        
                        <!--<section class="contact-details clearfix">
                            <h3>E-Imóveis Brasil</h3>
                            <address><strong>Avenida Ayrton Senna, Nova Parnamirim,<br>Parnamirim/RN, Brasil.</strong></address>
                            <ul class="contacts-list">
                                <li class="phone"> <strong>Telefone:</strong> (84) 3231-4748</li>
                                <li class="mobile"> <strong>Celular:</strong> (84) 8845-9865</li>
                                <li class="email"> <strong>E-mail:</strong> contato@eimoveisbrasil.com.br</li>
                            </ul>
                        </section>-->
                        
                        <article class="page type-page clearfix">
                            <h2 class="post-title">Entre em contato conosco</h2>                           
                            <hr />                        
                            <p></p> 
                        </article>
                        
                        <section id="contact-form">
                            <!--<h3 class="form-heading">Entre em contato conosco</h3>-->
                            <form  action="javascript:void(0);" id="formContato">
                                                               
                                <p>
                                    <label for="nome"><strong>Nome:</strong></label>
                                    <input type="text" id="nome" name="nome" class="" placeholder="Por favor, informe seu nome">
                                </p>
                                
                                <p>
                                    <label for="telefone"><strong>Telefone:</strong></label>
                                    <input type="text" id="telefone" name="telefone" class="telefone" placeholder="Por favor, informe seu telefone">
                                </p>

                                <p>
                                    <label for="email"><strong>E-mail:</strong></label>
                                    <input type="text" id="email" name="email" class="email " placeholder="Por favor, informe um endereço de email válido">
                                </p>

                                <p>
                                    <label for="assunto"><strong>Assunto:</strong></label>
                                    <input type="text" name="assunto" id="assunto" class="" placeholder="Por favor, informe o assunto">
                                </p>

                                <p>
                                    <label for="comment"><strong>Mensagem:</strong></label>                                    
                                    <textarea name="mensagem" id="comment" class="" rows="10" cols="15" placeholder="Por favor, informe a sua mensagem"></textarea>
                                </p>
                                
                                <p>
                                    <span><a id="btnEnviaMsgContato" class="btn-blue btn"><strong>Enviar mensagem</strong></a></span>                                    
                                </p>
                                
                            </form>
                        </section>

                    </div>
                </div><!-- End Main Content -->

            </div> <!-- End span9 -->

            <?php include_once 'app/view/frontend/formpesquisalateral.php'; ?>

        </div><!-- End contents row -->

    </div><!-- End Content -->