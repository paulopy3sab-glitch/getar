<?php

/**
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: indeterminada
 * Descricao: funcoes de apoio ao estoque
 * Revisoes:
 * 18/07/2016 - pregis
 * Atualizacao para POO
 * 
 * Novembro de 2020
 * Abandonando a montagem de formularios e listagem por string e sim por .inc para
 * poder acompanhar melhor sua estrutura  HTML
 * 
 * 30/05/24
 * Aprimoramento da listagem de Consumo de componentes pelos projetos
 * Funcao: listPedHist()
 * 
 * 31/05/24
 * Funcao: listPedAbt()
 * 
 * 01/04/25
 * Atualizando a função pedidoLista()
 */

/**
 * Listagem Previa dos pedidos em processamento/transito/espera
 * @global type $conexao
 * @param type $tipo
 * @return string
 */
function pedidoLPrev($tipo = "") {

    $complemento = " 1 = 1";
    if ($tipo == "PTE") {// Processamtento - Transito - Espera - Estudo
        $complemento = " cb.situ IN ('processamento', 'transito', 'espera', 'estudo') ";
        $tipoList = "<div class=\"titulo\">Listagem Pr&eacute;via de Pedidos Processamento/Transito/Espera/Estudo.</div>";
    } elseif ($tipo == "") {
        $tipoList = "<div class=\"titulo\">Listagem Geral de Pedidos.</div>";
    } elseif ($tipo <> "") {
        $complemento = "cb.cod =" . $tipo;
        $tipoList = "<div class=\"titulo\">Listagem Geral de Pedidos.</div>";
    }
    // Listagem previa
    $consulta = "SELECT cb.cod codpedido,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                        (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                        (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                        (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                        cb.situ,
                        cb.tipo,
                        CASE
                            WHEN cb.tipo =  'compra' THEN 'compra/reposicao'
                            WHEN cb.tipo = 'venda' THEN 'venda/orcamento'
                            WHEN cb.tipo = 'consumo' THEN 'consumo'
                            ELSE 'indefinido'
                        END AS desctipo,
                        (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens
                   FROM estpedidocab cb
                   WHERE " . $complemento;
    $resultado = retornoSQL($consulta);

    $str = $tipoList . "       <table width=\"100%\">
                <tr>
                    <td class='sub-titulo'>Num. Pedido</td>
                    <td class='sub-titulo'>Fornecedor/Cliente</td>
                    <td class='sub-titulo'>Tipo</td>
                    <td class='sub-titulo'>Situ. Pedido</td>
                    <td class='sub-titulo'>Qtd. Itens</td>
                </tr>";

    while ($dados = arraySQL($resultado)) {
        $style = "";
        if ($dados["situ"] == "cancelado") {
            $style = " style=\"text-decoration:line-through;\"";
        }

        $str .= "<tr class=\"" . corLinha() . "\" " . $style . ">
                   <td class=\"txt\">" . $dados['codpedido'] . "</td>";

        if ($dados['tipo'] == "compra") {
            $str .= "<td class=\"txt\"><b>Fornecedor:</b> " . $dados['forn'];
        } else {
            $str .= "<td class=\"txt\"><b>Cliente:</b> " . $dados['cli'];
        }
        if ($dados['tipo'] == "venda") {
            $str .= "<br>" . $dados['equipo'];
        } elseif ($dados['tipo'] == "consumo") {
            $str .= "<br>" . $dados['projeto'];
        }
        $str .= "       <a href=\"index.php?st=pedido&pag=ped_edit&codped=" . $dados['codpedido'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"no\">
                        </a>
                        <a href=\"index.php?st=estoque&pag=ped_edit&codped=" . $dados['codpedido'] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"no\">
                        </a>
                        <a href=\"index.php?st=pedido&pag=ped_ldetal&codped=" . $dados['codpedido'] . "\">
                            <img src=\"imagens/livro.gif\" alt=\"\" border=\"no\">
                        </a>
                        <a href=\"impress.php?st=estoque&pag=list_ped&codped=" . $dados['codpedido'] . "\" target=\"_blank\">
                            <img src=\"imagens/impress.jpeg\" alt=\"\" border=\"no\" width=\"16\" height=\"16\">
                        </a>
                    </td>
                    <td class='txt'>" . $dados["desctipo"] . "</td>
                    <td class='txt'>" . $dados["situ"] . "</td>
                    <td class='txt'>" . $dados["qtitens"] . "</td>
                </tr>";
    }
    $str .= "</table>";

    return $str;
}

/**
 * Cria um pedido novo
 * --/--/--
 * [possicao anterior] Funcao abandonado pois no modo $str nao ha controle HTML
 * 01/05/24
 * Retomada uso para aliviar codigo fonte da estoque-cad.inc.php
 * @param type $tipo
 * @return string
 */
function pedidoNovo($tipo) {
    $str = "<div class = \"titulo\">CRIANDO UM PEDIDO NOVO</div>";
    if ($tipo == "compra") {
        $str.="<i><div id=\"divForn\"></div></i>
        <label for=\"fornNv\">Acrescente Fornecedor</label>
        <input name=\"forn\" type=\"text\" autocomplete=\"off\" size=\"42\" maxlength=\"120\" value=\"\" onkeydown=\"atualDivForn(this.value);\"><br>";
    } elseif ($tipo == "venda") {
        $str.="<label>Defina o Cliente: </label>";
        $str.= selectCliente("") . "<br />";
    } elseif ($tipo == "consumo") {
        echo "Pedido de Consumo interno<br />";
    }

    return $str;
}

/**
 * Gerencia os pedidos de componentes eletronicos
 * ver aquivo switch.inc.php
 * --/--/--
 * [possicao anterior] Funcao abandonado pois no modo $str nao ha controle HTML
 * 01/05/24
 * Em analize cheguei a conclusao que agora esta me uso no metodo pedidoAcop() na arquivo classe_estoque.php
 * @global type $msgAcop
 * @param type $codPed
 * @param type $codOS
 * @param type $codPedProj
 * @return string
 */
function pedidoAcop($codPed, $codOS, $codPedProj, $tipo = "") {
    
}

/**
 * Detalhamento de um pedido
 * @param type $codPed
 * @return string
 */
function pedidoDetal($codPed) {

    $consulta = "SELECT cad.nome forn,
                        date_format(cb.dtped, '%d/%m/%Y') dtped,
                        date_format(cb.dtcheg, '%d/%m/%Y') dtcheg,
                        date_format(cb.dtrecb, '%d/%m/%Y') dtrecb,
                        cb.rastr,
                        cb.vlfrete,
                        cb.empfrete,
                        cb.situ,
                        cb.tipo
                   FROM getar_cad cad,
                        estpedidocab cb
                  WHERE cb.codforn = cad.cod
                        AND cb.cod = " . $codPed;
    $dados = consultaSQL($consulta);

    $str = "
    <div class=\"titulo\">DETALHANDO UM PEDIDO</div>
    <table>
        <tr>
            <td class=\"txt\"><b>Fornecedor:</b> " . $dados['forn'] . "</td>
            <td class=\"txt\"><b>Pedido n&uacute;mero:</b> " . $codPed . "</td>
            <td></td>
        </tr>
        <tr>
            <td class=\"txt\"><b>Data pedido:</b> " . $dados['dtped'] . "</td>
            <td class=\"txt\"><b>Data Previsao de chegada:</b> " . $dados['dtcheg'] . "</td>
            <td class=\"txt\"><b>Data Recebimento:</b> " . $dados['dtrecb'] . "</td>
        </tr>
        <tr>
            <td class=\"txt\"><b>Rastreador:</b> " . $dados['rastr'] . "</td>
            <td class=\"txt\"><b>Valor Frete:</b> " . $dados['vlfrete'] . "</td>
            <td class=\"txt\"><b>Transportador:</b> " . $dados['empfrete'] . "</td>
        </tr>
        <tr>
            <td class=\"txt\"><b>Tipo pedido:</b> " . $dados['tipo'] . "</td>
            <td class=\"txt\"><b>Situa&ccedil;&atilde;o:</b>" . $dados['situ'] . "</td>
            <td>&nbsp;</td>
        </tr>
    </table>
</form>";

    return $str;
}

/**
 * Listagem detalhada
 * @param type $codPed
 * @return string
 */
function pedidoLDetal($codPed) {

    $complemento = "";
    if ($codPed <> "") {
        $complemento = "  AND cb.cod = " . $codPed;
    } elseif ($codPed == "") {
        $complemento = " AND cb.situ IN('processamento', 'transito') ";
    }
    $consulta = "    SELECT cb.cod codpedido,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                            estq.descr,
                            estq.cod,
                            pd.codest,
                            pd.qt,
                            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                            pd.custo,
                            cb.situ,
                            cb.tipo,
                            pd.situ situitem
                       FROM estoque estq,
                            estpedidocab cb,
                            estpedidoitem pd
                      WHERE estq.cod = pd.codest
                            AND pd.codped = cb.cod
                            " . $complemento . "
                     ORDER BY codpedido, descr";
    $resultado = retornoSQL($consulta);

    $str = "<div class=\"titulo\">Listagem Pedido Processamento/Transito.</div>
            <table width=\"100%\">
                <tr>
                    <td class='sub-titulo'>Componente</td>
                    <td class='sub-titulo'>Qt. Pedida</td>
                    <td class='sub-titulo'>Custo</td>
                    <td class='sub-titulo'>Sub. Total</td>
                </tr>";

    $pedAnt = 0;
    $totPed = 0;
    while ($dados = arraySQL($resultado)) {
        $style = "";
        if ($dados["situ"] == "cancelado") {
            $style = " style=\"text-decoration:line-through;\"";
        }

        $str .= "<tr class=\"" . corLinha() . "\" " . $style . ">";

        if ($dados['codpedido'] <> $pedAnt) {
            if ($pedAnt <> 0) {
                $str .= "   <td class='txt'>&nbsp;</td>
                            <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                            <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                            <td class='txt'>&nbsp;</td>
                        </tr>";
                $totPed = 0;
            }
            if ($dados['tipo'] == "compra") {
                $forCli = "<b>Fornecedor:</b> " . $dados['forn'];
            } else {
                if ($dados['tipo'] == "consumo") {
                    $forCli = $dados['projeto'] . "<br>";
                } else {
                    $forCli = "<b>Cliente: </b>" . $dados['cli'] . " - " . $dados['equipo'] . " ";
                }
            }
            $str .= "
                        <tr class=" . corLinha() . ">
                            <td class='sub-titulo' colspan=\"4\">
                                " . $forCli . "- pedido: " . $dados['codpedido'] . "(" . $dados["situ"] . ")";
            $str .= "<a href=\"index.php?st=estoque&pag=ped_edit&codped=" . $dados['codpedido'] . "\">
                         <img src=\"imagens/editar.gif\" alt=\"\" border=\"no\">
                     </a>";
            $str .= "</td>
                        </tr>";
            $str .= "<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">
                        ";
            $pedAnt = $dados['codpedido'];
        } else {
            $str .= "";
        }

        $str .= "<td class='txt'>" . $dados["codest"] . " - " . $dados["descr"] . "
                    <a href=\"index.php?st=estoque&pag=edit&codestq=" . $dados['codest'] . "\">
                        <img src=\"imagens/editar.gif\" alt=\"\" border=\"no\">
                    </a>
                </td>";
        $custo = $dados['custo'];
        $qt = $dados['qt'];
        $subtot = $custo * $qt;
        $str .= "
            <td class='txt' style=\"text-align: center;\">" . $qt . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($custo, 2, ',', '.') . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($subtot, 2, ',', '.') . "</td>
        </tr>";
        $totPed += $subtot;
    }
    $str .= "<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">";
    $str .= "    <td class='txt'>&nbsp;</td>
                <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                <td class='txt'>&nbsp;</td>
            </tr>
        </table>
        <hr>";

    return $str;
}

/**
 * Listagem Pedido Processamento/Transito
 * @param type $codPed Codigo do pedido a ser detalhado, se vazio lista pedidos em andamento/transito
 * @param type $tipo abt = abastecimento de estoque - pro = separa para montagem de um projeto
 * @return string
 */
function pedidoLista($codPed, $tipo = 'OS') {

    $str = "<div class=\"titulo\">Listagem Pedido Processamento/Transito.</div>
            <table width=\"100%\">
                <tr>
                    <td class='sub-titulo'>Componente</td>
                    <td class='sub-titulo'>Qt. Pedida</td>
                    <td class='sub-titulo'>Custo</td>
                    <td class='sub-titulo'>Sub. Total</td>
                </tr>";
    # $str.="<pre>". $complemento."</pre><br />";
    $consulta = "  SELECT cb.cod codpedido,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM getar_projetos pj, getar_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                            cb.situ,
                            cb.tipo
                       FROM estpedidocab cb
                      WHERE cb.cod =" . $codPed;
    $dados = consultaSQL($consulta);
    if ($dados['tipo'] == "compra") {
        $forCli = "<b>Fornecedor:</b> " . $dados['forn'];
    } else {
        if ($dados['tipo'] == "consumo") {
            $forCli = $dados['projeto'] . "<br>";
        } else {
            $forCli = "<b>Cliente: </b>" . $dados['cli'] . " - " . $dados['equipo'] . " ";
        }
    }
    $str .= "    <tr class=" . corLinha() . ">
                            <td class='sub-titulo' colspan=\"4\">";
    if ($dados['tipo'] == "consumo") {
        $str.= $dados['projeto'];
    }
    if ($dados['tipo'] == "venda") {
        $str.= $forCli;
    }
    $str.= "- pedido: " . $dados['codpedido'] . "(" . $dados["situ"] . ")";
    if ($dados["situ"] == "recebido") {
        $str .= "<a href=\"index.php?st=pedido&pag=ped_detal&codped=" . $dados['codpedido'] . "\"><img src=\"imagens/editar.gif\" alt=\"\" border=\"no\"></a>";
    } else {
        $str .= "<a href=\"index.php?st=pedido&pag=ped_edit&codped=" . $dados['codpedido'] . "\"><img src=\"imagens/editar.gif\" alt=\"\" border=\"no\"></a>";
    }
    $str .= "</td>
                        </tr>";

    $complemento = "";
    if ($codPed <> "") {
        $complemento = "  AND cb.cod = " . $codPed;
    } elseif ($codPed == "") {
        $complemento = " AND cb.situ IN('processamento', 'transito') ";
    }
    $consulta = "    SELECT cb.cod codpedido,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM getar_projetos pj, getar_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                            estq.descr,
                            estq.cod,
                            estq.nossonum,
                            pd.codest,
                            pd.qt,
                            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                            pd.custo,
                            cb.situ,
                            cb.tipo,
                            pd.situ situitem
                       FROM estoque estq,
                            estpedidocab cb,
                            estpedidoitem pd
                      WHERE estq.cod = pd.codest
                            AND pd.codped = cb.cod
                            # AND cb.tpcons = 'projeto'
                            # AND cb.nmproj = 653
                            " . $complemento . "
                     ORDER BY codpedido, descr";
    $resultado = retornoSQL($consulta);

    if (rowsSQL($resultado) == 0) {
        $str .= "</table>
                 <hr>";

        return $str;
    }

    $pedAnt = 0;
    $totPed = 0;
    $style = "";
    while ($dados = arraySQL($resultado)) {
        $style = "";
        if ($dados["situ"] == "cancelado") {
            $style = " style=\"text-decoration:line-through;\"";
        }

        $str .= "<tr class=\"" . corLinha() . "\" " . $style . ">";

        if ($dados['codpedido'] <> $pedAnt && $pedAnt <> 0) {
            if ($pedAnt <> 0) {
                $str .= "   <td class='txt'>&nbsp;</td>
                            <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                            <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                            <td class='txt'>&nbsp;</td>
                        </tr>";
                $totPed = 0;
            }

            if ($dados['tipo'] == "compra") {
                $forCli = "<b>Fornecedor:</b> " . $dados['forn'];
            } else {
                if ($dados['tipo'] == "consumo") {
                    $forCli = $dados['projeto'] . "<br>";
                } else {
                    $forCli = "<b>Cliente: </b>" . $dados['cli'] . " - " . $dados['equipo'] . " ";
                }
            }
            $str .= "    <tr class=" . corLinha() . ">
                            <td class='sub-titulo' colspan=\"4\">";
            if ($dados['tipo'] == "consumo") {
                $str.= $dados['projeto'];
            }
            if ($dados['tipo'] == "venda") {
                $str.= $forCli;
            }
            $str.= "- pedido: " . $dados['codpedido'] . "(" . $dados["situ"] . ")";
            if ($dados["situ"] == "recebido") {
                $str .= "<a href=\"index.php?st=pedido&pag=ped_detal&codped=" . $dados['codpedido'] . "\"><img src=\"imagens/editar.gif\" alt=\"\" border=\"no\"></a>";
            } else {
                $str .= "<a href=\"index.php?st=pedido&pag=ped_edit&codped=" . $dados['codpedido'] . "\"><img src=\"imagens/editar.gif\" alt=\"\" border=\"no\"></a>";
            }
            $str .= "</td>
                        </tr>";
            $str .= "<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">
                        ";
            $pedAnt = $dados['codpedido'];
        } else {
            $str .= "";
        }

        $str .= "<td class='txt'>";
        if ($dados["nossonum"] != "") {
            $str .= $dados["nossonum"];
        } else {
            $str .= "GT" . $dados["cod"];
        }
        $str .= "    <a href=\"index.php?st=estoque&pag=edit&codestq=" . $dados["codest"] . "\">
                    <img src=\"imagens/editar.gif\" alt=\"\" border=\"no\">
                </a> - " . $dados["descr"];
        if ($dados['situitem'] == "esg") {
            $str .= " - <b style=\"color: red;\">ESGOTADO</b>";
        }
        $custo = $dados['custo'];
        $qt = $dados['qt'];
        $subtot = $custo * $qt;
        $str .= "</td>
            <td class='txt' style=\"text-align: center;\">" . $qt . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($custo, 2, ',', '.') . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($subtot, 2, ',', '.') . "</td>
        </tr>";
        $totPed += $subtot;
    }
    $str .= "<tr " . $style . " class=" . corLinha() . " onmouseover=\"this.className = 'corLinhaAtiva'\" onmouseout=\"this.className = '" . corLinha(0) . "'\">";
    $str .= "    <td class='txt'>&nbsp;</td>
                <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                <td class='txt'>&nbsp;</td>
            </tr>
        </table>
<hr>";

    return $str;
}

/**
 * Consulta para listagem padrao consulta e HTML
 * Somento para Projetos Eletronico e OSs
 * @param type $codPed
 * @param type $tipo
 * @return type
 */
function pedidoListaNovo($codPed, $tipo = 'OS') {

    $consulta = "    SELECT cb.cod codpedido,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM getar_projetos pj, getar_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                            estq.descr,
                            estq.cod,
                            estq.nossonum,
                            pd.codest,
                            pd.qt,
                            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                            pd.custo,
                            cb.situ,
                            cb.tipo,
                            pd.situ situitem
                       FROM estoque estq,
                            estpedidocab cb,
                            estpedidoitem pd
                      WHERE estq.cod = pd.codest
                            AND pd.codped = cb.cod
                            AND cb.tpcons = 'projeto'
                            AND cb.nmproj = " . $codPed . "
                     ORDER BY codpedido, descr";
    $resultado = retornoSQL($consulta);

    return $resultado;
}

/**
 * Listagem para impressao
 * @param type $codPed
 * @return string
 */
function pedidoListaImpress($codPed) {

    $complemento = "";
    if ($codPed <> "") {
        $complemento = "  AND cb.cod = " . $codPed;
    } elseif ($codPed == "") {
        $complemento = " AND cb.situ IN('processamento', 'transito') ";
    }
    $consulta = "    SELECT cb.cod codpedido,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codforn) forn,
                            (SELECT nome FROM getar_cad WHERE cod = cb.codcli) cli,
                            (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                            (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                            estq.descr,
                            estq.cod,
                            pd.codest,
                            estq.und,
                            pd.qt qtd,
                            FORMAT(pd.qt, 0) strQtd,
                            (SELECT COUNT(*) FROM estpedidoitem it WHERE it.codped = cb.cod) qtitens,
                            pd.custo,
                            cb.situ,
                            cb.tipo,
                            pd.situ situitem
                       FROM estoque estq,
                            estpedidocab cb,
                            estpedidoitem pd
                      WHERE estq.cod = pd.codest
                            AND pd.codped = cb.cod
                            " . $complemento . "
                     ORDER BY codpedido, descr";
    $resultado = retornoSQL($consulta);

    $str = "<div class=\"titulo\">Listagem Pedido Processamento/Transito.</div>
            <table width=\"100%\" border=\"1\">
                <tr>
                    <td class='sub-titulo'>Componente</td>
                    <td class='sub-titulo'>Qt. Pedida</td>
                    <td class='sub-titulo'>Custo</td>
                    <td class='sub-titulo'>Sub. Total</td>
                </tr>";

    $pedAnt = 0;
    $totPed = 0;
    while ($dados = arraySQL($resultado)) {
        $style = "";
        if ($dados["situ"] == "cancelado") {
            $style = " style=\"text-decoration:line-through;\"";
        }

        $str .= "<tr " . $style . ">";

        if ($dados['codpedido'] <> $pedAnt) {
            if ($pedAnt <> 0) {
                $str .= "    <td class='txt'>&nbsp;</td>
                            <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                            <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                            <td class='txt'>&nbsp;</td>
                        </tr>";
                $totPed = 0;
            }
            if ($dados['tipo'] == "compra") {
                $forCli = "<b>Fornecedor:</b> " . $dados['forn'];
            } else {
                if ($dados['tipo'] == "consumo") {
                    $forCli = $dados['projeto'] . " ";
                } else {
                    $forCli = "<b>Cliente: </b>" . $dados['cli'] . " - " . $dados['equipo'] . " ";
                }
            }
            $str .= "
                        <tr class=" . corLinha() . ">
                            <td class='sub-titulo' colspan=\"4\">
                                " . $forCli . "- pedido: " . $dados['codpedido'] . "(" . $dados["situ"] . ")
                            </td>
                        </tr>";
            $str .= "<tr>";
            $pedAnt = $dados['codpedido'];
        } else {
            $str .= "";
        }

        $str .= "<td class='txt'>" . $dados["codest"] . " - " . $dados["descr"];
        if ($dados['situitem'] == "esg") {
            $str .= " - <b style=\"color: red;\">ESGOTADO</b>";
        }
        $qtd = $dados['qtd'];
        $custo = $dados['custo'];
        if ($dados['und'] == "pc") {
            $strQtd = $dados['strQtd'];
        } else {
            $strQtd = $qtd;
        }
        $subtot = $custo * $qtd;
        $str .= "</td>
            <td class='txt' style=\"text-align: center;\">" . $strQtd . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($custo, 2, ',', '.') . "</td>
            <td class='txt' style=\"text-align: right;\">R$ " . number_format($subtot, 2, ',', '.') . "</td>
        </tr>";
        $totPed += $subtot;
    }
    $str .= "<tr>
                <td class='txt'>&nbsp;</td>
                <td class='txt' style=\"text-align: right;\"><b>Total pedido = </b></td>
                <td class='txt' style=\"text-align: right;\"><b>R$ " . number_format($totPed, 2, ',', '.') . "</b></td>
                <td class='txt'>&nbsp;</td>
            </tr>
        </table>";

    return $str;
}

/**
 * Listagem de produtos abaixo do estoque minimo
 * @return string
 */
function pedidoCompra($codPed) {
    #movida para classe_estoque
}


/**
 * Rodape para estoquistas criarem novos pedidos
 * @return string
 */
function pedidoRodapeEstoquista() {
    $str = "<div id=\"opcoes\">
        <div id=\"elemento\">
            <a href=\"index.php?st=pedido&pag=ped_novo&tipo=compra&pagina=\">
                <img src=\"imagens/editar.gif\" alt=\"\" style=\"width: 32px;\" title=\"Criar novo pedido de Compra\"><br>
                Novo pedido
            </a>
        </div>
        <div id=\"elemento\">
            <a href=\"index.php?st=pedido&pag=list_ped\">
                <img src=\"imagens/livro.gif\" alt=\"\" style=\"width: 32px;\" title=\"listar pedidos ativos\"><br>
                Listar Ativos
            </a>
        </div>
        <div id=\"elemento\">
            <a href=\"index.php?st=pedido&pag=list_compra\">
                <img src=\"imagens/livro.gif\" alt=\"\" style=\"width: 32px;\" title=\"Listar Todos Pedidos\"><br>
                Listar p/ Pedidos
            </a>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php?st=pedido&pag=pesq_pedCd\" method=\"post\">
                <input type=\"hidden\" name=\"pag\" value=\"pesq\">
                <input type=\"hidden\" name=\"pagina\" value=\"\">
                <img src=\"imagens/pesquisa1.gif\" alt=\"\"><br />
                Por Cod. Pedido<br>
                <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"20\">
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php?st=pedido&pag=list_compra\" method=\"post\">
                <img src=\"imagens/livro.gif\" alt=\"\"><br />
                Pedido Compra<br>";

    $str.= selectFornPedA();

    $str.="<input name=\"Listar\" type=\"submit\" value=\"OK\">
                </form>
            </div>
        </div>";

    return $str;
}

/**
 * Select com fornecedores com Pedidos Ativos
 * 01/06/24
 * Funcao criada
 * @return string
 */
function selectFornPedA() {
    $consulta = "  SELECT DISTINCT cb.cod cod,
                        (SELECT SUBSTRING(nome, 1, 12) nome
                         FROM getar_cad
                         WHERE cod= cb.codforn) forn,
                         cb.situ
                    FROM estpedidocab cb,
                         estpedidoitem it
                   WHERE cb.cod = it.codped
                         AND cb.tipo = 'compra'
                         AND cb.situ IN('processamento', 'transito', 'espera', 'estudo');";
    $resultado = retornoSQL($consulta);

    $str = "      <select name=\"codped\">
                     <option value=\"000\">Sem Fornecedor</option>";
    while ($dados = arraySQL($resultado)) {
        $str.= "      <option value=\"" . $dados['cod'] . "\">" . $dados['cod'] . "-" . $dados['situ'] . "-" . $dados['forn'] . "</option>";
    }
    $str.= "      </select><br />";

    return $str;
}

/**
 * Rodape para estoque
 * --/--/--
 * [possicao anterior] Funcao abandonado pois no modo $str nao ha controle HTML
 * 01/05/24
 * Retomada uso para aliviar codigo fonte da estoque-cad.inc.php
 * @return string
 */
function estoqueRodape() {
    $str = "<div id=\"opcoes\">
    <div id=\"elemento\">
        <form action=\"index.php?st=estoque&pag=pesq\" method=\"post\">
            <input type=\"hidden\" name=\"pag\" value=\"pesq\">
            <input type=\"hidden\" name=\"pagina\" value=\"\">
            <img src=\"imagens/pesquisa1.gif\" alt=\"\">Por Descri&ccedil;&atilde;o<br>
            <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"20\" accesskey=\"p\">
            <i><small>Atalho:[Shift] [Alt] [P]</small></i>
            <input name=\"Listar\" type=\"submit\" value=\"OK\">
        </form>
    </div>
    <div id=\"elemento\">
        <form action=\"index.php\" method=\"get\">
            <input type=\"hidden\" name=\"st\" value=\"estoque\">
            <input type=\"hidden\" name=\"pag\" value=\"edit\">
            <img src=\"imagens/pesquisa1.gif\" alt=\"\">Por C&oacute;digo<br>
            <input name=\"codestq\" type=\"text\" size=\"12\" maxlength=\"10\" accesskey=\"c\">
            <i><small>Atalho:[Shift] [Alt] [C]</small></i>
            <input name=\"Listar\" type=\"submit\" value=\"OK\">
        </form>
    </div>";

    if (atrib("21")) {
        $str.="<div id=\"elemento\">
                <a href=\"index.php?st=estoque&pag=cad\" accesskey=\"n\">
                    <img src=\"imagens/editar.gif\" alt=\"Produto Novo\" style=\"widht: 32px;\" title=\"Cria Produto Novo\"><br>
                    Produto Novo
                </a>
            </div>";
    }

    $str.="<div id=\"elemento\">
                <a href=\"index.php?st=estoque&pag=list_u&pagina=\">
                    <img src=\"imagens/grupo.gif\" alt=\"Listar ultimos Registros\" style=\"widht: 32px;\" title=\"Listar Ultimos Registros\"><br>
                    Listar &Uacute;ltimos
                </a>
            </div>
            <div id=\"elemento\">
                <a href=\"index.php?st=pedido&pag=list_ped\">
                    <img src=\"imagens/grupo.gif\" alt=\"\" style=\"widht: 32px;\" border=\"no\"><br>
                    Listar Pedidos
                </a>
            </div>
        </div>";

    return $str;
}

/**
 * Select com os fornecedores
 * @param type $codForn
 * @return string
 */
function selectForn($codForn = "") {
    $str = "<select name=\"forn\">    
                        <option value=\"0\">Acrescente Fornecedor</option>";
    $consulta = "SELECT cod,
                            nome
                       FROM getar_cad
                      WHERE clasf = 'r'
                            AND situacao = 'ativo'
                   ORDER BY nome";
    $resultado = retornoSQL($consulta);
    while ($dadosSelect = arraySQL($resultado)) {
        $str .= "<option value=\"" . $dadosSelect['cod'] . "\" >" . $dadosSelect['nome'] . "</option>";
    }

    $str .= "</select>";

    return $str;
}

/**
 * Select com os fabricantes
 * @param type $codFabr
 * @return string
 */
function selectFabr($codFabr = "") {
    $str = "<select name=\"fabr\">    
                        <option value=\"0\">Selecione</option>";
    $consulta = "SELECT cod, nome FROM getar_cad WHERE clasf = 'b' AND situacao = 'ativo' ORDER BY nome";
    $resultado = retornoSQL($consulta);
    while ($dados = arraySQL($resultado)) {
        if ($dados['cod'] == $codFabr) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        $str .= "<option value=\"" . $dados['cod'] . "\" " . $selected . " >" . $dados['nome'] . "</option>";
    }

    $str .= "</select>";

    return $str;
}

/**
 * Select das categoria
 * @param type $codCateg
 * @return string
 */
function selectCateg($codCateg) {
    $consulta = "SELECT cod, descr FROM estcatg WHERE situacao = 'ativo' ORDER BY descr";
    $resultado = retornoSQL($consulta);
    $str = "<select name=\"categ\">    
                        <option value=\"0\">Selecione</option>";
    while ($dados = arraySQL($resultado)) {
        if ($dados['cod'] == $codCateg) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        $str .= "<option value=\"" . $dados['cod'] . "\" " . $selected . " >" . $dados['descr'] . "</option>";
    }

    $str .= "</select>";

    return $str;
}

/**
 * Select com as qadras
 * @param type $codQuadra
 * @return string
 */
function selectQuadra($codQuadra) {
    $consulta = "SELECT cod, etq FROM estquadra WHERE situacao = 'ativo' ORDER BY etq";
    $resultado = retornoSQL($consulta);
    $str = "<select name=\"quadra\">    
                        <option value=\"0\">Selecione</option>";
    while ($dados = arraySQL($resultado)) {
        if ($dados['cod'] == $codQuadra) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        $str .= "<option value=\"" . $dados['cod'] . "\" " . $selected . " >" . $dados['etq'] . "</option>";
    }

    $str .= "</select>";

    return $str;
}

/**
 * Rodape para pedidos
 * @return string
 */
function pedidoRodape() {
    $str = "<div id=\"opcoes\">
        <div id=\"elemento\">
            <a href=\"index.php?st=estoque&pag=ped_novo&tipo=compra&pagina=\">
                <img src=\"imagens/editar.gif\" alt=\"\" style=\"width: 32px;\" title=\"Criar novo pedido de Compra\"><br>
                Novo pedido
            </a>
        </div>
        <div id=\"elemento\">
            <a href=\"index.php?st=estoque&pag=list_ped\">
                <img src=\"imagens/livro.gif\" alt=\"\" style=\"width: 32px;\" title=\"listar pedidos ativos\"><br>
                Listar Ativos
            </a>
        </div>
        <div id=\"elemento\">
            <a href=\"index.php?st=estoque&pag=list_compra\">
                <img src=\"imagens/livro.gif\" alt=\"\" style=\"width: 32px;\" title=\"Listar Todos Pedidos\"><br>
                Listar p/ Pedidos
            </a>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php?st=estoque&pag=pesq_pedCd\" method=\"post\">
                <input type=\"hidden\" name=\"pag\" value=\"pesq\">
                <input type=\"hidden\" name=\"pagina\" value=\"\">
                <img src=\"imagens/pesquisa1.gif\" alt=\"\"><br />
                Por Cod. Pedido<br>
                <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"20\">
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php?st=estoque&pag=list_compra\" method=\"post\">
                <img src=\"imagens/livro.gif\" alt=\"\"><br />
                Pedido Compra<br>";

    $consulta = "  SELECT DISTINCT cb.cod cod,
                        (SELECT SUBSTRING(nome, 1, 12) nome
                         FROM getar_cad
                         WHERE cod= cb.codforn) forn,
                         cb.situ
                    FROM estpedidocab cb,
                         estpedidoitem it
                   WHERE cb.cod = it.codped
                         AND cb.tipo = 'compra'
                         AND cb.situ IN('processamento', 'transito', 'espera', 'estudo');";
    $resultado = retornoSQL($consulta);

    $str.="      <select name=\"codped\">
                     <option value=\"000\">Sem Fornecedor</option>";
    while ($dados = arraySQL($resultado)) {
        $str.="      <option value=\"" . $dados['cod'] . "\">" . $dados['cod'] . "-" . $dados['situ'] . "-" . $dados['forn'] . "</option>";
    }
    $str.="      </select><br />
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>
        </div>";

    return $str;
}

/**
 * Rodape para as categorias e sub categorias
 * @return string
 */
function categRodape() {
    $str = "<div id=\"opcoes\">
        <div id=\"elemento\">
            <a href=\"index.php?st=categ&pag=novacatg\" accesskey=\"n\">
                <img src=\"imagens/editar.gif\" alt=\"Categoria Nova\" style=\"width: 32px;\" title=\"Cria Nova Categoria\"><br>
                Categoria Nova
            </a>
        </div>
        <div id=\"elemento\">
            <a href=\"index.php?st=categ&pag=list\">
                <img src=\"imagens/grupo.gif\" alt=\"Listar Categorias\" style=\"width: 32px;\" title=\"Listar Categorias Ativas\"><br>
                Listar Categorias
            </a>
        </div>
        <div id=\"elemento\">
            <a href=\"index.php?st=estoque&pag=list&pagina=\">
                <img src=\"imagens/grupo.gif\" alt=\"Listar Produtos\" style=\"width: 32px;\" title=\"Listar Produtos Ativos\"><br>
                Listar Produtos
            </a>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php?st=estoque&pag=pesq\" method=\"post\">
                <input type=\"hidden\" name=\"pag\" value=\"pesq\">
                <input type=\"hidden\" name=\"pagina\" value=\"\">
                <img src=\"imagens/pesquisa1.gif\" alt=\"\">Pesquisa<br>
                <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"10\" accesskey=\"p\">
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>
    </div>";

    return $str;
}

/**
 * Rodape para local de estocagem
 * @return string
 */
function localRodape() {
    $str = "<div id=\"opcoes\">
        <div id=\"elemento\">
            <a href=\"index.php?st=local&pag=novo\" accesskey=\"n\">
                <img src=\"imagens/editar.gif\" alt=\"Local Novo\" style=\"width: 32px;\" title=\"Cria Novo Local\"><br>
                Local Novo
            </a>
        </div>
        <div id=\"elemento\">
            <a href=\"index.php?st=local&pag=list\">
                <img src=\"imagens/grupo.gif\" alt=\"Listar Locais\" style=\"width: 32px;\" title=\"Listar Locais Ativas\"><br>
                Listar Locais
            </a>
        </div>
        <div id=\"elemento\">
            <a href=\"index.php?st=estoque&pag=list&pagina=\">
                <img src=\"imagens/grupo.gif\" alt=\"Listar Produtos\" style=\"width: 32px;\" title=\"Listar Produtos Ativos\"><br>
                Listar Produtos
            </a>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php?st=estoque&pag=pesq\" method=\"post\">
                <input type=\"hidden\" name=\"pag\" value=\"pesq\">
                <input type=\"hidden\" name=\"pagina\" value=\"\">
                <img src=\"imagens/pesquisa1.gif\" alt=\"\">Pesquisa<br>
                <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"10\" accesskey=\"p\">
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>
    </div>";

    return $str;
}

/**
 * Cria nova e edita uma existente
 * @global type $msg
 * @param type $codLocal
 * @return string
 */
function localEdit($codLocal) {
    global $msg, $numest;

    //  Cadastro local provissorio
    if ($codLocal == "") {
        $consulta = "INSERT INTO estlocal (etq, descr, numest, situacao)
                          VALUES ('xxx', 'temporario', " . $numest . ",'ativo')";
        $codLocal = executaIdSQL($consulta);
    }
    $consulta = "    SELECT lc.etq,
                            lc.descr,
                            lc.quadra,
                            lc.categ,
                            qd.etq etqquadra,
                            ru.etq etqrua,
                            lc.situacao
                       FROM estlocal lc,
                            estquadra qd,
                            estrua ru
                       WHERE lc.numest = " . $numest . "
                            AND qd.cod = lc.quadra
                            AND ru.cod = qd.codrua
                            AND lc.cod=" . $codLocal;
    $dados = consultaSQL($consulta);

    $str = "<form action='index.php?st=local&pag=edit&cod=" . $codLocal . "' method='post'>
            <input name=\"codlocal\" type=\"hidden\" value=\"" . $codLocal . "\">
            <fieldset>
                <legend>Edi&ccedil;&atilde;o de Local de Estocagem</legend>
                <label>C&oacute;digo:</label><b> " . $codLocal . "</b><br />
                <label>Etiqueta:</label>
                <input name='etq' type='text' size='22' maxlength='20' value=\"" . $dados['etq'] . "\"><br />
                <label>Descri&ccedil;&atilde;o:</label>
                <textarea name='descr' cols=\"40\" rows=\"3\">" . $dados['descr'] . "</textarea><br />
                <label>Quadra:</label>";
    $str.= selectQuadra($dados['quadra']) . "<br />";
    $str.= "     <label>Rua:</label>
                 <b>" . $dados['etqrua'] . "</b><br />
                 <label>Categoria:</label>";
    $str.= selectCateg($dados['categ']) . "<br />";
    $str.="      <label>Situa&ccedil;&atilde;o:</label>
                <select name=\"situacao\">
                    <option value=\"ativo\"" . selectedIf("ativo", $dados['situacao']) . ">ativo</option>
                    <option value=\"inativo\"" . selectedIf("inativo", $dados['situacao']) . ">inativo</option>
                </select><br />
                <label>&nbsp;</label>
                " . $msg . "<input type=\"submit\" name=\"salvar\" value=\"Salvar\">
            </fieldset>
        </form>";

    return $str;
}

/**
 * Cria nova e edita uma existente
 * @global type $msg
 * @global type $msgSubIna
 * @param type $codCatg
 * @return string
 */
function categEdit($codCatg) {
    global $msg, $msgSubIna;

    //  Cadastra provissoria
    if ($codCatg == "") {
        $consulta = "INSERT INTO estcatg (descr, situacao)
                          VALUES ('temporario', 'ativo')";
        $codCatg = executaIdSQL($consulta);
        // inserir uma subcategoria para efeitos de listagem
        $consulta = "INSERT INTO estsubcatg (codcatg, descr, situacao)
                          VALUES (" . $codCatg . ", 'geral', 'ativo')";
        executaIdSQL($consulta);
    }
    $consulta = "SELECT descr, situacao FROM estcatg WHERE cod=" . $codCatg;
    $dados = consultaSQL($consulta);

    $str = "<form action='index.php?st=categ&pag=editcatg&codcatg=" . $codCatg . "' method='post'>
    <span class=\"titulo\">Edi&ccedil;&atilde;o de Categoria</span><br>";

    $str.="
    <input name=\"codCatg\" type=\"hidden\" value=\"" . $codCatg . "\">
    <table border=\"0\">
        <tr>
            <td class=\"txt\"><b>C&oacute;digo:</b> " . $codCatg . "
                <b>Categoria:</b> <input name='descr' type='text' size='22' maxlength='20' value=\"" . $dados['descr'] . "\">
            </td>
            <td align=\"center\">
                <select name=\"situacao\">
                    <option value=\"ativo\"" . selectedIf("ativo", $dados['situacao']) . ">ativo</option>
                    <option value=\"inativo\"" . selectedIf("inativo", $dados['situacao']) . ">inativo</option>
                </select>
            </td>
            <td>
                " . $msg . "<input type=\"submit\" name=\"salvarCatg\" value=\"Salvar\">
            </td>
        </tr>
    </table>
    " . $msgSubIna . "
    <br><i style=\"color: blue;\">Desativando uma categoria ira desativar todos suas subcategorias.</i>
    <br><i style=\"color: blue;\">Havendo necessidade de excluir esta categoria entre em contato com administrador.</i>
</form>";

    return $str;
}

/**
 * 
 * @global type $msg
 * @global type $msgSubIna
 * @param type $codSubCatg
 * @param type $codCatg
 * @return string
 */
function subCategEdit($codSubCatg, $codCatg) {
    global $msg, $msgSubIna;

    //  Cadastra provissoria
    if ($codSubCatg == "") {
        $consulta = "INSERT INTO estsubcatg (codcatg, descr, situacao)
                          VALUES (" . $codCatg . ", 'temporario', 'ativo')";

        $codSubCatg = executaIdSQL($consulta);
    }

    $consulta = "SELECT ct.descr,
                        sb.descr sbdescr,
                        sb.situacao
                   FROM estsubcatg sb,
                        estcatg ct
                  WHERE sb.codcatg = ct.cod
                        AND sb.cod=" . $codSubCatg;
    $dados = consultaSQL($consulta);

    $str = "<form action='index.php?st=categ&pag=editsub&codcatg=" . $codCatg . "' method='post'>
    <span class=\"titulo\">Edi&ccedil;&atilde;o de Subcategoria</span><br>";
    $str.="
    <input name=\"codSubCatg\" type=\"hidden\" value=\"" . $codSubCatg . "\">
    <table border=\"0\">
        <tr>
            <td class=\"sub-titulo\" colspan=\"3\">
                <b>Categoria:</b> " . $dados['descr'] . "
            </td>
        </tr>
        <tr>
            <td class=\"txt\"><b>C&oacute;digo subcategoria:</b> " . $codSubCatg . "
                <b>Subcategoria:</b> <input name='descr' type='text' size='22' maxlength='20' value=\"" . $dados['sbdescr'] . "\">
            </td>
            <td align=\"center\">
                <select name=\"situacao\">
                    <option value=\"ativo\"" . selectedIf("ativo", $dados['situacao']) . ">ativo</option>
                    <option value=\"inativo\"" . selectedIf("inativo", $dados['situacao']) . ">inativo</option>
                </select>
            </td>
            <td>
                " . $msg . "<input type=\"submit\" name=\"salvarSubCatg\" value=\"Salvar\">
            </td>
        </tr>
    </table>
    <br><i style=\"color: blue;\">Havendo necessidade de excluir esta categoria entre em contato com administrador.</i>
</form>";

    return $str;
}

/**
 * select com os box disponivel para uma categoria
 * @global type $descrLocal
 * @param type $box
 * @param type $codCatg
 * @return string
 */
function selectBoxxx($box, $codCatg = 1) {
    global $descrLocal, $numest;

    // para ver se a categoria tem local
    $consulta = "SELECT cod
                   FROM estlocal
                  WHERE situacao = 'ativo'
                        AND categ=" . $codCatg;
    $resultado = retornoSQL($consulta);
    $rows = rowsSQL($resultado);
    $complemento = " ";
    $msg = "";
    if ($rows < 1) {
        $msg = "<b>CATEGORIA SEM NENHUM BOX DEFINIDO</b>";
    } else {
        $complemento = " AND categ = " . $codCatg;
    }

    $consulta = "    SELECT cod,
                            etq,
                            SUBSTRING(descr, 1, 20) descr,
                            descr descrcomp
                       FROM estlocal
                       WHERE numest = " . $numest . "
                             AND situacao = 'ativo' 
                       " . $complemento . "
                   ORDER BY etq ASC";
    $resultado = retornoSQL($consulta);

    $str = "<select name=\"local\" onchange=\"atualDivLocal(this.value)\">
                <option value=\"1\">Selecione</option>";
    while ($dadosSelect = mysqli_fetch_assoc($resultado)) {
        if ($box == $dadosSelect['cod']) {
            $selected = "selected";
            $descrLocal = $dadosSelect['descrcomp'];
        } else {
            $selected = "";
        }
        $str.= "<option value=\"" . $dadosSelect['cod'] . "\" " . $selected . ">" . $dadosSelect['etq'] . "-" . $dadosSelect['descr'] . "</option>";
    }

    $str.= "    </select>" . $msg;
    return $str;
}

/**
 * Listagem dos locais cadastrados
 * @param type $complemento
 * @return string
 */
function localList($complemento) {
    $consulta = "SELECT loc.cod,
                        loc.etq,
                        (SELECT COUNT(*) FROM estoque WHERE `local` = loc.cod) numitm,
                        loc.descr,
                        loc.situacao
                   FROM estlocal loc
                   WHERE loc.situacao = 'ativo'
                    " . $complemento . "
                  ORDER BY loc.etq";
    $resultado = retornoSQL($consulta);

    $str = "<table>
            <caption>ESTOQUE - Locais de Estocagem.</caption>
            <thead>
                <tr>
                    <th>Cod</th>
                    <th>Etiqueta</th>
                    <th>Descri&ccedil;&atilde;o</th>
                    <th>Situa&ccedil;&atilde;o</th>
                </tr>
            </thead>
            <tbody>";
    while ($dados = arraySQL($resultado)) {
        $str.="<tr class=" . corLinha() . ">
                   <th>" . $dados['cod'] . "(" . $dados['numitm'] . ")</th>
                   <td>
                        " . $dados['etq'] . "
                        <a href=\"index.php?st=local&pag=edit&cod=" . $dados['cod'] . "\">
                            <img src=\"imagens/editar.gif\" border=\"0\">
                        </a>
                   </td>
                   <td>" . $dados['descr'] . "</td>
                   <td>" . $dados['situacao'] . "</td>
               </tr>";
    }

    $str.="</tbody>
          </table>";

    return $str;
}

/**
 * Listagem de pedidos compra Reposicao ou Venda/Consumo para o produto em foco
 * Autor: Paulo Regis
 * Data: 30/05/2024 - criacao
 * @param type $cod
 * @return type
 */
function listPedHist($cod) {
    $consulta = " SELECT cb.cod codped,# ver linha 1578 de consultas_estoque.sql
                         cad.nome,
                        (SELECT descr FROM estoque WHERE cod=it.codest) descr,
                        (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo)
                           FROM eletro_projetos pj,
                                eletro_pedidos pd
                          WHERE pj.cod = pd.codproj
                                AND pd.cod = cb.nmproj) projetoEletro,# cb.ospro
                        (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo)
                           FROM getar_projetos pj, getar_pedidos pd
                          WHERE pj.cod = pd.codproj
                                AND pd.cod = cb.nmproj) projeto, # cb.ospro
                        (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                           FROM ordem od, equipo eq
                           WHERE od.cod = cb.ospro
                                 AND od.codeqp = eq.cod) equipo,
                        (SELECT CONCAT('Quantidade: ', qt, ' - Custo: ', custo)
                           FROM estpedidoitem
                          WHERE codped = cb.cod
                                AND codest = it.codest LIMIT 1) qtcst,
                        (SELECT codest
                           FROM estpedidoitem
                          WHERE codped = cb.cod
                                AND codest = it.codest LIMIT 1) codest,
                        (SELECT COUNT(*)
                           FROM estpedidoitem 
                          WHERE codped = cb.cod
                                AND codest = it.codest) AS numitem,
                        cb.situ,
                        cb.tipo
                  FROM estpedidocab cb,
                       estpedidoitem it,
                       getar_cad cad
                 WHERE cb.cod = it.codped
                       AND cad.cod = cb.codcli
                       AND cb.tipo IN ('venda', 'consumo')
                       AND it.codest =" . $cod . "
              ORDER BY codped DESC
                 LIMIT 20";
    $resultado = retornoSQL($consulta);
    $rows = rowsSQL($resultado);

    $str = "";
    $descr = "";
    if (!$rows) {
        return $str;
    }

    while ($dados = arraySQL($resultado)) {
        if ($descr == "") {
            $descr = $dados['descr'];
            $str = "<fieldset><legend>PEDIDOS DE VENDA/CONSUMO DE: " . $descr . "</legend>";
        }
        $str.= "<b>Pedido de " . $dados['tipo'] . " n&uacute;mero:</b> " . $dados['codped'] . " ";
        if ($dados['situ'] == "processamento") {
            $str.= "<b style=\"color: red;\">(Em processamento)</b>
                  <a href=\"index.php?st=estoque&pag=ped_edit&codped=" . $dados['codped'] . "\">
                      <img src=\"imagens/visto.gif\" alt=\"\" border=\"no\">
                  </a><br>";
        }
        if ($dados['tipo'] == "venda") {
            $str.= $dados['equipo'] . "<br>";
            $str.= "<b>Cliente: </b>" . $dados['nome'] . "<br>";
        } else {
            if ($dados['projetoEletro']) {
                $str.= "<b>" . $dados['projetoEletro'] . "</b><br>";
                $str.= "<b style=\"color: red;\">(TABELAS OBSOLETAS)</b>";
            } else {
                $str.= "<b>" . $dados['projeto'] . "</b><br>";
            }
            if ($dados['numitem'] > 1) {
                $str.= "<b style=\"color: red;\">Este item esta cadastrado " . $dados['numitem'] . " vezes neste pedido</b><br>";
            }
        }
        $str.= $dados['qtcst'];
        if ($dados['situ'] == "processamento") {

            $str.= "<a href=\"index.php?st=estoque&pag=edit&codestq=" . $cod . "&inped=" . $dados['codped'] . "\">
                        <img src=\"imagens/visto.gif\" alt=\"\" border=\"no\">
                    </a>";

            $str.= "<a href=\"index.php?st=estoque&pag=excitem&codestq=" . $cod . "&codped=" . $dados['codped'] . "\">
                        <img src=\"imagens/lixo.gif\" alt=\"\" border=\"0\">
                    </a>";
        }
        $str.= "<br><br>";
    }
    $str.= "</fieldset>";
    return $str;
}

/**
 * Para criar futura funcao ou metodo
 * Listagem de pedidos Compra Reposicao em ABERTO
 * Autor: Paulo Regis
 * Data:
 * 31/05/2024 - Criacao da funcao
 * @param type $cod
 * @return string
 */
function listPedAbt($cod) {
    $consulta = "SELECT forn.codforn,
                    cad.nome,
                    ped.nomeped,
                    ped.cod codped,
                    ped.situ
               FROM fornecedor forn,
                    getar_cad cad,
                    estoque est,
                    estpedidocab ped
               WHERE forn.codestq = est.cod
                     AND forn.codforn = cad.cod
                     AND forn.codforn = ped.codforn
                     AND ped.situ IN('processamento', 'estudo', 'transito', 'estudo', 'orcamento')
                     AND est.qtd < est.qtdmin
                     AND est.cod NOT IN(SELECT itm.codest
                                          FROM estpedidocab cab,
                                               estpedidoitem itm
                                         WHERE cab.cod = itm.codped
                                               AND cab.situ = 'espera'# era IN('processamento', 'espeta')
                                               AND cab.tipo= 'compra'
                                               AND itm.codest = est.cod)
                     AND est.cod =" . $cod;
    $resultado = retornoSQL($consulta);

    $str = "";
    while ($dados = arraySQL($resultado)) {
        $nomePed = "";
        if ($dados['nomeped'] <> "") {
            $nomePed = $dados['nomeped'] . " - ";
        }

        $str.=" <fieldset>
                <legend>INSERIR EM PEDIDO DE COMPRA/REPOSI&Ccedil;&Atilde;O N&Uacute;MERO: " . $dados['codped'] . " (" . $nomePed . $dados['situ'] . ")" . "</legend>
                <b>Fornecedor: </b>" . $dados['nome'] . "  
                <a href=\"index.php?st=estoque&pag=edit&codestq=" . $cod . "&inped=" . $dados['codped'] . "\">
                    <img src=\"imagens/visto.gif\" alt=\"\" border=\"no\">
                </a>
            </fieldset>";
    }
    return $str;
}

/**
 * Listagem de produtos no estoque
 * @date: 03/06/2024
 * criacao baseado no arquivo estoque-lista.inc.php
 * @global type $blcPag
 * @global type $comExtra
 * @param type $complemento
 * @param type $numest
 * @return string
 */
function estoqueListaxxx($complemento, $numest) {
    global $blcPag, $comExtra;

    $consulta = estq_consLista01($complemento, $numest);

    $pagina = 1;

    if (!$blcPag) {
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        }
        $resultado = gerapaginacao($consulta, $pagina, "");
    } else {
        $resultado = retornoSQL($consulta);
    }
    $outroEstoque = TRUE;

    $msgList = "Listagem Geral.";
    $str = "<table width=\"100%\">
    <caption>ESTOQUE -" . $msgList . "</caption>
    <thead>
        <tr>
            <th>C&oacute;digo</th>
            <th>Descri&ccedil;&atilde;o</th>
            <th>Quantidade</th>
            <th>Local</th>
            <th>Categoria</th>
            <th>Clasifica&ccedil;&atilde;o</th>
        </tr>
    </thead>
    <tbody>";

    while ($dados = arraySQL($resultado)) {
        $outroEstoque = FALSE;
        $style = "";
        if ($dados["situacao"] == "inativo") {
            $style = " style=\"text-decoration:line-through;\"";
        }
        $str.="<tr class=" . corLinha() . "\" " . $style . ">
                <th>";

        if ($dados["nossonum"] != "") {
            $str.= $dados["nossonum"];
        } else {
            $str.= "GT" . $dados["cod"];
        }

        $str.="</th>
                <td>";

        $str.= $dados["descr"];
        if ($dados["fabr"] != "") {
            $str.= "(" . $dados["fabr"] . ")";
        } else {
            $str.= "";
        }
        if ($dados["descrtec"] != "") {
            $str.= " - " . $dados["descrtec"];
        }
        if (atrib("21")) {

            $str.="     <a href=\"index.php?st=estoque&pag=edit&codestq=" . $dados["cod"] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"no\">
                        </a>";
        } else {

            $str.="    <a href=\"index.php?st=estoque&pag=detal&codestq=" . $dados["cod"] . "\">
                            <img src=\"imagens/editar.gif\" alt=\"\" border=\"no\">
                        </a>";
        }

        $str.="</td>
                <td>&nbsp;" . $dados["qtd"] . $dados["und"] . "</td>
                <td>&nbsp;" . $dados["etqlocal"] . "</td>
                <td>&nbsp;" . $dados["descrcatg"] . $dados["descrsubcatg"] . "</td>
                <td>&nbsp;" . $dados["clasf"] . "</td>
            </tr>";
    }
    $str.="</tbody>
    <tr>
        <td colspan=\"5\">";
    $str.= geraindicespaginas($pagina, "index.php?st=estoque" . $comExtra . "&");
    $str.="    </td>
    </tr>
</table>";
    return $str;
}

/**
 * Listagem de pedidos Ativso (andamento, pago e orcamento
 * @param type $cod
 * @param type $codPed
 * @return string
 */
function listPedAtvxxx($cod) {
    $consulta = "SELECT it.custo custo,
                            cb.situ situ,
                            cb.nomeped nomeped,
                            cb.cod cod,
                            (SELECT nome FROM getar_cad cad WHERE cad.cod = cb.codforn) forn,
                            cb.cod codped
                        FROM estpedidocab cb,
                             estpedidoitem it
                       WHERE cb.cod = it.codped
                             AND cb.tipo = 'compra'
                             AND it.codest = " . $cod . "
                             AND cb.situ IN('processamento', 'espera', 'transito', 'estudo', 'pago')
                       ORDER BY cb.cod DESC";
    $retorno = retornoSQL($consulta);
    $str = "";
    while ($dados = arraySQL($retorno)) {
        $str .= "<small class=\"txt\">Pedido PED" . $dados['cod'] . "(" . $dados['forn'] . ")| Valor de Custo= " . $dados['custo'];
        $situ = $dados['situ'];
        if ($situ == "estudo") {
            $situ = "Or&ccedil;amento";
        }
        $str .= "| em situa&ccedil;&atilde;o: (" . $situ;
        if ($dados['nomeped'] <> "") {
            $str .= " - " . $dados['nomeped'];
        }
        $str.=")</small>
                    <a href=\"index.php?st=pedido&pag=ped_ldetal&codped=" . $dados['codped'] . "\">
                        <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                    </a>
                    <a href=\"index.php?st=estoque&pag=edit&codestq=" . $cod . "&codped=" . $dados['codped'] . "&acao=excitem\">
                        <img src=\"imagens/lixo.gif\" alt=\"\" border=\"0\">
                    </a><br />";
    }
    return $str;
}

/**
 * Listagem de pedidos de venda e consumo abertos
 * @param type $cod
 * @return type
 */
function inserPedido($cod) {
    $consulta = "    SELECT codped,
                            nome,
                            projeto,
                            equipo,
                            tipo                    
                       FROM (SELECT cb.cod codped,
                                    cad.nome,
                                    (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo)
                                       FROM getar_projetos pj,
                                            getar_pedidos pd
                                      WHERE pj.cod = pd.codproj
                                            AND pd.cod = cb.nmproj) projeto,
                                    (SELECT CONCAT('<b>OS Numero: </b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                                       FROM ordem od,
                                            equipo eq
                                      WHERE od.cod = cb.ospro
                                            AND od.codeqp = eq.cod) equipo,
                                    (SELECT COUNT(*) FROM estpedidoitem WHERE codped = cb.cod AND codest = " . $cod . ") AS numitem,
                                    cb.situ,
                                    cb.tipo
                               FROM estpedidocab cb,
                                    getar_cad cad
                              WHERE cad.cod = cb.codcli
                                    AND cb.tipo IN ('venda', 'consumo')
                                    AND cb.situ = 'processamento') as cb
                      WHERE numitem = 0";
    $retorno = retornoSQL($consulta);
    $str = "";
    while ($dados = arraySQL($retorno)) {
        if ($dados['tipo'] == "consumo") {
            $tipo = "CONSUMO INTERNO";
            $strAux = $dados['projeto'];
        } else {
            $tipo = "VENDA/OR&Ccedil;AMENTO";
            $strAux = "<b>Cliente: </b>" . $dados['nome'] . "<br>";
            $strAux.= $dados['equipo'];
        }
        $str.="<fieldset>
                    <legend>INSERIR EM PEDIDO DE " . $tipo . " N&Uacute;MERO: " . $dados['codped'] . "</legend>
                    " . $strAux . "
                    <a href=\"index.php?st=estoque&pag=edit&codestq=" . $cod . "&inped=" . $dados['codped'] . "\">
                        <img src=\"imagens/visto.gif\" alt=\"\" border=\"no\">
                    </a>
                </fieldset>";
    }

    return $str;
}