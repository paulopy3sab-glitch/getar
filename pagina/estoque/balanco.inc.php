<?php
/**
 * Description:
 * Relatorio balanco tipo totalizador
 *
 * @author Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 11 de Maio de 2023
 * Revision: 23/10/2023
 *     Balanco patrimonial
 * 
 */
$consulta = " SELECT SUM(subtotal) totalgeral
                FROM (SELECT @subtotal := qtd * valorcusto subtotal
                             FROM estoque
                       WHERE qtd > 0
                             AND situacao= 'normal'
                             AND numest= 1
                             AND clasf NOT IN('ne') # produtos nao estocado
                             AND valorcusto > 0) AS grp";
$dados = consultaSQL($consulta);
?>
<fieldset>
    <legend>Bala&ccedil;o Totalizador</legend>
    <label>Total estocado a preco custo:</label>
    <b style="background-color: white"><?php echo formatarValorPadrao($dados['totalgeral'], TRUE); ?></b><br>
    <?php
    $consulta = " SELECT COUNT(*) semvalor FROM estoque WHERE valorvenda = 0";
    $dados = consultaSQL($consulta);
    ?>
    <label>Itens sem valor de Venda:</label>
    <b style="background-color: white"><?php echo $dados['semvalor']; ?></b><br>
    <?php
    $consulta = " SELECT COUNT(*) semvalor FROM estoque WHERE valorcusto = 0";
    $dados = consultaSQL($consulta);
    ?>
    <label>Itens sem valor de Custo:</label>
    <b style="background-color: white"><?php echo $dados['semvalor']; ?></b><br>
    <?php
    $consulta = " SELECT COUNT(*) recebido FROM estpedidocab WHERE tipo='compra' AND DATE_FORMAT(dtrecb, '%m/%y') = DATE_FORMAT(CURDATE(), '%m/%y')";
    $dados = consultaSQL($consulta);
    ?>
    <label>Pedidos recebidos no m&ecirc;s:</label>
    <b style="background-color: white"><?php echo $dados['recebido']; ?></b><br>
    <?php
    $consulta = " SELECT COUNT(*) recebido FROM estpedidocab WHERE tipo='compra' AND DATE_FORMAT(dtped, '%m/%y') = DATE_FORMAT(CURDATE(), '%m/%y')";
    $dados = consultaSQL($consulta);
    ?>
    <label>Pedidos abertos m&ecirc;s:</label>
    <b style="background-color: white"><?php echo $dados['recebido']; ?></b><br>
</fieldset>
<?php
$consulta = " SELECT SUM(subtotal) totalgeral
                FROM (SELECT @subtotal := qtd * valorcusto subtotal
                             FROM estoque
                       WHERE qtd > 0
                             AND situacao= 'normal'
                             AND numest= 1
                             AND catg= 5
                             AND clasf = 'ne' # produtos nao estocado
                             AND valorcusto > 0) AS grp";
$dados = consultaSQL($consulta);
?>
<fieldset>
    <legend>Balan&ccedil;o Patrimonial</legend>
    <label>Totalizador de Ferramentas:</label>
    <b style="background-color: white"><?php echo formatarValorPadrao($dados['totalgeral'], TRUE); ?></b><br>
    <?php
    $consulta = " SELECT SUM(subtotal) totalgeral
                    FROM (SELECT @subtotal := qtd * valorcusto subtotal
                                 FROM estoque
                           WHERE qtd > 0
                                 AND situacao= 'normal'
                                 AND numest= 1
                                 AND catg= 6
                                 AND clasf = 'ne' # produtos nao estocado
                                 AND valorcusto > 0) AS grp";
    $dados = consultaSQL($consulta);
    ?>
    <label>Totalizador de Instrumentos:</label>
    <b style="background-color: white"><?php echo formatarValorPadrao($dados['totalgeral'], TRUE); ?></b><br>
    
</fieldset>

