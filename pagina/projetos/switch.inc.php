<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date Outubro/2017
 * Descricao: Switch para projetos de programacao
 */

if (isset($_GET['ft'])) {
    switch ($_GET['ft']) {// para nao ficar repetindo para projetos-pedidos-tarefas
        case 'prp':
            include './pagina/projetos/trait_projcons.php';
            include './pagina/projetos/classe_projprog.php';
            include './pagina/estoque/funcoes_estoque.php';
            $prp = new projprog();
            //Para recarregar apos logado
            $prp->set_resp($resp);
            //Carregar atribuicoes
            $prp->carAtrib($resp);
            break;
    }
}

switch ($setor) {
    case "projetos":
        include './pagina/projetos/projetos.php';
        break;
    case "pedidos":
        include './pagina/projetos/pedidos.php';
        break;
    case "tarefas":
        include './pagina/projetos/tarefa.php';
        break;
}
