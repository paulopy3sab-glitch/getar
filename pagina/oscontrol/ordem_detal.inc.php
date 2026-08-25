<?php
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
<!-- edicao de uma OS -->
<form name="formulario" action="index.php?st=ordm&pag=edit&codos=<?php echo $codOS; ?>" method="post">
    <fieldset>
        <legend>REGISTRO DA OS</legend>
        <label>Equipamento: </label><b><?php echo $dados['equipamento']; ?></b><br>
        <label>OS C&oacute;digo: </label><b><?php echo $codOS; ?></b><br>
        <label>Cliente:</label>
        <b><?php echo $dados['cliente']; ?></b><br>
        <label>T&eacute;cnico: </label>
        <b><?php echo $dados['resp'] ?></b><br>
        <label>Data de entrada: </label><b><?php echo $dados['entd']; ?></b><br>
        <label>Data de fechamento: </label><b><?php echo $dados['fcd']; ?></b><br>
        <label>Data de sa&iacute;da: </label><b><?php echo $dados['sd']; ?></b><br>
        <label>Situa&ccedil;&atilde;o OS:</label><b><?php echo $dados["situ"]; ?></b><br>
        <label>Situa&ccedil;&atilde;o do equipamento:</label><b><?php echo $dados["situequip"]; ?></b><br>
        <label>Defeito reclamado: </label><b><?php echo $dados["recla"]; ?></b><br>
        <label>Defeito encontrado: </label><b><?php echo $dados["encr"]; ?></b><br>
        <label>Servico executado: </label><b><?php echo $dados["serv"]; ?></b><br>        
        <label>Observa&ccedil;&atilde;o: </label><b><?php echo ordemObs($codOS); ?></b><br>
        <label>Faturada: </label><b><?php echo $dados["fatu"]; ?></b><br>
        <label>Valor cobrado:</label><b><?php echo $dados["valcb"]; ?></b><br>
    </fieldset>
</form>
<?php
$consulta = "SELECT cod FROM estpedidocab WHERE tipo = 'venda' AND ospro = " . $codOS;
$resultado = mysqli_query($conexao, $consulta);
$dadosPesq = mysqli_fetch_assoc($resultado);
if ($dadosPesq['cod'] <> "") {
    echo pedidoLista($dadosPesq['cod']);
}

echo "<div id=\"divTarfOS\">" . tarfList($codOS, FALSE) . "</div>"
        . "<hr>";
