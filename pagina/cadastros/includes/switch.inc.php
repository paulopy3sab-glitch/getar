<?php

/*
 * Para comandos cf $
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 05/08/2024
 */
$complemento = "";
$cadNovo = FALSE;
switch ($pag) {
    case "edit":
        $dados = $cad->cadEdit();
        //Ocultando os cadatros particulares que nao sao do logado
        if (($dados['cod'] <> $cad->get_codCad()) OR ( $cad->ocultaPart($dados))) {
            echo "<b style=\"color: red\">Nenhum registro para o codigo " . $cad->get_codCad() . "</b>";
        } else {
            include './pagina/cadastros/includes/cad_edit.inc.php';
        }
        $complemento = " AND cod = " . $cad->get_codCad() . " ";
        break;
    case "cad":
        $cadNovo = TRUE;
        $cad->set_codCad("");
        $dados = $cad->cadEdit();
        include './pagina/cadastros/includes/cad_edit.inc.php';
        $complemento = "  AND cod = " . $cad->get_codCad() . " ";
        break;
    case "fnedt":
        $cad->set_codTel($_GET['fnedt']);
        $dados = $cad->foneEdit();
        include './pagina/cadastros/includes/fone_edit.inc.php';
        break;
    case "fnexc":
        $cad->set_codTel($_GET['fnexc']);
        $cad->foneExcl();
        $dados = $cad->cadEdit();
        include './pagina/cadastros/includes/cad_edit.inc.php';
        $complemento = " AND cod = " . $cad->get_codCad();
        break;
    case "emedt":
        $cad->set_codEml($_GET['emedt']);
        $dados = $cad->emailEdit();
        include './pagina/cadastros/includes/email_edit.inc.php';
        break;
    case "emexc":
        $cad->set_codEml($_GET['emexc']);
        $cad->emailExcl();
        $dados = $cad->cadEdit();
        include './pagina/cadastros/includes/cad_edit.inc.php';
        $complemento = " AND cod = " . $cad->get_codCad();
        break;
    case "stedt":
        $cad->set_codSite($_GET['stedt']);
        $dados = $cad->siteEdit();
        include './pagina/cadastros//includes/site_edit.inc.php';
        break;
    case "stexc":
        $cad->set_codSite($_GET['stexc']);
        $cad->siteExcl();
        $dados = $cad->cadEdit();
        include './pagina/cadastros/includes/cad_edit.inc.php';
        $complemento = " AND cod = " . $cad->get_codCad();
        break;
    case "detal":
        echo $cad->cadDetal();
        $complemento = " AND cod = " . $cad->get_codCad();
        break;
    case 'excl':
        excluir();
        $complemento = " ORDER BY cod DESC";
        break;
    case "ingr":
        $cad->set_nick($_GET['nick']);
        echo " <span class='titulo'>Dados do logon</span><br>";
        echo $cad->ingressoEdit();
        //lista somente um cadastro - editando um logon
        $complemento = " AND cod = " . $cad->get_codCad() . " ";
        break;
    case 'list':
        $complemento = " AND situacao = 'ativo' ";
        break;
    case 'listff':
        $complemento = " AND situacao = 'ativo'
                         AND clasf IN('r', 'b')";
        break;
    case 'listall':
        $complemento = " ";
        break;
    case 'listu':
        $complemento = " ORDER BY cod DESC";
        break;
    case 'listcli':
        $complemento = " AND cad.clasf = 'c' ORDER BY cod DESC";
        break;
    case 'listlog':
        $complemento = " AND cad.cod IN(SELECT codcad FROM getar_control) ORDER BY cod DESC";
        break;
    case 'pesq':
        $complemento = " AND nome LIKE '" . $cad->get_pesq() . "%' ORDER BY nome";
        break;
    case 'psqcpf':
        $complemento = " AND cpcn LIKE '" . $cad->get_pesq() . "%' ORDER BY nome";
        break;
    case 'psqdsd':
        $complemento = " AND desde = '" . $cad->get_pesq() . "' ORDER BY nome";
        break;
    case 'listingr':
        $complemento = "";
        break;
    default :
        $complemento = " AND situacao = 'ativo' ";
        break;
}

if ($cad->cadRestr() == "") {
    
} else {
    $pag = "list";
}
?>