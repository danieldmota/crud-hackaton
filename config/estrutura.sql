create database gestao_de_reserva;

use gestao_de_reserva;

create table clientes(
id_client int(5) primary key auto_increment,
senha varchar(10) not null,
cliente varchar(230) not null,
telefone int(15) not null,
email varchar(230) not null
);

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

creat table(
FOREIGN KEY (pessoa_id) REFERENCES pessoa (pessoa_id),
FOREIGN KEY (aula_id) REFERENCES aula (aula_id)
)


