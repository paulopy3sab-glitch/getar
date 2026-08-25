<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: indeterminada
 * Descricao: Para criar e geranciar as categoria e subcategorias dos produtos
 * Revisoes:
 * 28/11/2020 - pregis
 *     formatacoes iniciais
 */
switch ($pag) {
    case 'novacatg':
        // echo CategEdit("");
        break;
    case 'editcatg':
        //echo CategEdit($codCatg);
        break;
    case 'novasub':
        //echo SubCategEdit("", $codCatg);
        break;
    case 'editsub':
        //echo SubCategEdit($codSubCatg, $codCatg);
        break;
}

if ($pag == "novacatg" || $pag == "editcatg") {
    //  Cadastra provissoria
    if ($codCatg == "") {
        $consulta = "INSERT INTO estcatg (descr, situacao)
                          VALUES ('temporario', 'ativo')";
        $codCatg = executaIdSQL($consulta);
        // inserir uma subcategoria para efeitos de listagem
        $consulta = "INSERT INTO estsubcatg (codcatg, descr, situacao)
                          VALUES (" . $codCatg . ", 'geral', 'ativo')";
        executaIdSQL($consulta);
    }
    
    $consulta = "SELECT descr, situacao FROM estcatg WHERE cod=" . $codCatg;
    $dados = consultaSQL($consulta);
    $pag = "editcatg";


    ?>
    <form action = "index.php?st=categ&pag=editcatg&codcatg=<?php echo $codCatg; ?>" method = "post">
        <input name = "codCatg" type = "hidden" value = "<?php echo $codCatg; ?>">
        <fieldset>
            <legend>Edi&ccedil;&atilde;o de Categoria</legend>
            <label>C&oacute;digo:</label>
        <table border = "0">
            <tr>
                <td class = "txt"><b ></b> <?php echo $codCatg; ?></td>
                <td class="txt">
                    <b>Categoria:</b> <input name="descr" type="text" size="22" maxlength="20" value="<?php echo $dados['descr']; ?>">
                </td>
                <td align="center">
                    <select name="situacao">
                        <option value="ativo" <?php echo selectedIf("ativo", $dados['situacao']); ?>>ativo</option>
                        <option value="inativo" <?php echo selectedIf("inativo", $dados['situacao']); ?>>inativo</option>
                    </select>
                </td>
                <td>
                    <?php echo $msg; ?><input type="submit" name="salvarCatg" value="Salvar">
                </td>
            </tr>
        </table>
        <?php echo $msgSubIna; ?>
        <br><i style="color: blue;">Desativando uma categoria ira desativar todos suas subcategorias.</i>
        <br><i style="color: blue;">Havendo necessidade de excluir esta categoria entre em contato com administrador.</i>
        </fieldset>
    </form>
    <?php
}
if ($pag == "novasub" || $pag =="editsub") {
    //  Cadastra provissoria
    if ($codSubCatg == "") {
        $consulta = "INSERT INTO estsubcatg (codcatg, descr, situacao)
                          VALUES (" . $codCatg . ", 'temporario', 'ativo')";

        $codSubCatg = executaIdSQL($consulta);
    }

    $consulta = "SELECT ct.descr,
                        sb.descr sbdescr,
                        sb.situacao
                   FROM estsubcatg sb,
                        estcatg ct
                  WHERE sb.codcatg = ct.cod
                        AND sb.cod=" . $codSubCatg;
    $dados = consultaSQL($consulta);
    ?>
    <form action="index.php?st=categ&pag=editsub&codcatg=<?php echo $codCatg; ?>" method="post">
        <span class="titulo">Edi&ccedil;&atilde;o de Subcategoria</span><br>
        <input name="codSubCatg" type="hidden" value="<?php echo $codSubCatg; ?>>">
        <table id="Edita Sub Categoria">
            <tr>
                <td class="sub-titulo" colspan="3">
                    <b>Categoria:</b><?php echo $dados['descr']; ?>
                </td>
            </tr>
            <tr>
                <td class="txt"><b>C&oacute;digo subcategoria:</b> <?php echo $codSubCatg; ?>
                    <b>Subcategoria:</b> <input name="descr" type="text" size="22" maxlength="20" value="<?php echo $dados['sbdescr']; ?>">
                </td>
                <td align="center">
                    <select name="situacao">
                        <option value="ativo" <?php echo selectedIf("ativo", $dados['situacao']); ?>>ativo</option>
                        <option value="inativo" <?php echo selectedIf("inativo", $dados['situacao']); ?>>inativo</option>
                    </select>
                </td>
                <td>
                    <?php echo $msg; ?> . <input type="submit" name="salvarSubCatg" value="Salvar">
                </td>
            </tr>
        </table>
        <br><i style="color: blue;">Havendo necessidade de excluir esta categoria entre em contato com administrador.</i>
    </form>
    <?php
}
?>
<!-- 
** LISTAGEM
-->
<table>
    <caption>ESTOQUE - Categorias e Subcategorias.</caption>
    <thead>
        <tr>
            <th>Categoria</th>
            <th>Subcategoria</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $consulta = "SELECT ct.cod,
                        ct.descr,
                        (SELECT COUNT(*) FROM estoque WHERE ct.cod = estoque.catg) nmitct,
                        ct.situacao situ,
                        sb.cod codsub,
                        (SELECT COUNT(*) FROM estoque WHERE sb.cod = estoque.subcatg) nmitsb,
                        sb.descr descrsub,
                        sb.situacao situsub
                   FROM estcatg ct,
                        estsubcatg sb
                  WHERE ct.cod = sb.codcatg
                        AND ct.numest = " . $numest . "
                        " . $complemento . "
               ORDER BY ct.descr, sb.descr";
        $resultado = retornoSQL($consulta);
        $catAnt = "";
        while ($dados = arraySQL($resultado)) {
            $style = "";
            if ($dados["situ"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>
            <tr class="<?php echo corLinha(); ?>" <?php echo $style; ?>>
                <?php
                if ($catAnt <> $dados['cod']) {
                    ?>
                    <th>
                        <?php echo $dados['descr']; ?>
                        <a href="index.php?st=categ&pag=editcatg&codcatg=<?php echo $dados['cod']; ?>">
                            <img src="imagens/editar.gif" border="0">
                        </a>
                        <a href="index.php?st=categ&pag=novasub&codcatg=<?php echo $dados['cod']; ?>">
                            <img src="imagens/editar.gif" border="0">Nova Sub.
                        </a>
                        <a href="index.php?st=estoque&pag=list_catg&codcatg=<?php echo $dados['cod']; ?>&pagina=1">
                            <img src="imagens/livro.gif" border="0"><?php echo $dados['nmitct']; ?> itens
                        </a>
                    </th>
                    <?php
                    $catAnt = $dados['cod'];
                } else {
                    echo "<td>&nbsp;</td>";
                }
                if ($dados["situsub"] == "inativo") {
                    $style = " style=\"text-decoration:line-through;\"";
                }
                ?>
                <td class='txt' <?php echo $style; ?> >
                    <?php echo $dados['descrsub']; ?>
                    <a href="index.php?st=categ&pag=editsub&codcatg=<?php echo $dados['cod']; ?>&codsub=<?php echo $dados['codsub']; ?>">
                        <img src="imagens/editar.gif" border="0">
                    </a>
                    <a href="index.php?st=estoque&pag=list_subcatg&codcatg=<?php echo $dados['cod']; ?>&codsubcatg=<?php echo $dados['codsub']; ?>&pagina=1">
                        <img src="imagens/livro.gif" border="0"><?php echo $dados['nmitsb']; ?> itens
                    </a>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
<hr />
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=categ&pag=novacatg" accesskey="n">
            <img src="imagens/editar.gif" alt="Categoria Nova" style="width: 32px;" title="Cria Nova Categoria"><br>
            Categoria Nova
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=categ&pag=list">
            <img src="imagens/grupo.gif" alt="Listar Categorias" style="width: 32px;" title="Listar Categorias Ativas"><br>
            Listar Categorias
        </a>
    </div>
    <div id="elemento">
        <a href=\"index.php?st=estoque&pag=list&pagina=\">
            <img src="imagens/grupo.gif" alt="Listar Produtos" style="width: 32px;" title="Listar Produtos Ativos"><br>
            Listar Produtos
        </a>
    </div>
    <div id="elemento">
        <form action="index.php?st=estoque&pag=pesq" method="post">
            <input type="hidden" name="pag" value="pesq">
            <input type="hidden" name="pagina" value="">
            <img src="imagens/pesquisa1.gif" alt="">Pesquisa<br>
            <input name="string" type="text" size="12" maxlength="10" accesskey=\"p\">
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>
</div>