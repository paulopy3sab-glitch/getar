<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 05/05/2025
 * Descricao: Gerenciamento de um conta a pagar ou receber
 */
?>
<form action="index.php?st=financaspr&ft=fnc&pag=edit&codcarne=<?php echo $fnc->get_codCarne(); ?>" method="post">
    <input type="hidden" name="codcarne" value="<?php echo $fnc->get_codCarne(); ?>">
    <input type="hidden" name="tipo" value="<?php echo $dados['tipo']; ?>">
    <fieldset>
        <legend>Editando Conta Pagar/Receber n&ordm;: <b><?php echo $fnc->get_codCarne(); ?></b></legend>
        <label>
            <?php
            if ($dados['tipo'] == "pagar") {
                $str = "Conta a pagar a:";
                $clasf = 'r';
                $agente = "Credor";
            } else {
                $str = "Conta a receber de:";
                $clasf = 'c';
                $agente = "Devedor";
            }
            ?>
            <?php echo $str; ?>
        </label><b><?php echo $dados['nome']; ?></b><br>
        <label>Situa&ccedil;&atilde;o da Conta: </label>
        <select name="situcarne">
            <option value="cancelado" <?php echo $fnc->selectedIf("cancelado", $dados['situacao']); ?>>Cancelado</option>
            <option value="ativo" <?php echo $fnc->selectedIf("ativo", $dados['situacao']); ?>>Ativo</option>
        </select><br />
        <label>Conta Corrente:</label>
        <?php echo $fnc->selectCtCo($dados['codctco']); ?><br />
        <label>Plano de contas: </label>
        <?php echo $fnc->clasfSelect($dados['codclasf']); ?><br>
        <label>Tipo Lan&ccedil;amento:</label>
        <?php
        if ($dados['projetado'] == "fixo") {
            echo " <b>Projetado</b><br /> ";
        } else {
            echo " <b>Faturado</b><br /> ";
        }
        ?>
        <label>Objeto:</label><b><?php echo $dados['objeto']; ?></b><br>
        <label>N&uacute;mero de Faturas:</label><b><?php echo $dados['numparc']; ?></b><br>
        <label>Total: </label><b><?php echo $dados['valortot']; ?></b><br>
        <label>Valor Pag. Final: </label><b><?php echo $dados['valorpag']; ?></b><br>
        <label>Data Primeira Parcela:</label><b><?php echo $dados['priparc']; ?></b><br>
        <label>Observa&ccedil;&atilde;o Carn&ecirc;:</label>
        <textarea cols="60" rows="3" name="obs"><?php echo $dados['obs']; ?></textarea><br>
        <label>Senha Valida&ccedil;&atilde;o:</label>
        <input type="password" name="contra" value="" required size="16" maxlength="20"><br>
        <label><?php echo $fnc->get_msg(); ?>&nbsp;</label><input type="submit" name="editarCarne" value="Salvar"><br>
    </fieldset>