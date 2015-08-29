<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of LayoutPadraoclass
 *
 * @author alan
 */
class LayoutPadrao extends Pagina {

    protected $menu;
    protected $cabecalho;
    protected $rodape;
    protected $breadcrumb; // As migalhas de pão do joão e maria.
    protected $acoes;
    /**
     *
     */
    public function  __construct() {
        $this->adMetaTags('<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />');
        $this->adCSS('<link type="text/css" href="resources/css/le-frog/jquery-ui-1.7.2.custom.css" rel="stylesheet" />');
        $this->adCSS('<link type="text/css" href="css/estilo.css" rel="stylesheet" />');
        $this->adJs('<script type="text/javascript" src="resources/js/jquery-1.3.2.min.js"></script>');
        $this->adJs('<script type="text/javascript" src="resources/js/jquery-ui-1.7.2.custom.min.js"></script>');
        $this->adCabecalho("<h1>GuardaChuva</h1>");
    }
    /**
     *
     * @param <type> $acao
     */
    public function adAcao($acao) {
        $this->acoes[] = $acao;
    }
    /**
     *
     * @param <type> $breadCrumb
     */
    public function adBreadcrumb($breadCrumb) {
        $this->breadcrumb[] = $breadCrumb;
    }
    /**
     *
     * @param <type> $rodape
     */
    public function adRodape($rodape) {
        $this->rodape[] = $rodape;
    }
    /**
     *
     * @param <type> $cabecalho
     */
    public function adCabecalho($cabecalho) {
        $this->cabecalho[] = $cabecalho;
    }

    public function pegaCabecalho() {
        $html = "<div id='cabecalho'>";
        if(isset ($this->cabecalho)) {
            foreach($this->cabecalho as $cabecalho) {
                $html .= "$cabecalho";
            }
        }
        $html .= "</div>";
    }
    public function pegRodape() {
        $html = "<div id='rodape'>";
        if(isset ($this->rodape)) {
            foreach($this->rodape as $rodape) {
                $html .= "$rodape";
            }
        }
        $html .= "</div>";
    }



    public function pegConteudo() {

        $html = "<div id='geral'>";
        if(isset ($this->conteudo)) {
            foreach($this->conteudo as $conteudo) {
                $conteudo .= "\t\t$conteudo\n";
            }
        }
        return $conteudo;
        $html .= "</div>";
    }
}
?>
