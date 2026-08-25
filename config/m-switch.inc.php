<?php

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 17/03/2025
 * Descricao: coletanea complementar para os switch do modulo adicionais para Mobile
 * Tem limitacao de recursos
 */
switch ($setor) {
    case 'eqp'://Equipamentos
        #include './pagina/oscontrol/funcoes_oscons.php';
        include './pagina/oscontrol/switch.inc.php';
        break;
    case 'ordm':// OSs
        include './pagina/oscontrol/switch.inc.php';
        break;
    // Estoque
    case 'estoque':// Estoque e pedidos de componentes
        include './pagina/estoque/switch.inc.php';
        break;
    // Financas
    case 'financaspr':// gerenciamento Conta Corrente
        include './pagina/financas/carne.php';
        break;
    case 'financascc':// gerenciamento Conta Corrente
        include './pagina/financas/contacor.php';
        break;
    // final financas
    case 'artigos':// Para artigos
        include './pagina/artigos/artigos.php';
        break;
    case 'lembretes':// para mensagens
        # include './pagina/mensagens/switch.inc.php'; # erro em estudo: algo mudando o st=lembretes para st=mensagens
    case 'mensagens':// para mensagens
        include './pagina/mensagens/switch.inc.php';

    default:
        break;
}
