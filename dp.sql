create database pet;

use pet;

create table usuarios (
    id int auto_increment primary key,
    email varchar(100) not null unique,
    nome varchar(100) not null,
    telefone varchar(20) not null,
    senha varchar(255) not null
);
   ALTER TABLE usuarios ADD COLUMN foto_user longblob;
   describe usuarios;
    ALTER TABLE usuarios DROP COLUMN contato;
select*from usuarios;

create table animal (
    id_animal int auto_increment primary key,
    nome_pet varchar(100) not null,
    tipo varchar(50),
    idade int,
    descriçao text,
    foto_pet longblob
);
   ALTER TABLE animal ADD COLUMN contato VARCHAR(50);
     ALTER TABLE animal ADD COLUMN endereço VARCHAR(50);
ALTER TABLE animal ADD COLUMN idade INT;
   select*from animal;
   SET SQL_SAFE_UPDATES = 0;
   delete from animal;
   DESCRIBE animal;
   ALTER TABLE animal DROP COLUMN id_usuario;
   SHOW CREATE TABLE animal;
   ALTER TABLE animal MODIFY foto_pet LONGBLOB;
   ALTER TABLE animal DROP FOREIGN KEY animal_ibfk_1;
   ALTER TABLE animal DROP COLUMN id_usuario;
   DELETE FROM animal WHERE id_animal = 7;
   
   
SELECT 
    usuarios.id AS id_user,
    usuarios.email,
    usuarios.nome AS dono,
    usuarios.telefone,
    usuarios.senha,
    animal.id_animal,
    animal.nome_pet,
    animal.descriçao
FROM animal
INNER JOIN usuarios ON animal.id_usuario = usuarios.nome;
