<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: 24/02/2025
 * Descricao: Rodape para os Produtos
 * Revisoes:
 */
?>

<div id="opcoes">
    <div id="elemento">
        <form action="index.php?st=estoque&pag=pesq" method="post">
            <input type="hidden" name="pag" value="pesq">
            <input type="hidden" name="pagina" value="">
            <img src="imagens/pesquisa_.jpg" alt="Pesquisa" height="32px">Por Descri&ccedil;&atilde;o<br>
            <input name="string" type="text" size="12" maxlength="20" accesskey="p">
            <i><small>Atalho:[Shift] [Alt] [P]</small></i>
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>

    <div id="elemento">
        <form action="index.php" method="get">
            <input type="hidden" name="st" value="estoque">
            <input type="hidden" name="pag" value="edit">
            <img src="imagens/pesquisa_.jpg" alt="Pesquisa" height="32px" alt="">Por C&oacute;digo<br>
            <input name="codestq" type="number" size="12" maxlength="10" accesskey="c">
            <i><small>Atalho:[Shift] [Alt] [C]</small></i>
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>
    <?php
    if (atrib("21")) {
        ?>
        <div id="elemento">
            <a href="index.php?st=estoque&pag=cad" accesskey="n">
                <img src="imagens/editar.gif" alt="Produto Novo" style="widht: 32px;" title="Cria Produto Novo"><br>
                Produto Novo
            </a>
        </div>
        <?php
    }
    ?>
    <div id="elemento">
        <a href="index.php?st=estoque&pag=list_u&pagina=">
            <img src="imagens/listar_.jpg" alt="Listar ultimos Registros" style="widht: 32px;" title="Listar Ultimos Registros"><br>
            Listar &Uacute;ltimos
        </a>
    </div>
    <!--<div id="elemento">
        <a href="index.php?st=estoque&pag=list&pagina=">
            <img src="imagens/grupo.gif" alt="Listar Produtos" style="widht: 32px;" title="Listar Produtos Ativos"><br>
            Listar Produtos
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=estoque&pag=list_i&pagina=">
            <img src="imagens/grupo.gif" alt="" style="widht: 32px;" border="no"><br>
            Listar Inativos
        </a>
    </div>-->
    <div id="elemento">
        <a href="index.php?st=pedido&pag=list_ped">
            <img src="imagens/lista_pedidos.jpg" alt="Listar Pedidos" style="widht: 32px;" border="no"><br>
            Listar Pedidos
        </a>
    </div>
</div>