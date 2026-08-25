<?php
/*
 * Para listagem dos carnes de parcelamento a receber e a pagar
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 29/07/2024
 */
?>
<table>
    <caption>Listagem Faturas Geral.</caption>
    <thead>
        <tr>
            <th>Conta</th>
            <th>Fatura</th>
            <th>Credor/Pagador</th>
            <th>Data</th>
            <th>Receber</th>
            <th>Pagar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $saldoCred = 0;
        $saldoDeb = 0;
        while ($dados = arraySQL($resultado)) {
            $valorCredito = null;
            $valorDebito = null;
            if ($dados['tipo'] == "receber") {
                $valorCredito = $dados['valorpar'];
                $saldoCred+= $valorCredito;
            } else {
                $valorDebito = $dados['valorpar'];
                $saldoDeb+= $valorDebito;
            }
            $style = "";
            if ($dados["situacao"] == "cancelada") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>
            <tr class="<?php echo $fnc->corLinha(); ?>" <?php echo $style; ?>>
                <th <?php echo $style; ?> valign="top">
                    Conta No.: <?php echo $dados['codcarne']; ?>
                    <a href="index.php?st=financaspr&ft=fnc&pag=edit&codcarne=<?php echo $dados['codcarne']; ?>">
                        <img src="imagens/editar.gif" alt="" border="0">
                    </a>
                </th>
                <td class="txt" valign="top">
                    Fatura No.: <?php echo $dados['parnum']; ?> (<?php echo $dados['situacao']; ?>)
                    <?php
                    if ($dados['situacao'] == "paga") {
                        ?>
                        <a href="index.php?st=financaspr&ft=fnc&pag=detalpar&codpar=<?php echo $dados['codpar']; ?>">
                            <img src="imagens/livro.gif" alt="" border="0">
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="index.php?st=financaspr&ft=fnc&pag=editpar&codpar=<?php echo $dados['codpar']; ?>">
                            <img src="imagens/editar.gif" alt="" border="0">
                        </a>
                        <?php
                    }
                    ?>
                    <!--<a href="pagina/financas/recibo.php?codpar=<?php echo $dados['codpar']; ?>" target="_blank">
                        <img src="imagens/impress.jpeg" alt="" border="0">
                    </a>-->
                </td>
                <td class="txt" valign="top"><?php echo $dados['nome']; ?></td>
                <td class="txt" valign="top"><?php echo $dados['datavnc']; ?></td>
                <td class="txt" valign="top">&nbsp;<b style="color: blue"><?php echo $valorCredito; ?></b></td>
                <td class="txt" valign="top">&nbsp;<b style="color: red"><?php echo $valorDebito; ?></b></td>
            </tr>

            <?php
        }
        ?>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="txt"><b>Totais:</b>&nbsp;</td>
            <td class="txt"><b style="color: blue"><?php echo formatarValorPadrao($saldoCred, TRUE); ?></b></td>
            <td class="txt"><b style="color: red"><?php echo formatarValorPadrao($saldoDeb, TRUE); ?></b></td>
        </tr>
    </tbody>
</table>