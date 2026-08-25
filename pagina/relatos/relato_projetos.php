<?php
//Consulta estuda em consulta_proj_geral.sql
$consulta = "(SELECT pd.cod,
                     pd.codproj,
                     'eletro' tipoProj,
                     pj.nome,
                     pd.titulo,
                     pd.resp,
                     pd.dataini,
                     date_format(pd.dataini, '%d/%m/%Y') AS dataAgendada,
                     date_format(pd.dataclc, '%d/%m/%Y') AS dataFim,
                     CASE 
                         WHEN date_format(pd.dataini, '%w') = '0' THEN 'Domingo'
                         WHEN date_format(pd.dataini, '%w') = '1' THEN 'Segunda'
                         WHEN date_format(pd.dataini, '%w') = '2' THEN 'Terca'
                         WHEN date_format(pd.dataini, '%w') = '3' THEN 'Quarta'
                         WHEN date_format(pd.dataini, '%w') = '4' THEN 'Quinta'
                         WHEN date_format(pd.dataini, '%w') = '5' THEN 'Sexta'
                         WHEN date_format(pd.dataini, '%w') = '6' THEN 'Sabado'
                     END AS diaSemana
                FROM eletro_pedidos pd,
                     eletro_projetos pj
               WHERE pj.cod = pd.codproj
                     AND pd.situacao = 'a')
              UNION(
              SELECT pd.cod,
                     pd.codproj,
                     'proga' tipoProj,
                     pj.nome,
                     pd.titulo,
                     pd.resp,
                     pd.dataini,                     
                     date_format(pd.dataini, '%d/%m/%Y') AS dataAgendada,
                     date_format(pd.dataclc, '%d/%m/%Y') AS dataFim,
                     CASE 
                         WHEN date_format(pd.dataini, '%w') = '0' THEN 'Domingo'
                         WHEN date_format(pd.dataini, '%w') = '1' THEN 'Segunda'
                         WHEN date_format(pd.dataini, '%w') = '2' THEN 'Terca'
                         WHEN date_format(pd.dataini, '%w') = '3' THEN 'Quarta'
                         WHEN date_format(pd.dataini, '%w') = '4' THEN 'Quinta'
                         WHEN date_format(pd.dataini, '%w') = '5' THEN 'Sexta'
                         WHEN date_format(pd.dataini, '%w') = '6' THEN 'Sabado'
                     END AS diaSemana
                FROM getar_pedidos pd,
                     getar_projetos pj
               WHERE pj.cod = pd.codproj
                     AND pd.situacao = 'a')
              ORDER BY dataini";
$resultado = retornoSQL($consulta);
$row = rowsSQL($resultado);
if ($row < 1) {
    echo "N&atilde;o h&aacute; Pedidos de projetos em andamento";
} else {
    ?>
    <table width="100%">
        <tr>
            <td class='sub-titulo'>Data In&iacute;cio</td>
            <td class='sub-titulo'>Data Fim</td>
            <td class='sub-titulo'>Sequencia</td>
            <td class='sub-titulo'>Responsavel</td>
            <td class='sub-titulo'>Projeto</td>
            <td class='sub-titulo'>Pedido</td>
        </tr>
        <?php
        $dataAgdAnt= "";
        while ($dados = arraySQL($resultado)) {
            ?>
            <tr class="<?php echo corLinha(); ?>" onmouseover="this.className = 'corLinhaAtiva'" onmouseout="this.className = '<?php echo corLinha(0); ?>'">
                <?php
                if ($dataAgdAnt <> $dados["dataAgendada"]) {
                    ?>
                    <td class="sub-titulo"><?php echo $dados["dataAgendada"] . " - " . $dados["diaSemana"] ?></td>
                    <?php
                    $dataAgdAnt = $dados["dataAgendada"];
                } else {
                    echo "<td>&nbsp;</td>";
                }
                ?>
                <td class="txt"><?php echo $dados["dataFim"] ?></td>
                <td>
                    <?php
                    echo "Projeto: ".$dados['codproj']." Pedido:". $dados['cod'];
                    if ($dados['tipoProj'] == "eletro") {
                        ?>
                        <a href="index.php?st=ped_eletro&pag=edit&codped=<?php echo $dados['cod']; ?>&codproj=<?php echo $dados['codproj']; ?>">
                            <img src="imagens/editar.gif" border="0" alt="Edita" title="Edita pedido">
                        </a>
                        <a href="index.php?st=tarf_eletro&pag=list_all&codped=<?php echo $dados['cod']; ?>">
                            <img src="imagens/livro.gif" alt="Lista" title="Lista Tarefas">
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="index.php?st=pedidos&ft=prj&pag=edit&codped=<?php echo $dados['cod']; ?>&codproj=<?php echo $dados['codproj']; ?>">
                            <img src="imagens/editar.gif" border="0" alt="Edita" title="Edita pedido">
                        </a>
                        <a href="index.php?st=tarefas&ft=prj&pag=list_all&codped=<?php echo $dados['cod']; ?>">
                            <img src="imagens/livro.gif" alt="Lista" title="Lista Tarefas">
                        </a>
                        <?php
                    }
                    ?>
                </td>
                <td class="txt"><?php echo $dados["resp"] ?></td>
                <td class="txt"><?php echo $dados["nome"]; ?></td>
                <td class="txt"><?php echo $dados["titulo"]; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}
?>
<hr>
