<?php

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data de criacao: Marco/2017
 * Descricao: Funcoes de apoio a Ordem de Servicos e Equipamento
 * Revisoes:
 * 09/01/2018 - pregis
 * Retomada das atualizacoes
 */

/**
 * 
 * @return string
 */
function relatoSemFone() {
    $consulta = " SELECT cad.cod,
                         cad.nome,
                         cad.desde,
                         cad.clasf,
                         cad.situacao
                    FROM getar_cad cad
                   WHERE cad.clasf = 'c'
                         AND cad.cod IN(SELECT DISTINCT(codcli)
                                          FROM equipo
                                         WHERE codcli NOT IN(SELECT fn.codcli FROM getar_fones fn))
                ORDER BY nome DESC";
    $resultado = retornoSQL($consulta);
    $row = rowsSQL($resultado);
    $str = "";
    if ($row > 0) {
        $str .= "<table width=\"100%\">
                    <caption>LISTAGEM DE CLIENTES SEM TELEFONE</caption>
                    <thead>
                        <tr>
                            <th>C&oacute;digo</th>
                            <th>Cliente</th>
                            <th>Desde</th>
                        </tr>
                    </thead>
                    <tbody>";
        while ($dados = arraySQL($resultado)) {
            $str.="<tr>
                      <th>" . $dados['cod'] . "</th>
                      <td>
                      " . $dados['nome'] . "";
            $str.="<a href=\"index.php?st=cadastro&pag=edit&codcad=" . $dados["cod"] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"Editar\" title=\"Editar este registro\">
                        </a>";
            $str .="  </td>
                      <td>" . $dados['desde'] . "
                   </tr>";
        }
    } else {
        $str = "Todos tem telefone";
    }
    $str.="</tbody>
        </table>";
    return $str;
}

/**
 * Lista de tarefas
 * @param type $codOS
 * @param type $edit
 * @return string
 */
function tarfList($codOS, $edit = TRUE) {
    $consulta = "SELECT cod,
                        DATE_FORMAT(dataexec, '%d/%m/%Y') dataexec,
                        DATE_FORMAT(dataexec, '%m') mes,
                        DATE_FORMAT(horaini, '%k:%i') horaini,
                        TIMEDIFF(horafim, horaini) AS tempo,
                        tecn,
                        descr,
                        REGEXP_SUBSTR(descr, '#[a-z]+') AS tag
                   FROM ordem_tarf
                  WHERE codos = " . $codOS . "
                        AND situ = 'concluida'
                  ORDER BY cod DESC";
    $resultado = retornoSQL($consulta);
    $row = rowsSQL($resultado);
    $str = "";
    $hashtag = "";
    if ($row > 0) {
        $str .= "<hr />
                 <span class=\"sub-titulo\"> Tarefas: </span><br>";
        $dataAnt = "";
        $dataList = "";
        $mesAnt = "";
        $mesList = "";
        while ($dados = arraySQL($resultado)) {
            // separando por dia
            $dataList = $dados['dataexec'];
            if ($dataList <> $dataAnt) {
                $str.=" <span class=\"txt\"><b>" . $dataList . "</b></span><br />";
            }
            // trocando de mes
            $mesList = $dados['mes'];
            if ($mesList <> $mesAnt) {
                $str.=" <span class=\"txt\"><b>" . mesExtBR($mesList) . "</b></span><br />";
            }
            $str .= "<span class=\"txt\"><b>" . $dados['cod'] . "</b>";
            if ($edit) {
                $str.="<a href=\"index.php?st=ordm&pag=edit&codos=" . $codOS . "&codtarf=" . $dados['cod'] . "\">
                           <img src=\"imagens/editar.gif\" alt=\"Editar\" style=\"width: 16px;\" title=\"Editar Tarefa\">
            </a>";
            }
            $str.= " - (Tecnico: <b>" . $dados['tecn'] . "</b>)
                       Hora Inicio: <b>" . $dados['horaini'] . "</b> - Dura&ccedil;&atilde;o: <b>" . $dados['tempo'] . "</b>
                     </span><br>
                     <textarea cols=\"80\" rows=\"6\" readonly=\"\">" . devolve_texto($dados['descr']) . "</textarea><br />";
            $dataAnt = $dados['dataexec'];
            $mesAnt = $dados['mes'];
            if ($dados['tag']) {
                $hashtag.= "<a href=\"index.php?st=ordm&pag=edit&codos=" . $codOS . "&codtarf=" . $dados['cod'] . "\">
                    " . $dados['tag'] . "</a>&nbsp;";
                # contagem de hashtag
                $array = explode("#", $dados['descr']);
                $numArray = count($array) - 1;
                if ($numArray > 1) {
                    $str.= "<b style=\"color: red;\">Erro!!! - " . $numArray . " tags #</b>";
                }
            }
        }
        $str .= "<span class=\"sub-titulo\">Total horas trabalhadas: " . tarfTotHora2($codOS) . "</span><br />";
    }
    $str.="<br />" . $hashtag;

    return $str;
}

/**
 * 
 * @param type $codOS
 * @return string
 */
function hashtagList($codOS){
    $consulta = "SELECT cod,
                        REGEXP_SUBSTR(descr, '#[a-z]+') AS tag
                   FROM ordem_tarf
                  WHERE codos = " . $codOS . "
                        AND situ = 'concluida'
                  ORDER BY cod DESC";
    $resultado = retornoSQL($consulta);
    $row = rowsSQL($resultado);
    $str = "";
    $hashtag = "";
    if ($row > 0) {
        while ($dados = arraySQL($resultado)) {
            $hashtag.= "<a href=\"index.php?st=ordm&pag=edit&codos=" . $codOS . "&codtarf=" . $dados['cod'] . "\">
                            " . $dados['tag'] . "</a>&nbsp;";
        }
    }
    return $hashtag;
}
/**
 * Retorna o total de horas trabalhadas num OS
 * @param type $codOS
 * @return type
 * Obsoleta
 */
function tarfTotHora($codOS) {
    $consulta = "SELECT DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(horafim, horaini)))), '%H:%i') AS tothora
                   FROM ordem_tarf WHERE codos =" . $codOS;
    $dados = consultaSQL($consulta);

    return $dados['tothora'];
}

/**
 * Nova versao com controle mais detalhado das horas e minutos, ha problemas quando tem mais de 24 horas total trabalhadas
 * @param type $codOS
 * @return type
 */
function tarfTotHora2($codOS) {
    $consulta = "SELECT SUM(DATE_FORMAT((TIMEDIFF(horafim, horaini)), '%H')) hora,
                        SUM(DATE_FORMAT((TIMEDIFF(horafim, horaini)), '%i')) min
                   FROM ordem_tarf
                  WHERE codos=" . $codOS . "
                        AND situ = 'concluida'";
    $dados = consultaSQL($consulta);

    /**
     * Retirando as horas do total dos minutos
     */
    $hora = $dados['hora'];
    $horaMin = $dados['min'] / 60;
    $min = $dados['min'] % 60;
    $horaTot = $hora + $horaMin;
    if ($min < 10) {
        $zero = "0";
    } else {
        $zero = "";
    }

    $str = intval($horaTot) . " horas e " . $zero . $min . " minutos";
    return $str;
}

/**
 * Editar uma tarefa da OS
 * @global type $msgTarefa
 * @param type $codTarf
 * @return string
 */
function tarfEdit($codTarf) {
    global $msgTarefa;

    $consulta = " SELECT cod AS codtarf,
                         codos,
                         # DATE_FORMAT(horaini, '%k:%i') horaini,
                         horaini,
                         # DATE_FORMAT(horafim, '%k:%i') horafim,
                         horafim,
                         descr,
                         situ
                    FROM ordem_tarf
                   WHERE tecn = '" . $_SESSION['resp'] . "'
                         AND cod=" . $codTarf;
    $dados = consultaSQL($consulta);

    if ($dados['horafim'] == '00:00:00') {
        $horaFim = "";
    } else {
        $horaFim = $dados['horafim'];
    }

    $str = "<form name=\"formTarefa\" action=\"index.php?st=ordm&pag=edit&codos=" . $dados['codos'] . "\" method=\"post\">
        <input name=\"codtarf\" type=\"hidden\" value=\"" . $dados['codtarf'] . "\">
        <input name=\"codos\" type=\"hidden\" value=\"" . $dados['codos'] . "\">
        <input name=\"tecn\" type=\"hidden\" value=\"" . $_SESSION['resp'] . "\">
        <fieldset>
            <legend>REGISTRO DE TAREFAS</legend>
            <label>Registro:</label><b>" . $dados['codtarf'] . "</b><br />
            <label>Hora inicial:</label>
            <input name=\"horaini\" value=\"" . $dados['horaini'] . "\" type=\"time\" size=\"6\" maxlength=\"5\" onclick=\"agora('horaini', this.value);\" ><br/>
            <label>Hora final:</label>
            <input name=\"horafim\" id=\"horafim\" value=\"" . $horaFim . "\" type=\"time\" size=\"6\" maxlength=\"5\" onclick=\"agora('horafim', this.value);\" ><br />
            <label>Descri&ccedil;&atilde;o:</label><br />
            <textarea name=\"descr\" cols=\"80\" rows=\"8\" autofocus=\"\">" . devolve_texto($dados['descr']) . "</textarea><br>
            <small><i style=\"color: blue;\">Sem decri&ccedil;&atilde;o para a tarefa n&atilde;o haver&aacute; resgistro.</i></small><br />
            <label>Situa&ccedil;&atilde;o</label>
            <select name=\"situ\">
                <option value=\"andamento\"" . selectedIf('andamento', $dados['situ']) . ">andamento</option>
                <option value=\"concluida\"" . selectedIf('concluida', $dados['situ']) . ">concluida</option>
                <option value=\"cancelada\"" . selectedIf('cancelada', $dados['situ']) . ">cancelada</option>
            </select><br />
            <label>&nbsp;</label>
            <input type=\"submit\" name=\"enviarTarefa\" value=\"Registrar Tarefa\"><br />"
            . $msgTarefa
            . " </fieldset>
         </form>";

    return $str;
}

/**
 * Retorna o texto da observacao da OS
 * @param type $codOS
 * @return type
 */
function ordemObs($codOS) {
    $consulta = "SELECT texto FROM ordem_obs WHERE codord =" . $codOS;
    $dados = consultaSQL($consulta);

    return $dados['texto'];
}

function OSMes($mes, $ano) {
    $consulta = " SELECT cod,
                         DATE_FORMAT(inicio, '%d') dia
                    FROM ordem
                   WHERE DATE_FORMAT(inicio, '%m/%Y') = '" . $mes . "/" . $ano . "'
                         AND situ IN('aberta', 'programada')
                ORDER BY dia";
    $resultado = retornoSQL($consulta);
    $str["01"] = "";
    $str["02"] = "";
    $str["03"] = "";
    $str["04"] = "";
    $str["05"] = "";
    $str["06"] = "";
    $str["07"] = "";
    $str["08"] = "";
    $str["09"] = "";
    $str["10"] = "";
    $str["11"] = "";
    $str["12"] = "";
    $str["13"] = "";
    $str["14"] = "";
    $str["15"] = "";
    $str["16"] = "";
    $str["17"] = "";
    $str["18"] = "";
    $str["19"] = "";
    $str["20"] = "";
    $str["21"] = "";
    $str["22"] = "";
    $str["23"] = "";
    $str["24"] = "";
    $str["25"] = "";
    $str["26"] = "";
    $str["27"] = "";
    $str["28"] = "";
    $str["29"] = "";
    $str["30"] = "";
    $str["31"] = "";

    while ($dados = mysqli_fetch_array($resultado)) {
        # pesq se tem + de 1 por dia
        $consulta = " SELECT COUNT(*) mais
                        FROM ordem
                        WHERE situ IN('aberta', 'programada')
                              AND DATE_FORMAT(inicio, '%d/%m/%Y') = '" . $dados['dia'] . "/" . $mes . "/" . $ano . "'";
        $dadosPesq = consultaSQL($consulta);
        $mais = "";
        if ($dadosPesq['mais'] > 1) {
            $num = $dadosPesq['mais'] - 1;
            $mais = "<a href=\"index.php?st=ordm&pag=listdd&dia=" . $dados['dia'] . "&mes=" . $mes . "&ano=" . $ano . "\">+" . $num . "</a>";
        }


        $str[$dados['dia']] = "<div>
                        <a href=\"index.php?st=ordm&pag=edit&codos=" . $dados['cod'] . "\">OS" . $dados['cod'] . "</a> " . $mais . "<br />
                    </div>";
    }

    return $str;
}

/**
 * Para Calendario de OS trabalhadas por dia
 * @date 15/06/2024
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * @param type $mes
 * @param type $ano
 * @return string
 */
function OSTrabMes($mes, $ano) {
    $consulta = " SELECT DISTINCT ord.cod,
                         DATE_FORMAT(trf.dataexec, '%d') dia
                    FROM  ordem ord,
                         ordem_tarf trf
                   WHERE ord.cod = trf.codos
                         AND DATE_FORMAT(trf.dataexec, '%m/%Y') = '06/2024'
                         AND trf.situ = 'concluida'
                   ORDER BY dia";
    $resultado = retornoSQL($consulta);
    $str["01"] = "";
    $str["02"] = "";
    $str["03"] = "";
    $str["04"] = "";
    $str["05"] = "";
    $str["06"] = "";
    $str["07"] = "";
    $str["08"] = "";
    $str["09"] = "";
    $str["10"] = "";
    $str["11"] = "";
    $str["12"] = "";
    $str["13"] = "";
    $str["14"] = "";
    $str["15"] = "";
    $str["16"] = "";
    $str["17"] = "";
    $str["18"] = "";
    $str["19"] = "";
    $str["20"] = "";
    $str["21"] = "";
    $str["22"] = "";
    $str["23"] = "";
    $str["24"] = "";
    $str["25"] = "";
    $str["26"] = "";
    $str["27"] = "";
    $str["28"] = "";
    $str["29"] = "";
    $str["30"] = "";
    $str["31"] = "";

    while ($dados = mysqli_fetch_array($resultado)) {
        # pesq se tem + de 1 por dia
        $consulta = " SELECT COUNT(*) mais
                        FROM ordem
                        WHERE situ IN('aberta', 'programada')
                              AND DATE_FORMAT(inicio, '%d/%m/%Y') = '" . $dados['dia'] . "/" . $mes . "/" . $ano . "'";
        $dadosPesq = consultaSQL($consulta);
        $mais = "";
        if ($dadosPesq['mais'] > 1) {
            $num = $dadosPesq['mais'] - 1;
            $mais = "<a href=\"index.php?st=ordm&pag=listdd&dia=" . $dados['dia'] . "&mes=" . $mes . "&ano=" . $ano . "\">+" . $num . "</a>";
        }


        $str[$dados['dia']] = "<div>
                        <a href=\"index.php?st=ordm&pag=edit&codos=" . $dados['cod'] . "\">OS" . $dados['cod'] . "</a> " . $mais . "<br />
                    </div>";
    }

    return $str;
}

/**
 * Cria uma nova OS
 * @param type $codEqp
 * @return type
 */
function novaOS($codEqp) {
    $consulta = "INSERT INTO ordem (cod, codcli, entd, inicio, codeqp, resp, situ)
                      VALUES (NULL, (SELECT codcli FROM equipo WHERE cod = " . $codEqp . "), CURDATE(), CURDATE(), " . $codEqp . ",'" . $_SESSION['resp'] . "', 'temporario');";
    /* mysqli_query($conexao, $consulta);
      $codOS = mysqli_insert_id($conexao);
      gravaSQL($consulta); */
    $codOS = executaIdSQL($consulta);

    return $codOS;
}

/**
 * Menu de opcoes para OSs
 */
function opcoesOS() {
    
}