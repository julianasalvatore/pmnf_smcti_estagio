DROP DATABASE IF EXISTS prefeitura;
CREATE DATABASE IF NOT EXISTS  prefeitura DEFAULT CHARSET=utf8 DEFAULT COLLATE=utf8_unicode_ci;
USE prefeitura;


CREATE TABLE IF NOT EXISTS instituicao(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL,
    inicio_vinculo DATE NOT NULL, 
    termino_vinculo DATE NOT NULL,

    UNIQUE INDEX idx_nome(nome)
)ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS localEstagio(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(200) NOT NULL
)ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS aluno(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(65) NOT NULL,
    nascimento DATE NOT NULL,
    email VARCHAR(65) NOT NULL,
    telefone VARCHAR(14), -- 9 caso não use ddd, 11 caso use dd, 13 ddd com parenteses, 14 ddd com parenteses e espaço  
    senha VARCHAR(256), -- !!IMPORTANTE!! SALVE A SENHA EM HASH!!! https://pt.wikipedia.org/wiki/Fun%C3%A7%C3%A3o_hash  https://www.youtube.com/watch?v=b4b8ktEV4Bg 

    id_instituicao INT not null,
    id_local INT not null,

    CONSTRAINT fk_id_instituicao FOREIGN KEY(id_instituicao) REFERENCES instituicao(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_id_local FOREIGN KEY(id_local) REFERENCES localEstagio(id) ON DELETE RESTRICT ON UPDATE CASCADE
)ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS administrador(
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(65) NOT NULL,
    email VARCHAR(65) NOT NULL,
    setor VARCHAR(200) NOT NULL,
    senha VARCHAR(256) -- !!IMPORTANTE!! SALVE A SENHA EM HASH!!! https://pt.wikipedia.org/wiki/Fun%C3%A7%C3%A3o_hash  https://www.youtube.com/watch?v=b4b8ktEV4Bg 
)ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- -- Descomente caso queira que setor seja uma entidade
-- CREATE TABLE IF NOT EXISTS setor(
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     nome VARCHAR(200)
-- )ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- DROP TABLE administrador;

-- CREATE TABLE administrador(
--     id INT AUTO_INCREMENT PRIMARY KEY,
--     nome VARCHAR(65) NOT NULL,
--     email VARCHAR(65) NOT NULL,
--     id_setor INT NOT NULL,
--     senha VARCHAR(256), -- !!IMPORTANTE!! SALVE A SENHA EM HASH!!! https://pt.wikipedia.org/wiki/Fun%C3%A7%C3%A3o_hash  https://www.youtube.com/watch?v=b4b8ktEV4Bg 
    
  

--     CONSTRAINT fk_id_setor FOREIGN KEY(id_setor) REFERENCES setor(id) ON DELETE RESTRICT ON UPDATE CASCADE

-- )ENGINE=INNODB CHARSET=utf8 COLLATE=utf8_unicode_ci;

