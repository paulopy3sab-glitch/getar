<?php
/*
 * Para editar os carnes de parcelamento a receber e a pagar
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * @date 16/05/2024
 * Descricao: pagar um fatura
 *
*/

if ($dados['tipo'] == "pagar") {
    $agenteTipo = "Credor";
    $agenteAcao = "Pagando";
    $agenteAcaoM = "PAGANDO";
} else {
    $agenteTipo = "Cliente";
    $agenteAcao = "Recebendo";
    $agenteAcaoM = "RECEBENDO";
}
?>
<form action="index.php?st=financaspr&ft=fnc&pag=pagar&codpar=<?php echo $fnc->get_codParc(); ?>" method="post">
    <input type="hidden" name="codpar" value="<?php echo $codParc; ?>">
    <input type="hidden" name="tipo" value="<?php echo $dados['tipo']; ?>">
    <input type="hidden" name="codctco" value="<?php echo $dados['codctco']; ?>">
    <fieldset>
        <legend><?php echo $agenteAcaoM; ?> UMA FATURA</legend>
        <label><?php echo $agenteTipo; ?>: </label><b><?php echo $dados['nome']; ?></b><br>
        <label>Conta Corrente: </label><b><?php echo $dados['contanome']; ?></b><br>
        <label>Objeto:</label><b><?php echo $dados['obscn']; ?></b><br>
        <label>Situa&ccedil;&atilde;o da fatura: </label>
        <input type="hidden" name="situpar" value="paga" />
        <b><?php echo $agenteAcao; ?></b><br>
        <label>Fatura n&uacute;mero: </label><b><?php echo $dados['parnum']; ?></b><br>
        <label>Valor da Parcela: </label><input name="valorpar" value="<?php echo $dados['valorpar']; ?>"  size="8" maxlength="9"><br>
        <label>Data Vencimento:</label>
        <?php echo selectData("vnc", $dados['diavnc'], $dados['mesvnc'], $dados['anovnc']); ?><br>
        <input type="hidden" name="obsant" value="<?php echo $dados['obspar']; ?>" >
        <pre><?php echo $dados['obspar']; ?></pre><br>
        <label>Observa&ccedil;&atilde;o:</label><textarea cols="60" rows="3" name="obs"></textarea><br>
        <label>Senha Valida&ccedil;&atilde;o:</label>
        <input type="password" name="contra" value="" size="16" maxlength="20"><br>
        <label><?php echo $fnc->get_msg(); ?>&nbsp;</label><input type="submit" name="editparc" value="Pagar"><br>
    </fieldset>
</form>