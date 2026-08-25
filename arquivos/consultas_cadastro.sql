/**
* Extrutura atual do tabela principal
**/
SHOW CREATE TABLE getar_cad;
CREATE TABLE `getar_cad` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) DEFAULT NULL,
  `clasf` char(1) DEFAULT NULL,
  `contato` varchar(20) DEFAULT NULL,
  `mae` varchar(120) DEFAULT NULL COMMENT 'Mae do cadastrado',
  `endr` varchar(40) DEFAULT NULL,
  `bairro` varchar(20) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `pais` varchar(60) DEFAULT 'Brasil',
  `cep` varchar(9) DEFAULT NULL,
  `estado` VARCHAR(40) DEFAULT NULL,
  `cpcn` varchar(20) DEFAULT NULL,
  `rgie` varchar(20) DEFAULT NULL,
  `desde` date DEFAULT '2001-01-01',
  `nasc` date DEFAULT '2001-01-01',
  `ref` varchar(40) DEFAULT NULL,
  `situacao` varchar(60) NOT NULL,
  `emailcorp` varchar(60) DEFAULT NULL COMMENT 'Para uso de envio e-mail pelo Getar',
  `estciv` varchar(20) DEFAULT 'casado',
  `sexo` varchar(120) DEFAULT 'masculino',
  `conj` varchar(120) DEFAULT NULL COMMENT 'Conjuge do cadastrado',
  `nacna` varchar(20) DEFAULT 'Brasileiro' COMMENT 'Nacionalidade',
  `prof` varchar(60) DEFAULT NULL COMMENT 'Profissao do cadastrado',
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `getar_cad` ADD `pais` VARCHAR(60) NOT NULL DEFAULT 'Brasil' AFTER `cidade`;
ALTER TABLE `getar_cad` ADD `cnpj` VARCHAR(20) DEFAULT NULL AFTER `cpcn`;
ALTER TABLE `getar_cad` ADD `ie` VARCHAR(20) DEFAULT NULL AFTER `rgie`;
ALTER TABLE `getar_cad` DROP `rg`;
ALTER TABLE `getar_cad` CHANGE `estado` `estado` VARCHAR(40) DEFAULT NULL;
ALTER TABLE `getar_cad` ADD `numero` VARCHAR(8) NOT NULL DEFAULT '' AFTER `endr`;
ALTER TABLE `getar_cad` ADD `complemento` VARCHAR(60) NOT NULL DEFAULT '' AFTER `numero`;
ALTER TABLE `getar_cad` CHANGE `bairro` `bairro` VARCHAR(60) DEFAULT NULL;
ALTER TABLE getar_cad DROP mae, DROP prof, DROP conj;
ALTER TABLE getar_cad DROP conj;

SELECT cod, nome, rgie, ie, cpcn, cnpj, situacao FROM getar_cad WHERE situacao = 'ativo' AND rgie <> '' ORDER BY cod DESC LIMIT 5;

SHOW CREATE TABLE estado;
CREATE TABLE `estado` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `pais` varchar(60) NOT NULL,
  `DDI` int(11) NOT NULL,
  `codpais` int(11) NOT NULL,
  `sgl` char(2) DEFAULT NULL,
  `nome` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

ALTER TABLE `estado` ADD `pais` VARCHAR(60) NOT NULL AFTER `cod_estado`, ADD `DDI` INT(11) NOT NULL AFTER `pais`;
ALTER TABLE `estado` CHANGE `cod_estado` `cod` INT(11) NOT NULL PRIMARY KEY;
ALTER TABLE `estado` CHANGE `cod_pais` `codpais` INT(11) NOT NULL;
ALTER TABLE `estado` CHANGE `sgl_estado` `sgl` char(2);
ALTER TABLE `estado` CHANGE `nom_estado` `nome` VARCHAR(60);
ALTER TABLE `estado` ADD PRIMARY KEY(`cod`);
ALTER TABLE `estado` CHANGE `cod` `cod` INT(11) NOT NULL AUTO_INCREMENT;
SELECT DISTINCT(pais) FROM estado;

# corrigindo MER
CREATE TABLE getar_pais (
  cod INT NOT NULL AUTO_INCREMENT,
  nome VARCHAR(45) NOT NULL,
  PRIMARY KEY (cod)
) ENGINE = InnoDB;
INSERT INTO getar_pais (nome)
                 VALUES('Brasil'),
                       ('EUA'),
                       ('Alemanha'),
                       ('India'),
                       ('China'),
                       ('UK');

CREATE TABLE `getar_estado` (
  `cod` INT(11) NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `getar_pais_id_pais` INT NOT NULL,
  PRIMARY KEY (`cod`)
)ENGINE = InnoDB;
ALTER TABLE getar_estado ADD INDEX `fk_getar_estado_getar_pais1_idx` (`getar_pais_id_pais` ASC);
ALTER TABLE getar_estado ADD
  CONSTRAINT `fk_getar_estado_getar_pais1`
    FOREIGN KEY (`getar_pais_id_pais`)
    REFERENCES `getar_pais` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION;
# ALTER TABLE getar_estado DROP cod_pais;

SELECT * FROM getar_estado;
SELECT * FROM getar_pais;

DROP TABLE getar_estado;

ALTER TABLE getar_cad ADD getar_estado_cod INT AFTER cod;
SELECT cod, nome, estado, getar_estado_cod, situacao FROM getar_cad LIMIT 5;
UPDATE getar_cad SET getar_estado_cod = 24;# 24- Santa Catarina 23 - Rio Grande do Sul
UPDATE getar_cad SET getar_estado_cod= 31 WHERE estado = 'California';
UPDATE getar_cad SET getar_estado_cod= 24 WHERE estado = 'Santa Catarina';

UPDATE getar_cad SET getar_estado_cod= 79 WHERE estado = 'Inglaterra';

UPDATE getar_cad SET estado= 'Santa Catarina' WHERE getar_estado_cod = 24;
UPDATE getar_cad SET estado= 'Maranhão' WHERE getar_estado_cod= 10;

SELECT cod, nome, estado, getar_estado_cod, situacao FROM getar_cad WHERE estado= 'Minas Gerais';
SELECT cod, nome, estado, getar_estado_cod, situacao FROM getar_cad WHERE estado= '';# 42 ocorrencias são forneceores, fabricante e cadastros antigos
# deixar como o default 24 (Santa Catarina)
SELECT cod, nome, estado, getar_estado_cod, situacao FROM getar_cad WHERE estado= NULL; # sem registro mas aparece no SQL de captura.
SELECT cod, nome, estado, getar_estado_cod, situacao FROM getar_cad WHERE estado= 'SC';
SELECT cod, nome, estado, getar_estado_cod, situacao FROM getar_cad WHERE estado= 'Rio Grande do Sul';
SELECT cod, nome, estado, getar_estado_cod, situacao FROM getar_cad WHERE getar_estado_cod= ;

SELECT cod, nome, estado, getar_estado_cod, pais, clasf,  situacao FROM getar_cad WHERE estado NOT IN('Rio Grande do Sul',
'Santa Catarina','Minas Gerais', 'Sao Paulo', 'Amazonas', 'Ceara', 'Pernanbuco', 'Paraná', 'Rio de Janeiro',
'Mato Grosso do Sul', 'China', 'Inglaterra', 'Roraima', 'Bahia', 'Rio Grande do Norte', 'Pernambuco',
'Distrito Federal', 'Goiás', 'Piauí', 'Rondônia', 'Acre');

SELECT cod, nome, estado, getar_estado_cod, clasf,  situacao FROM getar_cad WHERE clasf = 'g' AND estado ='';
UPDATE getar_cad SET estado = 'Santa Catarian', getar_estado_cod= 24 WHERE clasf = 'b' AND estado ='';

SELECT DISTINCT(estado) FROM getar_cad;

# excluinda campo obsoletos
ALTER TABLE getar_cad DROP estciv, DROP nacna;

# Estados brasileiros
INSERT INTO getar_estado (nome, getar_pais_id_pais)
                  VALUES ('Acre', 1),
                         ('Alagoas', 1),
                         ('Amazonas', 1),
                         ('Amapá', 1),
                         ('Bahia', 1),
                         ('Ceará', 1),
                         ('Distrito Federal', 1),
                         ('Espírito Santo', 1),
                         ('Goiás', 1),
                         ('Maranhão', 1),
                         ('Minas Gerais', 1),
                         ('Mato Grosso do Sul', 1),
                         ('Mato Grosso', 1),
                         ('Pará', 1),
                         ('Paraíba', 1),
                         ('Pernambuco', 1),
                         ('Piauí', 1),
                         ('Paraná', 1),
                         ('Rio de Janeiro', 1),
                         ('Rio Grande do Norte', 1),
                         ('Rondônia', 1),
                         ('Roraima', 1),
                         ('Rio Grande do Sul', 1),
                         ('Santa Catarina', 1),
                         ('Sergipe', 1),
                         ('São Paulo', 1),
                         ('Tocantis', 1);

INSERT INTO getar_estado (nome, getar_pais_id_pais)
            VALUES('Alabama', 2),# https://brasilescola.uol.com.br/geografia/estados-unidos2.htm
                  ('Alaska', 2),
                  ('Arcansas', 2),
                  ('Califórnia', 2),
                  ('Carolina do Norte', 2),
                  ('Carolina do Sul', 2),
                  ('Colorado', 2),
                  ('Connecticut', 2),
                  ('Dakota do Norte', 2),
                  ('Dakota do Sul', 2),
                  ('Delaware', 2),
                  ('Flórida', 2),
                  ('Geórgia', 2),
                  ('Havai', 2),
                  ('Idaio', 2),
                  ('Illinois', 2),
                  ('Indiana', 2),
                  ('Iowa', 2),
                  ('Kansas', 2),
                  ('Kentucky', 2),
                  ('Louisiana', 2),
                  ('Maine', 2),
                  ('Maryland', 2),
                  ('Massachusetts', 2),
                  ('Michigan', 2),
                  ('Mississipi', 2),
                  ('Missouri', 2),
                  ('Montana', 2),
                  ('Nebraska', 2),
                  ('Nevada', 2),
                  ('New Hampshire', 2),
                  ('New Jersey', 2),
                  ('Nova Iorque', 2),
                  ('Novo México', 2),
                  ('Oklahoma', 2),
                  ('Ohio', 2),
                  ('Oregon', 2),
                  ('Pennsylvania', 2),
                  ('Rhode Island', 2),
                  ('Tennessee', 2),
                  ('Texas', 2),
                  ('Utah', 2),
                  ('Vermont', 2),
                  ('Virginia', 2),
                  ('Virginia Oscidental', 2),
                  ('Washington', 2),
                  ('Wisconsin', 2),
                  ('Wyoming', 2);

INSERT INTO getar_estado (nome, getar_pais_id_pais ) VALUES ('Alemanha', 3),
('India', 4),
('China', 5),
('UK', 6);

CREATE TABLE IF NOT EXISTS `getar_cad` (
  `cod` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(120) NULL DEFAULT NULL,
  `clasf` CHAR(1) NULL DEFAULT NULL,
  `contato` VARCHAR(120) NULL DEFAULT NULL COMMENT 'Funcionário ou representante de um empresa ou associação',
  `mae` VARCHAR(120) NULL DEFAULT NULL COMMENT 'Mae do cadastrado',
  `endr` VARCHAR(40) NULL DEFAULT NULL,
  `bairro` VARCHAR(20) NULL DEFAULT NULL,
  `cidade` VARCHAR(40) NULL DEFAULT NULL,
  `cep` VARCHAR(9) NULL DEFAULT NULL,
  `cpcn` VARCHAR(20) NULL DEFAULT NULL,
  `rgie` VARCHAR(20) NULL DEFAULT NULL,
  `desde` DATE NULL DEFAULT '2001-01-01',
  `nasc` DATE NULL DEFAULT '2001-01-01',
  `ref` VARCHAR(40) NULL DEFAULT NULL,
  `situacao` VARCHAR(60) NOT NULL,
  `estciv` VARCHAR(20) NULL DEFAULT 'casado',
  `sexo` VARCHAR(120) NULL DEFAULT 'masculino',
  `conj` VARCHAR(120) NULL DEFAULT NULL COMMENT 'Conjuge do cadastrado',
  `nacna` VARCHAR(20) NULL DEFAULT 'Brasileiro' COMMENT 'Nacionalidade do cadastrado.',
  `prof` VARCHAR(60) NULL DEFAULT NULL COMMENT 'Profissao do cadastrado',
  `getar_estado_cod` INT NOT NULL,
  PRIMARY KEY (`cod`),
  INDEX `fk_getar_cad_getar_estado1_idx` (`getar_estado_cod` ASC),
  CONSTRAINT `fk_getar_cad_getar_estado1`
    FOREIGN KEY (`getar_estado_cod`)
    REFERENCES `getarsab`.`getar_estado` (`cod`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = latin1;

/*
*
*/
SELECT cod, nome, desde, clasf, situacao FROM getar_cad ORDER BY cod DESC;
SELECT cod, nome, clasf, nasc, desde, situacao FROM getar_cad WHERE cod = 1;
SELECT cod, nome, desde, clasf, situacao FROM getar_cad WHERE nome LIKE ('%Proesi%');
SELECT cod, nome, desde, clasf, situacao FROM getar_cad WHERE endr LIKE ('%Estrada%');
SELECT cod, nome, desde, clasf, situacao FROM getar_cad WHERE clasf = 'a';
SELECT cod, nome, desde, clasf, situacao FROM getar_cad WHERE clasf = 'c' AND estado = 'Pernanbuco';# r= fornecedor c= cliente

# Corrigindo o 'Rio Grando do Sul';
SELECT cod, nome, cidade, estado FROM getar_cad WHERE estado = 'Rio Grando do Sul';

CREATE TABLE getar_cadtemp(
cod INT(11)
)ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO getar_cadtemp (cod) VALUES(SELECT cod, nome, cidade, estado FROM getar_cad WHERE estado = 'Rio Grando do Sul');# da erro
INSERT INTO getar_cadtemp (cod) SELECT cod FROM getar_cad WHERE estado = 'Rio Grando do Sul';# Deu Certo!!!
TRUNCATE TABLE getar_cadtemp;
UPDATE getar_cad SET estado = 'Rio Grande do Sul' WHERE cod IN(SELECT cod FROM getar_cadtemp);
DROP TABLE getar_cadtemp;

# outro correcao de teste anteriores
ALTER TABLE getar_cad DROP estadotemp;
SELECT * FROM getar_cad WHERE cod= 1196;

SELECT cod, nome FROM getar_cad LIMIT 5;
SELECT cod, nome, situacao FROM getar_cad WHERE cod > 200 LIMIT 100;
INSERT INTO getar_cad (cod, nome, situacao)
                VALUES(238, 'Namir Recksiegel', 'ativo');

UPDATE getar_cad SET clasf = 'u' WHERE cod = 514;
INSERT getar_part (nick, codcad) VALUES('pregis', 514);
INSERT getar_part (nick, codcad) VALUES('pregis', 253);
SELECT COUNT(*) nm FROM getar_part WHERE nick = 'pregis' AND codcad= 253;
SELECT * FROM getar_part;
SELECT * FROM getar_reglog ORDER BY cod DESC;
SELECT * FROM getar_reglog WHERE `datalog` = '2016-09-27' ORDER BY cod DESC;
UPDATE getar_reglog SET horafim = CURTIME() WHERE horafim= '00:00:00' AND nick = 'pregis';
INSERT INTO getar_reglog (nick, datalog, horaini, horafim) VALUES ('pregis', CURDATE(), CURTIME(), '');
ALTER TABLE getar_reglog CHANGE `data` datalog DATE DEFAULT NULL;

# pesquisando clientes com equipamento mas sem telefone
        SELECT cad.cod,
               cad.nome,
               fn.numero,
               ord.cod OS,
               cad.desde,
               cad.clasf,
               cad.situacao
          FROM getar_cad cad,
               getar_fones fn,
               equipo eqp,
               ordem ord
         WHERE cad.cod= eqp.codcli
               AND cad.cod = fn.codcli
               AND eqp.cod = ord.codeqp
      ORDER BY numero, nome ASC;
SELECT * FROM getar_fones WHERE codcli= 1108;
SELECT * FROM getar_fones WHERE codcli IN(1138, 1147) AND numero='';
DELETE FROM getar_fones WHERE numero='';

    SELECT cad.cod,
               cad.nome,
               cad.desde,
               cad.clasf,
               cad.situacao
          FROM getar_cad cad
         WHERE cad.clasf = 'c'
               AND cad.cod IN(SELECT DISTINCT(codcli)
                   FROM equipo
                  WHERE codcli NOT IN(SELECT fn.codcli FROM getar_fones fn));
/**
**
*/

        SELECT cod,
               nome,
               cpcn,
               CASE
                   WHEN clasf = 'a' THEN 'administrador'
                   WHEN clasf = 'c' THEN 'cliente'
                   WHEN clasf = 'v' THEN 'vendedor'
                   WHEN clasf = 'p' THEN 'programador/designer'
                   WHEN clasf = 'f' THEN 'financeiro'
                   WHEN clasf = 'r' THEN 'fornecedor'
                   WHEN clasf = 'b' THEN 'fabricante'
                   WHEN clasf = 'g' THEN 'geral' # nao usado aqui mas para usar em outros SQL
                   WHEN clasf = 'u' THEN 'particular' # indexado ao dono pela getar_part
               END clasf,
               (SELECT nick
                FROM getar_control ct
                WHERE ct.codcad = cad.cod) nick            
          FROM getar_cad cad
            WHERE cpcn LIKE '245%';
          /*WHERE cad.cod = 11;
         WHERE situacao != 'temporario'
               AND clasf != 'g';*/

        SELECT cod,
               nome,
               nasc,
               date_format(nasc, '%d') dia_nasc,
               date_format(nasc, '%m') mes_nasc,
               date_format(nasc, '%Y') ano_nasc,
               desde,
               date_format(desde, '%d') dia_desde,
               date_format(desde, '%m') mes_desde,
               date_format(desde, '%Y') ano_desde
          FROM getar_cad
         WHERE cod = 1;

         WHERE situacao != 'temporario'
               AND clasf = 'c';

         SELECT cad.cod,
                cad.nome,
                cad.contato,
                (SELECT numero FROM getar_fones WHERE codcli = cad.cod LIMIT 1) AS fones,
                (SELECT endr FROM getar_emails WHERE codcli = cad.cod LIMIT 1) AS email,
                cad.cidade,
                cad.situacao
           FROM getar_cad cad
          WHERE cad.situacao != 'temporario'
                AND cad.cod IN(SELECT codcad FROM getar_control)
                AND ((cad.cod IN(SELECT codcad nm FROM getar_part WHERE nick = 'pregis' AND codcad= cad.cod))
                      OR (cad.clasf <> 'u'))
                AND cod = 514;


          SELECT cad.cod,
                 cad.nome,
                 date_format(cad.nasc, '%d/%m/%Y') dia_nasc,
                 cad.estciv,
                 cad.sexo,
                 est.nf09,
                 est.nf15,
                 est.nf18,
                 est.natu,
                 cad.prof,
                 cad.bairro,
                 cad.cidade,
                 cad.estado
            FROM getar_cad cad,
                 nvd_est est
            WHERE cad.cod= est.codcad
                  AND cad.clasf = 'g'
                  AND cad.situacao= 'ativo'
        ORDER BY cod DESC;

/**
** CONTROLE DOS LOGONS
*/
          SELECT cad.cod,
                 sn.nick,
                 cad.clasf
            FROM getar_control AS sn,
                 getar_cad AS cad
           WHERE sn.codcad= cad.cod
                 AND cad.situacao = 'ativo'
                 AND sn.nick  ='pregis';

            SELECT *
            FROM getar_cad cad,
                 getar_control ct,
                 getar_cliente cl
           WHERE cad.cod = ct.codcad
                 AND ct.nick = cl.nick;

SELECT * FROM getar_control;
UPDATE getar_control SET custohora = 30 WHERE nick='pregis';
SELECT custohora FROM getar_control WHERE nick= 'pregis';

        SELECT cad.cod,
               cad.nome,
               ctl.nick,
               ctl.custohora
          FROM getar_control ctl,
               getar_cad cad
         WHERE cad.cod= ctl.codcad;

        SELECT cad.cod,
               cad.nome,
               ctl.nick,
               ctl.custohora
          FROM getar_control ctl,
               getar_cad cad
         WHERE cad.cod= ctl.codcad
               # AND ctl.nick= 'pregis';
               AND cad.cod= 273;

# Perfil de Atributos
SELECT * FROM getar_perfil;

        SELECT nick FROM getar_control WHERE nick LIKE 'adm%'
UNION(SELECT nick FROM getarnvd.getar_control WHERE nick LIKE 'adm%')
         LIMIT 3;

SELECT * FROM getar_control WHERE codcad = 897;
SELECT * FROM getar_control4cd84958-7a49-4a93-ac6a-a39cdcbba484;
DELETE FROM getar_control WHERE codcad = 897;
INSERT INTO getar_control (nick, codcad, frase, contra) VALUES('teste', 897, '', '');
INSERT INTO getar_cliente (nick, url) VALUES('marias', 'http://192.168.0.4/clientea');
SELECT * FROM getar_cliente;

INSERT INTO getar_control (nick, frase, contra, custohora, codcad) VALUES ('teste', PASSWORD('123mudar'), '', 0, 829);
UPDATE getar_control SET frase= PASSWORD('123mudar') WHERE nick= 'admin';
UPDATE getar_control SET frase= PASSWORD('vend1234') WHERE nick= 'vendedor';
UPDATE getar_control SET frase= PASSWORD('salm37teca5') WHERE nick= 'pregis';
UPDATE getar_cad SET emailcorp = 'pregis@localhost' WHERE cod= 273;

SELECT nome, cid, res, cel, comr FROM getar_cad WHERE cod = 2;

        SELECT nick
          FROM getar_control
         WHERE nick= 'ricardo'
               AND contra = PASSWORD('123mudar');
SELECT * FROM getar_control;

SELECT COUNT(*) num
                   FROM getar_lembre
                  WHERE dataAgendada <= CURDATE()
                        AND dest = 'visitante'
                        AND situacao= 'ativo';

SELECT * FROM getar_atrib WHERE nick = 'kauan';

             SELECT rg.cod,
                    rg.nick,
                    (SELECT cl.url FROM getar_cliente cl WHERE cl.nick = rg.nick) url,
                    DATE_FORMAT(rg.datalog, '%d/%m/%Y') datalog,
                    rg.horaini,
                    rg.horault,
                    rg.horafim
               FROM getar_reglog rg
              WHERE 1 = 1 
            ORDER BY rg.cod DESC;

SELECT * FROM getar_reglog;

SELECT * FROM getar_control WHERE codcad= 881;
INSERT INTO getar_control (nick, codcad) VALUES('temp273', 273);
DELETE FROM getar_control WHERE nick= 'temp881';

SELECT COUNT(*) nm FROM getar_control WHERE nick='pregis';

/**
** Enderecamento no cadastro
**/
SELECT cod, nome, endr, numero, bairro, cidade, estado, pais FROM getar_cad WHERE cod = 1249;

/**
** Gerenciando pais, estado, DDI
** tabela estado e cidades
**/
SELECT * FROM estado WHERE codpais= 1;# Brasil
SELECT * FROM estado WHERE codpais= 3;# Alemanha
SELECT * FROM estado WHERE codpais= 4;# India
SELECT * FROM estado WHERE codpais= 5;# China
SELECT * FROM estado WHERE codpais= 6;# UK Reino Unido
SELECT * FROM estado;
UPDATE estado SET DDI= 55, pais= 'Brasil'  WHERE codpais= 1;
INSERT INTO estado (pais, DDI, codpais, sgl, nome)
            VALUES('EUA', 1, 2, '', 'Alabama'),# https://brasilescola.uol.com.br/geografia/estados-unidos2.htm
                  ('EUA', 1, 2, '', 'Alaska'),
                  ('EUA', 1, 2, '', 'Arcansas'),
                  ('EUA', 1, 2, '', 'Califórnia'),
                  ('EUA', 1, 2, '', 'Carolina do Norte'),
                  ('EUA', 1, 2, '', 'Carolina do Sul'),
                  ('EUA', 1, 2, '', 'Colorado'),
                  ('EUA', 1, 2, '', 'Connecticut'),
                  ('EUA', 1, 2, '', 'Dakota do Norte'),
                  ('EUA', 1, 2, '', 'Dakota do Sul'),
                  ('EUA', 1, 2, '', 'Delaware'),
                  ('EUA', 1, 2, '', 'Flórida'),
                  ('EUA', 1, 2, '', 'Geórgia'),
                  ('EUA', 1, 2, '', 'Havai'),
                  ('EUA', 1, 2, '', 'Idaio'),
                  ('EUA', 1, 2, '', 'Illinois'),
                  ('EUA', 1, 2, '', 'Indiana'),
                  ('EUA', 1, 2, '', 'Iowa'),
                  ('EUA', 1, 2, '', 'Kansas'),
                  ('EUA', 1, 2, '', 'Kentucky'),
                  ('EUA', 1, 2, '', 'Louisiana'),
                  ('EUA', 1, 2, '', 'Maine'),
                  ('EUA', 1, 2, '', 'Maryland'),
                  ('EUA', 1, 2, '', 'Massachusetts'),
                  ('EUA', 1, 2, '', 'Michigan'),
                  ('EUA', 1, 2, '', 'Mississipi'),
                  ('EUA', 1, 2, '', 'Missouri'),
                  ('EUA', 1, 2, '', 'Montana'),
                  ('EUA', 1, 2, '', 'Nebraska'),
                  ('EUA', 1, 2, '', 'Nevada'),
                  ('EUA', 1, 2, '', 'New Hampshire'),
                  ('EUA', 1, 2, '', 'New Jersey'),
                  ('EUA', 1, 2, '', 'Nova Iorque'),
                  ('EUA', 1, 2, '', 'Novo México'),
                  ('EUA', 1, 2, '', 'Oklahoma'),
                  ('EUA', 1, 2, '', 'Ohio'),
                  ('EUA', 1, 2, '', 'Oregon'),
                  ('EUA', 1, 2, '', 'Pennsylvania'),
                  ('EUA', 1, 2, '', 'Rhode Island'),
                  ('EUA', 1, 2, '', 'Tennessee'),
                  ('EUA', 1, 2, '', 'Texas'),
                  ('EUA', 1, 2, '', 'Utah'),
                  ('EUA', 1, 2, '', 'Vermont'),
                  ('EUA', 1, 2, '', 'Virginia'),
                  ('EUA', 1, 2, '', 'Virginia Oscidental'),
                  ('EUA', 1, 2, '', 'Washington'),
                  ('EUA', 1, 2, '', 'Wisconsin'),
                  ('EUA', 1, 2, '', 'Wyoming');

INSERT INTO estado (pais, DDI, codpais, sgl, nome)
            VALUES('UK', 44, 6, ' ', 'Inglaterra');

# para o select dos paises
SELECT DISTINCT DDI, pais, codpais FROM estado;

# testes
SELECT COUNT(*) nm FROM estado WHERE nome = "";
SELECT nome, estado FROM getar_cad WHERE cod= 1290;

/**
** ESTATISTICAS
**/
        SELECT COUNT(*) cod,
               (SELECT COUNT(*) geral FROM getar_cad WHERE clasf= 'g' AND situacao= 'ativo') geral,
               (SELECT COUNT(*) casados FROM getar_cad WHERE clasf= 'g' AND estciv= 'casado' AND situacao= 'ativo') casados,
               (SELECT COUNT(*) solteiros FROM getar_cad WHERE clasf= 'g' AND estciv= 'solteiros' AND situacao= 'ativo') solteiros,
               (SELECT COUNT(*) masculino FROM getar_cad WHERE clasf= 'g' AND sexo= 'masculino' AND situacao= 'ativo') masculino,
               (SELECT COUNT(*) mulheres FROM getar_cad WHERE clasf= 'g' AND sexo= 'feminino' AND situacao= 'ativo') mulheres,
          FROM getar_cad cad
         WHERE cad.situacao= 'ativo';

        SELECT COUNT(*) clientes FROM getar_cad WHERE clasf= 'c';
        SELECT COUNT(*) geral FROM getar_cad WHERE clasf= 'g' AND situacao= 'ativo';
        SELECT COUNT(*) casados FROM getar_cad WHERE clasf= 'g' AND estciv= 'casado' AND situacao= 'ativo';

SELECT cod, estciv, sexo FROM getar_cad;


/**
** aniversariantes
**/
          SELECT cod,
                nome,
                TIMESTAMPDIFF(YEAR, nasc, CURDATE()) as idade,
                DATE_FORMAT(nasc, '%d') dia,
                'dia' per,
                1 ord
           FROM getar_cad
          WHERE nasc != '2001-01-01'
                AND situacao NOT IN ('inativo')
                AND DATE_FORMAT(nasc, '%d/%m') = DATE_FORMAT(CURDATE(), '%d/%m');

         SELECT cod,
                nome,
                TIMESTAMPDIFF(YEAR, nasc, CURDATE()) as idade,
                DATE_FORMAT(nasc, '%d') dia,
                'dia' per,
                1 ord
           FROM getar_cad
          WHERE nasc != '2001-01-01'
                AND situacao NOT IN ('inativo')
                AND DATE_FORMAT(nasc, '%d/%m') = DATE_FORMAT(CURDATE(), '%d/%m')
         UNION(SELECT cod,
                nome,
                TIMESTAMPDIFF(YEAR, nasc, CURDATE()) as idade,
                DATE_FORMAT(nasc, '%d') dia,
                'mes' per,
                2 ord
           FROM getar_cad
          WHERE nasc != '2001-01-01'
                AND situacao NOT IN ('inativo')
                AND DATE_FORMAT(nasc, '%m') = DATE_FORMAT(CURDATE(), '%m'))
         ORDER BY ord;


/**
** AREA DE TESTES
**/
/**
** AREA DE TESTES
**/
INSERT INTO getar_cliente (nick, url) VALUES( 'pregis', 'http://192.168.0.4/getarschw');
TRUNCATE getar_cliente;

        SELECT url
          FROM getar_cliente
         WHERE nick= 'pregis';

# xxxxxxxxxxxxxx
ALTER TABLE getar_fones DROP FOREIGN KEY fk_fonecad;
DROP TABLE getar_cad;
DROP TABLE getar_fones;
DROP TABLE getar_control;
DROP TABLE getar_part;
TRUNCATE TABLE getar_cad;
TRUNCATE TABLE getar_fones;

SELECT * FROM getar_cad;
SELECT * FROM getar_fones;

INSERT INTO getar_cad (nome, clasf) VALUES('Cliente Bom', 'c');
INSERT INTO getar_fones (codcli, descr, numero) VALUES( 3, 'Celular Vivo', '(99)9999-9999');
INSERT INTO getar_fones (codcli, descr, numero) VALUES( 4, 'Celular Vivo', '(99)9999-9999');

        SELECT *
         FROM getar_cad cad,
              getar_fones fone
        WHERE cad.cod = fone.codcli;

INSERT INTO getar_atrib (`nick`, `codatrib`, `tipo`) 
            VALUES('admin', 1, 'padrao');

 SELECT * FROM getar_atrib;

         SELECT cod,
                nome,
                clasf,
                emailcorp,
                contato,
                rgie,
                cpcn,
                estciv,
                nacna,
                prof,
                endr,
                bairro,
                cidade,
                pais,
                (SELECT codpais FROM estado est WHERE est.pais = pais LIMIT 1) codpais,
                cep,
                estado,
                date_format(nasc, '%d') dia_nasc,
                date_format(nasc, '%m') mes_nasc,
                date_format(nasc, '%Y') ano_nasc,
                date_format(desde, '%d') dia_desde,
                date_format(desde, '%m') mes_desde,
                date_format(desde, '%Y') ano_desde,
                ref,
               # (SELECT COUNT(*) FROM getar_part WHERE nick = '" . $_SESSION['resp'] . "' AND codcad= getar_cad.cod) nm,
                situacao
           FROM getar_cad
          WHERE cod= 1200;

SELECT cod, nome, emailcorp FROM getar_cad WHERE cod= 273;
SELECT cod, nome, emailcorp FROM getar_cad WHERE emailcorp != '';

SHOW CREATE TABLE getar_control;
CREATE TABLE `getar_control` (
  `nick` varchar(20) NOT NULL,
  `emailcorp` varchar(60) DEFAULT NULL COMMENT 'Para uso de envio e-mail pelo Getar',
  `hashsl` varchar(256) NOT NULL,
  `codcad` int(11) NOT NULL,
  `contrahash` varchar(256) NOT NULL,
  `custohora` decimal(10,2) NOT NULL,
  PRIMARY KEY (`nick`),
  KEY `fk_ctcad` (`codcad`),
  CONSTRAINT `fk_ctcad` FOREIGN KEY (`codcad`) REFERENCES `getar_cad` (`cod`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci

ALTER TABLE getar_control CHANGE frase hashsl VARCHAR(256) NOT NULL;
ALTER TABLE getar_control CHANGE contra contrahash VARCHAR(256) NOT NULL;
ALTER TABLE getar_control CHANGE codcad codcad INT(11) NOT NULL;
ALTER TABLE getar_control CHANGE nick nick VARCHAR(20) NOT NULL;
ALTER TABLE getar_control ADD emailcorp varchar(60) DEFAULT NULL COMMENT 'Para uso de envio e-mail pelo Getar' AFTER nick;

UPDATE getar_control SET hashsl= '$2y$10$BS/ciby7ACQFdhZ2ijo6ve.DD9ZIx2byaJWSdAoQacUATnsD6IlNa' WHERE nick='pregis';
UPDATE getar_control SET contrahash= '$2y$10$N2CMC8ih4iOKWH0qcoVRrulHVCIs0bDJOw32CgF4m/JLFfwlkEs5G' WHERE nick='pregis';
          SELECT hashsl
            FROM getar_control
           WHERE nick  ='pregis';

INSERT INTO `getar_control` VALUES ('admin','*098B2780BCF9639317284CB946DAE68EAEB222AD',1,'',0.00),
('aninha_reg','*EDA3881CA744F437C7C6CBC3E40C574BFE660FD3',454,'',0.00),
('kauan','*EDA3881CA744F437C7C6CBC3E40C574BFE660FD3',1294,'',0.00),
('pregis','*EA69354690168BDBEDF29CA0A304E7841CE2BA23',273,'*7BD415BCE20D48FC0FEC0B2A9568E19C7125E0DC',30.00),
('sofia2t','*D028C20D58D6D8CB642DEE85C7EBBAD1B3B0FC10',838,'',30.00),
('tecno','*EDA3881CA744F437C7C6CBC3E40C574BFE660FD3',804,'',30.00);

# email corporativo
UPDATE getar_control SET emailcorp='teste@pergamo' WHERE codcad= 804;
UPDATE getar_control SET emailcorp='' WHERE nick= 'tecno';

SELECT emailcorp FROM getar_control WHERE codcad = 804;
SELECT * FROM getar_control;

SHOW CREATE TABLE getar_cad;
CREATE TABLE `getar_cad` (
  `cod` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(120) DEFAULT NULL,
  `clasf` char(1) DEFAULT NULL,
  `contato` varchar(20) DEFAULT NULL,
  `endr` varchar(40) DEFAULT NULL,
  `numero` varchar(8) NOT NULL DEFAULT '',
  `complemento` varchar(60) NOT NULL DEFAULT '',
  `bairro` varchar(60) DEFAULT NULL,
  `cidade` varchar(40) DEFAULT NULL,
  `pais` varchar(60) NOT NULL DEFAULT 'Brasil',
  `cep` varchar(9) DEFAULT NULL,
  `estado` varchar(40) DEFAULT NULL,
  `cpcn` varchar(20) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `rgie` varchar(20) DEFAULT NULL,
  `ie` varchar(20) DEFAULT NULL,
  `desde` date DEFAULT '2001-01-01',
  `nasc` date DEFAULT '2001-01-01',
  `ref` varchar(40) DEFAULT NULL,
  `emailcorp` varchar(60) DEFAULT NULL COMMENT 'Para uso de envio e-mail pelo Getar',
  `estciv` varchar(20) DEFAULT 'casado',
  `sexo` varchar(120) DEFAULT 'masculino',
  `nacna` varchar(20) DEFAULT 'Brasileiro' COMMENT 'Nacionalidade',
  `situacao` varchar(60) NOT NULL,
  PRIMARY KEY (`cod`)
) ENGINE=InnoDB AUTO_INCREMENT=1410 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci