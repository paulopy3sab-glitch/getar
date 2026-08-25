<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 30/04/2025
 * Descricao: Gerenciamento das tarefas
 */
?>
<form name="formTarefa" action="index.php?st=tarefas&ft=prp&pag=edit&codTarefa=<?php echo $prp->get_codTarf(); ?>" method="post" onSubmit="return validaFormTarf();">
    <fieldset>
        <legend>Descricao do pedido:</legend>
        <textarea cols="80" rows="12" readonly='readonly'><?php echo $dados['doc_pedido']; ?></textarea>
    </fieldset>
    <fieldset>
        <legend>Detalhamento da Tarefa</legend>
        <label>C&oacute;digo: </label><b><?php echo $prp->get_codTarf(); ?></b><br>
        <label>Respons&aacute;vel :</label><?php echo $prp->selectResp($dados['resp'], "31"); ?><br>
        <label>Data: </label><b><?php echo $dados['dia']; ?></b><br>
        <label>Hora In&iacute;cio: </label>
        <input name="horaini" type="time" id="horaini" value="<?php echo $dados['horaini']; ?>" onclick="agora('horaini', this.value);"><br>
        <label>Hora Fim: </label>
        <input name="horafim" type="time" id="horafim" value="<?php echo $dados['horafim']; ?>" onclick="agora('horafim', this.value);"><br>
        <label>Documenta&ccedil;&atilde;o: </label><textarea name="doc" cols="80" rows="10" id="doc" autofocus=""><?php echo $dados['doc']; ?></textarea><br>
        <label>Situacao: </label>
        <select name="situacao">
            <option value="andamento" <?php echo $prp->selectedIf($dados["situ"], "andamento"); ?>>Andamento</option>
            <option value="concluido" <?php echo $prp->selectedIf($dados["situ"], "concluido"); ?>>Conclu&iacute;do</option>
            <option value="cancelada" <?php echo $prp->selectedIf($dados["situ"], "cancelada"); ?>>Cancelada</option>
        </select><br>
        <label>&nbsp;</label><input name="salvartarf" type="submit" value="Editar"><br>
        <?php echo $prp->get_msg(); ?>
    </fieldset>
</form>