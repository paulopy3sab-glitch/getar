<?php
session_start();

/**
 * @author: Paulo Regis S. Schwingel <paulo_schw@yahoo.com.br>
 * Data criacao: indeterminada
 * Descricao: arquivo chave para chamada de todos os modulos. Versao mobile
 * Revisoes: Junho/2016 - pregis
 *           reestruturacao em POO
 */
//Para exibir erros
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

global $dirChave;
global $dirPChave;
global $mobile;
$mobile = TRUE;
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
include './funcoes/funcoes.php';
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
//include $dirChave . 'funcoes_cadcons.php';
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
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta name="viewport" content="width=device-width, user-scalable=1">
        <link href="css/m-style.css" rel="stylesheet" type="text/css">
        <link href="css/tabela.css" rel="stylesheet" type="text/css">
        <link href="css/formulario.css" rel="stylesheet" type="text/css">
        <!--personalizacoes do cliente -->
        <link href="config/m-pstyle.css" rel="stylesheet" type="text/css">

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
                <div>
                    <?php echo $cad->mcabecalho(); ?>
                </div>
                <div id="cablinks">
                    <span>GETAR Vers&atilde;o: 3.5.0</span> -&nbsp;
                    <span><?php echo $resp; ?></span>
                    &nbsp;- <a href="m-index.php?acao=logof">Sair</a>
                </div>
            </div>
            <?php
            //Verificar se logado
            if (!$cad->user_validacao()) {
                ?>
                <div class="logon">
                    <div id="logoQd">                    
                        <?php echo $cad->logoPrin(); ?>
                    </div>
                    <div>
                        <form action="m-index.php?acao=logon" method="post">
                            <fieldset>
                                <legend>Logon no sistema</legend>
                                <?php echo $msg; ?>
                                <label>Usu&aacute;rio: </label><br />
                                <input name="user" type="text" placeholder="usuario" required autocomplete="off" tabindex="1" autofocus="" size="22" maxlength="20"><br>
                                <label>Senha: </label><br />
                                <input name="senha" type="password" placeholder="senha" required tabindex="2" size="22" maxlength="20"><br>
                                <label>&nbsp;</label><input name="entrar" type="Submit" value="Entrar" tabindex="3">
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
                if (!$cad->atrib("500")) {
                    ?>
                    <div class="logon">
                        <div id="logoQd">                    
                            <?php echo $cad->logoPrin(); ?>
                        </div>
                        <div>
                            <form action="m-index.php?acao=logon" method="post">
                                <fieldset>
                                    <legend>Logon no sistema</legend>
                                    <b style="color: red;">ACESSO BLOQUEADO VIA DISPOSITIVO M&Oacute;VEL!</b>
                                    <div>&nbsp;</div>
                                    <label>Usu&aacute;rio: </label><br />
                                    <input name="user" type="text" size="22" maxlength="20"><br>
                                    <label>Senha: </label><br />
                                    <input name="senha" type="password" size="22" maxlength="20"><br>
                                    <label>&nbsp;</label><input name="entrar" type="Submit" value="Entrar">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                    <br style="clear: both;" />
                    <?php
                    echo $cad->rodape();
                    die();
                }
                echo " <div id=\"mens\">";
                echo $cad->verificaMensagens($resp) . "<br>";
                echo $cad->verificaLembretes($resp) . "<br>";
                echo "</div>";
            }
            ?>
            <div id="menu">
                <ul>
                    <li><a href="m-index.php?st=boasvindas&ft=bvnd&pag=">Inicio</a></li>
                    <?php
                    if ($cad->atrib("581")) {
                        ?>
                        <li><a href="m-index.php?st=artigos&pag=list_u&pagina=">Artigos</a></li>
                        <?php
                    }
                    if ($cad->atrib("504")) {//detalha cadasto
                        ?>
                        <li><a href="m-index.php?st=cadastro&pag=list&pagina=">Cadastro</a></li>
                        <?php
                    }
                    if ($cad->atrib("573")) {
                        ?>
                        <li><a href="m-index.php?st=lembretes&ft=mens&pag=list">Lembretes</a></li>
                        <?php
                    }
                    if ($cad->atrib("572")) {
                        ?>
                        <li><a href="m-index.php?st=mensagens&ft=mens&pag=list">Mensagens</a></li>
                        <?php
                    }

                    if ($cad->atrib("531") or $cad->atrib("541")) {
                        ?>
                        <li><a href="#">Projetos</a>
                            <ul>
                                <?php
                                if ($cad->atrib("531")) {
                                    ?>
                                    <li><a href="m-index.php?st=projetos&ft=prp&pag=list">Projetos Programa&ccedil;&atilde;o</a></li>
                                    <?php
                                }
                                if ($cad->atrib("541")) {
                                    ?>
                                    <li><a href="m-index.php?st=proj_eletro&ft=pre&pag=list">Projetos Eletr&ocirc;nicos</a></li>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($cad->atrib("532") or $cad->atrib("542")) {
                                    ?>
                                    <li><a href="m-index.php?st=relato_tarefas&pag=&resp=">Relat&oacute;rio de Tarefas</a></li>
                                    <li><a href="m-index.php?st=relato_projetos&pag=&resp=">Planej. de Projetos</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    if ($cad->atrib("520")) {
                        ?>
                        <li><a href="#">Estoque</a>
                            <ul>
                                <li><a href="m-index.php?st=estoque&pag=list">Listagem Geral</a></li>
                                <?php
                                if ($cad->atrib("521")) {
                                    ?>
                                    <li><a href="m-index.php?st=estoque&pag=list_compra">Listagem para Pedidos</a></li>
                                    <li><a href="m-index.php?st=estoque&pag=list_ped">Pedidos Ativos</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }
                    if ($cad->atrib("511")) {
                        ?>
                        <li><a href="#">Oscontrol</a>
                            <ul>
                                <li><a href="m-index.php?st=eqp&pag=list_u">Equipamento das OS</a></li>
                                <li><a href="m-index.php?st=ordm&pag=list">OS-Ordens de Servi&ccedil;o</a></li>
                            </ul>
                        </li>
                        <?php
                    }
                    if ($cad->atrib("551")) {
                        ?>
                        <li><a href="m-index.php?st=vendas&pag=list">Vendas</a></li>
                        <?php
                    }
                    if ($cad->atrib("561")) {
                        ?>
                        <li><a href="#">Financeiro</a>
                            <ul>
                                <li><a href="m-index.php?st=contacarne&ft=fnc&pag=listmes&mes=<?php echo date('m') ?>">Contas a Pagar/Receber</a></li>
                                <li><a href="m-index.php?st=contalanca&ft=fnc&pag=listcor">Contas Correntes</a></li>                                
                            </ul>
                        </li>
                        <?php
                    }
                    if ($cad->atrib("502")) {
                        ?>
                        <li><a href="#">Admin. Sistema</a>
                            <ul>
                                <li><a href="m-index.php?st=plano_atrib&pag=&resp=">Plano de Atribui&ccedil;&otilde;es</a></li>
                                <li><a href="m-index.php?st=ingresso&pag=list&pagina=">Listar Ingressos no sistema</a></li>
                                <?php
                                if ($cad->atrib("590")) {
                                    ?>
                                    <li><a href="m-index.php?st=backup&pag=SQL">Backup em SQL</a></li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </li>
                        <?php
                    }

                    // menu personalizado se houver
                    include $dirPChave . 'm-menu_personal.inc.php';
                    ?>
                    <li>
                        <a href="m-index.php?st=ajuda&ft=bvnd&pag=">Ajuda</a></li>                                
                    </li>
                </ul>
                <br style="clear: left" />
            </div>
            <div id="conteudo">
                <?php
                //Carregar classes conforme os modulos
                if (isset($_GET['ft'])) {
                    switch ($_GET['ft']) {// para nao ficar repetindo para projetos-pedidos-tarefas
                        case 'prp':
                            include './pagina/projetos/trait_projcons.php';
                            include './pagina/projetos/classe_projprog.php';
                            $prp = new projprog();
                            //Para recarregar apos logado
                            $prp->set_resp($resp);
                            //Carregar atribuicoes
                            $prp->carAtrib($resp);
                            break;
                        case 'pre':
                            include './pagina/proj_eletro/trait_precons.php';
                            include './pagina/proj_eletro/classe_projeletro.php';
                            $pre = new Projeletro();
                            //Para recarregar apos logado
                            $pre->set_resp($resp);
                            //Carregar atribuicoes
                            $pre->carAtrib($resp);
                            break;
                        case 'fnc':
                            include './pagina/financas/trait_financacons.php';
                            include './pagina/financas/classe_financa.php';
                            include './config/classe_pfinanca.php';
                            $fnc = new Pfinanca;
                            //Para recarregar apos logado
                            $fnc->set_resp($resp);
                            //Carregar atribuicoes
                            $fnc->carAtrib($resp);
                            /**
                             * Pegar o nick da conta padrao
                             */
                            if (!isset($_SESSION['codconta'])) {
                                $_SESSION['codconta'] = $fnc->contaFixa(1);
                            } else {
                                $fnc->contaFixa($_SESSION['codconta']);
                            }
                            break;
                        case 'mens':
                            include './pagina/mensagens/trait_menscons.php';
                            include './pagina/mensagens/classe_lembr.php';
                            $lmb = new lembr();
                            //Para recarregar apos logado
                            $lmb->set_resp($resp);
                            //Carregar atribuicoes
                            $lmb->carAtrib($resp);
                            break;
                        case 'bvnd'://boas vindas
                            include './pagina/trait_consBoasVnd.php';
                            include './pagina/classe_boasvindas.php';
                            $boasVnd = new BoasVindas();
                            //Para recarregar apos logado
                            $boasVnd->set_resp($resp);
                            //Carregar atribuicoes
                            $boasVnd->carAtrib($resp);
                            break;
                    }
                } elseif (isset($_GET["pag"])) {
                    include './pagina/trait_consBoasVnd.php';
                    include './pagina/classe_boasvindas.php';
                    $boasVnd = new BoasVindas();
                    //Para recarregar apos logado
                    $boasVnd->set_resp($resp);
                    //Carregar atribuicoes
                    $boasVnd->carAtrib($resp);
                }

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

                //para carregar POST personalizados
                include $dirPChave . 'parametro_personal.inc.php';
                // switch complementar
                include './config/m-switch.inc.php';
                switch ($setor) {
                    case "boasvindas":
                        //Boas Vindas Personalizada
                        include './config/m-boasvindas.inc.php';
                        break;
                    case "cadastro":
                        if (isset($_GET['codcad'])) {
                            $cad->set_codCad($_GET['codcad']);
                        }
                        echo "<div class=\"titulo\">CADASTRO</div>";
                        if (isset($_POST["salvarCad"])) {
                            //Entrada de variaveis
                            $cad->set_codCad($_POST['cod']);
                            $cad->set_nome($_POST['nome']);
                            //montagem da data nascimento
                            $dia_nasc = $_POST['dia_nasc'];
                            $mes_nasc = $_POST['mes_nasc'];
                            $ano_nasc = $_POST['ano_nasc'];
                            $dataNasc = $ano_nasc . "-" . $mes_nasc . "-" . $dia_nasc;
                            $cad->set_dataNasc($dataNasc);
                            //montagem de cliente desde
                            $dia_desde = $_POST['dia_desde'];
                            $mes_desde = $_POST['mes_desde'];
                            $ano_desde = $_POST['ano_desde'];
                            $dataDesde = $ano_desde . "-" . $mes_desde . "-" . $dia_desde;
                            $cad->set_dataDesde($dataDesde);
                            $cad->set_contato($_POST['cont']);
                            $cad->set_rgie($_POST['rgie']);
                            $cad->set_cpcn($_POST['cpcn']);
                            $cad->set_estciv($_POST['estciv']);
                            $cad->set_mae($_POST['mae']);
                            $cad->set_conj($_POST['conj']);
                            $cad->set_sexo($_POST['sexo']);
                            $cad->set_nacna($_POST['nacna']);
                            $cad->set_prof($_POST['prof']);
                            $cad->set_endr($_POST['endr']);
                            $cad->set_bairro($_POST['bairro']);
                            $cad->set_cidade($_POST['cidade']);
                            $cad->set_estado($_POST['estado']);
                            $cad->set_cep($_POST['cep']);
                            $cad->set_ref($_POST['ref']);
                            $cad->set_clasf($_POST['clasf']);
                            $cad->set_situCad($_POST['situacao']);
                            $cad->cadSalvar();
                        }
                        if (isset($_POST['fonesalvar'])) {
                            $cad->set_codTel($_POST['codfone']);
                            $cad->set_numTel($_POST['numero']);
                            $cad->set_descrTel($_POST['descr']);
                            $cad->set_ramalTel($_POST['ramal']);
                            $cad->foneSalvar();
                        }
                        if (isset($_POST['emailsalvar'])) {
                            $cad->set_codEml($_POST['codemail']);
                            $cad->set_endrEml($_POST['endremail']);
                            $cad->set_descrEml($_POST['descremail']);
                            $cad->emailSalvar();
                        }
                        if (isset($_POST['sitesalvar'])) {
                            $cad->set_codSite($_POST['codsite']);
                            $cad->set_endrSite($_POST['endr']);
                            $cad->set_descrSite($_POST['descr']);
                            $cad->siteSalvar();
                        }
                        if (isset($_GET['fnexc'])) {
                            $cad->set_codTel($_GET['fnexc']);
                            $cad->foneExcl();
                        }
                        if (isset($_GET['emexc'])) {
                            $cad->set_codEml($_GET['emexc']);
                            $cad->emailExcl();
                        }
                        if (isset($_GET['stexc'])) {
                            $cad->set_codSite($_GET['stexc']);
                            $cad->siteExcl();
                        }
                        if (isset($_GET['fnedt'])) {
                            $cad->set_codTel($_GET['fnedt']);
                            echo $cad->foneEdit();
                        } elseif (isset($_GET['emedt'])) {
                            $cad->set_codEml($_GET['emedt']);
                            echo $cad->emailEdit();
                        } elseif (isset($_GET['stedt'])) {
                            $cad->set_codSite($_GET['stedt']);
                            echo $cad->siteEdit();
                        }
                        if ($pag == "edit" || $pag == "cad") {
                            if ($pag == "edit" || $pag == "cad") {
                                if ($cad->atrib("2")) {
                                    echo $cad->mcadEdit();
                                    $clasf = $cad->get_clasf();
                                    if (($clasf <> "r") && ($clasf <> "b") && ($clasf <> "g") && ($clasf <> "u")) {
                                        if ($cad->ingressoCar() == "") {
                                            echo $cad->ingressoNovo();
                                        } else {
                                            echo $cad->ingressoEdit();
                                        }
                                    }
                                } else {
                                    echo $cad->mcadEditPers();
                                }
                            }
                            if ($pag == "detal") {
                                echo $cad->cadDetal();
                            }
                        }
                        echo "<hr>";
                        if ($cad->atrib('2')) {
                            $complemento = "";
                        } else {
                            $complemento = " AND clasf NOT IN('a') ";
                        }
                        //para pesquisas
                        if (isset($_POST['string'])) {
                            $cad->set_pesq($_POST['string']);
                        }
                        $complemento .= $cad->cadSwitch($pag);
                        echo $cad->mcadList($complemento, $pag, $pagList);
                        echo "<hr>";
                        echo $cad->mcadOpcoes();
                        break;
                    case "eqp":
                        include './pagina/oscontrol/classe_os.php';
                        $OS = new OScontrol();
                        //Para recarregar apos logado
                        $OS->set_resp($resp);
                        //Carregar atribuicoes
                        $OS->carAtrib($resp);

                        //Ajustes de variaveis
                        if (isset($_GET['codeqp'])) {
                            $OS->set_codEqp($_GET['codeqp']);
                        }
                        echo "<div class=\"titulo\">EQUIPAMENTOS CADASTRADOS</div>";
                        if (isset($_POST['salvar'])) {
                            $OS->set_codEqp($_POST['codeqp']);
                            $OS->set_codCli($_POST['codCliente']);
                            $OS->set_hist($_POST['hist']);
                            $OS->set_descr($_POST['descr']);
                            $OS->set_marca($_POST['marca']);
                            $OS->set_modelo($_POST['modelo']);
                            $OS->set_serial($_POST['serial']);
                            $OS->set_situEqp($_POST['situ']);
                            $OS->eqpSalvar();
                        }
                        $complemento = $OS->eqpSwitch($pag);
                        echo $OS->eqpList($complemento, $pag, $pagList);
                        echo "<hr>";
                        echo $OS->eqpOpcoes();
                        break;
                    case "clasf":
                        include("pagina/cadastros/clasf.php");
                        break;
                    case "ingresso":
                        include("pagina/cadastros/ingresso.php");
                        break;
                    case "artigos":
                        include './pagina/artigos/funcoes_artigos.php';
                        include("pagina/artigos/artigos.php");
                        break;
                    case "proj_eletro":
                        //Ajustes de variaveis
                        if (isset($_GET['codproj'])) {
                            $pre->set_codProj($_GET['codproj']);
                        }
                        echo "<div class=\"titulo\">PROJETOS ELETR&Ocirc;NICOS</div>";
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
                            echo $pre->pedLista(" AND situacao NOT IN('x', 'c')");
                        }
                        $complemento = $pre->projSwitch($pag);
                        echo "<hr>";
                        echo $pre->projLista($complemento, $acao);
                        echo $pre->projOpcoes();
                        break;
                    case "ped_eletro":
                        include("pagina/proj_eletro/pedido.php");
                        break;
                    case "tarf_eletro":
                        include("pagina/proj_eletro/tarefa.php");
                        break;
                    case "projetos":
                        //Ajustes de variaveis
                        if (isset($_GET['codproj'])) {
                            $prp->set_codProj($_GET['codproj']);
                        }
                        if (isset($_POST['pesq'])) {
                            $cad->set_pesq($_POST['pesq']);
                        }
                        echo "<div class=\"titulo\">PROJETOS PROGRAMA&Ccedil;&Atilde;O</div>";
                        if (isset($_POST["salvar"])) {
                            $prp->set_codProj($_POST['codproj']);
                            $prp->set_nomeProj($_POST['nome']);
                            $prp->set_codCliente($_POST['codCliente']);
                            $prp->set_descr($_POST['descr']);
                            $prp->set_situProj($_POST['situacao']);
                            $prp->projSalvar();
                        }

                        $complemento = $prp->projSwitch($pag);
                        echo "<hr>";
                        echo $prp->projLista($complemento, $prp->get_acao());
                        if ($pag == "edit" or $pag == "detal") {
                            $complemento = " AND ped.situacao NOT IN('temporario', 'x', 'c')
                                             AND pj.cod =" . $prp->get_codProj();
                            echo $prp->pedLista($complemento);
                            echo "<hr>";
                        }
                        if ($pag == "listped") {
                            $complemento = " AND ped.situacao NOT IN('temporario')
                                             AND pj.cod =" . $prp->get_codProj();
                            echo $prp->pedLista($complemento);
                            echo "<hr>";
                        }
                        echo $prp->projOpcoes();
                        break;
                    case "pedidos":
                        if (isset($_GET['codproj'])) {
                            $prp->set_codProj($_GET['codproj']);
                        }

                        if (isset($_GET['codped'])) {
                            $prp->set_codPed($_GET['codped']);
                        }

                        if (isset($_POST["salvarped"])) {
                            $prp->set_codProj($_POST['codproj']);
                            $prp->set_codPed($_POST['codped']);
                            $prp->set_tituPed($_POST['titulo']);
                            $prp->set_resp($_POST['resp']);
                            $prp->set_docPed($_POST['doc']);
                            $prp->set_situPed($_POST['situped']);
                            $prp->set_priorPed($_POST['prior']);
                            $prp->set_fatuPed($_POST['fatura']);
                            //Trabalhando com as datas
                            $dataIni = $_POST['anoini'] . "/" . $_POST['mesini'] . "/" . $_POST['diaini'];
                            $prp->set_dataIni($dataIni);
                            $dataClc = $_POST['anoclc'] . "/" . $_POST['mesclc'] . "/" . $_POST['diaclc'];
                            $prp->set_dataClc($dataClc);

                            $prp->pedSalvar();
                        }

                        echo $prp->pedCab();

                        $complemento = $prp->pedSwitch($pag);
                        if ($pag == "edit" || $pag == "detal") {
                            echo $prp->pedEdit($prp->get_codPed(), $prp->get_codProj());
                            $complemento = " AND ped.cod= " . $prp->get_codPed();
                        }
                        echo $prp->pedLista($complemento);
                        echo "<hr>";
                        echo $prp->pedOpcoes();
                        break;
                    case "tarefas":
                        if (isset($_GET['codTarefa'])) {
                            $prp->set_codTarf($_GET['codTarefa']);
                        }
                        if (isset($_GET['codped'])) {
                            $prp->set_codPed($_GET['codped']);
                            $prp->set_respTarf($_SESSION['resp']);
                        }
                        if (isset($_POST["salvartarf"])) {
                            $prp->set_horaIni($_POST['horaini']);
                            $prp->set_respTarf($_SESSION['resp']);
                            $prp->set_docTarf($_POST['doc']);
                            $prp->set_statusTarf($_POST['status']);
                            $prp->set_fatuTarf($_POST['fatura']);
                            $prp->set_codTarf($_GET['codTarefa']);
                            //Verificacoes
                            if ($_POST['status'] == "c") {
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
                        $complemento = $prp->tarfSwitch($pag);
                        if ($pag == "edit" || $pag == "detal") {
                            $complemento = " AND cod= " . $prp->get_codTarf();
                        }
                        echo $prp->tarfLista($complemento);
                        echo "<hr>";
                        echo $prp->tarfOpcoes();
                        break;
                    case "relato_tarefas":
                        include("pagina/relato_tarefa.php");
                        break;
                    case "relato_projetos":
                        include("pagina/relato_projetos.php");
                        break;
                    case "mensagens":
                        //Ajustes de variaveis
                        if (isset($_GET['codmens'])) {
                            $lmb->set_codMens($_GET['codmens']);
                        }

                        if (isset($_POST['postarNova'])) {
                            $lmb->set_destMens($_POST['dest']);
                            $lmb->set_texto(html_texto($_POST['texto']));
                            $lmb->mensPostar();
                        }

                        if (isset($_GET['codmens'])) {
                            $lmb->set_codMens($_GET['codmens']);
                        }
                        $pag = $_GET['pag'];

                        if ($pag == 'inativa') {
                            $lmb->mensInativa();
                            $pag = $_GET['ulist'];
                        }

                        if ($pag == 'excl') {
                            $lmb->mensExcl();
                            $pag = "list_recb";
                        }
                        if ($pag == "nova") {
                            echo $lmb->mensEdit();
                        }
                        if ($pag == "exib") {
                            echo $lmb->mensExib($lmb->get_codMens());
                        }
                        $complemento = $lmb->mensSwitch($pag);
                        echo $lmb->mensList($complemento, $pag, $pagList);
                        echo "<hr>";
                        echo $lmb->mensOpcoes();

                        break;
                    case "lembretes":
                        //Ajustes de variaveis
                        if (isset($_GET['codlmb'])) {
                            $lmb->set_codLmb($_GET['codlmb']);
                        }

                        if (isset($_POST['salvarLmb'])) {
                            $lmb->set_codLmb($_POST['codlmb']);
                            $lmb->set_textoLmb($_POST['texto']);
                            $lmb->set_remtLmb($_POST['remt']);
                            $lmb->set_destLmb($_POST['dest']);
                            $lmb->set_situLmb($_POST['situacao']);
                            $dataAgendada = $_POST['anoagd'] . "-" . $_POST['mesagd'] . "-" . $_POST['diaagd'];
                            $lmb->set_dataAgd($dataAgendada);
                            $msg = $lmb->lembreSalvar();
                        }

                        //preparar calendario
                        include $dirChave . 'classe_calendario.php';
                        $cld = new Calendario();
                        $mes = date('m');
                        $ano = date('Y');
                        $cld->set_mes($mes);
                        $cld->set_ano($ano);
                        $lmb->arrayLmb = $cld->arrayDia;
                        $lmb->lembreMes($mes, $ano, TRUE);
                        $cld->arrayDia = $lmb->arrayLmb;
                        if ($pag == "edit" || $pag == "nova") {
                            echo $lmb->mlembrEdit($lmb->get_codLmb());
                        }
                        $complemento = $lmb->lembrSwitch($pag);
                        echo $lmb->mlembrList($complemento, $pag, $pagList);
                        
                        $capt = "Calend&aacute;rio " . $lmb->mesExtBR($mes) . " de " . $ano;
                        echo $cld->exibe_calendario($capt);
                        echo "<hr>";
                        echo $lmb->lembrOpcoes();
                        break;
                    case "contacor":
                        if (isset($_GET['codctco'])) {
                            $codCtCo = $_GET['codctco'];
                            $fnc->set_codCtCo($_GET['codctco']);
                        } else {
                            $codCtCo = ""; // para nova conta corrente
                        }
                        if (isset($_POST['salvarCtNm'])) {
                            $fnc->set_nomeConta($_POST['nome']);
                            $fnc->set_descrConta($_POST['descr']);
                            $fnc->set_situConta($_POST['situacao']);
                            $fnc->contaSalvar();
                        }
                        echo "<div class=\"titulo\">Conta Corrente</div>";
                        if ($pag == "editcor") {
                            echo $fnc->contaNomeEdit($codCtCo);
                            ;
                        }
                        if ($pag == "defcor") {
                            $_SESSION['codconta'] = $_GET['codctco'];
                            $fnc->contaFixa($_SESSION['codconta']);
                            echo "<b style=\"color: blue;\">Conta Corrente Difinida: " . $fnc->get_nomeConta() . "</b>";
                        }
                        $complemento = $fnc->contaSwith($pag);
                        echo $fnc->contaList($complemento);
                        echo $fnc->contaOpcoes();
                        break;
                    case "contaclasf":
                        if (isset($_GET['codctco'])) {
                            $fnc->set_codCtCo($_GET['codctco']);
                        }
                        if (isset($_GET['codclasf'])) {
                            $fnc->set_codClasf($_GET['codclasf']);
                        }
                        if (isset($_POST['salvarClasf'])) {
                            $fnc->set_codClasf($_POST['codclasf']);
                            $fnc->set_nomeClasf($_POST['nome']);
                            $fnc->set_descrClasf($_POST['descr']);
                            $fnc->set_situClasf($_POST['situacao']);
                            $fnc->clasfSalvar();
                        }

                        echo "<div class=\"titulo\">Conta Corrente</div>";
                        if ($pag == "editclasf") {
                            echo $fnc->clasfEdit();
                            ;
                        }
                        $complemento = $fnc->clasfSwitch($pag);
                        echo $fnc->clasfList($complemento);
                        echo $fnc->clasfOpcoes();
                        break;
                    case "contacarne":
                        //Ajustes de variaveis
                        if (isset($_GET['codcarne'])) {
                            $fnc->set_codCarne($_GET['codcarne']);
                        }
                        if (isset($_GET['codpar'])) {
                            $fnc->set_codParc($_GET['codpar']);
                        }
                        if (isset($_GET['mes'])) {
                            $fnc->set_mesPesq($_GET['mes']);
                        }
                        if (isset($_GET['tipo'])) {
                            $fnc->set_tipoCarne($_GET['tipo']);
                        }
                        if (isset($_POST['anoini'])) {
                            $dataIni = $_POST['anoini'] . "-" . $_POST['mesini'] . "-" . $_POST['diaini'];
                            $fnc->set_dataIni($dataIni);
                            $dataFim = $_POST['anofim'] . "-" . $_POST['mesfim'] . "-" . $_POST['diafim'];
                            $fnc->set_dataFim($dataFim);
                        }

                        echo "<div class=\"titulo\">Contas Pagar e Receber</div>";
                        //salvar um carne novo
                        if (isset($_POST["salvarCarne"])) {// Vai gerar parcelamentos automaticamente
                            $fnc->set_codCarne($_POST['codcarne']);
                            $fnc->set_codCtCo($_POST['codctco']);
                            $fnc->set_objeto($_POST['objeto']);
                            $fnc->set_obsCarne($_POST['obs']);
                            $fnc->set_codCad($_POST['codcad']);
                            $fnc->set_valorTot($_POST['valortot']);
                            $fnc->set_numParc($_POST['numparc']);
                            if (isset($_POST['juros'])) {
                                $fnc->set_jurosParc($_POST['juros']);
                            }
                            $fnc->carneSalvar();
                        }

                        //Gravando edicao de um carne
                        if (isset($_POST['editarCarne'])) {
                            $fnc->set_codCarne($_POST['codcarne']);
                            $fnc->set_codCtCo($_POST['codctco']);
                            $fnc->set_obsCarne($_POST['obs']);
                            $fnc->set_situCarne($_POST['situcarne']);
                            $fnc->carneAtual();
                        }
                        //Pagando ou editando uma parcela
                        if (isset($_POST['editparc'])) {
                            $fnc->set_codParc($_POST['codpar']);
                            $fnc->set_situParc($_POST['situpar']);

                            $diaVnc = $_POST['diavnc'];
                            $mesVnc = $_POST['mesvnc'];
                            $anoVnc = $_POST['anovnc'];
                            $dataVncParc = $anoVnc . "-" . $mesVnc . "-" . $diaVnc;
                            $fnc->set_dataVncParc($dataVncParc);

                            $obs = $_POST['obs'];
                            $obsAnt = $_POST['obsant'];
                            //Preparar a documentacao para a observacao
                            $observacao = $_SESSION['resp'] . " (" . date('d/m/y') . "): " . $obs . "\n" . $obsAnt;
                            $fnc->set_obsParc($observacao);

                            $fnc->set_valorParc($_POST['valorpar']);
                            if ($_POST['situpar'] == "paga") {
                                $fnc->parcelaSlPagar();
                            } else {
                                $fnc->parcelaSlEdit();
                            }
                        }

                        switch ($pag) {
                            case 'carnenv':// Para criar um carne novo
                                echo $fnc->carneNovo($fnc->get_tipoCarne());
                                break;
                            case 'edit':
                                echo $fnc->carneEdit();
                                echo $fnc->parcelaList();
                                echo "</fieldset>";
                                break;
                            case 'editpar':
                                echo $fnc->parcelaEdit($fnc->get_codParc());
                                break;
                            case 'detalpar':
                                echo $fnc->parcelaDetal($fnc->get_codParc());
                                break;
                            case 'pagar':
                                echo $fnc->parcelaPagar($fnc->get_codParc());
                                break;
                        }
                        $complemento = $fnc->carneSwitch($pag);
                        echo "<hr>";
                        echo $fnc->m_carneList($complemento);
                        echo $fnc->m_carneOpcoes();
                        break;
                    case "contalanca":
                        if (isset($_POST['salvarlanca'])) {
                            $fnc->set_codLanca($_POST['codlanca']);
                            $fnc->set_descrLanca($_POST['descr']);
                            $fnc->set_codClasf($_POST['codclasf']);
                            //remontar a data lancamento
                            $diaLanca = $_POST['dialnc'];
                            $mesLanca = $_POST['meslnc'];
                            $anoLanca = $_POST['anolnc'];
                            $dataLanca = $anoLanca . "-" . $mesLanca . "-" . $diaLanca;
                            $fnc->set_dataLanca($dataLanca);
                            $fnc->set_valorCred($_POST['cred']);
                            $fnc->set_valorDeb($_POST['debt']);
                            $fnc->set_situLanca($_POST['situacao']);
                            $fnc->set_obsLanca($_POST['obs']);
                            $fnc->lancaSalvar();
                        }
                        if ($pag == "editlanca") {
                            $fnc->set_codLanca($_GET['codlanca']);
                            echo $fnc->lancaEdit();
                        }
                        $complemento = $fnc->lancaSwitch($pag);
                        echo $fnc->lancaList($complemento);
                        echo $fnc->lancaOpcoes();
                        break;
                    case "plano_atrib":
                        include("pagina/atribuicoes/classe_atrib.php");
                        $atrb = new Atrib();
                        echo $atrb->atribList();
                        break;
                    case "backup":
                        include("pagina/backup.php");
                        break;
                    case "ajuda":
                        echo $boasVnd->textoBoaVindas();
                        break;
                    default:
                        //echo $boasVnd->textoBoaVindas();
                        break;
                }
                ?>
            </div>
            <?php echo $cad->rodape(); ?>
        </div>
    </body>
</html>