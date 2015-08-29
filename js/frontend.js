$(document).ready(function(){
    /*-- CARREGA ANUNCIOS --*/
    $('#btnPesquisar').click(function(){
        pesquisarImovel();
    });
    
    $('.btnSolicitarImovel').click(function(){
        $(window.document.location).attr('href',"index.php?action=solicitarimovel");
    });
    
    $('#btnIrParaMensagem').click(function(){
        $('#btnContatoAnuncio').focus();
        $('#nome').focus();
    });
    
    $('#ircontatoanunciante').click(function(){
        $('#nome').focus();
    });      
    
    /*-- TOPO PADRÃO --*/
    //carrega as categorias
    $('#uf').change(function(){
        $('#categoria').html('<option></option>');
        $('#finalidade').html('<option></option>');
        $('#cidade').html('<option></option>');
        $('#bairro').html('<option></option>');
        if ($('#uf').val() != '') {
            $('#categoria').html('<option>carregando...<option>');
            $.ajax({
                type: 'POST',                
                url: 'app/control/frontend/imovelGetCategoriasComAnuncio.php',
                data: {uf: $('#uf').val()},
                success: function(data) {
                    $('#categoria').html(data);
                    if ($('#categoria option').length == 1) {                        
                        carregarFinalidades();
                    } else {
                        $('#categoria').focus();
                    }                    
                },
                error: function() {
                    $('#categoria').html('<option><option>');
                    alert('Erro ao tentar carregar as categorias!');
                }
            });
        }        
    });
    //carrega as finalidades
    $('#categoria').change(function(){
        $('#finalidade').html('<option></option>');
        $('#cidade').html('<option></option>');
        $('#bairro').html('<option></option>');
        if ($('#categoria').val() != '' && $('#categoria').val() != '-1') {
            carregarFinalidades();            
        }
    });
    //carrega as cidades
    $('#finalidade').change(function(){        
        $('#cidade').html('<option></option>');
        $('#bairro').html('<option></option>');
        if ($('#finalidade').val() != '' && $('#finalidade').val() != '-1') {
            carregarCidade();
        }
    });
    //carrega os bairros
    $('#cidade').change(function(){
        $('#bairro').html('<option></option>');
        if ($('#cidade').val() != '' && $('#cidade').val() != '-1') {
            carregarBairro();
        }
    });
    
    /*- Newsletter -*/
    $('#btnNews').click(function(){
        $('#msgnews').html('');
        if ($.trim($('#nomeadd').val()) == '' || $.trim($('#nomeadd').val()) == 'Seu nome') {
            $('#msgnews').html('<span style="color:red; font-weight: bold;">(*) - Informe o seu nome!</span>');
            $('#nomeadd').focus();        
        } else if (!emailValido($('#emailadd').val())) {
            $('#msgnews').html('<span style="color:red; font-weight: bold;">(*) - E-mail inválido!</span>');
            $('#emailadd').focus();
        } else {
            $('#msgnews').html('<span style="font-weight:bold;color:blue;">Assinando, aguarde...</span>');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/frontend/newsLatterAssinar.php',
                data: {nome: $('#nomeadd').val(), email:$('#emailadd').val()},
                success: function(json) {
                    if (json.status == 'OK') {
                        $('#nomeadd').val('Seu nome');
                        $('#emailadd').val('Seu e-mail');
                        $('#msgnews').html('<span style="color:green; font-weight: bold;">News assinada com sucesso!</span>');
                    } else {
                        $('#msgnews').html('<span style="color:red; font-weight: bold;">Erro ao tentar assinar a newsletter!</span>');
                    }
                },
                error: function() {
                    $('#msgnews').html('<span style="color:red; font-weight: bold;">Erro ao tentar assinar a newsletter!</span>');
                }
            });
        }        
    });
    
    $('#btnContatoAnuncio').click(function() {
        if ($.trim($('#nome').val()) == '') {
            alert('Informe o seu nome!');
            $('#nome').focus();        
        } else if (!emailValido($('#email').val())) {
            alert('O e-mail informado é inválido!');
            $('#email').focus();
        } else if ($.trim($('#mensagem').val()) == '') {
            alert('Informe a mensagem!');
            $('#email').focus();
        } else {
            $('#btnContatoAnuncio').val('Enviando mensagem...');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/frontend/anuncioContatoEnviarMensagem.php',
                data: $('#frmContatoAnuncio').serialize(),
                success: function(json) {
                    if (json.status == 'OK') {
                        $('#btnContatoAnuncio').val('Enviar mensagem');
                        $('#nome').val('');
                        $('#telefone').val('');
                        $('#email').val('');
                        $('#mensagem').val('');
                        alert('OBRIGADO POR ENTRAR EM CONTATO.\n\nA sua mensagem foi enviado com sucesso, em breve o anunciante retornará o seu contato!');
                        $('#nome').focus();
                    } else {
                        $('#btnContatoAnuncio').val('Enviar mensagem');
                        alert('Falha ao tentar enviar a mensagem!');                        
                    }
                },
                error: function() {
                    $('#btnContatoAnuncio').val('Enviar mensagem');                    
                    alert('Erro ao tentar enviar a mensagem!');
                }
            });
        }
    });
    
    $('#btnEnviaMsgContato').click(function(){
        //$('#msgContato').html('');        
        if ($.trim($('#nome').val()) == '') {
            alert('Informe o seu nome!');
            $('#nome').focus();        
        } else if (!emailValido($('#email').val())) {
            alert('O e-mail informado é inválido!');
            $('#email').focus();
        } else if ($.trim($('#assunto').val()) == '') {
            alert('Informe a mensagem!');
            $('#assunto').focus();
        } else if ($.trim($('#comment').val()) == '') {
            alert('Informe a mensagem!');
            $('#comment').focus();
        } else {
            $('#btnEnviaMsgContato strong').html('Enviando mensagem...');
            if ($.trim($('#telefone').val()) == '') {
                $('#telefone').val('');
            }
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/frontend/siteContatoEnviarMensagem.php',
                data: $('#formContato').serialize(),
                success: function(json) {
                    if (json.status == 'OK') {                        
                        $('#btnEnviaMsgContato strong').html('Enviar mensagem');
                        $('#nome').val('');
                        $('#telefone').val('');
                        $('#email').val('');
                        $('#assunto').val('');
                        $('#comment').val('');
                        alert('Sua mensagem foi enviado com sucesso, em breve retornaremos o seu contato!');
                    } else {
                        $('#btnEnviaMsgContato strong').html('Enviar mensagem');
                        alert('Erro ao tentar enviar a mensagem!');
                    }
                },
                error: function() {
                    $('#btnEnviaMsgContato strong').html('Enviar mensagem');
                    alert('Erro ao tentar enviar a mensagem!');
                }
            });
        }
    });
    $('#btnSolicitar').click(function(){
        if ($.trim($('#nome').val()) == '') {
            alert('Informe o seu nome!');
            $('#nome').focus();        
        } else if (!emailValido($('#email').val())) {
            alert('O e-mail informado é inválido!');
            $('#email').focus();
        } else if ($.trim($('#cidade_').val()) == '') {
            alert('Informe a(s) cidade(s) de interesse!');
            $('#cidade_').focus();
        } else if ($.trim($('#uf_').val()) == '') {
            alert('Informe o(s) estado(s) de interesse!');
            $('#uf_').focus();
        } else if ($.trim($('#imovel').val()) == '') {
            alert('Informe o imóvel!');
            $('#imovel').focus();
        } else if ($.trim($('#finalidade_').val()) == '' || $.trim($('#finalidade_').val()) == 'F') {
            alert('Informe a finalidade!');
            $('#finalidade_').focus();
        } else if ($.trim($('#comment').val()) == '' || $.trim($('#comment').val()) == 'Descreva as características do imóvel') {
            alert('Informe as caracteristicas do imóvel!');
            $('#descricao').focus();
        } else {
            $('#btnSolicitar strong').html('Enviando solicitação...');
            if ($.trim($('#telefone').val()) == 'Telefone') {
                $('#telefone').val('');
            }
            if ($.trim($('#bairro').val()) == 'Bairro(s)') {
                $('#bairro').val('');
            }
            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/frontend/imovelSolicitadoSolicitar.php',
                data: $('#formSolicitarImovel').serialize(),
                success: function(json) {
                    if (json.status == 'OK') {                        
                        $('#btnSolicitar').val('Solicitar');
                        $('#nome').val('');
                        $('#telefone').val('');
                        $('#celular').val('');
                        $('#email').val('');
                        $('#cidade_').val('');
                        $('#bairro_').val('');
                        $('#uf_').val('');
                        $('#valorMin').val('');
                        $('#valorMax').val('');
                        $('#imovel').val('');
                        $('#finalidade_').val('');
                        $('#comment').val('');
                        $('#msg').html('<div class="alert green_alert"><p>Sua solicitação foi enviada com sucesso!</p></div>');
                        $('#btnSolicitar strong').html('Enviar solicitação');
                        alert('Sua solicitação foi enviada com sucesso!');
                        $('#nome').focus();
                    } else {
                        $('#btnSolicitar').val('Solicitar');
                        //$('#msg').html('<div class="alert red_alert"><p>Erro ao tentar enviar a solicitação!</p></div>');
                        alert('Erro ao tentar enviar a solicitação!');
                    }
                },
                error: function() {
                    $('#btnSolicitar').val('Solicitar');
                    //$('#msg').html('<div class="alert red_alert"><p>Erro ao tentar enviar a solicitação!</p></div>');
                    alert('Erro ao tentar enviar a solicitação!');
                }
            });
        }
    });
});

/* CARREGAR IMOVEIS */
function carregarAnunciosHome() {   
    $('.anuncio_destaque').html('');
    $('#anuncio_normal').html('');
    //$('#btnPesquisar strong').html('Pesquisando...');
    //$('#btnNaoEncontrei').hide();
    $('#btnMaisAnuncio').hide();
    $('.carregando').show();
    /*var ok = true, msg;
    
    if ($('#uf').val() == '' || $('#uf').val() == '-1') {
        ok = false;
        msg = 'Selecione o estado!';
    }
    
    if (ok && ($('#categoria').val() == '' || $('#categoria').val() == '-1')) {
        ok = false;
        msg = 'Selecione o tipo do imovel!';
    }
    
    if (ok && ($('#finalidade').val() == '' || $('#finalidade').val() == '-1')) {
        ok = false;
        msg = 'Selecione a finalidade!';
    }
    
    if (ok && ($('#cidade').val() == '' || $('#cidade').val() == '-1')) {
        ok = false;
        msg = 'Selecione a cidade!';
    }
    
    if (ok && ($('#bairro').val() == '' || $('#bairro').val() == '-1')) {
        ok = false;
        msg = 'Selecione o bairro!';
    }    
    
    if (ok) {
        alert('Em desenvolvimento!')
    } else {
        alert(msg)
    }*/ 
    
     $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/frontend/homePesquisarAnuncios.php',
        data: {uf: $('#uf').val(),
               categoria: $('#categoria').val(),
               finalidade: $('#finalidade').val(),
               cidade: $('#cidade').val(),
               bairro: $('#bairro').val()},
        success: function(json) {
            if (json.status == 'ok') {
                if (json.tem_anuncio_destaque == 'ok') {
                    $('.anuncio_destaque').html(json.anuncio_destaque);
                } else {
                    $('.anuncio_destaque').html(msgAlerta('Nenhum anuncio em destaque!'));
                }
                
                if (json.tem_anuncio_normal == 'ok') {
                    $('#anuncio_normal').html(json.anuncio_normal);
                } else {                    
                    $('#anuncio_normal').html(msgAlerta('Nenhum anuncio cadastrado!')); 
                }                                
            } else {
                $('.anuncio_destaque').html(msgErro('Erro ao tentar carregar os anuncios em destaque!'));
                $('#anuncio_normal').html(msgErro('Erro ao tentar carregar os anuncios!')); 
            }            
            $('.carregando').hide();
            //$('#btnPesquisar strong').html('Pesquisar');
            //$('#btnNaoEncontrei').show();
        },
        error: function() {
            $('.carregando').hide();
            //$('#btnPesquisar strong').html('Pesquisar');
            //$('#btnNaoEncontrei').show();
            $('.anuncio_destaque').html(msgErro('Erro ao tentar carregar os anuncios em destaque!'));
            $('#anuncio_normal').html(msgErro('Erro ao tentar carregar os anuncios!')); 
        }
    });
}

/* REDIRECIONA PARA A PAGINA DE PESQUISA */
function redirecionaPesquisaImovel() {
    $('#btnFiltros').hide();
    $('#pesquisar strong').html('Pesquisando...');    
    var parametros = ($('#uf').val() == '' || $('#uf').val() == '-1') ? '' : '&uf='+$('#uf').val();    
    parametros += ($('#categoria').val() == '' || $('#categoria').val() == '-1') ? '' : '&categoria='+$('#categoria').val();    
    parametros += ($('#finalidade').val() == '' || $('#finalidade').val() == '-1') ? '' : '&finalidade='+$('#finalidade').val();    
    parametros += ($('#cidade').val() == '' || $('#cidade').val() == '-1') ? '' : '&cidade='+$('#cidade').val();    
    parametros += ($('#bairro').val() == '' || $('#bairro').val() == '-1') ? '' : '&bairro='+$('#bairro').val();        
    $(window.document.location).attr('href','index.php?action=pesquisarimovel'+parametros);
}

/* PESQUISA OS ANUNCIOS EM DESTAQUE E OS NORMAIS DA HOME E PAGINA DE PESQUISA*/
function pesquisarImovel() {
    $('#btnNaoEncontrei').hide();
    $('#btnPesquisar').html('Pesquisando...');    
    
    var parametros = ($('#uf').val() == '' || $('#uf').val() == '-1') ? '' : '&uf='+$('#uf').val();    
    parametros += ($('#categoria').val() == '' || $('#categoria').val() == '-1') ? '' : '&categoria='+$('#categoria').val();    
    parametros += ($('#finalidade').val() == '' || $('#finalidade').val() == '-1') ? '' : '&finalidade='+$('#finalidade').val();    
    parametros += ($('#cidade').val() == '' || $('#cidade').val() == '-1') ? '' : '&cidade='+$('#cidade').val();    
    parametros += ($('#bairro').val() == '' || $('#bairro').val() == '-1') ? '' : '&bairro='+$('#bairro').val();        
    $(window.document.location).attr('href','index.php?action=pesquisarimovel'+parametros);
    
    //$('#anuncio_destaque').html('');
    //$('#anuncio_normal').html('');
    //$('.carregando').show();
    
    /*var ok = true, msg;
    
    if ($('#uf').val() == '' || $('#uf').val() == '-1') {
        ok = false;
        msg = 'Selecione o estado!';
    }
    
    if (ok && ($('#categoria').val() == '' || $('#categoria').val() == '-1')) {
        ok = false;
        msg = 'Selecione o tipo do imovel!';
    }
    
    if (ok && ($('#finalidade').val() == '' || $('#finalidade').val() == '-1')) {
        ok = false;
        msg = 'Selecione a finalidade!';
    }
    
    if (ok && ($('#cidade').val() == '' || $('#cidade').val() == '-1')) {
        ok = false;
        msg = 'Selecione a cidade!';
    }
    
    if (ok && ($('#bairro').val() == '' || $('#bairro').val() == '-1')) {
        ok = false;
        msg = 'Selecione o bairro!';
    }    
    
    if (ok) {
        alert('Em desenvolvimento!')
    } else {
        alert(msg)
    }*/ 
    
    /*$.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/frontend/pesquisarimoveis.php',
        data: {uf: $('#uf').val(),
               categoria: $('#categoria').val(),
               finalidade: $('#finalidade').val(),
               cidade: $('#cidade').val(),
               bairro: $('#bairro').val()},
        success: function(json) {
            if (json.status == 'ok') {
                if (json.tem_anuncio_destaque == 'ok') {
                    $('.anuncio_destaque').html(json.anuncio_destaque);
                } else {
                    $('.anuncio_destaque').html(msgAlerta('Nenhum anuncio em destaque!'));
                }
                
                if (json.tem_anuncio_normal == 'ok') {
                    $('#anuncio_normal').html(json.anuncio_normal);
                } else {                    
                    $('#anuncio_normal').html(msgAlerta('Nenhum anuncio cadastrado!')); 
                }                                
            } else {
                $('.anuncio_destaque').html(msgErro('Erro ao tentar carregar os anuncios em destaque!'));
                $('#anuncio_normal').html(msgErro('Erro ao tentar carregar os anuncios!')); 
            }            
            $('.carregando').hide();
            $('#btnPesquisar strong').html('Pesquisar');
            $('#btnNaoEncontrei').show();
        },
        error: function() {
            $('.carregando').hide();
            $('#btnPesquisar strong').html('Pesquisar');
            $('#btnNaoEncontrei').show();
            $('.anuncio_destaque').html(msgErro('Erro ao tentar carregar os anuncios em destaque!'));
            $('#anuncio_normal').html(msgErro('Erro ao tentar carregar os anuncios!')); 
        }
    });*/
}

function carregarFinalidades() {    
    $('#finalidade').html('<option>carregando...<option>');
    $.ajax({
        type: 'POST',
        url: 'app/control/frontend/imovelGetTipoAnuncioComAnuncio.php',
        data: {uf: $('#uf').val(),
               categoria: $('#categoria').val()},
        success: function(data) {
            $('#finalidade').html(data);
            if ($('#finalidade option').length == 1) {
                carregarCidade();
            } else {
                $('#finalidade').focus();
            }            
        },
        error: function() {
            $('#finalidade').html('<option><option>');
            alert('Erro ao tentar carregar as finalidades!');
        }
    });
}

function carregarCidade() {    
    $('#cidade').html('<option>carregando...<option>');
    $.ajax({
        type: 'POST',
        url: 'app/control/frontend/imovelGetCidadeComAnuncio.php',
        data: {uf: $('#uf').val(),
               categoria: $('#categoria').val(),
               finalidade: $('#finalidade').val()},
        success: function(data) {
            $('#cidade').html(data);
            if ($('#cidade option').length == 1) {
                carregarBairro();
            } else {
                $('#cidade').focus();
            }            
        },
        error: function() {
            $('#cidade').html('');
            alert('Erro ao tentar carregar as cidades!');
        }
    });
}

function carregarBairro() {
    $('#bairro').html('<option>carregando...<option>');
    $.ajax({
        type: 'POST',
        url: 'app/control/frontend/imovelGetBairroComAnuncio.php',
        data: {uf: $('#uf').val(),
               categoria: $('#categoria').val(),
               finalidade: $('#finalidade').val(),
               cidade: $('#cidade').val()},
        success: function(data) {
            $('#bairro').html(data);
            $('#bairro').focus();
        },
        error: function() {
            $('#cidade').html('');
            alert('Erro ao tentar carregar as cidades!');
        }
    });
}

function carregarValores() {
    alert('em desenvolvimento!')
}

function homeMaisAnuncios() {
    $('.carregando').show();
}
