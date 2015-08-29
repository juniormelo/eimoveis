<?php
/**
 * Classe para realizar o registro de logs.
 * Implementa o padrão de projeto silngleton
 * @author alan
 * Instruções para o Uso da Classe.
 * 1) Você precisará criar na raiz do site(ou seja, a pasta onde está o
 *    config.php da arquitetura guardachuva) um diretorio com permissão
 *    de leitura/escrita chamado log (em minusculo mesmo).
 * 2) Chamar a função estática:
 *    Log::reg("MENSAGEM QUALQUER");
 * 3) No 1º será criado (se não existir um arquivo na pasta log chamado
 *    logANOMESDIA.log por exemplo log20100322.log
 * 4) Em cada linha da mensagem há, separado por tabulação, registro da data (no
 *    formato DATE_RFC822, o IP de origem, o Usuario (Aquele que estiver armazenado
 *    na sessão $_SESSION['USUARIO']) e o Hash do conteudo da linha + Conf::chave.
 * Tue, 30 Mar 10 00:05:29 -0300	200.124.56.34	naoLogado	TESTE	1c43d5dc92b04206a89777059f455b4a
 * @example
 * <code>
 * include_once "config.php";
 * // Incluo um registro de log com o texto TESTE
 * Log::reg("TESTE");
 * // Incluo um registro de log com o texto POPOO
 * Log::reg("POPOO");
 * // Incluo um registro de log com o texto XXXXX
 * Log::reg("XXXXX");
 * // Verifico se o arquivo de log atual é consistente.
 * Log::validaLog();
 * // Verifico se um arquivo de log é válido.
 * Log::validaLog("/home/alan/www/guardaChuva/log/log20100407.log");
 * </code>
 */
class Log {

    public $caminho;

    public $ip;

    public $usuario;

    public $arquivo;

    public $nomeArquivo;

    public static $log = null;
    /**
     * Construtor do Arquivo de Log.
     * @param string $arquivo inicial do Arquivo.
     */
    private function  __construct($caminho = null) {
        // Armazeno o IP da máquina cliente
        $this->ip       = $_SERVER['REMOTE_ADDR'];
        // Crio o nome do Arquivo de Log
        $this->nomeArquivo = "log{$this->dataLog()}.log";
        // Capturo a informação de usuário na sessão
        if(isset($_SESSION['USUARIO'])) {
            $this->usuario  = $_SESSION['USUARIO'];
        } else {
            $this->usuario  = "nulo";
        }
        if($caminho == null) {
            // Capturo o Caminho Raiz do site
            $caminho        = Conf::$CAMINHO;
            // Descubro o caracter que separa os diretorios
            $ds             = Conf::$DS;
            $this->caminho  = "{$caminho}log{$ds}{$this->nomeArquivo}";

        } else {
            $this->caminho = $caminho;
        }

        $this->arquivo  = new ArquivoTexto($this->caminho);
    }
    /**
     * Função que faz o registro em Log
     * @param string $string - O texto que será inserido no log
     * @return string - retorna o texto armazenado o nome do arquivo e o hash
     */
    public static function reg($string) {
        // Se não tiver objetos criados crio um.
        if(is_null(self::$log)) {
            self::$log = new Log();
        }

        // Construo a String completa que será inserida.
        $data = date(DATE_RFC822);
        $CHAVE = Conf::pegCHAVE();
        // Objeto Singleton!
        $a          = self::$log;
        // Construo a string do registro.
        $linhaLog   = "{$data}\t{$a->ip}\t{$a->usuario}\t{$string}";
        // Faço o Hash da Linha (juntando a Chave)
        $hash       = md5($linhaLog . $CHAVE);
        // Escrevo no Arquivo.
        $resultado  = self::$log->arquivo->escrever("{$linhaLog}\t{$hash}\t\n");
        if(!$resultado) {
            die("ERRO FATAL: N&ATILDE;O FOI POSS&IACUTE;VEL REALIZAR O LOG - VERIFIQUE PERMISS&OTILDE;ES NA PASTA DE LOG!!! MAIS INSTRU&CCEDIL;&OTILDE;ES NO INICIO DA CLASSE bib/Log.class.php");
        }
        return "REGISTRO DE LOG: $hash - ARQUIVO:" . self::$log->nomeArquivo;
    }
    /**
     * Função para retorno de data
     * @return data no formato AnoMesDia  ex: 20100320
     */
    protected function dataLog() {
        list($ano, $mes, $dia) = split('-', date("Y-m-d"));
        return "{$ano}{$mes}{$dia}";
    }
    /**
     * Função para validar Arquivos de Log.
     * Se você não informar um caminho a classe vai tentar validar o arquivo
     * atual.
     * Se validar retorna true.
     */
    public static function validaLog($caminho = null) {
        // Se não existir um objeto Log ou se o Caminho atual é diferente do
        // caminho informado
        if((is_null(self::$log))||(self::$log->caminho != $caminho)) {
            // Eu crio um novo objeto
            self::$log = new Log($caminho);
        }
        // Abro o arquivo de log.
        $arquivo = self::$log->arquivo;
        $ln = $arquivo->leConteudo();
        foreach ($ln as $tx) {
            if($tx) {
                list($data, $ip, $usuario, $texto, $hash) = split("\t", $tx);
                $linha = "{$data}\t{$ip}\t{$usuario}\t{$texto}";
                // Crio novamente a chave
                $chk = md5($linha . Conf::pegCHAVE());
                // Confiro se as chaves estão ok.
                if($chk == $hash) {
                    return true;
                } else {
                    $caminho = self::$log->caminho;
                    die("O arquivo {$caminho} foi adulterado");
                }
            }
        }
    }
}
?>