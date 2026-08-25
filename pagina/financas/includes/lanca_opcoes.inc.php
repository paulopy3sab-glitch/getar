<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 03/05/2025
 * Descricao: opcoes dos lancamentos dos C/C
 */
?>
<div id="opcoes">
    <div id="elemento">
        <img src="imagens/moedas.png" alt="Nova conta corrente" title="Nova Conta Corrente"><br>
        Saldo:<br/>
        <?php
        if (isset($dados['peratu'])) {
            echo $fnc->lancaTotPer($dados['peratu']);
        }
        ?>
    </div>
    <div id="elemento">
        <a href="index.php?st=financascc&ft=fnc&pag=editlanca&codlanca=&codctco=<?php echo $fnc->get_codCtCo(); ?>" accesskey="n">
            <img src="imagens/editar.gif" alt="Novo Lancamento" title="Novo Lancamento na conta corrente"><br>
            Novo lan&ccedil;amento<br />
            <?php echo $fnc->get_nomeConta(); ?>
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financascc&ft=fnc&pag=listlanca">
            <img src="imagens/editar.gif" alt="Fluxo de caixa" title="Listar lancamentos da conta corrente ativa"><br>
            Fluxo Caixa de<br />
            <?php echo $fnc->get_nomeConta(); ?>
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financascc&ft=fnc&pag=listperant">
            <img src="imagens/listar_.jpg" alt="Periodos de Caixa" title="Listar Periodos da conta corrente"><br>
            Periodos Anteriores de<br />
            <?php echo $fnc->get_nomeConta(); ?>
        </a>
    </div>
</div>