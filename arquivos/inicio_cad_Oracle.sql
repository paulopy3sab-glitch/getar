/**
**
**/
CREATE TABLE getar_cad(
    cod NUMBER PRIMARY KEY,
    nome VARCHAR2(120),
    clasf VARCHAR(1),
    cont VARCHAR(40),
    endr VARCHAR(120),
    bai VARCHAR(20),
    cid VARCHAR(40),
    cep VARCHAR(9),
    est VARCHAR(2),
    cpcn VARCHAR(20),
    rgie VARCHAR(20),
    desde DATE,
    nasc DATE,
    ref VARCHAR(40),
    limt NUMBER(7,2),
    limtusd NUMBER(7,2),
    situacao VARCHAR(60),
    emailcorp VARCHAR(60)
);

INSERT INTO getar_cad (cod, nome, clasf, situacao)
            VALUES( 1,
                   'Administrador',
                   'a',
                   'ativo');
INSERT INTO getar_cad (cod, nome, clasf, situacao)
            VALUES(
                   (SELECT MAX(cod)+1 cod FROM getar_cad),
                   'Empresa Proprietaria',
                   'c',
                   'ativo');

CREATE TABLE getar_fones (
    cod INTEGER NOT NULL PRIMARY KEY,
    codcli INTEGER NOT NULL,
    numero VARCHAR(13) NOT NULL,
    descr VARCHAR(40) NOT NULL,
    ramal VARCHAR(5),
    situ VARCHAR(20)
);

ALTER TABLE getar_fones ADD CONSTRAINT fk_fonecad FOREIGN KEY (codcli) REFERENCES getar_cad (cod);
INSERT INTO getar_fones(cod, codcli, numero, descr) VALUES(1, 2, '(99)9999-9999', 'Principal');

CREATE TABLE getar_sites (
    cod INTEGER NOT NULL PRIMARY KEY,
    codcli INTEGER NOT NULL,
    endr VARCHAR(120) NOT NULL,
    descr VARCHAR(120) NOT NULL,
    situ VARCHAR(20)
);

ALTER TABLE getar_sites ADD CONSTRAINT fk_sitecad FOREIGN KEY (codcli) REFERENCES getar_cad (cod);
INSERT INTO getar_sites(cod, codcli, endr, descr) VALUES(1, 2, 'http://www.teste.com', 'Principal');

CREATE TABLE getar_emails (
    cod INTEGER NOT NULL PRIMARY KEY,
    codcli INTEGER NOT NULL,
    endr VARCHAR(120) NOT NULL,
    descr VARCHAR(120) NOT NULL,
    situ VARCHAR(20)
);

ALTER TABLE getar_emails ADD CONSTRAINT fk_emailcad FOREIGN KEY (codcli) REFERENCES getar_cad (cod);
INSERT INTO getar_emails(cod, codcli, endr, descr) VALUES(1, 2, 'testes@provedor.coom', 'Principal');

/**
** Para logon no sistemas
**/
CREATE TABLE getar_control (
    nick VARCHAR(20) NOT NULL PRIMARY KEY,
    frase VARCHAR(64) NOT NULL,
    datalog DATE,
    ip VARCHAR(20),
    codcad INTEGER
);

ALTER TABLE getar_control ADD CONSTRAINT fk_ctcad FOREIGN KEY (codcad) REFERENCES getar_cad (cod);
INSERT INTO getar_control (nick, frase, codcad) VALUES('admin', 'mate1128', 1);

CREATE TABLE getar_reglog (
    cod INTEGER NOT NULL,
    nick VARCHAR(40),
    datalog DATE,
    horaini DATE,
    horafim DATE
);

ALTER TABLE getar_reglog ADD CONSTRAINT fk_reglog FOREIGN KEY (nick) REFERENCES getar_control (nick);
INSERT INTO getar_reglog (cod, nick) VALUES(1, 'admin');

/** Tabela para distinguir contatos particulares dos administradores ou gerentes */
CREATE TABLE getar_part (
    nick VARCHAR(20) NOT NULL,
    codcad INTEGER NOT NULL
);

ALTER TABLE `getar_part` ADD CONSTRAINT `fk_ptcad` FOREIGN KEY (`codcad`) REFERENCES `getar_cad` (`cod`);
ALTER TABLE `getar_part` ADD CONSTRAINT `fk_ptctr` FOREIGN KEY (`nick`) REFERENCES `getar_control` (`nick`);

/**
** AREA DE TESTES
**/


