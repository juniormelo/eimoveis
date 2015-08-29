<?php if (Sessao::temPermissao('imovellista')) : ?>
<form action="javascript: void(0)" id="frmConImovel" class="formpadrao">    
    <fieldset><h1 style="text-align: center;"><strong>Imóveis cadastrados</strong></h1><hr /><br />
    <p><strong>Consultar imóvel:</strong><br />
    <input type="text" id="txtConsulta" name="txtConsulta" size="70" />&nbsp;
    <button id="btnConsultar" class="button medium white" name="btnConsultar"><strong>Consultar</strong></button>&nbsp;&nbsp;&nbsp;
    <button id="btnNovo" class="button medium blue" name="btnNovo"><strong>Novo imóvel</strong></button></p><br />
    <div id="dados">   
        <div id="registros" style="text-align: right;">0 registro(s) encontrado(s).</div>
        <table id="tblImoveis" class="tabelapadrao ajustar">
            <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Categoria</th>
                <th>Descrição</th>
                <th>Cadastro</th>                
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>            
            </tbody>            
        </table>        
    </div>
    <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
    </fieldset>
    <div id="fundo">
        <div id="janela" class="grid_12">
            <h1 style="text-align: center;"><strong>.::Informações do imóvel::.</strong></h1>
            <a href="javascript:close()"><img width="20" class="close" src="images/delete.png" alt="Fechar" title="Fechar" /></a>
            <div id="corpo"><hr />
                <fieldset>
                    <table id="tblInfoImovel" class="tabelapadrao ajustar"></table>
                </fieldset>                
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="js/imovel.js"></script>
<?php endif; ?>