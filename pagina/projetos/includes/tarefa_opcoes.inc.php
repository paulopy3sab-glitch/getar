<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 26/04/2025
 * Descricao: Opcoes para tarefas
 */
?>
<div id="opcoes">
    <div id="elemento">
        <?php
        $prp->verificaPedido();
        if ($prp->get_situPed() != "cancelado") {
            ?>
            <a href="index.php?st=tarefas&ft=prp&pag=edit&codped=<?php echo $prp->get_codPed(); ?>" accesskey="n">
                <img src="imagens/novo.jpg" alt="Nova Tarefa" title="Criar nova tarefa para o pedido" style="width: 32px;"><br>
                Tarefa Nova.
            </a>
            <?php
        } else {
            ?>
            <img src="imagens/desativar.gif" alt="" title="" style="width: 32px;"><br>    
            Pedido Cancelado
            <?php
        }
        ?>
    </div>
    <div id="elemento">
        <a href="index.php?st=pedidos&ft=prp&pag=list_atv&codproj=<?php echo $prp->get_codProj(); ?>">
            <img src="imagens/livro.gif" alt="Listar Pedido"  title="Listar Pedido Ativos no Projeto" style="width: 32px;"><br>
            Listar Pedidos
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=tarefas&ft=prp&pag=list&codped=<?php echo $prp->get_codPed(); ?>">
            <img src="imagens/livro.gif" alt="Listar Tarefas" title="Listar Suas Tarefas em Andamento" style="width: 32px;"><br>
            Listar Tarefas
        </a>
    </div>
    <?php
    if (atrib("32")) {
        ?>
        <div id="elementoAdmin">
            <a href="index.php?st=tarefas&ft=prp&pag=list_adm&codped=<?php echo $prp->get_codPed(); ?>">
                <img src="imagens/livro.gif" alt="Listar Todas" title="Listar Todos Tarefas- N&iacute;vel Administrador" style="width: 32px;"><br>
                Listar Todos Tarefas
            </a>
        </div>
        <?php
    }
    ?>
    <div id="elemento">
        <a href="index.php?st=tarefas&ft=prp&pag=list_all&codped=<?php echo $prp->get_codped(); ?>">
            <img src="imagens/livro.gif" alt="" title="Listar Todas Suas Tarefas" style="width: 32px;"><br>
            Listar suas Tarefas
        </a>
    </div>
</div>