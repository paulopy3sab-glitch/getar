/***
**
**/
DESCRIBE getar_tarefas;
SHOW CREATE TABLE getar_tarefas;


/***
** ESTUDOS FUNCAO
*/
DELIMITER //
CREATE FUNCTION palavra(texto CHAR(20))
RETURNS CHAR(50)
BEGIN
    RETURN CONCAT('Voce digitou: ', texto, '!!!');
END
//
DELIMITER ;

DROP FUNCTION palavra;

SELECT COUNT(*) FROM estoque;
SELECT palavra('Ola funcao');

/**
** ESTUDOS TRIGER
*/

CREATE TABLE empregados(
    idempr INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL COMMENT 'Nome do colaborador'
)ENGINE= InnoDb;

INSERT INTO empregados (nome) VALUES('Paulo');
SELECT idempr, nome FROM empregados;

CREATE TABLE empregados_auditoria (
    idmodf INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idempr INT(11) NOT NULL COMMENT 'Id do tabela empregados modificada',
    nomevelho VARCHAR(60),
    datamodf DATETIME NOT NULL
)ENGINE= InnoDb;
ALTER TABLE empregados_auditoria ADD CONSTRAINT fk_idempr FOREIGN KEY (idempr) REFERENCES empregados (idempr);

INSERT INTO empregados_auditoria (idempr, nomevelho, datamodf) VALUES(1, 'Paulo', CURDATE());
SELECT * FROM empregados_auditoria;

DELIMITER //
CREATE TRIGGER antesupdateempr
BEFORE UPDATE ON empregados 
FOR EACH ROW
BEGIN
    INSERT INTO empregados_auditoria
    SET idempr =  OLD.idempr,
        nomevelho = OLD.nome,
        datamodf = CURDATE();
END //
DELIMITER ;
DROP TRIGGER antesupdateempr;
UPDATE empregados SET nome='Roberto' WHERE idempr= 1;

