<?php
/*
 * Para Listagem do cadastro de clientes
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 12/08/2024
 */
?>
<table id="listcad">
    <caption>Cadastro - Listagem Geral</caption>
    <thead>
        <tr>
            <th>Reg.</th>
            <th>Nome</th>
            <?php
            if ($cad->atrib("2")) {
                ?>
                <th>Classifica&ccedil;&atilde;o</th>
                <?php
            }
            ?>
            <th>Cidade</th>
            <th>Telefone</th>
            <th>E-mail</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($dados = arraySQL($resultado)) {
            $style = "";
            if ($dados["situacao"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>
            <tr <?php echo $style; ?> class="<?php echo $cad->corLinha(); ?>">
                <th><?php echo $dados['cod']; ?></th>
                <td><?php echo $dados['nome']; ?>
                    <?php
                    if ($dados["contato"] != "") {
                        echo " - " . $dados["contato"];
                    }
                    if (atrib("3")) {
                        ?>
                        <a href="index.php?st=cadastro&pag=edit&codcad=<?php echo $dados["cod"]; ?>">
                            <img src="imagens/editar.gif" alt="Editar" title="Editar este registro">
                        </a>
                        <?php
                    }
                    if (atrib("4")) {
                        ?>
                        <a href="index.php?st=cadastro&pag=detal&codcad=<?php echo $dados["cod"]; ?>">
                            <img src="imagens/editar.gif" alt="Detalhar" title="Detalhar este registro">
                        </a>
                        <?php
                    }
                    if ($cad->atrib("2") && ($dados['nick'] <> "")) {
                        ?>
                        [<?php echo $dados['nick']; ?>
                        <a href="index.php?st=cadastro&pag=ingr&nick=<?php echo $dados['nick']; ?>&codcad=<?php echo $dados["cod"]; ?>">
                            <img src="imagens/editar.gif" alt="Editar" title="Editar logon">
                        </a>]
                        <?php
                    }
                    $arrayClasf = $cad->descrClasf($dados["clasf"]);
                    ?>
                </td>
                <?php
                if ($cad->atrib("2")) {
                    ?>
                    <td>&nbsp;<?php echo $arrayClasf[1]; ?></td>
                    <?php
                }
                ?>
                <td>&nbsp;<?php echo $dados["cidade"] . " - " . $dados['estado']; ?></td>
                <td>&nbsp;<?php echo $dados["fones"]; ?></td>
                <td>&nbsp;<?php echo $dados["email"]; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<?php
$doc = "index.php?st=cadastro&pag=" . $pag;
echo $cad->geraIndicesPaginas($pagList, $doc);
?>