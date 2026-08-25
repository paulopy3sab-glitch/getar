<?php
/*
 * Para editar os carnes de parcelamento a receber e a pagar
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 04/10/2025
 * Descricao: listar faturas programadas e atrazadas
 */
?>
<table width="100%">
    <caption>Parcelas Vencidas</caption>
    <thead>
        <tr>
            <th>C&oacute;digo</th>
            <th>Credor/Pagador</th>
            <th>Data</th>
            <th>Cr&eacute;dito/D&eacute;bito</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($dados = arraySQL($resultado)) {
            ?>
            <tr class="<?php echo corLinha(); ?>">
                <th><?php echo $dados['codpar']; ?></th>
                <td>
                    <?php
                    echo $dados['descr'];
                    if ($dados['situacao'] == "atrasada") {
                        ?>
                        <b style="color: red">[ATRASADA]</b>
                        <?php
                    }
                    ?>
                    <a href="index.php?st=financaspr&ft=fnc&pag=pagar&codpar=<?php echo $dados['codpar']; ?>">
                        <img src="imagens/editar.gif" border="0" alt="">
                    </a>
                </td>
                <td><?php echo $dados["datapar"]; ?></td>
                <td><?php echo $dados["valorpar"]; ?></td>
            </tr>
            <?php
        }
        ?></tbody>
</table>