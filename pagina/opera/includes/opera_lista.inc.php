<?php
/*
 * Para listagem dos Operacionais cadastrados
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 22/12/2024
 */


$resultado = $opr->operaConsulta($complemento);
?>
<table width="100%">
    <caption>LISTAGEM DOS OPERA&Ccedil;&Otilde;ES</caption>
    <thead>
        <tr>
            <th>C&oacute;d/Tag</th>
            <th>Atividade</th>
            <th>Data</th>
            <th>Inicio Descr.</td>
            <th>Situa&ccedil;&atilde;o</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($dados = arraySQL($resultado)) {
            $style = "";
            if ($dados["situacao"] == "cancelado") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>
            <tr <?php echo $style; ?> class="<?php echo $opr->corLinha(); ?>">
                <td><?php echo $dados["cod"] . "-" . $dados["tag"]; ?></td>
                <td><?php echo $dados["nome"]; ?>
    <?php
    //so disponibilizar para o administrador
    if ($opr->atrib("32")) {
        ?>
                        <a href="index.php?st=opera&pag=edit&codopr=<?php echo $dados['cod']; ?>">
                            <img src="imagens/editar.gif" alt="" border="0">
                        </a>
        <?php
    } else {
        ?>
                        <a href="index.php?st=opera&pag=detal&codopr=<?php echo $dados['cod']; ?>">
                            <img src="imagens/editar.gif" alt="" border="0">
                        </a>
        <?php
    }
    ?>


                </td>
                <td><?php echo $dados["datareg"]; ?></td>
                <td><?php echo $dados["descr"]; ?></td>
                <td><?php echo $dados["situacao"]; ?></td>
            </tr>
    <?php
}
?>
    </tbody>
</table>
