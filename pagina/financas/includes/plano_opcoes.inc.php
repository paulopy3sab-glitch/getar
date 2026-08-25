<?php
/*
 * Descricao: Opcoes para plano de Contas
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 03/05/2025
 */
?>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=financascc&ft=fnc&pag=editclasf" accesskey="n">
            <img src="imagens/novo.jpg" alt="Novo plano de contas" title="Novo plano de contas"><br>
            Novo plano de <br />
            contas
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financascc&ft=fnc&pag=listclasf&codctco=">
            <img src="imagens/listar_plan.jpg" alt="Listar Classificacoes" title="Listar Classificacoes para a conta corrente"><br>
            Plano de<br />
            Contas
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financascc&ft=fnc&pag=listccnome">
            <img src="imagens/listar_.jpg" alt="Listar Contas" title="Listar contas corrente"><br>
            Listar<br>
            Contas Correntes
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financascc&ft=fnc&pag=listlanca">
            <img src="imagens/editar.gif" alt="Fluxo de caixa" title="Listar lancamentos da conta corrente ativa"><br>
            Fluxo Caixa de<br />
            <?php echo $fnc->get_nomeConta(); ?>
        </a>
    </div>
</div>