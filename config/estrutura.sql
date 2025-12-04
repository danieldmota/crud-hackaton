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

CREATE TABLE avaliacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    restaurante_id INT NOT NULL,
    cliente_id INT,
    nome_cliente VARCHAR(150) NOT NULL,
    rating INT NOT NULL CHECK(rating >= 1 AND rating <= 5),
    comentario TEXT NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (restaurante_id) REFERENCES restaurantes(id) ON DELETE CASCADE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL
);

-- Estados
CREATE TABLE estados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sigla CHAR(2) NOT NULL,
    nome VARCHAR(50) NOT NULL
);

CREATE TABLE formas_pagamento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO formas_pagamento (nome) VALUES
('Dinheiro'), ('Cartão de Crédito'), ('Cartão de Débito'), ('PIX'), ('Vale Alimentação');


-- Inserir dados de teste
INSERT INTO clientes (nome, email, telefone, cpf, senha) VALUES
('Maria Silva', 'maria@email.com', '11987654321', '12345678901', SHA2('senha123', 256)),
('João Santos', 'joao@email.com', '11987654322', '12345678902', SHA2('senha123', 256)),
('Ana Costa', 'ana@email.com', '11987654323', '12345678903', SHA2('senha123', 256));

INSERT INTO restaurantes (nome, cnpj, categoria, capacidade, descricao, imagem) VALUES
('La Bella Italia', '12.345.678/0001-90', 'Italiana', 80, 'O La Bella Italia oferece uma experiência gastronômica única com pratos autênticos da culinária italiana. Nossa equipe de chefs traz receitas tradicionais passadas de geração em geração, preparadas com ingredientes frescos e selecionados. Ambiente acolhedor e sofisticado, perfeito para jantares românticos, encontros com amigos ou celebrações especiais.', NULL);

INSERT INTO enderecos_restaurantes (restaurante_id, rua, bairro, cidade, estado, cep) VALUES
(1, 'Rua das Flores', 'Centro', 'São Paulo', 'SP', '01234-567');

INSERT INTO contatos_restaurantes (restaurante_id, telefone, email, website) VALUES
(1, '(11) 3456-7890', 'contato@labellaitalia.com.br', 'www.labellaitalia.com.br');

INSERT INTO horarios_funcionamento (restaurante_id, dia_semana, hora_abertura, hora_fechamento, ativo) VALUES
(1, 'Segunda', '18:00', '23:00', 1),
(1, 'Terça', '18:00', '23:00', 1),
(1, 'Quarta', '18:00', '23:00', 1),
(1, 'Quinta', '18:00', '23:00', 1),
(1, 'Sexta', '18:00', '00:00', 1),
(1, 'Sábado', '18:00', '00:00', 1),
(1, 'Domingo', '12:00', '22:00', 1);

INSERT INTO caracteristicas (nome) VALUES
('Vegetariano'),
('Área Externa'),
('Estacionamento'),
('Romântico'),
('Wi-Fi Grátis'),
('Música Ambiente');

INSERT INTO restaurante_caracteristicas (restaurante_id, caracteristica_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6);

INSERT INTO formas_pagamento (nome) VALUES
('Dinheiro'),
('Cartão de Crédito'),
('Cartão de Débito'),
('PIX');

INSERT INTO restaurante_pagamentos (restaurante_id, pagamento_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4);

INSERT INTO cardapio_itens (restaurante_id, categoria, nome, descricao, preco, disponivel) VALUES
(1, 'pratos', 'Spaghetti Carbonara', 'Massa artesanal com bacon, ovos, queijo parmesão e pimenta preta', 45.90, 1),
(1, 'pratos', 'Risotto de Camarão', 'Arroz arbóreo cremoso com camarões frescos e ervas', 58.90, 1),
(1, 'pratos', 'Pizza Margherita', 'Massa fina, molho de tomate, mussarela de búfala e manjericão', 42.90, 1),
(1, 'pratos', 'Lasagna à Bolonhesa', 'Camadas de massa, molho bolonhesa, queijo e bechamel', 52.90, 1),
(1, 'pratos', 'Osso Buco', 'Vitela cozida lentamente com legumes e gremolata', 68.90, 1),
(1, 'sobremesas', 'Tiramisu', 'Sobremesa tradicional italiana com café e mascarpone', 24.90, 1);

INSERT INTO avaliacoes (restaurante_id, cliente_id, nome_cliente, rating, comentario, data_criacao) VALUES
(1, 1, 'Maria Silva', 5, 'Experiência incrível! A comida estava deliciosa, o ambiente é acolhedor e o atendimento foi impecável. Definitivamente voltarei!', '2024-01-15 20:30:00'),
(1, 2, 'João Santos', 4, 'Ótimo restaurante! A pizza estava perfeita e o serviço foi rápido. O único ponto negativo foi a espera para conseguir uma mesa, mas valeu a pena.', '2024-01-10 19:45:00'),
(1, 3, 'Ana Costa', 5, 'Melhor restaurante italiano da cidade! O risotto estava divino e o ambiente é perfeito para um jantar romântico. Recomendo muito!', '2024-01-05 21:15:00');

-- Estados
INSERT INTO estados (sigla, nome) VALUES
('AC','Acre'), ('AL','Alagoas'), ('AP','Amapá'), ('AM','Amazonas'),
('BA','Bahia'), ('CE','Ceará'), ('DF','Distrito Federal'), ('ES','Espírito Santo'),
('GO','Goiás'), ('MA','Maranhão'), ('MT','Mato Grosso'), ('MS','Mato Grosso do Sul'),
('MG','Minas Gerais'), ('PA','Pará'), ('PB','Paraíba'), ('PR','Paraná'),
('PE','Pernambuco'), ('PI','Piauí'), ('RJ','Rio de Janeiro'), ('RN','Rio Grande do Norte'),
('RS','Rio Grande do Sul'), ('RO','Rondônia'), ('RR','Roraima'), ('SC','Santa Catarina'),
('SP','São Paulo'), ('SE','Sergipe'), ('TO','Tocantins');