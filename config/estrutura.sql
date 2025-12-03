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

CREATE TABLE estados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sigla VARCHAR(2) NOT NULL,
    nome VARCHAR(50) NOT NULL
);



CREATE TABLE formas_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE
);

select * from formas_pagamento;


INSERT INTO formas_pagamento (nome) VALUES
('cash'), ('credit-card'), ('debit-card'),
('pix'), ('voucher');

INSERT INTO caracteristicas (nome) VALUES
('vegetarian'), ('vegan'), ('gluten-free'),
('romantic'), ('family-friendly'), ('pet-friendly'),
('outdoor'), ('live-music'), ('parking'),
('wifi'), ('delivery'), ('bar');

INSERT INTO estados (sigla, nome) VALUES
('AC','Acre'), ('AL','Alagoas'), ('AP','Amapá'), ('AM','Amazonas'),
('BA','Bahia'), ('CE','Ceará'), ('DF','Distrito Federal'), ('ES','Espírito Santo'),
('GO','Goiás'), ('MA','Maranhão'), ('MT','Mato Grosso'), ('MS','Mato Grosso do Sul'),
('MG','Minas Gerais'), ('PA','Pará'), ('PB','Paraíba'), ('PR','Paraná'),
('PE','Pernambuco'), ('PI','Piauí'), ('RJ','Rio de Janeiro'), ('RN','Rio Grande do Norte'),
('RS','Rio Grande do Sul'), ('RO','Rondônia'), ('RR','Roraima'), ('SC','Santa Catarina'),
('SP','São Paulo'), ('SE','Sergipe'), ('TO','Tocantins');

select * from reservas;

select * from restaurantes;

