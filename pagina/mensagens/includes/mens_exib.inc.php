<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 31/03/2025
 * Descricao: Para edicao e envio de Mensagens
 */

$dados = $lmb->mensExib();
?>
<div class="titulo">LENDO UM MENSAGEM</div>
<fieldset>
    <legend>Detalhe da Mensagem</legend>
    <label>C&oacute;digo da Mensagem: </label><b><?php echo $dados['cod']; ?></b><br>
    <label>Titulo da Mensagem: </label><b><?php echo $dados['titulo']; ?></b><br />
    <label>Data da postagem: </label><b><?php echo $dados['data']; ?></b><br>
    <label>Remetente: </label><b><?php echo $dados['remt']; ?></b><br>
    <label>Destinatario: </label><b><?php echo $dados['dest']; ?></b><br>
    <label>Conte&uacute;do da Mensagem.</label>
    <!--<a href=\"index.php?st=mensagens&ft=mens&pag=excl&codmens=" . $dados["cod"] . "\">
       <img src=\"imagens/lixo.gif\" alt=\"Excluir\" title=\"Excluir Mensagem\" />
    </a>-->
    <textarea rows="10" cols="45" readonly><?php echo devolve_texto($dados['texto']); ?></textarea><br>
</fieldset>";

