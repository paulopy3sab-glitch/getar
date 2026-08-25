<?php

/*
 * @author: Paulo Regis <paulo_schw@yahoo.com.br>
 * Data criacao: 23/03/2025
 * Descricao: switch para Lembretes
 */

$complemento = "";
        switch ($pag) {
            case 'edit':                
                $complemento = " AND cod = " . $lmb->get_codLmb();
                break;
            case 'nova':
                $complemento = " AND dataagd <= CURDATE()
                        AND situ = 'ativo' ";
                break;
            case 'list':
                $complemento = " AND dataagd <= CURDATE()
                        AND situ = 'ativo' 
                        AND dest='" . $lmb->get_resp() . "'
                        ";
                break;
            case 'list_env':
                $complemento = " AND situ = 'ativo' 
                        AND remt='" . $lmb->get_resp() . "'
                        AND dest <> '" . $lmb->get_resp() . "'
                        ";
                break;
            case 'list_agd':
                $complemento = " AND dataagd >= CURDATE()
                        AND situ = 'ativo' 
                        AND dest='" . $lmb->get_resp() . "'
                        ";
                break;
            case 'list_todos':
                $complemento = " AND dest='" . $lmb->get_resp() . "'
                        ";
                break;
            case 'list_all':
                $complemento = "";
                break;
            default:
                break;
        }
?>
