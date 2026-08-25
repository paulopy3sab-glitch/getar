/***
** RECRIACAO E AMARRAR TABELAS
** VER VERSAO ATUALIZADA EM; consultas_fiancas.sql
*/
CREATE TABLE `conta_carne` (
  `cod` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `codcad` INT(11) NOT NULL COMMENT 'codigo do fornecedor ou cliente',
  `codctco` INT(11) NOT NULL COMMENT 'codigo da conta corrente a ser usada',
  `finc` VARCHAR(20) NOT NULL COMMENT 'nick do financeiro responsavel',
  `tipo` VARCHAR(20) DEFAULT 'pagar' COMMENT 'pagar: contas a pagar, receber: a receber',
  `projetado` VARCHAR(20) DEFAULT 'fixo' COMMENT 'fixo: parcelas fixas, nego: parcelas negociaveis ou com variacao',
  `objeto` varchar(60) DEFAULT NULL,
  `juro` DECIMAL(6,2) DEFAULT 0,
  `valortot` DECIMAL(8,3) NOT NULL COMMENT 'Valor total do carne',
  `datacarne` DATE NOT NULL COMMENT 'data em que foi criado o carne',
  `obs` TEXT NULL COMMENT 'Observacoes pertinentes ao carne',
  `situacao` varchar(20) DEFAULT 'ativo'
)ENGINE = InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `conta_carnepar` (
   `cod` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   `parnum` int(11) NOT NULL COMMENT 'numero da parcela',
   `codcarne` INT(11) NOT NULL COMMENT 'codigo do carne a que se revere',
   `datavnc` DATE NOT NULL COMMENT 'data de vencimento da parcela',
   `datapag` DATE NULL COMMENT 'data de pagamento da parcela'
   `valorpar` DECIMAL(8,3) NOT NULL COMMENT 'valor da parcela',
   `obs` TEXT NULL COMMENT 'Observacoes pertinentes a parcela',
   `situacao` VARCHAR(20) DEFAULT 'aberta' COMMENT 'aberta, paga, cancelada'
)ENGINE = InnoDB DEFAULT CHARSET=latin1;
ALTER TABLE conta_carnepar ADD CONSTRAINT fk_codcarne FOREIGN KEY (codcarne) REFERENCES conta_carne (cod);
ALTER TABLE conta_carnepar DROP FOREIGN KEY fk_codcarne;

/**
** conta corrente
**/
CREATE TABLE `getar_contacor` (
    `cod` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `codctco` INT(11) NOT NULL COMMENT 'codigo conta corrente',
    `datalanca` date DEFAULT NULL,
    `descr` text,
    `codclasf` int(11) DEFAULT NULL,
    `cred` decimal(10,2) DEFAULT '0.00',
    `debt` decimal(10,2) DEFAULT '0.00',
    `resp` varchar(20) NOT NULL DEFAULT '',
    `obs` text null COMMENT 'Comentarios para o lancamento',
    `situacao` varchar(60) NOT NULL DEFAULT 'ativo'
) ENGINE = InnoDB DEFAULT CHARSET=latin1 COMMENT 'registro de lancamentos';
# ALTER TABLE getar_contacor ADD `obs` text null COMMENT 'Comentarios para o lancamento';

CREATE TABLE `getar_contanome` (
    `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` varchar(40) DEFAULT NULL,
    `descr` text,
    `situacao` varchar(60) NOT NULL DEFAULT 'ativo'
) ENGINE = InnoDB DEFAULT CHARSET=latin1 COMMENT 'registro de lancamentos';
ALTER TABLE getar_contacor ADD CONSTRAINT fk_codctnm FOREIGN KEY (codctco) REFERENCES `getar_contanome` (cod);
ALTER TABLE conta_carne ADD CONSTRAINT `fk_codctco` FOREIGN KEY (`codctco`) REFERENCES `getar_contanome` (`cod`);
INSERT INTO getar_contanome (`nome`, `descr`) VALUES('Caixa Geral', 'Conta basica inicial');

CREATE TABLE `getar_contaclasf` (
    `cod` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `nome` varchar(20) DEFAULT NULL,
    `codctco` int(11) NOT NULL,
    `descr` text,
    `situacao` varchar(60) NOT NULL DEFAULT 'ativo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT 'classificacao de lancamentos';
ALTER TABLE getar_contacor ADD CONSTRAINT fk_codclasf FOREIGN KEY (codclasf) REFERENCES getar_contaclasf (cod);
ALTER TABLE getar_contaclasf ADD CONSTRAINT fk_codctcocl FOREIGN KEY (codctco) REFERENCES getar_contanome (cod);

# REGISTROS INICIAIS
INSERT INTO getar_contaclasf (`cod`, `nome`, `codctco`, `descr`)
         VALUES (1, 'Entrada Capital', 1, 'Capital inicial ou credito para saldar pagamentos'),
                (2, 'Pagamentos', 1, 'Pagamentos Diversos'),
                (3, 'Recebimentos', 1, 'Recebimentos Diversos');
INSERT INTO getar_contacor (`codctco`, `datalanca`, `descr`, `codclasf`,  `cred`, `resp`, `situacao`)
            VALUES(1, CURDATE(), 'Saldo Inicial', 1, 0, 'admin', 'ativo');
/**
** CASO SEJA NECESSARIO RECRIAR AS TABELAS
** DROP na sequencia abaixo
**/
DROP TABLE conta_carnepar;
DROP TABLE getar_contacor;
DROP TABLE getar_contanome;
DROP TABLE getar_contaclasf;
DROP TABLE conta_carne;

# ajustes
# SELECT * FROM getar_contacor;