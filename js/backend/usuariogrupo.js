$(document).ready(function() {
    $('#btnNovo').click(function(){
        $('#modal-form-grupocad').modal('show');
        $('#idPapel').val('');
        $('#papel').val('');
        $('#papel').focus();
    });               
    
    $('#btnConsultar').click(function(){             
        $('.carregando').show();
        $('#tblGrupo').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblGrupo tbody').html(''); 
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/usuarioGrupoConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json.status == 'OK') { //tem dados
                    for (i in json.resultados) {
                        seq++;
                        str_html = str_html + '<tr id="'+json.resultados[i].idpapel+'"><td><strong>'+seq+'</strong></td><td>' + (($.trim(json.resultados[i].codigo) != '') ? '<strong>' : '') + json.resultados[i].papel + (($.trim(json.resultados[i].codigo) != '') ? '</strong>' : '') + '</td>';
                                                
                        if ($.trim(json.resultados[i].codigo) == '') {
                            str_html = str_html + '<td>';
                            str_html = str_html + '<a href="javascript:editar('+json.resultados[i].idpapel+')" class="btn btn-xs btn-success" title="Editar grupo"><i class="ace-icon fa fa-pencil bigger-130"></i></a>';
                            str_html = str_html + '&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=usuariogrupopermissao&id='+json.resultados[i].idpapel+'" class="btn btn-xs btn-warning" title="Configurar permissões do grupo"><i class="ace-icon fa fa-users bigger-130"></i></a>';
                            str_html = str_html + '&nbsp;&nbsp;&nbsp;<a href="javascript:excluir('+json.resultados[i].idpapel+');" class="btn btn-xs btn-danger" title="Excluir grupo"><i class="ace-icon fa fa-trash-o bigger-130"></i></a>';
                            str_html = str_html +  '</td>';
                        } else {
                            str_html = str_html + '<td></td>';                                                    
                        }
                        
                        str_html = str_html +  '</tr>';
                    }
                } else {
                    if (json.status == 'NO') { //vazio
                        str_html = '<tr><td colspan="3" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                    } else {                        
                        str_html = '<tr><td colspan="3" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                    }
                }                              
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblGrupo tbody').html(str_html);
                $('#registros').show();
                $('#tblGrupo').show();
                $('.carregando').hide();
            },
            error: function() {
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblGrupo tbody').html('<tr><td colspan="3" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                $('.carregando').hide(); 
            }
        });
    }).click();
    
    $('#btnSalvar').click(function() {        
        if ($.trim($('#papel').val() != '')) {
            $('#btnSalvar strong').html('Salvando...');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/backend/usuarioGrupoGravar.php',
                data: $('#frmcadgrupo').serialize(),
                success: function(json) {
                    $('#btnSalvar strong').html('Salvar');
                    if (json == null) {
                        alert('Erro ao tentar salvar o grupo!');
                    } else if (json.status == 'OK') {                        
                        alert('O grupo foi salvo com sucesso!');
                        $('#idPapel').val('');
                        $('#papel').val('');
                        $('#btnCancelar').click();
                    } else {
                        alert('Erro ao tentar salvar o grupo!');
                    }
                },
                error: function() {
                    $('#btnSalvar strong').html('Salvar');
                    alert('Erro ao tentar salvar o grupo!');
                }
            });
        }
    });
    
    $('#btnAplicPermissao').click(function() { 
        $('#btnAplicPermissao strong').html('Aplicando...');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/usuarioGrupoAplicPermissao.php',
            data: $('#frmGrupoPermissoes').serialize(),
            success: function(json) {
                $('#btnAplicPermissao strong').html('Aplicar permissões');
                /*if (json.status == 'NO') {
                    alert('Operação realizada com sucesso!');
                } else */
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
        
    });
    
    $('#btnRetPermissao').click(function() {
        if (confirm('Deseja realmente retirar todas as permissões desse grupo?')) {
            $('#btnRetPermissao strong').html('Retirando...');
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/backend/usuarioGrupoRetPermissao.php',
                data: {idPapel: $('#idPapel').val()},
                success: function(json) {
                    $('#btnRetPermissao strong').html('Retirar todas');                
                    if (json.status == 'OK') {
                        $('.ckbpermissao').each(function(){
                            $(this).attr("checked", false);                              
                        });
                        alert('Permissões retiradas com sucesso!');
                    } else {
                        alert('Erro ao tentar retirar todas as permissões!');
                    }
                },
                error: function() {
                    $('#btnRetPermissao strong').html('Retirar todas');
                    alert('Erro ao tentar retirar todas as permissões!');
                }
            });
        }
    });
    
});

function excluir(codigo) {
    if (confirm('Deseja realmente excluir o grupo?')) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/usuarioGrupoExcluir.php',
            data: {idPapel: codigo},
            success: function(json) {
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblGrupo tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblGrupo tbody tr').length == 0) {
                        $('#tblGrupo tbody').html('<tr><td colspan="2" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Grupo excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir o grupo!');
                }
            },
            error: function() {
                alert('Erro ao tentar excluir o Grupo!');
            }
        });
    }
}

function editar(codigo) {
    $('#modal-form-grupocad').modal('show');
    $('#idPapel').val('');
    $('#papel').val('');
    
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/backend/usuarioGrupoGetRegistro.php',
        data: {idPapel: codigo},
        success: function(json) {
            if (json.status == 'OK') {
                $('#idPapel').val(json.resultados[0].idpapel);
                $('#papel').val(json.resultados[0].papel);
                $('#papel').focus();
            } else if (json.status == 'NO') {
                alert('Registro não encontrado!');
            } else {
                alert('Falha ao tentar exibir o registro para edição!');
            }
        },
        error: function() {
            alert('Falha ao tentar exibir o registro para edição!');
        }
    });
}