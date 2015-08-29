<?php 
Sessao::temPermissao('colaboradorcad');
include_once 'app/view/backend/menupadrao.php'; 
?>

<div class="main-content">
    
<?php
$cnx = Conf::pegCnxPadrao();
$colaborador = new Funcionario($cnx);
$titulo = 'Cadastrar colaborador';
if (isset ($_GET['idcolaborador'])) {
    $titulo = 'Editar colaborador';
    $colaborador->setIdFuncionario($_GET['idcolaborador']);
    $colaborador->setIdPessoaProprietario($_SESSION['idPessoaProprietario']);
    $colaborador->preencheObj();
}
?>
<div class="breadcrumbs" id="breadcrumbs">
    <script type="text/javascript">
        try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
    </script>

    <ul class="breadcrumb">
        <li>
            <i class="ace-icon fa fa-home home-icon"></i>
            <a href="sistema.php">Início</a>
        </li>
        <li class="active">Colaboradores</li>
    </ul>					
</div>

<div class="page-content">

    <div class="page-header">
        <!--<h1 style="text-align: center; font-weight: bold">-->
        <h1>
            <?=$titulo?>
            <!--<small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                overview &amp; stats
            </small>-->
        </h1>
    </div><!-- /.page-header -->
    
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="row">
                <div class="col-xs-12"><br />                    
                    <!--<form id="fmCadCliente" class="form-horizontal" role="form" name="fmCadCliente" method="post"  action="javascript:void(0)">-->
                    <form id="fmCadColaborador" class="form-horizontal" role="form" name="fmCadColaborador" method="post" action="javascript:void(0)" >
                        <div class="tabbable">
                            <ul class="nav nav-tabs" id="myTab">
                                <li class="active">
                                    <a data-toggle="tab" href="#info">
                                        <!--<i class="green ace-icon fa fa-home bigger-120"></i>-->
                                        <strong>Informações</strong>
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#contato">
                                        <strong>Contato</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#endereco">
                                        <strong>Endereço</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>                                                        

                                <li>
                                    <a data-toggle="tab" href="#outrasinfo">
                                        <strong>Info. Profissional</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>
                                
                                <li>
                                    <a data-toggle="tab" href="#obs">
                                        <strong>Outras info.</strong>
                                        <!--<span class="badge badge-danger">4</span>-->
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="info" class="tab-pane in active">                                    
                                    
                                    <fieldset>
                                        <legend><strong>Dados pessoais:</strong></legend>                                                                                
                                        
                                        <input type="hidden" id="idFuncionario" name="idFuncionario" value="<?=$colaborador->getIdFuncionario()?>" />
                                        
                                        <div id="lblCpf" class="form-group">
                                            <label for="cpf_cnpj" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">CPF:</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="cpf_cnpj" name="cpf_cnpj" class="col-xs-10 col-sm-5 obrigatorio" value="<?=$colaborador->getCpf_cnpj()?>" title="CPF" onblur="localizarPessoa()"/>
                                            </div>
                                        </div>
                                        
                                        <div id="lblRazao" class="form-group">
                                            <label for="razao" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Nome:</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="razao" class="col-xs-10 col-sm-5 obrigatorio" name="razao" value="<?=$colaborador->getRazao()?>" maxlength="100" />
                                            </div>
                                        </div>
                                        
                                        <div id="lblFantasia" class="form-group">
                                            <label for="fantasia" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Apelido:</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="fantasia" class="col-xs-10 col-sm-5" name="fantasia" value="<?=$colaborador->getFantasia()?>" maxlength="100" />
                                            </div>
                                        </div>
                                        
                                        <div id="lblRg" class="form-group">
                                            <label for="rg_ie" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">RG:</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="rg_ie" class="col-xs-10 col-sm-5" name="rg_ie" value="<?=$colaborador->getRg_ie()?>" maxlength="14" />
                                            </div>
                                        </div>
                                        
                                        <div id="lblNascimento" class="form-group">
                                            <label for="dtNascimento" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Nascimento:</label>
                                            <div class="col-sm-9">
                                                <input type="text" id="dtNascimento" class="col-xs-10 col-sm-5 data" name="dtNascimento" value="<?=Utilitarios::formataData_DiaMesAno(str_replace('//', '', $colaborador->getDtNascimento()))?>" />
                                            </div>
                                        </div>
                                        
                                        <div id="lblGenero" class="form-group">
                                            <label for="genero" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Sexo:</label>
                                            <div class="col-sm-9">
                                                <select id="genero" class="col-xs-10 col-sm-5" name="genero">
                                                    <option value="M">Masculino</option>
                                                    <option value="F">Feminino</option>        
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div id="lblEstadoCivil" class="form-group">
                                            <label for="idEstadoCivil" class="col-sm-2 control-label no-padding-right" style="font-weight: bold;">Estado civil:</label>
                                            <div class="col-sm-9">
                                                <select id="idEstadoCivil" class="col-xs-10 col-sm-5" name="idEstadoCivil">                              
                                                    <?php
                                                      $estadoCivil = new EstadoCivil(Conf::pegCnxPadrao());
                                                      Utilitarios::preencheComboDB($estadoCivil->getCadastrados(),$colaborador->getIdEstadoCivil());
                                                    ?>
                                                </select>
                                            </div>  
                                        </div>  
                                    </fieldset>

                                </div>

                                <div id="contato" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Contato:</strong></legend>                                                                                
                                        
                                        <div id="lblTelefone" class="form-group">
                                            <label for="telefone" class="col-sm-2 control-label no-padding-right"><strong>Telefone:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="telefone" class="col-xs-10 col-sm-5 telefone" name="telefone" value="<?=$colaborador->getTelefone()?>" maxlength="15" />
                                            </div>                                        
                                        </div>

                                        <div class="form-group">
                                            <label for="fax" class="col-sm-2 control-label no-padding-right"><strong>Fax:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="fax" class="col-xs-10 col-sm-5 telefone" name="fax" value="<?=$colaborador->getFax()?>" maxlength="15" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="celular" class="col-sm-2 control-label no-padding-right"><strong>Celular:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="celular" class="col-xs-10 col-sm-5 telefone" name="celular" value="<?=$colaborador->getCelular()?>" maxlength="15" />
                                            </div>                                        
                                        </div>

                                        <div class="form-group">
                                            <label for="email" class="col-sm-2 control-label no-padding-right"><strong>E-mail:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="email" class="col-xs-10 col-sm-5 obrigatorio" name="email" value="<?=$colaborador->getEmail()?>" maxlength="50" />
                                            </div>                                        
                                        </div>
                                        <div class="form-group">
                                            <label for="site" class="col-sm-2 control-label no-padding-right"><strong>Site:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="site" class="col-xs-10 col-sm-5" name="site" value="<?=$colaborador->getSite()?>" maxlength="50" />
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div id="endereco" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Dados de endereço:</strong></legend>                                                                                

                                        <div class="form-group">
                                            <label for="cep" class="col-sm-2 control-label no-padding-right"><strong>Cep:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="cep" class="col-xs-10 col-sm-5 cep" name="cep" value="<?=$colaborador->getCep()?>" onBlur="getEndereco('cep','logradouro','bairro','cidade','uf','pais','msgcep')" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="" class="col-sm-2 control-label no-padding-right" style="font-weight: bold"></label>
                                            <div class="col-sm-9"><div id="msgcep"></div></div>
                                        </div>

                                        <div class="form-group">
                                            <label for="logradouro" class="col-sm-2 control-label no-padding-right"><strong>Logradouro:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="logradouro" class="col-xs-10 col-sm-5" name="logradouro" value="<?=$colaborador->getLogradouro()?>"  />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="numLogradouro" class="col-sm-2 control-label no-padding-right"><strong>Número:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="numLogradouro" class="col-xs-10 col-sm-5" name="numLogradouro" value="<?=$colaborador->getNumLogradouro()?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="complemento" class="col-sm-2 control-label no-padding-right"><strong>Complem.:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="complemento" class="col-xs-10 col-sm-5" name="complemento" value="<?=$colaborador->getComplemento()?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="bairro" class="col-sm-2 control-label no-padding-right"><strong>Bairro:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="bairro" class="col-xs-10 col-sm-5" name="bairro" value="<?=$colaborador->getBairro()?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="cidade" class="col-sm-2 control-label no-padding-right"><strong>Cidade:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="cidade" class="col-xs-10 col-sm-5" name="cidade" value="<?=$colaborador->getCidade()?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="uf" class="col-sm-2 control-label no-padding-right"><strong>UF:</strong></label>
                                            <div class="col-sm-9">
                                                <select id="uf" name="uf" class="col-xs-10 col-sm-5">
                                                  <option value="AC">AC</option><option value="AL">AL</option><option value="AM">AM</option>
                                                  <option value="AP">AP</option><option value="BA">BA</option><option value="CE">CE</option>
                                                  <option value="DF">DF</option><option value="ES">ES</option><option value="GO">GO</option>
                                                  <option value="MA">MA</option><option value="MG">MG</option><option value="MS">MS</option>
                                                  <option value="MT">MT</option><option value="PA">PA</option><option value="PB">PB</option>
                                                  <option value="PE">PE</option><option value="PI">PI</option><option value="PR">PR</option>
                                                  <option value="RJ">RJ</option><option value="RN">RN</option><option value="RO">RO</option>
                                                  <option value="RR">RR</option><option value="RS">RS</option><option value="SC">SC</option>
                                                  <option value="SE">SE</option><option value="SP">SP</option><option value="TO">TO</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="pais" class="col-sm-2 control-label no-padding-right"><strong>País:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="pais" class="col-xs-10 col-sm-5" name="pais" value="<?=$colaborador->getPais()?>" />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label  for="pontoReferencia" class="col-sm-2 control-label no-padding-right"><strong>Referência:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="pontoReferencia" class="col-xs-10 col-sm-5" name="pontoReferencia" value="<?=$colaborador->getPontoReferencia()?>" maxlength="100" />
                                            </div>
                                        </div>
                                    </fieldset>                               
                                </div>                                                        

                                <div id="outrasinfo" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Informações profissionais:</strong></legend>                                    
                                        
                                        <div class="form-group">                                            
                                            <label  for="idCargo" class="col-sm-2 control-label no-padding-right"><strong>Cargo:</strong></label>
                                            <div class="col-sm-9">
                                                <select id="idCargo" name="idCargo" class="col-xs-10 col-sm-5">
                                                <?php
                                                  $cargo = new Cargo($cnx);
                                                  Utilitarios::preencheComboDB($cargo->getCadastrados(),$colaborador->getIdCargo(),' -- Selecione um cargo -- ');
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">                                            
                                            <label for="dtAdmissao" class="col-sm-2 control-label no-padding-right"><strong>Admissão:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="dtAdmissao" class="col-xs-10 col-sm-5 data" name="dtAdmissao" value="<?= Utilitarios::formataData_DiaMesAno(str_replace('//', '', $colaborador->getDtAdmissao()))?>" maxlength="20" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">                                            
                                            <label for="carteiraTrab" class="col-sm-2 control-label no-padding-right"><strong>CTS:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="carteiraTrab" class="col-xs-10 col-sm-5" name="carteiraTrab" value="<?=$colaborador->getCarteiraTrab()?>" maxlength="18" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="pis_pasep" class="col-sm-2 control-label no-padding-right"><strong>PIS/PASEP:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="pis_pasep" class="col-xs-10 col-sm-5" name="pis_pasep" value="<?=$colaborador->getPis_pasep()?>" maxlength="18" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="cnh" class="col-sm-2 control-label no-padding-right"><strong>CNH:</strong></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="cnh" class="col-xs-10 col-sm-5" name="cnh" value="<?=$colaborador->getCnh()?>" maxlength="14" />
                                            </div>
                                        </div>
      
                                    </fieldset>
                                </div>
                                
                                <div id="obs" class="tab-pane">
                                    <fieldset>
                                        <legend><strong>Observações:</strong></legend>                                    
                                        <textarea id="observacao" name="observacao" rows="6" cols="60" ><?=$colaborador->getObservacao()?></textarea>
                                    </fieldset>
                                </div>
                            </div>
                    </div>
                    <div id="divButoes"><br />
                        
                        <?php if(Sessao::temPermissao('colaboradorlista', false)) :?>
                            <button class="btn btn-info" type="button" id="btnLista" name="btnLista">
                                <i class="ace-icon fa fa-arrow-left icon-on-right bigger-125"></i>
                                <strong>Colaboradores cadastrados</strong>
                            </button>&nbsp;&nbsp;
                        <?php endif; ?>
                        
                        <!--<button type="button" id="btnNovo" class="button medium blue" name="btnNovo"><strong>Novo</strong></button>    -->
                        <button class="btn btn-light" type="button" id="btnNovo" name="btnNovo">
                            <i class="ace-icon fa fa-pencil-square-o bigger-125"></i>
                            <strong>Novo</strong>
                        </button>&nbsp;&nbsp;&nbsp;&nbsp;

                        <!--<button id="btnSalvar" class="button medium blue" name="btnSalvar"><strong>Salvar</strong></button>-->                                    
                        <button class="btn btn-success" type="button" id="btnSalvar" name="btnSalvar">
                            <i class="ace-icon fa fa-floppy-o bigger-125"></i>
                            <strong>Salvar</strong>
                        </button>

                    </div>
                </form>    
                </div>
            </div>
        </div>
    </div>    
</div><!-- /.page-content -->


<script type="text/javascript" src="js/colaborador.js"></script>
<script type="text/javascript">
$('document').ready(function(){ 
    $('#uf').val('<?=$colaborador->getUf()?>');    
    $('#genero').val('<?=$colaborador->getGenero()?>');    
});
</script>

</div>