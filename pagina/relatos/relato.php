<?php
/**
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: indeterminada
 * Descricao: relatorio horas trabalhadas em tarefas de pedidos eletronicos, programacao e OSs
 * Revisoes: 17/07/2016 - pregis
 *           troca para mysqlI_ e revisoes
 */
if (isset($_GET['pag'])) {
    $pag = $_GET['pag'];
} else {
    $pag = "list";
}
switch ($pag) {
    case 'tarefas':
        include 'relato_tarefas.inc.php';
        break;
    case 'form':
        ?>
        <form action="index.php?st=relato_tarefas" method="post">
            <table width="640px" border="1">
                <tr> 
                    <td valign="top">
                        <label>Mes/Ano:</label>
                        <?php
                        echo selectData("Relato", "xx");
                        ?>
                    </td>
                    <?php
                    $consulta = "SELECT cad.nome,
                                ctl.nick
                          FROM  getar_control ctl,
                                getar_cad cad
                          WHERE ctl.codcad = cad.cod
                                AND cad.situacao = 'ativo' ";
                    $retorno = retornoSQL($consulta);
                    ?>
                    <td valign="top" align="center">
                        <label> Reponsavel:</label>
                        <select name="resp" type="menu">
                            <option value="">Todos</option>
                            <?php
                            while ($dados = arraySQL($retorno)) {
                                echo "<option value=\"" . $dados["nick"] . "\" >" . $dados["nome"] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td valign="top" align="center">
                        <input type="submit" name="Enviar" value="Enviar">
                    </td>
                </tr>
            </table>
        </form>
        <?php
        break;
    default :
        include 'relato_tarefas.inc.php';
        break;
}
?>

<!--
*** RODAPE
-->
<hr>
<div id="opcoes">
    <div id="elemento">
        <a href="index.php?st=relato_tarefas&pag=tarefas">
            <img src="imagens/listar_plan.jpg" alt="Nova Tarefa" title="Criar nova tarefa para o Operacao"><br>
            Listar Suas.
        </a>
    </div>
    <?php
    if ($cad->atrib("42")) {
        ?>
        <div id="elemento">
            <a href="index.php?st=relato_tarefas&pag=form">
                <img src="imagens/listar_.jpg" alt="Nova Tarefa" title="Criar nova tarefa para o Operacao"><br>
                Listagem Seletiva.
            </a>
        </div>
        <?php
    }
    ?>
</div>
