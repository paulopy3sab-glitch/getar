<?php
/*
 * Para Opcoes dos Operacionais cadastrados
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 22/12/2024
 */
?>
<div id="opcoes">
    <?php
    if ($opr->atrib("42")) {
        ?>
        <div id="elemento">
            <a href="index.php?st=opera&pag=edit" accesskey="n">
                <img src="imagens/novo.jpg" alt="Operacional Novo" title="Cria uma nova atividade Operacional"><br>
                Operacional Novo.
            </a>
        </div>
        <?php
    }
    ?>
    <div id="elemento">
        <a href="index.php?st=opera&pag=list">
            <img src="imagens/grupo.gif" alt="Lista Operacionais" title="Listar atividade Operacional"><br>
            Listar.
        </a>
    </div>
    <?php
    if ($opr->get_codOpera() != "") {
        ?>
        <div id="elemento">
            <a href="index.php?st=tarfopera&pag=list&codoper=<?php echo $opr->get_codOpera(); ?>">
                <img src="imagens/editar.gif" alt="Lista Todos" title="Lista todos tarefas da operacao"><br>
                Listar Tarefas
            </a>
        </div>
        <?php
    }
    ?>    
</div>