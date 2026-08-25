<link href="./css/style.css" rel="stylesheet" type="text/css">
<link href="./css/tabela.css" rel="stylesheet" type="text/css">
<link href="./css/formulario.css" rel="stylesheet" type="text/css">

<?php
include './pagina/oscontrol/funcoes_os.php';
#include './pagina/oscontrol/funcoes_oscons.php';

$codOS = $_GET['codos'];

$consulta = "    SELECT cod codos,
                        (SELECT trf.cod FROM ordem_tarf trf WHERE trf.codos = ord.cod AND trf.situ= 'andamento') codtarf,
                        codcli,
                        (SELECT cad.nome 
                           FROM getar_cad cad,
                                getar_control ctl
                          WHERE ctl.codcad = cad.cod
                                AND ctl.nick = resp) resp,
                        (SELECT nome 
                           FROM getar_cad cad
                          WHERE codcli = cad.cod) cliente,
                        valcb,
                        fatu,
                        vndacs,
                        DATE_FORMAT(entd, '%d/%m/%Y') entd,
                        DATE_FORMAT(inicio, '%d/%m/%Y') ini,
                        DATE_FORMAT(saida, '%d/%m/%Y') sd,
                        DATE_FORMAT(datafcd, '%d/%m/%Y') fcd,
                        (SELECT CONCAT(eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                           FROM equipo eq
                          WHERE eq.cod = codeqp) equipamento,
                        codeqp,
                        situequip,
                        recla,
                        encr,
                        serv,
                        situ
                   FROM ordem ord
                  WHERE cod=" . $codOS;
$dados = consultaSQL($consulta);
$codEqp = $dados['codeqp'];
?>
<table width="100%">
    <tr>
        <td id="cabecalho" colspan="2">
            <div class="centro">
                <div style="float: left;">
                    <?php echo $cad->cabecalho(); ?>
                </div>
                <div style="float: right;">
                    <?php echo $TITULO_PAG; ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td id="conteudo" valign="top" align="center">
            <form name="formulario" action="index.php?st=ordm&pag=edit&codos=<?php echo $codOS; ?>" method="post" style="font-size: 8pt;">
                <fieldset>
                    <legend>REGISTRO DA OS</legend>
                    <label>Equipamento: </label><b><?php echo $dados['equipamento']; ?></b><br>
                    <label>OS C&oacute;digo: </label><b><?php echo $codOS; ?></b><br>
                    <label>Data Entrada: </label><b><?php echo $dados['entd']; ?></b><br>
                    <label>Data Inicio: </label><b><?php echo $dados['ini']; ?></b><br>
                    <label>Cliente:</label>
                    <b><?php echo $dados['cliente']; ?></b><br>
                    <label>T&eacute;cnico: </label>
                    <b><?php echo $dados['resp'] ?></b><br>
                    <!--<label>Data de entrada: </label><b><?php echo $dados['entd']; ?></b><br>
                    <label>Data de fechamento: </label><b><?php echo $dados['fcd']; ?></b><br>
                    <label>Data de sa&iacute;da: </label><b><?php echo $dados['sd']; ?></b><br>-->
                    <label>Situa&ccedil;&atilde;o OS:</label><b><?php echo $dados["situ"]; ?></b><br>
                    <label>Situa&ccedil;&atilde;o do equipamento:</label><b><?php echo $dados["situequip"]; ?></b><br>
                    <label>Defeito reclamado: </label><pre><br /><b><?php echo $dados["recla"]; ?></b></pre><br>
                    <label>Defeito encontrado: </label><pre><br /><b><?php echo $dados["encr"]; ?></b></pre><br>
                    <label>Servico executado: </label><pre><br /><b><?php echo $dados["serv"]; ?></b></pre><br>        
                    <label>Tot. horas trabalhadas: </label><b><?php echo $_GET["tthr"]; ?></b><br>        
                    <label>Observa&ccedil;&atilde;o: </label><pre><br /><b><?php echo ordemObs($codOS); ?></b></pre><br>
                    <label>Faturada: </label><b><?php echo $dados["fatu"]; ?></b><br>
                    <label>Valor cobrado:</label><b><?php echo $dados["valcb"]; ?></b><br>
                </fieldset>
            </form>
            <?php
            $consulta = "SELECT cod FROM estpedidocab WHERE tipo = 'venda' AND ospro = " . $codOS;
            $resultado = mysqli_query($conexao, $consulta);
            $dadosPesq = mysqli_fetch_assoc($resultado);
            if ($dadosPesq['cod'] <> "") {
                echo "<div id=\"divTarfOS\" style=\"font-size: 8pt!important;\">" . pedidoListaImpress($dadosPesq['cod']) . "</div>";
            }

            if (isset($_GET['ltarf'])) {
                echo "<div id=\"divTarfOS\" style=\"font-size: 8pt;\">" . tarfList($codOS, FALSE) . "</div>";
            }
            ?>
            <a href="impress.php?st=ordm&pag=detal&codos=<?php echo $codOS; ?>&tthr=<?php echo tarfTotHora2($codOS); ?>&ltarf=1">
                <img src="imagens/impress.jpeg" alt="Imprimir OS" style="width: 16px;" title="Imprimir a OS"><br />
                Imprimir OS com as Tarefas
            </a>
        </td>
    </tr>
</table>
