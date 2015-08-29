<?php
/*
 * Arquivo de Configuracao da Classe Conexao
 * @author Informática PR/RN <informatica@prrn.mpf.gov.br> em 18/08/2008
 * @version 1.1
 * @package bd
 */
/**
 * classe Conexao
 * Gerencia as conexões com banco de dados
 * @example
 * <code>
 * include_once "config.php";
 * $cnxIntra = new Conexao("mysql", "servidor","banco","usuario","senha");
 * $cnxIntra->getConexao();
 * </code>
 */
class Conexao {
/**
 *
 * @var boolean - Verifica se o modo transacional está ativo
 */
    protected $transacao = false;

    /**
     * Variavel que guarda o tipo de banco de dados a ser utilizado na conexao.
     * Os tipos previstos são:
     * pgsql - PostgreSQL
     * mysql - MySQL
     * sqlite- SQLite
     * ibase - InterBase
     * oci8	 - Oracle
     * mssql - Microsoft SQL
     * IMPORTANTE: Para que os tipos funcionem é preciso que o pdo PHP Data Object
     * e o respectivo driver pdo_<driver> esteja devidamente instalado.
     * Exemplo: Para utilizar com o oracle é necessário que o pdo_oci8 esteja
     * instalado e funcionando. Verifique na documentação do PHP.
     * @access private
     * @var string tipo do banco de dados
     */
    private $tipo;
    /**
     * @access private
     * @var string endereço ou o nome do servidor de banco de dados
     */
    private $servidor;
    /**
     * @access private;
     * @var string nome do banco de dados, base de dados, serviço ou schema
     */
    private $base;
    /**
     * @access private;
     * @var string nome do usuário do banco de dados
     */
    private $usuario;
    /**
     * @access private;
     * @var string senha do usuário do banco de dados
     */
    private $senha;
    /**
     * @access private;
     * @var int porta utilizada para o Banco de Dados
     */
    private $porta;
    /**
     * @access private;
     * @var object Objeto do pdo_mysql
     */
    private $conexao = null;
    /**
     * Construtor da Classe
     * @param string $tipo tipo do banco de dados
     * @param string $servidor endereço ou o nome do servidor de banco de dados
     * @param string $base nome do banco de dados, base de dados, serviço ou schema
     * @param string $usuario nome do usuário do banco de dados utilizado na conexao
     * @param string $senha senha do usuário do banco de dados utilizado na conexao
     */
    public function __construct($tipo, $servidor, $base, $usuario, $senha, $porta = false) {
        $this->tipo = $tipo;
        $this->servidor = $servidor;
        $this->base = $base;
        $this->usuario = $usuario;
        $this->senha = $senha;
        $this->porta = $porta;
    }
    public function __destruct() {
        if($this->transacao) {
            $this->fimTransacao();
        }
        $this->conexao = null;
    }
    /**
     *  Cria a conexão e retorna um objeto do tipo PDO
     * @deprecated
     */
    public function getConexao() {
        try {
            if ($this->conexao == null) {
                switch ($this->tipo) {
                    case 'pgsql' :
                        $this->conexao = new PDO("pgsql:dbname={$this->base};user={$this->usuario}; password={$this->senha};host=$this->servidor");
                        break;
                    case 'mysql' :
                        $this->conexao = new PDO("mysql:dbname=$this->base;port=3306;host=$this->servidor", $this->usuario, $this->senha);
                        break;
                    case 'sqlite' :
                        $this->conexao = new PDO("sqlite:{$this->base}");
                        break;
                    case 'ibase' :
                        $this->conexao = new PDO("firebird:dbname={$this->base}", $this->usuario, $this->senha);
                        break;
                    case 'oci8' :
                        $this->conexao = new PDO("oci:dbname={$this->base}", $this->usuario, $this->senha);
                        break;
                    case 'mssql' :
                        $this->conexao = new PDO("mssql:host={$this->servidor},1433;dbname={$this->base}", $this->usuario, $this->senha);
                        break;
                }
                Depurar::reg("[CONFIG] BANCO TIPO {$this->tipo}");
                // define para que o PDO lance exceções na ocorrência de erros
                $this->conexao->setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
            }
            // retorna o objeto instanciado.
            return $this->conexao;
        }catch ( PDOException $ex ) {
            //echo $ex;
            //die();
            $frontend = (isset($_SESSION['app'])) ? (($_SESSION['app'] == 'FRONT') ? true : false) : false;
            $backend  = (isset($_SESSION['app'])) ? (($_SESSION['app'] == 'BACK') ? true : false) : false;
            
            if ($frontend) {
                echo "<h1>Falha de comunicação com o servidor</h1>";                
                //header("Location: ../index.php");                
                //echo '<script type="text/javascript">location.href="index.php?action=falhacomunicacaoserver";</script>';
                //echo $ex;
                die();
                //header("Location: index.php?action=falhacomunicacaoserver");
            } else if ($backend) {
                //header("Location: sistema.php?action=falhacomunicacaoserver");
                echo '<script type="text/javascript">location.href="sistema.php?action=falhacomunicacaoserver";</script>';
            } else {
                echo '<script type="text/javascript">location.href="administracao.php?action='+md5('1')+'";</script>';
                //header("Location: administracao.php?action="+md5('1'));
            }
            
            /*else {
                echo "<h1>Falha de comunicação com o servidor</h1>";
                Depurar::reg("[ERRO] {$ex->getMessage()}");
                die();
            }            */
            //echo "Verifique se o arquivo config.php est&aacute; corretamente configurado<br />";
            //echo "Erro: ".$ex->getMessage();
            //Depurar::reg("[ERRO] {$ex->getMessage()}");
            //die();
        }

//        return $this->conexao;
    }
    /**
     * Retorna a Conexão
     * @return Conexao
     */
    public function pegConexao(){
        return $this->getConexao();
    }
    /**
     * Inicia uma transação com o Banco de Dados
     */
    public function iniTransacao() {
        $cnx = $this->getConexao();
        if(!$this->transacao) {
            $this->transacao = true;
            $cnx->beginTransaction();
            Depurar::reg("[INI TRANS]");
        }
    }
    /**
     * Termina uma transação com o Banco de Dados
     */
    public function fimTransacao() {
        if($this->transacao) {
            $cnx = $this->getConexao();
            try {
                $cnx->commit();
                Depurar::reg("[FIM TRANS]");
                $status = true; 
            } catch (Exception $e) {
                $cnx->rollBack();
                //echo "[ERRO] ROLLBACK TRANS" . $e->getMessage();
                //die();
                Depurar::reg("[ERRO] ROLLBACK TRANS" . $e->getMessage());
                $status = false;
                //echo "Aconteceu um Erro: " . $e->getMessage();
                //die();
            }
        } else {
            $status = false;
        }
        $this->transacao = false;
        return $status;
    }
}
?>