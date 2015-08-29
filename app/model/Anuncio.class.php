<?php

class Anuncio extends Modelo {
    protected $idAnuncio;
    protected $_codigo;    
    protected $idImovel;
    protected $idTipo;
    protected $valor;
    protected $_qtdVisita;
    protected $dataIni;
    protected $dataFim;
    protected $_status; //A - Ativo (quando esta disponivel para o portal), I - Inativo (quando o usuario deseja retirar do portal temporariamente), C - Cancelado (quando desiste do anuncio), B - Bloqueado (automatico via sistema [expiração do contrato, falta de pagamento ou bloqueio do credenciado])
    protected $motivoStatus;
    protected $posicao;
    protected $exibirMapa;
    protected $titulo;
    protected $descricao;
    protected $telefone1;
    protected $telefone2;
    protected $email;    
    protected $responsavel;    
    protected $_dataCadastro;
    protected $_dataAlteracao;
    protected $_idUsuarioCad;
    protected $idUsuarioAlt;    
    protected $_idPessoaProprietario;
    protected $_imagens = array();
    
    public function getTabela(){
        return "anuncio";
    }
    
    public function estaAtivo($idAnuncio) {
        $sql = "SELECT 1 FROM anuncio WHERE idAnuncio=:idAnuncio and status='A' LIMIT 1";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idAnuncio", $idAnuncio);
        $result = false;
        foreach ($consulta->getResultados() as $linha) {
            $result = true;
        }
        return $result;
    }
    
    public function consultar() {
        $criterio  = (empty ($this->_codigo)) ? '' : " or anuncio.codigo = :codigo" ;
        $criterio .= (empty ($this->titulo)) ? '' : " or anuncio.titulo like :titulo" ;
        $criterio .= (empty ($this->idTipo)) ? '' : " or anunciotipo.descricao like :finalidade" ;            
        
        $sql = "SELECT anuncio.idAnuncio,anuncio.codigo,anuncio.titulo,anuncio.qtdVisita,anuncio.idAnuncio,
               CASE anuncio.status WHEN 'A' THEN 'Ativo' WHEN 'I' THEN 'Inativo' WHEN 'C' 
               THEN 'Cancelado' ELSE 'Bloqueado' END status,anunciotipo.descricao as finalidade 
               FROM anuncio INNER JOIN anunciotipo ON anuncio.idTipo = anunciotipo.idTipo INNER 
               JOIN imovel ON anuncio.idImovel = imovel.idImovel WHERE imovel.idPessoaProprietario=:idPessoaProprietario";
       
        if (empty ($criterio)) {
            $sql .= ' ORDER BY anuncio.dataCadastro desc limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (anuncio.idAnuncio is null {$criterio}) ORDER BY anuncio.dataCadastro desc";
        }        
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->_idPessoaProprietario);
        
        if (!empty ($criterio)) {
            if (!empty ($this->_codigo)) {
                $consulta->liga("codigo", $this->_codigo);
            }
            if (!empty ($this->titulo)) {
                $consulta->liga("titulo", $this->titulo.'%');
            }
            if (!empty ($this->idTipo)) {
                $consulta->liga("finalidade", $this->idTipo.'%');
            }
        }
        
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function getInfoComplementares() {
        $sql = "SELECT anuncio.idAnuncio,anuncio.idTipo,anuncio.titulo,anuncio.valor,anuncio.qtdVisita,
               anuncio.dataIni,anuncio.dataFim,anuncio.status,imovelcategoria.descricao as categoria 
               FROM anuncio INNER JOIN imovel ON anuncio.idImovel = imovel.idImovel INNER JOIN imovelcategoria 
               ON imovel.idCategoria = imovelcategoria.idCategoria WHERE imovel.idPessoaProprietario=:idPessoaProprietario";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->_idPessoaProprietario);
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function preecheObjeto() {
        $sql = "SELECT anuncio.idAnuncio,anuncio.idImovel,anuncio.idTipo,anuncio.codigo,anuncio.valor,
               anuncio.qtdVisita,anuncio.posicao,anuncio.exibirMapa,anuncio.titulo,anuncio.descricao,
               anuncio.telefone1,anuncio.telefone2,anuncio.email,anuncio.responsavel, anuncioimagem.idanuncioimagem, anuncioimagem.ordem, anuncioimagem.descricao as descimagem, anuncioimagem.imagem FROM 
               anuncio INNER JOIN anunciotipo ON anuncio.idTipo = anunciotipo.idTipo INNER JOIN anuncioimagem on 
               anuncio.idAnuncio = anuncioimagem.idAnuncio INNER JOIN imovel ON anuncio.idImovel = 
               imovel.idImovel WHERE anuncio.idAnuncio=:idAnuncio AND imovel.idPessoaProprietario=:idPessoaProprietario";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->_idPessoaProprietario);
        $consulta->liga("idAnuncio", $this->idAnuncio);        
        $this->idAnuncio = null;
        $this->_idPessoaProprietario = null;
        
        $resultados = $consulta->getResultados();
        $this->setDados($resultados[0]);
        
        
        foreach ($resultados as $imagens) {
            array_push(
                $this->_imagens, 
                array(
                    'idanuncioimagem' => $imagens['idanuncioimagem'],
                    'ordem' => $imagens['ordem'],
                    'descimagem' => $imagens['descimagem'],
                    'imagem' => $imagens['imagem']
                )
            );
        }
        
        $this->_codigo = $resultados[0]['codigo'];
        
        /*foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
            foreach ($resultados as $imagens) {
                array_push($this->_imagens, $imagens['imagem']);
            }
            $this->_codigo = $linha['codigo'];
        }*/
        
        /*$sql = "SELECT anuncio.idAnuncio,anuncio.idImovel,anuncio.idTipo,anuncio.codigo,anuncio.valor,
               anuncio.qtdVisita,anuncio.posicao,anuncio.exibirMapa,anuncio.titulo,anuncio.descricao,
               anuncio.telefone1,anuncio.telefone2,anuncio.email,anuncio.responsavel FROM anuncio INNER 
               JOIN anunciotipo ON anuncio.idTipo = anunciotipo.idTipo INNER JOIN imovel ON anuncio.idImovel = 
               imovel.idImovel WHERE anuncio.idAnuncio=:idAnuncio AND imovel.idPessoaProprietario=:idPessoaProprietario";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->_idPessoaProprietario);
        $consulta->liga("idAnuncio", $this->idAnuncio);        
        $this->idAnuncio = null;
        $this->_idPessoaProprietario = null;
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
            $this->_codigo = $linha['codigo'];
        }*/
    }
    
    public function excluir() {
        $sql = 'delete anuncio from anuncio inner join imovel on anuncio.idImovel = 
               imovel.idImovel where anuncio.idAnuncio = :idAnuncio and 
               imovel.idPessoaProprietario = :idPessoaProprietario';
        $delete = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $delete->liga("idPessoaProprietario", $this->_idPessoaProprietario);
        $delete->liga("idAnuncio", $this->idAnuncio);
        $delete->executa();
    }
    
    public function cancelar() {      
        $sql = "update anuncio inner join imovel on anuncio.idImovel = imovel.idImovel 
                set anuncio.status = 'C'
                where anuncio.idAnuncio = :idAnuncio and 
                imovel.idPessoaProprietario = :idPessoaProprietario";
        $update = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $update->liga("idPessoaProprietario", $this->_idPessoaProprietario);
        $update->liga("idAnuncio", $this->idAnuncio);
        $update->executa();
    }
    
    public function ativar() {
        $sql = "update anuncio inner join imovel on anuncio.idImovel = imovel.idImovel 
               set anuncio.status = 'A' where anuncio.idAnuncio = :idAnuncio and 
               imovel.idPessoaProprietario = :idPessoaProprietario";
        $atualizar = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $atualizar->liga("idPessoaProprietario", $this->_idPessoaProprietario);
        $atualizar->liga("idAnuncio", $this->idAnuncio);
        $atualizar->executa();
    }
    
    public function inativar() {
        $sql = "update anuncio inner join imovel on anuncio.idImovel = imovel.idImovel 
               set anuncio.status = 'I' where anuncio.idAnuncio = :idAnuncio and 
               imovel.idPessoaProprietario = :idPessoaProprietario";
        $atualizar = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $atualizar->liga("idPessoaProprietario", $this->_idPessoaProprietario);
        $atualizar->liga("idAnuncio", $this->idAnuncio);
        $atualizar->executa();
    }
    
    public function getInfoCadastrais() {
        $sql = "select anuncio.codigo,anuncio.valor,anuncio.qtdVisita,date_format(anuncio.dataIni,'%d/%m/%Y') as dataIni,
               date_format(anuncio.dataFim,'%d/%m/%Y') as dataFim,CASE anuncio.status WHEN 'A' THEN 'Ativo' WHEN 'I' 
               THEN 'Inativo' WHEN 'C' THEN 'Cancelado' ELSE 'Bloqueado' END status,anuncio.motivoStatus,case 
               anuncio.posicao when 'N' then 'Normal' when 'B' then 'Banner' else 'Destaque' end as posicao, case 
               anuncio.exibirMapa when 'S' then 'Sim' else 'Não' end as exibirMapa,anuncio.titulo,anuncio.descricao,
               anuncio.telefone1,anuncio.telefone2,anuncio.email,anuncio.responsavel,date_format(anuncio.dataCadastro,'%d/%m/%Y') 
               as dataCadastro,date_format(anuncio.dataAlteracao,'%d/%m/%Y - %H:%i:%s') as dataAlteracao,imovel.descricao 
               as imovel,anunciotipo.descricao as tipo,(select login from usuario where idUsuario=idUsuarioCad) as usuarioCad,
               (select login from usuario where idUsuario=idUsuarioAlt) as usuarioAlt from anuncio inner join imovel on 
               anuncio.idImovel = imovel.idImovel inner join anunciotipo on anuncio.idTipo = anunciotipo.idTipo where 
               anuncio.idAnuncio = :idAnuncio and imovel.idPessoaProprietario = :idPessoaProprietario";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);        
        $consulta->liga("idPessoaProprietario", $this->_idPessoaProprietario);
        $consulta->liga("idAnuncio", $this->idAnuncio);        
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function getAnuncio() {
        $sql = "SELECT anuncio.idAnuncio,anuncio.codigo,anuncio.titulo,anuncio.valor, anuncio.qtdVisita,
               anuncio.exibirMapa,anuncio.descricao,anuncio.telefone1,anuncio.telefone2,anuncio.email,anuncio.responsavel,
               anunciotipo.descricao AS `tipoAnuncio`,imovel.idImovel,imovel.logradouro,imovel.numLogradouro,
               imovel.bairro,imovel.cidade,imovel.uf,imovelcategoria.descricao AS `categoriaImovel`,pessoa.foto as `logo` FROM anuncio 
               INNER JOIN anunciotipo ON anuncio.idTipo = anunciotipo.idTipo INNER JOIN imovel ON anuncio.idImovel 
               = imovel.idImovel INNER JOIN imovelcategoria ON imovel.idCategoria = imovelcategoria.idCategoria                
               INNER JOIN pessoa on imovel.idPessoaProprietario = pessoa.idPessoa
               WHERE anuncio.idAnuncio=:idAnuncio AND anuncio.status = 'A'";        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idAnuncio", $this->idAnuncio);        
        return $consulta->getResultados();
    }
    
    public function getCaracteristicas() {
        $sql = "select imovelcaracteristicatipo.codigo, imovelcaracteristicatipo.descricao as `caracteristica`, imovelcaracteristica.descricao 
               from imovelcaracteristicatipo inner join imovelcaracteristica on imovelcaracteristicatipo.idCaracteristica 
               = imovelcaracteristica.idCaracteristica where imovelcaracteristica.idImovel = :idImovel";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idImovel", $this->idImovel);        
        return $consulta->getResultados();
    }
    
    public function getProximidades() {
        $sql = "select imovelproximidadetipo.descricao as `proximidade`, imovelproximidade.descricao from 
               imovelproximidadetipo inner join imovelproximidade on imovelproximidadetipo.idProximidade = 
               imovelproximidade.idProximidade where imovelproximidade.idImovel = :idImovel";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idImovel", $this->idImovel);        
        return $consulta->getResultados();
    }
    
    public function getImagensAnuncio() {
        /*$sql = "SELECT imovelfoto.ordem,imovelfoto.descricao,imovelfoto.foto FROM anuncio 
               INNER JOIN imovel ON anuncio.idImovel = imovel.idImovel 
               INNER JOIN imovelfoto ON imovel.idImovel = imovelfoto.idImovel 
               WHERE anuncio.idAnuncio=:idAnuncio ORDER BY imovelfoto.ordem";*/
        $sql = "SELECT anuncioimagem.ordem,anuncioimagem.descricao,anuncioimagem.imagem as foto FROM anuncio 
               INNER JOIN imovel ON anuncio.idImovel = imovel.idImovel 
               INNER JOIN anuncioimagem ON anuncio.idAnuncio = anuncioimagem.idAnuncio 
               WHERE anuncio.idAnuncio=:idAnuncio ORDER BY anuncioimagem.ordem";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idAnuncio", $this->idAnuncio);        
        return $consulta->getResultados();
    }
    
    public function registrarVisualizacao() {
        $sql = 'UPDATE anuncio SET qtdVisita=coalesce(qtdVisita,0)+1 where idAnuncio=:idAnuncio';
        $atualizar = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $atualizar->liga("idAnuncio", $this->idAnuncio);        
        $atualizar->executa();
    }
    
    public function getIdAnuncio() {
        return $this->idAnuncio;
    }

    public function getIdImovel() {
        return $this->idImovel;
    }

    public function getIdTipo() {
        return $this->idTipo;
    }

    public function getValor() {
        return $this->valor;
    }

    public function get_qtdVisita() {
        return $this->_qtdVisita;
    }

    public function getDataIni() {
        return $this->dataIni;
    }

    public function getDataFim() {
        return $this->dataFim;
    }

    public function get_status() {
        return $this->_status;
    }

    public function getMotivoStatus() {
        return $this->motivoStatus;
    }

    public function getPosicao() {
        return $this->posicao;
    }

    public function getExibirMapa() {
        return $this->exibirMapa;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getTelefone1() {
        return $this->telefone1;
    }

    public function getTelefone2() {
        return $this->telefone2;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getResponsavel() {
        return $this->responsavel;
    }

    public function get_dataCadastro() {
        return $this->_dataCadastro;
    }

    public function get_dataAlteracao() {
        return $this->_dataAlteracao;
    }

    public function get_idUsuarioCad() {
        return $this->_idUsuarioCad;
    }

    public function getIdUsuarioAlt() {
        return $this->idUsuarioAlt;
    }

    public function get_idPessoaProprietario() {
        return $this->_idPessoaProprietario;
    }

    public function setIdAnuncio($idAnuncio) {
        $this->idAnuncio = $idAnuncio;
    }
    

    public function setIdImovel($idImovel) {
        $this->idImovel = $idImovel;
    }

    public function setIdTipo($idTipo) {
        $this->idTipo = $idTipo;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function set_qtdVisita($_qtdVisita) {
        $this->_qtdVisita = (empty($qtdVisita)) ? '0' : $qtdVisita;
    }

    public function setDataIni($dataIni) {
        $this->dataIni = $dataIni;
    }

    public function setDataFim($dataFim) {
        $this->dataFim = $dataFim;
    }

    public function set_status($_status) {
        $this->_status = $_status;
    }

    public function setMotivoStatus($motivoStatus) {
        $this->motivoStatus = $motivoStatus;
    }

    public function setPosicao($posicao) {
        $this->posicao = $posicao;
    }

    public function setExibirMapa($exibirMapa) {
        $this->exibirMapa = $exibirMapa;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setTelefone1($telefone1) {
        $this->telefone1 = $telefone1;
    }

    public function setTelefone2($telefone2) {
        $this->telefone2 = $telefone2;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setResponsavel($responsavel) {
        $this->responsavel = $responsavel;
    }

    public function set_dataCadastro($_dataCadastro) {
        $this->_dataCadastro = $_dataCadastro;
    }

    public function set_dataAlteracao($_dataAlteracao) {
        $this->_dataAlteracao = $_dataAlteracao;
    }

    public function set_idUsuarioCad($_idUsuarioCad) {
        $this->_idUsuarioCad = $_idUsuarioCad;
    }

    public function setIdUsuarioAlt($idUsuarioAlt) {
        $this->idUsuarioAlt = $idUsuarioAlt;
    }

    public function set_idPessoaProprietario($_idPessoaProprietario) {
        $this->_idPessoaProprietario = $_idPessoaProprietario;
    }
    
    public function get_codigo() {
        return $this->_codigo;
    }

    public function set_codigo($_codigo) {
        $this->_codigo = $_codigo;
    }
    
    function get_imagens() {
        return $this->_imagens;
    }

    function set_imagens($_imagens) {
        $this->_imagens = $_imagens;
    }
    
}

?>
