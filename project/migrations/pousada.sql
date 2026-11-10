create database pousada;
use pousada;

create table clientes (
    idCliente int primary key auto_increment,
    nome varchar (50) not null,
    cpf varchar (15) unique not null,
    email varchar (100) not null,
    telefone varchar (50) not null,
    cidade varchar (30) not null,
    estado varchar (25) not null
);

create table quartos (
    idQuartos int primary key auto_increment,
    nome varchar (50) not null,
    tipo enum ('Simples','Duplo','Suíte') not null,
    capacidade int not null,
    valor_diaria decimal (10,2) not null,
    descricao varchar (250) not null,
    situacao enum ('Disponível','Ocupado','Manutenção') not null
);
create table reservas(
    idReservas int primary key auto_increment,
    data_entrada date not null,
    data_saida date not null,
    quantidade int not null,
    valor_total decimal (10,2) not null,
    situacao enum ('Confirmada','Cancelada','Finalizada') not null
);