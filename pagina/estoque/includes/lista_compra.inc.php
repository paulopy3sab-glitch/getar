<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: 18/10/2024
 * Descricao: Para listagem de pedido de consumo para pedidos de projetos eletronicos
 * Vindo da funcao: list_compra(), funcoes_estoque.php
 * Revisoes:
 */
?>
<div class="titulo">Listagem Produtos para Compra.</div>
<?php
/*if ($msgItem <> "") {
    echo $msgItem;
}*/
?>
<table width="100%">
    <tr>
        <td class='sub-titulo'>Cod Estoque</td>
        <td class='sub-titulo'>Componente</td>
        <td class='sub-titulo'>Qt. Pedida</td>
        <td class='sub-titulo'>Custo</td>
        <td class='sub-titulo'>Situ. Pedido</td>
    </tr>
    <?php
    while ($dados = arraySQL($resultado)) {
        ?>
        <tr class="<?php echo corLinha(); ?>">
            <td class='sub-titulo'><?php echo $dados["codest"]; ?></td>
            <td class='txt'>
    <?php echo $dados["descr"]; ?>
                <a href="index.php?st=estoque&pag=edit&codestq=<?php echo $dados["codest"]; ?>" target=\"blank\">
                    <img src="imagens/livro.gif" alt="" border="0">
                </a>
    <?php echo $dados['descrtec'] . " - " . $dados['fornc']; ?>
                <?php
                if ($dados['situitem'] == "esg") {
                    ?>
                    - <b style="color: red;">ESGOTADO</b>
                    <?php
                }
                if ($dados['fornc'] == "sem fornecedor") {
                    
                } else {
                    echo "(" . $dados['codpedido'] . ")";
                }
                ?>
            </td>
            <td class="txt"><?php echo $dados["qt"]; ?></td>
            <td class="txt"><?php echo $dados['custo']; ?></td>
            <td class='txt'><?php echo $dados["situpedido"]; ?></td>
        </tr>
    <?php
}
?>
</table>
<hr>