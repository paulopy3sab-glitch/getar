<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: 28/11/2020
 * Descricao: Para criar e acompanhar os pedidos, compra, de consumo e venda
 * Revisoes:
 * 28/11/2020 - pregis
 *     formatacoes iniciais
 * 01/05/24
 * Retomada das funcoes com $str para aliviar codigo fonte
 * 19/02/2025
 * Poder editar um item de um pedido
 */

# Salvar editar item
if (isset($_POST["salvarItem"])) {
    $codItem = $_POST['coditem'];
    $qt = $_POST['qt'];
    $custo = formatarValorMySQL($_POST['custo']);
    $consulta = "UPDATE estpedidoitem SET qt= " . $qt . ", custo = " . $custo . " WHERE coditem= " . $codItem;
    $msgAcop = executaSQL($consulta);
}

if (isset($_GET['codped'])){
    $codPed = $_GET['codped'];
}  else {
    $codPed = 0;
}

$complemento = "1 = 1 ";
$tipoList = "<div class=\"titulo\">Listagem Geral de Pedidos.</div>";
$listPed = FALSE;
switch ($pag) {
    case 'slvped':
        $codforn = $_GET['codforn'];
        $consulta = "UPDATE estpedidocab SET codforn= " . $codforn . " WHERE cod= " . $codPed;
        $msgAcop = executaSQL($consulta);

        if (isset($_GET['codos'])) {
            $codOS = $_GET['codos'];
        } else {
            $codOS = "";
        }
        if (isset($_GET['codpedproj'])) {
            $codPedProj = $_GET['codpedproj'];
        } else {
            $codPedProj = "";
        }
        include './pagina/estoque/includes/pedido-cad.inc.php';
        $complemento.= " AND cb.cod = " . $codPed;
        break;

    case 'ped_novo':
        $codOS = "";
        $codPedProj = "";
        $codPed = "";
        $tipo = $_GET['tipo'];
        include './pagina/estoque/includes/pedido-cad.inc.php';
        $complemento.= " AND cb.cod = " . $codPed;
        break;
    case 'ped_edit':
        if (isset($_GET['codos'])) {
            $codOS = $_GET['codos'];
        } else {
            $codOS = "";
        }
        if (isset($_GET['codpedproj'])) {
            $codPedProj = $_GET['codpedproj'];
        } else {
            $codPedProj = "";
        }
        include './pagina/estoque/includes/pedido-cad.inc.php';
        $complemento.= " AND cb.cod = " . $codPed;
        break;
    case 'ped_detal':
        echo pedidoDetal($codPed);
        break;
    case 'item_edit':
        $codEstq = $_GET['codestq'];
        include './pagina/estoque/includes/pedido-item.inc.php';
        $complemento.= " AND cb.cod = " . $codPed;
        break;
    case 'list_ped':
        $complemento = " cb.situ IN ('processamento', 'transito', 'espera', 'estudo', 'orcamento', 'pago') ";
        $tipoList = "<div class=\"titulo\">Listagem Pr&eacute;via de Pedidos Processamento/Transito/Espera/Or&ccedil;mento.</div>";
        break;
    case 'pesq_pedCd':
        $codPed = $_POST['string'];
        $complemento = "cb.cod =" . $codPed;
        break;
    case 'pesq_forn':
        $strFron = $_POST['string'];
        $complemento = "cb.codforn = (SELECT cod FROM getar_cad WHERE nome LIKE ('" . $strFron . "%') LIMIT 1)";
        break;

    case 'list_pedTd':
        $complemento = " 1 = 1";
        if ($tipo == "PTE") {// Processamtento - Transito - Espera - Estudo
            $complemento = " cb.situ IN ('processamento', 'transito', 'espera', 'estudo', 'orcamento') ";
            $tipoList = "<div class=\"titulo\">Listagem Pr&eacute;via de Pedidos Processamento/Transito/Espera/Or&ccedil;mento.</div>";
        }
        break;
    case 'ped_ldetal':
        $listPed = TRUE;
        $complemento = "cb.cod =" . $codPed;
        break;
    case 'list_compra':
        $resultado= $est->pedidoCompra();
        include './pagina/estoque/includes/lista_compra.inc.php';
        $complemento = "cb.cod =" . $codPed;
        break;
    case 'list_compraLiticos':
        $resultado = $est->pedidoCompraCapEletro();
        include './pagina/estoque/includes/lista_compra.inc.php';
        $complemento = "cb.cod =" . $codPed;
        break;
}

# detalhamento de um pedido
if ($listPed) {
    $consulta = $est->pedidoDetalhar($codPed);
    $resultado = retornoSQL($consulta);
    ?>
    <div id="lista de itens">
        <div class="titulo">Listagem Detalhada Pedido Processamento/Transito.</div>
        <table width="100%" id="Lista detalhada">
            <tr>
                <td class='sub-titulo'>Componente</td>
                <td class='sub-titulo'>Qt. Pedida</td>
                <td class='sub-titulo'>Custo</td>
                <td class='sub-titulo'>Sub. Total</td>
            </tr>
            <?php
            $pedAnt = 0;
            $totPed = 0;
            $style = "";
            while ($dados = arraySQL($resultado)) {
                if ($dados["situ"] == "cancelado") {
                    $style = " style=\"text-decoration:line-through;\"";
                }
                ?>
                <tr class="<?php echo corLinha(); ?>" <?php echo $style; ?>>
                    <?php
                    if ($dados['codpedido'] <> $pedAnt) {
                        if ($pedAnt <> 0) {
                            ?>
                            <td class='txt'>&nbsp;</td>
                            <td class="txt" style="text-align: right;"><b>Total pedido = </b></td>
                            <td class="txt" style="text-align: right;"><b>R$ <?php number_format($totPed, 2, ',', '.'); ?></b></td>
                            <td class="txt">&nbsp;</td>
                        </tr>
                        <?php
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
                    ?>
                    <tr class="<?php echo corLinha(); ?> ">
                        <td class="sub-titulo" colspan="4">
                            <?php echo $forCli; ?>- pedido: <?php echo $dados['codpedido']; ?>(<?php echo $dados["situ"]; ?>)
                            <a href="index.php?st=pedido&pag=ped_edit&codped=<?php echo $dados['codpedido']; ?>">
                                <img src="imagens/editar.gif" alt="" border="no">
                            </a>
                        </td>
                    </tr>
                    <tr <?php echo $style; ?> class="<?php echo corLinha(); ?>" onmouseover="this.className = 'corLinhaAtiva';" onmouseout="this.className = '<?php corLinha(0); ?>';">
                        <?php
                        $pedAnt = $dados['codpedido'];
                    }
                    ?>
                    <td class="txt">
                        <?php
                        $strItem = "";
                        if ($dados['situitem'] == "esg") {
                            $strItem = "<b style=\"color: red;\">(" . $dados['situitem'] . ")</b)";
                        }
                        echo $dados["codest"] . " - " . $dados["descr"] . $strItem;
                        ?>
                        <a href="index.php?st=estoque&pag=edit&codestq=<?php echo $dados['codest']; ?>" target="blank">
                            <img src="imagens/editar.gif" alt="" border="no">
                        </a>
                        <a href="index.php?st=pedido&pag=item_edit&codestq=<?php echo $dados['codest']; ?>&codped=<?php echo $dados['codpedido']; ?>">
                            <img src="imagens/livro.gif" alt="" border="no">
                        </a>
                    </td>
                    <?php
                    $custo = $dados['custo'];
                    $qt = $dados['qt'];
                    $subtot = $custo * $qt;
                    ?>

                    <td class="txt" style="text-align: center;"><?php echo $qt; ?></td>
                    <td class="txt" style="text-align: right;">R$ <?php echo number_format($custo, 2, ',', '.'); ?></td>
                    <td class="txt" style="text-align: right;">R$ <?php echo number_format($subtot, 2, ',', '.'); ?></td>
                </tr>
                <?php
                $totPed += $subtot;
            }
            ?>
            <tr <?php echo $style; ?> class="<?php echo corLinha(); ?>" onmouseover="this.className = 'corLinhaAtiva';" onmouseout="this.className = '<?php corLinha(0); ?>';">
                <td class="txt">&nbsp;</td>
                <td class="txt" style="text-align: right;"><b>Total pedido = </b></td>
                <td class="txt" style="text-align: right;"><b>R$ <?php echo number_format($totPed, 2, ',', '.'); ?></b></td>
                <td class='txt'>&nbsp;</td>
            </tr>
        </table>
    </div>
    <hr>
    <?php
}

include './pagina/estoque/includes/lista-pedido_atv.inc.php';

# listagem pedido ativos
/*if ($codPed == "000") {
    
} else {
    include './pagina/estoque/includes/lista-pedido_atv.inc.php';
}*/

//so disponibilizar para o estoquista
if (atrib("21")) {
    #echo pedidoRodapeEstoquista();
    include './pagina/estoque/includes/opcoes_pedido.inc.php';
}
?>
