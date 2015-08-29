$(document).ready(function() {     
  
    if ($('#txtConsulta').length) {
        $('#txtConsulta').focus();
    }
    
    $('#btnNovo').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=bancocad");
    });
    
    $('#btnLista').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=bancoslista");
    });        
    
    $('#btnSalvar').click(function() {
        var podeExecutar = camposPreenchidos();        
        if (podeExecutar) {
            $('#fmCadBanco').submit();
            //aguarde();
            /*$.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/backend/bancoGravar.php',
                data: $('#fmCadBanco').serialize(),
                success: function(json) {
                    aguarde(false);
                    if (json == null) {
                        alert('Erro ao tentar salvar o banco!');
                    } else if (json.status == 'OK') {                        
                        alert('Banco salvo com sucesso!');                        
                    } else {
                        alert('Erro ao tentar salvar o banco!');
                    }
                },
                error: function() {
                    aguarde(false);
                    alert('Erro ao tentar salvar o banco!');
                }
            });*/
        }
    });
    
    $('#btnConsultar').click(function(){                       
        $('.carregando').show();
        $('#tblBancos').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblBancos tbody').html(''); 
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/bancoConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json == null) {
                    str_html = '<tr><td colspan="4" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                } else {
                    if (json.status == 'OK') { //tem dados
                        for (i in json.resultados) {
                            seq++;                            
                            str_html = str_html + '<tr id="'+json.resultados[i].idBanco+'"><td>'+seq+'</td><td>'+json.resultados[i].codigo+'</td><td>'+json.resultados[i].descricao+'</td><td><a href="javascript:visualizar('+json.resultados[i].idBanco+')" class="btn btn-xs btn-info"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=bancocad&idbanco='+json.resultados[i].idBanco+'" class="btn btn-xs btn-success"><i class="ace-icon fa fa-pencil bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:excluir('+json.resultados[i].idBanco+');" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>';
                        }
                    } else {
                        if (json.status == 'NO') { //vazio
                            str_html = '<tr><td colspan="4" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                        } else {
                            str_html = '<tr><td colspan="4" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                        }
                    }
                }                
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblBancos tbody').html(str_html);
                $('#registros').show();
                $('#tblBancos').show();
                $('.carregando').hide();
            },
            error: function() {                
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblBancos tbody').html('<tr><td colspan="4" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
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
    if (confirm('Deseja realmente excluir o banco?')) {
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/bancoExcluir.php',
            data: {idBanco: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblBancos tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblBancos tbody tr').length == 0) {
                        $('#tblBancos tbody').html('<tr><td colspan="4" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Banco excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir o banco!');
                }
            },
            error: function() {
                aguarde(false);
                alert('Erro ao tentar excluir o banco!');
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