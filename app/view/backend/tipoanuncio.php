<?php include_once 'app/view/backend/menupadrao.php'; Sessao::eSuperAdm(); ?>

<div class="main-content">

<form action="javascript: void(0)" id="frmTipoAnuncio" class="formpadrao">    
    <fieldset><h1 style="text-align: center;"><strong>Tipos de Anúncio cadastrados</strong></h1><hr /><br />
    <p><strong>Consultar tipo:</strong><br />
    <input type="text" id="txtConsulta" name="txtConsulta" size="70" />&nbsp;
    <button id="btnConsultar" class="button medium white" name="btnConsultar"><strong>Consultar</strong></button>&nbsp;&nbsp;&nbsp;
    <button id="btnNovo" class="button medium blue" name="btnNovo"><strong>Novo tipo</strong></button></p><br />
    <div id="dados">   
        <div id="registros" style="text-align: right;">0 registro(s) encontrado(s).</div>
        <table id="tblTipos" class="tabelapadrao ajustar">
            <thead>
            <tr>
                <th>#</th>
                <th>Descrição</th>                
                <th width="100">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="3" align="center">Nenhum registro encontrado</td>
            </tr>
            </tbody>            
        </table>        
    </div>
    <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
    </fieldset>
    <div id="fundo">
        <div id="janela" class="grid_12">
            <h1 style="text-align: center;"><strong>.::Cadastrar tipo::.</strong></h1>
            <a href="javascript:close()"><img width="20" class="close" src="images/delete.png" alt="Fechar" title="Fechar" /></a>
            <div id="corpo"><hr />
                <fieldset>
                    <input type="hidden" id="idTipo" name="idTipo" />
                    <p><label for="descricao">Descrição:</label><input type="text" id="descricao" name="descricao" title="Descrição" class="obrigatorio" title="Descrição" size="50" /></p>                    
                </fieldset>
                <div style="text-align: right;">
                    <button id="btnSalvar" class="button medium blue" name="btnSalvar"><strong>Salvar</strong></button>
                </div> 
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="js/tipoAnuncio.js"></script>

</div>