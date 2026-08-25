<?php
/**
 *
 * @global <type> $conexao
 * @global <type> $arquivo
 * @param <type> $tabela 
 */
function escreveArq($tabela) {
    global $conexao;

    $arquivo= fopen("backup/getar".$tabela.".txt","w");
    $consulta = "SELECT * FROM ".$tabela;
    $resultado = mysqli_query($conexao, $consulta);
    $numCampos= mysqli_num_fields($resultado);

    fwrite($arquivo,"-- Tabela ".$tabela.".\n");
    fwrite($arquivo,"TRUNCATE ".$tabela.";\n");
    while ($linha = mysqli_fetch_row($resultado)) {
        fwrite($arquivo,"INSERT INTO ".$tabela." VALUES(");
        for ($loop = 0; $loop < $numCampos- 1; $loop++) {
            fwrite($arquivo," '".$linha[$loop]."',");
        }
        fwrite($arquivo," '".$linha[$loop]."')\n");
    }
    fclose($arquivo);
}


function geraSQL($tabela) {
    global $conexao;

    echo "<h1>".$tabela."</h1>";
    echo '<textarea cols=160 rows=40 name="'.$tabela.'" >';
    $consulta = "SELECT * FROM ".$tabela;
    $resultado = mysqli_query($conexao, $consulta);
    $numCampos= mysqli_num_fields($resultado);

    echo "-- Tabela ".$tabela.".\n";
    echo "TRUNCATE ".$tabela.";\n";
    while ($linha = mysqli_fetch_row($resultado)) {
        echo "INSERT INTO ".$tabela." VALUES(";
        for ($loop = 0; $loop < $numCampos- 1; $loop++) {
            echo " '".$linha[$loop]."',";
        }
        echo " '".$linha[$loop]."');\n";
    }
    echo '</textarea>';
}

?>

<div align="left">
    <?php
    switch ($pag) {
        case 'SQL':
            echo "Criando Arquivos de Backup.";
            //Tabela de clientes
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM getar_cad WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL("getar_cad");
            //Tabela de senhas
            geraSQL("getar_control");

            //Tabela de mensagens
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM ".$tabMensagens." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL($tabMensagens);
            //Tabela de lembretes
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM ".$tabLembretes." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL($tabLembretes);
            //Tabela de chamadas dos artigos
            geraSQL($tabArtgCh);
            //Tabela de artigos revistas
            geraSQL($tabArtgRv);
            //Tabela de artigos fotos
            geraSQL($tabArtgFt);
            //Tabela de artigos linhas
            geraSQL($tabArtgLn);
            //Tabela de artigos imagens
            geraSQL($tabArtgFtImg);

            //Tabela de contas classificacao
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM ".$tabContaClasf." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL($tabContaClasf);
            //Tabela de contas correntes
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM ".$tabContaCor." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL($tabContaCor);
            //Tabela de contas nomes
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM ".$tabContaNome." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL($tabContaNome);
            //Tabela de cadastro de financeiros
            geraSQL($tabFinanceiro);
            //Tabela dos carnes a pagar e receber
            geraSQL($tabCarne);
            //Tabela das parcelas dos carnes a pagar e receber
            geraSQL($tabCarneParcela);

            //Tabela de projetos
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM ".$tabProjetos." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL($tabProjetos);
            //Tabela de pedidos
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM ".$tabPedidos." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL($tabPedidos);
            //Tabela tarefas
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM ".$tabTarefas." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL($tabTarefas);

            //Tabela tarefas
            //Limpeza dos registro temporarios
            $consulta = "DELETE FROM ".$tabHistoricos." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            geraSQL($tabHistoricos);
            
            //echo "<a href=\"backup/getar.txt\" target=\"_blank\">Donwload do arquivo</a>";
            break;
        case 'local':
            echo "Copiando Arquivo Backup (".$localBackup.")".
                /**
                 * Limpesa de todos os registros temporarios
                 */
                //Tabela de clientes
                $consulta = "DELETE FROM getar_cad WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);

            //Tabela de mensagens
            $consulta = "DELETE FROM getar_mens WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            //Tabela de lembretes
            $consulta = "DELETE FROM getar_lembre WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);

            //Tabela de contas classificacao
            $consulta = "DELETE FROM ".$tabContaClasf." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            //Tabela de contas correntes
            $consulta = "DELETE FROM ".$tabContaCor." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            //Tabela de contas nomes
            $consulta = "DELETE FROM ".$tabContaNome." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);

            //Tabela de projetos
            $consulta = "DELETE FROM ".$tabProjetos." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            //Tabela de pedidos
            $consulta = "DELETE FROM ".$tabPedidos." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            //Tabela tarefas
            $consulta = "DELETE FROM ".$tabTarefas." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);

            //Tabela de vendas
            $consulta = "DELETE FROM ".$tabVendas." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);
            //Tabela tarefas
            $consulta = "DELETE FROM ".$tabHistoricos." WHERE situacao= 'temporario'";
            $resultado = mysqli_query($conexao, $consulta);

            /**
             * Todas as tabelas sao copiadas para a pasta temporaria em form de .frm
             */
            // Montar array com nomes das tabelas
            $nomeTabelas= array();
            $nomeTabelas[1]= $tabRegLog;
            $nomeTabelas[2]= "getar_cad";
            $nomeTabelas[3]= "getar_control";
            $nomeTabelas[4]= $tabMensagens;
            $nomeTabelas[5]= $tabLembretes;
            $nomeTabelas[6]= $tabArtgCh;
            $nomeTabelas[7]= $tabArtgRv;
            $nomeTabelas[8]= $tabArtgFt;
            $nomeTabelas[9]= $tabArtgLn;
            $nomeTabelas[10]= $tabArtgFtImg;
            $nomeTabelas[11]= $tabContaClasf;
            $nomeTabelas[12]= $tabContaCor;
            $nomeTabelas[13]= $tabContaNome;
            $nomeTabelas[14]= $tabContPag;
            $nomeTabelas[15]= $tabCrediario;
            $nomeTabelas[16]= $tabTabax;
            $nomeTabelas[17]= $tabProjetos;
            $nomeTabelas[18]= $tabPedidos;
            $nomeTabelas[19]= $tabTarefas;
            $nomeTabelas[20]= $tabVendas;
            $nomeTabelas[21]= $tabHistoricos;
            $nomeTabelas[22]= "conta_carne";
            $nomeTabelas[23]= "conta_carne_parcela";

            //Limpar a pasta temporaria
            foreach ($nomeTabelas as $itens) {
                @unlink($localBackup.$itens.".MYD");
                @unlink($localBackup.$itens.".frm");
            }

            //Verificar erros nas tabelas e corrigir
            foreach ($nomeTabelas as $itens) {
                $string = "CHECK TABLES ".$itens;
                $retorno= mysqli_query($string, $conexao) or print mysqli_error();
            }

            //Travar tabelas
    /*foreach ($nomeTabelas as $itens) {
        $string = "LOCK TABLES ".$itens." WRITE";
        $retorno= mysqli_query($string, $conexao) or print mysqli_error();
    }
    $string = "FLUSH TABLES";
    $retorno= mysqli_query($string, $conexao) or print mysqli_error();*/

            //  Backup
            $string = "BACKUP TABLES ";
            $primeiro= " ";
            foreach ($nomeTabelas as $itens) {
                $string .= $primeiro.$itens;
                $primeiro= ", ";
            }
            $string .= " TO '".$localBackup."'";
            $retorno= mysqli_query($string, $conexao) or print mysqli_error();
            // Liberar as tabelas
    /*$string = "UNLOCK TABLES";
    $retorno= mysqli_query($string, $conexao) or print mysqli_error();*/
            break;

    }
    ?>
</div>