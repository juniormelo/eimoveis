<?php

//class Usuario extends Modelo {
class Usuario extends Pessoa {
    protected $idUsuario;
    protected $idPessoa;
    protected $idPapel;
    protected $login;
    protected $senha;
    protected $logado;
    protected $bloqueado;
    protected $acessos;
    protected $ultimoAcesso;
    protected $dominio;
    protected $_superAdm;
    protected $_credenciadoBloqueado;
    protected $_permissoes;

    public function getTabela() {
        return 'usuario';
    }   
    
    public function autentica(){
        try {            
            $this->login = trim(str_replace("'", "", addslashes($this->login)));
            $this->senha = trim(str_replace("'", "", addslashes($this->senha)));        
            $sql = "select usuario.idUsuario,usuario.idPessoa,usuario.idPapel,".
                   "usuario.superAdm, usuario.login,usuario.bloqueado,pessoa.idPessoaProprietario,".
                   "pessoa.razao as nome,".
                   "(select p1.razao from pessoa as p1 where p1.idpessoa = pessoa.idPessoaProprietario) as razao,".
                   "(select coalesce(p2.credenciadoBloqueado,'N') from pessoa as p2 where p2.idpessoa = pessoa.idPessoaProprietario) as credenciadoBloqueado ".
                   "from usuario ".
                   "inner join pessoa on usuario.idPessoa = pessoa.idPessoa ".
                   "where usuario.login=:login and usuario.senha = md5(:senha)";            
            $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
            $consulta->liga("login", $this->login);
            $consulta->liga("senha", $this->senha);
            foreach ($consulta->getResultados() as $linha) {                
                $this->setDados($linha);
                $this->_superAdm = ($linha['superAdm'] == 'S') ? true : false;
                $this->_credenciadoBloqueado = ($linha['credenciadoBloqueado'] == 'S' ? true : false);
                $this->bloqueado = ($linha['bloqueado'] == 'S') ? true : false;
                $this->_permissoes = ($this->_superAdm == 'S') ? array('adm') : $this->getPermissoesLogin();
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function consultar() {
        $criterio  = (empty ($this->idUsuario)) ? '' : " or usuario.idUsuario = :idUsuario" ;
        $criterio .= (empty ($this->login))     ? '' : " or usuario.login = :usuario" ;
        $criterio .= (empty ($this->idPessoa))  ? '' : " or pessoa.razao like :razao" ;
        $criterio .= (empty ($this->idPapel))   ? '' : " or usuariopapel.papel like :papel" ;        
        
        $sql = "select usuario.idUsuario,usuario.login,case usuario.bloqueado when 'S' then 'Sim' else 'Não' 
               end as bloqueado,usuario.acessos,date_format(usuario.ultimoAcesso,'%d/%m/%Y - %H:%i:%s') as 
               ultimoAcesso,pessoa.razao,coalesce(usuariopapel.papel,'Sem grupo') as papel from usuario ".
               "left join usuariopapel on usuario.idPapel = usuariopapel.idPapel ".
               "inner join pessoa on usuario.idPessoa = pessoa.idPessoa ".               
               "where (pessoa.idPessoa=:idPessoa or pessoa.idPessoaProprietario=:idPessoaProprietario) ".
               "and (usuario.superAdm <> 'S') and (coalesce(usuariopapel.codigo,'') <> 'adm')";
        
        if (empty ($criterio)) {
            $sql .= ' order by pessoa.razao limit '.Conf::$PAGINACAO;
        } else {
            $sql .= " and (usuario.idUsuario is null ".$criterio.") order by pessoa.razao";
        }
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPessoa", $this->idPessoaProprietario);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        
        if (!empty ($criterio)) {
            if (!empty ($this->idUsuario)) {
                $consulta->liga("idUsuario", $this->idUsuario);
            }
            if (!empty ($this->login)) {
                $consulta->liga("usuario", $this->login);
            }
            if (!empty ($this->idPessoa)) {
                $consulta->liga("razao", $this->idPessoa.'%');
            }
            if (!empty ($this->idPapel)) {
                $consulta->liga("papel", $this->idPapel.'%');
            }            
        }
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function alterarSenha() {
        /*$sql = "UPDATE usuario set senha = md5(:senha) where idUsuario=:idUsuario";*/
        $sql = 'UPDATE usuario INNER JOIN pessoa ON usuario.idPessoa = pessoa.idPessoa '.
               'SET senha = md5(:senha) WHERE usuario.idUsuario=:idUsuario AND '.
               'pessoa.idPessoaProprietario = :idPessoaProprietario';
        $update = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $update->liga("senha", $this->senha);
        $update->liga("idUsuario", $this->idUsuario);
        $update->liga("idPessoaProprietario", $_SESSION['idPessoaProprietario']);
        $update->executa();
    }
    
    public function getSenhaAtualDB() {
        $sql = "select senha from usuario where idUsuario=:idUsuario";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idUsuario", $this->idUsuario);
        foreach ($consulta->getResultados() as $linha) {
            return $linha['senha'];
        }
    }
    
    public function getDadosAutenticacao() {
        $sql = "select usuario.idUsuario,usuario.idPessoa,usuario.idPapel,usuario.login,usuario.bloqueado,
	       pessoa.idPessoaProprietario,pessoa.razao from usuario inner join pessoa on usuario.idPessoa = 
               pessoa.idPessoa where usuario.login=:usuario and usuario.senha = md5(:senha)";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("usuario", $this->login);
        $consulta->liga("senha", $this->senha); 
        return $consulta->getResultados();
    }
    
    public function registrarAcesso() {
        $sql = "update usuario set acessos=acessos+1,ultimoAcesso=now() where idUsuario=:idUsuario";
        $comando = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $comando->liga("idUsuario", $this->idUsuario);
        $comando->executa();
    }
    
    public function gravar() {        
        $sql = "call sp_gravar_usuario(:pIdUsuario,:pIdPessoa,:pIdPapel,:pLogin,:pSenha,:pBloqueado,:pDominio);";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("pIdUsuario", (empty ($this->idUsuario)) ? 0 : $this->idUsuario);
        $consulta->liga("pIdPessoa", $this->idPessoa);
        $consulta->liga("pIdPapel", (empty ($this->idPapel)) ? 0 : $this->idPapel);
        $consulta->liga("pLogin", $this->login);
        $consulta->liga("pSenha", $this->senha);
        $consulta->liga("pBloqueado", $this->bloqueado);
        $consulta->liga("pDominio", (empty ($this->dominio)) ? '' : $this->dominio);              
        
        foreach ($consulta->getResultados() as $linha) {            
            return $linha['RESULT'];
        }        
    }        
    
    public function getColaboradoresCadUsuario() {        
        if ((empty ($this->idUsuario)) || ($this->idUsuario == 0)) {
            $sql = 'select distinct pessoa.idPessoa,pessoa.razao from funcionario inner join pessoa 
                   on funcionario.idFuncionario = pessoa.idPessoa where pessoa.idPessoaProprietario = 
                   :idPessoaProprietario1 and pessoa.idPessoa not in (select usuario.idPessoa from 
                   usuario inner join funcionario on usuario.idPessoa = funcionario.idFuncionario 
                   inner join pessoa on funcionario.idFuncionario = pessoa.idPessoa where 
                   pessoa.idPessoaProprietario=:idPessoaProprietario2)';
        } else {
            $sql = 'select distinct pessoa.idPessoa,pessoa.razao from usuario inner join funcionario 
                   on usuario.idPessoa = funcionario.idFuncionario inner join pessoa on 
                   funcionario.idFuncionario = pessoa.idPessoa where usuario.idUsuario=:idUsuario and 
                   pessoa.idPessoaProprietario=:idPessoaProprietario';            
        }
        $sql .= " order by razao";

        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        
         if (empty ($this->idUsuario)) {
            $consulta->liga("idPessoaProprietario1", $this->idPessoaProprietario);
            $consulta->liga("idPessoaProprietario2", $this->idPessoaProprietario);
         } else {
             $consulta->liga("idUsuario", $this->idUsuario);
             $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
         }     
                
        return $consulta->getResultados();
    }
    
    public function getInfoUsuario() {        
        $sql = "select usuario.login, case usuario.bloqueado when 'S' then 'Sim' else 'Não' ". 
               "end as bloqueado, date_format(usuario.ultimoAcesso,'%d/%m/%Y - %H:%i:%s') as ultimoAcesso, usuario.acessos,".
               "date_format(usuario.dataCadastro,'%d/%m/%Y - %H:%i:%s') as dataCadastro, usuariopapel.papel ,pessoa.razao, pessoa.email ".
               'from usuario '.
               'left join usuariopapel on usuario.idPapel = usuariopapel.idPapel '.
               'inner join pessoa on usuario.idPessoa = pessoa.idPessoa '.
               'where usuario.idUsuario = :idUsuario '.
               'and pessoa.idPessoaProprietario = :idPessoaProprietario';
        
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idUsuario", $this->idUsuario);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);        
        return $this->transformaEmArray($consulta->getResultados());
    }
    
    public function alterarStatus() {
        $sql = "call sp_usuario_altera_status(:pIdUsuario);";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("pIdUsuario", (empty ($this->idUsuario)) ? 0 : $this->idUsuario);        
        
        foreach ($consulta->getResultados() as $linha) {            
            return $linha['RESULT'];
        }
    }
    
    public function preencheObj() {
        $sql = "select u.* from usuario as u ".
               "inner join pessoa as p on u.idPessoa = p.idPessoa ".
               "where u.idUsuario = :idUsuario and p.idPessoaProprietario = :idPessoaProprietario";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);        
        $consulta->liga("idUsuario", $this->idUsuario);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);
        
        foreach ($consulta->getResultados() as $linha) {            
            $this->setDados($linha);
            break;
        }
    }
    
    public function getPermissoesLogin() {         
        $sql = "select distinct a.cod_modulo, a.acesso ".
               "from usuariopermissao as upe inner join usuariopapelpermissao as ".
               "upp on upe.idPapelPermissao = upp.idPapelPermissao inner join ".
               "acessocredenciado as ac on upp.idAcessoCredenciado = ac.idAcessoCredenciado ".
               "inner join acesso as a on ac.idAcesso = a.idAcesso where upe.idUsuario = :pIdUsuario ".
               "and upe.permitido = 'S' and upp.idPapel = :pIdPapel and upp.permitido = 'S' ".
               "and ac.idPessoaCredenciado = :pIdPessoaProprietario and ac.liberado = 'S' ";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("pIdUsuario", $this->idUsuario);
        $consulta->liga("pIdPapel", $this->idPapel);
        $consulta->liga("pIdPessoaProprietario", $this->idPessoaProprietario);
        $permissoes = array();
        foreach ($consulta->getResultados() as $linha) {
            if (!in_array($linha['cod_modulo'], $permissoes)) {
                array_push($permissoes, $linha['cod_modulo']);
            }
            array_push($permissoes, $linha['acesso']);
        }
        return $permissoes;
    }
    
    public function getPermissoes($json = true) {         
        $sql = "select distinct upe.idPapelPermissao, upe.permitido, a.modulo, a.descricao ".
               "from usuariopermissao as upe inner join usuariopapelpermissao as ".
               "upp on upe.idPapelPermissao = upp.idPapelPermissao inner join ".
               "acessocredenciado as ac on upp.idAcessoCredenciado = ac.idAcessoCredenciado ".
               "inner join acesso as a on ac.idAcesso = a.idAcesso where ".
               "upe.idUsuario = :pIdUsuario and upp.idPapel = :pIdPapel and upp.permitido = 'S' ".
               "and ac.idPessoaCredenciado = :pIdPessoaProprietario and ac.liberado = 'S' ".
               "order by a.modulo";
                
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("pIdUsuario", $this->idUsuario);
        $consulta->liga("pIdPapel", $this->idPapel);
        $consulta->liga("pIdPessoaProprietario", $this->idPessoaProprietario);        
        if ($json) {
            return $this->transformaEmArray($consulta->getResultados(), true);            
        } else {
            return $consulta->getResultados();
        }        
    }

    public function getPermissoesGrupo() {
        $sql = "select upp.idPapelPermissao, upp.permitido, a.modulo, a.descricao ".
           "from usuariopapel as up inner join usuariopapelpermissao as upp on ".
           "up.idPapel = upp.idPapel inner join acessocredenciado as ac on ".
           "upp.idAcessoCredenciado = ac.idAcessoCredenciado inner join ".
           "acesso as a on ac.idAcesso = a.idAcesso where up.idPapel = :idPapel ".
           "and ac.idPessoaCredenciado = :idPessoaProprietario and ".
           "ac.liberado = 'S' and upp.permitido = 'S' order by a.modulo";
        $consulta = new ConsultaPreparada(Conf::pegCnxPadrao(), $sql);
        $consulta->liga("idPapel", $this->idPapel);
        $consulta->liga("idPessoaProprietario", $this->idPessoaProprietario);            
        return $this->transformaEmArray($consulta->getResultados(),true);
    }
    
    public function aplicarPermissoes($permissoes) {
        if (sizeof($permissoes) > 0) {
            //vincular ao grupo
            $this->vinculaGrupo();
            
            //retira as permissões
            $this->retirarPermissoes();

            //setar as permissões
            if (isset($permissoes['permissoes'])) {
                $sql = '';
                foreach ($permissoes['permissoes'] as $permissao => $valor) {
                    $sql .= "update usuariopermissao set permitido='S' where ".
                            "idUsuario = {$this->idUsuario} and idPapelPermissao = {$valor}; "; 
                }
                                
                if (!empty($sql)) {
                    $liberar = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
                    $liberar->executa();
                    unset($liberar);
                }
            }
        } 
    }
    
    public function retirarPermissoes() {
        $sql = "update usuariopermissao as upe ".
               "inner join usuario as u on upe.idUsuario = u.idUsuario ".
               "inner join pessoa as p on u.idPessoa = p.idPessoa ".
               "set permitido = 'N' ".
               "where u.idUsuario = :idUsuario and ".
               "p.idPessoaProprietario = :idPessoaProprietario";
        $comando = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $comando->liga("idUsuario", $this->idUsuario);
        $comando->liga("idPessoaProprietario", $this->idPessoaProprietario);
        $comando->executa();
    }
    
    public function vinculaGrupo() {
        $sql = "call sp_usuario_sincroniza_acessos({$this->idUsuario}, {$this->idPapel}, {$this->idPessoaProprietario}); ";
        $sql .= "update usuario as u inner join pessoa as p on ".
               "u.idPessoa = p.idPessoa set idPapel = {$this->idPapel} ".
               "where u.idUsuario = {$this->idUsuario} and ".
               "p.idPessoaProprietario = {$this->idPessoaProprietario}; ";
        $comando = new ComandoPreparado(Conf::pegCnxPadrao(), $sql);
        $comando->executa();
        unset($comando);
    }
    
    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getIdPessoa() {
        return $this->idPessoa;
    }

    public function getIdPapel() {
        return $this->idPapel;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function getLogado() {
        return $this->logado;
    }

    public function getBloqueado() {
        return $this->bloqueado;
    }

    public function getAcessos() {
        return $this->acessos;
    }

    public function getUltimoAcesso() {
        return $this->ultimoAcesso;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = (int) $idUsuario;
    }

    public function setIdPessoa($idPessoa) {
        $this->idPessoa = (int) $idPessoa;
    }

    public function setIdPapel($idPapel) {
        $this->idPapel = (int) $idPapel;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function setLogado($logado) {
        $this->logado = $logado;
    }

    public function setBloqueado($bloqueado) {        
        $bloqueado = strtoupper($bloqueado);
        $this->bloqueado = ($bloqueado == 'N' || $bloqueado == 'S') ? $bloqueado : 'N';
    }

    public function setAcessos($acessos) {
        $this->acessos = $acessos;
    }

    public function setUltimoAcesso($ultimoAcesso) {
        $this->ultimoAcesso = $ultimoAcesso;
    }
    
    function getDominio() {
        return $this->dominio;
    }

    function setDominio($dominio) {
        $this->dominio = $dominio;
    }
    
    function get_superAdm() {
        return $this->_superAdm;
    }

    function set_superAdm($_superAdm) {
        $this->_superAdm = $_superAdm;
    }
    
    function get_credenciadoBloqueado() {
        return $this->_credenciadoBloqueado;
    }

    function set_credenciadoBloqueado($_credenciadoBloqueado) {
        $this->_credenciadoBloqueado = $_credenciadoBloqueado;
    }
    
    function get_permissoes() {
        return $this->_permissoes;
    }
    
    function set_permissoes($_permissoes) {
        $this->_permissoes = $_permissoes;
    }
   
}

?>
