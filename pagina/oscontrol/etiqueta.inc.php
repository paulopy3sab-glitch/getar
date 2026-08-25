<?php
include './pagina/oscontrol/funcoes_os.php';
#include './pagina/oscontrol/funcoes_oscons.php';

$codOS = $_GET['codos'];

$consulta = "    SELECT cad.nome,
                        cad.cpcn,
                        cad.cnpj,
                        cad.endr,
                        cad.bairro,
                        cad.cep,
                        cad.cidade,
                        cad.estado,
                        (SELECT fn.numero FROM getar_fones fn WHERE fn.codcli = cad.cod LIMIT 1) fone,
                        cad.pais
                  FROM ordem ord,
                       getar_cad cad
                 WHERE ord.codcli = cad.cod
                       AND ord.cod=" . $codOS;
$dados = consultaSQL($consulta);
?>
<fieldset>
    <legend>Destinat&aacute;rio</legend>
    <table width="100%">
        <tr>
            <td colspan="2">
                <?php
                echo $dados['nome'];
                if ($dados['cnpj'] <> "") {
                    echo " - CNPJ: " . $dados['cnpj'];
                } else {
                    echo " - CPF: " . $dados['cpcn'];
                }
                ?></td>
        </tr>
        <tr>
            <td colspan="2">Telefone:&nbsp;<?php echo $dados['fone']; ?></td>
        </tr>
        <tr>
            <td><?php echo $dados['endr']; ?></td>
            <td>Bairro:&nbsp;<?php echo $dados['bairro']; ?></td>
        </tr>
        <tr>
            <td><label>CEP:&nbsp;</label><?php echo $dados['cep']; ?></td>
            <td><?php echo $dados['cidade'] . "/" . $dados['estado'] . "/" . $dados['pais']; ?></td>
        </tr>
    </table>
</fieldset>
<fieldset>
    <legend>Remetente</legend>
    <?php
    $consulta = "    SELECT cad.nome,
                        cad.cnpj,
                        cad.endr,
                        cad.bairro,
                        cad.cep,
                        cad.cidade,
                        cad.estado,
                        (SELECT fn.numero FROM getar_fones fn WHERE fn.codcli = cad.cod LIMIT 1) fone,
                        cad.pais
                  FROM getar_cad cad
                 WHERE cad.cod= 2";
$dados = consultaSQL($consulta);
?>
    <table width="100%">
        <tr>
            <td colspan="2"><?php
                echo $dados['nome']." - CNPJ: " . $dados['cnpj']; ?></td>
        </tr>
        <tr>
            <td colspan="2">Telefone:&nbsp;<?php echo $dados['fone']; ?></td>
        </tr>
        <tr>
            <td><?php echo $dados['endr']; ?></td>
            <td>Bairro:&nbsp;<?php echo $dados['bairro']; ?></td>
        </tr>
        <tr>
            <td><label>CEP:&nbsp;</label><?php echo $dados['cep']; ?></td>
            <td><?php echo $dados['cidade'] . "/" . $dados['estado'] . "/" . $dados['pais']; ?></td>
        </tr>
    </table>
</fieldset>
