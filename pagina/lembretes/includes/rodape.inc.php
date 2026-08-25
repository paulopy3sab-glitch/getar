<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 22/03/2025
 * Descricao: Opcoes de rodape para Lembretes
 */
?>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=lembretes&ft=mens&pag=nova" accesskey="n">
            <img src="imagens/mensagem_nova.jpg" alt="" border="no" height="32px"><br>
            Novo Lembrete
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=lembretes&ft=mens&pag=list">
            <img src="imagens/grupo.gif" alt="" border="no"><br>
            Lembretes Vencidos
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=lembretes&ft=mens&pag=list_env">
            <img src="imagens/grupo.gif" alt="" border="no"><br>
            Lembretes Enviados a Outros
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=lembretes&ft=mens&pag=list_agd">
            <img src="imagens/grupo.gif" alt="" border="no"><br>
            Lembretes Agendados
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=lembretes&ft=mens&pag=list_todos">
            <img src="imagens/grupo.gif" alt="" border="no"><br>
            Todos Seus Lembretes</a>
    </div>
    <?php
    //so disponibilizar para o administrador
    if ($lmb->atrib("71")) {
        echo " <div id=\"elemento\">
                        <a href=\"index.php?st=lembretes&ft=mens&pag=list_all\">
                            <img src=\"imagens/pesquisa1.gif\" alt=\"\" width=\"20\" height=\"16\" border=\"no\"><br>
                            Todos n&iacute;vel Administrador.</a>
                    </div>";
    }
    ?>
</div>