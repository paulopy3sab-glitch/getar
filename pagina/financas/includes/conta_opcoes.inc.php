<?php
/*
 * Descricao: Opcoes para C/C Contas Corrente
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 16/04/2025
 */
?>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=financascc&ft=fnc&pag=editcor" accesskey="n">
            <img src="imagens/novo.jpg" alt="Nova conta corrente" title="Nova Conta Corrente"><br>
            Nova Conta Corrente
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financascc&ft=fnc&pag=listcor">
            <img src="imagens/listar_.jpg" alt="Listar Contas" title="Listar contas corrente"><br>
            Listar<br>
            Contas Ativas
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
        <a href="index.php?st=financascc&ft=fnc&pag=listperativo">
            <img src="imagens/listar_plan.jpg" alt="Listar Periodos" title="Listar periodos das contas corrente"><br>
            Listar<br>
            Per&iacute;odos Ativos
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
        <a href="index.php?st=financascc&ft=fnc&pag=listlanca">
            <img src="imagens/editar.gif" alt="Fluxo de caixa" title="Listar lancamentos da conta corrente ativa"><br>
            Fluxo Caixa de<br />
            <?php echo $fnc->get_nomeConta(); ?>
        </a>
    </div>
</div>