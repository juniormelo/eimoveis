<?php
/**
 * Arquivo de Configuração da Classe Comando
 * @author informatica <informatica@prrn.mpf.gov.br>
 * @version 1.1
 * @package bib
 */
/**
 * classe Comando
 * Utilizada para executar instruções SQL em um Banco de Dados que NÃO retornam conjunto de dados.
 * Como por exemplo INSERT, UPDATES, DELETES, execução de StoreProcedures (que não retornam conjunto
 * de dados e etc..)
 * @example
 * <code>
 * include_once "config.php";
 * $cnxIntra = new Conexao("mysql", "localhost","teste","root","root123");
 * $sql = "INSERT INTO `justica` (`nome`, `estado`) VALUES
 * ('apague','RN'),
 * ('apague1','RN'),
 * ('apague2','RN')";
 * $queryIntra = new Comando($cnxIntra, $sql);
 * echo $queryIntra->executa(); // Retorna 3 (Que é a quantidade de Registros afetados)!
 * echo $queryIntra->getUltimoId(); // Retorna o Ultimo Id Autoincrement
 * </code>
 */
class Comando {
/**
 * Variavel que armazena a string de consulta a ser utilizada no Banco de Dados
 * @access protected;
 * @var string Ultimo Comando SQL usado
 */
    protected $stringSQL;
    /**
     * Variavel que armazena a conexao ao Banco de Dados
     * @access protected;
     * @var PDO - Conexao com o Banco de Dados
     */
    protected $conexao = null;
    /**
     * Variavel que armazena o conjunto de resultados
     * @access protected;
     * @var array array contendo o conjunto de resultados
     */
    protected $resultado = null;
    /**
     * Construtor da Classe
     * @param object $conexao Objeto do tipo MConexao
     * @param string $sql comando SQL a ser executado
     */
    public function __construct($conexao=null, $sql=null) {
        if(!is_a($conexao, "Conexao")) {
            $erro   = ":A Conex&atilde;o n&atilde;o foi informada ou o 1o par&acirc;metro n&atilde;o &eacute; uma Conex&atilde;o!";
            $string = __FILE__ . ":" . __LINE__ . $erro;
            $cod    = Log::reg($string, "ERRO");
            die($string . "\n Contate o Suporte\n LOG ERRO: {$cod}");

        } else {
            $this->conexao	= $conexao->getConexao();
        }
        if(empty($sql)) {
            $erro = ":&Eacute; preciso informar uma String de Consulta ao Banco de Dados!";
            $string = __FILE__ . ":" . __LINE__ . $erro;
            $cod    = Log::reg($string, "ERRO");
            die($string . "\n Contate o Suporte\n {$cod}");

        }
        //echo $sql . "<br>";
        Depurar::reg("[SQL] {$sql}");
        $this->stringSQL= $sql;
        $this->resultado= $this->conexao->prepare($this->stringSQL);
    }
    /**
     * Método que executa a Instrução SQL e retorna a quantidade de registros afetados.
     */
    public function executa() {
        $ret = "";
        try {
            $ret = $this->resultado->execute();
        }catch(PDOException $e) {
            $this->conexao->rollBack();
            Depurar::reg("[ERRO] " . $e->getMessage());
            echo 'ERRo: '.$e->getMessage();
            die();
        }
        if(!$ret) {
            $erro = ":Problemas na Execu&ccedil;&atilde;o do Comando SQL!";
            die(__FILE__ . ":" . __LINE__ . $erro);
        }
        return $this->resultado->rowCount();
    }
    /**
     * Método que retorna o Último ID inserido.
     * @deprecated
     */
    public function getUltimoId() {
        $id = $this->conexao->lastInsertId();        
        return $id;

    }
    /**
     * Método que retorna o Último ID inserido.
     * @return int
     */
    public function pegUltimoId() {
        return $this->getUltimoId();
    }
}
?>