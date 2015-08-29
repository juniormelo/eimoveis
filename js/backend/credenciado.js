$(document).ready(function() {    
    
    if ($('#txtConsulta').length) {
        $('#txtConsulta').focus();
    }
    
    $('#btnNovo').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=credenciadocad");
    });
    
    $('#btnLista').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=credenciadolista");
    });
    
    $('#fmCadCredenciado').submit(function() {
        if (camposPreenchidos()) {
            if ($('#cpf_cnpj').val() != '') {
                if (!cpf_cnpj_valido($('#cpf_cnpj').val())) {
                    if ($("#fisica").is(':checked')) {
                        alert('O CPF informado é inválido!');
                    } else {
                        alert('O CNPJ informado é inválido!');
                    }
                    $('#cpf_cnpj').focus();
                    return false;
                }
            }

            if ($('#dtNascimento').val() != '') {
                if (!dataValida($('#dtNascimento').val())) {
                    alert('A data informada é inválida!');
                    $('#dtNascimento').focus();
                    return false;
                }
            }

            if ($('#email').val() != '') {
                if (!emailValido($('#email').val())) {
                    alert('O e-mail informado é inválido!');
                    $('#email').focus();
                    return false;
                }
            }           
            return true;            
        } else {
            return false;
        }             
    });
    
    $('#btnSalvar').click(function() {
        $('#fmCadCredenciado').submit();
        /*var ok = camposPreenchidos();

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
            aguarde('Salvando...');            
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/backend/credenciadoGravar.php',
                data: $('#fmCadCredenciado').serialize(),
                success: function(json) {
                    //aguarde(false);
                    alert(json.status);
                    if (json.status == 'OK') {
                        $('#idPessoa').val(json.id);
                        alert('Credenciado salvo com sucesso!');
                    } else {
                        alert('Erro ao tentar salvar o credenciado!');
                    }
                },
                error: function() {
                    //aguarde(false);
                    alert('_Erro ao tentar salvar o credenciado!');
                }
            });
        }*/
    });
    
    $('#fisica').click(function(){
        mudaFormPessoaFisica();
        if ($('#cpf_cnpj').val() == '') {
            $('#cpf_cnpj').focus();
        } else {
            $('#razao').focus();
        }
    });//.click();
    
    $('#juridica').click(function(){
        mudaFormPessoaJuridica();
        $('#imobiliariaSim').attr("checked", true);
        if ($('#cpf_cnpj').val() == '') {
            $('#cpf_cnpj').focus();
        } else {
            $('#razao').focus();
        }
    });
    
    $('#btnConsultar').click(function(){     
        $('.carregando').show();
        $('#tblCredenciados').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblCredenciados tbody').html('');        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/credenciadoConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json == null) {
                    str_html = '<tr><td colspan="5" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                } else {
                    if (json.status == 'OK') { //tem dados
                        for (i in json.resultados) {
                            seq++;
                            str_html = str_html + '<tr id="'+json.resultados[i].idPessoa+'"><td>'+((json.resultados[i].credenciadoBloqueado.toUpperCase() == 'S')?'<span class="badge badge-danger" title="Credenciado bloqueado"><strong>B</strong></span>':'<span class="badge badge-success" title="Credenciado ativo"><strong>A</strong></span>')+'</td><td>'+json.resultados[i].tipo+'</td><td>'+json.resultados[i].cpf_cnpj+'</td><td>'+json.resultados[i].razao+'</td><td><a href="javascript:visualizar('+json.resultados[i].idPessoa+')" class="btn btn-xs btn-info"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=credenciadocad&idcredenciado='+json.resultados[i].idPessoa+'" class="btn btn-xs btn-success"><i class="ace-icon fa fa-pencil bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=credenciadomodulo&id='+json.resultados[i].idPessoa+'" class="btn btn-xs btn-warning" title="Habilitar/Desabilitar Módulos"><i class="ace-icon fa fa-users bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:alterarstatus('+json.resultados[i].idPessoa+');" class="btn btn-xs btn-danger" title="Alterar status (Ativar/Bloquear)"><i class="glyphicon glyphicon-refresh"></i></a></td></tr>';
                        }
                    } else {
                        if (json.status == 'NO') { //vazio
                            str_html = '<tr><td colspan="5" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                        } else {
                            str_html = '<tr><td colspan="5" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                        }
                    }
                }
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblCredenciados tbody').html(str_html);
                $('#registros').show();
                $('#tblCredenciados').show();
                $('.carregando').hide();
            },
            error: function() {
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblCredenciados tbody').html('<tr><td colspan="5" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                //$('#dados').show();
                $('.carregando').hide();
            }
        });        
        
    }).click();
    
    $('#btnLiberarMod').click(function() { 
        $('#btnLiberarMod strong').html('Liberando...');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/credenciadoLiberarModulos.php',
            data: $('#frmLibModulos').serialize(),
            success: function(json) {
                $('#btnLiberarMod strong').html('Liberar módulos');
                if (json.status == 'NO') {
                    alert('Operação realizada com sucesso!');
                } else if (json.status == 'OK') {
                    alert('Módulos liberados com sucesso!');
                } else if (json.status == 'PERMISSAO') {
                    alert('Você não tem permissão para executar a operação!');
                } else {
                    alert('Erro ao tentar liberar os módulos!');
                }
            },
            error: function() {
                $('#btnLiberarMod strong').html('Liberar módulos');
                alert('Erro ao tentar liberar os módulos!');
            }
        });        
        
    });
});

function visualizar (codigo) {
    aguarde();
    $('#tblInfoCredenciado').html('');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/backend/credenciadoVisualizar.php',
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
                $('#tblInfoCredenciado').html(str_html);
                criar();
            } else if (json.status == 'ERRO') {
                aguarde(false);
                alert('Erro ao tentar localizar as informações do credenciado!'); 
            }
        },
        error: function() {
            aguarde(false);
            alert('Erro ao tentar localizar as informações do credenciado!'); 
        }
    });
}

function mudaFormPessoaFisica() {
    $('#lblCpf label strong').html('CPF:');
    $('#lblCpf input').attr('title', 'CPF');    
    $('#lblRazao label strong').html('Nome:');
    $('#lblRazao input').attr('title', 'Nome');
    $('#lblFantasia label strong').html('Apelido:');
    $('#lblFantasia input').attr('title', 'Apelido');
    $('#lblRg label strong').html('RG:');
    $('#lblRg input').attr('title', 'RG');
    $('#lblNascimento label strong').html('Nascimen.:');
    $('#lblNascimento input').attr('title', 'Nascimento');
    $('#lblGenero label strong').html('Sexo:');
    $('#lblGenero input').attr('title', 'Sexo');
    $('#lblEstadoCivil').show();
    $('#dadosPessoaFisica').hide();
    $('#imobiliariaNao').attr("checked", false);
}

function mudaFormPessoaJuridica() {
    $('#lblCpf label strong').html('CNPJ:');
    $('#lblCpf input').attr('title', 'CNPJ');
    $('#lblRazao label strong').html('Razão:');
    $('#lblRazao input').attr('title', 'Razão');
    $('#lblFantasia label strong').html('Fantasia:');
    $('#lblFantasia input').attr('title', 'Fantasia');
    $('#lblRg label strong').html('IE:');
    $('#lblRg input').attr('title', 'IE');
    $('#lblNascimento label strong').html('Fundação:');
    $('#lblNascimento input').attr('title', 'Fundação');
    $('#lblGenero label strong').html('Gênero:');
    $('#lblGenero input').attr('title', 'Gênero');
    $('#lblEstadoCivil').hide();
    $('#dadosPessoaFisica').show();
    //$('#imobiliariaSim').attr("checked", true);
}

function localizarPessoa() {
    if (cpf_cnpj_valido($('#cpf_cnpj').val())) {
        aguarde('Verificando se a pessoa já existe...');
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

/*
 * Metodo para bloquear/desbloquear o credenciado, a variavel codigo é o
 * codigo do credenciado
 * @param {type} codigo
 * @returns {undefined}
 */
function alterarstatus(codigo) {
    //if (confirm('Deseja realmente alterar o status do credenciado?')) {        
        $('#'+codigo).children("td:nth-child(1)").html('<span class="badge badge-warning glyphicon glyphicon-refresh"> </span>');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/credenciadoAlterarStatus.php',
            data: {idPessoa: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'B') {
                    $('#'+codigo).children("td:nth-child(1)").html('<span class="badge badge-danger" title="Credenciado bloqueado"><strong>B</strong></span>');
                } else if (json.status == 'A') {                    
                    $('#'+codigo).children("td:nth-child(1)").html('<span class="badge badge-success" title="Credenciado ativo"><strong>A</strong></span>');
                } else {
                    alert('Erro ao tentar alterar status do credenciado!');
                }
            },
            error: function() {
                alert('Erro ao tentar alterar status do credenciado!');
            }
        });
    //}
}