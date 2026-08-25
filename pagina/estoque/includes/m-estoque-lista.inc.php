<?php
/*
 * @autor: Paulo Regis 
 * @date: 24/09;2021
 * @object: Auxiliar a listagem e aliviar o pesso do código fonte de
 * estoque.php
 */
$consulta = estq_consLista01($complemento, $numest);
$resultado = retornoSQL($consulta);

$Conta = 12; # limitar listagem
?>
<table width="100%">
    <caption>ESTOQUE - Listagem Geral.</caption>
    <thead>
        <tr>
            <th>C&oacute;digo</th>
            <th>Descri&ccedil;&atilde;o</th>
            <th>Quantidade</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($dados = arraySQL($resultado)) {
            $outroEstoque = FALSE;
            $style = "";
            if ($dados["situacao"] == "inativo") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            
            if($Conta >0){
                
            
            ?>
            <tr class="<?php echo corLinha(); ?>" <?php echo $style; ?>>
                <th>
                    <?php
                    if ($dados["nossonum"] != "") {
                        echo $dados["nossonum"];
                    } else {
                        echo "GT" . $dados["cod"];
                    }
                    ?>
                </th>
                <td>
                    <?php
                    echo $dados["descr"];
                    if ($dados["fabr"] != "") {
                        echo "(".$dados["fabr"].")";
                    } else {
                        echo "";
                    }
                    if($dados["descrtec"] !=""){
                        echo " - " . $dados["descrtec"];
                    }
                    if (atrib("21")) {
                        ?>
                        <a href="index.php?st=estoque&pag=edit&codestq=<?php echo $dados["cod"] ?>">
                            <img src="imagens/editar.gif" alt="" border="no">
                        </a>
                        <?php
                    } else {
                        ?>
                        <a href="index.php?st=estoque&pag=detal&codestq=<?php echo $dados["cod"] ?>">
                            <img src="imagens/editar.gif" alt="" border="no">
                        </a>
                        <?php
                    }
                    ?>
                </td>
                <td>&nbsp;<?php echo $dados["qtd"] ?> <?php echo $dados["und"] ?></td>
                
            </tr>
            <?php
            }
            $Conta--;
        }
        ?>
    </tbody>
    <tr>
        <td colspan="5">
            &nbsp;
        </td>
    </tr>
</table>