$(document).ready(function() {
    $("#fundo").css({position: 'fixed',width: '100%',height: '100%',top: '0px',left: '0px',background: 'url(images/fund.png)'}).hide();
    $("#janela").css({position: 'absolute',width: '800px',height: '60%',top: '20%',left: '50%',marginLeft: '-400px',backgroundColor: 'white',border: '1px gray solid',borderRadius: '5px',padding: '10px'});
    $("#corpo").css({overflowY: 'auto',height: '85%'});
    $(".close").css({position: 'absolute',top: '20px',right: '20px'});
    
    if ($('#txtConsulta').length) {
        $('#txtConsulta').focus();
    }
    
    if ($('#cpf_cnpj').length) {
        if ($('#cpf_cnpj').val() == '') {
            $('#cpf_cnpj').focus();
        } else {
            $('#razao').focus();
        }
    }        
    
    $('#btnNovo').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=colaboradorcad");        
    });
    
    $('#btnLista').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=colaboradorlista");
    });        

    $('#btnSalvar').click(function() {
        var ok = camposPreenchidos();
        
        if (ok) {
            if ($('#cpf_cnpj').val() != '') {
                if (!cpf_cnpj_valido($('#cpf_cnpj').val())) {
                    alert('O CPF informado é inválido!');              
                    $('#cpf_cnpj').focus();
                    ok = false;
                }                
            }
        }
        
        if (ok) {
            if ($('#dtNascimento').val() != '') {
                if (!dataValida($('#dtNascimento').val())) {
                    alert('A data de nascimento informada é inválida!');
                    $('#dtNascimento').focus();
                    ok = false;
                }
            }
        }
        
        
        if (ok) {
            if ($('#dtAdmissao').val() != '') {
                if (!dataValida($('#dtAdmissao').val())) {
                    alert('A data de admissão informada é inválida!');
                    $('#dtAdmissao').focus();
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
            if ($('#idCargo').val() < 1) {
                alert('Selecione um cargo!');
                $('#idCargo').focus();
                ok = false;                
            }
        }
        
        if (ok) {
            aguarde();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/colaboradorGravar.php',
                data: $('#fmCadColaborador').serialize(),
                success: function(json) {                   
                    aguarde(false);
                    if (json.status == 'OK') {
                        $('#idFuncionario').val(json.idFuncionario);
                        alert('Colaborador salvo com sucesso!');
                    } else {
                        alert('Erro ao tentar salvar o colaborador!');
                    }                    
                },
                error: function() {
                    aguarde(false);
                    alert('Erro ao tentar salvar o colaborador!');
                }
            });
        }                   
    });                       
    
    $('#btnConsultar').click(function(){

        $('.carregando').show();
        $('#tblColaboradores').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblColaboradores tbody').html(''); 
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/colaboradorConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json == null) {
                    str_html = '<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                } else {
                    if (json.status == 'OK') { //tem dados
                        for (i in json.resultados) {
                            seq++;                            
                            str_html = str_html + '<tr id="'+json.resultados[i].idFuncionario+'"><td>'+seq+'</td><td>'+json.resultados[i].cpf_cnpj+'</td><td>'+json.resultados[i].razao+'</td><td>'+json.resultados[i].cargo+'</td><td>'+json.resultados[i].email+'</td><td><a href="javascript:visualizar('+json.resultados[i].idFuncionario+')" class="btn btn-xs btn-info"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=colaboradorcad&idcolaborador='+json.resultados[i].idFuncionario+'" class="btn btn-xs btn-success"><i class="ace-icon fa fa-pencil bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:excluir('+json.resultados[i].idFuncionario+');" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>';
                        }
                    } else {
                        if (json.status == 'NO') { //vazio
                            str_html = '<tr><td colspan="6" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                        } else {
                            str_html = '<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                        }
                    }
                }                                
                /*$('#tblColaboradores tbody').html(str_html);
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#dados').show();
                $('.carregando').hide();*/
                
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblColaboradores tbody').html(str_html);
                $('#registros').show();
                $('#tblColaboradores').show();
                $('.carregando').hide();
            },
            error: function() {
                /*$('#registros').html('0 registro(s) encontrado(s).');
                $('#tblColaboradores tbody').html('<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                $('#dados').show();
                $('.carregando').hide();*/
                
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblColaboradores tbody').html('<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                $('.carregando').hide();  
            }
        });
    }).click();
});

function excluir (codigo) {
    if (confirm('Deseja realmente excluir o colaborador?')) {
        aguarde();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/colaboradorExcluir.php',
            data: {idFuncionario: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblColaboradores tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblColaboradores tbody tr').length == 0) {
                        $('#tblColaboradores tbody').html('<tr><td colspan="6" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Colaborador excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir o colaborador!');
                }
            },
            error: function() {
                aguarde(false);
                alert('Erro ao tentar excluir o colaborador!');
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
        url: 'app/control/colaboradorVisualizar.php',
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
                alert('Erro ao tentar localizar as informações da pessoa!'); 
            }
        },
        error: function() {
            aguarde(false);
            alert('Erro ao tentar localizar as informações da pessoa!'); 
        }
    });
}

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
                    $('#idFuncionario').val(json.resultados[0].idPessoa);                    
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
            alert('O CPF informado é inválido!');
        }
    } 
}

function close() {
    $("#fundo").fadeOut(300);
}

function criar() {    
    $("#fundo").fadeIn(300);    
}