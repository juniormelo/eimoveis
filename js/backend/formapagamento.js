$(document).ready(function() {     
  
    if ($('#txtConsulta').length) {
        $('#txtConsulta').focus();
    }
    
    $('#btnNovo').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=formapagtocad");
    });
    
    $('#btnLista').click(function(){
        $(window.document.location).attr('href',"sistema.php?action=formapagtolista");
    });        
    
    $('#btnSalvar').click(function() {
        var podeExecutar = camposPreenchidos();        
        if (podeExecutar) {
            $('#fmCadPlanoConta').submit();
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
        $('#tblPlanos').hide();
        $('#registros').hide();
        $('#registros').html('');
        $('#tblPlanos tbody').html(''); 
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/planoContasConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json == null) {
                    str_html = '<tr><td colspan="4" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>';
                } else {
                    if (json.status == 'OK') { //tem dados
                        for (i in json.resultados) {
                            seq++;                            
                            str_html = str_html + '<tr id="'+json.resultados[i].idPlanoConta+'"><td>'+seq+'</td><td>'+json.resultados[i].codigo+'</td><td>'+json.resultados[i].descricao+'</td><td><a href="javascript:visualizar('+json.resultados[i].idPlanoConta+')" class="btn btn-xs btn-info"><i class="ace-icon fa fa-search-plus bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="sistema.php?action=planocontacad&idplanoconta='+json.resultados[i].idPlanoConta+'" class="btn btn-xs btn-success"><i class="ace-icon fa fa-pencil bigger-130"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:excluir('+json.resultados[i].idPlanoConta+');" class="btn btn-xs btn-danger"><i class="ace-icon fa fa-trash-o bigger-130"></i></a></td></tr>';
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
                $('#tblPlanos tbody').html(str_html);
                $('#registros').show();
                $('#tblPlanos').show();
                $('.carregando').hide();
            },
            error: function() {                
                $('#registros').html('0 registro(s) encontrado(s).');
                $('#tblPlanos tbody').html('<tr><td colspan="4" align="center"><strong><i>Erro ao tentar exibir os registros!</i></strong></td></tr>');
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
    if (confirm('Deseja realmente excluir o plano de contas?')) {
        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/backend/planoContaExcluir.php',
            data: {id: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblPlanos tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblPlanos tbody tr').length == 0) {
                        $('#tblPlanos tbody').html('<tr><td colspan="4" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Plano de conta excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir o plano de conta!');
                }
            },
            error: function() {
                aguarde(false);
                alert('Erro ao tentar excluir o plano de conta!');
            }
        });
    }
}