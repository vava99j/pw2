create database pet;
use pet;

create table usuarios (
    id int auto_increment primary key,
    email varchar(100) not null unique,
    nome varchar(100) not null,
    foto_user longblob,
    telefone varchar(20) not null,
    senha varchar(255) not null
);

describe usuarios;

select * from usuarios;

create table animal (
    id_animal int auto_increment primary key,
    nome_pet varchar(100) not null,
    tipo varchar(50),
    idade int,
    contato varchar(50),
    descricao text,
    endereco varchar(100),
    foto_pet longblob
);