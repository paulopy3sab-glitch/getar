<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 26/04/2025
 * Descricao: Opcoes para tarefas
 */
?>
<table width="100%">
    <caption>LISTAGEM DE TAREFAS</caption>
    <thead>
        <tr>
            <th>C&oacute;digo</th>
            <th>Respons&aacute;vel</th>
            <th>Hora In&iacute;cio</th>
            <th>Situa&ccedil;&atilde;o</th>
            <th>Duracao</th>
            <th>Inc&iacute;cio Descri&ccedil;&atilde;o</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dataAnt = "";
        $dataList = "";
        $mesAnt = "";
        $mesList = "";
        while ($dados = arraySQL($resultado)) {
            $style = "";
            if ($dados["situ"] == "cancelada") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            // trocando de mes
            $mesList = $dados['mes'];
            if ($mesList <> $mesAnt) {
                ?>
                <tr class="<?php echo corLinha(); ?>">
                    <th>&nbsp;</th>
                    <th><?php echo mesExtBR($mesList); ?></th>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <?php
            }
            // separando por dia
            $dataList = $dados['dia'];
            if ($dataList <> $dataAnt) {
                ?>
                <tr class="<?php echo corLinha(); ?>">
                    <th>&nbsp;</th>
                    <th><?php echo $dataList; ?></th>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <?php
            }
            ?>
            <tr <?php echo $style; ?> class="<?php echo corLinha(); ?>">
                <th><?php echo $dados['cod']; ?></th>
                <td><?php echo $dados['resp']; ?>
                    <?php
                    if ($dados['situ'] != "concluida") {
                        //  Para nao poder editar ou excluir tarefas concluidas
                        ?>
                        <a href="index.php?st=tarefas&ft=prp&pag=edit&codTarefa=<?php echo $dados['cod']; ?>">
                            <img src="imagens/editar.gif" alt=""></a>
                        <?php
                    } else {
                        ?>
                        <a href="index.php?st=tarefas&ft=prp&pag=detalhar&codTarefa=<?php echo $dados['cod']; ?>">
                            <img src="imagens/editar.gif" alt=""></a>
                        <?php
                    }
                    ?>
                </td>
                <td><?php echo $dados['hora_ini']; ?></td>
                <td><?php echo $dados["situ"]; ?></td>
                <td><?php echo $dados['tempotrab']; ?> &nbsp;</td>
                <td>
                    <textarea cols="80" rows="4" class="txt" readonly=""><?php echo $dados["doc"]; ?></textarea>
                </td>
            </tr>
            <?php
            $dataAnt = $dados['dia'];
            $mesAnt = $dados['mes'];
        }
        ?>

        <tr>
            <td colspan="5" class="sub-titulo" align="right">
                Total horas trabalhadas: </td>
            <td class="sub-titulo">
                <b><?php echo $prp->totHoras($complemento); ?></b>
            </td>
        </tr>
    </tbody>
</table>
