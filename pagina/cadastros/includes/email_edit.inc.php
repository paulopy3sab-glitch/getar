<?php
/*
 * Para edição dos emails do cadastro de clientes
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 13/08/2024
 */
?>
<fieldset>
    <legend>Editando Email</legend>
    <form name="formemail" action="index.php?st=cadastro&pag=edit&codcad=<?php echo $cad->get_codCad(); ?>" method="post">
        <input type="hidden" name="codcad" value="<?php echo $cad->get_codcad(); ?>" />
        <input type="hidden" name="codemail" value="<?php echo $dados['cod']; ?>" />
        <input type="text" name="descremail" value="<?php echo $dados['descr']; ?>" size="22" maxlength="120" />:&nbsp;
        <input type="text" name="endremail" value="<?php echo $dados['endr']; ?>" size="40" maxlength="120" /><br />
        <label>&nbsp;</label>
        <input type="submit" name="emailsalvar" value="Salvar" />
    </form>
</fieldset>