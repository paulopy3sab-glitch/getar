<?php

/**
 * Funcoes de formatacao uteis para varios sistemas
 */
global $TOTALPAGINAS;
$TOTALPAGINAS = 0; //variavel global para compartilhar a total de pagina

/**
 * Verificar o logon e encaminhar para logof se necessario
 * $_SESSION['resp'] $_SESSION['codresp']
 * @return true se validado
 */
function user_validacao() {
    $validado = FALSE;
    if (!isset($_SESSION['codresp'])) {
        session_unset();
    } else {
        $validado = TRUE;
    }

    return $validado;
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
 * @global <type> $conexao
 * @param string $consulta
 * @param int $pagina
 * @return <type>
 */
function gerapaginacao($consulta, $pagina) {
    global $TOTALPAGINAS;

    //Limito a busca
    $tamanho_pagina = 20;
    //examino a pagina e o inicio do registro
    if (!$pagina) {
        $inicio = 0;
        $pagina = 1;
    } else {
        $inicio = ($pagina - 1) * $tamanho_pagina;
    }
    /* vejo o numero total de campos que ha na tabela com essa busca
      $consulta vem da pagina pai */
    $resultado = retornoSQL($consulta);
    $num_total_registros = rowsSQL($resultado);
    //calculo o total de paginas
    $TOTALPAGINAS = ceil($num_total_registros / $tamanho_pagina);

    //construo a sentenca SQL incrementando o limite inicial e o final
    $consulta = $consulta . " LIMIT " . $inicio . "," . $tamanho_pagina;
    $listapag = retornoSQL($consulta);
    return $listapag;
}

/**
 * Funcao para gerar os indices para a paginacao
 *     Do script do documento pai deve vir a pagina a ser lista na variavel $pagina,
 *     e $documento deve conter o link a ser chamado nos numeros de pagina.
 *     Obs.: Devem vir no minimo com "?" no final para permitir o uso com parametros, como nos
 *     exemplos abaixo:
 *     1 - ingresso.php?pag=list& sera ascressentado "pagina=2" = ingresso.php?pag=list&pagina=2
 *     2 - index.php? + "pagina=23" = index.php?pagina=23
 *
 *   echo  geraindicespaginas($pagina, "ingresso.php?pag=list&");
 * @param <type> $pagina
 * @param <type> $documento
 */
function geraindicespaginas($pagina, $documento) {
    global $TOTALPAGINAS;

    //Para nao imprimir + de 10 links paginas por documento
    $numero_paginas = 0;
    $retorno = "";
    if ($TOTALPAGINAS > 1) {

        $retorno = '<a href="' . $documento . 'pagina=1"> Primeira</a>';

        if ($pagina < 8) {
            $i = 1;
        } else {
            $i = $pagina - 2;
        }
        for ($i; $i <= $TOTALPAGINAS; $i++) {
            $numero_paginas++;
            if ($numero_paginas > 10) {

                $retorno .= '<a href="' . $documento . 'pagina=' . $TOTALPAGINAS . '"> &Uacute;ltima</a>';

                break;
            }
            if ($pagina == $i) {
                //se mostro o indice da pagina atual, nao coloco link
                $retorno .= $pagina . "| ";
            } else {
                //se o indice nao corresponde com a pagina mostrada atualmente,
                // coloco o link para ir a essa pagina

                $retorno .= '<a href="' . $documento . 'pagina=' . $i . '">' . $i . '</a>|';
            }
        }
    }
    return $retorno;
}

/**
 * Devolve o texto do formato com codiog HTML para normal
 * @param <type> $str
 * @return <type>
 */
function devolve_texto($str) {
    $str = str_replace("<br>", "\r", $str);
    $str = str_replace("<tab>", "\t", $str);
    $str = str_replace("&apos;", "'", $str);
    $str = str_replace("&bsol;", trim("\ ", " "), $str);
    return $str;
}

/**
 * Codifica carecteres especias para codigo HTML
 * @param <type> $str
 * @return <type>
 */
function html_texto($str) {
    $str = str_replace("'", "&apos;", $str);
    $str = str_replace(trim("\ ", " "), "&bsol;", $str);
    $str = str_replace("\r", "<br>", $str);
    $str = str_replace("\t", "<tab>", $str);
    return $str;
}

/**
 *
 * @param <type> $str
 * @return <type>
 */
function trata_arqu($str) {
    $str = str_replace("À", "A", $str); //À
    $str = str_replace("Á", "A", $str); //Á
    $str = str_replace("Â", "A", $str); //Â
    $str = str_replace("Ã", "A", $str); //Ã
    $str = str_replace("Ä", "A", $str); //Ä
    $str = str_replace("É", "E", $str); //É
    $str = str_replace("Ê", "E", $str); //Ê
    $str = str_replace("Í", "I", $str); //Í
    $str = str_replace("Ó", "O", $str); //Ó
    $str = str_replace("Õ", "O", $str); //Õ
    $str = str_replace("Ô", "O", $str); //Ô
    $str = str_replace("Ú", "U", $str); //Ú
    $str = str_replace("Ü", "U", $str); //Ü
    $str = str_replace("Ç", "C", $str); //Ç
    $str = str_replace("ã", "a", $str); //ã
    $str = str_replace("à", "a", $str); //à
    $str = str_replace("á", "a", $str); //á
    $str = str_replace("â", "a", $str); //â
    $str = str_replace("é", "e", $str); //é
    $str = str_replace("ê", "e", $str); //ê
    $str = str_replace("í", "i", $str); //í
    $str = str_replace("ó", "i", $str); //ó
    $str = str_replace("õ", "o", $str); //õ
    $str = str_replace("ô", "o", $str); //ô
    $str = str_replace("ú", "u", $str); //ú
    $str = str_replace("ü", "u", $str); //ü
    $str = str_replace("ç", "c", $str); //ç
    $str = str_replace(" ", "_", $str);
    $str = str_replace("'", "-", $str);
    $str = str_replace("[", "-", $str);
    $str = str_replace("]", "-", $str);
    $str = str_replace("{", "-", $str);
    $str = str_replace("}", "-", $str);
    $str = str_replace("(", "-", $str);
    $str = str_replace(")", "-", $str);
    $str = str_replace("@", "-", $str);
    return $str;
}

/**
 * Retorna um array com os estados do Brasil
 * @return string
 */
function listaUF() {
    $arrayUF["ac"] = "Acre";
    $arrayUF["al"] = "Alagoas";
    $arrayUF["ap"] = "Amapa";
    $arrayUF["am"] = "Amazonas";
    $arrayUF["ba"] = "Bahia";
    $arrayUF["df"] = "Distrito Federal";
    $arrayUF["ec"] = "Espirito Santo";
    $arrayUF["go"] = "Goias";
    $arrayUF["ma"] = "Maranhão";
    $arrayUF["mg"] = "Minas Gerais";
    $arrayUF["mt"] = "Mata Grosso";
    $arrayUF["ms"] = "Mato Grosso do Sul";
    $arrayUF["pa"] = "Pará";
    $arrayUF["pb"] = "Paraiba";
    $arrayUF["pr"] = "Paraná";
    $arrayUF["pe"] = "Pernanbuco";
    $arrayUF["pi"] = "Piaui";
    $arrayUF["rj"] = "Rio de Janeiro";
    $arrayUF["rn"] = "Rio Grande do Norte";
    $arrayUF["rs"] = "Rio Grande do Sul";
    $arrayUF["ro"] = "Rondonia";
    $arrayUF["rr"] = "Roraima";
    $arrayUF["sc"] = "Santa Catarina";
    $arrayUF["sp"] = "São Paulo";
    $arrayUF["se"] = "Sergipe";
    $arrayUF["to"] = "Tocantins";
    return $arrayUF;
}

/**
 * Para converter as data para o formato SQL
 *
 * @param string $data
 * @return string
 */
function dataMySQL($data) {
    return $data = date('Y-m-d', strtotime(str_replace("/", "-", $data)));
}

/**
 * Para converter as do formato SQL
 *
 * @param string $data
 * @return string
 */
function dataNormal($data) {
    return $data = date('d/m/Y', strtotime($data));
}

/**
 * Retorna o nome de um estado pela sigla
 * Ex. rs -> Rio Grande do Sul
 * @global <array> $arrayUF
 * @param <string> $uf
 * @return <string>
 */
function retornaEstado($uf) {
    $arrayUF = listaUF();
    $uf = strtolower($uf);
    return $arrayUF[$uf];
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
 * Para trocar a cor de fundo das linhas de listagem alternadamente
 * retorn corLinhaPar ou corlinhaImpar alternadamente
 * opcao alternar se 0 desativa a troco apenas retornando a atual
 * @global <boolean> $loopColor
 * @global <string> $corFundo
 * @param <int> $alternar
 * @return <string>
 */
function corLinha($alternar = 1) {
    global $loopColor, $corFundo;

    if ($alternar) {
        if ($loopColor) {
            $corFundo = "corLinhaPar";
            $loopColor = false;
        } else {
            $corFundo = "corLinhaImpar";
            $loopColor = true;
        }
    }

    return $corFundo;
}

/**
 * Retira a virgula do valor padrao Brasileiro para ser usado no banco MySQL
 * @param <string> $valor
 * @return <string>
 */
function formatarValorMySQL($valor) {
    $valorNovo = "";
    $centavos = "00";
    if (mb_strpos($valor, ",") !== FALSE) {
        $arrayValor = explode(",", $valor);
        $centavos = $arrayValor[1];
        $valorNovo = str_replace(".", "", $valor);
    }
    # se foi digitado como exemplo= .12
    if ($valorNovo !== "") {
        $valorNovo = floatval($valorNovo) . "." . $centavos;
    } else {
        $valorNovo = floatval($valor);
    }

    return $valorNovo;
}

/**
 * Formata  o valor do banco MySQL para o padrao Brasileiro
 * Ex.: R$ 126,68
 * @param <string> $valor
 * @param <bool> $simbolo
 * @return <string>
 */
function formatarValorPadrao($valor, $simbolo = false) {
    $sinal = "";
    if (intval($valor) < 0) {
        $sinal = "-";
    }

    //Retirar a virgula do milhar
    $valor = preg_replace("/,/", "", $valor);

    $valorNovo = number_format(floatval($valor), 2, ',', '.');
    if ($simbolo) {
        $valorNovo = "R$ " . $sinal . $valorNovo;
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
 * @param type $hoje faz a date null ser a atuaal
 * @return string.
 */
function selectData($nome, $dia = "", $mes = "", $ano = "", $hoje = TRUE) {

    if ($hoje) {
        if ($dia == "" or $dia == "00") {
            $dia = date('d');
        }
        if ($mes == "" or $mes == "00") {
            $mes = date('m');
        }
        if ($ano == "" or $ano == "0000") {
            $ano = date('Y');
        }
    }

    $str = "";
    if ($dia <> "xx") {//Suprimir a impresao do dia
        $str .= "<select name=\"dia" . $nome . "\">
            <option value=\"00\"" . selectedIf('00', $dia) . ">00</option>
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
            <option value=\"00\"" . selectedIf('00', $mes) . ">Selecione</option>
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
    	<option value=\"0000\" " . selectedIf('0000', $ano) . ">0000</option>
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
 * Um select com os anos mais atuai
 * REQUER ATUALIZACAO ANUAL
 * @param type $nome
 * @param type $dia
 * @param type $mes
 * @param type $ano
 * @param type $hoje
 * @return string
 */
function selectDataAtu($nome, $dia = "", $mes = "", $ano = "", $hoje = TRUE) {

    if ($hoje) {
        if ($dia == "" or $dia == "00") {
            $dia = date('d');
        }
        if ($mes == "" or $mes == "00") {
            $mes = date('m');
        }
        if ($ano == "" or $ano == "0000") {
            $ano = date('Y');
        }
    }

    $str = "";
    if ($dia <> "xx") {//Suprimir a impresao do dia
        $str .= "<select name=\"dia" . $nome . "\">
            <option value=\"00\"" . selectedIf('00', $dia) . ">00</option>
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
            <option value=\"00\"" . selectedIf('00', $mes) . ">Selecione</option>
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
        <select name=\"ano" . $nome . "\"  >";
    if ($ano == '00') {
        $str.=" <option value=\"00\"" . selectedIf('00', $ano) . ">Selecione</option>";
    } else {
        $str.=" <option value=\"" . $ano . "\" selected>" . $ano . "</option>";
    }
    $str.=" <option value=\"2016\" " . selectedIf('2016', $ano) . ">2016</option>
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
    $mes = "";
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
 * Select para os clientes
 * @param type $codcad
 * @return string
 */
function selectCliente($codcad = "") {
    $consulta = "    SELECT cod,
                            nome
                       FROM getar_cad 
                      WHERE clasf='c'
                            AND situacao = 'ativo'
                            AND cod NOT IN (2, 3)";
    $retorno = retornoSQL($consulta);

    $str = "<select name=\"codcli\">";

    while ($dados = arraySQL($retorno)) {
        $str .= "<option value=\"" . $dados['cod'] . "\"" . selectedIf($codcad, $dados['cod']) . " >" . $dados['nome'] . "</option>";
    }

    $str .= "</select>";

    return $str;
}

/**
 * Monta um select com os administradores, tecnicos, engenheiros responsaveis
 * por algum modulo definico por $codAtrib
 * @param type $resp
 * @param type $codAtrib
 * @return string
 */
function selectResp($resp, $codAtrib) {
    $consulta = "SELECT cad.nome,
                        ctl.nick
                  FROM  getar_control ctl,
                        getar_cad cad
                  WHERE ctl.codcad = cad.cod
                        AND cad.situacao = 'ativo'
                        AND ctl.nick IN(SELECT nick
                                          FROM getar_atrib
                                         WHERE codatrib = " . $codAtrib . ") ";
    $retorno = retornoSQL($consulta);
    $str = "<select name=\"resp\">
                        <option value=\"\">Selecione</option>";
    while ($dados = arraySQL($retorno)) {
        $str .= "<option value=\"" . $dados["nick"] . "\" " . selectedIf($dados["nick"], $resp) . " >" . $dados["nome"] . "</option>";
    }
    $str .= "</select>";

    return $str;
}

/**
 * Cadastro rapido do cliente
 * @return string
 */
function clienteCadRap() {
    $str = "<div id=\"cadRapCli\">
                <label>&nbsp;</label><i><div id=\"divNome\">&nbsp;</div></i>
                <br style=\"clear:both;\" />
                <label>Cliente: </label>
                <input name=\"nome\" type=\"text\" placeholder=\"Nome Cliente\" autocomplete=\"off\" size=\"42\" maxlength=\"120\" onkeyup=\"atualDivNome(this.value);\" /><br/>
                <label>Endere&ccedil;o: </label><input name=\"endr\" type=\"text\" placeholder=\"Rua, 1234\" size=\"42\" maxlength=\"120\"/><br/>
                <label>Bairro: </label><input name=\"bai\" type=\"text\" placeholder=\"Bairro Centro\" size=\"42\" maxlength=\"60\"/><br/>
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
function clienteSalvRap($nome, $endr, $num, $bai, $cep = "", $cidade = "", $est = "") {
    global $cidPadr, $estPadr;

    if ($cidade == "") {
        $cidade = $cidPadr;
    }
    if ($est == "") {
        $est = $estPadr;
    }
    $consulta = "INSERT INTO getar_cad (nome, clasf, desde, endr, numero, bairro, cep, cidade, getar_estado_cod, situacao)
                                VALUES('" . $nome . "', 'c', CURDATE(), '" . $endr . "', '" . $num . "', '" . $bai . "', '" . $cep . "', '" . $cidade . "', " . $est . ", 'ativo')";
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
function clienteSalvFone($codCli, $descr, $numero, $ramal = "") {
    $consulta = "INSERT INTO getar_fones (codcli, descr, numero, ramal)
                      VALUES(" . $codCli . ", '" . $descr . "', '" . $numero . "', '" . $ramal . "')";
    $codFone = executaIdSQL($consulta);

    return $codFone;
}

/**
 * Detalha resumidamente o Nome, Endereco do cliente
 * @param type $codcad
 * @return array
 */
function clienteDetalRap($codcad) {

    $consulta = "  SELECT cad.nome,
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
 * Extrai a primeira hashtag # do texto
 * @param type $string
 * @return string
 */
function extraiHashtag($string) {
    $str = "";
    $x = strstr($string, "#");
    $str = strstr($x, " ", TRUE);

    return $str;
}