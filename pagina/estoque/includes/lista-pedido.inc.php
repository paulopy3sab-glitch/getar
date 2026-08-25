<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: 18/10/2024
 * Descricao: Para listagem de pedido de consumo para pedidos de projetos eletronicos
 * Vindo da funcao: pedidoLista(), funcoes_estoque.php
 * Revisoes:
 */


// $resultado = pedidoListaNovo($codPed);
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
                            AND cb.situ NOT IN ('cancelado')
                            # AND cb.tpcons = 'projeto'
                            # AND cb.nmproj = " . $codPed . "
                            AND cb.cod = " . $codPedCons. "
                     ORDER BY codpedido, descr";
$resultado = retornoSQL($consulta);
?>
<div class="titulo">Listagem Pedido Processamento/Transito. (Novo)</div>
<table width="100%">
    <tr>
        <td class="sub-titulo">Componente</td>
        <td class="sub-titulo">Qt. Pedida</td>
        <td class="sub-titulo">Custo</td>
        <td class="sub-titulo">Sub. Total</td>
    </tr>
    <?php
    $totPed = 0;
    while ($dados = arraySQL($resultado)) {
        if ($dados['tipo'] == "consumo") {
            $forCli = $dados['projeto'] . "<br>";
        } else {
            $forCli = "<b>Cliente: </b>" . $dados['cli'] . " - " . $dados['equipo'] . " ";
        }
        if ($dados['tipo'] == "consumo") {
            $tipoPed = $dados['projeto'];
        }
        if ($dados['tipo'] == "venda") {# Para as OSs eh venda
            $tipoPed = $forCli;
        }
        if ($dados["nossonum"] != "") {
            $codEstq = $dados["nossonum"];
        } else {
            $codEstq = "GT" . $dados["cod"];
        }
        ?>
        <tr class="<?php echo corLinha(); ?> ">
            <td class='sub-titulo' colspan="4">
                <?php echo $tipoPed; ?>- pedido: <?php echo $dados['codpedido'] . "(" . $dados["situ"] . ")"; ?>

                <a href="index.php?st=pedido&pag=ped_edit&codped=<?php echo $dados['codpedido']; ?>"><img src="imagens/editar.gif" alt="" border="no"></a>

            </td>
        </tr>
        <tr class="<?php echo corLinha(); ?> . " onmouseover="this.className = 'corLinhaAtiva';" onmouseout="this.className = '<?php echo corLinha(0); ?>;">
            <td class='txt'>
                <?php echo $codEstq; ?>

                <a href="index.php?st=estoque&pag=edit&codestq=<?php echo $dados["codest"]; ?>">
                    <img src="imagens/editar.gif" alt="" border="no">
                </a> - <?php echo $dados["descr"]; ?>
                <?php
                $custo = $dados['custo'];
                $qt = $dados['qt'];
                $subtot = $custo * $qt;
                ?>
            </td>
            <td class="txt" style="text-align: center;"><?php echo $qt; ?></td>
            <td class="txt" style="text-align: right;">R$<?php echo number_format($custo, 2, ',', '.'); ?></td>
            <td class="txt" style="text-align: right;">R$ <?php echo number_format($subtot, 2, ',', '.'); ?></td>
        </tr>
        <?php
        $totPed += $subtot;
    }
    ?>
    <tr class="<?php echo corLinha(); ?>" onmouseover="this.className = 'corLinhaAtiva';" onmouseout="this.className = '<?php echo corLinha(0); ?>';">
        <td class="txt">&nbsp;</td>
        <td class="txt" style="text-align: right;"><b>Total pedido = </b></td>
        <td class="txt" style="text-align: right;"><b>R$ <?php echo number_format($totPed, 2, ',', '.'); ?></b></td>
        <td class="txt">&nbsp;</td>
    </tr>
</table>
<hr>


