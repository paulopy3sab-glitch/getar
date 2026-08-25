<?php

/**
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: Outubro/2017
 * Descricao: coletanea complementar para os switch do modulo adicionais
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
    case 'categ':// Estoque e pedidos de componentes
        include './pagina/estoque/switch.inc.php';
        break;
    case 'local':// Estoque e pedidos de componentes
        include './pagina/estoque/switch.inc.php';
        break;
    case 'pedido': // Pedidos de componentes
        include './pagina/estoque/switch.inc.php';
        break;
    // Financas
    case 'financaspr':// gerenciamento Contas a pagar e receber
        include './pagina/financas/carne.php';
        break;
    case 'financascc':// gerenciamento Contas Correntes e financas
        include './pagina/financas/contacor.php';
        break;
    case 'custos':// gerenciamento Custos
        include './pagina/planocustos/custos.php';
        break;
    //
    case 'artigos':// Para artigos
        include './pagina/artigos/artigos.php';
        break;
    case 'lembretes':// para mensagens
        include './pagina/lembretes/lembretes.php';
        break;
    case 'mensagens':// para mensagens
        include './pagina/mensagens/mensagens.php';
        break;
    default:
        
        break;
}
