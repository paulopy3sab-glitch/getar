<?php
/*
 * Para edicao do periodo da Contas Corrente
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 15/04/2025
 */
?>
<form name="formPeriodo" action="index.php?st=financascc&ft=fnc&pag=listperativo" method="post">
    <input name="codPer" type="hidden" value="<?php echo $fnc->get_codPer(); ?>">
    <input name="codCtCo" type="hidden" value="<?php echo $dados['codctco']; ?>">
    <fieldset>
        <legend>Periodo de Lan&ccedil;amentos para: <b><?php echo $dados['nomecc']; ?></b>.</legend>
        <label>C&oacute;digo: </label><b><?php echo $dados['cod']; ?></b><br>
        <label>Nome Per&iacute;odo: </label>
        <input name="nome" type="text" size="22" maxlength="20" value="<?php echo $dados["nomeper"]; ?>" /><br>
        <label>Data Inicio:</label>
        <input name="dataini" type="date" value="<?php echo $dados['dataini']; ?>"><br />
        <label>Data Fim:</label>
        <input name="datafim" type="date" value="<?php echo $dados['datafim']; ?>"><br />
        <label>Situa&ccedil;&atilde;o</label>
        <select name="situ">
            <option value="ativo" <?php echo $fnc->selectedIf("ativo", $dados['situacao']); ?>>Ativo</option>
            <option value="inativo" <?php echo $fnc->selectedIf("inativo", $dados['situacao']); ?>>Inativo</option>
        </select><br>
        <label><?php echo $fnc->get_msg(); ?>&nbsp;</label><input type="submit" name="salvarPeriodo" value="Editar">
    </fieldset>
</form>