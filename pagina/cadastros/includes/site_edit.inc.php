<?php
/*
 * Para edição dos sites do cadastro de clientes
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 14/08/2024
 */
?>
<fieldset>
    <legend>Editando Site</legend>
    <form name="formsite" action="index.php?st=cadastro&pag=edit&codcad=<?php echo $cad->get_codCad(); ?>" method="post">
        <input type="hidden" name="codcad" value="<?php echo $cad->get_codcad(); ?>" />
        <input type="hidden" name="codsite" value="<?php echo $dados['cod']; ?>" />
        <input type="text" name="descr" value="<?php echo $dados['descr']; ?>" size="22" maxlength="120" />:&nbsp;
        <input type="text" name="endr" value="<?php echo $dados['endr']; ?>" size="40" maxlength="120" /><br />
        <label>&nbsp;</label>
        <input type="submit" name="sitesalvar" value="Salvar" />
    </form>
</fieldset>