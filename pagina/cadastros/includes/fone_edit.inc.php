<?php
/*
 * Para edição dos telefones do cadastro de clientes
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 05/08/2024
 */
?>
<fieldset>
    <legend>Editando Telefone</legend>
    <form name="formFone" action="index.php?st=cadastro&pag=edit&codcad=<?php echo $cad->get_codCad(); ?>" method="post">
        <input type="hidden" name="codcad" value="<?php echo $cad->get_codcad(); ?>" />
        <input type="hidden" name="codfone" value="<?php echo $dados['cod']; ?>" />
        <input type="text" name="descr" value="<?php echo $dados['descr']; ?>" size="22" maxlength="20" />:&nbsp;
        <input type="text" name="numero" value="<?php echo $dados['numero']; ?>" size="17" maxlength="15" /><br />
        <label>&nbsp;</label>
        <input type="submit" name="fonesalvar" value="Salvar" />
    </form>
</fieldset>