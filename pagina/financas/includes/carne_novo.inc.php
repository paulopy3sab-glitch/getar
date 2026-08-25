<?php
/*
 * Para editar os carnes de parcelamento a receber e a pagar
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 29/07/2024
 */
?>
<form name="formCarneNovo" action="index.php?st=financaspr&ft=fnc&pag=edit&codcarne=<?php echo $fnc->get_codCarne(); ?>" method="post"  onsubmit="return valFormCarneNv();">
    <input type="hidden" name="codcarne" value="<?php echo $fnc->get_codCarne(); ?>">
    <input type="hidden" name="tipo" value="<?php echo $dados['tipo']; ?>">
    <fieldset>
        <legend>Criando Conta N&ordem;: <b><?php echo $fnc->get_codCarne(); ?></b></legend>
        <label>
            <?php
            if ($dados['tipo'] == "pagar") {
                ?>
                Fatura a pagar a:
                <?php
            } else {
                ?>
                Fatura a receber de:
                <?php
            }
            ?>
        </label>
        <?php echo $fnc->selectAgente($dados['tipo'], $fnc->get_codCad()); ?><br />
        <label>Conta Corrente: </label><?php echo $fnc->selectCtCo($fnc->get_codCtCo()); ?><br />
        <label>Plano de contas: </label>
        <?php echo $fnc->clasfSelect($dados['codclasf']); ?><br>
        <label>Tipo Lan&ccedil;amento: </label>
        <select name="projetado">
            <option value="fixo">projetado</option>
            <option value="nego">faturado</option>
        </select><br>
        <i>Faturado: sao lan&ccedilamentos com n&uacute;mero de parcelas. Ex.: parcelamento de uma compra qualquer.<br>
            Projetado: n&atilde;o tem n&uacute;mero fixo de parcela e seus valores s&atilde;o mut&aacute;veis. Ex.: as contas de luz.</i><br>
        <label>Objeto:</label><input name="objeto" value="<?php echo $fnc->get_objeto(); ?>" size="22" maxlength="60" ><br>
        <label>Total da Conta:</label><input name="valortot" value="<?php echo $fnc->get_valorTot(); ?>" size="8" maxlength="9" ><br>
        <label>Numero de faturas:</label><input type="number" name="numparc" value="<?php echo $fnc->get_numParc(); ?>" size="2" maxlength="2"><br>
        <label>Valor da fatura:</label><input name="valorparc" size="8" maxlength="9"><br>
        <label>Data da primeira:</label><?php echo $fnc->selectData("pri"); ?><br />
        <label>Intervalo fatura:</label>
        <select name="interparc">
            <option value="7d">Semanal</option>
            <option value="15d">15 dias</option>
            <option value="mes" selected>Mesmo dia do mes</option>
            <option value="util">Proximo dia util</option>
        </select><br>
        <label>Observa&ccedil;&atilde;o:</label>
        <textarea cols="60" rows="3" name="obs"><?php echo $fnc->get_obsCarne(); ?></textarea><br>
        <label>Senha Valida&ccedil;&atilde;o:</label>
        <input type="password" name="contra" value="" required size="16" maxlength="20"><br>
        <label>&nbsp;<?php echo $fnc->get_msg(); ?></label><input type="submit" name="salvarCarne" value="Salvar"><br>
    </fieldset>
</form>