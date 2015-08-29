<?php
require_once('ArquivoTexto.class.php');
/**
 * Essa classe é reponsável por criar na RAIZ o aruivo DEPURAR.TXT.
 * Nesse arquivo são coletadas informações de depuração já configuradas
 * e outras que podem vir a ser configuradas pelo programador.
 * A depuração é habilitada no arquivo de configuração na linha
 * Conf::$DEPURAR = true;
 * Quando habilitada, diversas informações de conexão e operações no banco de
 * dados são informadas, e podem ser vistas em: {edereço raiz do site}/depurar
 * @author alan
 */
class Depurar {

    public $caminho;

    public $arquivo;

    public $nomeArquivo;

    protected static $Depurar = null;
    private function  __construct() {
        // Crio o nome do Arquivo de Log
        /*$this->nomeArquivo = "index.html";
        // Capturo o Caminho Raiz do site
        $caminho        = Conf::$CAMINHO; // O caminho já vem com a ultima barra
        // Descubro o caracter que separa os diretorios
        $ds             = Conf::$DS;
        // Configuro o Camino com o nome do arquivo
        $this->caminho  = "{$caminho}depurar{$ds}{$this->nomeArquivo}";
        // Crio um onjeto do tipo Arquivo Texto.
        $this->arquivo  = new ArquivoTexto($this->caminho);
        if($this->arquivo->criar()) {
            echo "<a href='depurar/index.html'><span id='depurar' style='font-size:5px;' >depurar</span></a><br>";
        } else {
            echo "N&atilde;o foi poss&iacute;vel criar o arquivo de depura&ccedil;&atilde;o<br> Verifique as permiss&otilde;es do diret&oacute;rio depurar<br>";
        }*/

    }
    /**
     * Função que faz o registro em Log
     * @param string $string - O texto que será inserido no log
     * @return boolean - retorna true ou false (apos a escrita do arquivo)
     */
    public static function reg($string) {
        // Se não houverem
        /*if (self::$Depurar == null) {
            self::$Depurar = new Depurar();
            self::$Depurar->arquivo->deletar();
            self::$Depurar->arquivo->criar();
        }
        $arquivo = self::$Depurar->arquivo;
        return $arquivo->escrever("{$string}<br>\n");*/
        
    }
}
?>
