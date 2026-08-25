<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 01/05/2025
 * Descricao: Gerenciamento dos pedidos para projetos
 */
?>
<form name="formulario" action="index.php?st=pedidos&ft=prp&pag=edit&codped=<?php echo $prp->get_codPed(); ?>&codproj=<?php echo $prp->get_codProj(); ?>" method="post" onsubmit="return validaFormPed();">
    <input name="codped" type="hidden" value="<?php echo $prp->get_codPed(); ?>">
    <input name="codproj" type="hidden" value="<?php echo $prp->get_codProj(); ?>">
    <fieldset>
        <legend>Detalhes do Pedido</legend>
        <label>C&oacute;digo: </label><b><?php echo $prp->get_codPed(); ?></b><br>
        <label for="titulo">T&iacute;tulo:</label>
        <input name="titulo" type="text" value="<?php echo $dados["titulo"]; ?>" size="60" maxlength="60"><br>
        <label>Respons&aacute;vel: </label><?php echo $prp->selectResp($dados['resp'], '41'); ?><br>
        <label>Data Registro: </label> <b><?php echo $dados["datareg"]; ?></b><br>
        <label>Data In&iacute;cio: </label>
        <input type="date" name="dataini" value="<?php echo $dados['dataini']; ?>" ><br>
        <label>Data Conclus&atilde;o</label>
        <input type="date" name="dataclc" value="<?php echo $dados['dataclc']; ?>" ><br>
        <label>Documenta&ccedil;&atilde;o: </label>
        <textarea name="doc" cols="90" rows="10"><?php echo $dados["doc"]; ?></textarea><br>
        <label>Situacao: </label>
        <select name="situped">
            <option value="espera" <?php echo $prp->selectedIf($dados["situacao"], "espera"); ?>>espera</option>
            <option value="estudo" <?php echo $prp->selectedIf($dados["situacao"], "estudo"); ?>>estudos</option>
            <option value="andamento" <?php echo $prp->selectedIf($dados["situacao"], "andamento"); ?>>andamento</option>
            <option value="concluido" <?php echo $prp->selectedIf($dados["situacao"], "concluido"); ?>>concluido</option>
            <option value="cancelado" <?php echo $prp->selectedIf($dados["situacao"], "cancelado"); ?>>cancelado</option>
        </select>
        <a href="index.php?st=artigos&pag=leitura&codartg=85" target="blank"><img src="imagens/duvida.gif"></a><br>
        <label>Prioridade: </label>
        <select name="prior">
            <option value="urgente" <?php echo $prp->selectedIf($dados["prior"], "urgente"); ?>>Urgente</option>
            <option value="alta" <?php echo $prp->selectedIf($dados["prior"], "alta"); ?>>Alta</option>
            <option value="media" <?php echo $prp->selectedIf($dados["prior"], "media"); ?>>M&eacute;dia</option>
            <option value="baixa" <?php echo $prp->selectedIf($dados["prior"], "baixa"); ?>>Baixa</option>
        </select><br>
        <label>Fatura: </label>
        <select name="fatu">
            <option value="1" <?php echo $prp->selectedIf($dados["fatu"], "1"); ?>>Sim</option>
            <option value="0" <?php echo $prp->selectedIf($dados["fatu"], "0"); ?>>N&atilde;o</option>
        </select><br>
        <label for="salvar">&nbsp;</label>
        <input name="salvarped" type="submit" value="Editar"><br/>
<?php echo $prp->get_msg(); ?>
    </fieldset>
</form>
<?php
if ($dados['numcodpedcons'] > 2) {
    $str.= "<b style=\"color: red;\">H&aacute; mais de um (1) pedido de consumo para esta Pedido de Projeto!!!</b>";
}
?>