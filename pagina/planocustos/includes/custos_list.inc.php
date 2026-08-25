<?php
/*
 * Descricao:
 * Listagem dos tecnicos trabalhando em OSs e colaboradores.
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * @date: 22/04/2025
 * 
 * Revisions:
 */

$consulta = "SELECT cad.cod,
               cad.nome,
               ctl.nick,
               ctl.custohora,
               cad.situacao
          FROM getar_control ctl,
               getar_cad cad
         WHERE cad.cod= ctl.codcad " . $complemento;
$resultado = retornoSQL($consulta);
?>
<table width="100%">
    <caption>LISTAGEM DOS COLABORADORES</caption>
    <thead>
        <tr>
            <th>C&oacute;d</th>
            <th>Nome</th>
            <th>Custo</th>
        </tr>
    </thead>
    <tbody><?php
        while ($dados = arraySQL($resultado)) {
            $style = "";
            if ($dados["situacao"] == "cancelado") {
                $style = " style=\"text-decoration:line-through;\"";
            }
            ?>
            <tr <?php echo $style; ?> class="<?php echo corLinha(); ?>">
                <td><?php echo $dados["cod"]; ?></td>
                <td><?php echo $dados["nome"] . "(" . $dados["nome"] . ")"; ?>
                    <a href="index.php?st=custos&pag=edit&codcad=<?php echo $dados['cod']; ?>">
                        <img src="imagens/editar.gif" alt="" border="0">
                    </a>
                </td>
                <td><?php echo $dados["custohora"]; ?></td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
