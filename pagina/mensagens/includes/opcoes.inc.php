<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 22/03/2025
 * Descricao: Opcoes de rodape para Mensagens
 */
?>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=mensagens&ft=mens&pag=nova" accesskey="n">
            <img src="imagens/mensagem_nova.jpg" alt="Nova Mensagem" title=""><br>
            Nova Mensagem
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=mensagens&ft=mens&pag=list_recb">
            <img src="imagens/mensagem_lida.jpg" alt="" title="Mensagens Recebidas"><br>
            Mensagens Recebidas
        </a>
    </div>
    <?php
    //Lista novas mensagens para administradores
    if (atrib("71")) {
        echo "<div id=\"elemento\">
                    <a href=\"index.php?st=mensagens&ft=mens&pag=contatos\">
                        <img src=\"imagens/mensagem_admin.jpg\" alt=\"Mensagens Administrativas\" title=\"Mensagens Administrativas\"><br>
                        Mensagens Administrativas
                    </a>
                </div>
                <div id=\"elemento\">
                    <a href=\"index.php?st=mensagens&ft=mens&pag=list_all\">
                        <img src=\"imagens/mensagem_admin.jpg\" alt=\"Todas\" title=\"Todas Mensagens Recebidas\"><br>
                        Todas Mensagens
                    </a>
                </div>";
    }
    ?>
    <div id="elemento">
        <a href="index.php?st=mensagens&ft=mens&pag=list_env">
            <img src="imagens/mensagem_enviada.jpg" alt="" title="Mensagens Enviadas"><br>
            Mensagens Enviadas
        </a>
    </div>
</div>