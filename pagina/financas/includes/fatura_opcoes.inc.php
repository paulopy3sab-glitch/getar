<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 05/05/2025
 * Descricao: Gerenciamento de um conta a pagar ou receber
 */
?>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=financaspr&ft=fnc&pag=carnenv&tipo=pagar" accesskey="n">
            <img src="imagens/novo.jpg" alt="Nova a Pagar"><br>
            Nova<br>
            Fatura a Pagar
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financaspr&ft=fnc&pag=carnenv&tipo=receber">
            <img src="imagens/novo.jpg" alt="Nova a Receber" ><br>
            Novo<br>
            Fatura a Receber
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financaspr&ft=fnc&pag=listvenc">
            <img src="imagens/listar_.jpg" alt="Lista Vencidas"><br>
            Listagem:<br />
            Vencidas
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financaspr&ft=fnc&pag=listabt">
            <img src="imagens/listar_.jpg" alt="Lista Aberta"><br>
            Listagem:<br />
            Abertas
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=financaspr&ft=fnc&pag=listmes&mes=<?php echo date('m'); ?>">
            <img src="imagens/listar_.jpg" alt="Lista Mes" title="Listar as do mes em curso"><br>
            Listagem:<br />
            <?php echo $fnc->mesExtBR(date('m')); ?>
        </a>
    </div>
</div>