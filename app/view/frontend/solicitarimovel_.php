<div class="breadcrumbs">
    <div class="bread-top">
        <h2><strong>Solicite um imóvel de sua preferência</strong></h2>
        <span class="left"><a href="index.php">Home &rArr;</a></span>
        <span>Solicitação de imóvel</span>
    </div>
</div>
<section id="content">
    <h3 style="text-align: center; font-weight: bold;">Descreva um imóvel de acordo com as suas necessidades</h3>
    <form action="javascript:void(0);" id="formSolicitarImovel" class="contactForm">
        <div id="msg"></div>
        <h3>Contato:</h3>
        <p>
            <input type="hidden" id="x" name="x" />
            <input type="text" id="nome" name="nome" value="Nome" onblur="if (this.value == ''){this.value = 'Nome'; }" onfocus="if (this.value == 'Nome') {this.value = '';}" >&nbsp;&nbsp;
            <input type="text" id="telefone" class="telefone" name="telefone" value="Telefone" onblur="if (this.value == ''){this.value = 'Telefone'; }" onfocus="if (this.value == 'Telefone') {this.value = '';}">&nbsp;&nbsp;
            <input type="text" id="email" name="email" value="E-mail" onblur="if (this.value == ''){this.value = 'E-mail'; }" onfocus="if (this.value == 'E-mail') {this.value = '';}">
        </p>
        <h3>Localização desejada:</h3>
        <p>
            <input type="text" id="cidade_" name="cidade" value="Cidade(s)" onblur="if (this.value == ''){this.value = 'Cidade(s)'; }" onfocus="if (this.value == 'Cidade(s)') {this.value = '';}" >&nbsp;&nbsp;
            <input type="text" id="bairro" name="bairro" value="Bairro(s)" onblur="if (this.value == ''){this.value = 'Bairro(s)'; }" onfocus="if (this.value == 'Bairro(s)') {this.value = '';}">&nbsp;&nbsp;
            <select id="uf_" name="uf">
                <option value="0">Estado</option><option value="AC">AC</option><option value="AL">AL</option><option value="AM">AM</option>
                <option value="AP">AP</option><option value="BA">BA</option><option value="CE">CE</option>
                <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                <option value="MA">MA</option><option value="MG">MG</option><option value="MS">MS</option>
                <option value="MT">MT</option><option value="PA">PA</option><option value="PB">PB</option>
                <option value="PE">PE</option><option value="PI">PI</option><option value="PR">PR</option>
                <option value="RJ">RJ</option><option value="RN">RN</option><option value="RO">RO</option>
                <option value="RR">RR</option><option value="RS">RS</option><option value="SC">SC</option>
                <option value="SE">SE</option><option value="SP">SP</option><option value="TO">TO</option>
            </select>
        </p>
        <h3>Valor entre:</h3>
        <p>
            <input type="text" id="valorMin" class="decimal" name="valorMin" value="R$ 0,00" onblur="if (this.value == ''){this.value = 'R$ 0,00'; }" onfocus="if (this.value == 'R$ 0,00') {this.value = '';}" >
            &nbsp;&nbsp;<strong>a</strong>&nbsp;&nbsp;&nbsp;<input type="text" id="valorMax" class="decimal" name="valorMax" value="R$ 0,00" onblur="if (this.value == ''){this.value = 'R$ 0,00'; }" onfocus="if (this.value == 'R$ 0,00') {this.value = '';}">
        </p>
        <h3>Tipo do imóvel:</h3>
        <p>
            <span style="font-weight: bold; color: blue;">Casa, terreno, apartamento etc.</span><br />
            <input type="text" id="imovel" name="imovel" value="imóvel" onblur="if (this.value == ''){this.value = 'imóvel'; }" onfocus="if (this.value == 'imóvel') {this.value = '';}" >&nbsp;&nbsp;
            <select id="finalidade_" name="finalidade">
                <option value="F">Finalidade</option>
                <option value="A">Alugar</option>
                <option value="C">Comprar</option>
                <option value="T">Temporada</option>
            </select>
        </p>
        <h3>Caracteristicas do imóvel:</h3>
        <p><textarea id="descricao" name="descricao" rows="10" cols="20" onblur="if (this.value == ''){this.value = 'Descreva as características do imóvel'; }" onfocus="if (this.value == 'Descreva as características do imóvel') {this.value = '';}">Descreva as características do imóvel</textarea></p>
        <p><input id="btnSolicitar" type="submit" name="submit" class="submit" value="Solicitar"></p>
    </form>
</section>
<?php include_once 'app/view/frontend/barralateral.php'; ?>