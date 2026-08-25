<?php
/*
 * Aquivo de listagem para estudos
 * Pegado de ordem.php
 */
?>
<table width="100%">
    <?php
    if (isset($cabRelato)) {
        # no relatorio de OSs muda o cabecalho conforme objeto. Ver ./includes/ordem_relato.inc.php
        echo "<caption>" . $cabRelato . "</caption>";
    } else {
        ?>
        <caption>LISTAGEM DE ORDENS DE SERVI&Ccedil;O</caption>
        <?php
    }
    ?>
    <thead>
        <tr>
            <th>C&oacute;digo</th>
            <th>Descri&ccedil;&atilde;o</th>
            <th>Cliente</th>
            <th>Modelo</th>
            <th>Fila</th>
            <th>Data Entrada</th>
            <th>Data In&iacute;cio</th>
            <th>Situa&ccedil;&atilde;o</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $Conta = 0;
        while ($dados = arraySQL($resultado)) {
            ?>
            <tr class="<?php echo corLinha(); ?>">
                <th>
                    <?php echo $dados['cod']; ?>
                </th>
                <td><?php
                    echo $dados['descr'] . " - " . $dados['marca'];

                    if ($dados['situ'] == "aberta" || $dados['situ'] == "espera" || $dados['fatu'] = "aberta") {
                        ?>
                        <a href="index.php?st=ordm&pag=edit&codos=<?php echo $dados['cod']; ?>" target="blank">
                            <img src="imagens/editar.gif" border="0" alt="">
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="index.php?st=ordm&pag=detal&codos=<?php echo $dados['cod']; ?>">
                            <img src="imagens/editar.gif" border="0" alt="">
                        </a>
                        <?php
                    }
                    if ($dados['retorno']) {
                        ?>
                        <b style="color: red">RETORNO</b>
                        <?php
                    }
                    if ($dados['hashtag'] <> "") {
                        ?>
                        <i style="color: blue"><?php echo $dados['hashtag']; ?></i>
                        <?php
                    }
                    ?>
                </td>
                <td>
                    <?php
                    echo $dados['cliente'];
                    ?>
                </td>
                <td><?php echo $dados['modelo']; ?></td>
                <td>
                    <?php
                    if ($dados['fila'] == 9999) {
                        echo "&nbsp;";
                    } else {
                        echo $dados['ord'] . "&ordm;";
                    }
                    ?>
                </td>
                <td><?php echo $dados['entrada']; ?></td>
                <td>
                    <?php
                    if ($dados['inicio'] == '00/00/0000') {
                        echo "";
                    } else {
                        echo $dados['inicio'];
                    }
                    ?>
                </td>
                <td><?php echo $dados['situ']; ?></td>
            </tr>
            <?php
            $Conta++;
        }
        ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td colspan="4"><b><?php echo "Total listado= " . $Conta; ?></b></td>
        </tr>
    </tbody>
</table>

