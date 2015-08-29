<?php include_once 'app/view/backend/menupadrao.php'; ?>

<div class="main-content">
<form action="javascript: void(0)" id="frmImovelSolicitado" class="formpadrao">    
    <fieldset><h1 style="text-align: center;"><strong>Imóveis solicitados</strong></h1><hr /><br />
    <p><strong>Consultar por:</strong></p>
    <p>&nbsp;&nbsp;
        <strong>UF:</strong>&nbsp;
        <select id="uf" name="uf">
            <option value="0">Todos</option>
            <option>RN</option>
            <option>JP</option>
        </select>&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Interesse:</strong>&nbsp;
        <select id="interesse" name="interesse">
            <option value="0">Todos</option>
            <option>Alugar</option>
            <option>Comprar</option>
            <option>Temporada</option>
        </select>&nbsp;&nbsp;&nbsp;&nbsp;
        <button id="btnConsultar" class="button medium blue" name="btnConsultar"><strong>Consultar</strong></button>
    </p>    
    <br />
    <div id="dados">
        <div id="registros" style="text-align: right;">0 registro(s) encontrado(s).</div>
        <table id="tblImoveis" class="tabelapadrao ajustar">
            <thead>
            <tr>
                <th>#</th>
                <th>Solicitado em</th>
                <th>Interessado</th>
                <th>Interesse</th>
                <th>Imóvel</th>
                <th>UF</th>
                <th>Visitas</th>
                <th width="100">Ações</th>
            </tr>
            </thead>
            <tbody>
                <tr><td colspan="8" align="center">Nenhum registro encontrado.</td></tr>
            </tbody>            
        </table>        
    </div>
    <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
    </fieldset>
    <div id="fundo" style="display: none;">
        <div id="janela" class="grid_12">
            <h1 style="text-align: center;"><strong>Informações do Interessado</strong></h1>
            <a href="javascript:close()"><img width="20" class="close" src="images/delete.png" alt="Fechar" title="Fechar" /></a>
            <div id="corpo"><hr />
                <fieldset>
                    <!--<input type="hidden" id="idCargo" name="idCargo" />
                    <p><label for="descricao">Descrição:</label><input type="text" id="descricao" name="descricao" title="Descrição" class="obrigatorio" size="50" /></p>-->
                </fieldset>
                <div style="text-align: right;">
                    <!--<button id="btnSalvar" class="button medium blue" name="btnSalvar"><strong>Salvar</strong></button>-->
                </div> 
            </div>
        </div>
    </div>
</form>
<script type="text/javascript" src="js/imovelSolicitado.js"></script>

</div>