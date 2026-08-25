<?php
/*
 * Autor: Paulo Regis S. Schwingel
 * Data criacao: 18/10/2024
 * Descricao: Para listagem de pedido de consumo para pedidos de projetos eletronicos
 * Vindo da arquivo: pedido.php
 * Revisoes:
 */

// Listagem previa
$consulta = $est->pedidoList($complemento);
  $resultado = retornoSQL($consulta);
?>
<?php echo $tipoList; ?>
<div id="lista de pedidos">
    <table width="100%">
        <tr>
            <td class='sub-titulo'>Num. Pedido</td>
            <td class='sub-titulo'>Fornecedor/Cliente</td>
            <td class='sub-titulo'>Tipo</td>
            <td class='sub-titulo'>Situ. Pedido</td>
            <td class='sub-titulo'>Qtd. Itens</td>
        </tr>
        <?php
        while ($dados = arraySQL($resultado)) {        
            $style = "";
            if ($dados["situ"] == "cancelado") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>
            <tr class="<?php echo corLinha(); ?> " <?php echo $style; ?>>
                <td class="txt"><?php echo $dados['codpedido']; ?></td>
                <?php
                if ($dados['tipo'] == "compra") {
                    ?>
                    <td class="txt"><b>Fornecedor:&nbsp;</b> <?php echo $dados['forn']; ?><br />
                        <?php
                    } else {
                        ?>
                    <td class="txt"><b>Cliente:&nbsp;</b><?php echo $dados['cli']; ?><br />
                        <?php
                    }
                    if ($dados['tipo'] == "venda") {
                        echo $dados['equipo'];
                    } elseif ($dados['tipo'] == "consumo") {
                        if ($dados['projeto'] == "") {
                            echo $dados['nomeped'];
                        } else {
                            echo $dados['projeto'];
                        }
                    }
                    if ($dados['tipo'] == "compra") {
                        if ($dados['nomeped'] == "") {
                            echo "Reposi&ccedil;&atilde;o";
                        } else {
                            echo $dados['nomeped'];
                        }
                    }
                    ?>
                    <a href="index.php?st=pedido&pag=ped_edit&codped=<?php echo $dados['codpedido']; ?>">
                        <img src="imagens/editar.gif" alt="" border="no">
                    </a>
                    <a href="index.php?st=pedido&pag=ped_ldetal&codped=<?php echo $dados['codpedido']; ?>">
                        <img src="imagens/livro.gif" alt="" border="no">
                    </a>
                    <a href="impress.php?st=estoque&pag=list_ped&codped=<?php echo $dados['codpedido']; ?>" target="_blank">
                        <img src="imagens/impress.jpeg" alt="" border="no" width="16" height="16">
                    </a>
                </td>
                <td class="txt"><?php echo $dados["desctipo"]; ?></td>
                <?php
                if ($dados['situ'] == "estudo") {
                    $situ = "orcamento";
                } else {
                    $situ = $dados['situ'];
                }
                ?>
                <td class="txt"><?php echo $situ; ?> </td>
                <td class="txt"><?php echo $dados["qtitens"]; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<hr/>
