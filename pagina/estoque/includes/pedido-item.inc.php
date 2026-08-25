<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: 18/02/2025
 * Descricao: Para editar um item do pedido
 * 
 */

$consulta = "   SELECT it.coditem,
                it.codped,
                it.codest,
                est.descr,
                it.qt,
                it.custo
           FROM estpedidoitem it,
                estoque est
          WHERE est.cod = it.codest
                AND est.cod = ".$codEstq."
                AND codped = ". $codPed;
$dados = consultaSQL($consulta);
?>
<form action="index.php?st=pedido&pag=ped_ldetal&codped=<?php echo $codPed; ?>" method="post">
    <input name="coditem" type="hidden" value="<?php echo $dados['coditem']; ?>">
    <fieldset>
        <legend>Editando um Item do Pedido</legend>
        <label>Pedido n&uacute;mero: </label><b> <?php echo $codPed; ?> </b><br />
        <label>Descri&ccedil;&atilde;o: </label><b><?php echo $dados['descr']; ?></b><br />
        <label>Quantidade:</label><b>
        <input name="qt" type="tex" value="<?php echo $dados['qt']; ?>" size="22" maxlength="30"></b><br />
        <label>Custo/Pre&ccedil;o Final:</label><b>
        <input name="custo" type="tex" value="<?php echo $dados['custo']; ?>" size="22" maxlength="30"></b><br />
        <label>&nbsp;</label><?php echo $msgAcop; ?><input type="submit" name="salvarItem" value="Salvar"><br />
    </fieldset>
</form>
