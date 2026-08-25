<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Outubro/2017
 * Descricao: Switch para gerenciamento de equipamentos e OSs
 */

include './pagina/proj_eletro/trait_precons.php';
include './pagina/proj_eletro/classe_projeletro.php';
$pre = new Projeletro();
//Para recarregar apos logado
$pre->set_resp($resp);
//Carregar atribuicoes
$pre->carAtrib($resp);

//Ajustes de variaveis
if (isset($_GET['codproj'])) {
    $pre->set_codProj($_GET['codproj']);
} else {
    $codproj = "";
}

if (isset($_GET['codped'])) {
    $codPed = $_GET['codped'];
    $pre->set_codPed($codPed);
} else {
    $codPed = 0;
}

if (isset($_GET['codTarefa'])) {
    $codTarefa = $_GET['codTarefa'];
    $pre->set_codTarf($codTarefa);
} else {
    $codTarefa = "";
}

switch ($setor) {

    case "proj_eletro":
        echo "<div class=\"titulo\">PROJETOS ELETR&Ocirc;NICOS</div>";
        echo "<div class=\"titulo\"><b style=\"text-align: center; color: red; font-weight: bold;\">&Aacute;REA OBSOLETA</b></div>";
        
        if (isset($_POST['salvar'])) {
            $pre->set_nomeProj($_POST['nome']);
            $pre->set_codCliente($_POST['codCliente']);
            $pre->set_descrProj($_POST['descr']);
            $pre->set_situProj($_POST['situacao']);
            $pre->projSalvar();
        }
        $acao = "Projetos em Andamento";
        if ($pag == "edit") {
            echo $pre->projEdit();
        }
        if ($pag == "detal") {
            echo $pre->projDetal();
        }
        if ($pag == "edit" || $pag == "detal") {
            $complemento= " AND codproj= " . $pre->get_codProj() . " 
                            AND situacao NOT IN('x', 'c')";
            echo $pre->pedLista($complemento);
        }
        $complemento = $pre->projSwitch($pag);
        echo "<hr>";
        echo $pre->projLista($complemento, $acao);
        echo $pre->projOpcoes();
        break;
    case "ped_eletro":
        //Para detalhamento dos pedidos de componentes
        include './pagina/estoque/funcoes_estoque.php';
        if (isset($_POST["salvar"])) {
            $dia_ini = $_POST['diaini'];
            $mes_ini = $_POST['mesini'];
            $ano_ini = $_POST['anoini'];
            $data_ini = $ano_ini . "-" . $mes_ini . "-" . $dia_ini;
            $pre->set_dataIni($data_ini);

            $dia_cls = $_POST['diaclc'];
            $mes_cls = $_POST['mesclc'];
            $ano_cls = $_POST['anoclc'];
            $data_cls = $ano_cls . "-" . $mes_cls . "-" . $dia_cls;
            $pre->set_dataClc($data_cls);

            //setar primeiro o codido do pedido pois este ja fixo o titulo do pedido
            $pre->set_codPed($_POST['codped']);
            $pre->set_tituPed($_POST['titulo']);
            $pre->set_resp($_POST['resp']);
            $pre->set_situPed($_POST['situped']);
            $pre->set_priorPed($_POST['prioridade']);
            $pre->set_fatuPed($_POST['fatura']);
            $pre->set_docPed($_POST['doc']);

            $pre->pedSalvar();
        }
        echo "<div class=\"titulo\">PEDIDOS - Projetos Eletr&ocirc;nicos</div>
            <div class=\"titulo\"><b style=\"text-align: center; color: red; font-weight: bold;\">&Aacute;REA OBSOLETA</b></div>
              <div class=\"sub-titulo\">Projeto:<b>" . $pre->get_nomeProj() . "</b>
                  <a href=\"index.php?st=proj_eletro&ft=pre&pag=edit&codproj=" . $pre->get_codProj() . "\">
                      <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                  </a>
              </div>";
        if ($pag == "edit") {
            echo $pre->pedEdit();
            echo $pre->pedComp();
        }
        $complemento = $pre->pedSwitch($pag);
        echo "<hr>";
        echo $pre->pedLista($complemento);
        echo $pre->pedOpcoes();
        break;
    case "tarf_eletro":
        if (isset($_POST['salvar'])) {
            $pre->set_horaIni($_POST['horaini']);
            $pre->set_horaFim($_POST['horafim']);
            $pre->set_respTarf($_POST['resp']);
            $pre->set_docTarf($_POST['doc']);
            $pre->set_situTarf($_POST['situacao']);
            $pre->set_codTarf($_GET['codTarefa']);
            
            $pre->tarfSalvar();
        }
        echo "<div class=\"titulo\">TAREFAS - Projetos Eletr&ocirc;nicos</div>
              <div class=\"sub-titulo\">Projeto:<b>" . $pre->get_nomeProj() . "</b>
                  <a href=\"index.php?st=proj_eletro&ft=pre&pag=edit&codproj=" . $pre->get_codProj() . "\">
                      <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                  </a>
              </div>
              <div class=\"sub-titulo\">Titulo Pedido:<b>" . $pre->get_tituPed() . "</b>
                  <a href=\"index.php?st=ped_eletro&ft=pre&pag=edit&codped=" . $pre->get_codPed() . "&codproj=" . $pre->get_codPed() . "\">
                      <img src=\"imagens/editar.gif\" alt=\"\" border=\"0\">
                  </a>
              </div>";
        if ($pag == "edit") {
            echo $pre->tarfEdit();
        }
        $complemento = $pre->tarfSwitch($pag);
        echo "<hr>";
        echo $pre->tarfLista($complemento);
        echo $pre->tarfOpcoes();
        break;
}
