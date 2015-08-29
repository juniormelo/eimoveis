<?php
    $dataAtual = Utilitarios::getDataServidor();
?>
<form action="javascript: void(0)" id="frmlogVisitasPortal" class="formpadrao">    
    <fieldset><h1 style="text-align: center;"><strong>Log de visitas</strong></h1><hr /><br />
        <fieldset><br />
            <label for="dataIni"><strong>Inicio:</strong></label><input type="text" id="dataIni" name="dataIni" class="data" value="<?=$dataAtual?>" />&nbsp;&nbsp;
            <label for="dataFim"><strong>Fim:</strong></label><input type="text" id="dataFim" name="dataFim" class="data" value="<?=$dataAtual?>" />&nbsp;&nbsp;&nbsp;
        <button id="btnConsultar" class="button medium white" name="btnConsultar"><strong>Consultar</strong></button>&nbsp;&nbsp;
        <button id="btnImprimir" class="button medium blue" name="btnImprimir"><strong>Imprimir log</strong></button></p>
        </fieldset>
    <div id="dados">   
        <div id="registros" style="text-align: right;">0 registro(s) encontrado(s).</div>
        <table id="tblLog" class="tabelapadrao ajustar">
            <thead>
            <tr>
                <th>#</th>
                <th>Data - Hora</th>
                <th>Visitante (IP)</th>
                <th>Visitas</th>                
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="4" align="center">Nenhum registro encontrado</td>
            </tr>
            </tbody>            
        </table>        
    </div>
    <div class="carregando"><img src="images/ajax-loader.gif"><br />carregando...</div>
    </fieldset>    
</form>
<script type="text/javascript" src="js/logvisitasportal.js"></script>