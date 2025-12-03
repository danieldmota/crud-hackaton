create database route2eat;
use route2eat;

create table clientes(
id int primary key auto_increment,
senha varchar(255) not null,
nome varchar(230) not null,
telefone varchar(15) not null,
email varchar(230) not null unique,
cpf varchar(11) unique not null
);

CREATE TABLE restaurantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cnpj VARCHAR(18) NOT NULL UNIQUE,
    categoria VARCHAR(50) NOT NULL,
    capacidade INT NOT NULL,
    descricao TEXT NOT NULL,
    imagem VARCHAR(255) DEFAULT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE enderecos_restaurantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurante_id INT NOT NULL,
    rua VARCHAR(255) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    estado CHAR(2) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) ON DELETE CASCADE
);

CREATE TABLE contatos_restaurantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurante_id INT NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    email VARCHAR(150) NOT NULL,
    website VARCHAR(255),
    FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) ON DELETE CASCADE
);

CREATE TABLE horarios_funcionamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurante_id INT NOT NULL,
    dia_semana VARCHAR(20) NOT NULL,
    hora_abertura TIME NOT NULL,
    hora_fechamento TIME NOT NULL,
    ativo TINYINT(1) DEFAULT 1,
    FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) ON DELETE CASCADE
);

CREATE TABLE caracteristicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE restaurante_caracteristicas (
    restaurante_id INT NOT NULL,
    caracteristica_id INT NOT NULL,
    PRIMARY KEY (restaurante_id, caracteristica_id),
    FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) ON DELETE CASCADE,
    FOREIGN KEY (caracteristica_id) REFERENCES caracteristicas(id) ON DELETE CASCADE
);

CREATE TABLE formas_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE restaurante_pagamentos (
    restaurante_id INT NOT NULL,
    pagamento_id INT NOT NULL,
    PRIMARY KEY (restaurante_id, pagamento_id),
    FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) ON DELETE CASCADE,
    FOREIGN KEY (pagamento_id) REFERENCES formas_pagamento(id) ON DELETE CASCADE
);

create table categoria( 
id int primary key unique auto_increment,
categoria varchar(230)
);



create table perfil ( 
restaurantes ;
clientes 


);

create table cardapio_itens(
id int primary key auto_increment,
restaurante_id int not null,
categoria varchar(20) not null,
nome varchar(150) not null,
descricao text not null,
preco decimal(10,2) not null,
imagem varchar(255),
disponivel tinyint(1) default 1,
criado_em datetime default current_timestamp,
atualizado_em datetime default current_timestamp on update current_timestamp,
FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) on delete cascade
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
FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id)
);

select * from reservas;

select * from restaurantes;

