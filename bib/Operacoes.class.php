<?php
/*
 * Classe responsável por realizar as operações de CRUD
 */
/**
 * Description of Operacoes.
 * A Classe Operações faz a inserção, atualização, exclusão e seleção de dados
 * na tabela. A idéia é que o Modelo saiba persistir com as operações básicas.
 * Exemplo: Se a intenção é apenas atualizar um único campo, será necessário
 * carregar todos os dados, atualizar o campo e só então salvar.
 * @author Alan
 */
class Operacoes {
/**
 * A classe Operações é responsável por realizar a persistência do Modelo.
 * @var Modelo modelo
 */
    protected $modelo;
    /**
     * Construtor da Classe
     * @param Modelo $modelo
     */
    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }
    /**
     * Seleciona os dados da Tabela
     */
    public function select() {
    // Se o Modelo não for herança direta da classe Modelo
    // (Ex: Modelo -> Pessoa -> PessoaFisica), então para capturar todos
    // os dados será necessário fazer um select também nas tabelas da
    // hierarquia além da captura dos dados somente do objeto.
        $pai = $this->modelo->_getPai();
        //var_dump($chaves);
        if($pai != "Modelo") {
        //echo "É diferente de Modelo";
        // Precisamos fazer o mapeamento Objeto Relacional.
        // Primeiro instanciamos o Pai
            $objPai = new $pai($this->modelo->_getConexao());
            // Configuro a chave primária do Objeto Pai com o valor da ChavePrimaria do Filho
            $objPai->setValorChavePrimaria($this->modelo->getValorChavePrimaria());
            // Capturo os dados do Pai
            $objPai->_select();
            // Informo os dados do Objeto Pai ao Modelo.
            $this->modelo->_setDados($objPai->_getDados());
        }
        // Trago o comando SQL
        $sql = $this->getSQLSelect();
        //echo $sql . "<br>";
        // Instancio a Consulta
        $con = new ConsultaPreparada($this->modelo->_getConexao(), $sql);
        // Ligo a chave Primaria do Modelo ao Campo do WHERE
        $campo = $this->modelo->getCampoChavePrimaria();
        $valor = $this->modelo->getValorChavePrimaria();
        $con->liga($campo, $valor);
        // Preencho os campos do objeto
        foreach($con->getResultados() as $linha) {
            foreach($linha as $campo=>$valor) {
                $this->modelo->$campo = $valor;
            }
        }
        // Retorna a quantidade de registros.
        $qtdReg = $con->getQtdeLinhas();
        if($qtdReg) {
            return true;
        } else {
            return false;
        }

    }
    /**
     * Deleta o Registro da Tabela. Não trata ainda da deleção na hierarquia.
     * A idéia é que pode ser possível excluir um usuário sem excluir a pessoa e
     * pessoa física por exemplo.
     */
    public function delete() {
         // Trago o comando SQL
        $sql = $this->getSQLDelete();
        // Instancio o Comando
        $con = new ComandoPreparado($this->modelo->_getConexao(), $sql);
        // Ligo a chave Primaria do Modelo ao Campo do WHERE
        $campo = $this->modelo->getCampoChavePrimaria();
        $valor = $this->modelo->getValorChavePrimaria();
        $con->liga($campo, $valor);
        // Retorna a quantidade de registros.
        $qtdReg = $con->executa();
        if($qtdReg) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Essa função constroi o comando SQL com os parâmetros (sem valores)
     * @return string comando SQL completo
     */
    public function getSQLSelect() {
        $tabela = $this->modelo->getTabela();
        $where = $this->getSQLwhere();
        $sql = "SELECT * FROM {$tabela} ";
        $sql .= $this->getSQLwhere();
        return $sql;
    }
    
    /**
     * Essa função retorna o filtro SQL com Where
     * @return string Filtro SQL
     */
    public function getSQLwhere() {
        $campo = $this->modelo->getCampoChavePrimaria();
        $sql = " WHERE 1=1 AND {$campo} = :{$campo};";
        return $sql;
    }
    /**
     * Essa função salva os dados do Modelo no Banco de Dados
     */
    public function salvar() {
        // Pega a Conexao e Inicio a transacao
        $cnx = $this->modelo->_getConexao();
        $cnx->iniTransacao();
        // Se o Modelo não for herança direta da classe Modelo
        // (Ex: Modelo -> Pessoa -> PessoaFisica), então para realizar uma inserção
        // será necessário salvar primeiro nas classes da hierarquia.
        // No caso de haver herança podem ocorre 3 Situações:
        // 1ª - O registro do Objeto Pai não Existe e conseqüentemente o Objeto
        //      Filho não foi salvo no banco de dados.
        // 2ª - O registro do Objeto Pai Existe e o Objeto Filho não foi salvo no
        //      banco
        // 3ª - O registro do Objeto Pai Existe e o Objeto Filho também.
        // Lembrar de Colocar a Conexão em modo transacional se houver herança.
        $pai    = $this->modelo->_getPai();
        //1º Vamos verificar se há herança.
        if($pai != "Modelo") {
        // Se entrou aqui é porque houve herança entre os modelos.
        // Lembrando que o trato é que se há herança não pode haver chave
        // composta. Vamos fazer a primeira verificação...
        // Primeiro instancio o objPai - ele vai ser responsável por fazer
        // sua própria persistência
        // É importante tornar a conexao transacional.            
            $objPai = new $pai($cnx);
            // Agora vamos colocar a chave primaria do Objeto no objeto Pai
            // e verificar se o Objeto Pai já está cadastrado no banco.
            // Insiro a Chave Primária do filho no Objeto Pai
            $objPai->setValorChavePrimaria($this->modelo->getValorChavePrimaria());
            // Verifico se há registros no banco de dados
            $existe = $objPai->_select(); // Retorna true ou false (se achou ou não registro)
            // Se não existir, então caio na 1ª Situação (Pai e Filho não existem)
            if(!$existe) {
            // Preencho os dados do Pai com os dados do Filho
            // No filho tem mais dados que no Pai, então precisamos retirar os
            // campos que não coincidem com o Pai.
                $arrayPai   = $objPai->_getDados();
                $arrayFilho = $this->modelo->_getDados();
                // ArrDados receberá a interseção dos dois arrays Pai e Filho
                // Em outras palavras o que tem em um e tem no outro.
                $arrayDados = array_intersect_key($arrayFilho, $arrayPai);
                // Incluo os dados no Objeto Pai
                $objPai->_setDados($arrayDados);
                // Como não existia nenhum registro, ao salvar ele vai informar
                // o id da chave primária
                $chavePai = $objPai->_salvar();
                // Preencho a Chave Primária do Filho com o Id recebido pelo Pai
                $this->modelo->setValorChavePrimaria($chavePai);
            } else {
            // Se entrou aqui é porque o Pai foi selecionado, ou seja, existe
            // um registro no banco de dados do Pai.
            // Nos atualizamos os dados do Pai (pode ser que tenha havido alguma
            // alteração no Pai.)
            // No filho tem mais dados que no Pai, então precisamos retirar os
            // campos que não coincidem com o Pai.
            // Temos que informar a chave primária do filho pra colocar no Pai.
                $arrayPai   = $objPai->_getDados();
                $arrayFilho = $this->modelo->_getDados();
                // ArrDados receberá a interseção dos dois arrays Pai e Filho
                // Em outras palavras o que tem em um e tem no outro.
                $arrayDados = array_intersect_key($arrayFilho, $arrayPai);
                $objPai->_setDados($arrayDados);
                // Quando eu coloco os dados dentro de Pai novamente, eu apago a
                // Chave Primaria do Pai, por isso tenho que novamente colocar
                // a chave Primária do Pai (Normalmente só sabemos a chave do filho)
                $objPai->setValorChavePrimaria($this->modelo->getValorChavePrimaria());
                // Tanto no insert qto no update o método salvar deverá retornar o idChavePrimaria
                $chavePai = $objPai->_salvar();
                // Preencho a Chave Primária do Filho com o Id recebido pelo Pai
                $this->modelo->setValorChavePrimaria($chavePai);
            }
        }
        // Resolvido o problema da Inserção ou não do registro no Pai.
        // Faremos agora a inserção na tabela do modelo.
        // Verificamos se há um registro do modelo no banco de dados.
        $existe = $this->modelo->_existe();
        // Se não existir (retornou falso)
        if(!$existe) {
            $sql = $this->getSQLInsert();
            // Instancio o Comando Preparado
            $cmd    = new ComandoPreparado($cnx, $sql);
            // Pego todos os campos do modelo (que não são de herança)
            $campos = $this->modelo->_getDadosLocais();
            // Faço aligação desses campos com todos valores
            foreach($campos as $campo => $valor) {
                $cmd->liga($campo, $valor);
            }
            $cmd->executa();
            $ultId = $cmd->getUltimoId();
            if( $ultId == 0) {
                $ultId = $this->modelo->getValorChavePrimaria();
            }
            return $ultId;
        } else {
            $sql = $this->getSQLUpdate();
            // Instancio o Comando Preparado
            $cmd    = new ComandoPreparado($cnx, $sql);
            // Pego todos os campos do modelo (que não são de herança)
            $campos = $this->modelo->_getDadosLocais();
            // Faço aligação desses campos com todos valores
            foreach($campos as $campo => $valor) {
                $cmd->liga($campo, $valor);
            }
            $cmd->executa();
            // Preciso agora retornar o Id da Chave Primaria
            return $this->modelo->getValorChavePrimaria();

        }
    }
    /**
     * Essa função constroi o comando SQL com os parâmetros (sem valores)
     * @return string comando SQL completo
     */
    public function getSQLInsert() {
        $tabela = $this->modelo->getTabela();
        $sql    = "INSERT INTO {$tabela} (";
        $dados =$this->modelo->_getDadosLocais();
        foreach($dados as $campo => $valor) {
            $campos[] = $campo;
            $params[] = ":{$campo}";
        }
        $strCampos = implode(",",$campos);
        $strParams = implode(",",$params);
        $sql .= "{$strCampos}) VALUES ({$strParams});";
        return $sql;
    }
    /**
     * Essa função constroi o comando SQL com os parâmetros (sem valores)
     * @return string comando SQL completo
     */
    public function getSQLUpdate() {
        $tabela = $this->modelo->getTabela();
        $sql    = "UPDATE {$tabela} SET ";
        $dados =$this->modelo->_getDadosLocais();
        foreach($dados as $campo => $valor) {
            $campos[] = "{$campo} = :{$campo} " ;
        }
        $strCampos = implode(", ",$campos);
        $sql .= $strCampos . $this->getSQLwhere();
        return $sql;
    }
    /**
     * Essa função constroi o comando SQL com os parâmetros (sem valores)
     * @return string comando SQL completo
     */
    public function getSQLDelete() {
        $tabela = $this->modelo->getTabela();
        $sql    = "DELETE FROM {$tabela} ";
        $sql .= $this->getSQLwhere();
        return $sql;
    }
    /**
     * A diferença entre esse método e o select é qie esse método não preenche
     * os dados do objeto, apenas verifica a sua existencia.
     * @return boolean true se existir o registro e false se não existir
     */
    public function existe() {
        // Trago o comando SQL
        $sql = $this->getSQLSelect();
        //echo $sql . "<br>";
        // Instancio a Consulta
        $con = new ConsultaPreparada($this->modelo->_getConexao(), $sql);
        // Ligo a chave Primaria do Modelo ao Campo do WHERE
        $campo = $this->modelo->getCampoChavePrimaria();
        $valor = $this->modelo->getValorChavePrimaria();
        $con->liga($campo, $valor);
        // Retorna a quantidade de registros.
        $qtdReg = $con->getQtdeLinhas();
        if($qtdReg) {
            return true;
        } else {
            return false;
        }

    }

}
?>