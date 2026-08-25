<?php
/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 25/04/2025
 * Descricao: Opcoes para projetos
 */
?>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=projetos&ft=prp&pag=edit" accesskey="n">
            <img src="imagens/projetos.jpg" alt="Projeto Novo" title="Cria um projeto novo" style="width: 32px;"><br>
            Projeto Novo.
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=projetos&ft=prp&pag=list_est">
            <img src="imagens/lista_projetos.jpg" alt="Lista Estudo" title="Listar Projetos Programa&ccedil;&atilde;o em estudo" style="width: 32px;"><br>
            Listar em estudo.
        </a>
    </div>
    <?php
    if ($prp->get_codProj() != "") {
        if ($prp->get_situProj() != "x") {
            ?>
            <div id="elementoAdmin">
                <a href="index.php?st=pedidos&ft=prp&pag=edit&codproj=<?php echo $prp->get_codProj(); ?>">
                    <img src="imagens/editar.gif" alt="Pedido Novo" title="Cria um pedido novo para o projeto em foco" style="width: 32px;"><br>
                    Pedido Novo.
                </a>
            </div>
            <?php
        } else {
            ?>    
            <div id="elementoAdmin">
                <img src="imagens/desativar.gif" alt="Projeto Cancelado" title="Projeto Cancelado. Imposs&iacute;vel Criar Pedido Novo" style="width: 32px;"><br>
                Projeto Cancelado
            </div>
            <?php
        }
        ?><div id="elemento">
            <a href="index.php?st=projetos&ft=prp&pag=listped&codproj=<?php echo $prp->get_codProj(); ?>">
                <img src="imagens/editar.gif" alt="Lista Todos" title="Lista todos pedidos do projeto" style="width: 32px;"><br>
                Lista Pedido
            </a>
        </div>
        <?php
    }
    ?>
    <div id="elemento">
        <a href="index.php?st=projetos&ft=prp&pag=list">
            <img src="imagens/grupo.gif" alt="Listar Andamento" title="Listar Projetos Programa&ccedil;&atilde;o em andamento." style="width: 32px;"><br>
            Listar Projetos
        </a>
    </div>
    <div id="elemento">
        <a href="index.php?st=projetos&ft=prp&pag=list_all">
            <img src="imagens/grupo.gif" alt="Listar Todos" title="Listar todos projetos" style="width: 32px;"><br>
            Listar Todos Projetos
        </a>
    </div>
</div>