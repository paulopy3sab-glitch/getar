<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 27/04/2025
 * Descricao: Gerenciamento dos projetos, eletronicos e programacao
 */

//Ajustes de variaveis
if (isset($_GET['codproj'])) {
    $prp->set_codProj($_GET['codproj']);
}
if (isset($_GET['tag'])) {
    $prp->set_tag($_GET['tag']);
}
if (isset($_POST['pesq'])) {
    $cad->set_pesq($_POST['pesq']);
}
echo "<div class=\"titulo\">PROJETOS EM ANDAMENTO</div>";
if (isset($_POST["salvar"])) {
    $prp->set_codProj($_POST['codproj']);
    $prp->set_tag($_POST['tag']);
    $prp->set_nomeProj($_POST['nome']);
    $prp->set_codCliente($_POST['codCliente']);
    $prp->set_descr($_POST['descr']);
    $prp->set_situProj($_POST['situacao']);
    $prp->projSalvar();
}

#$complemento = $prp->projSwitch($pag);
$complemento = "";
switch ($pag) {
    case 'edit':
        $str = $prp->projEdit($prp->get_codProj());
        echo $str;
        $complemento = " AND tag= '" . $prp->get_tag() . "'
                                 AND cod= " . $prp->get_codProj();
        $prp->set_acao(" Projeto em Foco");
        break;
    case 'detal':
        $str = $prp->projDetal();
        $complemento = " AND cod= " . $prp->get_codProj();
        $prp->set_acao(" Projeto em Foco");
        break;
    case 'list':
        $complemento = " AND situacao NOT IN('temporario', 'fechado', 'cancelado') ORDER BY nome ASC";
        $prp->set_acao(" Projetos em Andamento");
        break;
    case 'list_est':
        $complemento = " AND situacao = 'estudo' ORDER BY nome ASC";
        $prp->set_acao(" Projeto em estudos");
        break;
    case 'list_u':
        $complemento = " ORDER BY cod DESC";
        $prp->set_acao(" Ultimos Projetos");
        break;
    case 'list_all':
        $complemento = " ORDER BY cod ASC";
        $prp->set_acao(" Todos Projetos");
        break;
    case 'list_pesq':
        $complemento = " AND nome LIKE '" . $_REQUEST['string'] . "%' ORDER BY nome ASC";
        $prp->set_acao(" em Pesquisa");
        break;
    case 'listped':
        $complemento = " AND cod= " . $prp->get_codProj();
        $prp->set_acao(" Projeto em Foco");
        break;
}

echo $prp->projLista($complemento, $prp->get_acao());
if ($pag == "edit" or $pag == "detal") {
    $complemento = " AND ped.situacao NOT IN('temporario', 'cancelado', 'concluido')
                             AND proj.tag = '" . $prp->get_tag() . "'
                             AND proj.cod =" . $prp->get_codProj();
    $resultado= $prp->pedLista($complemento);
    include './pagina/projetos/includes/pedido_list.inc.php';
    echo "<hr>";
}
if ($pag == "listped") {
    $complemento = " AND ped.situacao NOT IN('temporario')
                             AND proj.cod =" . $prp->get_codProj();
    $resultado= $prp->pedLista($complemento);
    include './pagina/projetos/includes/pedido_list.inc.php';
    echo "<hr>";
}
include './pagina/projetos/includes/projeto_opcoes.inc.php';
?>
