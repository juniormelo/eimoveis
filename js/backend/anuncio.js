$(document).ready(function(){
    aplicaEstiloTagFile();
    
    if ($('#txtConsulta').length) {
        $('#txtConsulta').focus();
    }

    if ($('#codigo').length) {
        $('#codigo').focus();
    }
    
    if ($('#idTipo').length) {
        $('#idTipo').focus();
    }
        
    $('#btnNovo').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=anunciocad");
    });
    
    $('#btnLista').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=anunciolista");
    });

    if ($('#btnConsultar').length) {
        $('#btnConsultar').click(function(){            
            $('.carregando').show();
            $('#tblAnuncio').hide();
            $('#registros').hide();
            $('#registros').html('');
            $('#tblAnuncio tbody').html(''); 
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/anuncioConsultar.php',
                data: {consulta: $('#txtConsulta').val()},
                success: function(json) {
                    var i = 0, seq = 0, str_html = '';
                    if (json == null) {
                        str_html = '<tr><td colspan="8" align="center"><strong><i>Erro ao tentar exibir os anúncios!</i></strong></td></tr>';
                    } else {
                        if (json.status == 'OK') { //tem dados
                            for (i in json.resultados) {
                                seq++;                                
                                str_html = str_html + '<tr id="'+json.resultados[i].idAnuncio+'"><td>'+seq+'</td><td>'+json.resultados[i].codigo+'</td><td>'+json.resultados[i].finalidade+'</td><td>'+json.resultados[i].titulo+'</td><td>'+json.resultados[i].qtdVisita+'</td><td>'+json.resultados[i].status+'</td>';                                
                                str_html = str_html + '<td>';
                                str_html = str_html + '<a href="javascript:visualizar('+json.resultados[i].idAnuncio+')" class="btn btn-xs btn-info" title="Visualizar"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>';
                                if (json.resultados[i].status.toLowerCase() != 'cancelado') {                                    
                                    str_html = str_html + '&nbsp;&nbsp;<a href="javascript:alterarStatus('+json.resultados[i].idAnuncio+')" class="btn btn-xs btn-warning" title="Ativar/Inativar"><i class="glyphicon glyphicon-refresh"></i></a>';
                                    str_html = str_html + '&nbsp;&nbsp;<a href="?action=anunciocad&idanuncio='+json.resultados[i].idAnuncio+'" class="btn btn-xs btn-success" title="Editar"><i class="ace-icon fa fa-pencil bigger-130"></i></a>';
                                    str_html = str_html + '&nbsp;&nbsp;<a href="javascript:cancelar('+json.resultados[i].idAnuncio+')" class="btn btn-xs btn-danger" title="Cancelar"><i class="glyphicon glyphicon-remove"></i></a>';
                                }
                                str_html = str_html + '</td></tr>';
                            }
                        } else {
                            if (json.status == 'NO') { //vazio
                                str_html = '<tr><td colspan="8" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                            } else {
                                str_html = '<tr><td colspan="8" align="center"><strong><i>Erro ao tentar exibir os anúncios!</i></strong></td></tr>';
                            }
                        }
                    }
                    $('#registros').html(seq+' registro(s) encontrado(s).');
                    $('#tblAnuncio tbody').html(str_html);
                    $('#registros').show();
                    $('#tblAnuncio').show();
                    $('.carregando').hide();
                },
                error: function() {
                    $('#registros').html('0 registro(s) encontrado(s).');
                    $('#tblAnuncio tbody').html('<tr><td colspan="8" align="center"><strong><i>Erro ao tentar exibir os anúncios!</i></strong></td></tr>');
                    $('.carregando').hide();  
                }
            });
        }).click();
    }
    
    $('#idImovel').change(function(){
        $('#telefone1').val('');
        $('#telefone2').val('');
        $('#email').val('');
        $('#responsavel').val('');
        $('#titulo').val('');
        $('#msgimagem').hide();
        $('#tblImagens tbody').html('');
        if ($('#idImovel').val() > 0) {
            $('#linkinfoimovel').show();
            $('#telefone1').val('Carregando...');
            $('#telefone2').val('Carregando...');
            $('#email').val('Carregando...');
            $('#responsavel').val('Carregando...');
            $('#titulo').val('Carregando...');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/anuncioGetInfoComplementares.php',
                data: {idImovel: $('#idImovel').val()},
                success: function(json) {
                    if (json.status == 'OK') {
                        $('#telefone1').val(json.resultados[0].telefone1);
                        $('#telefone2').val(json.resultados[0].telefone2);
                        $('#email').val(json.resultados[0].email);
                        $('#responsavel').val(json.resultados[0].responsavel);
                        $('#titulo').val(json.resultados[0].titulo);
                        exibirImagens(json.resultados);
                    } else {
                        $('#telefone1').val('');
                        $('#telefone2').val('');
                        $('#email').val('');
                        $('#responsavel').val('');
                        $('#titulo').val('');
                        alert('Não foi possivel carregar as informação complementares!');
                    }
                },
                error: function() {
                    $('#telefone1').val('');
                    $('#telefone2').val('');
                    $('#email').val('');
                    $('#responsavel').val('');
                    $('#titulo').val('');
                    alert('Não foi possivel carregar as informação complementares!');
                }
            });
        } else {
            $('#linkinfoimovel').hide();
        }
    });
    
    $('#btnAnunciar').click(function(){
        var ok = camposPreenchidos();        
        /*if (ok) {
            if ($('#cpf_cnpj').val() != '') {
                if (!cpf_cnpj_valido($('#cpf_cnpj').val())) {
                    if ($("#fisica").is(':checked')) {
                        alert('O CPF informado é inválido!');
                    } else {
                        alert('O CNPJ informado é inválido!');
                    }                    
                    $('#cpf_cnpj').focus();
                    ok = false;
                }                
            }
        }
        if (ok) {
            if ($('#dtNascimento').val() != '') {
                if (!dataValida($('#dtNascimento').val())) {
                    alert('A data informada é inválida!');
                    $('#dtNascimento').focus();
                    ok = false;
                }
            }
        }
        if (ok) {
            if ($('#email').val() != '') {
                if (!emailValido($('#email').val())) {
                    alert('O e-mail informado é inválido!');
                    $('#email').focus();
                    ok = false;
                }
            }
        }*/
        if (ok) {
            aguarde('Salvando...');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/anuncioGravar.php',
                data: $('#frmAnunciar').serialize(),
                success: function(json) {                   
                    aguarde(false);
                    if (json.status == 'OK') {
                        $('#idAnuncio').val(json.idAnuncio);
                        if ($('#idAnuncio').length) {
                            alert('Anúncio atualizado com sucesso!');
                        } else {
                            alert('Anúncio realizado com sucesso!');
                        }                        
                    } else {
                        alert('Erro ao tentar gerar o anúncio!');
                    }                    
                },
                error: function() {
                    aguarde(false);
                    alert('Erro ao tentar gerar o anúncio!');
                }
            });
        }  
    });    
    
    $('#btnAddImg').click(function() {
                         
        if ($('#tblImagens tbody tr').length == 1 && $('#tblImagens tbody tr td').length == 1) {
            $('#tblImagens tbody').html('');            
        }
        $('#tblImagens tbody').append('<tr><td width="1%"><input type="hidden" name="codImg[]" value="0" /><input type="hidden" name="nomeImg[]" value="i_img_nv" /><input type="text" name="ordemImg[]" value="1" class="input-mini"/></td><td width="10%"><input type="file" name="img[]" id="id-input-file-2" /></td><td width="15%"><input type="text" name="descImg[]" class="width-100"/></td><td width="1%"><a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>');
        
        aplicaEstiloTagFile();              
    });
    
    $('#tblImagens').on("click", ".btn-danger",function(){
        if (confirm("Deseja realmente remover a imagem do anuncio?")) {
            $(this).parent().parent().remove();
            if ($('#tblImagens tbody tr').length == 0) {
                $('#tblImagens tbody').html('<tr><td colspan="4" align="center"><strong><i>Nenhuma imagem adicionada!</i></strong></td></tr>');
            }
        }
    });
    
    $('#btnAvancar').click(function() {
        //VALIDANDO A ETAPA 1
        if ($('#idTipo').val() < 1) {
            alert('Selecione a finalidade do anúncio!');
            $('#idTipo').focus();
            abort();
        } else if ($('#idImovel').val() < 1) {
            alert('Selecione o imóvel que deseja anunciar!');
            $('#idImovel').focus();
            abort();
        } 
        
        if ($.trim($('#valor').val()) == '') {
            if (!confirm('O valor do anúncio não foi informado deseja continuar?')) {
                abort();
            }
            $('#valor').val('0,00');
        }
        
        //VALIDANDO A ETAPA 2
        if( $('#step2').is(':visible') ) {
            if (($('#tblImagens tbody tr').length == 1) && ($('#tblImagens tbody tr td').length == 1)) {
                if (!confirm('Nenhuma imagem foi adicionada ao anúncios, deseja prosseguir?')) {
                    abort();
                }
            }
        }
        
        ////VALIDANDO A ETAPA 3
        if( $('#step3').is(':visible') ) {
            if (($.trim($('#telefone1').val()) == '') && ($.trim($('#telefone2').val()) == '')) {
                alert('Informe pelo menos um telefone para contato!');
                $('#telefone1').focus();
                abort();
            }
        }
        
        ////SUBMETE O FORMULARIO
        if( $('#step4').is(':visible') ) {
             $('#frmAnunciar').submit();
        }
    });
});

function close() {
    $("#fundo").fadeOut(300);
}

function criar() {    
    $("#fundo").fadeIn(300);    
}

function exibirInfoImovel() {    
    if ($('#idImovel').val() == 0 || $('#idImovel').val() == '') {
        $('#idImovel').focus();
        alert('É necesário selecionar um imóvel!');
    } else {
        aguarde();
        $('#infoimovel').html('');
        $('#modal-info-imovel').modal('show');
        $('.carregando').show();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/imovelGetInfoCadastrais.php',
            data: {idImovel: $('#idImovel').val()},
            success: function(json) {
                if (json == null) {
                    alert('Erro ao tentar exibir as informações do imóvel!');
                } else if (json.status == 'OK') {                   
                    $('#infoimovel').html('<table class="table table-striped table-bordered table-hover"><tr><td><strong>Código:</strong></td><td>'+json.resultados[0].codigo+'</td></tr><tr><td><strong>Categoria:</strong></td><td>'+json.resultados[0].categoria+'</td></tr><tr><td><strong>Descrição:</strong></td><td>'+json.resultados[0].descricao+'</td></tr><tr><td><strong>Area:</strong></td><td>'+json.resultados[0].area+' m2</td></tr><tr><td><strong>Endereço:</strong></td><td>'+json.resultados[0].logradouro+','+json.resultados[0].numLogradouro+', '+json.resultados[0].bairro+' - '+json.resultados[0].cidade+' / '+json.resultados[0].uf+' - '+json.resultados[0].pais+'</td></tr><tr><td><strong>Proprietario:</strong></td><td>'+json.resultados[0].razao+'</td></tr></table>');
                } else if (json.status == 'NO') {                
                    alert('Informações não localizadas!');
                } else {
                    alert('Erro ao tentar exibir as informações do imóvel!');
                }
                aguarde(false);
                $('.carregando').hide();
            },
            error: function() {
                aguarde(false);
                $('.carregando').hide();
                alert('Erro ao tentar exibir as informações do imóvel!');
            }
        });
    }
}

function excluir(codigo) {
    if (confirm('Deseja realmente excluir o anúncio?')) {
        aguarde();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/anuncioExcluir.php',            
            data: {idAnuncio: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblAnuncio tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblAnuncio tbody tr').length == 0) {
                        $('#tblAnuncio tbody').html('<tr><td colspan="7" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Anúncio excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir o anúncio!');
                }
            },
            error: function() {
                aguarde(false);
                alert('Erro ao tentar excluir o anúncio!');
            }
        });
    }
}

function cancelar(codigo) {
    if (confirm('Deseja realmente cancelar o anúncio?')) {
        aguarde();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/anuncioCancelar.php',            
            data: {idAnuncio: codigo},
            success: function(json) {
                aguarde(false);
                $('#'+codigo).children("td:nth-child(6)").html('<span class="badge badge-danger">Cancelado</span>');
                /*if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblAnuncio tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblAnuncio tbody tr').length == 0) {
                        $('#tblAnuncio tbody').html('<tr><td colspan="7" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Anúncio cancelado com sucesso!');
                } else {
                    alert('Erro ao tentar cancelar o anúncio!');
                }*/
            },
            error: function() {
                aguarde(false);
                alert('Erro ao tentar cancelar o anúncio!');
            }
        });
    }
}

function visualizar(codigo) {
    aguarde();
    $('#tblInfoAnuncio tbody').html('');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/anuncioGetInfoCadastrais.php',
        data: {idAnuncio: codigo},
        success: function(json) {
            if (json == null) {
                alert('Erro ao tentar exibir as informações do anúncio!');
            } else if (json.status == 'OK') {                                
                $('#tblInfoAnuncio tbody').html(
                    '<tr><td><strong>Código:</strong></td><td>'+json.resultados[0].codigo+'</td></tr>'+
                    '<tr><td><strong>Finalidade:</strong></td><td>'+json.resultados[0].tipo+'</td></tr>'+
                    '<tr><td><strong>Status:</strong></td><td>'+json.resultados[0].status+'</td></tr>'+
                    '<tr><td><strong>Num. Visitas:</strong></td><td>'+json.resultados[0].qtdVisita+'</td></tr>'+
                    '<tr><td><strong>Imovel:</strong></td><td>'+json.resultados[0].imovel+'</td></tr>'+
                    '<tr><td><strong>Titulo:</strong></td><td>'+json.resultados[0].titulo+'</td></tr>'+
                    '<tr><td><strong>Valor:</strong></td><td>R$ '+json.resultados[0].valor+'</td></tr>'+
                    '<tr><td><strong>Descricao:</strong></td><td>'+json.resultados[0].descricao+'</td></tr>'+
                    '<tr><td><strong>Telefone 1:</strong></td><td>'+json.resultados[0].telefone1+'</td></tr>'+
                    '<tr><td><strong>telefone 2:</strong></td><td>'+json.resultados[0].telefone2+'</td></tr>'+
                    '<tr><td><strong>E-mail:</strong></td><td>'+json.resultados[0].email+'</td></tr>'+
                    '<tr><td><strong>Reponsável:</strong></td><td>'+json.resultados[0].responsavel+'</td></tr>'+
                    '<tr><td><strong>Data Inicio:</strong></td><td>'+json.resultados[0].dataIni+'</td></tr>'+
                    '<tr><td><strong>Data Fim:</strong></td><td>'+json.resultados[0].dataFim+'</td></tr>'+
                    '<tr><td><strong>Posição:</strong></td><td>'+json.resultados[0].posicao+'</td></tr>'+
                    '<tr><td><strong>Exibir Mapa:</strong></td><td>'+json.resultados[0].exibirMapa+'</td></tr>'+
                    '<tr><td><strong>Cadastrado por:</strong></td><td>'+json.resultados[0].usuarioCad+'</td></tr>'+
                    '<tr><td><strong>Data Cadastro:</strong></td><td>'+json.resultados[0].dataCadastro+'</td></tr>'+
                    '<tr><td><strong>Alterado por:</strong></td><td>'+json.resultados[0].usuarioAlt+'</td></tr>'+
                    '<tr><td><strong>Ultima Alteração:</strong></td><td>'+json.resultados[0].dataAlteracao+'</td></tr>'
                );
                criar();
            } else if (json.status == 'NO') {                
                alert('Informações não localizadas!');
            } else {
                alert('Erro ao tentar exibir as informações do anúncio!');
            }
            aguarde(false);
        },
        error: function() {
            aguarde(false);
            alert('Erro ao tentar exibir as informações do anúncio!');
        }
    });
}

function alterarStatus(codigo) {
    var pStatus = $('#'+codigo).children("td:nth-child(6)").html();    
    if (pStatus != 'Ativo' && pStatus != 'Inativo') {
        alert('O status não pode ser modificado!')
    } else {
        aguarde('Alterando status...');
        $('#'+codigo).children("td:nth-child(6)").html('<b><i>Alterando...</i></b>'); 
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/anuncioAlterarStatus.php',
            data: {idAnuncio: codigo, status: pStatus},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    if (pStatus == 'Ativo') {
                        $('#'+codigo).children("td:nth-child(6)").html('Inativo');                                  
                    } else {
                        $('#'+codigo).children("td:nth-child(6)").html('Ativo');
                    }                       
                } else {
                    $('#'+codigo).children("td:nth-child(6)").html(pStatus);
                    alert('Erro ao tentar alterar o status do anúncio!');
                }
            },
            error: function() {
                $('#'+codigo).children("td:nth-child(6)").html(pStatus);
                aguarde(false);
                alert('Erro ao tentar alterar o status do anúncio!');
            }
        });
    }
}

function exibirImagens(imagens) {
    var i = 0, html = '';
    for (i in imagens) {        
        html = html + '<tr>';        
        html = html + '<td width="1%">';
        html = html + '<input type="hidden" name="codImgCad[]" value="'+imagens[i].idFoto+'" />';
        html = html + '<input type="hidden" name="nomeImgCad[]" value="'+imagens[i].foto+'" />';
        html = html + '<input type="text" name="ordemImgCad[]" value="'+imagens[i].ordem+'" class="input-mini" />';
        html = html + '</td>';        
        html = html + '<td width="10%" style="text-align: center;">';
        html = html + '<img src="images/upload/'+imagens[i].foto+'" width="125" height="100" />';
        html = html + '</td>';        
        html = html + '<td width="15%">';
        html = html + '<input type="text" name="descImgCad[]" value="'+imagens[i].descricao+'" class="width-100"/>';
        html = html + '</td>';        
        html = html + '<td width="1%">';
        html = html + '<a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>';
        html = html + '</td>';        
        html = html + '</tr>';                       
    }
    
    if ($.trim(html) !== '') {        
        $('#msgimagem').show();
        $('#tblImagens tbody').html(html);
        $('#btnAddImg').click();    
        aplicaEstiloTagFile();
    }               
}


