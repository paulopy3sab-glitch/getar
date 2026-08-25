<?php
//  Para detalhamento
$consulta = "SELECT estq.cod,
                    estq.descr,
                    estq.datasheet,
                    (SELECT nome FROM getar_cad WHERE cod = estq.fabr) nmfabr,
                    estq.und,
                    CASE
                        WHEN estq.und IN('pc', 'und') THEN ROUND(estq.qtd, 0)
                        WHEN estq.und IN('m', 'ml', 'Kg') THEN ROUND(estq.qtd, 3)
                    END qtd,
                    CASE
                        WHEN estq.und IN('pc', 'und') THEN ROUND(estq.qtdmin, 0)
                        WHEN estq.und IN('m', 'ml', 'Kg') THEN ROUND(estq.qtdmin, 3)
                    END qtdmin,
                    estq.valorvenda,
                    estq.peso,
                    estq.foto,
                    (SELECT etq FROM estlocal WHERE cod = estq.local) local,
                    (SELECT descr FROM estlocal WHERE cod = estq.local) descrlocal,
                    estq.situacao,
                    CASE
                        WHEN estq.clasf = 'colec' THEN 'Colecionavel'
                        WHEN estq.clasf = 'novo' THEN 'Novo'
                        WHEN estq.clasf = 'usado' THEN 'Usado'
                    END nmclasf,
                    (SELECT descr FROM estcatg WHERE cod = estq.catg) descrcatg,
                    (SELECT descr FROM estsubcatg WHERE cod = estq.subcatg) descrsubcatg,
                    (SELECT cb.cod
                       FROM estpedidocab cb,
                            estpedidoitem it
                      WHERE cb.cod = it.codped
                            AND cb.tipo = 'compra'
                            AND it.codest = estq.cod
                      ORDER BY cb.cod DESC
                      LIMIT 1) AS codpedido,
                    (SELECT cb.situ stpedido
                       FROM estpedidocab cb,
                            estpedidoitem it
                      WHERE cb.cod = it.codped
                            AND cb.tipo = 'compra'
                            AND it.codest = estq.cod
                      ORDER BY cb.cod DESC
                      LIMIT 1) AS stpedido
               FROM estoque estq
              WHERE estq.cod = " . $codestq;
$resultado = mysqli_query($conexao, $consulta);
$dados = mysqli_fetch_assoc($resultado);

if ($dados['cod'] <> $codestq) {
    echo "<b style=\"color: red\">Nenhum registro para o codigo " . $codestq . "</b>";
} else {
    ?>
    <div>
        <fieldset>
            <legend>Dados do Produto ou Componente</legend>
            <label>C&oacute;digo GETAR: </label><b><?php echo $codestq ?></b><br>
            <label>Descri&ccedil;&atilde;o: </label>
            <b><?php echo $dados['descr']; ?></b><br>
            <label for="foto">Foto Ilustrativa: </label>
            <?php
            if ($dados['foto'] <> "") {
                $img = $dados['foto'];
                echo '<a href="' . $pastaDocs . 'imagens/' . $dados['foto'] . '" title="' . $dados['descr'] . '" rel="shadowbox[galeria];">
                      <img width="90" border="0" src="' . $pastaDocs . 'imagens/' . $dados['foto'] . '" >
                  </a>';
            }
            ?><br>
            <label>Categoria: </label>
            <b><?php echo $dados['descrcatg']; ?></b><br>
            <label>Sub-categoria:</label>
            <b><?php echo $dados['descrsubcatg']; ?></b><br>
            <label>Datasheet: </label>
            <?php
            if ($dados['datasheet'] <> "") {
                ?>
                <a href="<?php echo $pastaDocs . "DataSheet/" . $dados['datasheet']; ?>" target="blank">
                    <img src="imagens/arquivo_pdf.png" width="83" height="90" alt="arquivo_pdf" title="<?php echo $dados['datasheet']; ?>"/>
                </a>
                <?php
            }
            ?><br>
            <label>Fabricante: </label>
            <b><?php echo $dados['nmfabr']; ?></b><br>
            <label>Quantidade: </label>
            <b><?php echo $dados['qtd']; ?></b><br>
            <label>Undidade:</label>
            <b><?php echo $dados['und']; ?></b><br>
            <label>Classifica&ccedil;&atilde;o: </label>
            <b><?php echo $dados['nmclasf']; ?></b><br>
            <label>Quantidade m&iacute;mina: </label>
            <b><?php echo $dados['qtdmin']; ?></b><br>
            <?php
            if ($dados['codpedido'] <> "") {
                echo "<i>Pedido n&uacute;mero " . $dados['codpedido'] . " " . $dados['stpedido'] . "</i><br>";
            } else {
                echo "&nbsp;";
            }
            ?>
            <label>Local:</label>
            <b><?php echo $dados['local']; ?></b><br>
            <i><?php echo $dados['descrlocal']; ?></i><br>
            <label>Valor venda: </label>
            <b><?php echo $dados['valorvenda']; ?></b><br>
            <label>Peso:</label>
            <b><?php echo $dados['peso']; ?></b><br>
            <?php
            $consulta = "SELECT cod, texto FROM estobs WHERE codestq =" . $dados['cod'];
            $resultado = mysqli_query($conexao, $consulta);
            $dadosPesq = mysqli_fetch_assoc($resultado);
            ?>
            <label>Observa&ccedil;&atilde;o: </label>
            <textarea name="texto" cols="40" rows="5" readonly=""><?php echo $dadosPesq['texto']; ?></textarea>
            <?php
            if ($msgObs <> "") {
                echo $msgObs;
            }
            ?>
        </fieldset>
    </div>

    <?php
    $consulta = "SELECT cb.cod codped,
                        cb.codcli,
                        cad.nome,
                        (SELECT CONCAT('<b>Projeto Eletronico:</b> ', pj.nome, ' - ',pd.titulo) FROM eletro_projetos pj, eletro_pedidos pd WHERE pj.cod = pd.codproj AND pd.cod = cb.ospro) projeto,
                        (SELECT CONCAT('<b>OS Numero:</b> ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo) FROM ordem od, equipo eq WHERE od.cod = cb.ospro AND od.codeqp = eq.cod) equipo,
                        (SELECT CONCAT('Quantidade: ', qt, ' - Custo: ', custo) FROM estpedidoitem WHERE codped = cb.cod AND codest = " . $dados['cod'] . " LIMIT 1) qtcst,
                        (SELECT codest FROM estpedidoitem WHERE codped = cb.cod AND codest = " . $dados['cod'] . " LIMIT 1) codest,
                        (SELECT COUNT(*) FROM estpedidoitem WHERE codped = cb.cod AND codest = " . $dados['cod'] . ") AS numitem,
                        cb.situ,
                        cb.tipo
                   FROM estpedidocab cb,
                        getar_cad cad
                  WHERE cad.cod = cb.codcli
                        AND cb.resp = '" . $_SESSION['resp'] . "'
                        AND cb.tipo IN ('venda', 'consumo')";
    $retPesq = mysqli_query($consulta) or print mysqli_error();
    $str = "<fieldset>";
    $str2 = "";
    while ($dadosPesq = mysqli_fetch_assoc($retPesq)) {
        if ($dadosPesq['codest'] == $dados['cod']) {
            echo $str;
            echo "<legend>Pedido de " . $dadosPesq['tipo'] . " n&uacute;mero:</b> " . $dadosPesq['codped'] . "</legend>";
            if ($dadosPesq['tipo'] == "venda") {
                echo $dadosPesq['equipo'] . "<br>";
                echo "<b>Cliente:</b>" . $dadosPesq['nome'] . "<br>";
            } else {
                echo $dadosPesq['projeto'] . "<br>";
                if ($dadosPesq['numitem'] > 1) {
                    echo "<b style=\"color: red;\">Este item esta cadastrado " . $dadosPesq['numitem'] . " vezes neste pedido</b><br>";
                }
            }
            echo $dadosPesq['qtcst'] . "<br>";
            $str = "";
            $str2 = "</fieldset>";
        }
    }
    echo $str2;
    ?>
    <table style="width: 100%;">
        <tr>        
            <td>
                <div id="divRetira">
                    &nbsp;
                    <?php
                    $sep = "<fieldset>
                        <legend>Retiradas Avulsas realizadas:</legend>";
                    $consulta = "SELECT cod, DATE_FORMAT(dia, '%d/%m/%Y %h:%i') datahora, usuario, qtd, und, motivo FROM estretira WHERE codestq =" . $dados['cod'];
                    $resultado = mysqli_query($conexao, $consulta);
                    while ($dadosSelect = mysqli_fetch_assoc($resultado)) {
                        echo $sep;
                        echo $dadosSelect['datahora'] . " - " . $dadosSelect['usuario'] . " (" . $dadosSelect['qtd'] . " " . $dadosSelect['und'] . "): " . $dadosSelect['motivo'];
                        $sep = "";
                    }
                    if ($sep == "") {
                        echo "<br><i style=\"color: blue\">Havendo necessidade de editar/excluir retiradas entre em contato com o administrador. </i>
                    </fieldset>";
                    }
                    ?>
                </div>
            </td>
        </tr>
    </table>    
    <?php
}
?>