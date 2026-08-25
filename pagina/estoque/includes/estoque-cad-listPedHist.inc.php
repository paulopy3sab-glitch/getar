<?php
/*
 * Para criar futura funcao ou metodo
 * Listagem de pedidos compra Reposicao ou Venda/Consumo para o produto em foco
 * Autor: Paulo Regis
 * Data:
 * 30/05/2024 - 
 */

$consulta= " SELECT cb.cod codped,# ver linha 1578
                    cad.nome,
                    (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo)
                       FROM eletro_projetos pj,
                            eletro_pedidos pd
                      WHERE pj.cod = pd.codproj
                            AND pd.cod = cb.ospro) projetoEletro,
                    (SELECT CONCAT('Projeto Eletronico: ', pj.nome, ' - ',pd.titulo)
                       FROM getar_projetos pj, getar_pedidos pd
                      WHERE pj.cod = pd.codproj
                            AND pd.cod = cb.ospro) projeto,
                    (SELECT CONCAT('OS Numero: ', od.cod, ' - ', eq.descr, ' - ', eq.marca, ' - ', eq.modelo)
                       FROM ordem od, equipo eq
                      WHERE od.cod = cb.ospro
                            AND od.codeqp = eq.cod) equipo,
                    (SELECT CONCAT('Quantidade: ', qt, ' - Custo: ', custo)
                       FROM estpedidoitem
                      WHERE codped = cb.cod
                            AND codest = it.codest LIMIT 1) qtcst,
                    (SELECT codest
                       FROM estpedidoitem
                      WHERE codped = cb.cod
                            AND codest = it.codest LIMIT 1) codest,
                    (SELECT COUNT(*)
                       FROM estpedidoitem 
                      WHERE codped = cb.cod
                            AND codest = it.codest) AS numitem,
                    cb.situ,
                    cb.tipo
               FROM estpedidocab cb,
                    estpedidoitem it,
                    getar_cad cad
              WHERE cb.cod = it.codped
                    AND cad.cod = cb.codcli
                    AND cb.tipo IN ('venda', 'consumo')
                    AND it.codest =". $dados['cod'];
$retPesq = retornoSQL($consulta);
        $rows = rowsSQL($resultado);
$str = "<fieldset><legend>PEDIDOS DE VENDA/CONSUMO DE: " . $dados['descr'] . "</legend>";
$str2 = "";

while ($dadosPesq = arraySQL($retPesq)) {
        echo $str;
        echo "<b>Pedido de " . $dadosPesq['tipo'] . " n&uacute;mero:</b> " . $dadosPesq['codped'] . " ";
        if ($dadosPesq['situ'] == "processamento") {
            echo "<b style=\"color: red;\">(Em processamento)</b>
                  <a href=\"index.php?st=estoque&pag=ped_edit&codped=" . $dadosPesq['codped'] . "\">
                      <img src=\"imagens/visto.gif\" alt=\"\" border=\"no\">
                  </a><br>";
        }
        if ($dadosPesq['tipo'] == "venda") {
            echo $dadosPesq['equipo'] . "<br>";
            echo "<b>Cliente: </b>" . $dadosPesq['nome'] . "<br>";
        } else {
            if($dadosPesq['projetoEletro']){
                echo "<b>".$dadosPesq['projetoEletro'] . "</b><br>";
            }  else {
                echo "<b>".$dadosPesq['projeto'] . "<b><br>";
            }
            if ($dadosPesq['numitem'] > 1) {
                echo "<b style=\"color: red;\">Este item esta cadastrado " . $dadosPesq['numitem'] . " vezes neste pedido</b><br>";
            }
        }
        echo $dadosPesq['qtcst'];
        if ($dadosPesq['situ'] == "processamento") {
            ?>
            <a href="index.php?st=estoque&pag=edit&codestq=<?php echo $dados["cod"]; ?>&inped=<?php echo $dadosPesq['codped']; ?>">
                <img src="imagens/visto.gif" alt="" border="no">
            </a>
            <?php
            echo "<a href=\"index.php?st=estoque&pag=excitem&codestq=" . $dados["cod"] . "&codped=" . $dadosPesq['codped'] . "\">
                      <img src=\"imagens/lixo.gif\" alt=\"\" border=\"0\">
                  </a>";
        }
        echo "<br><br>";
        $str = "";
        $str2 = "</fieldset>";
}
echo $str2;
?>
