<?php
/*
 * Aquivo de listagem para estudos
 * Pegado de ordem.php
 */
?>
<table width="100%">        
    <caption>LISTAGEM DE ORDENS DE SERVI&Ccedil;O</caption>
    <thead>
        <tr>
            <th>OS N&uacute;mero</th>
            <th>Cliente</th>
            <th>Modelo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $Conta = 0;
        while ($dados = arraySQL($resultado)) {
            ?>
            <tr class="<?php echo corLinha(); ?>">
                <th>
                    <?php echo $dados['cod']; ?>
                </th>
                <td>
                    <?php
                    echo $dados['cliente'];
                    ?>
                </td>
                <td>
                    <?php echo $dados['modelo']; ?>
                    <a href="index.php?st=ordm&pag=edit&codos=<?php echo $dados['cod']; ?>" target="blank">
                        <img src="imagens/editar.gif" border="0" alt="">
                    </a>
                </td>
            </tr>
            <?php
            $Conta++;
        }
        ?>
    </tbody>
</table>

