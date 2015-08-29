<?php

class Utilitarios {
    /* responssavel por carregar as paginas de visão */

    public static function mostraPageBackend($url) {
        try {
            if (!empty($url)) {
                $pagina = 'app/view/backend/'.strip_tags($url).'.php';
                if (file_exists($pagina)) {
                    include_once $pagina;
                } else {
                    $pagina = 'app/view/'.strip_tags($url).'.php';
                    if (file_exists($pagina)) {
                        include_once $pagina;
                    } else {
                        include_once 'app/view/paginanaoencontrada.php';
                    }                    
                }
            }
        } catch (Exception $e) { //personalizar uma pagina com erro
            //include_once 'app/view/paginanaoencontrada.php';
            echo '<br /><br /><div class="alert red_alert"><p><strong>Erro ao tentar exibir a pagina!</strong></p></div><br /><br /><br /><br />';
        }
    }

    public static function mostraPageFrontend($url) {
        try {
            if (!empty($url)) {
                $pagina = 'app/view/frontend/' . strip_tags($url) . '.php';                
                if (file_exists($pagina)) {
                    include_once $pagina;
                } else {
                    $pagina = 'app/view/'.strip_tags($url).'.php';
                    if (file_exists($pagina)) {
                        include_once $pagina;
                    } else {
                        include_once 'app/view/paginanaoencontrada.php';
                    }
                }
            }
        } catch (Exception $e) {
            include_once 'app/view/paginadeerro.php';
        }
    }

    public static function mostraRelatorio($rel) {
        try {
            if (!empty($rel)) {
                $pagina = 'app/view/relatorios/' . $rel . '.php';
                if (file_exists($pagina)) {
                    include_once $pagina; //'app/view/'.$url.'.php';
                } else {
                    header('home.php');
                }
            }
        } catch (Exception $e) {
            header('home.php');
        }
    }
       
    /*
     * dataset       = dados retornados do banco
     * campoAux      = caso deseje adicionar mais um campo na combo Ex.: opção todos
     * campoOpcional = caso deseje exibir "Selecione uma opção"
     */

    public static function preencheComboDB($dataSet, $selecionado = null, $campoAux = null, $campoOpcional = false) {
        try {
            $dataSource = $dataSet; //$dataSet->getResultados();
            $qtdReg = sizeof($dataSet); //$dataSet->getQtdeLinhas();
            if ($qtdReg > 0) {
                
                if ($campoOpcional && $qtdReg > 1) {
                    echo '<option class="" value="-1" selected="selected">-- Selecione --</option>';
                }
                
                if ((!is_null($campoAux)) || (!empty($campoAux))) {
                    if ($qtdReg > 1) {
                        $selected = '';
                        echo '<option class="" value="0" ' . $selected . '>' . $campoAux . '</option>';
                    }
                }
                
                $campos = array();
                $selected = '';
                foreach ($dataSource as $linha) {
                    $campos = array_keys($linha);
                                        
                    if ($selecionado == $linha[$campos[0]]) {
                        $selected = 'selected="selected"';
                    }
                    echo '<option class="" value="'.$linha[$campos[0]].'" '.$selected.'>'.trim($linha[$campos[1]]).'</option>';
                    $selected = '';
                }                
                
            } else {
                echo '<option value="">Sem opções</option>';
            }
        } catch (PDOException $e) {
            echo '<option value="">Erro ao listar</option>';
        }
    }

    public static function getDataHoraServidor() {
        $pSQL = 'SELECT CURRENT_TIMESTAMP AS result;'; //PostgreSQL        
        //$dados = new Consulta(Conf::pegCnxPadrao(), $pSQL);
        $dados = new Consulta(Conf::cnxPadrao(), $pSQL);
        $dataSet = $dados->getResultados();
        foreach ($dataSet as $linha) {
            return $linha['result'];
            break;
        }
    }

    /**
     * Passa a data do servidor no formato
     * dd/mm/yyyy.
     * @param void
     * @return string data convertida em dd/mm/yyyy
     */
    public static function getDataServidor() {
        //$pSQL='SELECT CURRENT_TIMESTAMP AS result;'; PostgreSQL
        //$pSQL='SELECT CONVERT(CHAR(10),GETDATE(),103) AS result;'; sql server
        $pSQL = "select date_format(curdate(), '%d/%m/%Y') AS result";
        $dataSet = new Consulta(Conf::pegCnxPadrao(), $pSQL);
        foreach ($dataSet->getResultados() as $linha) {
            return $linha['result'];
        }
    }

    public static function removeMascara($string) {
        $string = preg_replace('#[^0-9]#', '', $string);
        return $string;
    }

    public static function getCores($qtd) {
        $vCores = array("ff0000", "7B68EE", "8B7765", "00FF00", "DCDCDC", "FFE4B5",
            "8470FF", "0000FF", "1E90FF", "4682B4", "B0C4DE", "6B8E23",
            "FFD700", "EE3A8C", "68228B", "CD5C5C", "CD853F", "A52A2A",
            "FF8C00", "FF0000", "9400D3", "8B658B", "FF3030", "FF7F24");
        $cont = 0;
        $cores = '';
        while ($cont < $qtd) {
            $cores = $cores . $vCores[$cont] . '|';
            $cont++;
        }
        $cores = substr($cores, 0, strlen($cores) - 1);
        return $cores;
    }

    public static function ExibirRSS() {
        $feed = 'http://olhardigital.uol.com.br/rss/ultimas_noticias.php';

        ini_set('allow_url_fopen', true);
        $fp = fopen($feed, 'r');
        $xml = '';
        while (!feof($fp)) {
            $xml .= fread($fp, 128);
        }
        fclose($fp);

        function untag($string, $tag) {
            $tmpval = array();
            $preg = "|<$tag>(.*?)</$tag>|s";
            preg_match_all($preg, $string, $tags);
            foreach ($tags[1] as $tmpcont) {
                $tmpval[] = $tmpcont;
            }
            return $tmpval;
        }

        $items = untag($xml, 'item');
        $html = '<p>';
        foreach ($items as $item) {
            $title = untag($item, 'title');
            $title[0] = str_replace('<', "", $title[0]);
            $title[0] = str_replace('>', "", $title[0]);
            $title[0] = str_replace('![CDATA[', "", $title[0]);
            $title[0] = str_replace(']]', "", $title[0]);
            $title[0] = mb_convert_encoding($title[0], 'utf8');
            $link = untag($item, 'link');
            $html .= '<a href="' . $link[0] . '" target="_blank">' . $title[0] . "</a><br />\n";
        }
        $html .= '</p>';
        echo $html;
    }

    public static function criptografa($str) {
        for ($i = 0; $i < 1; $i++) {
            $str = strrev(base64_encode($str)); //apply base64 first and then reverse the string
        }
        return $str;
    }

    public static function descriptografa($str) {
        for ($i = 0; $i < 1; $i++) {
            $str = base64_decode(strrev($str)); //apply base64 first and then reverse the string}
        }
        return $str;
    }
    
     /**
     * Formata o número entregue pelo banco em número convencional
     * no formato BR.
     * @param float $numero - numero à ser transformado.
     * @param int $casas - número de casas decimais à serem preservadas.
     * @return string
     * @description Formato visual do número.
     */
    public static function formatarMoeda($valor = 0 , $casas = 2) {       
        return number_format($valor,$casas,",",".");
    }

    public static function formataData_DiaMesAno($data) {
        if (empty ($data)) {
            return null;
        } else {
            $data = substr($data, 0, 10);
            $dados = explode("-", $data);
            $novadata = $dados[2] . "/" . $dados[1] . "/" . $dados[0]; // Formato PT-BR(DD/MM/YYYY)
            return $novadata;
        }        
    }

    public static function formataData_AnoMesDia($data) {
        if (strpos($data, "-") === false) {
            $data = substr($data, 0, 10);
            $dados = explode("/", $data);
            $novadata = $dados[2] . "-" . $dados[1] . "-" . $dados[0];
        } else {
            $novadata = $data;
        }
        
        return $novadata;
    }    

    public static function paginaEmManutencao() {
        echo "<br /><div class=\"warning msg\"><strong>A página está temporariamente em manutenção tente novamente mais tarde!</strong></div>
              <br /><h1 align=\"center\"><a href=\"?action=acessoRapido\">Clique aqui para voltar ao menu principal</a></h1>";
        die();
    }

    public static function siteEmManutencao() {
        echo "<br /><div class=\"warning msg\"><strong>Sistema temporariamente em manutenção tente novamente mais tarde</strong></div>
              <br /><h1 align=\"center\"><a href=\"?action=acessoRapido\">Clique aqui para voltar ao menu principal</a></h1>";
        die();
    }    
    
    public static function getNavegadorComVersao() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
 
        if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'IE';
        } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Opera';
        } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Firefox';
        } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Chrome';
        } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Safari';
        } else {
            // browser not recognized!
            $browser_version = 0;
            $browser= 'NI'; //não identificado
        }
        return $browser.' '.$browser_version;
    }
    
    public static function getNavegador() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
 
        if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'IE';
        } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Opera';
        } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Firefox';
        } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Chrome';
        } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Safari';
        } else {
            // browser not recognized!
            $browser_version = 0;
            $browser= 'NI'; //não identificado
        }
        return $browser;
    }
    
    public static function getVersaoNavegador() {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
 
        if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'IE';
        } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Opera';
        } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Firefox';
        } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Chrome';
        } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
            $browser_version=$matched[1];
            $browser = 'Safari';
        } else {
            // browser not recognized!
            $browser_version = 0;
            $browser= 'NI'; //não identificado
        }
        return $browser_version;
    }
    
    public static function msgErro($msg = null, $retornar = false) {
        $html = (trim($msg) == '' || $msg == null) ? '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i>&nbsp;Erro!</strong></div>' : '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong><i class="ace-icon fa fa-times"></i>&nbsp;Erro!</strong>&nbsp;&nbsp;'.$msg.'<br /></div>';
        if ($retornar) {
            return $html;
        } else {
            echo $html;
        }
    }

    public static function msgSucesso($msg = null, $retornar = false) {
        $html = (trim($msg) == '' || $msg == null) ? '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="ace-icon fa fa-check"></i>&nbsp;Sucesso!</strong><br/></div>' : 
                '<div class="alert alert-block alert-success"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><p><strong><i class="ace-icon fa fa-check"></i></strong>&nbsp;&nbsp;'.$msg.'<br/></div>';
        if ($retornar) {
            return $html;
        } else {
            echo $html;
        }        
    }

    public static function msgAtencao($msg = null) {
        echo (trim($msg) == '' || $msg == null) ? '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong>Atenção!</strong><br /></div>' : '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong>Atenção:</strong>&nbsp;&nbsp;'.$msg.'<br /></div>';
    }

    public static function msgAviso($msg = null) {        
        echo (trim($msg) == '' || $msg == null) ? '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button><strong>Aviso!</strong></div>' : '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>&nbsp;&nbsp;'.$msg.'<br /></div>';
    }
    
    public static function exibirMensagem() {
        echo (isset($_SESSION['msg']))? $_SESSION['msg'] : '';
        $_SESSION['msg'] = null;
    }

}

?>