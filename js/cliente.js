$(document).ready(function() {    
    
    if ($('#txtConsulta').length) {
        $('#txtConsulta').focus();
    }
    
    $('#btnNovo').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=clientecad");
    });
    
    $('#btnLista').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=clientelista");
    });        

    $('#btnSalvar').click(function() {
        var ok = camposPreenchidos();
        
        if (ok) {
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
        }
        
        if (ok) {
            //aguarde();
            $('#btnSalvar strong').html('Salvando...');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/clienteGravar.php',
                data: $('#fmCadCliente').serialize(),
                success: function(json) {                   
                    $('#btnSalvar strong').html('Salvar');
                    if (json.status == 'OK') {
                        $('#idPessoa').val(json.idPessoa);
                        alert('Cliente salvo com sucesso!');
                    } else {
                        alert('Erro ao tentar salvar o cliente!');
                    }                    
                },
                error: function() {
                    $('#btnSalvar strong').html('Salvar');
                    alert('Erro ao tentar salvar o cliente!');
                }
            });
        }                   
    });
    
    /*$('#btnAddImg').click(function() {
        if ($('#tblImagens tbody tr').length == 1 && $('#tblImagens tbody tr td').length == 1) {
            $('#tblImagens tbody').html('');            
        }
        $('#tblImagens').append('<tr><td width="10"><input type="text" name="ordemImg[]" value="1" /></td><td width="280"><input type="file" name="img[]" /></td><td width="280"><input type="text" name="descImg[]" /></td><td><img style="cursor: pointer;" src="images/delete.png" title="Excluir"/></td></tr>');
    });*/
    
    /*$('#tblImagens img').live('click',function(){
        if (confirm("Deseja realmente excluir a imagem?")) {
            $(this).parent().parent().remove();
            if ($('#tblImagens tbody tr').length == 0) {
                $('#tblImagens tbody').html('<tr><td colspan="4" align="center"><strong><i>Nenhuma imagem cadastrada!</i></strong></td></tr>');
            }
        }
    });*/
    
    /*$('#tblCaracteristicas img').live('click',function(){
        if (confirm("Deseja realmente excluir a imagem?")) {
            $(this).parent().parent().remove();
            if ($('#tblCaracteristicas tbody tr').length == 0) {
                $('#tblCaracteristicas tbody').html('<tr><td colspan="4" align="center"><strong><i>Nenhuma caracteristica cadastrada!</i></strong></td></tr>');
                $('#seqCaracteristica').val('1');
            }
        }
    });*/
    
    /*$('#btnAddCaracteristica').click(function(){
        if ($('#tblCaracteristicas tbody tr').length == 1 && $('#tblCaracteristicas tbody tr td').length == 1) {
            $('#tblCaracteristicas tbody').html('');            
        }
        if ($('#idCaracteristica').val() < 1) {
            alert('Selecione uma caracteristica!');
            $('#idCaracteristica').focus();
        } else if ($('#desCaracteristica').val() == '') {            
            alert('Informe uma descrição para a caracteristica!');
            $('#desCaracteristica').focus();
        } else {
            if ($.trim($('#seqCaracteristica').val()) == '' || parseInt($('#seqCaracteristica').val()) <= 0) {
                $('#seqCaracteristica').val('1');
            }
            if ($('#'+$('#idCaracteristica').val()).length) {                
                alert('A caracteristica informada já foi inserida!');
            } else {
                $('#tblCaracteristicas tbody').append('<tr id="'+$('#idCaracteristica').val()+'"><td>'+$('#seqCaracteristica').val()+'</td><td><input type="hidden" name="idCaracteristica[]" value="'+$('#idCaracteristica').val()+'" />'+$('#idCaracteristica').find('option').filter(':selected').text()+'</td><td><input type="hidden" name="caracteristica[]" value="'+$('#desCaracteristica').val()+'" />'+$('#desCaracteristica').val()+'</td><td><img style="cursor: pointer;" src="images/delete.png" title="Excluir"/></td></tr>');
                $('#seqCaracteristica').val(parseInt($('#seqCaracteristica').val())+1);
                $('#desCaracteristica').val('');
            }
            $('#idCaracteristica').focus();
        }
    });*/
    
    /*$('#terceiro').click(function(){
        ativarCamposObrigatoriosProprietario();        
        $('#dadosProprietario').show();
        $('#fisica').click();
    });
    
    $('#proprio').click(function(){
        desativarCamposObrigatoriosProprietario();
        $('#dadosProprietario').hide();
    });*/
    
    $('#fisica').click(function(){
        mudaFormPessoaFisica();
        if ($('#cpf_cnpj').val() == '') {
            $('#cpf_cnpj').focus();
        } else {
            $('#razao').focus();
        }
    }).click();
    
    $('#juridica').click(function(){
        mudaFormPessoaJuridica();
        if ($('#cpf_cnpj').val() == '') {
            $('#cpf_cnpj').focus();
        } else {
            $('#razao').focus();
        }
    });
    
    $('#btnConsultar').click(function(){        
        /*$('.carregando').show();
        $('#dados').hide();
        $('#registros').html('');
        $('#tblClientes tbody').html('');*/        
        
        $('.carregando').show();
        $('#tblClientes').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblClientes tbody').html(''); 
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/clienteConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json == null) {
                    str_html = '<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                } else {
                    if (json.status == 'OK') { //tem dados
                        for (i in json.resultados) {
                            seq++;                            
                            str_html = str_html + '<tr id="'+json.resultados[i].idPessoa+'"><td>'+seq+'</td><td>'+json.resultados[i].tipo+'</td><td>'+json.resultados[i].cpf_cnpj+'</td><td>'+json.resultados[i].razao+'</td><td>'+json.resultados[i].email+'</td><td><a href="javascript:visualizar('+json.resultados[i].idPessoa+')" class="btn btn-xs btn-info"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=clientecad&idcliente='+json.resultados[i].idPessoa+'" class="btn btn-xs btn-success"><i class="ace-icon fa fa-pencil bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:excluir('+json.resultados[i].idPessoa+');" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>';
                        }
                    } else {
                        if (json.status == 'NO') { //vazio
                            str_html = '<tr><td colspan="6" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                        } else {
                            str_html = '<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                        }
                    }
                }                
                /*$('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblClientes tbody').html(str_html);
                $('#dados').show();
                $('.carregando').hide();*/
                
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblClientes tbody').html(str_html);
                $('#registros').show();
                $('#tblClientes').show();
                $('.carregando').hide();
            },
            error: function() {
                /*$('#registros').html('0 registro(s) encontrado(s).');
                $('#tblClientes tbody').html('<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                $('#dados').show();
                $('.carregando').hide();*/
                
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblClientes tbody').html('<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                $('.carregando').hide();                                      
            }
        });
    }).click();
});

/*function lixeira(pIdImovel) {
    if (confirm("Deseja realmente mover o item para a lixeira?")) {
        aguarde();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/imovelLixeira.php',
            data: {idImovel: pIdImovel},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {                    
                    $('#'+pIdImovel).remove();                    
                    $('#registros').html($('#tblImoveis tbody tr').length+' registro(s) encontrado(s).');
                    alert('Imovel movido para a lixeira!');
                } else {
                    alert('Erro ao tentar mover o imóvel para a lixeira!');
                }               
            },
            error: function() {
                aguarde(false);
                alert('Erro ao tentar mover o imóvel para a lixeira!'); 
            }
        });
    }
}*/

function excluir (codigo) {
    if (confirm('Deseja realmente excluir o cliente?')) {
        aguarde();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/clienteExcluir.php',
            data: {idPessoa: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblClientes tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblClientes tbody tr').length == 0) {
                        $('#tblClientes tbody').html('<tr><td colspan="6" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Cliente excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir o cliente!');
                }
            },
            error: function() {
                aguarde(false);
                alert('Erro ao tentar excluir o cliente!');
            }
        });
    }
}

function visualizar (codigo) {
    aguarde();
    $('#tblInfoCliente').html('');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/clienteVisualizar.php',
        data: {idPessoa: codigo},
        success: function(json) {
            aguarde(false);
            if (json.status == 'OK') {
                var str_html = '';                
                str_html = '<tr><td><strong>'+((json.resultados[0].tipo == 'F') ? 'Nome' : 'Razão')+':</strong></td><td>'+json.resultados[0].razao+'</td></tr>';
                str_html += '<tr><td><strong>'+((json.resultados[0].tipo == 'F') ? 'Apelido' : 'Fantasia')+':</strong></td><td>'+json.resultados[0].fantasia+'</td></tr>';
                str_html += '<tr><td><strong>'+((json.resultados[0].tipo == 'F') ? 'CPF' : 'CNPJ')+':</strong></td><td>'+json.resultados[0].cpf_cnpj+'</td></tr>';
                str_html += '<tr><td><strong>'+((json.resultados[0].tipo == 'F') ? 'RG' : 'IE')+':</strong></td><td>'+json.resultados[0].rg_ie+'</td></tr>';
                str_html += '<tr><td><strong>'+((json.resultados[0].tipo == 'F') ? 'Nascimento' : 'Fundação')+':</strong></td><td>'+json.resultados[0].dtNascimento+'</td></tr>';
                str_html += (json.resultados[0].tipo == 'F') ? '<tr><td><strong>Estado civil:</strong></td><td>'+json.resultados[0].idEstadoCivil+'</td></tr>' : '';
                str_html += '<tr><td><strong>'+((json.resultados[0].tipo == 'F') ? 'Sexo' : 'Gênero')+':</strong></td><td>'+json.resultados[0].genero+'</td></tr>';
                str_html += '<tr><td><strong>Endereço:</strong></td><td>'+json.resultados[0].logradouro+', '+
                            json.resultados[0].numLogradouro+' - '+json.resultados[0].complemento+', '+json.resultados[0].bairro+', '+
                            json.resultados[0].cidade+'/'+json.resultados[0].uf+' - '+json.resultados[0].pais+'</td></tr>';
                str_html += '<tr><td><strong>Telefone:</strong></td><td>'+json.resultados[0].telefone+'</td></tr>';
                str_html += '<tr><td><strong>Fax:</strong></td><td>'+json.resultados[0].fax+'</td></tr>';
                str_html += '<tr><td><strong>Celular:</strong></td><td>'+json.resultados[0].celular+'</td></tr>';
                str_html += '<tr><td><strong>E-mail:</strong></td><td>'+json.resultados[0].email+'</td></tr>';
                str_html += '<tr><td><strong>Site:</strong></td><td>'+json.resultados[0].site+'</td></tr>';
                $('#tblInfoCliente').html(str_html);
                criar();
            } else if (json.status == 'ERRO') {
                aguarde(false);
                alert('Erro ao tentar localizar as informações do cliente!'); 
            }
        },
        error: function() {
            aguarde(false);
            alert('Erro ao tentar localizar as informações do cliente!'); 
        }
    });
}

function mudaFormPessoaFisica() {
    $('#lblCpf label').html('CPF:');
    $('#lblCpf input').attr('title', 'CPF');    
    $('#lblRazao label').html('Nome:');
    $('#lblRazao input').attr('title', 'Nome');
    $('#lblFantasia label').html('Apelido:');
    $('#lblFantasia input').attr('title', 'Apelido');
    $('#lblRg label').html('RG:');
    $('#lblRg input').attr('title', 'RG');
    $('#lblNascimento label').html('Nascimento:');
    $('#lblNascimento input').attr('title', 'Nascimento');
    $('#lblGenero label').html('Sexo:');
    $('#lblGenero input').attr('title', 'Sexo');
    $('#lblEstadoCivil').show();
    //$('#cpf_cnpj').removeClass('cnpj');
    //$('#cpf_cnpj').addClass('cpf');
    //$('.cpf').setMask('cpf');
}

function mudaFormPessoaJuridica() {
    $('#lblCpf label').html('CNPJ:');
    $('#lblCpf input').attr('title', 'CNPJ');
    $('#lblRazao label').html('Razão:');
    $('#lblRazao input').attr('title', 'Razão');
    $('#lblFantasia label').html('Fantasia:');
    $('#lblFantasia input').attr('title', 'Fantasia');
    $('#lblRg label').html('IE:');
    $('#lblRg input').attr('title', 'IE');
    $('#lblNascimento label').html('Fundação:');
    $('#lblNascimento input').attr('title', 'Fundação');
    $('#lblGenero label').html('Gênero:');
    $('#lblGenero input').attr('title', 'Gênero');
    $('#lblEstadoCivil').hide();
    //$('#cpf_cnpj').removeClass('cpf');
    //$('#cpf_cnpj').addClass('cnpj');
    //$('.cnpj').setMask('cnpj');
}

/*function ativarCamposObrigatoriosProprietario() {
    $('#lblCpf input').addClass('obrigatorio');    
    $('#lblRazao input').addClass('obrigatorio');    
}

function desativarCamposObrigatoriosProprietario() {
    $('#lblCpf input').removeClass('obrigatorio');
    $('#lblRazao input').removeClass('obrigatorio');    
}*/

function localizarPessoa() {
    if (cpf_cnpj_valido($('#cpf_cnpj').val())) {
        aguarde();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/pessoaLocalizar.php',
            data: {cpf_cnpj: $('#cpf_cnpj').val()},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    aguarde('Pessoa localizado, carregando...');
                    if (json.resultados[0].tipo == 'F') {
                        $('#fisica').click();
                    } else {
                        $('#juridica').click();
                    }
                    $('#idPessoa').val(json.resultados[0].idPessoa);                    
                    $('#razao').val(json.resultados[0].razao);
                    $('#fantasia').val(json.resultados[0].fantasia);
                    $('#cpf_cnpj').val(json.resultados[0].cpf_cnpj);
                    $('#rg_ie').val(json.resultados[0].rg_ie);
                    $('#dtNascimento').val(json.resultados[0].dtNascimento);
                    $('#idEstadoCivil').val(json.resultados[0].idEstadoCivil);                    
                    $('#genero').val(json.resultados[0].genero);                    
                    $('#cep').val(json.resultados[0].cep);
                    $('#logradouro').val(json.resultados[0].logradouro);
                    $('#numLogradouro').val(json.resultados[0].numLogradouro);
                    $('#complemento').val(json.resultados[0].complemento);
                    $('#pontoReferencia').val(json.resultados[0].pontoReferencia);
                    $('#bairro').val(json.resultados[0].bairro);
                    $('#cidade').val(json.resultados[0].cidade);
                    $('#uf').val(json.resultados[0].uf);
                    $('#pais').val(json.resultados[0].pais);
                    $('#observacao').val(json.resultados[0].observacao);
                    $('#telefone').val(json.resultados[0].telefone);
                    $('#fax').val(json.resultados[0].fax);
                    $('#celular').val(json.resultados[0].celular);
                    $('#email').val(json.resultados[0].email);
                    $('#site').val(json.resultados[0].site);
                    aguarde(false);
                } else if (json.status == 'ERRO') {
                    alert('Erro ao tentar localizar a pessoa!'); 
                }
            },
            error: function() {
                aguarde(false);
                alert('Erro ao tentar localizar a pessoa!'); 
            }
        });
    } else {
        if ($('#cpf_cnpj').val() != '') {
            $('#cpf_cnpj').val('');           
            if ($("#fisica").is(':checked')) {
                alert('O CPF informado é inválido!');                
            } else {
                alert('O CNPJ informado é inválido!');
            }
        }
    } 
}

function close() {
    $("#fundo").fadeOut(300);
}

function criar() {    
    $("#fundo").fadeIn(300);    
}