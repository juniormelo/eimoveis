<?php
/* 
 * Arquivo de Configuracao da Classe Modelo
 * @author Informática PR/RN <informatica@prrn.mpf.gov.br> em 16/09/2009
 * @version 1.1
 * @package bd
 */
/**
 * A classe Modelo é abstrata. Implementa o M do padrão MVC.
 * Essa classe faz a interface com o banco de dados.
 * Nessa classe podem ser implementadas regras de negócio, mas
 * as regras serão tratadas como erros de desenvolvimento, tendo em vista
 * que cabe a V - Visão e ao C - Controle entregar dados consistentes para
 * operações nos bancos de dados.
 * @author Alan
 * @abstract
 */
abstract class Modelo {
/**
 * Armazena a Conexao que sera utilizada para manipular os dados do Model
 * @var Conexao
 */
    protected $_conexao;
    /**
     * Esse objeto será responsável por realizar as operações padrão com banco
     * de dados (CRUD)
     * @var Operacaoes - Guarda um objeto da classe Operacoes
     */
    protected $_operacoes;
    /**
     * Construtor da Classe
     * @param Conexao $conexao
     */
    public final function __construct(Conexao $conexao) {
        $this->_conexao = $conexao;
        $this->_operacoes = new Operacoes($this);
    }
    /**
     * Função que retorna todos os Atributos/Valor do objeto no formato de
     * um array associativo
     * @return array associativo campo => valor
     * @deprecated
     */
    public final function _getDados() {
        $atrs = array();
        $atb = get_object_vars($this);
        foreach ($atb as $nome => $valor) {
            // Se o 1º caracter do campo não for o underline eu incluo como atributo
            // da classe.
            if (substr($nome, 0, 1) != "_") {
                $atrs[$nome] = $valor;
            }
        }
        return $atrs;

    }
    /**
     * Função que retorna todos os Atributos/Valor do objeto no formato de
     * um array associativo
     * @return array associativo campo => valor
     */
    public final function pegDados() {
        return $this->_getDados();
    }
    /**
     * @access protected
     * @return array string - Array contendo todos os métodos da classe (não iniciados por _(underline)
     * @deprecated
     */
    protected final function _getArrayMetodos() {
        $mtds = array();
        foreach (get_class_methods(get_class($this)) as $metodo) {
            // Verifica se o atributo começaa com _ (Nesse caso desprezamos por considerá-lo um
            // método interno da classe e não um campo do banco de dados
            if (substr($metodo, 0, 1) != "_") {
                $mtds[] = $metodo;
            }
        }
        return $mtds;
    }
    /**
     * @access protected
     * @return array string - Array contendo todos os métodos da classe (não iniciados por _(underline)
     */
    protected final function pegArrayMetodos() {
        return $this->_getArrayMetodos();
    }
    /**
     * Método Mágico __get.
     * Permite ler atributos da classe.
     * Sempre que houver um método get[NomeAtributo], esse método será chamado
     * sempre que o [NomeAtributo] for lido.
     * Note que para chamar o método basta instanciar uma classe e tentar ler o
     * valor do atributo diretamente. Não é preciso fazer a leitura utilizando o
     * método. Basta ler o atributo diretamente.
     * Ex:
     * $a = new Classe();
     * echo $a->Atributo;
     * Aqui a classe irá verificar se existe um método getAtributo.
     * Se existir, esse método será chamado e o valor retornado
     * será passado pelo método.
     * Caso não exista o método, o conteúdo do atributo seré retornado diretamente.
     * @param string Nome do Atributo
     * @return mixed O valor armazenado no atributo
     */
    public final function __get($atributo) {
        // Crio o nome do Método que estamos buscando.
        $metodo     = "get". ucfirst($atributo);
        $arrMetodos = $this->_getArrayMetodos();
        // Verifica se o método existe
        if (in_array($metodo, $arrMetodos)) {
            //Se existir utiliza o método para pegar as variáveis.
            return $this->$metodo();
        } elseif (array_key_exists($atributo, $this->_getDados())) {
            return $this->$atributo;
        } else {
            die("[get]Atributo $atributo não encontrado na classe " . get_class($this) . "!");
        }
    }
    /**
     * O mesmo que o __get so que para setar as variáveis.
     * @param string $atributo nome do atributo
     * @param mixed $valor valor do atributo
     *
     */
    public final function __set($atributo, $valor) {
        // Crio o nome do Método que estamos buscando.
        $metodo     = "set". ucfirst($atributo);
        $arrMetodos = $this->_getArrayMetodos();
        // Verifica se o método existe
        if (in_array($metodo, $arrMetodos)) {
            //Se existir utiliza o método para setar as variáveis
            $this->$metodo($valor);
            // Se não existir o método mas existir a variável ele seta
            // diretamente
        } elseif (array_key_exists($atributo, $this->_getDados())) {
            $this->$atributo = $valor;
        } /*else {
            // Se não existe o método nem a variável então para tudo.
            die("[set]Atributo $atributo não encontrado na classe " . get_class($this) . "!");
        }*/
    }
    /**
     * Função que retorna todos os Atributos/Valor do objeto excluindo os atributos
     * que estão vindo por herança no formato de um array associativo
     * @return array associativo campo => valor
     * @deprecated
     */
    public final function _getDadosLocais() {
        $pai = $this->_getPai();
        if($pai == "Modelo") {
            return $this->_getDados();
        } else {
            $arr = $this->_getDados();
            $objPai = new $pai($this->_conexao);
            $arrPai = $objPai->_getDados();
            $arr = array_diff_key($arr, $arrPai);
            return $arr;
        }

    }
    /**
     * Função que retorna todos os Atributos/Valor do objeto excluindo os atributos
     * que estão vindo por herança no formato de um array associativo
     * @return array associativo campo => valor
     */
    public final function pegDadosLocais() {

        return $this->_getDadosLocais();
    }
    /**
     * Função que retorna o nome da classe Pai
     * @return string - retorna o nome da classe Pai
     * @deprecated
     */
    public final function _getPai() {
        $nomeClasse = get_class($this);
        return get_parent_class( $nomeClasse );
    }
    /**
     * Função que retorna o nome da classe Pai
     * @return string - retorna o nome da classe Pai
     */
    public final function pegNomePai() {
        return $this->_getPai();
    }
    /**
     * Retorna nome da tabela do banco de dados que o modelo representa
     * @return string nome da tabela do banco de dados que o modelo representa
     * @deprecated
     */
    public function getTabela() {
        return get_class($this);
    }
    /**
     * Retorna nome da tabela do banco de dados que o modelo representa
     * @return string nome da tabela do banco de dados que o modelo representa
     */
    public function pegTabela() {
        return $this->getTabela();
    }
    /**
     * Retorna a Conexao com o Banco de Dados do Modelo
     * @return Conexao A conexao com o Banco de Dados Atual
     * @deprecated
     */
    public final function _getConexao() {
        return $this->_conexao;
    }
    /**
     * Retorna a Conexao com o Banco de Dados do Modelo
     * @return Conexao A conexao com o Banco de Dados Atual
     */
    public final function pegConexao() {
        return $this->_getConexao();
    }
    /**
     * Esse método faz a seleção e o preenchimento do registro do banco de
     * dados no objeto.
     * É importante preencher os campos chave primaria do objeto
     */
    public final function _select() {
        return $this->_operacoes->select();
    }
    /**
     * Esse método faz a verificação da existência ou não de registro no banco
     * de dados. É importante preencher os campos chave primaria do objeto
     */
    public final function _existe() {
        return $this->_operacoes->existe();
    }
    /**
     * Preenche os dados do objeto com o array informado.
     * @param array $dados - Array associativo
     */
    public function _setDados($dados) {
        foreach($dados as $campo => $valor) {
            $this->$campo = $valor;
        }
    }
    /**
     * Preenche os dados do objeto com o array informado.
     * @param array $dados - Array associativo
     */
    public function altDados($dados) {
        return $this->_setDados($dados);
    }
    /**
     * Esse método pode ser sobrescrito quando a chave primária não for o
     * primeiro atributo declarado na classe.
     * @return array associativo contendo pares chave/valor
     */
    public function getCampoChavePrimaria() {
        $atributos = $this->_getDados();
        foreach($atributos as $campo => $valor) {
            return $campo;
        }
    }
    /**
     * Esse método pode ser sobrescrito quando a chave primária não for o
     * primeiro atributo declarado na classe.
     * @return array associativo contendo pares chave/valor
     */
    public final function getValorChavePrimaria() {
        $atributos = $this->_getDados();
        foreach($atributos as $campo => $valor) {
            return $valor;
        }
    }
    /**
     * Esse método não pode ser sobrescrito.
     * Coloca o valor na Chave Primaria
     */
    public final function setValorChavePrimaria($valor) {
        $campo = $this->getCampoChavePrimaria();
        $this->$campo = $valor;
    }
    /**
     * Esse método faz a seleção dos registros baseados no preenchimento dos
     * campos chave primária.
     */
    public final function _salvar() {
        return $this->_operacoes->salvar();
    }
    /**
     * Esse método faz a exclusão dos registros baseados no preenchimento do
     * campo chave primária.
     */
    public final function _delete() {
        return $this->_operacoes->delete();
    }
    /**
     * Faz o preenchimento dos valores do objeto com base
     * no valor da chave primária.
     * @param <type> $valorChavePrimaria
     * @return <type>boolean
     */
    public final function _preecheObjeto($valorChavePrimaria){
        $this->setValorChavePrimaria($valorChavePrimaria);
        return $this->_select();
    }
    /**
     * Retorna o valor da chave Primaria do Objeto
     * @return <int>
     */
    public final function  __toString() {
        return $this->getValorChavePrimaria();
    }
    
    public function getMetodos(){
        return get_class_methods($this);
    }
    
    public final function setDados($atributos) {
        $class_methods = $this->getMetodos();     
	foreach ($atributos as $chave => $valor){
	    $metodo = 'set'.$chave;
            foreach ($class_methods as $method_name) {                              
                if (strtolower($method_name) == strtolower($metodo)){ 
                    if (!isset ($valor)) {
                        $valor = null;
                    }
                    $this->$metodo(trim($valor));
                    break;
                }
            }            
	}        
    }
    
    public function transformaEmArray($dataSet, $converterUTF8 = false){
        $arr = array();
        foreach($dataSet as $linha){
            $arrAux = array();
            foreach($linha as $key => $value) {
                $arrAux[$key] = (is_null($value)) ? "" : (($converterUTF8)? utf8_encode($value) : $value);
            }
            array_push($arr, $arrAux);
        }
        return $arr;
    }
}
?>