# tabela de estoque de produtos
CREATE TABLE `estoque` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(120) NOT NULL,
  `descrtec` varchar(120) NOT NULL COMMENT 'Descricao tecnica do produto- sucinta',
  `numest` int(11) NOT NULL DEFAULT '1' COMMENT 'Para varios estoques',
  `datasheet` varchar(60) NOT NULL,
  `fabr` int(11) NOT NULL,
  `und` varchar(10) NOT NULL,
  `qtd` decimal(10,3) NOT NULL,
  `qtdmin` decimal(10,3) NOT NULL,
  `valorcusto` decimal(10,3) NOT NULL,
  `valorvenda` decimal(10,3) NOT NULL,
  `moeda` varchar(20) DEFAULT 'Real',
  `peso` decimal(10,3) NOT NULL,
  `foto` varchar(120) NOT NULL,
  `rua` int(11) NOT NULL DEFAULT '1' COMMENT 'Para estoque num pavilahao',
  `quadra` int(11) NOT NULL DEFAULT '1' COMMENT 'Para estoque num pavilahao',
  `local` int(11) NOT NULL DEFAULT '1',
  `situacao` varchar(60) NOT NULL,
  `clasf` varchar(60) NOT NULL DEFAULT 'geral',
  `catg` int(11) NOT NULL,
  `subcatg` int(11) NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_subcatg` (`subcatg`),
  KEY `fk_catg` (`catg`),
  CONSTRAINT `fk_catg` FOREIGN KEY (`catg`) REFERENCES `estcatg` (`cod`),
  CONSTRAINT `fk_subcatg` FOREIGN KEY (`subcatg`) REFERENCES `estsubcatg` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# observacoes para um produto
CREATE TABLE `estobs` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codestq` int(11) NOT NULL,
  `texto` text NOT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_codobs` (`codestq`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1


# categoria de produtos (transistores, resistores, etc
CREATE TABLE `estcatg` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `descr` varchar(60) NOT NULL,
  `situacao` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# subcategoris de produtos (transitores: audio baixa potencia, audio media potencia, RF alta potencia, etc
CREATE TABLE `estsubcatg` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codcatg` int(11) NOT NULL,
  `descr` varchar(60) NOT NULL,
  `situacao` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`),
  KEY `fk_codcatg` (`codcatg`),
  CONSTRAINT `fk_codcatg` FOREIGN KEY (`codcatg`) REFERENCES `estcatg` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# locais onde esta armazenado 
CREATE TABLE `estlocal` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `etq` varchar(8) NOT NULL,
  `descr` text NOT NULL COMMENT 'Descrição do local gavata ou caixa onde esta o componente',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# RUA onde esta armazenado 
CREATE TABLE `estrua` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `etq` varchar(18) NOT NULL,
  `descr` text NOT NULL COMMENT 'Descrição da rua, ou local onde estao as quadras e os potes, caixas: BOX',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# quadra da rua
CREATE TABLE `estquadra` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codrua` int(11) NOT NULL,
  `etq` varchar(18) NOT NULL,
  `descr` varchar(60) NOT NULL,
  `situacao` varchar(20) NOT NULL DEFAULT 'ativo',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/**
** retiradas e pedidos de compra reposicao
**/
# registro de retiradas avulsas
CREATE TABLE `estretira` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codestq` int(11) NOT NULL,
  `dia` datetime NOT NULL COMMENT 'Data e hora da retirada',
  `usuario` varchar(20) NOT NULL COMMENT 'Lgon de quem fez a retira',
  `qtd` int(11) NOT NULL,
  `und` varchar(20) NOT NULL,
  `motivo` text NOT NULL COMMENT 'Breve comentario justificando a retirada do estoque',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# cabecalho do pedido compra ou reposicao
CREATE TABLE `estpedidocab` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `codforn` int(11) NOT NULL COMMENT 'codigo do fornecedor na getar_cad',
  `resp` varchar(20) DEFAULT NULL COMMENT 'nick do responsavel pelo pedido',
  `codcli` int(11) DEFAULT NULL COMMENT 'codigo do cliente na getar_cad',
  `dtped` date DEFAULT NULL COMMENT 'data do pedido',
  `ospro` int(11) DEFAULT NULL COMMENT 'OS ou projeto vinculado ao pedido',
  `dtcheg` date DEFAULT NULL COMMENT 'data de privissao de chegada',
  `dtrecb` date DEFAULT NULL COMMENT 'data de recebimento do pedido',
  `rastr` varchar(120) DEFAULT NULL COMMENT 'codigo rastreador',
  `vlfrete` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT 'custo do frete',
  `empfrete` varchar(120) DEFAULT NULL,
  `situ` varchar(20) NOT NULL DEFAULT 'processamento',
  `tipo` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cod`),
  KEY `fk_codfornped` (`codforn`),
  CONSTRAINT `fk_codfornped` FOREIGN KEY (`codforn`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# itens do pedido
CREATE TABLE `estpedidoitem` (
  `coditem` int(11) NOT NULL AUTO_INCREMENT,
  `codped` int(11) NOT NULL COMMENT 'codigo do pedido encabeçado',
  `codest` int(11) NOT NULL COMMENT 'codigo do produto na tabela estoque',
  `qt` decimal(10,0) NOT NULL COMMENT 'quantidade pedida',
  `custo` decimal(10,3) NOT NULL COMMENT 'preço de custo ',
  `situ` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`coditem`),
  KEY `fk_codped` (`codped`),
  KEY `fk_codestqped` (`codest`),
  CONSTRAINT `fk_codestqped` FOREIGN KEY (`codest`) REFERENCES `estoque` (`cod`),
  CONSTRAINT `fk_codped` FOREIGN KEY (`codped`) REFERENCES `estpedidocab` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

# fornecedores
CREATE TABLE `fornecedor` (
  `codestq` int(11) NOT NULL COMMENT 'codigo do produto ou componente estocado',
  `codforn` int(11) NOT NULL COMMENT 'codigo do fornecedor na getar_cad',
  KEY `fk_codestqforn` (`codestq`),
  KEY `fk_codforn` (`codforn`),
  CONSTRAINT `fk_codestqforn` FOREIGN KEY (`codestq`) REFERENCES `estoque` (`cod`),
  CONSTRAINT `fk_codforn` FOREIGN KEY (`codforn`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/**
** AREA DE TESTES
**/
SELECT DISTINCT clasf FROM estoque;

SHOW CREATE TABLE estobs;

