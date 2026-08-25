<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao:
 * @date 27/04/2025
 * Descricao: Gerenciamento das tarefas
 */
if (isset($_GET['codTarefa'])) {
    $prp->set_codTarf($_GET['codTarefa']);
}
if (isset($_GET['codped'])) {
    $prp->set_codPed($_GET['codped']);
    $prp->set_respTarf($_SESSION['resp']);
}
if (isset($_POST["salvartarf"])) {
    // fixar o responsavel da tarefa como o logado pois eh este que esta salvando
    $prp->set_respTarf($_SESSION['resp']);
    $prp->set_horaIni($_POST['horaini']);
    $prp->set_docTarf($_POST['doc']);
    $prp->set_statusTarf($_POST['situacao']);
    $prp->set_codTarf($_GET['codTarefa']);
    //Verificacoes
    if ($_POST['situacao'] == "concluido") {
        if ($_POST['horafim'] == "0:00" || $_POST['horafim'] == "") {
            $prp->set_horaFim("CURTIME()");
        } else {
            $horaFim = "'" . $_POST['horafim'] . "'";
            $prp->set_horaFim($horaFim);
        }
    } else {
        if ($_POST['horafim'] == "") {
            $prp->set_horaFim("'00:00'");
        } else {
            $horaFim = "'" . $_POST['horafim'] . "'";
            $prp->set_horaFim($horaFim);
        }
    }

    $prp->tarfSalvar();
}
echo $prp->tarfCab();
# $complemento = $prp->tarfSwitch($pag);
$complemento = "";
switch ($pag) {
    case 'edit':
        $dados= $prp->tarfEdit();
        include './pagina/projetos/includes/tarefa_edit.inc';
        break;
    case 'detalhar':
        echo $prp->tarfDetal();
        break;
    case 'list':
        $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                                 AND situacao = 'andamento' ";
        break;
    case 'list_all':
        $complemento = " AND resp= '" . $_SESSION['resp'] . "'
                         AND situacao IN('andamento', 'concluido') ";
        break;
    case 'list_adm':
        $complemento = " ";
        break;
}
$resultado = $prp->tarfLista($complemento);
include './pagina/projetos/includes/tarefa_list.inc.php';
echo "<hr>";
include './pagina/projetos/includes/tarefa_opcoes.inc.php';
?>
