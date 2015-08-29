<?php
/* 
 * Arquivo de definição da classe Arquivo.
*/
require_once('Arquivo.class.php');
/**
 * A classe ArquivoTexto é a representação de um arquivo texto no sistema.
 * @author alan
 * @example
 * <code>
 * include_once "config.php";
 * $a = new ArquivoTexto('log/texto.txt');
 * $a->escrever("ALABLA KKKKK\n");
 * $a->escrever("BLABLA KKKKK\n");
 * $a->escrever("CLABLA KKKKK\n");
 * var_dump($a->leConteudo());
 * </code>
 */
class ArquivoTexto extends Arquivo {
    /**
     * São as linhas de um arquivo texto.
     * @var array de linhas do arquivo texto
     */
    protected $conteudo;
    /**
     * Abre o arquivo para a Leitura
     * @return boolean
     */
    protected function abrirLeitura() {
        if($this->arquivoExiste()) {
            if($this->ehLegivel()) {
                $this->arquivo = fopen($this->caminho,'r');
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * Abre o arquivo para a Escrita
     * @return boolean
     */
    protected function abrirEscrita() {
        if($this->arquivoExiste()) {
            if($this->ehLegivel()) {
                $this->arquivo = fopen($this->caminho,'a');
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * Abre o arquivo para a Escrita
     * @return boolean
     */
    protected function fechar() {
        fclose($this->arquivo);
    }
    /**
     * Le o arquivo e coloca o conteúdo em um array de linhas.
     * @return boolean
     */
    public function ler() {
        if($this->abrirLeitura()) {
            while(!feof($this->arquivo)) {
                $this->conteudo[] = fgets($this->arquivo);
            }
            $this->fechar();
            return true;
        } else {
            $this->conteudo[] = "nao foi possivel abrir o arquivo";
            return false;
        }
    }
    /**
     * Escreve o arquivo e coloca o conteúdo em um array de linhas.
     */
    public function escrever($texto) {
        if($this->abrirEscrita()) {
            fwrite($this->arquivo, $texto);
            $this->fechar();
            return true;
        } else {
            return false;
        }
    }
    /**
     * Escreve o arquivo e pula uma linha coloca o conteúdo em um array de linhas.
     */
    public function escreverLinha($texto) {
        if($this->abrirEscrita()) {
            fwrite($this->arquivo, $texto . "\n");
            fclose($this->arquivo);
            return true;
        } else {
            return false;
        }
    }
    /**
     * Verifica se o arquivo é legível
     * @return boolean
     */
    protected function ehLegivel() {
        return is_readable($this->caminho);
    }
    /**
     * Verifica se o arquivo pode ser alterável
     * @return boolean
     */
    protected function ehAlteravel() {
        return is_writable($this->caminho);
    }
    /**
     * Retorna um array com o conteúdo do arquivo linha a linha.
     * @return array
     */
    public function leConteudo() {
        $this->conteudo = null;
        $this->ler();
        return $this->conteudo;
    }
}
?>