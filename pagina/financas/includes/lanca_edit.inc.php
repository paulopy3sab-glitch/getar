<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 03/05/2025
 * Descricao: lancamento dos lancamentos dos C/C
 */
?>
<form name="formClasf" action="index.php?st=financascc&ft=fnc&pag=editlanca&codlanca=<?php echo $fnc->get_codLanca(); ?>" method="post">
    <input name="codlanca" type="hidden" value="<?php echo $fnc->get_codLanca(); ?>">
    <fieldset>
        <legend>Lancamento para: <b><?php echo $dados['contanome']; ?></b></legend>
        <label>C&oacute;digo: </label><b><?php echo $fnc->get_codLanca(); ?></b><br>
        <label>Descri&ccedil;&atilde;o:</label>
        <input name="descr" type="text" size="42" value="<?php echo $dados["descr"]; ?>" /><br>
        <label>Plano de contas: </label>
        <?php echo $fnc->clasfSelect($dados['codclasf']); ?><br>
        <label>Data:</label>
        <input type="date" name="datalanca" value="<?php echo $dados['datalanca']; ?>" /><br />
        <label>Credito:</label>
        <input name="cred" type="text" size="42" value="<?php echo $dados["cred"]; ?>" /><br>
        <label>Dedito:</label>
        <input name="debt" type="text" size="42" value="<?php echo $dados["debt"]; ?>" /><br>
        <label>Situa&ccedil;&atilde;o</label>
        <select name="situacao">
            <option value="ativo" <?php echo $fnc->selectedIf("ativo", $dados['situacao']); ?>>Ativo</option>
            <option value="pend" <?php echo $fnc->selectedIf("pend", $dados['situacao']); ?>>Pendente</option>
            <option value="inativo" <?php echo $fnc->selectedIf("inativo", $dados['situacao']); ?>>Inativo</option>
        </select><br />
        <i style="color: blue;"><strong>ativo</strong>: soma no total, <strong>inativo</strong>: n&atilde;o soma,
            <strong>pendente</strong>: vem de um lan&ccedil;amento a ser revisado(n&atilde;o soma)</i><br>
        <label>Observa&ccedil;&atilde;o:</label>
        <textarea cols="60" rows="3" name="obs"><?php echo $dados['obs']; ?></textarea><br>
        <label><?php echo $fnc->get_msg(); ?>&nbsp;</label><input type="submit" name="salvarlanca" value="Editar">
    </fieldset>
</form>
