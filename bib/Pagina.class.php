<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Descrição da Classe Página.
 *
 * @author alan
 */
class Pagina {
    protected $docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
    protected $tagHTML = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">';
    protected $meta;
    protected $js;
    protected $css;
    protected $conteudo;
    protected $titulo  = 'GuardaChuva - Framework - Troque o Título';
    /**
     * Adiciona Javascript para a Página
     * @param string $caminhoJS caminho do JavaScript
     */
    public function adJs($caminhoJS) {
        $this->js[] = $caminhoJS;
    }
    /**
     * Adiciona CSS para a Página
     * @param string $caminhoCSS caminho do CSS a partir da página index.php
     */
    public function adCSS($caminhoCSS) {
        $this->css[] = $caminhoCSS;
    }
    /**
     * Adiciona metaTags para a Página
     * @param string $metaTags caminho do CSS a partir da página index.php
     */
    public function adMetaTags($metaTags) {
        $this->meta[] = $metaTags;
    }
    /**
     * Adiciona conteudo HTML a Página
     * @param string $conteudoHTML caminho do CSS a partir da página index.php
     */
    public function adConteudo($conteudoHTML) {
        $this->conteudo[] = $conteudoHTML;
    }
    /**
     * Muda o DocType da Página
     * O valor padrão é:
     * '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     * "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
     * @param string $docType Informe um DocType
     */
    public function trocaDocType($docType) {
        $this->docType = $docType;
    }
    /**
     * Muda o DocType da Página
     * O valor padrão é:
     * '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br" lang="pt-br">';
     * @param string $tagHTML Informe uma nova Tag Html
     */
    public function trocaTagHTML($tagHTML) {
        $this->docType = $tagHTML;
    }
    /**
     * Retorna o Cabecalho HTML do <head> ao </head> conforme as configurações
     * de meta tags, css e javascripts colocadas.
     * @return string
     */
    protected function pegHeader() {
        $header  = "\t<head>\n";
        $header .= "\t\t<title>" . $this->titulo . "</title>\n";
        if(isset ($this->js)) {
            foreach($this->js as $javaScript) {
                $header .= "\t\t$javaScript\n";
            }
        }
        if(isset ($this->css)) {
            foreach($this->css as $CSS) {
                $header .= "\t\t$CSS\n";
            }
        }

        if(isset ($this->meta)) {
            foreach($this->meta as $metaDados) {
                $header .= "\t\t$metaDados\n";
            }
        }

        $header .= "\t</head>\n";
        return $header;
    }

    public function pegConteudo() {
        $conteudo = "<body>";
        if(isset ($this->conteudo)) {
            foreach($this->conteudo as $conteudo) {
                $conteudo .= "\t\t$conteudo\n";
            }
        }
        return $conteudo . '</body>';

    }

    public function exibe() {
        $html  = $this->docType . "\n";
        $html .= $this->tagHTML . "\n";
        $html .= $this->pegaHeader();
        $html .= $this->pegaConteudo();
        $html .= "</html>";

        return $html;

    }
}
?>