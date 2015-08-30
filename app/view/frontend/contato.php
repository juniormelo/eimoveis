<?php include_once 'app/view/frontend/topopadrao.php'; ?>
<div class="container contents single">
        <div class="row">
            <div class="span9 main-wrap">
                <!-- Main Content -->
                <div class="main">
                    <div class="inner-wrapper" style="min-height: 673px">
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
                                <div class="row">                               
                                    <div class="span4 main-wrap">
                                        <p>
                                            <label for="nome"><strong>Nome:</strong></label>
                                            <input type="text" id="nome" name="nome" style="width: 90%" class="" placeholder="Por favor, informe seu nome">
                                        </p>
                                    </div>
                                    <div  class="span4 main-wrap">
                                        <p>
                                            <label for="telefone"><strong>Telefone:</strong></label>
                                            <input type="text" id="telefone" name="telefone" style="width: 90%" class="telefone" placeholder="Por favor, informe seu telefone">
                                        </p>
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="span4 main-wrap">
                                        <p>
                                            <label for="email"><strong>E-mail:</strong></label>
                                            <input type="text" id="email" name="email" style="width: 90%" class="email " placeholder="Por favor, informe um endereço de email válido">
                                        </p>
                                    </div>
                                    <div class="span4 main-wrap">
                                        <p>
                                            <label for="assunto"><strong>Assunto:</strong></label>
                                            <input type="text" name="assunto" style="width: 90%" id="assunto" class="" placeholder="Por favor, informe o assunto">
                                        </p>
                                    </div>
                                </div>
                                <div class="row">  
                                    <div class="span8">
                                        <p>
                                            <label for="comment"><strong>Mensagem:</strong></label>                                    
                                            <textarea name="mensagem" style="width: 95%;min-height: 200px" id="comment" class="" rows="12" cols="25" placeholder="Por favor, informe a sua mensagem"></textarea>
                                        </p>
                                    </div>
                                </div>
                                
                                <div>
                                    <span><a id="btnEnviaMsgContato" class="btn-blue btn"><strong>Enviar mensagem</strong></a></span>                                    
                                </div>
                                
                            </form>
                        </section>

                    </div>
                </div><!-- End Main Content -->

            </div> <!-- End span9 -->

            <?php include_once 'app/view/frontend/formpesquisalateral.php'; ?>

        </div><!-- End contents row -->

    </div><!-- End Content -->
