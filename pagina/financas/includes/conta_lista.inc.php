<?php
/*
 * Para listagem das Contas Corrente
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * @date 11/04/2025
 */
?>
<table>
    <caption>Listagem Contas Corrente - Geral.</caption>
    <thead>
        <tr>
            <th>Cod.</th>
            <th>Conta</th>
            <th>Periodo</th>
            <th>Moeda</th>
            <th>Situacao</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($dados = arraySQL($resultado)) {

            $style = "";
            if ($dados["situacao"] == "cancelada") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>
            <tr class="<?php echo $fnc->corLinha(); ?>" <?php echo $style; ?>>
                <th>
                    <?php echo $dados['cod']; ?>
                </th>
                <td class="txt" valign="top">
                    <?php echo $dados['nome']; ?>
                    <a href="index.php?st=financascc&ft=fnc&pag=editcor&codctco=<?php echo $dados['cod']; ?>">
                        <img src="imagens/editar.gif" alt="" border="0">
                    </a>
                </td>
                <td>
                    <?php
                    if ($dados['nmper'] == 1) {
                        echo $dados['peratu'];
                    } elseif ($dados['nmper'] == 0 && $dados['situacao'] == 'ativo') {
                        echo "<b style=\"color: blue;\">Sem Per&iacute;odo Ativo</b>";
                        ?>
                        <a href="index.php?st=financascc&ft=fnc&pag=editper&codctco=<?php echo $dados['cod']; ?>&cod=">
                            <img src="imagens/editar.gif" alt="" border="0">
                        </a>
                        <?php
                    }
                    if ($dados['nmper'] > 1) {
                        echo "<b style=\"color: red;\">Erro! Mais de um Periodo Ativo.</b>";
                    }
                    ?>
                </td>
                <td class="txt" valign="top">
                    <?php echo $dados['moeda']; ?>
                </td>
                <td class="txt" valign="top"><?php echo $dados['situacao']; ?></td>
            </tr>

            <?php
        }
        ?>
    </tbody>
</table>