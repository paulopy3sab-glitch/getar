SELECT 'teste' FROM DUAL;
CREATE TABLE pessoa(
    id_pessoa INTEGER,
    nome VARCHAR2(200),
    cpf VARCHAR2(14)
);

CREATE TABLE curso(
    id_curso INTEGER,
    nome VARCHAR2(20)
);

CREATE TABLE mensalidade(
    id_curso INTEGER,
    id_pessoa INTEGER,
    valor NUMBER(5,2)
);

ALTER TABLE pessoa ADD CONSTRAINT id_pessoa_pk PRIMARY KEY (id_pessoa);
ALTER TABLE curso ADD CONSTRAINT id_curso_pk PRIMARY KEY (id_curso);
ALTER TABLE mensalidade ADD CONSTRAINT id_pessoa_fk FOREIGN KEY (id_pessoa) REFERENCES pessoa(id_pessoa);
ALTER TABLE mensalidade ADD CONSTRAINT id_curso_fk FOREIGN KEY (id_curso) REFERENCES curso(id_curso);

/*
* para o GETAR
*/
CREATE SEQUENCE codcad;
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
DROP TABLE GETAR_CAD;
TRUNCATE TABLE getar_cad;

SELECT * FROM GETAR_CAD;

        INSERT INTO getar_cad(cod, nome)
                    VALUES(
                           (SELECT MAX(cod)+1 cod FROM getar_cad),
                            'Joao de Castro'
);
/*
** Alteracoes de tabela
Alter table Pessoa add RG varchar2(14);
Alter table Pessoa drop column RG;
ALTER TABLE Pessoa RENAME COLUMN CPF TO Num_CPF;
ALTER TABLE Pessoa RENAME TO Alunos;
DROP TABLE pessoa;
*/


/*
* Dados e select 
*/

INSERT INTO pessoa VALUES(1, 'Paulo', '548.365.650-49');
INSERT INTO pessoa VALUES(2, 'Maria da Silva', '888.888.888-88');

        INSERT INTO pessoa VALUES(
                                  (SELECT MAX(id_pessoa)+1 id_pessoa FROM pessoa),
                                  'Joao de Castro',
                                  '666.666.666-66');

INSERT INTO curso VALUES(1, 'PHP Nivel 1');
INSERT INTO mensalidade VALUES(1, 1, 54.3);
INSERT INTO mensalidade VALUES(1, 2, 54.3);

SELECT * FROM pessoa;

        SELECT p.NOME,
               c.NOME,
               m.VALOR
          FROM PESSOA p,
               CURSO c,
               MENSALIDADE m
         WHERE m.ID_CURSO = c.ID_CURSO
               AND m.ID_PESSOA = p.ID_PESSOA
               AND p.NOME = 'Paulo';

/**
**
**/
SELECT TO_CHAR
    (SYSDATE, 'MM-DD-YYYY HH24:MI:SS') "NOW"
     FROM DUAL;
/**
NOW
-------------------
04-13-2001 09:45:51 **/

SELECT * FROM getar_reglog;
UPDATE getar_reglog SET horafim = SYSDATE WHERE cod = 1;
/* Código do erro 904, estado do SQL 42000: ORA-00904: "CURDATE": identificador inválido */