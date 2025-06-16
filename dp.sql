CREATE DATABASE IF NOT EXISTS pet;
USE pet;

-- TABELA DE USUÁRIOS
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    foto_user LONGBLOB
);

CREATE TABLE IF NOT EXISTS animal (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_pet VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    idade INT NOT NULL,
    descricao TEXT NOT NULL,
    foto_pet LONGBLOB NOT NULL,
    endereco VARCHAR(255) NOT NULL,
    id_usuario INT NOT NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);

-- CONSULTAS
-- 1. Ver todos os usuários
SELECT * FROM usuarios;

-- 2. Ver todos os animais
SELECT * FROM animal;

-- 3. Ver animais com dados dos donos
SELECT 
    usuarios.id AS id_user,
    usuarios.email,
    usuarios.nome AS dono,
    usuarios.telefone,
    animal.id_animal,
    animal.nome_pet,
    animal.descriçao
FROM animal
INNER JOIN usuarios ON animal.id_usuario = usuarios.id;


ALTER TABLE animal ADD COLUMN contato VARCHAR(20);
