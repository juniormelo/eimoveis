$(document).ready(function() {    
    $("#fundo").css({position: 'fixed',width: '100%',height: '100%',top: '0px',left: '0px',background: 'url(images/fund.png)'}).hide();
    $("#janela").css({position: 'absolute',width: '800px',height: '60%',top: '20%',left: '50%',marginLeft: '-400px',backgroundColor: 'white',border: '1px gray solid',borderRadius: '5px',padding: '10px'});            
    $("#corpo").css({overflowY: 'auto',height: '85%'});    
    $(".close").css({position: 'absolute',top: '20px',right: '20px'});
    
    $('#btnNovo').click(function(){
        LimpaCampos();
        criar();
        $('#descricao').focus();
    });       
        
    $('#btnConsultar').click(function(){        
        $('.carregando').show();
        $('#dados').hide();
        $('#registros').html('');
        $('#tblCargos tbody').html('');        
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/cargoConsultar.php',
            data: {consulta: $('#txtConsulta').val()},
            success: function(json) {
                var i = 0, seq = 0, str_html = '';
                if (json.status == 'OK') { //tem dados
                    for (i in json.resultados) {
                        seq++;
                        str_html = str_html + '<tr id="'+json.resultados[i].idCargo+'"><td>'+seq+'</td><td>'+json.resultados[i].descricao+'</td><td><a href="javascript:editar('+json.resultados[i].idCargo+')"><img src="images/editar.png" title="Editar" /></a>&nbsp;&nbsp;<a href="javascript:excluir('+json.resultados[i].idCargo+');"><img src="images/delete.png" title="Excluir" /></a></td></tr>';
                    }
                } else {
                    if (json.status == 'NO') { //vazio
                        str_html = '<tr><td colspan="3" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>';
                    } else {                        
                        str_html = '<tr><td colspan="3" align="center"><strong><i>Erro ao tentar exibir os cargos!</i></strong></td></tr>';
                    }
                }
                $('#registros').html(seq+' registro(s) encontrado(s).');
                $('#tblCargos tbody').html(str_html);
                $('#dados').show();
                $('.carregando').hide();
            },
            error: function() {
                $('#dados').html(msgErro('Erro ao tentar exibir os cargos!'));
                $('#dados').show();
                $('.carregando').hide();
            }
        });
    }).click();
    
    $('#btnSalvar').click(function() {
        var podeExecutar = camposPreenchidos();        
        if (podeExecutar) {
            aguarde();
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'app/control/cargoGravar.php',
                data: $('#frmCargo').serialize(),
                success: function(json) {
                    aguarde(false);
                    if (json == null) {
                        alert('Erro ao tentar salvar o cargo!');
                    } else if (json.status == 'OK') {                        
                        alert('cargo salvo com sucesso!');
                        close();
                    } else {
                        alert('Erro ao tentar salvar o cargo!');
                    }
                },
                error: function() {
                    aguarde(false);
                    alert('Erro ao tentar salvar o cargo!');
                }
            });
        }
    });
    
});

function editar(codigo) {
    aguarde();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'app/control/cargoGetInfoCadastrais.php',
        data: {idCargo: codigo},
        success: function(json) {
            aguarde(false);
            if (json == null) {
                alert('Erro ao tentar carregar as informações do cargo!');
            } else if (json.status == 'OK') {
                $('#idCargo').val(json.resultados[0].idTipo);
                $('#descricao').val(json.resultados[0].descricao);
                $('#descricao').focus();
                criar();
            } else {
                alert('Erro ao tentar carregar as informações do cargo!');
            }
        },
        error: function() {
            aguarde(false);
            alert('Erro ao tentar carregar as informações do cargo!');
        }
    });
}

function excluir(codigo) {
    if (confirm('Deseja realmente excluir o cargo?')) {
        aguarde();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'app/control/cargoExcluir.php',
            data: {idCargo: codigo},
            success: function(json) {
                aguarde(false);
                if (json.status == 'OK') {
                    $('#'+codigo).remove();
                    $('#registros').html($('#tblCargos tbody tr').length+' registro(s) encontrado(s).');
                    if ($('#tblCargos tbody tr').length == 0) {
                        $('#tblCargos tbody').html('<tr><td colspan="3" align="center"><strong><i>Nenhum registro encontrado!</i></strong></td></tr>');
                    }
                    alert('Cargo excluido com sucesso!');
                } else {
                    alert('Erro ao tentar excluir o cargo!');
                }
            },
            error: function() {
                aguarde(false);
                alert('Erro ao tentar excluir o cargo!');
            }
        });
    }
}

function close() {
    $("#fundo").fadeOut(300);
}

function criar() {    
    $("#fundo").fadeIn(300);    
}