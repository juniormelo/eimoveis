<?php
/* 
 * Arquivo de definição da classe Arquivo.
*/
/**
 * A classe arquivo é a representação de um arquivo no sistema.
 * @example
 * <code>
 * include_once "config.php";
 * $a = new Arquivo('depurar.php');
 * if($a->arquivoExiste()){
 *     echo "Ecziste!";
 * } else {
 *     echo "Non Ecziste!";
 * }
 * </code>
 * @author alan
 */
class Arquivo {
    /**
     * É o caminho onde o arquivo será armazenado no sistema.
     * @var string
     */
    protected $caminho;
    /**
     * É o recurso (o arquivo de fato)
     * @var recurso
     */
    protected $arquivo;
    /**
     * O caminho completo do arquivo (incluindo o nome e a extensão).
     * @param string $caminho
     */
    public function __construct($caminho) {
        $this->caminho = $caminho;
    }
    /**
     * Verifica se o arquivo existe ou não
     * @return boolean
     */
    public function arquivoExiste() {
        if (file_exists($this->caminho)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Cria o Arquivo
     * @return boolean
     */
    public function criar() {
        $this->arquivo = fopen($this->caminho,'a');
        fclose($this->arquivo);
        if($this->arquivo){
            return true;
        } else {
            return false;
        }

    }
    /**
     * Apaga o Arquivo
     * @return boolean
     */
    public function deletar() {
        if($this->arquivoExiste()){
            return unlink($this->caminho);// Retorna True ou False
        } else {
            // Se o arquivo já não existia, então não é possível deleta-lo
            return false;
        }
        
    }

}
?>