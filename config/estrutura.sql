create database route2eat;
use route2eat;

create table clientes(
id int(5) primary key auto_increment,
senha varchar(255) not null,
nome varchar(230) not null,
telefone varchar(15) not null,
email varchar(230) not null unique,
cpf varchar(11) unique not null
);

select * from clientes;

drop table clientes;


create table  restaurantes( 
id_rest int(5) primary key auto_increment,
nome_empresa varchar(230),
cnpj int(14) not null,
senha varchar(10) not null,
endereco varchar(230) not null,
estado varchar(150) not null,
cidade varchar(150) not null,
bairro varchar(150) not null,
cep int(9) not null,
complemento varchar(230),
telefone int(15) not null,
email varchar(230) not null,
categoria varchar(100)
);

create table categoria( 
id_categoria int(5) primary key(id_rest),
categoria varchar(230)
);



create table perfil ( 
restaurantes ;
clientes 


);

create table reservas(
id int(5) primary key auto_increment,
cliente_id int(5) not null,
restaurante_id int(5) not null,
data_reserva date not null,
horario time not null,
numero_pessoas int(3) not null,
pedidos_especiais text,
status varchar(20) default 'pendente',
data_criacao datetime default current_timestamp,
FOREIGN KEY (cliente_id) REFERENCES clientes(id),
FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id_rest)
);

select * from reservas;

