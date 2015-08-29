<?php

class Imovel extends Modelo {
    protected $idImovel;
    protected $_codigo;
    protected $idCategoria;
    protected $idPessoaProprietario;
    protected $idProprietarioImovel;
    protected $descricao;
    protected $area;
    protected $cep;
    protected $logradouro;
    protected $numLogradouro;
    protected $complemento;
    protected $pontoReferencia;               
    protected $bairro;
    protected $cidade;
    protected $uf;
    protected $pais;
    protected $excluido='N';
    protected $observacao;
    
    //campos que não pertence a entidade do banco de dados
    protected $_tipoAnuncio;
    
    public function getComAnuncioBanner() {
        
    }
    
    public function getComAnuncioDestaque() {
        
    }
    
    public function getComAnuncioNormal() {
        //$criterio  = ($this->idCategoria == '0') ? '' : ' AND imovel.idCategoria = :idCategoria';
        //$criterio .= ($this->cidade == '0') ? '' : ' AND imovel.cidade = :cidade';
        //$criterio .= ($this->_tipoAnuncio == '0') ? '' : ' AND anuncio.idTipo = :idTipo';
        
        $sql = "SELECT anuncio.idAnuncio,anuncio.titulo,anuncio.valor, anuncio.posicao,
               imovel.idImovel,imovel.cidade,imovel.uf,imovelCategoria.descricao,(SELECT foto 
               FROM imovelfoto WHERE idImovel=imovel.idImovel ORDER BY ordem LIMIT 1) AS `img` 
               FROM anuncio INNER JOIN imovel ON anuncio.idImovel = imovel.idImovel INNER 
               JOIN imovelcategoria ON imovel.idCategoria = imovelCategoria.idCategoria";
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        
        return $consulta;
    }
    
    public function pesquisarComAnuncio($maximo = null) {      
        $sql = "SELECT anuncio.idAnuncio,anuncio.titulo,anuncio.valor, anuncio.posicao,anuncio.descricao,DATE_FORMAT(anuncio.dataCadastro, '%d/%m/%Y às %H:%i:%s' ) as dataCadastro,
               anunciotipo.descricao AS `tipoAnuncio`,anuncio.qtdVisita,imovel.idImovel,imovel.cidade,imovel.uf,
               imovelcategoria.descricao AS `categoriaImovel`,
               (SELECT imagem FROM anuncioimagem WHERE idAnuncio = anuncio.idAnuncio ORDER BY ordem, idAnuncioImagem LIMIT 1) AS `img`,
               (select imovelcaracteristica.descricao from imovelcaracteristica
               inner join imovelcaracteristicatipo
               on imovelcaracteristica.idCaracteristica = imovelcaracteristicatipo.idCaracteristica
               where imovelcaracteristica.idImovel=imovel.idImovel
               and imovelcaracteristicatipo.codigo='quarto' limit 1) as 'quarto',               
               (select imovelcaracteristica.descricao from imovelcaracteristica
               inner join imovelcaracteristicatipo
               on imovelcaracteristica.idCaracteristica = imovelcaracteristicatipo.idCaracteristica
               where imovelcaracteristica.idImovel=imovel.idImovel
               and imovelcaracteristicatipo.codigo='garagem' limit 1) as 'garagem',               
               (select imovelcaracteristica.descricao from imovelcaracteristica
               inner join imovelcaracteristicatipo
               on imovelcaracteristica.idCaracteristica = imovelcaracteristicatipo.idCaracteristica
               where imovelcaracteristica.idImovel=imovel.idImovel
               and imovelcaracteristicatipo.codigo='banheiro' limit 1) as 'banheiro',               
               (select imovelcaracteristica.descricao from imovelcaracteristica
               inner join imovelcaracteristicatipo
               on imovelcaracteristica.idCaracteristica = imovelcaracteristicatipo.idCaracteristica
               where imovelcaracteristica.idImovel=imovel.idImovel
               and imovelcaracteristicatipo.codigo='area_total' limit 1) as 'area_total'
                FROM anuncio INNER JOIN anunciotipo ON anuncio.idTipo 
               = anunciotipo.idTipo INNER JOIN imovel ON anuncio.idImovel = imovel.idImovel INNER JOIN 
               imovelcategoria ON imovel.idCategoria = imovelcategoria.idCategoria WHERE anuncio.status = 'A'";
        
        $sql .= ($this->uf == '0' || $this->uf == '') ? '' : ' AND imovel.uf = :uf';
        
        $sql .= ($this->idCategoria == '0' || $this->idCategoria == '') ? '' : ' AND imovel.idCategoria = :idCategoria';
        
        $sql .= ($this->_tipoAnuncio == '0' || $this->_tipoAnuncio == '') ? '' : ' AND anuncio.idTipo = :tipoAnuncio';
        
        $sql .= ($this->cidade == '0' || $this->cidade == '') ? '' : ' AND imovel.cidade = :cidade';
        
        $sql .= ($this->bairro == '0' || $this->bairro == '') ? '' : ' AND imovel.bairro = :bairro';
                
        $sql .= ' ORDER BY anuncio.posicao,anuncio.dataCadastro desc,anuncio.qtdVisita desc';
                
        if (!is_null($maximo)) {
            $sql .= ' LIMIT '.$maximo;
        }                
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        
        if ($this->uf != '0' && $this->uf != '') {
            $consulta->liga("uf", $this->uf);
        }
        
        if ($this->idCategoria != '0' && $this->idCategoria != '') {
            $consulta->liga("idCategoria", $this->idCategoria);
        }
        
        if ($this->_tipoAnuncio != '0' && $this->_tipoAnuncio != '') {
            $consulta->liga("tipoAnuncio", $this->_tipoAnuncio);
        }
        
        if ($this->cidade != '0' && $this->cidade != '') {
            $consulta->liga("cidade", $this->cidade);
        }

        if ($this->bairro != '0' && $this->bairro != '') {
            $consulta->liga("bairro", $this->bairro);
        }
        
        return $consulta->getResultados();
    }

    public function getUfComAnuncio() {
        $sql = "SELECT DISTINCT imovel.uf,imovel.uf as `descricao` FROM imovel INNER
               JOIN anuncio ON imovel.idImovel = anuncio.idImovel WHERE anuncio.status = 'A' 
               ORDER BY imovel.uf";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        return $consulta->getResultados(); //$this->transformaEmArray($consulta->getResultados());
    }
    
    public function getCategoriaComAnuncio() {        
        $sql = "SELECT DISTINCT imovel.idCategoria,imovelcategoria.descricao FROM imovel
               INNER JOIN imovelcategoria ON imovel.idCategoria = imovelcategoria.idCategoria 
               INNER JOIN anuncio ON imovel.idImovel = anuncio.idImovel WHERE imovel.uf = :uf 
               AND anuncio.status = 'A' ORDER BY imovelcategoria.descricao";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("uf", $this->uf);
        return $consulta->getResultados();
    }
    
    public function getTipoAnuncioComAnuncio() {
        $criterio  = ($this->idCategoria == '0') ? '' : " AND imovel.idCategoria = :idCategoria" ;
        
        $sql = "SELECT DISTINCT anunciotipo.idTipo,anunciotipo.descricao FROM anunciotipo 
               INNER JOIN anuncio ON anunciotipo.idTipo = anuncio.idTipo INNER 
               JOIN imovel ON anuncio.idImovel = imovel.idImovel WHERE anuncio.status = 'A' 
               AND imovel.uf = :uf";
        
        $sql .= $criterio;
        
        $sql .= ' ORDER BY anunciotipo.descricao';
        //echo $sql;
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("uf", $this->uf);
        
        if ($this->idCategoria != '0') {
            $consulta->liga("idCategoria", $this->idCategoria);
        }
        
        return $consulta->getResultados();
    }
    
    public function getCidadeComAnuncio() {
        $criterio  = ($this->idCategoria == '0') ? '' : ' AND imovel.idCategoria = :idCategoria';
        $criterio .= ($this->_tipoAnuncio == '0') ? '' : ' AND anuncio.idTipo = :idTipo';
        
        $sql = "SELECT DISTINCT imovel.cidade,imovel.cidade as `descricao` FROM imovel INNER
               JOIN anuncio ON imovel.idImovel = anuncio.idImovel WHERE imovel.uf = :uf  
               AND anuncio.status = 'A'";
        
        $sql .= $criterio;
        
        $sql .= ' ORDER BY imovel.cidade';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("uf", $this->uf);
        
        if ($this->idCategoria != '0') {
            $consulta->liga("idCategoria", $this->idCategoria);
        }
        
        if ($this->_tipoAnuncio != '0') {
            $consulta->liga("idTipo", $this->_tipoAnuncio);
        }
        return $consulta->getResultados();
    }
    
    public function getBairroComAnuncio() {
        $criterio  = ($this->idCategoria == '0') ? '' : ' AND imovel.idCategoria = :idCategoria';
        $criterio .= ($this->cidade == '0') ? '' : ' AND imovel.cidade = :cidade';
        $criterio .= ($this->_tipoAnuncio == '0') ? '' : ' AND anuncio.idTipo = :idTipo';
        
        $sql = "SELECT DISTINCT imovel.bairro,imovel.bairro as `descricao` FROM imovel INNER
               JOIN anuncio ON imovel.idImovel = anuncio.idImovel WHERE imovel.uf = :uf 
               AND anuncio.status = 'A'";
        
        $sql .= $criterio;
        
        $sql .= ' ORDER BY imovel.cidade';
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("uf", $this->uf);
        
        if ($this->idCategoria != '0') {
            $consulta->liga("idCategoria", $this->idCategoria);
        }
        
        if ($this->cidade != '0') {
            $consulta->liga("cidade", $this->cidade);
        }
        
        if ($this->_tipoAnuncio != '0') {
            $consulta->liga("idTipo", $this->_tipoAnuncio);
        }
        
        return $consulta->getResultados();
    }
    
    /*função para pegar os valores
     * public function getBairroComAnuncio() {
        $criterio  = ($this->idCategoria == '0') ? '' : ' AND imovel.idCategoria = :idCategoria';
        $criterio .= ($this->cidade == '0') ? '' : ' AND imovel.cidade = :cidade';
        $criterio .= ($this->bairro == '0') ? '' : ' AND cidade.bairro = :bairro';
        $criterio .= ($this->_tipoAnuncio == '0') ? '' : ' AND anuncio.idTipo = :idTipo';        
        
        $sql = "SELECT DISTINCT imovel.bairro,imovel.bairro as `descricao` FROM imovel INNER
               JOIN anuncio ON imovel.idImovel = anuncio.idImovel WHERE imovel.uf = :uf 
               AND anuncio.status = 'A'";
        
        $sql .= $criterio;
        
        $sql .= ' ORDER BY imovel.cidade';
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("uf", $this->uf);
        
        if ($this->idCategoria != '0') {
            $consulta->liga("idCategoria", $this->idCategoria);
        }
        
        if ($this->cidade != '0') {
            $consulta->liga("cidade", $this->cidade);
        }
        
        if ($this->bairro != '0') {
            $consulta->liga("bairro", $this->bairro);
        }
        
        if ($this->_tipoAnuncio != '0') {
            $consulta->liga("idTipo", $this->_tipoAnuncio);
        }
        
        return $consulta;
    }*/
    
    public function consultar() {
        $criterio  = (empty ($this->_codigo)) ? '' : " or imovel.codigo = :codigo" ;
        $criterio .= (empty ($this->idCategoria)) ? '' : " or imovelcategoria.descricao like :categoria" ;
        $criterio .= (empty ($this->descricao)) ? '' : " or imovel.descricao like :descricao" ;        
        
        $sql = "SELECT imovel.idImovel,imovel.codigo,imovelcategoria.descricao AS categoria,imovel.descricao AS Imovel,
               DATE_FORMAT(imovel.dataCadastro,'%d/%m/%Y') AS dataCadastro,imovel.dataCadastro AS ordem FROM imovel INNER JOIN imovelcategoria ON 
               imovel.idCategoria = imovelcategoria.idCategoria where imovel.excluido<>'S' and imovel.idPessoaProprietario=
               :idPessoaProprietario";
       
        if (empty ($criterio)) {
            $sql .= ' ORDER BY ordem DESC limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (imovel.idImovel is null {$criterio}) ORDER BY ordem DESC ";
        }
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        
        if (!empty ($criterio)) {
            if (!empty ($this->_codigo)) {
                $consulta->liga("codigo", $this->_codigo);
            }
            if (!empty ($this->idCategoria)) {
                $consulta->liga("categoria", $this->idCategoria.'%');
            }
            if (!empty ($this->descricao)) {
                $consulta->liga("descricao", $this->descricao.'%');
            }
        }        
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function podeExcluir() {
        
    }
    
    public function moverParaLixeira() {
        $sql = "update imovel set excluido='S' where idImovel=:idImovel";
        $delete = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $delete->liga("idImovel", $this->idImovel);
        $delete->executa();        
    }
    
    public function preencheObjeto() {
        $sql = "select idImovel,codigo,idCategoria,idPessoaProprietario,idProprietarioImovel,descricao,
               area,cep,logradouro,numLogradouro,complemento,pontoReferencia,cidade,uf,bairro,pais,
               excluido,observacao,dataCadastro from imovel where idImovel=:idImovel and 
               idPessoaProprietario = :idPessoaProprietario";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        $consulta->liga("idImovel", $this->idImovel);        
        $this->idImovel = 0;
        $this->idPessoaProprietario = null;
        foreach ($consulta->getResultados() as $linha) {
            $this->setDados($linha);
            $this->_codigo = $linha['codigo'];
        }
    }
    
    public function getInfoCadastrais() {
        $sql = 'select imovel.idImovel,imovel.codigo,imovel.descricao,imovel.area,imovel.cep,'.
               'imovel.logradouro,imovel.numLogradouro,imovel.complemento,imovel.pontoReferencia,'.
               'imovel.cidade,imovel.uf,imovel.bairro,imovel.pais,imovel.observacao,'.
               "date_format(imovel.dataCadastro, '%d/%m/%Y') as dataCadastro,pessoa.razao, ".
               'imovelcategoria.descricao as categoria '.
               'from imovel '.
               'inner join pessoa on imovel.idProprietarioImovel = pessoa.idPessoa '.
               'inner join imovelcategoria on imovel.idCategoria = imovelcategoria.idCategoria '.               
               'where imovel.idImovel=:idImovel and imovel.idPessoaProprietario = :idPessoaProprietario';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        $consulta->liga("idImovel", $this->idImovel);        
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function getCadastrados() {
        $sql = "select idImovel,descricao from imovel where idPessoaProprietario=:idPessoaProprietario and excluido <> 'S'";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        return $consulta;
    }
    
    public function getSemAnuncio() {        
        $sql = "(select idImovel,descricao from imovel where imovel.idPessoaProprietario=:idPessoaProprietario and 
               excluido <> 'S' and idImovel not in (select imovel.idImovel from anuncio inner join imovel on anuncio.idImovel = 
               imovel.idImovel where imovel.idPessoaProprietario=:idPessoaProprietario1 and imovel.excluido <> 'S' and anuncio.status not in ('C','B')))";
        
        if (!empty ($this->idImovel)) {
            $sql .= " union (select idImovel,descricao from imovel where idImovel=:idImovel and 
                      idPessoaProprietario=:idPessoaProprietario2 and excluido <> 'S')";
        }
        
        $sql .= " order by descricao desc";
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        $consulta->liga("idPessoaProprietario1", $this->idPessoaProprietario);
        
        if (!empty ($this->idImovel)) {
            $consulta->liga("idImovel", $this->idImovel);
            $consulta->liga("idPessoaProprietario2", $this->idPessoaProprietario);
        }
        
        return $consulta->getResultados();
    }
    
    public function getInfoComplementaresAnuncio() {
        $sql = 'select pessoa.telefone as telefone1,pessoa.celular as telefone2,pessoa.email,'.
               'pessoa.razao as responsavel,imovel.descricao as titulo, imovelfoto.idFoto,'.
               'imovelfoto.ordem, imovelfoto.descricao, imovelfoto.foto '.
               'from imovel '.
               'inner join pessoa on imovel.idPessoaProprietario = pessoa.idPessoa '.
               'left outer join imovelfoto on imovel.idImovel = imovelfoto.idImovel '.
               'where imovel.idImovel = :idImovel and '.
               'imovel.idPessoaProprietario = :idPessoaProprietario';
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idImovel", $this->idImovel);
        $consulta->liga("idPessoaProprietario", (isset($_SESSION['idPessoaProprietario']) ? $_SESSION['idPessoaProprietario'] : 0) );
        return $this->transformaEmArray($consulta->getResultados());
    }
        
    public function getTabela(){
        return "imovel";
    }
    
    public function getIdImovel() {
        return $this->idImovel;
    }

    public function get_codigo() {
        return $this->_codigo;
    }

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getIdPessoaProprietario() {
        return $this->idPessoaProprietario;
    }

    public function getIdProprietarioImovel() {
        return $this->idProprietarioImovel;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function getArea() {
        return $this->area;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getNumLogradouro() {
        return $this->numLogradouro;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getPontoReferencia() {
        return $this->pontoReferencia;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getUf() {
        return $this->uf;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getExcluido() {
        return $this->excluido;
    }

    public function getObservacao() {
        return $this->observacao;
    }

    public function setIdImovel($idImovel) {
        $this->idImovel = $idImovel;
    }

    public function set_codigo($codigo) {
        $this->_codigo = $codigo;
    }

    public function setIdCategoria($idCategoria) {
        $this->idCategoria = $idCategoria;
    }

    public function setIdPessoaProprietario($idPessoaProprietario) {
        $this->idPessoaProprietario = $idPessoaProprietario;
    }

    public function setIdProprietarioImovel($idProprietarioImovel) {
        $this->idProprietarioImovel = $idProprietarioImovel;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setCep($cep) {
        $this->cep = $cep;
    }

    public function setLogradouro($logradouro) {
        $this->logradouro = $logradouro;
    }

    public function setNumLogradouro($numLogradouro) {
        $this->numLogradouro = $numLogradouro;
    }

    public function setComplemento($complemento) {
        $this->complemento = $complemento;
    }

    public function setPontoReferencia($pontoReferencia) {
        $this->pontoReferencia = $pontoReferencia;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function setCidade($cidade) {
        $this->cidade = $cidade;
    }

    public function setUf($uf) {
        $this->uf = $uf;
    }

    public function setPais($pais) {
        $this->pais = $pais;
    }

    public function setExcluido($excluido) {
        $this->excluido = (empty ($excluido) || is_null($excluido)) ? 'N': $excluido;
    }

    public function setObservacao($observacao) {
        $this->observacao = $observacao;
    }        
    
    public function get_tipoAnuncio() {
        return $this->_tipoAnuncio;
    }

    public function set_tipoAnuncio($_tipoAnuncio) {
        $this->_tipoAnuncio = $_tipoAnuncio;
    }

}

?>
