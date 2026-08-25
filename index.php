<?php
session_start();

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: indeterminada, meados de Maio de 2008
 * Descricao: arquivo chave para chamada de todos os modulos
 * Revisoes: Junho/2016 - pregis
 * reestruturacao em POO
 *           11/09/2016 - pregis
 * importar classe Cadastro do Petra
 *           06/08/2024 - pregis
 * Retirado o padrao $str da classe_cadastro, para melhor acompanhamento HTML
 * Retirada de compos obsoletos, ver artigo no Bloge "O Programador Basic"      
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
//include $dirChave . 'classe_cad.php';
include './pagina/cadastros/classe_cad.php';
include './pagina/cadastros/funcoes_cadcons.php';
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
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/tabela.css" rel="stylesheet" type="text/css">
        <link href="css/formulario.css" rel="stylesheet" type="text/css">
        <!--personalizacoes do cliente -->
        <link href="config/pstyle.css" rel="stylesheet" type="text/css">

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
        <script type="" language="javascript" src="<?php echo $dirChave; ?>funcoes.js"></script>
        <script type="text/javascript" language="Javascript">
            function ocultaTodos() {
                /*  Esta funcao e para ocultar todas as divs
                 para restabeler o padrao */
                document.getElementById("contaCorrente").style.display = "none";
                document.getElementById("adminProjeto").style.display = "none";
            }
        </script>
        <?php
        // JavaScripts para os modulos carregados
        if (isset($_GET['ft'])) {
            switch ($_GET['ft']) {
                case 'lmb':
                    ?>
                    <script type="" language="javascript" src="pagina/mensagens/funcoes_mesg.js"></script>
                    <?php
                    break;
                case 'prp':
                    ?>
                    <script type="" language="javascript" src="pagina/projetos/funcoes_projetos.js"></script>
                    <?php
                    break;
                case 'pre':
                    ?>
                    <script type="" language="javascript" src="pagina/projetos/funcoes_projetos.js"></script>
                    <?php
                    break;
                case 'fnc':
                    ?>
                    <script type="" language="javascript" src="pagina/financas/funcoes_financas.js"></script>
                    <?php
                    break;
                case 'mens':
                    ?>
                    <script type="" language="javascript" src="pagina/mensagens/funcoes_mesg.js"></script>
                    <?php
                    break;
            }
        }

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
        <div id="principal">
            <div id="cabecalho">
                <div id="logo">
                    <div style="padding-left: 8px; float: left;">
                        <img src="./imagens/LogoGETAR-qd.png" style="height: 82px;" alt="Logo GETAR" />
                    </div>
                    <div style="padding-left: 328px;">
                        <?php echo $cad->cabecalho(); ?>
                    </div>
                </div>
                <?php
                //Verificar se logado
                if (!$cad->user_validacao()) {
                    echo "</div>"; // fecha o cabecalho
                    ?>
                    <div class="logon">
                        <div>
                            <h1 style="color: brown; text-align: center; font-family: cursive">
                                Servidor<br />
                                <?php echo $cad->get_servLc(); ?>
                            </h1>
                        </div>
                        <div id="logoQd">                    
                            <?php echo $cad->logoPrin(); ?>
                        </div>
                        <div id="formLog">
                            <form action="index.php?acao=logon" method="post">
                                <fieldset>
                                    <legend>Logon no sistema</legend>
                                    <?php echo $cad->get_msgLog(); ?><br/>
                                    <label>Usu&aacute;rio: </label>
                                    <input name="user" type="text" placeholder="usuario" required autocomplete="off" tabindex="1" autofocus="" size="22" maxlength="20"><br />
                                    <label>Senha: </label>
                                    <input name="senha" type="password" placeholder="senha" required tabindex="2" size="22" maxlength="20"><br />
                                    <label>&nbsp;</label><input name="entrar" type="Submit" value="Entrar">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <br style="clear: both;" />
                    <?php
                    echo $cad->rodape();
                    die();
                } else {
                    //Para recarregar apos logado
                    $cad->set_resp($resp);
                    // Registrando ultima atividade
                    $cad->gravaUlt();
                    //Carregar atribuicoes via POO
                    $cad->carAtrib($resp);
                    //Passando para a parte Estruturada
                    global $arrayAtribEst;
                    $arrayAtribEst = $cad->arrayAtrib;
                    ?>
                    <div id="cablinks">
                        <span>GETAR Vers&atilde;o: 4.0.0</span> -&nbsp;
                        <span><?php echo $resp; ?></span>
                        <?php
                        if ($cad->atrib("72")) {
                            echo $cad->verificaMensagens($resp);
                        }
                        if ($cad->atrib("31")) {
                            echo $cad->verificaContatos();
                        }
                        if ($cad->atrib("73")) {
                            echo $cad->verificaLembretes($resp);
                        }
                        ?>
                        &nbsp;- <a href="index.php?acao=logof">Sair</a>
                    </div>
                </div>
                <?php
            }
            ?>
            <div id="menu">
                <ul>
                    <li><a href="index.php?st=boasvindas&ft=bvnd&pag=">Inicio</a></li>
                    <?php
                    if ($cad->atrib("1")) {
                        ?>
                        <li><a href="#">Cadastro</a>
                            <ul>
                                <li><a href="index.php?st=cadastro&pag=listcli">Clintes</a>
                                <li><a href="index.php?st=cadastro&pag=listu">Cadastro</a>
                                <li><a href="index.php?st=cadastro&pag=listlog">Corporativo</a>
                                    <?php
                                    if ($cad->get_resp() == "admin") {
                                        ?>
                                    <li><a href="index.php?st=cadastro&pag=listprim">Primeiros</a>
                                        <?php
                                    }
                                    ?>

                            </ul>
                        </li>                        
                        <?php
                    }
                    if ($cad->atrib("81")) {
                        ?>
                        <li><a href="#">Artigos</a>
                            <ul>
                                <li><a href="index.php?st=artigos&pag=list_u">Listar Artigos</a></li>
                                <li><a href="index.php?st=artigos&pag=pesq">Pesquisas nos Artigos</a></li>
                            </ul>
                        </li>
                        <?php
                    }
                    if ($cad->atrib("41")) {
                        ?>
                        <li><a href="#">Atv. Operacionais</a>
                            <ul>
                                <li><a href="index.php?st=opera&pag=list">Atv. Operacionais</a></li>
                                <li><a href="index.php?st=relato_tarefas&pag=&resp=">Relat&oacute;rio de Tarefas</a></li>
                            </ul>
                        </li>
                        <?php
                    }
                    if ($cad->atrib("73")) {
                        ?>
                        <li><a href="index.php?st=lembretes&ft=mens&pag=list">Lembretes</a></li>
                        <?php
                    }
                    if ($cad->atrib("72")) {
                        ?>
                        <li><a href="index.php?st=mensagens&ft=mens&pag=list">Mensagens</a></li>
                        <?php
                    }
                    if ($cad->atrib("111")) {
                        ?>
                        <li><a href="index.php?st=veiculo&ft=mens&pag=list">Veiculos</a></li>
                        <?php
                    }
                    if ($cad->atrib("31") or $cad->atrib("41")) {
                        ?>
                        <li><a href="#">Projetos</a>
                            <ul>
                                <?php
                                if ($cad->atrib("31")) {
                                    ?>
                                    <li><a href="index.php?st=projetos&ft=prp&pag=list">Projetos</a></li>
                                    <li><a href="index.php?st=pedidos&ft=prp&pag=list_user">Seus Pedidos</a></li>
                                    <?php
                                }
                                if ($cad->atrib("41")) {
                                    ?>
                                    <li><a href="index.php?st=proj_eletro&ft=pre&pag=list">Projetos Eletr&ocirc;nicos</a></li>
                                    <li><a href="index.php?st=ped_eletro&ft=pre&pag=list_user">Todos seus Pedidos Eletro</a></li>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($cad->atrib("32") or $cad->atrib("42")) {
                                    ?>
                                    <li><a href="index.php?st=relato_tarefas&pag=&resp=">Relat&oacute;rio de Tarefas</a></li>
                                    <li><a href="index.php?st=relato_projetos&pag=&resp=">Planej. de Projetos</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    if ($cad->atrib("21") || $cad->atrib("22")) {
                        ?>
                        <li><a href="#">Estoque</a>
                            <ul>
                                <li><a href="index.php?st=estoque&pag=list">Listagem Geral</a></li>
                                <?php
                                if ($cad->atrib("21")) {
                                    ?>
                                    <li><a href="index.php?st=pedido&pag=list_ped">Pedidos Ativos</a></li>
                                    <li><a href="index.php?st=categ&pag=list">Categoria de Produtos</a></li>
                                    <li><a href="index.php?st=local&pag=list">Local de Estocagem</a></li>
                                    <li><a href="index.php?st=estoque&pag=relatoest">Relat&oacute;rios</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    // Oscontrol
                    if ($cad->atrib("12")) {
                        ?>
                        <li><a href="#">Oscontrol</a>
                            <ul>
                                <li><a href="index.php?st=eqp&pag=list_u">Equipamento das OS</a></li>
                                <li><a href="index.php?st=ordm&pag=list">OS-Ordens de Servi&ccedil;o</a></li>
                                <?php
                                if ($cad->atrib("11")) {
                                    ?>
                                    <li><a href="index.php?st=ordm&pag=relato">Programa&ccedil;&atilde;o e Relat&oacute;rios</a></li>
                                    <li><a href="index.php?st=ordm&pag=list_prog">Calend&aacute;rio de OSs</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    // financieiro
                    if ($cad->atrib("61")) {
                        ?>
                        <li><a href="#">Financeiro</a>
                            <ul>
                                <li><a href="index.php?st=financaspr&ft=fnc&pag=listvenc">Contas a Pagar/Receber</a></li>
                                <li><a href="index.php?st=financascc&ft=fnc&pag=listcor">Contas Correntes</a></li>
                                <li><a href="index.php?st=financascc&ft=fnc&pag=relato">Relat&oacute;rios</a></li>
                                <li><a href="index.php?st=custos&pag=list">Plano de Custos</a></li>
                            </ul>
                        </li>
                        <?php
                    }
                    // Admin. Sistema
                    if ($cad->atrib("90")) {
                        ?>
                        <li><a href="#">Admin. Sistema</a>
                            <ul> <?php
                                if ($cad->atrib("93")) {
                                    ?>
                                    <li><a href="index.php?st=perfilatrib&pag=&resp=">Atribuir Perfis de Usu&aacute;rio</a></li>
                                    <?php
                                }
                                if ($cad->atrib("92")) {
                                    ?>
                                    <li><a href="index.php?st=plano_atrib&pag=&resp=">Plano de Atribui&ccedil;&otilde;es</a></li>
                                    <?php
                                }
                                ?>
                                <li><a href="index.php?st=cadastro&pag=listingr">Listar Ingressos no sistema</a></li>
                                <li><a href="DocsGetar/Docs/index.php" target="_blank">Registro de atividades</a></li>
                                <?php
                                if ($cad->atrib("91")) {
                                    ?>
                                    <li><a href="index.php?st=backup&pag=SQL">Backup em SQL</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }

                    // menu personalizado se houver
                    include $dirPChave . 'menu_personal.inc.php';
                    ?>
                    <li>
                        <a href="index.php?st=ajuda&ft=bvnd&pag=">Ajuda</a>
                    </li>
                    <li>
                        <a href="index.php?st=phpInfo&ft=bvnd&pag=">Info. Servidor</a>
                    </li>
                </ul>
                <br style="clear: left" />
            </div>
            <div id="conteudo">
                <?php
                if (isset($_GET['st'])) {
                    $setor = $_GET["st"];
                } else {
                    $setor = "boasvindas";
                }
                $pag = $_GET['pag'];
                if (isset($_GET['paglst'])) {
                    $pagList = $_GET['paglst'];
                } else {
                    $pagList = "";
                }

                //Carregar classes conforme os modulos
                if (isset($_GET['ft'])) {
                    switch ($_GET['ft']) {
                        case 'bvnd'://boas vindas
                            include './pagina/trait_consBoasVnd.php';
                            include './pagina/classe_boasvindas.php';
                            $boasVnd = new BoasVindas();
                            //Para recarregar apos logado
                            $boasVnd->set_resp($resp);
                            //Carregar atribuicoes
                            $boasVnd->carAtrib($resp);
                            break;
                        case 'pre'://projetos eletronicos
                            include './pagina/proj_eletro/swtich.inc.php';
                            break;
                        case 'prp':// Projetos de programacao
                            include './pagina/projetos/switch.inc.php';
                            break;
                    }
                } elseif (isset($_GET["pag"])) {//para quando nao for pedido nada mas esta logado
                    include './pagina/trait_consBoasVnd.php';
                    include './pagina/classe_boasvindas.php';
                    $boasVnd = new BoasVindas();
                    //Para recarregar apos logado
                    $boasVnd->set_resp($resp);
                    //Carregar atribuicoes
                    $boasVnd->carAtrib($resp);
                }

                //para carregar POST personalizados
                include $dirPChave . 'parametro_personal.inc.php';

                // switch complementar
                include './config/switch.inc.php';
                switch ($setor) {
                    case "boasvindas":
                        //Boas Vindas Personalizada
                        include './config/boasvindas.inc.php';
                        echo "<hr>";
                        break;
                    case "cadastro":
                        include './pagina/cadastros/cadastro.php';
                        break;
                    case "opera":
                        include './pagina/opera/switch.inc.php';
                        break;
                    case "tarfopera":
                        include './pagina/opera/switch.inc.php';
                        break;
                    case "relato_tarefas":
                        include("pagina/relatos/relato.php");
                        break;
                    case "relato_projetos":
                        include("pagina/relatos/relato_projetos.php");
                        break;
                    case "plano_atrib":
                        include("pagina/atribuicoes/classe_atrib.php");
                        $atrb = new Atrib();
                        echo $atrb->atribList();
                        echo $atrb->atribOpcoes();
                        break;
                    case "perfilatrib":
                        include("pagina/atribuicoes/classe_atrib.php");
                        $atrb = new Atrib();
                        echo "<div class=\"titulo\">PERFIL ATRIBUTOS</div>";
                        if (isset($_POST['aplicPerfil'])) {
                            $atrb->atribAplicPerfil($_POST['codperfil'], $_POST['nick']);
                        }
                        if ($_GET['pag'] == "excall") {
                            echo $atrb->atribExcTudo($_GET['nick']);
                        }
                        $complemento = $atrb->atribSwitch($pag);
                        echo $atrb->atribListPerfil($complemento);
                        echo $atrb->atribSemPerfil();
                        echo $atrb->atribListLoga();
                        echo "<hr>";
                        echo $atrb->atribOpcoes();
                        break;
                    case "backup":
                        include("pagina/backup.php");
                        break;
                    case "ajuda":
                        echo $boasVnd->textoBoaVindas();                        
                        break;
                    case "phpInfo":
                        phpinfo();
                        break;
                }
                /**
                 * Como agora tem switch complementares nao eh mais possivel usar 
                 * o default para os switchdefault:
                  echo $boasVnd->textoBoaVindas();
                  break;
                 */
                if ($setor == "") {
                    echo $boasVnd->textoBoaVindas();
                }
                ?>
            </div>
            <br style="clear: both"/>
            <?php echo $cad->rodape(); ?>
        </div>
    </body>
</html>
<!– SHADOWBOX –>
<link rel="stylesheet" href="css/shadowbox.css">
<script type="text/javascript" src="js/shadowbox.js"></script>
<script type="text/javascript"> Shadowbox.init(); </script>
<!– SHADOWBOX –>