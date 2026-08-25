<?php
/*
 * Descricao:
 * Listagem dos tecnicos trabalhando em OSs e colaboradores.
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * @date: 22/04/2025
 * 
 * Revisions:
 */
?>
<form name="formLembr" action="index.php?st=lembretes&ft=mens&pag=edit&codlmb=<?php echo $lmb->get_codLmb(); ?>" method="post" onsubmit="return validaForm();">
    <input name="codlmb" type="hidden" value="<?php echo $lmb->get_codLmb(); ?>">
    <input name="remt" type="hidden" value="<?php echo $lmb->get_resp(); ?>">
    <fieldset>
        <legend>Detalhes do Lembrete</legend>
        <label>T&iacute;tulo</label>
        <input type="text" name="titulo" size="20" maxlength="40" value="<?php echo $dados['titulo']; ?>"/><br/>
        <label>Destinat&aacute;rio: </label>
        <?php echo $lmb->lembrUsuarios($dados["dest"]); ?><br>
        <label>Agendar para: </label>
        <input type="date" name="dataagd" value="<?php echo $dados['dataagd']; ?>" /><br/>
        <label>Texto da mensagem:</label>
        <textarea name="texto" rows="10" cols="38"><?php echo $dados["texto"]; ?></textarea><br>
        <label>Situa&ccedil;&atilde;o:</label>
        <select name="situacao">
            <option value="ativo" <?php echo selectedIf($dados['situ'], "ativo"); ?>>ativo</option>
            <option value="inativo" <?php echo selectedIf($dados['situ'], "inativo"); ?>>inativo</option>
        </select><br>
        <label>&nbsp;</label>
        <input type="submit" name="salvarLmb" value="Salvar"><br>
        <?php echo $lmb->get_msgLmb(); ?>
    </fieldset>
</form>