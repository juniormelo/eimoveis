$(document).ready(function(){
    $.mask.definitions['~']='[+-]';
    $('.data').mask('99/99/9999');
    $('.telefone').mask('(99) 9999-9999');
    $('.cep').mask('99.999-999');    
    
    $('#txtConsulta').keypress(function(e){        
       var tecla = (e.keyCode?e.keyCode:e.which);       
       if(tecla == 13){
           $('#btnConsultar').click();
       }       
    });    
});

function SomenteNumero(e) {
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) {
        return true;
    } else {
        if (tecla==8 || tecla==0){ 
            return true; 
        } else {
            return false;
        }
    }
}

function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e) {
    $("input#"+objTextBox.id).css("text-align","right");
    var key = '';
    var i = k = 0;
    var len = len2 = 0;
    var strCheck = '0123456789-';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if (whichCode == 13) return true;
    if (whichCode == 9) return true; // TAB do IE
    if (whichCode == 0) return true; // TAB do Firefox =/
    if (whichCode == 8) return true; // BACKSPACE
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal))
            break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (k = 0, i = len - 3; i >= 0; i--) {
            if (k == 3) {
                aux2 += SeparadorMilesimo;
                k = 0;
            }
            aux2 += aux.charAt(i);
            k++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}

function converteToFloat(valorString){
    var convertido = valorString.replace(".", "");
    while(convertido.indexOf(".") > 0)
        convertido = convertido.replace(".", "");
    convertido = convertido.replace(",", ".");
    return new Number(convertido).toFixed(2);
}

function removeMascara(texto){
    var tam = texto.length
    var novo = texto;
    for(i=0; i<tam; i++){
        novo = novo.replace('.', '');
        novo = novo.replace(',', '');
        novo = novo.replace('/', '');
        novo = novo.replace('-', '');
    }
    return novo;
}

function cpf_cnpj_valido(cpf_cnpj) {
    cpf_cnpj = cpf_cnpj.replace(/\./g, "");
    cpf_cnpj = cpf_cnpj.replace(/\-/g, "");
    cpf_cnpj = cpf_cnpj.replace(/\_/g, "");
    cpf_cnpj = cpf_cnpj.replace(/\//g, "");
    
    if (cpf_cnpj.length > 11) {
        return valida_cnpj(cpf_cnpj);
    } else {
        return validar_cpf(cpf_cnpj);
    }
}

function validar_cpf(cpf) {
    cpf = cpf.replace(/\./g, "");
    cpf = cpf.replace(/\-/g, "");
    cpf = cpf.replace(/\_/g, "");
    cpf = cpf.replace(/\//g, "");    
    var numeros, digitos, soma, i, resultado, digitos_iguais;
    digitos_iguais = 1;
    if (cpf.length < 11)
        return false;
    for (i = 0; i < cpf.length - 1; i++) {            
        if (cpf.charAt(i) != cpf.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    }
    if (!digitos_iguais) {
        numeros = cpf.substring(0,9);
        digitos = cpf.substring(9);
        soma = 0;
        for (i = 10; i > 1; i--)
                soma += numeros.charAt(10 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(0))
                return false;
        numeros = cpf.substring(0,10);
        soma = 0;
        for (i = 11; i > 1; i--)
                soma += numeros.charAt(11 - i) * i;
        resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
        if (resultado != digitos.charAt(1))
                return false;
        return true;
    } else {
        return false;
    }        
}

function valida_cnpj(cnpj){
    //Limpa pontos e Traços da string
    cnpj = cnpj.replace(/\./g, "");
    cnpj = cnpj.replace(/\-/g, "");
    cnpj = cnpj.replace(/\_/g, "");
    cnpj = cnpj.replace(/\//g, "");
    
    var result = true;
    
    if(cnpj.length!=14){ 
        result = false; 
    }

    pri = eval(cnpj.substring(0,2));
    seg = eval(cnpj.substring(3,6));
    ter = eval(cnpj.substring(7,10));
    qua = eval(cnpj.substring(11,15));
    qui = eval(cnpj.substring(16,18));

    var i;
    var numero;
    var situacao = "";

    numero = (pri+seg+ter+qua+qui);

    s = numero;

    c = cnpj.substr(0,12);
    var dv = cnpj.substr(12,2);
    var d1 = 0;

    for (i = 0; i < 12; i++){
        d1 += c.charAt(11-i)*(2+(i % 8));
    }

    if (d1 == 0){
        result = false;
    }
    
    d1 = 11 - (d1 % 11);

    if (d1 > 9) {
        d1 = 0;
    }

    if (dv.charAt(0) != d1){
        result = false;
    }

    d1 *= 2;
    for (i = 0; i < 12; i++){
    d1 += c.charAt(11-i)*(2+((i+1) % 8));
    }

    d1 = 11 - (d1 % 11);
    if (d1 > 9) {
        d1 = 0;
    }

    if (dv.charAt(1) != d1) {
        result = false;
    }

    if (result == false) {
        //alert("CNPJ inválido!");
        return false;
    } else {
        return true;
        //alert("CNPJ Verdadeiro!");
    }
}

function camposPreenchidos() {
    var registroId = 0;
    $('.obrigatorio').each(function () {
        if (registroId == 0) {
            if($.trim($(this).val()) == '') {
                alert('O campo "'+$(this).attr('title')+'" é obrigatorio!');
                $(this).focus();
                registroId = registroId+1;
            }
        }
    });    
    if (registroId > 0) {
        return false;
    } else {
        return true;
    }
}

function getEndereco(idCep,idLogradouro,idBairro,idCidade,idEstado,idPais,divMsg) {
    try {        
        idCep = $("#"+idCep).val();
       
        if($.trim(idCep) != "" && $.trim(idCep) != "__.___-___") {
            if (divMsg != null) {
                $("#"+divMsg).html('<span class="badge badge-success"><strong>&nbsp;Aguarde, buscando cep ...&nbsp;&nbsp;</strong> </span>');
            }
            //aguarde('Localizando endereço...');
            $.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$.trim(idCep), function(){                            
            if(unescape(resultadoCEP["cidade"]) != '') {
                //alert('deu certo');
                $("#"+idLogradouro).val(unescape(resultadoCEP["tipo_logradouro"])+" "+unescape(resultadoCEP["logradouro"]));
                $("#"+idBairro).val((unescape(resultadoCEP["bairro"]) == '') ? 'Centro' : unescape(resultadoCEP["bairro"]));
                $("#"+idCidade).val(unescape(resultadoCEP["cidade"]));
                $("#"+idEstado).val(unescape(resultadoCEP["uf"]));
                $("#"+idPais).val('Brasil');                
                if (divMsg != null) {
                    $("#"+divMsg).html('');
                }
            } else {
                if (divMsg != null) {
                    $("#"+divMsg).html('<span class="badge badge-yellow"><strong>&nbsp;CEP inválido ou Endereço não localizado.&nbsp;&nbsp;</strong> </span>');
                }
                //alert("Endereço não localizado!");
                $("#"+idCep).focus();
            }
            });            
        }        
    } catch(e) {
        if (divMsg != null) {
            $("#"+divMsg).html('<span class="badge badge-danger"><strong>&nbsp;Erro ao tentar localizar o cep. Tente novamente.&nbsp;&nbsp;</strong> </span>');
        }
        //alert('Erro ao tentar buscar o cep!');
        $("#"+idLogradouro).focus();
    }    
}

function close() {
    $('#janelaModal').fadeOut(300);
}

function LimpaCampos(idForm) {    
    if(idForm != null){        
        $('#'+idForm).find('input').val('');
        $('#'+idForm).find('textarea').val('');
    }else{
        $('input').val('');
        $('textarea').val('');
    }
}

function SomenteNumero(e){
    var tecla=(window.event)?event.keyCode:e.which;   
    if((tecla>47 && tecla<58)) return true;
    else{
    	if (tecla==8 || tecla==0) return true;
	else  return false;
    }
}

function msgErro(msg) {        
    return ($.trim(msg) == '' || msg == null) ? '<div class="alert red_alert"><p>Erro!</p></div>' : '<div class="alert red_alert"><p>'+msg+'</p></div>';
}

function msgSucesso(msg) {
    return ($.trim(msg) == '' || msg == null) ? '<div class="alert green_alert"><p>Sucesso!</p></div>' : '<div class="alert green_alert"><p>'+msg+'</p></div>';
}

function msgConfirme(msg) {
    return ($.trim(msg) == '' || msg == null) ? '<div class="alert blue_alert"><p>Confirmação!</p></div>' : '<div class="alert blue_alert"><p>'+msg+'</p></div>';
}

function msgAlerta(msg) {
    return ($.trim(msg) == '' || msg == null) ? '<div class="alert yellow_alert"><p>Atenção!</p></div>' : '<div class="alert yellow_alert"><p>'+msg+'</p></div>';
}

function aguarde(msg,status) {
    /*if (msg == false || status == false) {
        $('#carregGeral').hide();                
    } else {
        if (msg == null || $.trim(msg) == '') {
            $('#carregGeral p').html('Carregando...');
            $('#carregGeral').show();
        } else {
            $('#carregGeral p').html(msg);
            $('#carregGeral').show();
        }
    }*/
}

function dataValida(digData) {
    //if (digData != '') {
        var bissexto = 0;
        var data = digData; 
        var tam = data.length;
        if (tam == 10) {
            var dia = data.substr(0,2)
            var mes = data.substr(3,2)
            var ano = data.substr(6,4)
            if ((ano > 1900)||(ano < 2100)) {
                switch (mes) {
                    case '01':
                    case '03':
                    case '05':
                    case '07':
                    case '08':
                    case '10':
                    case '12':if (dia <= 31) {return true;}
                    break

                    case '04':
                    case '06':
                    case '09':
                    case '11':if (dia <= 30) {return true;}
                    break

                    case '02':
                            /* Validando ano Bissexto / fevereiro / dia */ 
                            if ((ano % 4 == 0) || (ano % 100 == 0) || (ano % 400 == 0)) {bissexto = 1;} 
                            if ((bissexto == 1) && (dia <= 29)) {return true;} 
                            if ((bissexto != 1) && (dia <= 28)) {return true;}
                    break
                }
            }
        }
        //alert("A data informada é inválida!");
        return false;
    //}
}

function emailValido(email){
    var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
    var check=/@[\w\-]+\./;
    var checkend=/\.[a-zA-Z]{2,3}$/;
    if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
    else {return true;}
}

function aplicaEstiloTagFile() {
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
}