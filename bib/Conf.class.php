<?php
/* 
 * Classe de Configuração do Sistema - Utilizada para configurar
 */
/**
 * Essa classe ira carregar as variáveis Padrão de configuração por todo o sistema
 * A vantagem de utilizar essa classe é que não será necessário declarar variáveis
 * globais por todo o sistema. A classe implementa o padrão singleton para a
 * conexao padrão com o banco de dados.
 * @author alan
 */
class Conf {
    /**
     * Variavel que guarda o tipo de banco de dados PADRÃO a ser utilizado na
     * conexao.
     * Os tipos previstos são:
     * pgsql - PostgreSQL
     * mysql - MySQL
     * sqlite- SQLite
     * ibase - InterBase
     * oci8  - Oracle
     * mssql - Microsoft SQL
     * IMPORTANTE: Para que os tipos funcionem é preciso que o PDO PHP Data Object
     * e o respectivo driver pdo_<driver> esteja devidamente instalado.
     * Exemplo: Para utilizar com o oracle é necessário que o pdo_oci8 esteja
     * instalado e funcionando. Verifique na documentação do PHP os detalhes do
     * dos drivers PDO (http://www.php.net/manual/en/pdo.drivers.php)
     * @var string apelido do banco de dados conforme a descrição acima
     * @example Conf::$TIPO_BANCO = "mysql";
     */
    public static $TIPO_BANCO;
    /**
     * É o endereço do Banco de Dados Padrão do Sistema. Normalmente em ambientes
     * de teste utiliza-se "localhot";
     * @var string O endereço IP ou o nome do Servidor de Banco de Dados
     * @example Conf::$END_SERVIDOR = "localhost";
     */
    public static $END_SERVIDOR;
    /**
     * É a base de dados padrão a ser utilizado no sistema. Você poderá configurar
     * diversos objetos de conexão com o banco de dados se preferir, conectando a
     * bases de dados diferentes. A intenção é ter uma conexão padrão já pronta.
     * @var string nome da base de dados criada.
     * @example Conf::$BASE_DADOS = "teste";
     */
    public static $BASE_DADOS;
    /**
     * É o nome do usuário do banco de dados que será utilizado para acessar o banco
     * de dados.
     * @var string nome do usuario do banco de dados
     * @example Conf::$USUARIO_DB = "root";
     */
    public static $USUARIO_BD;
    /**
     * É o nome do usuário do banco de dados que será utilizado para acessar o banco
     * de dados.
     * @var string senha do usuario do banco de dados
     * @example Conf::$SENHA_BD = "123";
     */
    public static $SENHA_BD;
    /**
     * É a URL padrão do site, no caso de algum redirecionamento.
     * @var string URL raiz do site
     * @example Conf::$URL_SITE = "http://localhost/teste";
     */
    public static $URL_SITE;
     /**
     * É a paginação das consultas;
     * @var string
     */
    public static $PAGINACAO;
    /**
     * A chave criptográfica que será utilizada sempre que necessário.
     * essa chave é privada pois precisamos registrar todas as vezes que a chave
     * for modificada para poder realizar as perícias no sistema.
     * @var string a Chave criptográfica a ser utilizada no sistema
     */
    private static $CHAVE;
    /**
     * Quando habilitada, registra na pasta log as atividades do banco de dados
     * para auxiliar na depuração do código.
     * @var boolean
     * @example Conf::$DEPURAR = true; // Habilio a deputação do código.
     */
    public static $DEPURAR = false;
    /**
     * Caminho absoluto da RAIZ do Site. É importante preservar a posicao das
     * pastas conforme são disponibilizadas. Baseada no arquivo de configuração
     * chamado config.php.
     * Se você estiver no Windows vai retornar algo como C:\xampp\htdocs\pasta\
     * Se você estiver no linux
     * @var string
     */
    public static $CAMINHO;
    /**
     * Caracter utilizado para separar diretorios pode ser "\" ou "/"
     * @var string
     */
    public static $DS;
    /**
     * É o objeto da classe Conexão que representa a Conexão padrão do sistema.
     * @var Conexao
     */
    private static $CONEXAO = null;
   
    /**
     * Configura uma chave para auxiliar a criptografia dos dados. Essa chave
     * é adicionada ao final de cada linha de registro de segurança do log, para
     * criar o hash md5 e dificultar a inclusão de dados falsos nos arquivos de
     * log. Essa chave é armazenada em um arquivo de chaves contendo a data de
     * criação da chave.
     * @param string $chave
     */        
    public static function altCHAVE($chave){
        /**
         * @todo registrar em um arquivo todas as chaves criadas e a data e hora de
         * criação da chave.
         */
        self::$CHAVE = $chave;
    }
    /**
     * Método que retorna a Chave de Criptografia Vigente
     * @param string $param
     * @return mixed Depende dos parametros armazenados
     */
    public static function pegCHAVE(){
        /**
         * @todo se a chave não tiver sido criada então o sistema sorteia uma chave
         * armazena utilizando o setCHAVE (para registrar no arquivo) e depois le
         * o arquivo com as chaves e pega a última chave válida.
         */
        return self::$CHAVE;
    }
    /**
     * Retorna a conexao Padrão configurada no arquivo config.php
     * @return Conexao
     */
    public static function pegCnxPadrao(){
        if(is_null(self::$CONEXAO)){
            self::$CONEXAO = new Conexao(self::$TIPO_BANCO, self::$END_SERVIDOR, self::$BASE_DADOS, self::$USUARIO_BD,self::$SENHA_BD);
        }
        return self::$CONEXAO;
    }    
    /**
     * Função que configura o PHP para exibir todos os erros cometidos.
     */
    public static function exibeTodosErros(){
        error_reporting(E_ALL);        
        ini_set("display_errors", 1 );
    }
    /**
     * Função que configura o PHP para não exibir erros.
     */
    public static function ocultaTodosErros(){
        error_reporting(0);
    }

}
/**
 * Configurações para carregar automaticamente as classes do PHP e evitar o uso
 * de includes por todo o código para carregar CLASSES!
 */

function __autoload($classe)
{
    $CAMINHO    = Conf::$CAMINHO;
    $DS         = Conf::$DS;
	// Essa função procura a classe no caminho Raiz.
    if (file_exists("{$CAMINHO}{$classe}.class.php"))
    {
        include_once "{$CAMINHO}{$classe}.class.php";
    }
    // Se não existir na Raiz procura em bib
    // São as Classes da biblioteca.
    $caminho 	= $CAMINHO . "bib" . $DS;
    if (file_exists("$caminho$classe.class.php"))
    {
        include_once "$caminho$classe.class.php";
    }
    $caminho  = "{$CAMINHO}{$DS}app{$DS}";
    // Se não existir na Raiz procura em app model
    // São as classes Modelo que extendem o Modelo
    if (file_exists("{$caminho}{$DS}model{$DS}{$classe}.class.php"))
    {
        include_once "{$caminho}{$DS}model{$DS}{$classe}.class.php";
    }
    // Se não existir em model verifca em app/view
    // São as classes View do MVC
    if (file_exists("{$caminho}{$DS}view{$DS}{$classe}.class.php"))
    {
        include_once "{$caminho}{$DS}view{$DS}{$classe}.class.php";
    }
    // Se não existir em vier verifca em app/control
    // São as classes de Controle do MVC
    if (file_exists("{$caminho}{$DS}control{$DS}{$classe}.class.php"))
    {
        include_once "{$caminho}{$DS}control{$DS}{$classe}.class.php";
    }
}

?>