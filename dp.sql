create database pet;

use pet;

create table usuarios (
    id int auto_increment primary key,
    email varchar(100) not null unique,
    nome varchar(100) not null,
    telefone varchar(20) not null,
    senha varchar(255) not null
);

select * from usuarios