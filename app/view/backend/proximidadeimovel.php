<?php include_once 'app/view/backend/menupadrao.php'; Sessao::eSuperAdm(); ?>
<div class="main-content">
<form action="javascript: void(0)" id="frmProximidade" class="formpadrao">    
    <fieldset><h1 style="text-align: center;"><strong>Proximidade de imóveis cadastrados</strong></h1><hr /><br />
    <p><strong>Consultar proximidade:</strong><br />
    <input type="text" id="txtConsulta" name="txtConsulta" size="70" />&nbsp;
    <button id="btnConsultar" class="button medium white" name="btnConsultar"><strong>Consultar</strong></button>&nbsp;&nbsp;&nbsp;
    <button id="btnNovo" class="button medium blue" name="btnNovo"><strong>Nova proximidade</strong></button></p><br />
    <div id="dados">
        <div id="registros" style="text-align: right;">0 registro(s) encontrado(s).</div>
        <table id="tblProximidades" class="tabelapadrao ajustar">
            <thead>
            <tr>
                <th>#</th>
                <th>Descrição</th>                
                <th width="100">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr><td colspan="3" align="center">Nenhum registro encontrado</td></tr>
            </tbody>            
        </table>        
    </div>
    <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
    </fieldset>
    <div id="fundo" style="display: none;">
        <div id="janela" class="grid_12">
            <h1 style="text-align: center;"><strong>Proximidade</strong></h1>
            <a href="javascript:close()"><img width="20" class="close" src="images/delete.png" alt="Fechar" title="Fechar" /></a>
            <div id="corpo"><hr />
                <fieldset>
                    <input type="hidden" id="idProximidade" name="idProximidade" />
                    <p><label for="descricao">Descrição:</label><input type="text" id="descricao" name="descricao" title="Descrição" class="obrigatorio" size="50" /></p>                    
                </fieldset>
                <div style="text-align: right;">
                    <button id="btnSalvar" class="button medium blue" name="btnSalvar"><strong>Salvar</strong></button>
                </div> 
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="js/proximidadeImovel.js"></script>
</div>