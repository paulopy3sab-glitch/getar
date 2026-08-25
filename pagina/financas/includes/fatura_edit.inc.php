<?php
/*
 * Para editar os carnes de parcelamento a receber e a pagar
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 05/05/2024
 * Descricao: gerenciar um fatura
 */
if ($dados['tipo'] == "pagar") {
    $tipoAgente = "Credor";
} else {
    $tipoAgente = "Cliente";
}

$fnc->set_codCtCo($dados['codctco']);
?>
<div id="parcedit">
    <div id="parcform">
        <form action="index.php?st=financaspr&ft=fnc&pag=editpar&codpar=<?php echo $fnc->get_codParc(); ?>" method="post">
            <input type="hidden" name="codpar" value="<?php echo $codParc; ?>">
            <input type="hidden" name="codcarne" value="<?php echo $dados['codcarne']; ?>">
            <input type="hidden" name="tipo" value="<?php echo $dados['tipo']; ?>">
            <fieldset>
                <legend>EDITANDO UMA FATURA</legend>
                <label>Fatura n&uacute;mero: </label><b><?php echo $dados['parnum']; ?></b><br>
                <label><?php echo $tipoAgente; ?>: </label><b><?php echo $dados['nome']; ?></b><br>
                <label>Conta Corrente: </label><?php echo $fnc->selectCtCo($dados['codctco']); ?><br />
                <label>Plano de contas: </label>
                <?php echo $fnc->clasfSelect($dados['codclasf']); ?><br>
                <label>Situa&ccedil;&atilde;o da fatura: </label>
                <select name="situpar">
                    <option value="aberta" <?php echo selectedIf("aberta", $dados['situacao']); ?> >Aberta</option>
                    <option value="paga" <?php echo selectedIf("paga", $dados['situacao']); ?>>Paga</option>
                    <option value="cancelada" <?php echo selectedIf("cancelada", $dados['situacao']); ?>>Cancelada</option>
                </select><br>
                <input type="hidden" name="parnum" value="<?php echo $dados['parnum']; ?>">
                <label>Valor da Parcela: </label><input input="text" name="valorpar" value="<?php echo $dados['valorpar']; ?>"  size="8" maxlength="9"><br>
                <label>Data Vencimento:</label>
                <?php echo selectData("vnc", $dados['diavnc'], $dados['mesvnc'], $dados['anovnc']); ?><br>
                <input type="hidden" name="obsant" value="<?php echo $dados['obs']; ?>" >
                <pre><?php echo $dados['obs']; ?></pre><br>
                <label>Observa&ccedil;&atilde;o da Parcela:</label><textarea cols="60" rows="3" name="obs"></textarea><br>
                <label>Senha Valida&ccedil;&atilde;o:</label>
                <input type="password" name="contra" value="" required size="16" maxlength="20"><br>
                <label><?php echo $fnc->get_msg(); ?>&nbsp;</label><input type="submit" name="editparc" value="Editar"><br>
            </fieldset>
        </form>
    </div>
    <div id="parchist">
        <?php echo $fnc->carneRelato($dados['codcad']); ?>
    </div>
</div>