<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 05/06/206
 * Descricao: Resolucao para modelo em que os scripts HTML para a ser tratados
 * fora des strs, assim possiveis de melhor acompanhamento utilizando as IDEs, 
 * como o Netbeans.
 * Surgiu da necessidade de aprimorar a listage ate o momento utililizada
 * 
 * 
 */

$resultado = $artg->artgList($pag, $pagList, $complemento);
?>
<table width="100%">
    <caption>Listagem Artigos <?php echo $tipoList; ?></caption>
    <thead>
        <tr>
            <th>N&uacute;mero</th>
            <th>&nbsp;</th>
            <th>T&iacute;tulo</th>
            <th>Linha</th>
        </tr>
    </thead>
    <tbody>
    <?php
    while ($dados = arraySQL($resultado)) {
        $style = "";
        if ($dados['situacao'] == "inativo") {
            $style = ' style="text-decoration:line-through;"';
        }
        ?>
        <tr class="<?php echo  $artg->corLinha(). " " . $style; ?>" >
            <th rowspan="2"><?php echo  $dados['cod']; ?></th>
            <td rowspan="2">
                <img src="<?php echo $artg->get_localFotos() . $dados['imagem']; ?>" alt="" style="width: 32px" />
                &nbsp;
            </td>
            <td><?php echo  $dados['titulo']; ?>
                <a href="index.php?st=artigos&pag=leitura&codartg=<?php echo $dados['cod']; ?>">
                    <img src="imagens/livro.gif" alt="ler" title="Ler artigo">
                </a> 
                <a href="index.php?st=artigos&pag=edit&codartg=<?php echo  $dados['cod']; ?>">
                    <img src="imagens/editar.gif" alt="editar" title="Editar Artigo">
                </a>
                <a href="artigos-imprimir.php?codartg=<?php echo $dados['cod']; ?>" target="_blank">
                    <img src="imagens/impress.jpeg" width="20" height="18" alt="impress" title="Vers&atilde;o<br /> para impress&atilde;o"/>
                </a>
            </td>
            <td>
                <?php
                echo $dados['nome'] . "(" . $dados['nomeln'] . ")";
                ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $dados['intro']; ?>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <?php
    }
    ?>
    <td colspan="3">
        <h3 style="color: blue">Listando primeiros 20 artigos.</h3>
    </td>
    </tbody>
</table>