<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Outubro/2017
 * Descricao: Gerenciamento de artigos e dicas específicos do cliente
 * Junho/2024
 * Atualização e abandono de alguns conceitos obsoletos
 */

include './pagina/artigos/classe_artigos.php';
$artg = new Artigos;
//Salvando alteracoes
if (isset($_POST['salvarartg'])) {
    $artg->set_codArtg($_GET['codartg']);
    $chamada = $artg->html_texto($_POST['chamada']);
    $artg->set_chamada($chamada);
    $nome = $artg->html_texto($_POST['nome']);
    $artg->set_nomeArtg($nome);
    $artg->set_linhaArtg($_POST['lnartg']);
    $artg->set_sitacao($_POST['situacao']);

    //Salvar a edicao da segunda parte do artigo
    if (isset($_POST['rodape'])) {
        $rodape = $artg->html_texto($_POST['rodape']);
        $artg->set_rodape($rodape);
    }
    $artg->set_modelo($_POST['modelo']);
    //Conversoes 
    $titulo = $artg->html_texto($_POST['titulo']);
    $artg->set_titulo($titulo);
    $intro = $artg->html_texto($_POST['intro']);
    $artg->set_intro($intro);
    $artg->set_texto($_POST['texto']);
    $fonte = $artg->html_texto($_POST['fonte']);
    $artg->set_fonte($fonte);
    $artg->artgSalvar();
}

// Alterando a imagem da chamada
if (isset($_FILES['arquivoCh'])) {
    $codArtg = $_GET['codartg'];
    $artg->set_codArtg($codArtg);
    $arquivoCh = $_FILES['arquivoCh']['name'];
    if ($arquivoCh <> "") {
        #$imagem = $codArtg . "_" . $arquivoCh;
        $imagem = $arquivoCh;
        $artg->gravaImgCh($imagem);

        copy($_FILES['arquivoCh']['tmp_name'], $artg->get_localFotos() . $imagem);
        #$artg->geraThumb($imagem, "tmp-" . $imagem, '240');
    }
}

if (isset($_GET['pag'])) {
    $pag = $_GET['pag'];
} else {
    $pag = "";
}

if (isset($_GET['paglst'])) {
    $pagList = $_GET['paglst'];
} else {
    $pagList = "";
}

if (isset($_GET['linha'])) {
    $artg->set_linhaArtg($_GET['linha']);
} else {
    $artg->set_linhaArtg("geral");
}
if (isset($_GET['codartg'])) {
    $artg->set_codArtg($_GET['codartg']);
    $modelo = $artg->busca_modelo();
} elseif (isset($_GET['linha'])) {// entao criar um artigo novo
    $artg->artgNovo($pag, $_GET['linha']);
    $pag = 'edit';
}

$tipoList="Todos";
$complemento = " AND ch.situacao NOT IN('temporario')";

// listagem por linha
if (isset($_POST['lnartg']) && $_GET['pag'] == 'list') {
    $artg->set_linhaArtg($_POST['lnartg']);
    $pag = 'lstln';
}

switch ($pag) {
    case 'edit':
        $modelo = $artg->busca_modelo($artg->get_codArtg());
        if ($modelo == "fck") {
            /**
             * Como o modelo FCK trabalha com jQuery optei por
             *  trabalhar com um .inc pois caso contrario esta
             *  ficando muito complicado para acionar e manusear
             *  em POO.
             */
            include $artg->get_localFck() . 'fckeditor.php';
            include './pagina/artigos/includes/artigos-fck.inc.php';
        } else {
            echo $artg->artgEdit();
        }
        $complemento = " AND ch.cod= " . $artg->get_codArtg();
        break;
    case 'salvar':
        $complemento = " AND ch.cod= " . $artg->get_codArtg();
        break;
    case 'leitura':
        echo $artg->artgLeitura();
        $complemento = " AND ch.cod= " . $artg->get_codArtg();
        break;
    case 'pesq':
        include './pagina/artigos/includes/pesq.inc.php';
        $complemento = "  AND ch.situacao = 'ativo'
                          ORDER BY ch.cod DESC";
        break;
    case 'listpsqc':
        $tipoList= "\"".$_POST['string']."\"";
        $complemento = " AND rv.texto LIKE('%" . $_POST['string'] . "%')
                         AND ch.situacao = 'ativo'
                         ORDER BY ch.cod ASC";
        break;
    case 'listpsqt':
        $tipoList= "\"".$_POST['string']."\"";
        $complemento = " AND rv.intro LIKE('%" . $_POST['string'] . "%')
                         AND ch.situacao = 'ativo'
                         ORDER BY ch.cod ASC";
        break;
    case 'list':
        $tipoList="Primeiros";
        $complemento = " AND ch.situacao = 'ativo'
                                ORDER BY ch.cod ASC";
        break;
    case 'list_u':
        $tipoList="Ultimos";
        $complemento = "  AND ch.situacao = 'ativo'
                                ORDER BY ch.cod DESC";
        break;
    case 'listln':
        $tipoList= $_POST['lnartg'];
        $complemento = "  AND ch.linha= " . $_POST['lnartg'] . " ";
        break;
    case 'inatv':
        $tipoList="Inativos";
        echo $artg->artgAtv();
        break;
    default :
        $complemento = " AND ch.situacao NOT IN('temporario')";
}

include './pagina/artigos/includes/lista_artigos.inc.php';
echo "<hr>";
include './pagina/artigos/includes/rodape.inc.php';
