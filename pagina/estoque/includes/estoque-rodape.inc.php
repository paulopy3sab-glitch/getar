<?php

/*
 * Apenas para acompanhameto e backup da estrutura HTML
 * 
 * 01/05/24
 * Criacao
 */
?>
<div id="opcoes">
    <div id="elemento">
        <form action="index.php?st=estoque&pag=pesq" method="post">
            <input type="hidden" name="pag" value="pesq">
            <input type="hidden" name="pagina" value="">
            <img src="imagens/pesquisa1.gif" alt="">Por Descri&ccedil;&atilde;o<br>
            <input name="string" type="text" size="12" maxlength="20" accesskey="p">
            <i><small>Atalho:[Shift] [Alt] [P]</small></i>
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>

    <div id="elemento">
        <form action="index.php" method="get">
            <input type="hidden" name="st" value="estoque">
            <input type="hidden" name="pag" value="edit">
            <img src="imagens/pesquisa1.gif" alt="">Por C&oacute;digo<br>
            <input name="codestq" type="text" size="12" maxlength="10" accesskey="c">
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
            <img src="imagens/grupo.gif" alt="Listar ultimos Registros" style="widht: 32px;" title="Listar Ultimos Registros"><br>
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
            <img src="imagens/grupo.gif" alt="" style="widht: 32px;" border="no"><br>
            Listar Pedidos
        </a>
    </div>
</div>