<?php

/**
 * Descricao: Trait com metodos de uso geral e esenciais ao sistema
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Revisoes:
 */
trait Tgeral {

    public $tituloObjeto;
    public $descrObjeto;
    public $cabCol1;
    public $cabCol2;
    public $cabCol3;
    public $cabCol4;
    public $cabCol5;
    //Parametros para link
    public $st;
    public $ft;
    public $pag;
    public $tipoCod;

    /*
     * Titulo do Objeto a ser trabalhao.
     * Ex. Parcelas - Estoque 
     */

    public function set_tituloObjeto($novoTitulo) {
        $this->tituloObjeto = $novoTitulo;
    }

    /**
     * Titulo do cabecalho da descricao da listagem.
     * Segunda coluna
     * @param type $novaDescr
     */
    public function set_descrObjeto($novaDescr) {
        $this->descrObjeto = $novaDescr;
    }

    /**
     * Titulo cabecalho seguinte a descricao
     * @param type $novoCol1
     */
    public function set_cabCol1($novoCol1) {
        $this->cabCol1 = $novoCol1;
    }

    /**
     * Titulo cabecalho seguinte a descricao
     * @param type $novoCol2
     */
    public function set_cabCol2($novoCol2) {
        $this->cabCol2 = $novoCol2;
    }

    /**
     * Titulo cabecalho seguinte a descricao
     * @param type $novoCol3
     */
    public function set_cabCol3($novoCol3) {
        $this->cabCol3 = $novoCol3;
    }

    /**
     * Titulo cabecalho seguinte a descricao
     * @param type $novoCol4
     */
    public function set_cabCol4($novoCol4) {
        $this->cabCol4 = $novoCol4;
    }

    /**
     * Titulo cabecalho seguinte a descricao
     * @param type $novoCol5
     */
    public function set_cabCol5($novoCol5) {
        $this->cabCol5 = $novoCol5;
    }

    /**
     * Para o parametro st dos link
     * Eh o modulo: lembretes, estoque
     * @param type $novoSt
     */
    public function set_st($novoSt) {
        $this->st = $novoSt;
    }

    public function set_ft($novoFt) {
        $this->ft = $novoFt;
    }

    /**
     * Pagina interna 
     * Ex.: edit, nova, cad
     * @param type $novaPag
     */
    public function set_pag($novaPag) {
        $this->pag = $novaPag;
    }

    public function set_tipoCod($novoTipoCod) {
        $this->tipoCod = $novoTipoCod;
    }

    protected function set_totPag($novo_totPag) {
        $this->totPag = $novo_totPag;
    }

    protected function get_totPag() {
        return $this->totPag;
    }

    /**
     * Verificar mensagens dos visitantes, all_admin
     * @return string
     */
    public function carMens() {
        $str = "";
        $consulta = "SELECT dest FROM " . $this->get_tabMens() . " WHERE dest= 'all_admin' AND lida= '0'";
        $resultado = $this->retornoSQL($consulta);
        $row = $this->rowsSQL($resultado);
        if ($row > 0) {
            $str = " - <a href=\"mensg.php?pag=list_cont&tipo=all_admin\">" . $row . " contatos novos.</a>";
        }
        return $str;
    }

    /**
     * Verificar mensagens para o logado
     * @return <string> $msg
     * @global <type> $conexao
     */
    public function verificaMensagens($resp) {
        $msg = "";
        $consulta = " SELECT COUNT(*) num
                        FROM getar_mens
                       WHERE dest = '" . $resp . "'
                             AND situ = 'enviada'";
        $dados = $this->consultaSQL($consulta);
        $numMens = $dados['num'];

        if ($numMens > 0) {
            $msg = " - <a href=\"index.php?st=mensagens&ft=mens&pag=list&tipo=recb\">
            " . $dados['num'] . " mensagens novas</a>";
        }
        return $msg;
    }

    /**
     * Verefica se ha contatos vindo do site
     * e mensagens de erro SQL
     * @return string
     */
    public function verificaContatos() {
        $msg = "";
        //se for administrador
        $consulta = " SELECT COUNT(*) num
                        FROM getar_mens
                       WHERE dest = 'all_admin'
                             AND situ = 'enviada'";
        $dados = $this->consultaSQL($consulta);
        $numMens = $dados['num'];
        if ($numMens > 0) {
            $msg = " - <a href=\"index.php?st=mensagens&ft=mens&pag=contatos\">
            " . $dados['num'] . " Msg. all_admin novas</a>";
        }
        return $msg;
    }

    /**
     * Verificar lembretes para o logado
     * @return <string> $msg
     * @global <type> $conexao
     */
    public function verificaLembretes($resp) {

        $consulta = " SELECT COUNT(*) num
                        FROM getar_lembre
                       WHERE dataagd <= CURDATE()
                             AND dest = '" . $resp . "'
                             AND situ= 'ativo'";
        $dados = $this->consultaSQL($consulta);
        $msg = "";
        if ($dados['num'] > 0) {
            $msg = " - <a href=\"index.php?st=lembretes&ft=mens&pag=list&tipo=recb\">" . $dados['num'] . " lembretes para hoje </a>";
        }
        return $msg;
    }

    /**
     * Funcao para gerar paginacao.
     * Do script do documento pai deve vir a consulta na varivel $consulta
     * e a pagina a ser lista na variavel $pagina, o retorna sera dado
     * na variavel $listapag pela funcao.
     * Se $acao for relato sera impresso uma mensagem do tipo:
     * Numero de registros encontrados: 1035
     * Mostram-se paginas de 5 registros cada uma
     * A mostrar a pagina 2 de 207
     *
     * Forma de uso:
     * $pagina = $_GET['pagina'];
     * $resultado = gerapaginacao($consulta, $pagina);
     *
     * @param string $consulta
     * @param int $pagList
     * @return <type>
     */
    function geraPaginacao($consulta, $pagList) {

        //Limito a busca
        $tamanho_pagina = 20;
        //examino a pagina e o inicio do registro
        if (!$pagList) {
            $inicio = 0;
            $pagList = 1;
        } else {
            $inicio = ($pagList - 1) * $tamanho_pagina;
        }
        /* vejo o numero total de campos que ha na tabela com essa busca
          $consulta vem da pagina pai */
        $resultado = $this->retornoSQL($consulta);
        if ($this->get_suces() == FALSE) {
            $this->set_totPag(0);
            return $resultado;
        }
        $num_total_registros = $this->rowsSQL($resultado);
        //calculo o total de paginas
        $tot = ceil($num_total_registros / $tamanho_pagina);
        $this->set_totPag($tot);

        //construo a sentenca SQL incrementando o limite inicial e o final
        $consulta = $consulta . " LIMIT " . $inicio . "," . $tamanho_pagina;
        $resultado = $this->retornoSQL($consulta);
        return $resultado;
    }

    /**
     * Funcao para gerar os indices para a paginacao
     *     Do script do documento pai deve vir a pagina a ser lista na variavel $pagina,
     *     e $documento deve conter o link a ser chamado nos numeros de pagina.
     *     Obs.: Devem vir no m�nimo com "?" no final para permitir o uso com parametros, como nos
     *     exemplos abaixo:
     *     1 - ingresso.php?pag=list& sera ascressentado "pagina=2" = ingresso.php?pag=list&pagina=2
     *     2 - index.php? + "pagina=23" = index.php?pagina=23
     *
     *   echo  geraindicespaginas($pagina, "ingresso.php?pag=list&");
     * @param <type> $pagina
     * @param <type> $documento
     */
    function geraIndicesPaginas($pagList, $documento) {

        //Para nao imprimir + de 10 links paginas por documento
        $numero_paginas = 0;
        $str = "";
        if ($this->get_totPag() > 1) {

            $str = '<a href="' . $documento . '&paglst=1"> Primeira</a>';

            if ($pagList < 8) {
                $i = 1;
            } else {
                $i = $pagList - 2;
            }
            for ($i; $i <= $this->get_totPag(); $i++) {
                $numero_paginas++;
                if ($numero_paginas > 10) {

                    $str .= '<a href="' . $documento . '&paglst=' . $this->get_totPag() . '"> &Uacute;ltima</a>';

                    break;
                }
                if ($pagList == $i) {
                    //se mostro o indice da pagina atual, nao coloco link
                    $str .= $pagList . "| ";
                } else {
                    //se o indice nao corresponde com a pagina mostrada atualmente,
                    // coloco o link para ir a essa pagina

                    $str .= '<a href="' . $documento . '&paglst=' . $i . '">' . $i . '</a>|';
                }
            }
        }
        return $str;
    }

    /**
     * formata para tags HTML codigos ' \" \r \t
     * @param type $str
     * @param type $fck
     * @return type
     */
    public function html_texto($str, $fck = 0) {
        $str = str_replace("'", "&apos;", $str);
        if ($fck == 0) {
            $str = str_replace("\"", "&quot;", $str);
        }
        $str = str_replace("\r", "<br>", $str);
        $str = str_replace("\t", "<tab>", $str);
        $str = str_replace("\\", "&bsol;", $str); // a \ de c:\windows

        return $str;
    }

    /**
     * Metodo geraThumb
     * Gera thumbnail a partir da foto
     * Creditos: http://www.pablo.blog.br/35
     * Criado: Dezembro/2015
     * uso: geraThumb("DSCI0143.JPG", "novaFoto.jpg", '240');
     * @param <type> $photo
     * @param <type> $output
     * @param <type> $new_width 
     */
    public function geraThumb($photo, $output, $new_width) {
        global $pastaFotos;
        $source = imagecreatefromstring(file_get_contents($pastaFotos . $photo));
        list($width, $height) = getimagesize($pastaFotos . $photo);
        if ($width > $new_width) {
            $new_height = ($new_width / $width) * $height;
            $thumb = imagecreatetruecolor($new_width, $new_height);
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($thumb, $pastaFotos . $output, 100);
            copy($pastaFotos . $output, $pastaFotos . $photo);
            unlink($pastaFotos . $output);
        }
    }

    /**
     * formatarCpf (usado para formatar o CPF
     * @param string $valor
     * @return string formata Ex.: 123.123.123-99
     */
    function formatarCpf($valor) {
        $cpfNovo = substr($valor, 0, 3) . "." . substr($valor, 3, 3) . "." . substr($valor, 6, 3) . "-" . substr($valor, 9, 2);
        return $cpfNovo;
    }

    /**
     * formatarCnpj (usado para ...
     *  00.000.000/0000-00
     * @param <int> $valor
     * @return <string>
     */
    function formatarCnpj($numero) {
        $cnpjNovo = substr($numero, 0, 2) . "." . substr($numero, 2, 3) . "." . substr($numero, 5, 3) . "/" . substr($numero, 8, 4) . "-" . substr($numero, 12, 4);
        return $cnpjNovo;
    }

    /**
     * formatarTel (usada para formatar numeros telefone
     * Ex.: 5432119244 ->(54)3211-9244
     * @param <int> $valor
     * @return <string>
     */
    function formatarTel($numero) {
//
        $cnpjNovo = "(" . substr($numero, 0, 2) . ")" . substr($numero, 2, 4) . "-" . substr($numero, 6, 4);
        return $cnpjNovo;
    }

    /**
     * FormatarCep (usada para formata CEP
     *  Ex.: 95000123 ->95000-123
     * @param <int> $valor
     * @return <string>
     */
    function formatarCep($numero) {
        $cnpjNovo = substr($numero, 0, 5) . "-" . substr($numero, 5, 3);
        return $cnpjNovo;
    }

    /**
     * Faz alternancia na cor de fundo das linhas da listagem
     * @staticvar boolean $loopCor
     * @return string
     */
    public function corLinha() {
        static $loopCor = FALSE;

        if ($loopCor) {
            $corFundo = "corLinhaPar";
            $loopCor = FALSE;
        } else {
            $corFundo = "corLinhaImpar";
            $loopCor = TRUE;
        }

        return $corFundo;
    }

    /**
     * Retira a virgula do valor padrao Brasileiro para ser usado no banco MySQL
     * @param <string> $valor
     * @return <string>
     */
    function formataValorMySQL($valor) {
        $valorNovo = preg_replace("/,/", ".", $valor);
        return $valorNovo;
    }

    /**
     * Formata  o valor do banco MySQL para o padrao Brasileiro
     * Ex.: R$ 126,68
     * @param <string> $valor
     * @param <bool> $simbolo
     * @return <string>
     */
    function formataValorPadrao($valor, $simbolo = false) {
        $sinal = "";
        if (intval($valor) < 0) {
            $sinal = "-";
        }

        //Retirar a virgula do milhar
        $valor = preg_replace("/,/", "", $valor);

        $valorNovo = number_format(floatval($valor), 2, ',', '.');
        if ($simbolo) {
            $valorNovo = "R$ " . $sinal . $valor;
        }
        return $valorNovo;
    }

    /**
     * Cria um select com dia / mes / ano
     * se dia for xx nao retornara o campo dia
     * @param type $nome
     * @param type $dia
     * @param type $mes
     * @param type $ano
     * @return string.
     */
    function selectData($nome, $dia = "", $mes = "", $ano = "") {

        if ($dia == "" or $dia == "00") {
            $dia = date('d');
        }
        if ($mes == "" or $mes == "00") {
            $mes = date('m');
        }
        if ($ano == "" or $ano == "0000") {
            $ano = date('Y');
        }

        $str = "";
        if ($dia <> "xx") {//Suprimir a impresao do dia
            $str .= "<select name=\"dia" . $nome . "\">
            <option value=\"01\"" . selectedIf('01', $dia) . ">01</option>
            <option value=\"02\"" . selectedIf('02', $dia) . ">02</option>
            <option value=\"03\"" . selectedIf('03', $dia) . ">03</option>
            <option value=\"04\"" . selectedIf('04', $dia) . ">04</option>
            <option value=\"05\"" . selectedIf('05', $dia) . ">05</option>
            <option value=\"06\"" . selectedIf('06', $dia) . ">06</option>
            <option value=\"07\"" . selectedIf('07', $dia) . ">07</option>
            <option value=\"08\"" . selectedIf('08', $dia) . ">08</option>
            <option value=\"09\"" . selectedIf('09', $dia) . ">09</option>
            <option value=\"10\"" . selectedIf('10', $dia) . ">10</option>
            <option value=\"11\"" . selectedIf('11', $dia) . ">11</option>
            <option value=\"12\"" . selectedIf('12', $dia) . ">12</option>
            <option value=\"13\"" . selectedIf('13', $dia) . ">13</option>
            <option value=\"14\"" . selectedIf('14', $dia) . ">14</option>
            <option value=\"15\"" . selectedIf('15', $dia) . ">15</option>
            <option value=\"16\"" . selectedIf('16', $dia) . ">16</option>
            <option value=\"17\"" . selectedIf('17', $dia) . ">17</option>
            <option value=\"18\"" . selectedIf('18', $dia) . ">18</option>
            <option value=\"19\"" . selectedIf('19', $dia) . ">19</option>
            <option value=\"20\"" . selectedIf('20', $dia) . ">20</option>
            <option value=\"21\"" . selectedIf('21', $dia) . ">21</option>
            <option value=\"22\"" . selectedIf('22', $dia) . ">22</option>
            <option value=\"23\"" . selectedIf('23', $dia) . ">23</option>
            <option value=\"24\"" . selectedIf('24', $dia) . ">24</option>
            <option value=\"25\"" . selectedIf('25', $dia) . ">25</option>
            <option value=\"26\"" . selectedIf('26', $dia) . ">26</option>
            <option value=\"27\"" . selectedIf('27', $dia) . ">27</option>
            <option value=\"28\"" . selectedIf('28', $dia) . ">28</option>
            <option value=\"29\"" . selectedIf('29', $dia) . ">29</option>
            <option value=\"30\"" . selectedIf('30', $dia) . ">30</option>
            <option value=\"31\"" . selectedIf('31', $dia) . ">31</option>
        </select>/";
        }
        $str .= "<select name=\"mes" . $nome . "\">
            <option value=\"01\"" . selectedIf('01', $mes) . ">Janeiro</option>
            <option value=\"02\"" . selectedIf('02', $mes) . ">Fevereiro</option>
            <option value=\"03\"" . selectedIf('03', $mes) . ">Marco</option>
            <option value=\"04\"" . selectedIf('04', $mes) . ">Abril</option>
            <option value=\"05\"" . selectedIf('05', $mes) . ">Maio</option>
            <option value=\"06\"" . selectedIf('06', $mes) . ">Junho</option>
            <option value=\"07\"" . selectedIf('07', $mes) . ">Julho</option>
            <option value=\"08\"" . selectedIf('08', $mes) . ">Agosto</option>
            <option value=\"09\"" . selectedIf('09', $mes) . ">Setembro</option>
            <option value=\"10\"" . selectedIf('10', $mes) . ">Outubro</option>
            <option value=\"11\"" . selectedIf('11', $mes) . ">Novembro</option>
            <option value=\"12\"" . selectedIf('12', $mes) . ">Dezembro</option>
        </select>/
        <select name=\"ano" . $nome . "\"  >
    	<option value=\"1937\" " . selectedIf('1937', $ano) . ">1937</option>
    	<option value=\"1938\" " . selectedIf('1938', $ano) . ">1938</option>
    	<option value=\"1939\" " . selectedIf('1939', $ano) . ">1939</option>
    	<option value=\"1940\" " . selectedIf('1940', $ano) . ">1940</option>
    	<option value=\"1941\" " . selectedIf('1941', $ano) . ">1941</option>
    	<option value=\"1942\" " . selectedIf('1942', $ano) . ">1942</option>
    	<option value=\"1943\" " . selectedIf('1943', $ano) . ">1943</option>
    	<option value=\"1944\" " . selectedIf('1944', $ano) . ">1944</option>
    	<option value=\"1945\" " . selectedIf('1945', $ano) . ">1945</option>
    	<option value=\"1946\" " . selectedIf('1946', $ano) . ">1946</option>
    	<option value=\"1947\" " . selectedIf('1947', $ano) . ">1947</option>
    	<option value=\"1948\" " . selectedIf('1948', $ano) . ">1948</option>
    	<option value=\"1949\" " . selectedIf('1949', $ano) . ">1949</option>
    	<option value=\"1950\" " . selectedIf('1950', $ano) . ">1950</option>
    	<option value=\"1951\" " . selectedIf('1951', $ano) . ">1951</option>
    	<option value=\"1952\" " . selectedIf('1952', $ano) . ">1952</option>
    	<option value=\"1953\" " . selectedIf('1953', $ano) . ">1953</option>
    	<option value=\"1954\" " . selectedIf('1954', $ano) . ">1954</option>
    	<option value=\"1955\" " . selectedIf('1955', $ano) . ">1955</option>
    	<option value=\"1956\" " . selectedIf('1956', $ano) . ">1956</option>
    	<option value=\"1957\" " . selectedIf('1957', $ano) . ">1957</option>
    	<option value=\"1958\" " . selectedIf('1958', $ano) . ">1958</option>
    	<option value=\"1959\" " . selectedIf('1959', $ano) . ">1959</option>
    	<option value=\"1960\" " . selectedIf('1960', $ano) . ">1960</option>
    	<option value=\"1961\" " . selectedIf('1961', $ano) . ">1961</option>
    	<option value=\"1962\" " . selectedIf('1962', $ano) . ">1962</option>
    	<option value=\"1963\" " . selectedIf('1963', $ano) . ">1963</option>
    	<option value=\"1964\" " . selectedIf('1964', $ano) . ">1964</option>
    	<option value=\"1965\" " . selectedIf('1965', $ano) . ">1965</option>
    	<option value=\"1966\" " . selectedIf('1966', $ano) . ">1966</option>
    	<option value=\"1967\" " . selectedIf('1967', $ano) . ">1967</option>
    	<option value=\"1968\" " . selectedIf('1968', $ano) . ">1968</option>
    	<option value=\"1969\" " . selectedIf('1969', $ano) . ">1969</option>
    	<option value=\"1970\" " . selectedIf('1970', $ano) . ">1970</option>
    	<option value=\"1971\" " . selectedIf('1971', $ano) . ">1971</option>
    	<option value=\"1972\" " . selectedIf('1972', $ano) . ">1972</option>
    	<option value=\"1973\" " . selectedIf('1973', $ano) . ">1973</option>
    	<option value=\"1974\" " . selectedIf('1974', $ano) . ">1974</option>
    	<option value=\"1975\" " . selectedIf('1975', $ano) . ">1975</option>
    	<option value=\"1976\" " . selectedIf('1976', $ano) . ">1976</option>
    	<option value=\"1977\" " . selectedIf('1977', $ano) . ">1977</option>
    	<option value=\"1978\" " . selectedIf('1978', $ano) . ">1978</option>
    	<option value=\"1979\" " . selectedIf('1979', $ano) . ">1979</option>
    	<option value=\"1980\" " . selectedIf('1980', $ano) . ">1980</option>
    	<option value=\"1981\" " . selectedIf('1981', $ano) . ">1981</option>
    	<option value=\"1982\" " . selectedIf('1982', $ano) . ">1982</option>
    	<option value=\"1983\" " . selectedIf('1983', $ano) . ">1983</option>
    	<option value=\"1984\" " . selectedIf('1984', $ano) . ">1984</option>
    	<option value=\"1985\" " . selectedIf('1985', $ano) . ">1985</option>
    	<option value=\"1986\" " . selectedIf('1986', $ano) . ">1986</option>
    	<option value=\"1987\" " . selectedIf('1987', $ano) . ">1987</option>
    	<option value=\"1988\" " . selectedIf('1988', $ano) . ">1988</option>
    	<option value=\"1989\" " . selectedIf('1989', $ano) . ">1989</option>
    	<option value=\"1990\" " . selectedIf('1990', $ano) . ">1990</option>
    	<option value=\"1991\" " . selectedIf('1991', $ano) . ">1991</option>
    	<option value=\"1992\" " . selectedIf('1992', $ano) . ">1992</option>
    	<option value=\"1993\" " . selectedIf('1993', $ano) . ">1993</option>
    	<option value=\"1994\" " . selectedIf('1994', $ano) . ">1994</option>
    	<option value=\"1995\" " . selectedIf('1995', $ano) . ">1995</option>
    	<option value=\"1996\" " . selectedIf('1996', $ano) . ">1996</option>
    	<option value=\"1997\" " . selectedIf('1997', $ano) . ">1997</option>
    	<option value=\"1998\" " . selectedIf('1998', $ano) . ">1998</option>
    	<option value=\"1999\" " . selectedIf('1999', $ano) . ">1999</option>
    	<option value=\"2000\" " . selectedIf('2000', $ano) . ">2000</option>
    	<option value=\"2001\" " . selectedIf('2001', $ano) . ">2001</option>
    	<option value=\"2002\" " . selectedIf('2002', $ano) . ">2002</option>
    	<option value=\"2003\" " . selectedIf('2003', $ano) . ">2003</option>
    	<option value=\"2004\" " . selectedIf('2004', $ano) . ">2004</option>
    	<option value=\"2005\" " . selectedIf('2005', $ano) . ">2005</option>
    	<option value=\"2006\" " . selectedIf('2006', $ano) . ">2006</option>
    	<option value=\"2007\" " . selectedIf('2007', $ano) . ">2007</option>
    	<option value=\"2008\" " . selectedIf('2008', $ano) . ">2008</option>
    	<option value=\"2009\" " . selectedIf('2009', $ano) . ">2009</option>
    	<option value=\"2010\" " . selectedIf('2010', $ano) . ">2010</option>
    	<option value=\"2011\" " . selectedIf('2011', $ano) . ">2011</option>
    	<option value=\"2012\" " . selectedIf('2012', $ano) . ">2012</option>
    	<option value=\"2013\" " . selectedIf('2013', $ano) . ">2013</option>
    	<option value=\"2014\" " . selectedIf('2014', $ano) . ">2014</option>
    	<option value=\"2015\" " . selectedIf('2015', $ano) . ">2015</option>
    	<option value=\"2016\" " . selectedIf('2016', $ano) . ">2016</option>
    	<option value=\"2017\" " . selectedIf('2017', $ano) . ">2017</option>
    	<option value=\"2018\" " . selectedIf('2018', $ano) . ">2018</option>
    	<option value=\"2019\" " . selectedIf('2019', $ano) . ">2019</option>
    	<option value=\"2020\" " . selectedIf('2020', $ano) . ">2020</option>
    	<option value=\"2021\" " . selectedIf('2021', $ano) . ">2021</option>
    	<option value=\"2022\" " . selectedIf('2022', $ano) . ">2022</option>
    	<option value=\"2023\" " . selectedIf('2023', $ano) . ">2023</option>
    	<option value=\"2024\" " . selectedIf('2024', $ano) . ">2024</option>
    	<option value=\"2025\" " . selectedIf('2025', $ano) . ">2025</option>
    	<option value=\"2026\" " . selectedIf('2026', $ano) . ">2026</option>
    	<option value=\"2027\" " . selectedIf('2027', $ano) . ">2027</option>
    	<option value=\"2028\" " . selectedIf('2028', $ano) . ">2028</option>
    </select>";

        return $str;
    }

    /**
     * Retorna um selected para a opcao certa
     * @param type $dadoSel que vem do banco
     * @param type $dadoComp que pertence ao option
     * @return string
     */
    function selectedIf($dadoSel, $dadoComp) {
        if ($dadoSel == $dadoComp) {
            $str = " selected";
        } else {
            $str = "";
        }
        return $str;
    }

    /**
     * Retorna o mes por extenco 
     * 1 = Janeiro ...
     * @param type $numMes
     * @return string
     */
    function mesExtBR($numMes) {
        switch ($numMes) {
            case '1':
                $mes = "Janeiro";
                break;
            case '2':
                $mes = "Fevereiro";
                break;
            case '3':
                $mes = "Marco";
                break;
            case '4':
                $mes = "Abril";
                break;
            case '5':
                $mes = "Maio";
                break;
            case '6':
                $mes = "Junho";
                break;
            case '7':
                $mes = "Julho";
                break;
            case '8':
                $mes = "Agosto";
                break;
            case '9':
                $mes = "Setembro";
                break;
            case '01':
                $mes = "Janeiro";
                break;
            case '02':
                $mes = "Fevereiro";
                break;
            case '03':
                $mes = "Marco";
                break;
            case '04':
                $mes = "Abril";
                break;
            case '05':
                $mes = "Maio";
                break;
            case '06':
                $mes = "Junho";
                break;
            case '07':
                $mes = "Julho";
                break;
            case '08':
                $mes = "Agosto";
                break;
            case '09':
                $mes = "Setembro";
                break;
            case '10':
                $mes = "Outubro";
                break;
            case '11':
                $mes = "Novembro";
                break;
            case '12':
                $mes = "Dezembro";
                break;
        }
        return $mes;
    }

    /**
     * Monta uma listagem tabular
     * @param type $resultado
     * @return string
     */
    public function montaLista($resultado) {
        $str = "<table width=\"100%\">
                <caption>Listagem " . $this->tituloObjeto . ".</caption>
                <thead>
                    <tr>
                        <th>C&oacute;digo</th>
                        <th>" . $this->descrObjeto . "</th>
                        <th>&nbsp;" . $this->cabCol1 . "</th>
                        <th>&nbsp;" . $this->cabCol2 . "</th>
                        <th>&nbsp;" . $this->cabCol3 . "</th>
                        <th>&nbsp;" . $this->cabCol4 . "</th>
                        <th>&nbsp;" . $this->cabCol5 . "</th>
                    </tr>
                </thead>
                <tbody>";
        while ($dados = $this->arraySQL($resultado)) {
            if ($dados['col1']) {
                $col1 = $dados['col1'];
            } else {
                $col1 = "";
            }
            if (isset($dados['col2'])) {
                $col2 = $dados['col2'];
            } else {
                $col2 = "";
            }
            if (isset($dados['col3'])) {
                $col3 = $dados['col3'];
            } else {
                $col3 = "";
            }
            if (isset($dados['col4'])) {
                $col4 = $dados['col4'];
            } else {
                $col4 = "";
            }
            if (isset($dados['col5'])) {
                $col5 = $dados['col5'];
            } else {
                $col5 = "";
            }

            $str .= "<tr class=\"" . $this->corLinha() . "\">
                        <th>" . $dados['cod'] . "</th>
                        <td>" . $dados['descr'] . "
                            <a href=\"index.php?st=" . $this->st . "&ft=" . $this->ft . "&pag=" . $this->pag . "&" . $this->tipoCod . "=" . $dados['cod'] . "\">
                                <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                            </a>
                        </td>
                        <td>&nbsp;" . $col1 . "</td>
                        <td>&nbsp;" . $col2 . "</td>
                        <td>&nbsp;" . $col3 . "</td>
                        <td>&nbsp;" . $col4 . "</td>
                        <td>&nbsp;" . $col5 . "</td>
                    </tr>";
        }
        $str .= "
                </tbody>
            </table>";

        return $str;
    }

    /**
     * Monta um select com os administradores, tecnicos, engenheiros responsaveis
     * por algum modulo definico por $codAtrib
     * @param type $resp
     * @param type $codAtrib
     * @return string
     */
    public function selectResp($resp, $codAtrib) {
        $consulta = "SELECT cad.nome,
                            ctl.nick
                      FROM  getar_control ctl,
                            getar_cad cad
                      WHERE ctl.codcad = cad.cod
                            AND cad.situacao = 'ativo'
                            AND ctl.nick IN(SELECT nick
                                              FROM getar_atrib
                                             WHERE codatrib = " . $codAtrib . ") ";
        $retorno = $this->retornoSQL($consulta);
        $str = "<select name=\"resp\">
                        <option value=\"\">Selecione</option>";
        while ($dados = $this->arraySQL($retorno)) {
            $str .= "<option value=\"" . $dados["nick"] . "\" " . $this->selectedIf($dados["nick"], $resp) . " >" . $dados["nome"] . "</option>";
        }
        $str .= "</select>";

        return $str;
    }

    /**
     * select com cliente ativos
     * @return string str
     */
    public function selectCliente($codCli) {
        /**
         *  O cliente do projeto pode deixar de receber a classificacao de cliente e
         * deixar de ser listado no select, por isso ele é listado primeiro mesmo correndo
         * o risco de listagem duplo
         */
        $consulta = "SELECT cod, nome FROM getar_cad WHERE cod='" . $codCli . "'";
        $dados = $this->consultaSQL($consulta);
        $str = "<select name=\"codCliente\">
                    <option value=\"" . $dados["cod"] . "\" selected=\"\">" . $dados["nome"] . "</option>";

        $consulta = "SELECT cod, nome FROM getar_cad WHERE clasf='c' AND situacao = 'ativo'";
        $retorno = $this->retornoSQL($consulta);
        while ($dados = $this->arraySQL($retorno)) {
            $str .= "<option value=\"" . $dados["cod"] . "\">" . $dados["nome"] . "</option>";
        }
        $str .= "</select>";

        return $str;
    }

    /**
     * select de estados brasileiros
     * @param type $uf
     * @return string
     */
    public function selectEstados($uf, $pais = 1) {
        $consulta = "SELECT sgl, nome FROM estado WHERE codpais= " . $pais;
        $retorno = $this->retornoSQL($consulta);
        $str = "<select name=\"estado\">
                    <option value=\"\">Selecione</option>";
        while ($dados = $this->arraySQL($retorno)) {
            $str .= "<option value=\"" . $dados["nome"] . "\" " . $this->selectedIf($dados["nome"], $uf) . ">" . $dados["nome"] . "</option>";
        }
        $str .= "</select>";

        return $str;
    }

    /**
     * select de pais cadastrados
     * @param type $pais
     * @return string
     */
    public function selectPais($pais = 1) {
        $consulta = "SELECT DISTINCT pais FROM estado ORDER BY pais ";
        $retorno = $this->retornoSQL($consulta);
        $str = "<select name=\"pais\">
                    <option value=\"\">Selecione</option>";
        while ($dados = $this->arraySQL($retorno)) {
            $str .= "<option value=\"" . $dados["pais"] . "\" " . $this->selectedIf($dados["pais"], $pais) . ">" . $dados["pais"] . "</option>";
        }
        $str .= "</select>";

        return $str;
    }

    /**
     * Critica a idade minima em comparacao com $idadeNin
     * @param <int> $diaNasc
     * @param <int> $mesNasc
     * @param <int> $anoNasc
     * @param <int> $idadeMin
     * @return boolean TRUE se idade maior que $idadeMin
     */
    public function validaIdade($diaNasc, $mesNasc, $anoNasc, $idadeMin) {
        // calculo da referencia
        $totAtu = (date("Y") * 365 + date("m") * 30 + date("d"));
        $totMin = $totAtu - ($idadeMin * 365);

        // calculo total dias da idade
        $totNasc = $anoNasc * 365 + $mesNasc * 30 + $diaNasc;

        if ($totNasc < $totMin) {
            $valida = TRUE;
        } else {
            $valida = FALSE;
        }

        return $valida;
    }

    /**
     * Validar CPF
     * Fonte: http://www.geradorcpf.com/script-validar-cpf-php.htm
     * @param type $cpf
     * @return boolean
     */
    public function validaCPF($cpf = null) {
        // Verifica se um numero foi informado
        if (empty($cpf)) {
            return false;
        }

        // Elimina possivel mascara
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        // Verifica se o numero de digitos informados eh igual a 11 
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se nenhuma das sequencias invalidas abaixo 
        // foi digitada. Caso afirmativo, retorna falso
        else if ($cpf == '00000000000' ||
                $cpf == '11111111111' ||
                $cpf == '22222222222' ||
                $cpf == '33333333333' ||
                $cpf == '44444444444' ||
                $cpf == '55555555555' ||
                $cpf == '66666666666' ||
                $cpf == '77777777777' ||
                $cpf == '88888888888' ||
                $cpf == '99999999999') {
            return false;
            // Calcula os digitos verificadores para verificar se o
            // CPF eh válido
        } else {
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    #$d += $cpf{$c} * (($t + 1) - $c);
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }
            return true;
        }
    }

    /**
     * Validar o CNPJ
     * @param type $cnpj
     * @return boolean
     */
    public function validaCNPJ($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;

        // Verifica se todos os digitos são iguais
        if (preg_match('/(\d)\1{13}/', $cnpj))
            return false;

        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto))
            return false;

        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;

        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
        //return TRUE;
    }

    /**
     * Select dos estados civil
     * @param type $estCiv
     * @return string
     */
    public function selectEstCiv($estCiv) {
        $str = "<select name=\"estciv\">
                <option value=\"solteiro\"" . $this->selectedIf('solteiro', $estCiv) . ">Solteiro</option>
                <option value=\"casado\"" . $this->selectedIf('casado', $estCiv) . ">Casado</option>
                <option value=\"viuvo\"" . $this->selectedIf('viuvo', $estCiv) . ">Viuvo</option>
                <option value=\"estavel\"" . $this->selectedIf('estavel', $estCiv) . ">Uniao Estavel</option>
               </select>";

        return $str;
    }

    /**
     * Verifica se um esta esta de escrito de forma correta
     * fonte: http://codigofonte.uol.com.br/codigos/validacao-de-cep-com-expressao-regular-em-php
     * @param type $cep
     * @return boolean
     */
    public function validaCEP($cep) {
        // retira espacos em branco
        $cep = trim($cep);
        // expressao regular para avaliar o cep
        $avaliaCep = preg_match("/^[0-9]{5}-[0-9]{3}$/", $cep);

        // verifica o resultado
        if (!$avaliaCep) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * Cadastro rapido do cliente
     * Complemento de formulario
     * @return string
     */
    public function clienteCadRap() {
        $str = "<div id=\"cadRapCli\">
                    <label>&nbsp;</label><i><div id=\"divNome\">&nbsp;</div></i>
                    <br style=\"clear:both;\" />
                    <label>Cliente: </label>
                    <input name=\"nome\" type=\"text\" placeholder=\"Nome Cliente\" autocomplete=\"off\" size=\"42\" maxlength=\"120\" onkeyup=\"atualDivNome(this.value);\" /><br/>
                    <label>Endere&ccedil;o: </label><input name=\"endr\" type=\"text\" placeholder=\"Rua, 1234\" size=\"42\" maxlength=\"120\"/><br/>
                    <label>N&uacute;mero: </label><input name=\"num\" type=\"text\" placeholder=\"1234\" size=\"10\" maxlength=\"6\"/><br/>
                    <label>Bairro: </label><input name=\"bai\" type=\"text\" placeholder=\"Bairro Centro\" size=\"42\" maxlength=\"60\"/><br/>
                    <label>CEP: </label><input name=\"cep\" type=\"text\" placeholder=\"00000-000\" size=\"10\" maxlength=\"9\"/><br/>
                    <label>Cidade: </label><input name=\"cidade\" type=\"text\" placeholder=\"Cidade\" size=\"22\" maxlength=\"40\"/><br/>
                    <label>Estado: </label>" . $this->selectEstados("") . "<br/>
                    <label>Telefone: </label><input name=\"fone\" type=\"text\" placeholder=\"(99)9 9999-9999\" size=\"17\" maxlength=\"15\"/>
                </div>";

        return $str;
    }

    /**
     * Cadastra um cliente com campos minimo
     * @param type $nome
     * @param type $endr
     * @param type $bai
     * @return <int> cod do cliente cadastrado
     */
    public function clienteSalvRap($nome, $endr, $bai) {
        global $cidPadr, $estPadr;

        $consulta = "INSERT INTO getar_cad (nome, clasf, desde, endr, bairro, cidade, estado, situacao)
                                     VALUES('" . $nome . "', 'c', CURDATE(), '" . $endr . "', '" . $bai . "', '" . $cidPadr . "', '" . $estPadr . "', 'ativo')";
        $codCad = executaIdSQL($consulta);

        return $codCad;
    }

    /**
     * Insere um nomero de telefone rapido
     * @param type $codCli
     * @param type $descr
     * @param type $numero
     * @param type $ramal
     * @return type
     */
    public function clienteSalvFone($codCli, $descr, $numero, $ramal = "") {
        $consulta = "INSERT INTO getar_fones (codcli, descr, numero, ramal)
                                       VALUES(" . $codCli . ", '" . $descr . "', '" . $numero . "', '" . $ramal . "')";
        $codFone = executaIdSQL($consulta);

        return $codFone;
    }

    /**
     * Detalha resumidamente o Nome, Endereco e telefones do cliente
     * @param type $codcad
     * @return array
     */
    public function clienteDetalRap($codcad) {

        $consulta = "SELECT cad.nome,
                            cad.cidade,
                            GROUP_CONCAT(fn.numero) fone
                       FROM getar_cad cad,
                            getar_fones fn
                      WHERE fn.codcli = cad.cod
                            AND cad.cod =" . $codcad;
        $dados = consultaSQL($consulta);

        return $dados;
    }

    /**
     * Devolve o texto do formato com codiog HTML para normal
     * @param <type> $str
     * @return <type>
     */
    public function devolve_texto($str) {
        $str = str_replace("<br>", "\r", $str);
        $str = str_replace("<tab>", "\t", $str);
        $str = str_replace("&apos;", "'", $str);
        $str = str_replace("&bsol;", trim("\ ", " "), $str); // a \ de c:\windows

        return $str;
    }

}
