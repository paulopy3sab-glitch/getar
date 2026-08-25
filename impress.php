<?php
session_start();

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: em torno de JUnho de 2016
 * Descricao: Destinado a uma leitura limpa de relatorio para fins de impressao
 * CARESSE DE REVISOES!!!!!!
 * Revisoes:      
 */
//Para exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

global $dirChave;
global $dirPChave;
$dirChave = "./funcoes/"; // reconfigurado em conex.inc.php
$dirPChave = "./config/"; // reconfigurado em conex.inc.php

/**
 * Controle do logon no sistema
 */
if (!isset($_SESSION['resp'])) {
    $_SESSION['resp'] = "visitante";
    $_SESSION['datalog'] = date("d/m/Y");
}
$resp = $_SESSION['resp'];
$datalog = $_SESSION['datalog'];

if (!isset($_GET['st'])) {
    $_GET['st'] = "";
}
if (!isset($_GET['pag'])) {
    $_GET['pag'] = "";
}

// arquvos de configuracao
include './config/conex.inc.php';
// apenas para continar trabalhando no modo extruturado
include $dirChave . 'funcoes.php';
include $dirChave . 'funcoes-geral.php';
include $dirChave . 'funcoes-conex.php';

// trabalhando em POO
// arquvos de configuracao
include './config/trait_personal.php';
include './config/classe_config.php';
// arquivos chave
include $dirChave . 'trait_geral.php';
include $dirChave . 'classe_conex.php';
include $dirChave . 'classe_cad.php';
include $dirChave . 'funcoes_cadcons.php';
// arquivo de configuracao personalizado
include $dirPChave . 'classe_pcad.php';

$cad = new Pcadastro();
$msg = "";
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
} else {
    $acao = "";
}

/**
 * Logon/logoff de usuario
 */
if ($acao == "logof" && isset($_SESSION['resp'])) {
    $msg = $cad->logof_sis();
    session_start();
    $resp = "visitante";
    $_SESSION['resp'] = "visitante";
    $datalog = date("d/m/Y");
    $_SESSION['datalog'] = date("d/m/Y");
    //Redirecionar para novo logon se configurado
    if ($cad->get_dirRaiz() <> "") {
        $redirect = $cad->get_dirRaiz();
        header("location:$redirect");
        die();
    }
}

//logon redirecionado via GET
if (isset($_GET['rd'])) {
    $red = $_GET['rd'];
    $cad->logon_Redir($red);
    $resp = $cad->get_resp();
    $datalog = $cad->get_datalog();
    $_GET['st'] = "boasvindas";
    $_GET['ft'] = "bvnd";
    $_GET['pag'] = "";
}

//logon solicitado por POST
if (isset($_POST['user'])) {
    $cad->set_nick($_POST['user']);
    $cad->set_senha($_POST['senha']);
    $msg = $cad->logon_sis();
    if ($cad->get_urlRedrt() <> "") {
        $redirect = $cad->get_urlRedrt();
        header("location:$redirect");
        die();
    }
    $resp = $cad->get_resp();
    $datalog = $cad->get_datalog();
    $_GET['st'] = "boasvindas";
    $_GET['ft'] = "bvnd";
    $_GET['pag'] = "";
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $cad->get_tituloPag(); ?></title>
        <meta charset="utf-8" />
        <meta name="robots" content="noindex,nofollow">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">

        <!-- Redirecionar para vesao mobile -->
        <script type="text/javascript">
            var url_mobile = "m-index.php<?php echo "?" . $_SERVER['QUERY_STRING']; ?>";
            (function(a, b) {
                if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4)))
                    window.location = b
            })(navigator.userAgent || navigator.vendor || window.opera, url_mobile);
        </script>

        <link rel="icon" href="Mouse-SCHW.jpg" type="image/x-icon" />
        <link rel="shortcut icon" href="Mouse-SCHW.jpg" type="image/x-icon" />
        <?php
        if (isset($_GET['st'])) {
            switch ($_GET['st']) {
                case 'artigos':
                    ?>
                    <script type="" language="javascript" src="pagina/artigos/funcoes_artigos.js"></script>
                    <?php
                    break;
                case 'cadastro':
                    ?>
                    <script type="" language="javascript" src="<?php echo $dirChave; ?>funcoes_cadastro.js"></script>
                    <?php
                    break;
            }
        }
        ?>
    </head>

    <body>

        <?php
        if (isset($_GET['st'])) {
            $setor = $_GET["st"];
        } else {
            $setor = "boasvindas";
        }
        switch ($setor) {
            case "cadastro":
                include("pagina/cadastros/cadastro.php");
                break;
            case "estoque":
                include("pagina/estoque/impress.inc.php");
                break;
            case "categ":
                include("pagina/estoque/categ.php");
                break;
            case "ordm":
                include './pagina/estoque/funcoes_estoque.php';
                include './pagina/oscontrol/impress.inc.php';
                break;
            case "etiqueta":
                include './pagina/oscontrol/etiqueta.inc.php';
                break;
            case "decla":
                include './pagina/oscontrol/decla.inc.php';
                break;
            case "eqp":
                include("pagina/oscontrol/equipamento.php");
                break;
            case "clasf":
                include("pagina/cadastros/clasf.php");
                break;
            case "ingresso":
                include("pagina/cadastros/ingresso.php");
                break;
            case "artigos":
                include("pagina/artigos/artigos.php");
                break;
            case "proj_eletro":
                include("pagina/proj_eletro/projeto.php");
                break;
            case "ped_eletro":
                include("pagina/proj_eletro/pedido.php");
                break;
            case "tarf_eletro":
                include("pagina/proj_eletro/tarefa.php");
                break;
            case "projetos":
                include("pagina/projetos/projeto.php");
                break;
            case "pedidos":
                include("pagina/projetos/pedido.php");
                break;
            case "tarefas":
                include("pagina/projetos/tarefa.php");
                break;
            case "relato_tarefas":
                include("pagina/relato_tarefa.php");
                break;
            case "relato_projetos":
                include("pagina/relato_projetos.php");
                break;
            case "mensagens":
                include("pagina/mensagens/mensg.php");
                break;
            case "lembretes":
                include("pagina/mensagens/lembre.php");
                break;
            case "conta_pagrecb":
                include("pagina/financas/conta_pagrecb.php");
                break;
            case "contanome":
                include("pagina/financas/contanome.php");
                break;
            case "contacor":
                include("pagina/financas/contacor.php");
                break;
            case "contacarne":
                include("pagina/financas/contacarne.php");
                break;
            case "contacor_def":
                include("pagina/financas/contacor_def.php");
                break;
            case "contaclasf":
                include("pagina/financas/contaclasf.php");
                break;
            case "plano_atrib":
                include("pagina/atribuicoes/atribuicoes.php");
                break;
        }
        ?>
    </body>
</html>
