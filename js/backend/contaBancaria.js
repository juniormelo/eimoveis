$(document).ready(function() {     
  
    if ($('#txtConsulta').length) {
        $('#txtConsulta').focus();
    }
    
    $('#btnNovo').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=contacad");
    });
    
    $('#btnLista').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=contaslista");
    });        
    
    $('#btnSalvar').click(function() {
        var podeExecutar = camposPreenchidos();        
        if (podeExecutar) {
            $('#fmCadConta').submit();
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
        $('#tblContas').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblContas tbody').html(''); 
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/contaConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json == null) {
                    str_html = '<tr><td colspan="7" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                } else {
                    if (json.status == 'OK') { //tem dados
                        for (i in json.resultados) {
                            seq++;                            
                            str_html = str_html + '<tr id="'+json.resultados[i].idContaBanco+'"><td>'+seq+'</td><td>'+json.resultados[i].descricao+'</td><td>'+json.resultados[i].banco+'</td><td>'+json.resultados[i].agencia+'</td><td>'+json.resultados[i].conta+'</td><td>'+json.resultados[i].saldoAtual+'</td><td><a href="javascript:visualizar('+json.resultados[i].idContaBanco+')" class="btn btn-xs btn-info"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=contacad&idconta='+json.resultados[i].idContaBanco+'" class="btn btn-xs btn-success"><i class="ace-icon fa fa-pencil bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:excluir('+json.resultados[i].idContaBanco+');" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>';
                        }
                    } else {
                        if (json.status == 'NO') { //vazio
                            str_html = '<tr><td colspan="7" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                        } else {
                            str_html = '<tr><td colspan="7" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                        }
                    }
                }                
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblContas tbody').html(str_html);
                $('#registros').show();
                $('#tblContas').show();
                $('.carregando').hide();
            },
            error: function() {                
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblContas tbody').html('<tr><td colspan="7" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                $('.carregando').hide();                                      
            }
        });
    }).click();
});

function excluir (codigo) {
    if (confirm('Deseja realmente excluir a conta?')) {
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/contaExcluir.php',
            data: {idConta: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblContas tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblContas tbody tr').length == 0) {
                        $('#tblContas tbody').html('<tr><td colspan="7" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Conta bancária excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir a conta bancária!');
                }
            },
            error: function() {                
                alert('Erro ao tentar excluir a conta bancária!');
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