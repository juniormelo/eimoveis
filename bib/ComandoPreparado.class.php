<?php
/**
 * Arquivo de Configuração da Classe ComandoPreparado
 * @author informatica <informatica@prrn.mpf.gov.br>
 * @version 1.1
 * @package bib
 */
/**
 * classe ComandoPreparado
 * Utilizada para executar instruções SQL em um Banco de Dados que NÃO retornam conjunto de dados.
 * Como por exemplo INSERT, UPDATES, DELETES, execução de StoreProcedures (que não retornam conjunto
 * de dados e etc..)
 * @example
 * <code>
 * include_once "config.php";
 * $cnxIntra = new Conexao("mysql", "localhost","teste","root","root123");
 * $sql = "INSERT INTO `justica` (`nome`, `estado`) VALUES (:nome, :uf)";
 * $queryIntra = new ComandoPreparado($cnxIntra, $sql);
 * $queryIntra->liga("nome", 'ALAN TESTANDO');
 * $queryIntra->liga("uf", "RN");
 * echo $queryIntra->executa(); // Retorna 1 (Que é a quantidade de Registros afetados)!
 * echo $queryIntra->getUltimoId(); // Retorna o Ultimo Id Autoincrement
 * </code>
 */
class ComandoPreparado extends Comando {
        /**
         * Faz a ligação de um valor a um campo
         * @param string $campo
         * @param mixed $valor
         */

        public function liga($campo, $valor, $tipo = "STRING") {
        /*
         * Ajusto o tipo da variáveL
         */
        switch (strtoupper($tipo)) {
            case "BOOLEAN" :
                $tp = PDO::PARAM_BOOL;
                break;
            case "NULL" :
                $tp = PDO::PARAM_NULL;
                break;
            case "INT" :
                $tp = PDO::PARAM_INT;
                break;
            case "BLOB" :
                $tp = PDO::PARAM_LOB;
                break;
            default:
                $tp = PDO::PARAM_STR;
                break;
        }
        /* Tento ligar um valor ao parâmetro */
        Depurar::reg("Parametro: {$campo} Tipo:{$tipo} Valor:{$valor}");
        try {
            $this->resultado->bindValue(":" . $campo, $valor, $tp);
            //echo "liguei :{$campo} a {$valor}";
        } catch (PDOException $e)  {
            die( $e-getMessage());
        }

	}
}


?>