<?php
/**
 * Arquivo de Configuração da Classe ConsultaPreparada
 * @author informatica <informatica@prrn.mpf.gov.br>
 * @version 1.0
 * @package bib
 */
/**
 * classe ConsultaPreparada
 * Utilize para executar consultas preparada para um Banco de Dados que retornam conjunto de dados.
 * @example
 * <code>
 * include_once "config.php";
 * $cnx = new Conexao("mysql", "localhost","teste","root","root123");
 * $sql = "SELECT * FROM `usuario` WHERE login = :login AND senha = :senha;";
 * $con = new ConsultaPreparada($cnx, $sql);
 * $con->liga("login", 'zeruela');
 * $con->liga("senha", md5('123'));
 * echo "\n Numero de Registros:" . $con->getQtdeLinhas();
 * echo "\n Numero de Campos:" . $con->getQtdeCampos();
 * echo "\n Cabecalho: ";
 * foreach($con->getCampos() as $Campo) {
 *     echo $Campo . " \n";
 *
 * }
 * foreach($con->getResultados() as $linha) {
 *     foreach($linha as $campo=>$valor) {
 *         echo "\n$campo = $valor ";
 *    } echo
 *     " ";
 * }
 * </code>
 */
class ConsultaPreparada extends Consulta {
/**
 * Função para ligar uma variável a um valor
 * @param string $campo
 * @param string $valor
 * @param string $tipo (STRING = DEFAULT, NULL, INT, STRING, BLOB)
 * param CONSTANTES $tipo
 * Tipos constantes:
 * Os tipos são:
 * "BOOLEAN"    ->  PDO::PARAM_BOOL  (integer)
 * Representa um tipo de dados booleano.
 * "NULL"       ->  PDO::PARAM_NULL (integer)
 * Representa um tipo de dados nulo.
 * "INT"        ->  PDO::PARAM_INT (integer)
 * Representa o um tipo de dado inteiro
 * "STRING      -> PDO::PARAM_STR (integer)
 * Representa o CHAR, VARCHAR, ou outros tipos de dados string.
 * "BLOB"       -> PDO::PARAM_LOB (integer)
 * Representa o tipo de dado BLOB - Binary Large Objects
 * param int Tamanho
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
/**
 * @example
 * <code>
 * include_once "config.php";
 * $cnxIntra = new Conexao("mysql", "localhost","teste","root","root123");
 * $sql = "SELECT * FROM `usuario` WHERE login = :login AND senha = :senha;";
 * $queryIntra = new ConsultaPreparada($cnxIntra, $sql);
 * $queryIntra->liga("login", 'zeruela');
 * $queryIntra->liga("senha", '123');
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
?>