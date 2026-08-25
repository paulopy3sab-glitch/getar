<?php
/*
 * Para listagem dos Equipamentos cadastrados
 * @author Paulo Regis <paulo_schs@yahoo.com.br>
 * @date 11/07/2024
 */
/*if ($pag == "pesq") {# Pesquisa por string no modelo do equipamento
    $string = $_POST['string'];
    $consulta = $OS->os_cons4($string) . $complemento;
} else {*/
    $consulta = $OS->os_cons3($complemento);
# }
#$resultado = geraPaginacao($consulta, $pagList);
$resultado = retornoSQL($consulta);
?>
<table id="listeqp">
    <caption>Equipamentos - Listagem Geral.</caption>
    <thead>
        <tr>
            <th>Cod.</th>
            <th>Cliente</th>
            <th>Descri&ccedil;&atilde;o</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>OSs</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $conta = 0;
        while ($dados = arraySQL($resultado)) {# $OS->arraySQL() erro de chamada de objeto protegido
            $style = "";
            if ($dados["situeqp"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>
            <tr class="<?php echo corLinha(); ?>" <?php echo $style; ?>>
                <th><?php echo $dados['codeqp']; ?></th>
                <td><?php echo $dados['cliente']; ?></td>
                <td><?php echo $dados['descr']; ?>
                    <a href="index.php?st=eqp&pag=edit&codeqp=<?php echo $dados["codeqp"]; ?>">
                        <img src="imagens/editar.gif" alt="Editar" title="Editar este equipamento">
                    </a>
                </td>
                <td><?php echo $dados['marca']; ?></td>
                <td><?php echo $dados['modelo']; ?></td>
                <td>
                    <?php
                    switch ($dados['situos']) {
                        case "fechada":
                            $situOS = "FECHADA";
                            break;
                        case "aberta":
                            $situOS = "ABERTA";
                            break;
                        case "espera":
                            $situOS = "ESPERA";
                            break;
                        case "cancelada":
                            $situOS = "CANCELADA";
                            break;
                        case "programada":
                            $situOS = "PROGRAMADA";
                            break;
                    }
                    ?>           
                    <a href="index.php?st=ordm&pag=edit&codos=<?php echo $dados["codos"]; ?>">
                        OS<?php echo $dados['codos'] . " - " . $situOS; ?>
                    </a>
                </td>
            </tr>
            <?php
            $conta++;
        }
        ?>
    </tbody>
</table>
<?php
/* $doc = "index.php?st=eqp&pag=" . $pag;
  echo geraIndicesPaginas($pagList, $doc); */
echo prim20($conta);
?>
