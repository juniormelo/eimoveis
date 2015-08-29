<?php
/**
 * Arquivo de Configuração do Framework
 * @author Alan Gustavo Santana Ribeiro <alan@prrn.mpf.gov.br> em 17/09/2008
 * @version 1.0
 * @package
 */
// Inicio o tratamento de sessões
/*if (!isset($_SESSION)) {
    session_start();    
}*/

if (isset($_SESSION)) {
    session_regenerate_id(true);  //em teste (garante a renovação da session caso o cookie seja roubado por um hack)  
} else {
    session_start();    
}    

// Incluo a classe Principal de Configuração.
// Essa classe é Responsável por diversas configurações do framework.
include_once('bib/Conf.class.php');
/** 
 * Configurações padrão de Conexão com o Banco de Dados
 */
Conf::$TIPO_BANCO   = "mysql";
/* -REMOTO- */
/*Conf::$END_SERVIDOR = "ucore.com.br";
Conf::$BASE_DADOS   = "atriu820_junior";
Conf::$USUARIO_BD   = "atriu820_junior";
Conf::$SENHA_BD     = "jr#2013";*/

/* SERVIDOR DE DAVID*/
/*Conf::$END_SERVIDOR = "192.198.196.247";
Conf::$BASE_DADOS   = "eimoveis_db";
Conf::$USUARIO_BD   = "eimoveis_adm";
Conf::$SENHA_BD     = "juro.adm@2014";*/

/* SERVIDOR DIGITAL OCEAN*/
Conf::$END_SERVIDOR = "104.236.192.146";
Conf::$BASE_DADOS   = "eimoveis_db";
Conf::$USUARIO_BD   = "root";
Conf::$SENHA_BD     = "mastersystem";

/*Conf::$END_SERVIDOR = "127.0.0.1";
Conf::$BASE_DADOS   = "eimoveisdb";
Conf::$USUARIO_BD   = "root";
Conf::$SENHA_BD     = "123456";*/

/* -LOCAL- */
/*Conf::$END_SERVIDOR = "localhost";
Conf::$BASE_DADOS   = "dbopcaoimovel";
Conf::$USUARIO_BD   = "root";
Conf::$SENHA_BD     = "123456";*/

Conf::$URL_SITE     = "http://www.eimoveis.com.br";
Conf::$PAGINACAO    = "30"; //paginação das consultas
/**
 * Depois das Configurações Acima, é possível solicitar uma conexão com o banco
 * de dados utilizando a função Conf::cnxPadrao();
 */
/**
 * Habilito ou Desabilito a exibição de erros e warning
 */
Conf::exibeTodosErros();
// Conf::ocultaTodosErros(); // Quando colocar em produção desativas os warnings
/**
 * Habilito Log de Depuração. Comentar essa linha quando colocar na produção.
 */
Conf::$DEPURAR = FALSE;
/**
 *  O log de depuração vai criar registros de log das atividades das classes
 *  de banco de dados. Esse Log vai estar disponível na pasta log. O nome do
 *  arquivo vai começar com DEP
 */
Conf::$CAMINHO = str_replace("config.php","",__FILE__);
Conf::$DS      = DIRECTORY_SEPARATOR;
/**
 * Essa Chave será utilizada para Imprimir segurança ao HASH do Log
 * Troque essa chave no momento da configuração do sistema, mas não a altere
 * depois que o sistema começar a funcionar.
 */
Conf::altCHAVE("m|nH4Ch@v&Se(Rt@!li99)09877hGGftreFluminenseRulez");

$_POST = antiInject($_POST);
$_GET  = antiInject($_GET);

function antiInject($dado){    
    if(is_array($dado)){
        return array_map('antiInject', $dado);
    }else{
        $dado = str_replace("\\", "", $dado);
        $dado = str_replace("'", "''", $dado);
        $dado = strip_tags($dado);
        $dado = preg_replace("/(--|;|from|select|insert|delete|where|drop table|show tables)/",'', $dado);
        return $dado;
    }
}

?>