<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 28/03/2025
 * Descricao: Para edicao e envio de Mensagens
 */

#$dest = "";
$dados= $lmb->mensEdit();

?>
<div class="titulo">MENSAGEM NOVA</div>
<form action="index.php?st=mensagens&ft=mens&pag=edit&codmens=<?php echo $lmb->get_codMens(); ?>" method="post">
    <input name="codmens" type="hidden" value="<?php echo $dados['cod']; ?>">
    <fieldset>
        <legend>Editando Mensagem</legend>
        <label>C&oacute;digo Mens.: </label><b><?php echo $dados['cod']; ?></b><br />
        <label>T&iacute;tulo Mensagem: </label>
        <input name="titulo" type="text" size="42" maxlength="120" value="<?php echo $dados['titulo']; ?>" autofocus><br>
        <label>Data: </label><b><?php echo $dados['data']; ?></b><br>
        <label>Remetente</label><b><?php echo $dados['nomeremt']; ?></b><br>
        <label>E-mail Remt.: </label>
        <input name="remtemail" type="text" size="42" maxlength="120" value="<?php echo $dados['remtemail']; ?>"><br>
        <label>Destinat&aacute;rio</label><?php echo $lmb->selectDest($dados['dest']); ?><br>
        <label>E-mail Dest.: </label>
        <input name="destemail" type="text" size="42" maxlength="120" value="<?php echo $dados['destemail']; ?>"><br>
        <label>Texto da Mensagem: </label>
        <textarea name="texto" rows="10" cols="45"><?php echo $dados['texto']; ?></textarea><br>
        <label>Situa&ccedil;&atilde;o:</label><b><?php echo $dados['situ']; ?></b><br>
        <label>&nbsp;</label><input type="submit" name="editarNova" value="Editar"><br>
        <label>&nbsp;</label><input type="submit" name="postarNova" value="Enviar"><br>
        <?php echo $lmb->get_msgMens(); ?>
    </fieldset>
</form>