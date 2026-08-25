<?php
if (isset($_GET['reprofila'])) {
    $nmsem = $_GET['semanas'];
    $consulta = "UPDATE ordem SET dtrepro = inicio WHERE fila NOT IN(0)";
    $msgFila = executaSQL($consulta);
    $consulta = "UPDATE ordem SET inicio = DATE_ADD(dtrepro, INTERVAL " . $nmsem . " WEEK) WHERE fila NOT IN(0)";
    $msgFila = executaSQL($consulta);
}
?>
<div>
    <fieldset>
        <legend>Programa&ccedil;&atilde;o e Relat&oacute;rios de OSs</legend>
        <div id="elemento">
            <form action="index.php?st=eqp&pag=pesq" method="post">
                <input type="hidden" name="pag" value="pesq">
                <input type="hidden" name="pagina" value="">
                Por Modelo Equipamento<br>
                <table width="640px" border="1">
                    <tr> 
                        <td valign="top">
                            <input name="string" type="text" size="12" maxlength="10" accesskey="p">
                        </td>
                        <td>
                            <input name="Listar" type="submit" value="OK">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="elemento">
            <form action="index.php" method="get">
                <input type="hidden" name="st" value="ordm">
                <input type="hidden" name="pag" value="edit">
                Por C&oacute;digo OS<br>
                <table width="640px" border="1">
                    <tr> 
                        <td valign="top">
                            <input name="codos" type="text" size="12" maxlength="10" accesskey="c">
                        </td>
                        <td>
                            <input name="Listar" type="submit" value="OK">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="elemento">
            <form action="index.php?st=ordm&pag=list_rlt" method="post">
                Fechadas por M&ecirc;s<br />
                <table width="640px" border="1">
                    <tr> 
                        <td valign="top">
                            <label>Mes/Ano:</label>
                            <?php
                            echo selectData("Relato", "xx");
                            ?>
                        </td>
                        <td valign="top" align="center">
                            <input type="submit" name="Enviar" value="Enviar">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="elemento">
            Clientes com OS mas sem telefone<br />
            <table width="640px" border="1">
                <tr> 
                    <td valign="top">
                        <a href="index.php?st=ordm&pag=relato&acao=relatosnf">Listar</a>
                    </td>
                    <td valign="top" align="center">
                        &nbsp;
                    </td>
                </tr>
            </table>
        </div>
        <div id="elemento">
            OS N&atilde;o pagas<br />
            <table width="640px" border="1">
                <tr> 
                    <td valign="top">
                        <a href="index.php?st=ordm&pag=list_npag">
                            Listar
                        </a></td>
                    <td valign="top" align="center">
                        &nbsp;
                    </td>
                </tr>
            </table>
        </div>
        <div id="elemento">
            Calend&aacute;rio de OSs            
            <table width="640px" border="1">
                <tr> 
                    <td valign="top">
                        <a href="index.php?st=ordm&pag=list_prog">
                            Listar
                        </a></td>
                    <td valign="top" align="center">
                        &nbsp;
                    </td>
                </tr>
            </table>
        </div>
        <div id="elemento">
            Calend&aacute;rio de OSs trabalhadas por dia         
            <table width="640px" border="1">
                <tr> 
                    <td valign="top">
                        <a href="index.php?st=ordm&pag=list_trab">
                            Listar
                        </a></td>
                    <td valign="top" align="center">
                        &nbsp;
                    </td>
                </tr>
            </table>
        </div>
        <div id="elemento">
            <form action="index.php?st=ordm&pag=repro_os" method="post">
                <input type="hidden" name="repro_os" value="salvar">
                Reprogramar OSs<br />
                <table width="640px" border="1">
                    <tr> 
                        <td valign="top">
                            Atual Mes/Ano:<br />
                            <?php
                            echo selectData("Atual");
                            ?>
                        </td>
                        <td valign="top">
                            Novo Mes/Ano:<br />
                            <?php
                            echo selectData("Novo");
                            ?>
                        </td>
                        <td valign="top" align="center">
                            <input type="submit" name="Enviar" value="Enviar">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <div id="elemento">
            <form action="index.php" method="get">
                <input type="hidden" name="st" value="ordm">
                <input type="hidden" name="pag" value="relato">
                Reprogramar OSs em Fila<br>
                <table width="640px" border="1">
                    <tr> 
                        <td valign="top">
                            <input name="semanas" type="text" size="1" maxlength="5" accesskey="c">
                            semanas a frente.
                        </td>
                        <td>
                            <input name="reprofila" type="submit" value="OK">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?php
        if (isset($_GET['acao'])) {
            if ($_GET['acao'] == 'relatosnf') {
                echo relatoSemFone();
            }
        }

        $OS->set_erro(FALSE);
        $cabRelato = "LISTAGEM DE ORDENS DE SERVI&Ccedil;O ENFILERADAS";
        $complemento = " AND ord.fila NOT IN(0)";
        $resultado= $OS->relOS($complemento);
        if ($OS->get_erro()) {
            echo "<br /><b style=\"color: red;\">N&atilde;o h&aacute; OS com:</b><small>" . $complemento . "</small>";
        } else {
            include('./pagina/oscontrol/includes/ordem_lista.inc.php');
        }

        $cabRelato = "LISTAGEM DE OSs ABERTAS e PAGAS PARCIAL";
        $complemento = " AND ord.valcb > 0
                         AND ord.situ = 'aberta' ";
        $resultado= $OS->relOS($complemento);
        if ($OS->get_erro()) {
            echo "<br /><b style=\"color: red;\">N&atilde;o h&aacute; OS com:</b><small>" . $complemento . "</small>";
        } else {
            include('./pagina/oscontrol/includes/ordem_lista.inc.php');
        }
        
        $cabRelato = "LISTAGEM DE OSs TRAVA FILA";
        $complemento = " AND ord.situequip= 'travado'
                         AND ord.situ= 'aberta'";
        $resultado= $OS->relOS($complemento);
        if ($OS->get_erro()) {
            echo "<br /><b style=\"color: red;\">N&atilde;o h&aacute; OS com:</b><small>" . $complemento . "</small>";
        } else {
            include('./pagina/oscontrol/includes/ordem_lista.inc.php');
        }
        
        # com tags
        $cabRelato = "LISTAGEM OSs #sohrevisaoalinhamento";
        $complemento = " AND obs.texto LIKE('%#sohrevisaoalinhamento%') ";
        $resultado= $OS->relTag($complemento);
        if ($OS->get_erro()) {
            echo "<br /><b style=\"color: red;\">N&atilde;o h&aacute; OS com:</b><small>" . $complemento . "</small>";
        } else {
            include('./pagina/oscontrol/includes/ordem_lista.inc.php');
        }

        $cabRelato = "LISTAGEM OSs #compesquisadefeito";
        $complemento = " AND obs.texto LIKE('%#compesquisadefeito%') ";
        $resultado= $OS->relTag($complemento);
        if ($OS->get_erro()) {
            echo "<br /><b style=\"color: red;\">N&atilde;o h&aacute; OS com:</b><small>" . $complemento . "</small>";
        } else {
            include('./pagina/oscontrol/includes/ordem_lista.inc.php');
        }

        $cabRelato = "LISTAGEM OSs #praavaliar";
        $complemento = " AND obs.texto LIKE('%#praavaliar%') ";
        $resultado= $OS->relTag($complemento);
        if ($OS->get_erro()) {
            echo "<br /><b style=\"color: red;\">N&atilde;o h&aacute; OS com:</b><small>" . $complemento . "</small>";
        } else {
            include('./pagina/oscontrol/includes/ordem_lista.inc.php');
        }

        $cabRelato = "LISTAGEM OSs QUALQUER HASHTAG #";
        $complemento = " AND ord.cod IN (SELECT 
               codord
               FROM (SELECT codobs, codord, REGEXP_SUBSTR(texto, '#[a-z]+') hashtag FROM ordem_obs) xxx
               WHERE hashtag LIKE ('%#%'))
               AND ord.situ IN ('aberta', 'espera') ";
        $resultado= $OS->relTag($complemento);
        if ($OS->get_erro()) {
            echo "<br /><b style=\"color: red;\">N&atilde;o h&aacute; OS com:</b><small>" . $complemento . "</small>";
        } else {
            include('./pagina/oscontrol/includes/ordem_lista.inc.php');
        }
        ?>

    </fieldset>
</div>
<hr>
