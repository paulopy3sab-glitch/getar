<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 27/04/2025
 * Descricao: Gerenciamento dos pedidos para projetos
 */
?>
<table width="100%">
    <caption>LISTAGEM DE PEDIDOS</caption>
    <thead>
        <tr>
            <th>C&oacute;d/Tag</th>
            <th>T&iacute;tulo Pedido</th>
            <th>Data In&iacute;cio</th>
            <th>Situa&ccedil;&atilde;o</th>
            <th>Tempo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($dados = arraySQL($resultado)) {
            $style = "";
            if ($dados["situacao"] == "x") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>

            <tr <?php echo $style; ?> class="<?php echo $prp->corLinha(); ?>">
                <td><?php echo $dados["cod"] . " - " . $dados["tag"]; ?></td>
                <td><?php echo $dados["titulo"] . " - " . $dados["nome"]; ?>
                    <?php
                    //so disponibilizar para o administrador
                    if ($prp->atrib("32")) {
                        ?>
                        <a href="index.php?st=pedidos&ft=prp&pag=edit&codped=<?php echo $dados['cod']; ?>&codproj=<?php echo $dados['codproj']; ?>">
                            <img src="imagens/editar.gif" alt="" style="width: 16px;">
                        </a>
                        <?php
                    }
                    ?>
                    <a href="index.php?st=tarefas&ft=prp&pag=list_all&codped=<?php echo $dados['cod']; ?>">
                        <img src="imagens/livro.gif" alt="" style="width: 16px;">
                    </a>
                </td>
                <td><?php echo $dados["dataini"]; ?></td>
                <td><?php echo $dados["situacao"]; ?></td>
                <td>&nbsp;<?php echo $dados['tothora']; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody></table>
<?php
$prp->set_situProj($dados['situproj']);
?>