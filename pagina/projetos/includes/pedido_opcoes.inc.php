<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 25/04/2025
 * Descricao: Opcoes para pedidos
 */
?>
<div id="opcoes">
    <?php
//so disponibilizar para o administrador
    if (atrib("32")) {
        ?>
        <div id="elementoAdmin">
            <a href="index.php?st=pedidos&ft=prp&pag=list_all&codproj=<?php echo $prp->get_codProj(); ?>">
                <img src="imagens/lista.jpg" alt="" style="width: 32px;"><br> 
                Todos n&iacute;vel Administrador.
            </a>
        </div>
        <?php
        if ($prp->get_codProj() != "") {
            if ($prp->get_situProj() != "x") {
                ?>
                <div id="elementoAdmin">
                    <a href="index.php?st=pedidos&ft=prp&pag=edit&codproj=<?php echo $prp->get_codProj(); ?>">
                        <img src="imagens/editar.gif" alt="" style="width: 32px;"><br>
                        Pedido Novo.
                    </a>
                </div>
                <div id="elementoAdmin">
                    <a href="index.php?st=pedidos&ft=prp&pag=list_atv&codproj=<?php echo $prp->get_codProj(); ?>">
                        <img src="imagens/listar_.jpg" alt="" style="width: 32px;"><br>
                        Listar Pedidos Ativos do Projeto
                    </a>
                </div>
                <div id="elementoAdmin">
                    <a href="index.php?st=pedidos&ft=prp&pag=list&codproj=<?php echo $prp->get_codProj(); ?>">
                        <img src="imagens/listar_.jpg" alt=""  style="width: 32px;"><br>
                        Listar Pedidos<br>
                        p/ Projeto
                    </a>
                </div>
                <?php
            }
        }
    }
    ?>
    <div id="elemento">
        <a href="index.php?st=pedidos&ft=prp&pag=list_user">
            <img src="imagens/listar_plan.jpg" alt=""  style="width: 32px;"><br>
            Listar seus<br>
            Pedidos
        </a>
    </div>
    <?php
    if ($prp->get_codped() != "") {
        ?>
        <div id="elemento">
            <a href="index.php?st=tarefas&ft=prp&pag=list_all&codped=<?php echo $prp->get_codped(); ?>">
                <img src="imagens/listar_plan.jpg" alt="" title="Listar Todas Suas Tarefas" style="width: 32px;"><br>
                Listar suas Tarefas
            </a>
        </div>
        <?php
    }
    ?>
</div>