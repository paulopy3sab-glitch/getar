<?php
/*
 * @autor: Paulo Regis 
 * @date: 24/09;2021
 * @object: Auxiliar a listagem e aliviar o pesso do código fonte de
 * estoque.php
 */

$consulta = $est->estq_consLista01($complemento, $numest);
$pagina = 1;

/* if (!$blcPag) {
  if (isset($_GET['pagina'])) {
  $pagina = $_GET['pagina'];
  }
  $resultado = gerapaginacao($consulta, $pagina, "");
  } else {
  $resultado = retornoSQL($consulta);
  }
 */

$resultado = retornoSQL($consulta);
$msgList = "Listagem Geral.";
?>
<table width="100%">
    <caption>ESTOQUE - <?php echo $msgList; ?>.</caption>
    <tr style="background-color: white;">
        <?php
        $contaProd = 0;
        $contaLinhas = 1;
        while ($dados = arraySQL($resultado)) {
            ?>

            <td style="text-align: center;">
                <h3> <?php echo $dados["descr"]; ?></h3>
                <h3><?php echo $dados["descrcatg"]; ?> - <?php echo $dados["descrsubcatg"]; ?></h3>
                <br />
                <a href="index.php?st=estoque&pag=edit&codestq=<?php echo $dados["cod"]; ?>">
                    <img src="<?php echo $pastaDocs; ?>imagens/<?php echo $dados["imagem"]; ?>" alt="" border="no"  height="64px">
                </a><br />
                <h3><?php echo $dados["qtd"]. " ". $dados["und"]; ?></h3>

            </td>
            <?php
            # quebrando linha
            if ($contaLinhas == 4) {
                ?>
            </tr>
            <tr>
                <td colspan="4">
                    <hr style="color: brown;" />
                </td>
            </tr>
            <tr style="background-color: white;">
                <?php
                $contaLinhas = 0;
            }
            $contaProd++;
            $contaLinhas++;
        }
        ?></tr>
</tbody>
</table>
<?php
echo prim20($contaProd);
?>