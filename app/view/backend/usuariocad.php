<?php include_once 'app/view/backend/menupadrao.php'; ?>

<div class="main-content">
    
<form id="fmCadUsuario" class="formpadrao" name="fmCadUsuario" method="post" action="javascript:void(0);">
    <fieldset>
        <h1 style="text-align: center;"><strong>Cadastrar usuário</strong></h1><hr /><br />  
        <input type="hidden" id="idUsuario" name="idUsuario">
        <div class="camposInsercao">
            <p>
                <label for="idPessoa">Colaborador:</label>
                <select id="idPessoa" name="idPessoa" class="medium">
                    
                </select>
            </p>
        </div>
        
        <div class="camposInsercao">
            <p><label for="login">Login:</label><input type="text" id="login" name="login" />&nbsp;<span style="color: red; font-weight: bold; font-style: italic;">*O login não poderá ser alterado posteriormente.<span></p>
        </div>
        <p><label for="senha">Senha:</label><input type="password" id="senha" name="senha" /></p>
        <p><label for="confirme">Confirme:</label><input type="password" id="confirme" name="confirme" /></p>        
        <fieldset><legend>Permissões:</legend>
        </fieldset>
    </fieldset>
</form>

<script type="text/javascript" src="js/usuario.js?versao=<?=time()?>"></script>

</div>