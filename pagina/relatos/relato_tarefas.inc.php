<?php
/*
 * @author: Paulo Regis
 * @email: paulo_schw@yahoo.com.br
 * @descript: para listagem das tarefas registradas no GETAR
 */
if (isset($_POST['mesRelato'])) {
    $mesRelato = $_POST['mesRelato'];
} else {
    $mesRelato = DATE("m");
}
if (isset($_POST['anoRelato'])) {
    $anoRelato = $_POST['anoRelato'];
} else {
    $anoRelato = DATE("Y");
}

if (isset($_POST['resp'])) {
    $resp = $_POST['resp'];
} else {
    $resp = $_SESSION['resp'];
}

$consulta = "SELECT  @mes := '" . $mesRelato . "', @ano := '" . $anoRelato . "'"; // SQL de carregamento do mes e ano no banco";
$msg = executaSQL($consulta);


$consulta = "    SELECT codtarf,
                        tipo,
                        dia,
                        CASE 
                            WHEN date_format(diaSemana, '%w') = '0' THEN 'Domingo'
                            WHEN date_format(diaSemana, '%w') = '1' THEN 'Segunda'
                            WHEN date_format(diaSemana, '%w') = '2' THEN 'Terca'
                            WHEN date_format(diaSemana, '%w') = '3' THEN 'Quarta'
                            WHEN date_format(diaSemana, '%w') = '4' THEN 'Quinta'
                            WHEN date_format(diaSemana, '%w') = '5' THEN 'Sexta'
                            WHEN date_format(diaSemana, '%w') = '6' THEN 'Sabado'
                        END AS diaSemana,
                        tempo,
                        horaini,
                        resp,
                        projeto,
                        pedido
                  FROM (
                 SELECT tar.cod codtarf,
                        'Proj' tipo,
                        date_format(tar.dataexc, '%d/%m/%Y') dia,
                        tar.dataexc AS diaSemana,
                        CASE 
                            WHEN tar.horafim = 0 THEN 'Tarefa nao finalizada'
                            WHEN tar.horafim <> 0 THEN TIMEDIFF (tar.horafim, tar.horaini)
                        END tempo,
                        tar.horaini,
                        tar.resp,
                        proj.nome projeto,
                        ped.titulo pedido
                   FROM getar_tarefas tar,
                        getar_pedidos ped,
                        getar_projetos proj
                  WHERE (DATE_FORMAT(tar.dataexc, '%m')= @mes)
                        AND (DATE_FORMAT(tar.dataexc, '%Y')= @ano)
                        AND tar.situacao = 'concluido'
                        AND tar.codped = ped.cod
                        AND ped.codproj = proj.cod
                        AND tar.resp= '" . $resp . "'
             UNION(SELECT tar.cod codtarf,
                        'OS' tipo,
                        date_format(tar.dataexec, '%d/%m/%Y') dia,
                        tar.dataexec AS diaSemana,
                        TIMEDIFF (tar.horafim, tar.horaini) tempo,
                        tar.horaini,
                        tar.tecn resp,
                        CONCAT('OS ', tar.codos) projeto,
                        ' ' pedido
                   FROM ordem_tarf tar
                  WHERE (DATE_FORMAT(tar.dataexec, '%m')= @mes)
                        AND (DATE_FORMAT(tar.dataexec, '%Y')= @ano)
                        AND tar.situ = 'concluida'
                        AND tar.tecn='" . $resp . "')
             UNION(SELECT tar.cod codtarf,
                        opr.clasf tipo,
                        date_format(tar.dataexc, '%d/%m/%Y') dia,
                        tar.dataexc AS diaSemana,
                        TIMEDIFF (tar.horafim, tar.horaini) tempo,
                        tar.horaini,
                        tar.resp resp,
                        opr.nome projeto,
                        ' ' pedido
                   FROM getar_opera opr,
                        getar_tarfopera tar
                  WHERE opr.cod = tar.codopera
                        AND (DATE_FORMAT(tar.dataexc, '%m')= @mes)
                        AND (DATE_FORMAT(tar.dataexc, '%Y')= @ano)
                        AND tar.situacao = 'concluida'
                        AND tar.resp='" . $resp . "')) AS grp
             ORDER BY dia, horaini";
$resultado = retornoSQL($consulta);
$row = rowsSQL($resultado);
if ($row < 1) {
    echo "N&atilde;o h&aacute; tarefas em andamento";
} else {
    ?>
    <div class="titulo">LISTAGEM DE TAREFAS (<?php echo mesExtBR($mesRelato) . " de " . $anoRelato; ?>)</div>
    <div class="sub-titulo">Projetos: programa&ccedil;&atilde;o, eletr&ocirc;nicos  e Ordens de Servi&ccedil;o.</div>
    <table width="100%">
        <tr>
            <td class="sub-titulo">Data</td>
            <td class="sub-titulo">Dura&ccedil;&atilde;o</td>
            <td class="sub-titulo">Cod. Tarf.</td>
            <td class="sub-titulo">Tipo</td>
            <td class="sub-titulo">Respons&aacute;vel</td>
            <td class="sub-titulo">Projeto/Ordem</td>
            <td class="sub-titulo">Pedido</td>
        </tr>
        <?php
        $diaSemAnt = "";
        while ($dados = arraySQL($resultado)) {

            if ($diaSemAnt <> $dados["diaSemana"]) {
                if ($diaSemAnt <> "") {
                    echo "<tr class=\">" . corLinha() . "\">                  
                        <td>&nbsp;</td>
                        <td class=\"sub-titulo\">Parcial:</td>
                        <td class=\"sub-titulo\">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>";
                }
                ?>
                <td class="sub-titulo"><?php echo $dados["dia"] . " - " . $dados["diaSemana"]; ?></td>
                <?php
                $diaSemAnt = $dados["diaSemana"];
            }
            ?>
            <tr class="<?php echo corLinha(); ?>" onmouseover="this.className = 'corLinhaAtiva'" onmouseout="this.className = '<?php echo corLinha(0); ?>'">
                <td>&nbsp;</td>
                <td><?php echo $dados['tempo']; ?></td>
                <td><?php echo $dados["codtarf"]; ?></td>
                <td><?php echo $dados["tipo"]; ?></td>
                <td><?php echo $dados['resp']; ?></td>
                <td><?php echo $dados['projeto']; ?>&nbsp;</td>
                <td><?php echo $dados['pedido']; ?>&nbsp;</td>
            </tr>
            <?php
        }
        echo "<tr class=\">" . corLinha() . "\">                  
                        <td>&nbsp;</td>
                        <td class=\"sub-titulo\">Parcial:</td>
                        <td class=\"sub-titulo\">&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>";
        ?>
    </table>
    <?php
}
?>
