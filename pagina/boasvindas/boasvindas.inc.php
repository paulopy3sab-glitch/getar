<?php

/*
 * Descricao: Include personalizado para tela de boas vindas
 * Obs.: Ao contrario da ideologia de trabalhar em POO, nao vi outra maneira de 
 * atender tamanha diferenca de personalizacao.
 * Data Criacao: 30/09/2016
 * Cliente: SCHW Informatica
 * Revisoes:
 */
global $boasVnd;

if ($boasVnd->atrib("1")) {
    // echo $cad->aniver();
    // echo $cad->novoHoje();
}
//Pagina inicial
if ($boasVnd->atrib("61")) {//financeiro
    $resultado= $boasVnd->listParcela();
    include './pagina/boasvindas/includes/faturas.inc.php';
}
if ($boasVnd->atrib("73")) {
    echo $boasVnd->listLembre();
}
if ($boasVnd->atrib("21")) {
    echo $boasVnd->listPedidos(); //Pedidos estoque
}
if ($boasVnd->atrib("11")) {
    echo $boasVnd->listOS();
    echo $boasVnd->listTarOS(); //tarefas de OS
    echo $boasVnd->listTarErro(); //tarefas de OS
}
if ($boasVnd->atrib("31")) {
    echo $boasVnd->listPedProg(); //pedido de programacao/designer
    echo $boasVnd->listTarPro(); //tarefas de programacao/designer em aberto
}

echo $boasVnd->listPedEletro();
echo $boasVnd->listTarEletro();

if ($boasVnd->atrib("41")) {
    //echo $boasVnd->listOperaOld(); //para atividades operacionais
    echo $boasVnd->listOpera(); //para atividades operacionais
    echo $boasVnd->listTarfOpera();
}

/**
 * Rodape personalizado para Boas vindas
 */
echo "<hr>";
$str = "<div id=\"opcoes\">";
if (atrib("3")) {

    $str .= "<div id=\"elemento\">
                        <a href=\"index.php?st=cadastro&pag=cad\" accesskey=\"n\">
                            <img src=\"imagens/novo.jpg\" alt=\"Novo\" titlie=\"Cadastro Novo\" ><br>
                            Cadastro Novo
                        </a>
                    </div>";
}

//if (atrib("5")) {
$str .= "<div id=\"elementoAdmin\">
                <a href=\"index.php?st=cadastro&pag=listff\">
                    <img src=\"imagens/lista.jpg\"  alt=\"\" title=\"Listar Fornecedores/Fabricantes\"><br>
                    Listar fornecedores, fabricantes
                </a>
            </div>
            <div id=\"elemento\">
            <form action=\"index.php?st=estoque&pag=pesq\" method=\"post\">
                <input type=\"hidden\" name=\"pag\" value=\"pesq\">
                <input type=\"hidden\" name=\"pagina\" value=\"\">
                <img src=\"imagens/pesquisa1.gif\" alt=\"\"><br />Estoque: por Descri&ccedil;&atilde;o<br>
                <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"10\" accesskey=\"p\">
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>
        <div id=\"elemento\">
            <form action=\"index.php\" method=\"get\">
                <input type=\"hidden\" name=\"st\" value=\"estoque\">
                <input type=\"hidden\" name=\"pag\" value=\"edit\">
                <img src=\"imagens/pesquisa1.gif\" alt=\"\"><br />Estoque: por C&oacute;digo<br>
                <input name=\"codestq\" type=\"number\" size=\"12\" maxlength=\"10\" accesskey=\"c\">
                <input name=\"Listar\" type=\"submit\" value=\"OK\">
            </form>
        </div>";
//}

$str.= "<div id=\"elemento\">
        <form action=\"index.php?st=eqp&pag=pesq\" method=\"post\">
            <input type=\"hidden\" name=\"pag\" value=\"pesq\">
            <input type=\"hidden\" name=\"pagina\" value=\"\">
            <img src=\"imagens/pesquisa1.gif\" alt=\"\"><br />
            Por Modelo Equipamento<br>
            <input name=\"string\" type=\"text\" size=\"12\" maxlength=\"10\">
            <input name=\"Listar\" type=\"submit\" value=\"OK\">
        </form>
    </div>
    <div id=\"elemento\">
        <form action=\"index.php\" method=\"get\">
            <input type=\"hidden\" name=\"st\" value=\"ordm\">
            <input type=\"hidden\" name=\"pag\" value=\"edit\">
            <img src=\"imagens/pesquisa1.gif\" alt=\"\"><br />
            Por C&oacute;digo OS<br>
            <input name=\"codos\" type=\"number\" size=\"12\" maxlength=\"10\">
            <input name=\"Listar\" type=\"submit\" value=\"OK\">
        </form>
    </div>
    </div>";

if ($cad->atrib("1")) {
    echo $str;
}
