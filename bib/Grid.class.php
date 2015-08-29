<?php
/* 
 * Arquivo de Configuracao da Classe Grid
 * @author Junior Melo Natal/RN <junior_melo85@hotmail.com> em 10/11/2011
 * @version 1.0
 * esta classe criar um grid(tabela)
 */
class Grid {    
    protected $id;                                    //identificador do componente
    protected $nome;                                  //nome componente
    protected $estilo = 'tablesorter';                //enviar o estilo que o grid vai utilizar
    protected $mensagem = null;                       //mensagem quando a consulta do grid for vazia
    protected $titulo;                                //exibe um titulo no topo do grid gerado
    protected $formEdicao = '#';                      //utilizado nos botões de acoes quando necessitar chamar outra inteface para edição
    protected $formVisualizacao;                      //direciona para um arquivo de visualização não editavel caso necessite mostrar todo o cadastro (caso nao deseje setar esta propriedade basta criar um arquivo com o mesmo nome do formEditação com um "V" maisculo no final)
    protected $dataSet    = null;                     //sera atribuido apenas o obejo consulta
    protected $dataSource = null;                     //recebe um array de dados do dataset
    protected $indice     = 1;                        //define apartir de qual ponto será impresso, é interessante imprimir apos a chave primaria ou composta
    protected $editar     = false;                    //habilita a visibilidade do link edita
    protected $detalhar   = false;                    //habilita a visibilidade do link detalhar
    protected $excluir    = false;                    //habilita a visibilidade do link excluit    
    protected $exibirSequencial = false;              //exibe a sequencia do cadastro
    
    
    public function getExibirSequencial() {
        return $this->exibirSequencial;
    }

    public function setExibirSequencial($exibirSequencial) {
        $this->exibirSequencial = $exibirSequencial;
    }

    /**
     * recupere o nome do arquivo de visualização do grid
     */
    public function getFormVisualizacao() {
        return $this->formVisualizacao;
    }
    
    /**
     * vicule um arquivo de visualização par ao usuario
     */
    public function setFormVisualizacao($formVisualizacao) {
        $this->formVisualizacao = $formVisualizacao;
    }

    /**
     * identificador do componente
     */    
    public function getId() {
        return $this->id;
    }
    
    /**
     * nome componente
     */    
    public function getNome() {
        return $this->nome;
    }
    
    /**
     * enviar o estilo que o grid vai utilizar
     */    
    public function getEstilo() {
        return $this->estilo;
    }
    
    /**
     * exibe um titulo no topo do grid gerado
     */
    public function getTitulo() {
        return $this->titulo;
    }
    
    /**
     * mensagem quando a consulta do grid for vazia
     */
    public function getMensagem() {
        return $this->mensagem;
    }
    
    /**
     * utilizado nos botões de acoes quando necessitar chamar outra inteface
     */
    public function getFormEdicao() {
        return $this->formEdicao;
    }       
    
    /**
     * sera atribuido apenas o obejo consulta
     */
    public function getDataSet() {
        return $this->dataSet;
    }
    
    /**
     * recebe um array de dados do dataset
     */
    public function getDataSource() {
        return $this->dataSource;
    }
        
    /**
     * define apartir de qual ponto será impresso, é interessante imprimir apos a chave primaria ou composta
     */
    public function getIndice() {
        return $this->indice;
    }

    public function getEditar() {
        return $this->editar;
    }

    public function getDetalhar() {
        return $this->detalhar;
    }

    public function getExcluir() {
        return $this->excluir;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        if (!isset ($this->id)) {
            $this->id = $nome;
        }
    }

    public function setEstilo($estilo) {
        $this->estilo = $estilo;
    }

    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    
    public function setMensagem($mensagem) {
        $this->mensagem = $mensagem;
    }

    public function setFormEdicao($formEdicao) {
        $this->formEdicao = $formEdicao;
    }       
    
    public function setDataSet($dataSet) {
        $this->dataSet = $dataSet;
    }

    public function setDataSource($dataSource) {
        $this->dataSource = $dataSource;
    }

    public function setIndice($indice) {
        $this->indice = $indice;
    }

    public function setEditar($editar) {
        $this->editar = $editar;
    }

    public function setDetalhar($detalhar) {
        $this->detalhar = $detalhar;
    }

    public function setExcluir($excluir) {
        $this->excluir = $excluir;
    }  

    /*indice = imprime apartir do indice informado
     * COMPOS COM A SIGLA PK_ NO INICIO SÃO CONSIDERADOS COMO CHAVE
     * COMPOS COM ANDERLINE NO FIM SÃO CONSIDERADOS COMO INVISIVEIS*/
    public function exibirModoExpert(){
        try{             
            $this->dataSource = $this->dataSet->getResultados();
            if ($this->dataSource) {            
                if ((!is_null($this->titulo)) || (!empty($this->titulo))) {
                    echo "<br /><br /><center><h1>".$this->titulo."</h1></center><br />";
                }                
                                
                echo '<table class="'.$this->estilo.'" title="" >';//inicia a tabela                
                $titulos = $this->dataSet->getCampos(); //pega os campos da consulta para para ser exibido como os titulos                                
                echo '<thead><tr>';
                if ($this->exibirSequencial) {
                    echo '<th align="center">#&emsp;</th>';
                }
                $cont = 1;             
                foreach ($titulos as $titulo){
                    if ($this->indice == $cont) {
                        echo '<th><strong>'.$titulo.'</strong></th>';
                    } else {
                        $cont++;
                    }                                        
                }
                                
                if (($this->editar) || ($this->detalhar)  || ($this->excluir)) {
                    echo '<th WIDTH=70 ><strong>Ações</strong></th></tr></thead><tbody>';
                } else {
                    echo '</tr></thead><tbody>';
                }
                
                $cont = 1;
                $seq = 1;
                $mudaCor = 0;
                foreach ($this->dataSource as $linha){                    
                    echo '<tr>';
                    if ($this->exibirSequencial) {
                        echo '<td align="center"><strong>'.$seq++.'</strong></td>';
                    }
                    $parametros = '';
                    $campoChave = '';
                    foreach ($linha as $campo => $dado){
                        //caso seja chave guarda os parametros para possiveis edições exclusões                        
                        if (substr($campo, 0, 3) == 'PK_') {
                            $parametros = $parametros.'&'.substr($campo, 3, strlen($campo)).'='.$dado;
                            $campoChave .= $dado.',';
                        }
                        if ($this->indice == $cont) {
                            echo '<td>'.$dado.'</td>';
                        } else {
                            $cont++;
                        }
                    }                    
                    $campoChave = substr($campoChave, 0, strlen($campoChave)-1);                    
                    $acoes = null;                                                         
                    if ($this->editar) {
                        if (empty ($this->formEdicao)) {
                            $action = '#';
                        } else {
                            $action = '?action='.$this->formEdicao;                            
                        }
                        $acoes = $acoes.'<a href="'.$action.$parametros.'" title="Editar"><img src="images/editar.gif" alt="Editar" /></a>&emsp;';                        
                    }
                    
                    if ($this->detalhar) {
                        if (empty ($this->formVisualizacao)) {
                            if (empty ($this->formEdicao)) {
                                $action = '#';
                            } else {
                                $action = '?action='.$this->formEdicao.'V';
                            }
                        } else {
                            $action = '?action='.$this->formVisualizacao;
                        }                        
                        $acoes = $acoes.'<a href="'.$action.$parametros.'" title="Visualizar"><img src="images/visualizar.gif" alt="Visualizar" /></a>&emsp;';
                    }
                    if ($this->excluir) {         
                        $acoes = $acoes.'<a href="javascript: excluir('."'".$campoChave."'".');" title="Excluir"><img src="images/delete.png" alt="Excluir" /></a>';
                    }
                    echo '<td align="center">'.$acoes.'</td></tr>';                    
                    $cont = 1;
                    $mudaCor++;
                }
                echo "</tbody></table>";
            } else {              
                if (isset ($this->mensagem)) {
                    echo "<br /><br /><br /><center><h2>".$this->mensagem."</h2></center>";
                } else {
                    echo "<br /><br /><br /><center><h2>Não há dados cadastrados!</h2></center>
                      <!--<a href=\"sistema.php\"><h2><i>Clique aqui para retornar ao inicio.</i></h2></a>-->
                    ";
                }
            }
        } catch (PDOException $e) {
            die ($e->getMessage());
        }
    }
    
    //função legada
    public function gerarDbGrid() {
        try{
            /*$dados = new Consulta(Conf::pegCnxPadrao(),$pSQL);
            $dataSet = $dados->getResultados();*/
            if ($this->dataSource) {
                if (isset ($this->titulo)) {
                    echo "<h2>".$this->titulo."</h2>";
                }
                if (isset ($this->vinculo)) {
                    $vinculo = "?action=".$this->vinculo;
                } else {
                    $vinculo = "#";
                }
                //echo "<br/><hr /><h3><a href=\"$vinculo\">Voltar</a></h3><hr />";
                echo "<br/><table class=\"$this->estilo\">";
                //echo "<tr ><th colspan=\"3\">".$titulo."</th></tr>";
                foreach ($dataSet as $linha){
                    $cont = 1;
                    foreach ($linha as $campo => $dado){
                        if ($cont<10) {
                            $cont = "0".$cont;
                        }
                        echo "<tr><td><b>".$cont++."</b></td><td><b>".$campo."</b></td><td>".$dado."</td></tr>";
                    }                    
                }                
                echo "</table><br/><hr /><h3><a href=\"$vinculo\">Voltar</a></h3><hr /><br/><br/>";

            }
        } catch (PDOException $e) {
            die ('Erro ao tentar gerar o grid<br />'.$e->getMessage());
        }
    }    
}
?>
