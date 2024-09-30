create database bloco_notas_isabela_victoria;
use bloco_notas_isabela_victoria;

create table nota (
	id_nota int primary key auto_increment not null,
    titulo_nota varchar(45),
    anotacao varchar(15000),
    data_nota timestamp default current_timestamp,
    prioridade_nota enum('importante', 'normal', 'irrelevante')
);

create table usuario (
	id_usuario int primary key auto_increment not null,
    nome_usuario varchar(50),
    email_usuario varchar(50),
    senha_usuario varchar(50)
);