<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 27/04/2025
 * Descricao: Gerenciamento dos pedidos para projetos
 */

if (isset($_GET['codproj'])) {
    $prp->set_codProj($_GET['codproj']);
}

if (isset($_GET['codped'])) {
    $prp->set_codPed($_GET['codped']);
    $prp->busca_tag("");
}

if (isset($_GET['tag'])) {
    $prp->set_tag($_GET['tag']);
}

if (isset($_POST["salvarped"])) {
    $prp->set_codProj($_POST['codproj']);
    $prp->set_codPed($_POST['codped']);
    $prp->set_tituPed($_POST['titulo']);
    $prp->set_resp($_POST['resp']);
    $prp->set_docPed($_POST['doc']);
    $prp->set_situPed($_POST['situped']);
    $prp->set_priorPed($_POST['prior']);
    $prp->set_fatuPed($_POST['fatu']);
    //Trabalhando com as datas
    $prp->set_dataIni($_POST['dataini']);
    $prp->set_dataClc($_POST['dataclc']);

    $prp->pedSalvar();
}

echo $prp->pedCab();

switch ($pag) {
    case "edit":
        $dados= $prp->pedEdit($prp->get_codPed(), $prp->get_codProj());
        include './pagina/projetos/includes/pedido_edit.inc';
        echo $prp->pedComp();
        $complemento = " AND ped.cod= " . $prp->get_codPed();
        break;
    case "detal":
        echo $prp->pedEdit($prp->get_codPed(), $prp->get_codProj());
        echo $prp->pedComp();
        $complemento = " AND ped.cod= " . $prp->get_codPed();
        break;
    case 'list_atv':
        $complemento = " AND proj.cod = " . $this->get_codProj() . "
                                 AND ped.situacao IN('andamento', 'espera') ";
        break;
    case 'list':
        $complemento = " AND proj.cod = " . $this->get_codProj() . "
                                 AND ped.situacao NOT IN('cocluido', 'cancelado', 'estudo') ";
        break;
    case 'list_user':
        $complemento = " AND ped.resp = '" . $_SESSION['resp'] . "'
                                 AND ped.situacao NOT IN('concluido', 'cancelado') ";
        break;
    case 'list_and':
        $complemento = "AND ped.resp = '" . $_SESSION['resp'] . "'
                                AND ped.situacao = 'andamento'";
        break;
    case 'list_all':
        $complemento = "";
        break;
    default :
        $complemento = " ";
}

$resultado= $prp->pedLista($complemento);
if (!$prp->get_erro()) {
    include './pagina/projetos/includes/pedido_list.inc.php';
} else {
    echo "<br /><b>N&atilde;o h&aacute; pedidos ativos</b>";
}
echo "<hr>";
include './pagina/projetos/includes/pedido_opcoes.inc.php';
?>
