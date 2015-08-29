$(document).ready(function() {     
  
    if ($('#txtConsulta').length) {
        $('#txtConsulta').focus();
    }
    
    $('#btnNovo').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=contarecebercad");
    });
    
    $('#btnLista').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=contareceber");
    });        
    
    $('#btnBaixa').click(function(){
        var podeExecutar = camposPreenchidos();
        if (podeExecutar) {
            
        }
    });        
    
    $('#btnSalvar').click(function() {
        var podeExecutar = camposPreenchidos();        
        if (podeExecutar) {
            $('#fmCadContaReceber').submit();
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
        $('#tblContaReceber').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblContaReceber tbody').html(''); 
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/contaReceberConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json == null) {
                    str_html = '<tr><td colspan="5" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                } else {
                    if (json.status == 'OK') { //tem dados
                        for (i in json.resultados) {
                            seq++;                            
                            str_html = str_html + '<tr id="'+json.resultados[i].idContaReceber+'"><td>'+json.resultados[i].documento+'</td><td>'+json.resultados[i].descricao+' '+json.resultados[i].parcela+'</td><td style="text-align: right;">R$ '+json.resultados[i].valorNominal+'</td><td>'+json.resultados[i].dataVencimento+'</td><td><a href="javascript:visualizar('+json.resultados[i].idContaReceber+')" title="Baixar parcela" class="btn btn-xs btn-info"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=contarecebercad&idcontareceber='+json.resultados[i].idContaReceber+'" title="Baixar conta" class="btn btn-xs btn-success"><i class="ace-icon fa fa-check-square-o bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:cancelar('+json.resultados[i].idContaReceber+');" title="Cancelar parcela" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-times bigger-130"></i></a></td></tr>';
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
                $('#tblContaReceber tbody').html(str_html);
                $('#registros').show();
                $('#tblContaReceber').show();
                $('.carregando').hide();
            },
            error: function() {                
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblContaReceber tbody').html('<tr><td colspan="7" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
                $('.carregando').hide();                                      
            }
        });
    }).click();
});

function cancelar (codigo) {
    if (confirm('Deseja realmente excluir a conta?')) {
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/contaReceberExcluir.php',
            data: {idConta: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblContaReceber tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblContaReceber tbody tr').length == 0) {
                        $('#tblContaReceber tbody').html('<tr><td colspan="7" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Conta excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir a conta!');
                }
            },
            error: function() {                
                alert('Erro ao tentar excluir a conta!');
            }
        });
    }
}

function infoBaixa (codigo) {
    if (confirm('Deseja realmente excluir a conta?')) {
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/contaReceberExcluir.php',
            data: {idConta: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblContaReceber tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblContaReceber tbody tr').length == 0) {
                        $('#tblContaReceber tbody').html('<tr><td colspan="7" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Conta excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir a conta!');
                }
            },
            error: function() {                
                alert('Erro ao tentar excluir a conta!');
            }
        });
    }
}

function visualizar (pIdConta) {
    aguarde();
    $('.infoConta').html('');
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/backend/contaReceberVisualizar.php',
        data: {idContaReceber: pIdConta},
        success: function(html) {
            aguarde(false);
            alert('teste')
            $('.infoConta').html(html);
        },
        error: function() {
            aguarde(false);
            alert('Erro ao tentar exibir as informações da conta!'); 
        }
    });
}