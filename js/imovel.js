$(document).ready(function() {    
    aplicaEstiloTagFile();
    
    if ($('#txtConsulta').length) {
        $('#txtConsulta').focus();
    }
    
    if ($('#codigo').length) {
        $('#codigo').focus();
    }            
    
    $('#btnNovo').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=imovelcad");
    });
    
    $('#btnLista').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=imovellista");
    });        
    
    $('#btnSalvar').click(function(){
        $('#fmCadImovel').submit();
    });        

    $('#fmCadImovel').submit(function() {
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
            //aguarde('Salvando...');
            return true;            
        } else {
            return false;
        }             
    });
    
    $('#btnAddImg').click(function() {
                         
        if ($('#tblImagens tbody tr').length == 1 && $('#tblImagens tbody tr td').length == 1) {
            $('#tblImagens tbody').html('');            
        }
        $('#tblImagens').append('<tr><td width="3%"><input type="hidden" name="codImg[]" value="0" /><input type="hidden" name="nomeImg[]" value="i_img_nv" /><input type="text" name="ordemImg[]" value="1" class="input-mini"/></td><td width="25%"><input type="file" name="img[]" id="id-input-file-2" /></td><td width="3%"><input type="text" name="descImg[]" class="input-sm"/></td><td width="3%"><a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>');
        
        aplicaEstiloTagFile();
        
        /*$('#id-input-file-1 , #id-input-file-2').ace_file_input({
            //no_file:'No File ...',
            no_file:'Nenhum imagem ...',
            btn_choose:'Escolher',
            btn_change:'Alterar',
            droppable:false,
            onchange:null,
            thumbnail:false, //| true | large
            whitelist:'gif|png|jpg|jpeg'
            //blacklist:'exe|php'
            //onchange:''
            //
         });*/
    });
    
    //$('#tblImagens img').live('click',function(){
    $('#tblImagens').on("click", ".btn-danger",function(){
        if (confirm("Deseja realmente excluir a imagem?")) {
            $(this).parent().parent().remove();
            if ($('#tblImagens tbody tr').length == 0) {
                $('#tblImagens tbody').html('<tr><td colspan="4" align="center"><strong><i>Nenhuma imagem cadastrada!</i></strong></td></tr>');
            }
        }
    });
        
    //$('#tblCaracteristicas img').live('click',function(){
    $('#tblCaracteristicas').on("click", ".btn-danger",function(){
        if (confirm("Deseja realmente excluir a caracteristica?")) {
            $(this).parent().parent().remove();
            if ($('#tblCaracteristicas tbody tr').length == 0) {
                $('#tblCaracteristicas tbody').html('<tr><td colspan="4" align="center"><strong><i>Nenhuma caracteristica cadastrada!</i></strong></td></tr>');
                $('#seqCaracteristica').val('1');
            }
        }
    });
    
    $('#btnAddCaracteristica').click(function(){
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
            if ($('#c'+$('#idCaracteristica').val()).length) {                
                alert('A caracteristica informada já foi inserida!');
            } else {
                $('#tblCaracteristicas tbody').append('<tr id="c'+$('#idCaracteristica').val()+'"><td>'+$('#seqCaracteristica').val()+'</td><td><input type="hidden" name="idCaracteristica[]" value="'+$('#idCaracteristica').val()+'" />'+$('#idCaracteristica').find('option').filter(':selected').text()+'</td><td><input type="hidden" name="caracteristica[]" value="'+$('#desCaracteristica').val()+'" />'+$('#desCaracteristica').val()+'</td><td><a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>');
                $('#seqCaracteristica').val(parseInt($('#seqCaracteristica').val())+1);
                $('#desCaracteristica').val('');
            }
            $('#idCaracteristica').focus();
        }
    });
    
    //$('#tblProximidades img').live('click',function(){
    $('#tblProximidades').on("click", ".btn-danger",function(){
        if (confirm("Deseja realmente excluir a proximidade?")) {
            $(this).parent().parent().remove();
            if ($('#tblProximidades tbody tr').length == 0) {
                $('#tblProximidades tbody').html('<tr><td colspan="4" align="center"><strong><i>Nenhuma proximidade cadastrada!</i></strong></td></tr>');
                $('#seqProximidade').val('1');
            }
        }
    });
    
    $('#btnAddProximidade').click(function(){
        if ($('#tblProximidades tbody tr').length == 1 && $('#tblProximidades tbody tr td').length == 1) {
            $('#tblProximidades tbody').html('');            
        }
        if ($('#idProximidade').val() < 1) {
            alert('Selecione uma proximidade!');
            $('#idProximidade').focus();
        //} else if ($('#desProximidade').val() == '') {            
            //alert('Informe uma descrição para a proximidade!');
            //$('#desCaracteristica').focus();
        } else {
            if ($.trim($('#seqProximidade').val()) == '' || parseInt($('#seqProximidade').val()) <= 0) {
                $('#seqProximidade').val('1');
            }
            if ($('#p'+$('#idProximidade').val()).length) {                
                alert('A proximidade informada já foi inserida!');
            } else {
                $('#tblProximidades tbody').append('<tr id="p'+$('#idProximidade').val()+'"><td>'+$('#seqProximidade').val()+'</td><td><input type="hidden" name="idProximidade[]" value="'+$('#idProximidade').val()+'" />'+$('#idProximidade').find('option').filter(':selected').text()+'</td><td><input type="hidden" name="proximidade[]" value="'+$('#desProximidade').val()+'" />'+$('#desProximidade').val()+'</td><td><a href="javascript:void(0);" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>');
                $('#seqProximidade').val(parseInt($('#seqProximidade').val())+1);
                $('#desProximidade').val('');
            }
            $('#idProximidade').focus();
        }
    });   
    
    $('#terceiro').click(function(){
        ativarCamposObrigatoriosProprietario();        
        $('#dadosProprietario').show();
        $('#fisica').click();
    });
    
    $('#proprio').click(function(){
        desativarCamposObrigatoriosProprietario();
        $('#dadosProprietario').hide();
    });
    
    $('#fisica').click(function(){
        mudaFormPessoaFisica();
        if ($('#cpf_cnpj').val() == '') {
            $('#cpf_cnpj').focus();
        } else {
            $('#razao').focus();
        }
    });
    
    $('#juridica').click(function(){
        mudaFormPessoaJuridica();
        if ($('#cpf_cnpj').val() == '') {
            $('#cpf_cnpj').focus();
        } else {
            $('#razao').focus();
        }
    });
    
    $('#btnConsultar').click(function(){        
        $('.carregando').show();
        $('#tblImoveis').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblImoveis tbody').html('');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/imovelConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json == null) {
                    str_html = '<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os imóveis!</i></strong></td></tr>';
                } else {
                    if (json.status == 'OK') { //tem dados
                        for (i in json.resultados) {
                            seq++;
                            str_html = str_html + '<tr id="'+json.resultados[i].idImovel+'"><td>'+seq+'</td><td>'+json.resultados[i].codigo+'</td><td>'+json.resultados[i].categoria+'</td><td>'+json.resultados[i].Imovel+'</td><td>'+json.resultados[i].dataCadastro+'</td><td><a href="javascript:visualizar('+json.resultados[i].idImovel+')" class="btn btn-xs btn-info"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=imovelcad&idimovel='+json.resultados[i].idImovel+'" class="btn btn-xs btn-success"><i class="ace-icon fa fa-pencil bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:lixeira('+json.resultados[i].idImovel+');" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>';
                        }
                    } else {
                        if (json.status == 'NO') { //vazio
                            str_html = '<tr><td colspan="6" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                        } else {
                            str_html = '<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os imóveis!</i></strong></td></tr>';
                        }
                    }
                }
                
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblImoveis tbody').html(str_html);
                $('#registros').show();
                $('#tblImoveis').show();
                $('.carregando').hide();
            },
            error: function() {
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblImoveis tbody').html('<tr><td colspan="6" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                $('.carregando').hide();
            }
        });
    }).click();
});

function lixeira(pIdImovel) {
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
    $('#cpf_cnpj').removeClass('cnpj');
    $('#cpf_cnpj').addClass('cpf');
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
    $('#cpf_cnpj').removeClass('cpf');
    $('#cpf_cnpj').addClass('cnpj');
    //$('.cnpj').setMask('cnpj');
}

function ativarCamposObrigatoriosProprietario() {
    $('#lblCpf input').addClass('obrigatorio');    
    $('#lblRazao input').addClass('obrigatorio');    
}

function desativarCamposObrigatoriosProprietario() {
    $('#lblCpf input').removeClass('obrigatorio');
    $('#lblRazao input').removeClass('obrigatorio');    
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
                    aguarde('Pessoa localizada, carregando...');
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
                    $('#proCep').val(json.resultados[0].cep);
                    $('#proLogradouro').val(json.resultados[0].logradouro);
                    $('#proNumLogradouro').val(json.resultados[0].numLogradouro);
                    $('#proComplemento').val(json.resultados[0].complemento);
                    $('#proPontoReferencia').val(json.resultados[0].pontoReferencia);
                    $('#proBairro').val(json.resultados[0].bairro);
                    $('#proCidade').val(json.resultados[0].cidade);
                    $('#proUf').val(json.resultados[0].uf);
                    $('#proPais').val(json.resultados[0].pais);
                    $('#proObservacao').val(json.resultados[0].observacao);
                    $('#telefone').val(json.resultados[0].telefone);
                    $('#fax').val(json.resultados[0].fax);
                    $('#celular').val(json.resultados[0].celular);
                    $('#email').val(json.resultados[0].email);
                    $('#site').val(json.resultados[0].site);
                    aguarde(false);
                } else if (json.status == 'ERRO') {
                    aguarde(false);
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

function visualizar(codigo) {
    aguarde();
    $('#tblInfoImovel tbody').html('');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/imovelGetInfoCadastrais.php',
        data: {idImovel: codigo},
        success: function(json) {
            aguarde(false);
            if (json.status == 'OK') {                    
                $('#tblInfoImovel').html('<thead><tr><th><strong>Código:</strong></th><th>'+json.resultados[0].codigo+
                                               '</th></tr><thead><tbody><tr><td><strong>Categoria:</strong></td><td>'+json.resultados[0].categoria+
                                               '</td></tr><tr><td><strong>Descrição:</strong></td><td>'+json.resultados[0].descricao+
                                               '</td></tr><tr><td><strong>Area:</strong></td><td>'+json.resultados[0].area+' M2'+                                               
                                               '</td></tr><tr><td><strong>Endereço:</strong></td><td>'+json.resultados[0].logradouro+','+
                                               json.resultados[0].numLogradouro+', '+json.resultados[0].bairro+' - '+json.resultados[0].cidade+
                                               ' / '+json.resultados[0].uf+' - '+json.resultados[0].pais+
                                               '</td></tr><tr><td><strong>Proprietario:</strong></td><td>'+json.resultados[0].razao+
                                               '</td></tr><tr><td><strong>Observação:</strong></td><td>'+json.resultados[0].observacao+
                                               '</td></tr></tbody>');
                criar();
            } else {
                alert('Erro ao tentar exibir as informações do imóvel!');
            }               
        },
        error: function() {
            aguarde(false);
            alert('Erro ao tentar exibir as informações do imóvel!'); 
        }
    });
}

function close() {
    $("#fundo").fadeOut(300);
}

function criar() {    
    $("#fundo").fadeIn(300);    
}

/*function aplicaEstiloTagFile() {
    $('#id-input-file-1 , #id-input-file-2').ace_file_input({
        //no_file:'No File ...',
        no_file:'Nenhum adicionada imagem ...',
        btn_choose:'Escolher',
        btn_change:'Alterar',
        droppable:false,
        onchange:null,
        thumbnail:false, //| true | large
        whitelist:'gif|png|jpg|jpeg'            
     });
}*/