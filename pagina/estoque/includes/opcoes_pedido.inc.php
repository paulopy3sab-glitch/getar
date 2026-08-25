<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: 08/10/2024
 * Descricao: Rodape para os Pedidos
 * Revisoes:
 */
?>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=pedido&pag=ped_novo&tipo=compra&pagina=">
            <img src="imagens/editar.gif" alt="" style="width: 32px;" title="Criar novo pedido de Compra"><br>
            Novo pedido
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=pedido&pag=list_ped">
            <img src="imagens/livro.gif" alt="" style="width: 32px;" title="listar pedidos ativos"><br>
            Listar Ativos
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=pedido&pag=list_compra">
            <img src="imagens/livro.gif" alt="" style="width: 32px;" title="Listar Todos Pedidos"><br>
            Listar p/ Pedidos
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=pedido&pag=list_compraLiticos">
            <img src="imagens/livro.gif" alt="" style="width: 32px;" title="Listar Todos Pedidos"><br>
            Listar p/ Pedidos<br/>
            Eletrol&iacute;ticos.
        </a>
    </div>
    <div id="elemento">
        <form action="index.php?st=pedido&pag=pesq_pedCd" method="post">
            <input type="hidden" name="pag" value="pesq">
            <input type="hidden" name="pagina" value="">
            <img src="imagens/pesquisa1.gif" alt=""><br />
            Por Cod. Pedido<br>
            <input name="string" type="number" size="12" maxlength="20">
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>
    <div id="elemento">
        <form action="index.php?st=pedido&pag=pesq_forn" method="post">
            <input type="hidden" name="pag" value="pesq">
            <input type="hidden" name="pagina" value="">
            <img src="imagens/pesquisa1.gif" alt=""><br />
            Por Fornecedor<br>
            <input name="string" type="text" size="12" maxlength="20"><br />
            <input name="Listar" type="submit" value="OK">
        </form>
    </div>
</div>
