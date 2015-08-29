<?php
    $util = new Utilitarios();
    $cnx = Conf::pegCnxPadrao();
    $imovel = new Imovel($cnx);
    $proprietario = new Pessoa($cnx);
    $pTerceiro = false;
    $ePessoaFisica = false;
    $titulo = 'Cadastrar imóvel';
    if (isset ($_GET['idimovel'])) {
        $titulo = 'Editar imóvel';
        $idImovel = (int) $_GET['idimovel'];
        $imovel->setIdImovel($idImovel);        
        $imovel->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
        $imovel->preencheObjeto();
        $idImovel = $imovel->getIdImovel();        
        if ($imovel->getIdPessoaProprietario() != $imovel->getIdProprietarioImovel()) {
            $proprietario->_preecheObjeto($imovel->getIdProprietarioImovel());
            $pTerceiro = true;
            $ePessoaFisica = ($proprietario->getTipo() == 'F') ? true : false ;            
        }
        $imovelCarac = new ImovelCaracteristica($cnx);
        $imovelCarac->setIdImovel($idImovel);
        $dsetCaracteristicas = $imovelCarac->getCaracteristicas();
        
        $imovelProx = new ImovelProximidade($cnx);
        $imovelProx->setIdImovel($idImovel);
        $dsetProx = $imovelProx->getProximidades();        
        
        $imovelFoto = new ImovelFoto($cnx);
        $imovelFoto->setIdImovel($idImovel);
        $dsetFoto = $imovelFoto->getFotos();        
    }    
?>
<form id="fmCadImovel" class="formpadrao" name="fmCadImovel" method="post" enctype="multipart/form-data" action="app/control/imovelGravar.php">
    <fieldset>
    <h1 style="text-align: center;"><strong><?=$titulo?></strong></h1><hr /><br />
    <div id="tab">
        <ul class="nav">
            <li class="nav-two"><a href="#informacoes" class="current"><strong>Informações</strong></a></li>
            <li class="nav-three"><a href="#endereco"><strong>Endereço</strong></a></li>
            <li class=""><a href="#caracteristicas"><strong>Caracteristicas</strong></a></li>
            <li class=""><a href="#proximidade"><strong>Proximidades</strong></a></li>
            <li class="nav-four last"><a href="#imagens"><strong>Imagens</strong></a></li>
            <li class="nav-four last"><a href="#proprietario"><strong>Proprietário</strong></a></li>
        </ul>
        <div class="abas">    
            <div id="informacoes">
                <?php if (isset ($_GET['idimovel'])) : ?>
                <input type="hidden" id="idImovel" name="idImovel" value="<?= $imovel->getIdImovel(); ?>" />
                <?php endif; if ($imovel->get_codigo() != '') :?>                
                <p><label>Código: </label><input type="text" id="codigo" class="" name="codigo" title="Código" value="<?= $imovel->get_codigo(); ?>" readonly="" disabled="" /></p>
                <?php endif;?>
                <p><label>Categoria: </label><select id="idCategoria" class="medium" name="idCategoria">
                    <option value="-1">-- Selecione uma categoria --</option>
                    <?php
                        $categoria = new ImovelCategoria(Conf::pegCnxPadrao());
                        $util->preencheComboDB($categoria->getCadastradas(),$imovel->getIdCategoria());
                    ?>
                </select></p>
                <p><label>Descrição: </label><input type="text" id="descricao" class="medium obrigatorio" name="descricao" title="Descrição" value="<?= $imovel->getDescricao(); ?>" /></p>
                <!--<p><label>Área (m²): </label><input type="text" id="area" name="area" title="Área" value="<?php //$imovel->getArea(); ?>" /></p>-->
                <p><label>Observações: </label><textarea id="observacao" name="observacao" rows="5" cols="50" ><?= $imovel->getObservacao(); ?></textarea></p>
            </div>
            <div id="endereco" class="hide">        
                <p><label>Cep: </label><input type="text" id="cep" class="cep" name="cep" value="<?=$imovel->getCep();?>" onBlur="getEndereco('cep','logradouro','bairro','cidade','uf','pais')" /></p>
                <p><label>Logradouro: </label><input type="text" id="logradouro" class="medium" name="logradouro" value="<?= $imovel->getLogradouro(); ?>" /></p>
                <p><label>Número: </label><input type="text" id="numLogradouro" class="medium" name="numLogradouro" value="<?= $imovel->getNumLogradouro(); ?>" /></p>
                <p><label>Complemento: </label><input type="text" id="complemento" class="medium" name="complemento" value="<?= $imovel->getComplemento(); ?>" /></p>
                <p><label>Bairro: </label><input type="text" id="bairro" class="medium" name="bairro" value="<?= $imovel->getBairro(); ?>" /></p>
                <p><label>Cidade: </label><input type="text" id="cidade" class="medium" name="cidade" value="<?= $imovel->getCidade(); ?>" /></p>
                <p><label>UF: </label><select id="uf" name="uf">
                    <option value="AC">AC</option><option value="AL">AL</option><option value="AM">AM</option>
                    <option value="AP">AP</option><option value="BA">BA</option><option value="CE">CE</option>
                    <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                    <option value="MA">MA</option><option value="MG">MG</option><option value="MS">MS</option>
                    <option value="MT">MT</option><option value="PA">PA</option><option value="PB">PB</option>
                    <option value="PE">PE</option><option value="PI">PI</option><option value="PR">PR</option>
                    <option value="RJ">RJ</option><option value="RN">RN</option><option value="RO">RO</option>
                    <option value="RR">RR</option><option value="RS">RS</option><option value="SC">SC</option>
                    <option value="SE">SE</option><option value="SP">SP</option><option value="TO">TO</option>
               </select></p>
               <p><label>País: </label><input type="text" id="pais" class="medium" name="pais" value="<?= $imovel->getPais(); ?>" /></p>
               <p><label>Referência: </label><input type="text" id="pontoReferencia" class="medium" name="pontoReferencia" value="<?= $imovel->getPontoReferencia(); ?>" /></p>
          </div>          
          <div id="caracteristicas" class="hide">
              <p><label>Caracteristica:</label><select id="idCaracteristica" class="medium" >
                  <option value="-1"> -- Selecione uma caracteristica -- </option>
                  <?php
                    $caracteristica = new ImovelCaracteristicaTipo(Conf::pegCnxPadrao());
                    $util->preencheComboDB($caracteristica->getCadastradas());
                  ?>
              </select></p>
              <input type="hidden" id="seqCaracteristica" name="seqCaracteristica" />
              <p><label>Descrição:</label><input type="text" id="desCaracteristica" class="medium" name="desCaracteristica" />&nbsp;&nbsp;<button type="button" id="btnAddCaracteristica" class="button medium green" name="btnAddCaracteristica"><strong>Adicionar</strong></button></p><br />
              <table id="tblCaracteristicas" class="tabelapadrao ajustar">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Caracteristica</th>
                          <th>Descrição</th>
                          <th>Excluir</th>
                      </tr>
                  </thead>                  
                  <tbody>
                      <?php  if (isset ($_GET['idimovel'])) { if (sizeof($dsetCaracteristicas) > 0) { $i = 1; foreach ($dsetCaracteristicas as $linha) { ?>
                      <tr id="<?=$linha['idCaracteristica'];?>"><td><?=$i++;?></td><td><input type="hidden" name="idCaracteristica[]" value="<?= $linha['idCaracteristica']; ?>" /><?= $linha['caracteristica']; ?></td><td><input type="hidden" name="caracteristica[]" value="<?=utf8_encode($linha['descricao']);?>" /><?=$linha['descricao'];?></td><td><img style="cursor: pointer;" src="images/delete.png" title="Excluir"/></td></tr>
                      <?php }}} else { ?>
                      <tr><td colspan="4" align="center"><strong><i>Nenhuma caracteristica cadastrada!</i></strong></td></tr>
                      <?php } ?>
                  </tbody>
              </table>
          </div>
          <div id="proximidade" class="hide">
              <p><label>Proximidade:</label><select id="idProximidade" class="medium" >
                  <option value="-1"> -- Selecione uma proximidade -- </option>
                  <?php
                    $proximidade = new ImovelProximidadeTipo(Conf::pegCnxPadrao());
                    $util->preencheComboDB($proximidade->getCadastradas());
                  ?>
              </select></p>
              <input type="hidden" id="seqProximidade" name="seqProximidade" />
              <p><label>Descrição:</label><input type="text" id="desProximidade" class="medium" name="desProximidade" />&nbsp;&nbsp;<button type="button" id="btnAddProximidade" class="button medium green" name="btnAddProximidade"><strong>Adicionar</strong></button></p><br />
              <table id="tblProximidades" class="tabelapadrao ajustar">
                  <thead>
                      <tr>
                          <th>#</th>
                          <th>Proximidade</th>
                          <th>Descrição</th>
                          <th>Excluir</th>
                      </tr>
                  </thead>                  
                  <tbody>
                      <?php  if (isset ($_GET['idimovel'])) { if (sizeof($dsetProx) > 0) { $i = 1; foreach ($dsetProx as $linhaProx) { ?>
                      <tr id="<?= $linhaProx['idProximidade'] ?>"><td><?= $i++; ?></td><td><input type="hidden" name="idProximidade[]" value="<?= $linhaProx['idProximidade'] ?>" /><?= $linhaProx['proximidade']; ?></td><td><input type="hidden" name="proximidade[]" value="<?= utf8_encode($linhaProx['descricao']) ?>" /><?= $linhaProx['descricao'] ?></td><td><img style="cursor: pointer;" src="images/delete.png" title="Excluir"/></td></tr>
                      <?php }}} else { ?>
                      <tr><td colspan="4" align="center"><strong><i>Nenhuma proximidade cadastrada!</i></strong></td></tr>
                      <?php } ?>
                  </tbody>
              </table>
          </div>
          <div id="imagens" class="hide">
              <p>
                  <span style="color: red; font-weight: bold;">(*) - Insira as imagens do imóvel com extenção ".jpg" com até 2Mb.</span><br/>
                  <span style="color: blue; font-weight: bold;">(*) - A imagem com a menor ordem será considerada como principal no portal.</span><br/>
              </p>
              <table id="tblImagens" class="tabelapadrao ajustar">
                  <thead>
                      <tr><th><strong>Ordem</strong></th><th><strong>Imagem</strong></th><th><strong>Descrição</strong></th><th><strong>Excluir</strong></th></tr>
                  </thead>
                  <tbody>
                      <?php  if (isset ($_GET['idimovel'])) { if (sizeof($dsetFoto) > 0) { foreach ($dsetFoto as $linhaFoto) { ?>
                      <tr>                          
                          <td width="10"><input type="hidden" name="codImgCad[]" value="<?= $linhaFoto['idFoto'] ?>" /><input type="hidden" name="nomeImgCad[]" value="<?= $linhaFoto['foto'] ?>" /><input type="text" name="ordemImgCad[]" value="<?= $linhaFoto['ordem'] ?>"/></td>
                          <td width="378"  style="text-align: center;"><img src="images/upload/<?= $linhaFoto['foto'] ?>" width="125" height="100" /></td>
                          <td width="280"><input type="text" name="descImgCad[]" value="<?= $linhaFoto['descricao'] ?>"/></td>                          
                          <td><img style="cursor: pointer;" src="images/delete.png" title="Excluir"/></td>
                      </tr>
                      <?php } } } ?>
                      <tr>
                          <td width="10"><input type="hidden" name="codImg[]" value="0" /><input type="hidden" name="nomeImg[]" value="i_img_nv" /><input type="text" name="ordemImg[]" value="1"/></td>
                          <td width="378"><input type="file" name="img[]" /></td>
                          <td width="280"><input type="text" name="descImg[]" /></td>                          
                          <td><img style="cursor: pointer;" src="images/delete.png" title="Excluir"/></td>
                      </tr>                      
                  </tbody>
              </table>
              <div style="text-align: right; padding: 0px;"><hr />
                  <!--<button type="button" id="btnVisualizarImg" class="button medium green" name="btnVisualizarImg"><strong>Visualizar imagens</strong></button>-->
                  <button type="button" id="btnAddImg" class="button medium green" name="btnAddImg"><strong>Adicionar</strong></button>
              </div><br />
          </div>
          <div id="proprietario" class="hide">
              <fieldset><legend>&nbsp;&nbsp;<strong>Quem é o proprietário?</strong></legend>
                  <input type="radio" id="terceiro" name="tipoProprietario" <?=($pTerceiro) ? 'checked="checked"' : ''?> value="t" /><label for="terceiro">Terceiro</label><br />
                  <input type="radio" id="proprio" name="tipoProprietario" <?=(!$pTerceiro) ? 'checked="checked"' : ''?>  value="p" /><label for="proprio"><?=$_SESSION['razao']?></label><br />
              </fieldset>              
              <div id="dadosProprietario">
                  <fieldset><legend>&nbsp;&nbsp;<strong>Natureza?</strong></legend>
                      <input type="radio" id="fisica" class="tipo" name="tipo" <?=($ePessoaFisica) ? 'checked="checked"' : ''?> value="f"/><label for="fisica">Pessoa Fisica</label><br />
                      <input type="radio" id="juridica" class="tipo" name="tipo" <?=(!$ePessoaFisica) ? 'checked="checked"' : ''?> value="j"/><label for="juridica">Pessoa Juridica</label><br /><br />
                  </fieldset>
                  <fieldset><legend>&nbsp;&nbsp;Dados pessoais:</legend>
                      <input type="hidden" id="idPessoa" name="idPessoa" value="<?=$proprietario->getIdPessoa()?>" />
                      <p id="lblCpf"><label for="cpf_cnpj">CPF:</label><input type="text" id="cpf_cnpj" name="cpf_cnpj" class="" value="<?=$proprietario->getCpf_cnpj()?>" title="CPF" onblur="localizarPessoa()"/></p>
                      <p id="lblRazao"><label for="razao">Nome:</label><input type="text" id="razao" class="medium" name="razao" value="<?=$proprietario->getRazao()?>" maxlength="100" /></p>
                      <p id="lblFantasia"><label for="fantasia">Apelido:</label><input type="text" id="fantasia" class="medium" name="fantasia" value="<?=$proprietario->getFantasia()?>" maxlength="100" /></p>
                      <p id="lblRg"><label for="rg_ie">RG:</label><input type="text" id="rg_ie" class="medium" name="rg_ie" value="<?=$proprietario->getRg_ie()?>" maxlength="14" /></p>
                      <p id="lblNascimento"><label for="dtNascimento">Nascimento:</label><input type="text" id="dtNascimento" class="medium data" name="dtNascimento" value="<?=$util->formataData_DiaMesAno(str_replace('//', '', $proprietario->getDtNascimento()))?>" /></p>
                      <p id="lblGenero"><label for="genero">Sexo:</label><select id="genero" class="medium" name="genero">
                          <option value="M">Masculino</option>        
                          <option value="F">Feminino</option>        
                      </select></p>
                      <p id="lblEstadoCivil"><label for="estadoCivil">Estado civil:</label><select id="idEstadoCivil" class="medium" name="idEstadoCivil">                              
                      <?php
                        $estadoCivil = new EstadoCivil(Conf::pegCnxPadrao());
                        $util->preencheComboDB($estadoCivil->getCadastrados(),$proprietario->getIdEstadoCivil());
                      ?>
                      </select></p>                      
                  </fieldset>
                  <fieldset><legend>&nbsp;&nbsp;Contato:</legend>
                      <p><label for="telefone">Telefone:</label><input type="text" id="telefone" class="telefone" name="telefone" value="<?=$proprietario->getTelefone()?>" maxlength="15" /></p>
                      <p><label for="fax">Fax:</label><input type="text" id="fax" class="telefone" name="fax" value="<?=$proprietario->getFax()?>" maxlength="15" /></p>
                      <p><label for="celular">Celular:</label><input type="text" id="celular" class="telefone" name="celular" value="<?=$proprietario->getCelular()?>" maxlength="15" /></p>             
                      <p><label for="email">E-mail:</label><input type="text" id="email" class="medium" name="email" value="<?=$proprietario->getEmail()?>" maxlength="50" /></p>
                      <p><label for="site">Site:</label><input type="text" id="site" class="medium" name="site" value="<?=$proprietario->getSite()?>" maxlength="50" /></p>
                  </fieldset>
                  <fieldset><legend>&nbsp;&nbsp;Dados de endereço:</legend>
                      <p><label>Cep: </label><input type="text" id="proCep" class="cep" name="proCep" value="<?=$proprietario->getCep()?>" onBlur="getEndereco('proCep','proLogradouro','proBairro','proCidade','proUf','proPais')" /></p>
                      <p><label>Logradouro: </label><input type="text" id="proLogradouro" class="medium" name="proLogradouro" value="<?=$proprietario->getLogradouro()?>"  /></p>
                      <p><label>Número: </label><input type="text" id="proNumLogradouro" class="medium" name="proNumLogradouro" value="<?=$proprietario->getNumLogradouro()?>" /></p>
                      <p><label>Complemento: </label><input type="text" id="proComplemento" class="medium" name="proComplemento" value="<?=$proprietario->getComplemento()?>" /></p>
                      <p><label>Bairro: </label><input type="text" id="proBairro" class="medium" name="proBairro" value="<?=$proprietario->getBairro()?>" /></p>
                      <p><label>Cidade: </label><input type="text" id="proCidade" class="medium" name="proCidade" value="<?=$proprietario->getCidade()?>" /></p>
                      <p><label>UF: </label><select id="proUf" name="proUf">
                              <option value="AC">AC</option><option value="AL">AL</option><option value="AM">AM</option>
                              <option value="AP">AP</option><option value="BA">BA</option><option value="CE">CE</option>
                              <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                              <option value="MA">MA</option><option value="MG">MG</option><option value="MS">MS</option>
                              <option value="MT">MT</option><option value="PA">PA</option><option value="PB">PB</option>
                              <option value="PE">PE</option><option value="PI">PI</option><option value="PR">PR</option>
                              <option value="RJ">RJ</option><option value="RN">RN</option><option value="RO">RO</option>
                              <option value="RR">RR</option><option value="RS">RS</option><option value="SC">SC</option>
                              <option value="SE">SE</option><option value="SP">SP</option><option value="TO">TO</option>
                      </select></p>
                      <p><label>País: </label><input type="text" id="proPais" class="medium" name="proPais" value="<?=$proprietario->getPais()?>" /></p>
                      <p><label>Referência: </label><input type="text" id="proPontoReferencia" class="medium" name="proPontoReferencia" value="<?=$proprietario->getPontoReferencia()?>" size="40" /></p>
                  </fieldset>
                  <fieldset><legend>Outras informações:</legend>
                      <p><label>Observações: </label><textarea id="proObservacao" name="proObservacao" rows="5" cols="50" ><?=$proprietario->getObservacao()?></textarea></p>
                  </fieldset>
              </div>
          </div>
        </div>
    </div>
    <div id="divButoes">
        <button type="button" id="btnNovo" class="button medium blue" name="btnNovo"><strong>Novo</strong></button>    
        <button id="btnSalvar" class="button medium blue" name="btnSalvar"><strong>Salvar</strong></button>
        <button type="button" id="btnImovelLista" class="button medium white" name="btnImovelLista"><strong>Imoveis cadastrados</strong></button>
    </div>
    </fieldset>
</form><br />
<script type="text/javascript" src="js/imovel.js?versao=<?=time()?>"></script>
<script type="text/javascript">
$('document').ready(function(){
<?php if (isset ($_GET['return'])) { if ($_GET['return'] != '') { ?>
    alert(<?php echo "'".$util->descriptografa($_GET['return'])."'"; ?>);  
<?php } } if ($pTerceiro) { ?>
    $('#dadosProprietario').show();
<?php } else { ?>
    $('#dadosProprietario').hide();
<?php } if ($ePessoaFisica) { ?>
    mudaFormPessoaFisica();
<?php } else {?>
    mudaFormPessoaJuridica();
<?php } ?> 
    $('#uf').val('<?=$imovel->getUf()?>');
    $('#proUf').val('<?=$proprietario->getUf()?>');
    $('#genero').val('<?=$proprietario->getGenero()?>');
    $('#genero').val('<?=$proprietario->getGenero()?>');
});
</script>