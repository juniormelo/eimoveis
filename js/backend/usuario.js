$(document).ready(function() {
    $('#btnNovo').click(function(){
        limpaCampos();        
        $('#modal-form-usucad').modal('show');
        carregarVinculo();        
    });        
    
    if (($('#senhaAtual').length) && ($('#senhaNova').length)) {
        $('#senhaAtual').focus();
    }
    
    $('#btnAlterar').click(function() {
        var podeExecutar = camposPreenchidos();
        if (podeExecutar) {
            if ($('#senhaNova').val() != $('#senhaConfirme').val()) {
                alert('A senha nova não pode ser diferente da confirmação!');
                $('#senhaNova').focus();
                podeExecutar = false;
            }            
            if (podeExecutar) {                
                if (confirm('Deseja realmente alterar a senha?')) {
                    aguarde();
                    $('#btnAlterar strong').html('Alterando...');
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: 'app/control/usuarioAlterarSenha.php',
                        data: $('#frmAlterarSenha').serialize(),
                        success: function(json) {
                            $('#btnAlterar strong').html('Alterar senha');
                            aguarde(false);
                            if (json.status == 'OK') {
                                $('#senhaAtual').val('');
                                $('#senhaNova').val('');
                                $('#senhaConfirme').val('');
                                alert('Senha alterada com sucesso!');                               
                                $('#senhaAtual').focus();
                            } else if (json.status == 'NO') {
                                alert('A senha atual informada é errada!'); 
                            } else {
                                alert('Erro ao tentar alterar a senha do usuário!');
                            }                        
                        },
                        error: function() {
                            $('#btnAlterar strong').html('Alterar senha');
                            alert('Erro ao tentar alterar a senha do usuário!');
                        }
                    });
                }                
            }
        }
    });
    
    $('#btnRedefSenha').click(function() {
        var podeExecutar = true;
        
        if (podeExecutar) {
            if ($.trim($('#senhaRedef').val()) == '') {
                alert('Informe a senha!');
                $('#senhaRedef').focus();
                podeExecutar = false;
            }
        }

        if (podeExecutar) {
            if ($.trim($('#senhaRedef').val()) != $.trim($('#confirmeRedf').val())) {
                alert('A confirmação da senha não confere. O campo "Senha" e "Confirme a senha" devem ser idênticos!');
                $('#senhaRedef').focus();
                podeExecutar = false;
            }
        }           
        
        if (podeExecutar) {
            if (confirm('Deseja realmente redefinir a senha do usuario?')) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: 'app/control/backend/usuarioRedefinirSenha.php',
                    data: $('#frmRedefSenha').serialize(),
                    success: function(json) {
                        aguarde(false);
                        if (json.status == 'OK') {                            
                            alert('Senha alterada com sucesso!');
                            $('#idUsuarioRedef').val('');
                            $('#senhaRedef').val('');
                            $('#confirmeRedf').val('');                            
                            $('#btnCancelRedefSenha').click();
                        } else {
                            alert('Erro ao tentar alterar a senha do usuário!');
                        }                        
                    },
                    error: function() {
                        alert('Erro ao tentar alterar a senha do usuário!');
                    }
                });
            }                
        }
        
    });
    
    $('#btnConsultar').click(function(){             
        $('#loadconsulta').show();
        $('#tblUsuario').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblUsuario tbody').html(''); 
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/usuarioConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '', estilo = '';
                if (json.status == 'OK') { //tem dados
                    for (i in json.resultados) {
                        seq++;
                        estilo = '';//(json.resultados[i].bloqueado == 'Sim') ? 'style="color: red;"' : '';
                        str_html = str_html + '<tr id="'+json.resultados[i].idUsuario+'" '+estilo+'><td>'+((json.resultados[i].bloqueado.toUpperCase() == 'SIM')?'<span class="badge badge-danger" title="Usuário inativado"><strong>I</strong></span>':'<span class="badge badge-success" title="Usuário ativo"><strong>A</strong></span>')+'</td><td><strong>'+json.resultados[i].login+'</strong> <i>('+json.resultados[i].papel+')</i></td><td>'+json.resultados[i].razao+'</td><td>'+json.resultados[i].ultimoAcesso+'</td>';                                                
                        str_html = str_html + '<td>';
                        str_html = str_html + '<a href="javascript:visualizar('+json.resultados[i].idUsuario+')" class="btn btn-xs btn-info" title="+ informações"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>';
                        str_html = str_html + '&nbsp;&nbsp;&nbsp;<a href="javascript:redefinirsenha('+json.resultados[i].idUsuario+')" class="btn btn-xs btn-success" title="Redefinir senha"><i class="ace-icon fa fa-key bigger-130"></i></a>';
                        str_html = str_html + '&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=usuariopermissao&id='+json.resultados[i].idUsuario+'" class="btn btn-xs btn-warning" title="Grupo e Permissões"><i class="ace-icon fa fa-users bigger-130"></i></a>';
                        str_html = str_html + '&nbsp;&nbsp;&nbsp;<a href="javascript:alterarstatus('+json.resultados[i].idUsuario+');" class="btn btn-xs btn-danger" title="Alterar status (Ativar/Inativar)"><i class="glyphicon glyphicon-refresh"></i></a>';
                        str_html = str_html +  '</td></tr>';
                    }
                } else {
                    if (json.status == 'NO') { //vazio
                        str_html = '<tr><td colspan="5" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                    } else {                        
                        str_html = '<tr><td colspan="5" align="center"><strong><i>Erro ao tentar exibir os usuários!</i></strong></td></tr>';
                    }
                }                              
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblUsuario tbody').html(str_html);
                $('#registros').show();
                $('#tblUsuario').show();
                $('#loadconsulta').hide();
            },
            error: function() {
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblUsuario tbody').html('<tr><td colspan="5" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                $('#loadconsulta').hide(); 
            }
        });
    }).click();
    
    $('#btnSalvar').click(function() {
        var podeExecutar = true;        
        
        if (podeExecutar) {
            if ($.trim($('#idPessoa').val()) <= 0) {
                alert('Selecione um colaborador!');
                $('#idPessoa').focus();
                podeExecutar = false;
            }
        }
        
        if (podeExecutar) {
            if ($.trim($('#login').val()) == '') {
                alert('Informe o login para o usuário!');
                $('#login').focus();
                podeExecutar = false;
            }
        }
        
        if (podeExecutar) {
            if ($.trim($('#senha').val()) == '') {
                alert('Informe a senha!');
                $('#senha').focus();
                podeExecutar = false;
            }
        }

        if (podeExecutar) {
            if ($.trim($('#senha').val()) != $.trim($('#confirme').val())) {
                alert('A confirmação da senha não confere. O campo "Senha" e "Confirme a senha" devem ser idênticos!');
                $('#senha').focus();
                podeExecutar = false;
            }
        }  
        
        if (podeExecutar) {
            aguarde();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/usuarioGravar.php',
                data: $('#fmCadUsuario').serialize(),
                success: function(json) {
                    aguarde(false);
                    if (json == null) {
                        alert('Erro ao tentar salvar o usuário!');
                    } else if (json.status == 'OK') {                        
                        alert('Os dados do usuário foram salvos com sucesso!');
                        limpaCampos();
                        $('#btnCancelCadUsu').click();
                    } else if (json.status == 'ID') {                        
                        alert('O identificador do usuário é inválido!');
                    } else if (json.status == 'LG') {                        
                        alert('O login do usuário já existe!');
                    } else {
                        alert('Erro ao tentar salvar o usuário!');
                    }
                },
                error: function() {
                    aguarde(false);
                    alert('Erro ao tentar salvar o usuário!');
                }
            });
        }
    });
    
    $('#idPapel_alt').change(function(){
        if ($('#idPapel_alt').val() > 0) {
            $('.carregando').show();
            $('#tblpermissoes tbody').html('');                    
            $('#tblpermissoes').hide();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/backend/usuarioCarregaPermissao.php',
                data: {idUsuario: $('#idUsuario').val(),
                       idPapel_atual: $('#idPapel_atual').val(), 
                       idPapel_alt: $('#idPapel_alt').val()},
                success: function(json) { 
                    var i = 0, str_html = '';
                    if (json.status == 'OK') {                        
                        for (i in json.resultados) {                                                        
                            str_html = str_html + "<tr>";
                            str_html = str_html + '<td><div class="checkbox"><label><span class="lbl"><strong>'+json.resultados[i].modulo+'</strong></span></label></div></td>';
                            str_html = str_html + '<td><div class="checkbox"><label><span class="lbl"><strong>'+json.resultados[i].descricao+'</strong></span></label></div></td>';
                            str_html = str_html + '<td><div class="checkbox"><label><input name="permissoes[]" value="'+json.resultados[i].idPapelPermissao+'" type="checkbox" '+((json.resultados[i].permitido == 'S')?'checked=""':'')+' class="ace ckbpermissao" /><span class="lbl"></span></label></div></td>';
                            str_html = str_html + "</tr>";
                            
                        }
                    } else {
                        if (json.status == 'NO') { //vazio
                            str_html = '<tr><td colspan="3" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                        } else {                        
                            str_html = '<tr><td colspan="3" align="center"><strong><i>Erro ao tentar carregar as permissões!</i></strong></td></tr>';
                        }
                    }                                                  
                    $('#tblpermissoes tbody').html(str_html);                    
                    $('#tblpermissoes').show();
                    $('.carregando').hide();
                },
                error: function() {                    
                    $('#tblpermissoes tbody').html('<tr><td colspan="3" align="center"><strong><i>Erro ao tentar carregar as permissões!</i></strong></td></tr>');                    
                    $('#tblpermissoes').show();
                    $('.carregando').hide();
                }
            });
        } else {
            $('#tblpermissoes tbody').html('');
            $('#tblpermissoes').hide();
            $('.carregando').hide();
        }
    });
    
    $('#btnRetPermissao').click(function(){
        if (confirm('Deseja realmente retirar todas as permissões do usuário?')) {
            $('#btnRetPermissao strong').html('Retirando...');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/backend/usuarioRetPermissao.php',
                data: {idUsuario: $('#idUsuario').val()},
                success: function(json) {
                    $('#btnRetPermissao strong').html('Retirar todas');                   
                    if (json.status == 'OK') {
                        $('.ckbpermissao').each(function(){
                            $(this).attr("checked", false);                              
                        });
                        alert('Permissões retiradas com sucesso!');
                    } else {
                        alert('Erro ao tentar retirar as permissões!');
                    }
                },
                error: function() {
                    $('#btnRetPermissao strong').html('Retirar todas');
                    alert('Erro ao tentar retirar as permissões!');
                }
            }); 
        }
    });
    $('#btnAplicPermissao').click(function(){
        if (confirm('Deseja realmente aplicar as permissões?')) {
            $('#btnAplicPermissao strong').html('Aplicando...');
            $('#idPapel_atual').val($('#idPapel_alt').val());
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/backend/usuarioAplicPermissao.php',
                data: $('#frmUsuarioPermissoes').serialize(),
                success: function(json) {
                    $('#btnAplicPermissao strong').html('Aplicar permissões');                   
                    if (json.status == 'OK') {
                        alert('Permissões aplicadas com sucesso!');
                    } else {
                        alert('Erro ao tentar aplicar as permissões!');
                    }
                },
                error: function() {
                    $('#btnAplicPermissao strong').html('Aplicar permissões');
                    alert('Erro ao tentar aplicar as permissões!');
                }
            }); 
        }
    });
});

/*
 * Metodo para bloquear/desbloquear o usuario, a variavel status é um boleano se
 * verdadeiro bloqueia, caso seja falso desbloqueia
 * @param {type} status
 * @returns {undefined}
 */
function alterarstatus(codigo) {    
    $('#'+codigo).children("td:nth-child(1)").html('<span class="badge badge-warning glyphicon glyphicon-refresh"> </span>');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/backend/usuarioAlterarStatus.php',
        data: {idUsuario: codigo},
        success: function(json) {
            aguarde(false);
            if (json.status == 'I') {
                $('#'+codigo).children("td:nth-child(1)").html('<span class="badge badge-danger" title="Usuário inativado"><strong>I</strong></span>');
            } else if (json.status == 'A') {                    
                $('#'+codigo).children("td:nth-child(1)").html('<span class="badge badge-success" title="Usuário ativo"><strong>A</strong></span>');
            } else {
                alert('Erro ao tentar alterar status do usuário!');
            }
        },
        error: function() {
            alert('Erro ao tentar alterar status do usuário!');
        }
    });
}

function visualizar(pIdUsuario) {
    $('#usuinfo').html('');
    $("#loadinfousu").show();
    $('#modal-form-usuinfo').modal('show');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/backend/usuarioGetInfoCadastrais.php',
        data: {idUsuario: pIdUsuario},
        success: function(json) {
            $("#loadinfousu").hide();
            if (json == null) {
                alert('falha ao tentar exibir as informações do usuário!');
            } else if (json.status == 'OK') {
                var str_html = '<table class="table table-striped">';
                
                str_html = str_html + '<tr><td><strong>Nome</strong></td><td>'+json.resultados[0].razao+'</td></tr>';
                str_html = str_html + '<tr><td><strong>E-mail</strong></td><td>'+json.resultados[0].email+'</td></tr>';
                str_html = str_html + '<tr><td><strong>Grupo</strong></td><td>'+json.resultados[0].papel+'</td></tr>';
                str_html = str_html + '<tr><td><strong>Login</strong></td><td>'+json.resultados[0].login+'</td></tr>';
                str_html = str_html + '<tr><td><strong>Data Cadastro</strong></td><td>'+json.resultados[0].dataCadastro+'</td></tr>';
                str_html = str_html + '<tr><td><strong>Acessos</strong></td><td>'+json.resultados[0].acessos+'</td></tr>';
                str_html = str_html + '<tr><td><strong>Ult. Acesso</strong></td><td>'+json.resultados[0].ultimoAcesso+'</td></tr>';
                str_html = str_html + '<tr><td><strong>Bloqueado</strong></td><td>'+json.resultados[0].bloqueado+'</td></tr>';
                
                str_html = str_html + '</table>';
                
                $('#usuinfo').html(str_html);
            } else {
                alert('Erro ao tentar exibir as informações do usuário!');
            }
        },
        error: function() {
            $("#loadinfousu").hide();
            alert('Erro ao tentar exibir as informações do usuário!');
        }
    }); 
}

function redefinirsenha(pIdUsuario) {
    $('#idUsuarioRedef').val('');
    $('#senhaRedef').val('');
    $('#confirmeRedf').val('');  
    $('#idUsuarioRedef').val(pIdUsuario);    
    $('#modal-form-usuredsenha').modal('show');
    $('#senhaRedef').focus();
}

function carregarVinculo(pIdUsuario) {
    try {
        $('#idPessoa').html('<option value="0">Carregando...</option>');
        $.ajax({
            type: 'POST',
            url: 'app/control/backend/usuarioCarregarVinculo.php',
            data: {idUsuario: pIdUsuario},
            success: function(data) {
                aguarde(false);
                if (data == null) {
                    alert('Erro ao tentar carregar os vinculos!');
                } else {                
                    $('#idPessoa').html(data);
                }
            },
            error: function() {
                alert('Erro ao tentar carregar os vinculos!');
            }
        });
    } catch(e) {
        $('#idPessoa').html('');
        alert('Erro ao tentar carregar os vinculos!');
    }        
}

function limpaCampos() {
    $('#login').val('');
    $('#senha').val('');
    $('#confirme').val('');
}