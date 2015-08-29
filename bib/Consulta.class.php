<?php
/**
 * Arquivo de Configuração da Classe Consulta
 * @author informatica <informatica@prrn.mpf.gov.br>
 * @version 1.1
 * @package bib
 */
/**
 * classe Consulta
 * Utilizada para executar consultas SQL em um Banco de Dados que retornam conjunto de dados.
 * Para as ações no banco que não retornam conjunto de dados, como por exemplo INSERT, UPDATES
 * DELETES, execução de StoreProcedures (que não retornam conjunto de dados e etc..) utilize a
 * classe Comando
 * @example
 * <code>
 * include_once "../../config.php";
 * $cnxIntra = new Conexao("mysql", "localhost","teste","root","root123");
 * $cnxIntra->getConexao();
 * $queryIntra = new Consulta($cnxIntra, "SELECT * FROM processo");
 * echo "\n<br>Numero de Registros:" . $queryIntra->getQtdeLinhas();
 * echo "\n<br>Numero de Campos:" . $queryIntra->getQtdeCampos();
 * echo "\n<br>Cabecalho:<br>";
 * foreach($queryIntra->getCampos() as $Campo){
 * 	echo $Campo . "<br>\n";
 * }
 * foreach($queryIntra->getResultados() as $linha){
 * 	foreach($linha as $campo=>$valor){
 * 		echo "\n$campo = $valor<br>";
 * 	}
 * 	echo "<br>";
 * }
 * </code>
 */
class Consulta {
    /**
     * Variavel que armazena a string de consulta a ser utilizada no Banco de Dados
     * @access protected;
     * @var string Ultimo Comando SQL usado
     */
    protected $stringSQL;
    /**
     * Variavel que armazena o conjunto de resultados
     * @access protected;
     * @var array array contendo o conjunto de resultados
     */
    protected $resultado = null;
    /**
     * Variavel que armazena o conjunto de campos
     * @access protected;
     * @var array array contendo o conjunto de campos
     */
    protected $campos = null;
    /**
     * Variavel que armazena a conexao ao Banco de Dados
     * @access protected;
     * @var PDO - Conexao com o Banco de Dados
     */
    protected $conexao = null;
    /**
     * Variavel que verifica se já houve a execucação da consulta
     * @access protected;
     * @var boolean
     */
    protected $exec = false;
    /**
     * Variavel que armazena o array apos as consultas
     * @access protected;
     * @var boolean
     */
    protected $dados = false;

    /**
     * Construtor da Classe
     * @param object $conexao Objeto do tipo MConexao
     * @param string $sql comando SQL a ser executado
     */

    public function __construct ($conexao=null, $sql=null) {
        //die($sql);        
        if(!is_a($conexao, "Conexao")) {
            $erro = ":A Conexao n&atilde;o foi informada ou o 1o parametro n&atilde;o e uma Conex&atilde;o!<br />{$sql}";
            Depurar::reg("[ERRO]" . __FILE__ . ":" . __LINE__ . $erro);
            die(__FILE__ . ":" . __LINE__ . $erro);
        } else {
            $this->conexao	= $conexao->getConexao();
        }
        if(empty($sql)) {
            $erro = ":&Eacute; preciso informar uma String de Consulta ao Banco de Dados!";
            Depurar::reg("[ERRO]" . __FILE__ . ":" . __LINE__ . $erro);
            die(__FILE__ . ":" . __LINE__ . $erro);

        }
        $this->stringSQL= $sql;
        Depurar::reg("[SQL] {$sql}");
        $this->resultado= $this->conexao->prepare($this->stringSQL);
    }
    /**
     * Método que retorna um array com os resultados retornados da consulta ao banco de dados
     * @deprecated
     */
    public function getResultados() {
        $this->executa();
        if(!$this->dados) {
            $this->dados = $this->resultado->fetchAll(PDO::FETCH_ASSOC);
        }
        return $this->dados;
    }
    /**
     * Método que retorna um array com os resultados retornados da consulta ao banco de dados
     * @return array de array associativo (matriz)
     */
    public function pegResultados() {
        return $this->getResultados();
    }
    /**
     * Método que retorna um array baseado em números com os resultados retornados da consulta ao banco de dados
     * @deprecated
     */
    public function getResultadosNum() {
        $this->executa();
        if(!$this->dados) {
            $this->dados = $this->resultado->fetchAll(PDO::FETCH_NUM);
        }
        return $this->dados;
    }
    /**
     * Método que retorna um array baseado em números com os resultados retornados da consulta ao banco de dados
     * @return array de array (matriz)
     */
    public function pegResultadosNum() {
        return $this->getResultadosNum();

    }
    /**
     * Método que retorna um array com todos os campos retornados na consulta ao banco de dados
     * @deprecated
     */
    public function getCampos() {
        $campos = array_keys($this->getLinha());
        return $campos;
    }
    /**
     * Método que retorna um array com todos os campos retornados na consulta ao banco de dados
     * @return array
     */
    public function pegCampos() {
        return $this->getCampos();
    }
    /**
     * Método que retorna a quantidade de Campos retornados
     */
    public function getQtdeCampos() {
        $this->executa();
        return $this->resultado->columnCount();
    }
    /**
     * Retorna a quantidade de Campos encontrados na consulta.
     * @return int
     */
    public function pegQtdCampos() {
        return $this->getQtdeCampos();
    }
    /**
     * Método que retorna a quantidade de Registros
     * @deprecated
     */
    public function getQtdeLinhas() {
        $this->executa();
        return $this->resultado->rowCount();
    }
    /**
     * Método que retorna a quantidade de Registros ret
     * @return int
     */
    public function pegQtdLinhas() {
        return $this->getQtdeLinhas();
    }
    /**
     * Método que executa a consulta
     */
    public function executa() {
        if(!$this->exec) {
            try {
                $ret = $this->resultado->execute();
                $this->dados = false;
                $this->exec = true;
            }catch(PDOException $e) {
                $this->conexao->rollBack();
                Depurar::reg("[ERRO] " . $e->getMessage());
            }

            Depurar::reg("[OK]");
//            $this->resultado->execute();
//            $this->dados = false;
//            $this->exec = true;
        }
    }
    /**
     * Método que retorna uma linha da consulta
     * @deprecated
     */
    public function getLinha($linha=0) {
        $linhas = $this->getResultados();
        $ret = $linhas[$linha];
        return $ret;
    }
    /**
     * Método que retorna uma linha específica do resultado.
     * Se a linha não for informada, ele retornará a primeira linha
     * @param int $linha
     * @return array associativo chave valor
     */
    public function pegLinha($linha=0) {
        return $this->getLinha($linha);
    }
    /**
     * Método que retorna a 1ª linha do resultado da consulta.
     * @return array associativo
     */
    public function pegResultado() {
        return $this->getLinha();
    }
}
?>