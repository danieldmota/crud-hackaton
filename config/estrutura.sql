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

-- Restaurante 2: Sushi & Cia
INSERT INTO restaurantes (nome, cnpj, categoria, capacidade, descricao, imagem) VALUES
('Sushi & Cia', '98.765.432/0001-12', 'Japonesa', 60, 'Autêntica cozinha japonesa preparada por mestres sushi certificados. Oferecemos peças frescas, impérios rodantes e pratos especiais. Ambiente moderno e clean com balcão de observação.', NULL);

INSERT INTO enderecos_restaurantes (restaurante_id, rua, bairro, cidade, estado, cep) VALUES
(2, 'Avenida Paulista', 'Bela Vista', 'São Paulo', 'SP', '01311-100');

INSERT INTO contatos_restaurantes (restaurante_id, telefone, email, website) VALUES
(2, '(11) 3789-4560', 'contato@sushiecia.com.br', 'www.sushiecia.com.br');

INSERT INTO horarios_funcionamento (restaurante_id, dia_semana, hora_abertura, hora_fechamento, ativo) VALUES
(2, 'Segunda', '12:00', '22:00', 1),
(2, 'Terça', '12:00', '22:00', 1),
(2, 'Quarta', '12:00', '22:00', 1),
(2, 'Quinta', '12:00', '23:00', 1),
(2, 'Sexta', '12:00', '23:00', 1),
(2, 'Sábado', '12:00', '23:00', 1),
(2, 'Domingo', '12:00', '21:00', 1);

INSERT INTO restaurante_caracteristicas (restaurante_id, caracteristica_id) VALUES
(2, 3), (2, 5), (2, 6);

INSERT INTO restaurante_pagamentos (restaurante_id, pagamento_id) VALUES
(2, 1), (2, 2), (2, 3), (2, 4);

INSERT INTO cardapio_itens (restaurante_id, categoria, nome, descricao, preco, disponivel) VALUES
(2, 'pratos', 'Sushi Misto', 'Seleção de 12 peças: salmão, atum, peixe branco e vegetais', 52.90, 1),
(2, 'pratos', 'Sashimi Premium', 'Fatias finas de salmão selvagem e atum', 58.90, 1),
(2, 'pratos', 'Temaki Salmão', 'Cone de alga com salmão fresco, maionese e abacate', 28.90, 1),
(2, 'pratos', 'Moqueca de Salmão', 'Salmão em caldo cremoso com leite de coco', 45.90, 1),
(2, 'bebidas', 'Saquê Premium', 'Bebida tradicional japonesa', 35.90, 1),
(2, 'sobremesas', 'Mochi de Frutas Vermelhas', 'Doce gelado feito com farinha de arroz', 16.90, 1);

INSERT INTO avaliacoes (restaurante_id, cliente_id, nome_cliente, rating, comentario, data_criacao) VALUES
(2, 1, 'Maria Silva', 5, 'Sushi fresco e de primeira qualidade! Os mestres sushi são incríveis e conhecem bem do seu trabalho.', '2024-01-20 18:30:00'),
(2, 2, 'João Santos', 4, 'Ótimo ambiente, mas um pouco caro. A comida é excelente!', '2024-01-18 19:00:00');

-- Restaurante 3: Grill do Gaúcho
INSERT INTO restaurantes (nome, cnpj, categoria, capacidade, descricao, imagem) VALUES
('Grill do Gaúcho', '55.123.456/0001-78', 'Churrascaria', 100, 'Autêntica churrascaria com cortes premium de carne bovina. Rodízio completo com salada bar variado. Ambiente rústico e aconchegante.', NULL);

INSERT INTO enderecos_restaurantes (restaurante_id, rua, bairro, cidade, estado, cep) VALUES
(3, 'Rua da Paz', 'Zona Sul', 'Rio de Janeiro', 'RJ', '20210-230');

INSERT INTO contatos_restaurantes (restaurante_id, telefone, email, website) VALUES
(3, '(21) 3512-8900', 'reservas@grilldogaucho.com.br', 'www.grilldogaucho.com.br');

INSERT INTO horarios_funcionamento (restaurante_id, dia_semana, hora_abertura, hora_fechamento, ativo) VALUES
(3, 'Segunda', '11:30', '23:00', 1),
(3, 'Terça', '11:30', '23:00', 1),
(3, 'Quarta', '11:30', '23:00', 1),
(3, 'Quinta', '11:30', '23:30', 1),
(3, 'Sexta', '11:30', '23:30', 1),
(3, 'Sábado', '11:30', '00:00', 1),
(3, 'Domingo', '11:30', '22:00', 1);

INSERT INTO restaurante_caracteristicas (restaurante_id, caracteristica_id) VALUES
(3, 2), (3, 3), (3, 5), (3, 6);

INSERT INTO restaurante_pagamentos (restaurante_id, pagamento_id) VALUES
(3, 1), (3, 2), (3, 3), (3, 4), (3, 5);

INSERT INTO cardapio_itens (restaurante_id, categoria, nome, descricao, preco, disponivel) VALUES
(3, 'pratos', 'Rodízio de Carnes Premium', 'Seleção de cortes escolhidos: picanha, costela, fraldinha, cupim', 89.90, 1),
(3, 'pratos', 'Moqueca de Camarão', 'Camarões cozidos em leite de coco com dendê', 62.90, 1),
(3, 'saladas', 'Salada Bar Completo', 'Acesso livre ao bar de saladas', 0.00, 1),
(3, 'bebidas', 'Chopp Artesanal', 'Cerveja artesanal gelada', 18.90, 1),
(3, 'sobremesas', 'Brigadeiro Gourmet', 'Feito com chocolate belga', 12.90, 1);

INSERT INTO avaliacoes (restaurante_id, cliente_id, nome_cliente, rating, comentario, data_criacao) VALUES
(2, 3, 'Ana Costa', 5, 'Melhor churrascaria do Rio! Carne de primeira, salada bar maravilhoso e atendimento de excelência!', '2024-01-22 21:00:00');

-- Restaurante 4: Le Petit Bistro
INSERT INTO restaurantes (nome, cnpj, categoria, capacidade, descricao, imagem) VALUES
('Le Petit Bistro', '77.654.321/0001-45', 'Francesa', 45, 'Bistrô francês tradicional com pratos clássicos da culinária francesa. Ambiente elegante com decoração sofisticada. Perfeito para casais.', NULL);

INSERT INTO enderecos_restaurantes (restaurante_id, rua, bairro, cidade, estado, cep) VALUES
(4, 'Rua Oscar Freire', 'Pinheiros', 'São Paulo', 'SP', '05409-011');

INSERT INTO contatos_restaurantes (restaurante_id, telefone, email, website) VALUES
(4, '(11) 3064-2500', 'reservas@lepetitbistro.com.br', 'www.lepetitbistro.com.br');

INSERT INTO horarios_funcionamento (restaurante_id, dia_semana, hora_abertura, hora_fechamento, ativo) VALUES
(4, 'Segunda', 'FECHADO', 'FECHADO', 0),
(4, 'Terça', '19:00', '23:00', 1),
(4, 'Quarta', '19:00', '23:00', 1),
(4, 'Quinta', '19:00', '23:00', 1),
(4, 'Sexta', '19:00', '00:00', 1),
(4, 'Sábado', '19:00', '00:00', 1),
(4, 'Domingo', '12:00', '22:00', 1);

INSERT INTO restaurante_caracteristicas (restaurante_id, caracteristica_id) VALUES
(4, 1), (4, 4), (4, 5);

INSERT INTO restaurante_pagamentos (restaurante_id, pagamento_id) VALUES
(4, 2), (4, 3), (4, 4);

INSERT INTO cardapio_itens (restaurante_id, categoria, nome, descricao, preco, disponivel) VALUES
(4, 'pratos', 'Coq au Vin', 'Frango cozido em vinho tinto com cogumelos', 72.90, 1),
(4, 'pratos', 'Boef Bourguignon', 'Carne vermelha cozida em vinho com cebola e cenoura', 78.90, 1),
(4, 'pratos', 'Creme de Alho Francês', 'Sopa tradicional francesa', 28.90, 1),
(4, 'pratos', 'Escargot à Pariense', 'Caracóis preparados com ervas e manteiga', 35.90, 1),
(4, 'sobremesas', 'Soufflé de Chocolate', 'Leve e arejado, servido quente', 29.90, 1);

INSERT INTO avaliacoes (restaurante_id, cliente_id, nome_cliente, rating, comentario, data_criacao) VALUES
(4, 3, 'Ana Costa', 5, 'Que experiência maravilhosa! Pratos autênticos franceses, vinho excelente e atendimento impecável. Voltarei com meu namorado!', '2024-01-25 20:30:00');

-- Restaurante 5: Casa do Pão de Queijo
INSERT INTO restaurantes (nome, cnpj, categoria, capacidade, descricao, imagem) VALUES
('Casa do Pão de Queijo', '33.222.111/0001-99', 'Mineira', 70, 'Culinária mineira autêntica. Comida caseira com receitas tradicionais. Ambiente acolhedor que remete ao interior de Minas Gerais.', NULL);

INSERT INTO enderecos_restaurantes (restaurante_id, rua, bairro, cidade, estado, cep) VALUES
(5, 'Av. Brasil', 'Funcionários', 'Belo Horizonte', 'MG', '30140-071');

INSERT INTO contatos_restaurantes (restaurante_id, telefone, email, website) VALUES
(5, '(31) 3296-8800', 'info@casadopaoqueijo.com.br', 'www.casadopaoqueijo.com.br');

INSERT INTO horarios_funcionamento (restaurante_id, dia_semana, hora_abertura, hora_fechamento, ativo) VALUES
(5, 'Segunda', '11:00', '21:00', 1),
(5, 'Terça', '11:00', '21:00', 1),
(5, 'Quarta', '11:00', '21:00', 1),
(5, 'Quinta', '11:00', '21:00', 1),
(5, 'Sexta', '11:00', '22:00', 1),
(5, 'Sábado', '11:00', '22:00', 1),
(5, 'Domingo', '11:00', '20:00', 1);

INSERT INTO restaurante_caracteristicas (restaurante_id, caracteristica_id) VALUES
(5, 1), (5, 2), (5, 6);

INSERT INTO restaurante_pagamentos (restaurante_id, pagamento_id) VALUES
(5, 1), (5, 2), (5, 3), (5, 4), (5, 5);

INSERT INTO cardapio_itens (restaurante_id, categoria, nome, descricao, preco, disponivel) VALUES
(5, 'pratos', 'Feijoada Mineira', 'Feita lentamente com carne de porco', 38.90, 1),
(5, 'pratos', 'Frango com Quiabo', 'Prato típico mineiro', 32.90, 1),
(5, 'pratos', 'Tutu de Feijão', 'Massa de feijão com linguiça', 28.90, 1),
(5, 'acompanhamentos', 'Pão de Queijo Quentinho', 'Feito na hora', 8.90, 1),
(5, 'bebidas', 'Água de Coco Natural', 'Coco fresco', 12.90, 1),
(5, 'sobremesas', 'Broinhas de Chuva', 'Doces tradicionais', 15.90, 1);

INSERT INTO avaliacoes (restaurante_id, cliente_id, nome_cliente, rating, comentario, data_criacao) VALUES
(5, 1, 'Maria Silva', 5, 'Sensacional! Comida mineira autêntica que remete à avó. Pão de queijo quentinho e feijoada deliciosa!', '2024-01-28 12:30:00');

-- Restaurante 6: Dragon Palace
INSERT INTO restaurantes (nome, cnpj, categoria, capacidade, descricao, imagem) VALUES
('Dragon Palace', '44.555.666/0001-11', 'Chinesa', 80, 'Culinária chinesa autêntica com pratos especiais e receitas secretas. Ambiente orientalista com decoração asiática. Perfeito para famílias.', NULL);

INSERT INTO enderecos_restaurantes (restaurante_id, rua, bairro, cidade, estado, cep) VALUES
(6, 'Rua 25 de Março', 'Bom Retiro', 'São Paulo', 'SP', '01310-100');

INSERT INTO contatos_restaurantes (restaurante_id, telefone, email, website) VALUES
(6, '(11) 3331-4466', 'contato@dragonpalace.com.br', 'www.dragonpalace.com.br');

INSERT INTO horarios_funcionamento (restaurante_id, dia_semana, hora_abertura, hora_fechamento, ativo) VALUES
(6, 'Segunda', '11:30', '22:30', 1),
(6, 'Terça', '11:30', '22:30', 1),
(6, 'Quarta', '11:30', '22:30', 1),
(6, 'Quinta', '11:30', '23:00', 1),
(6, 'Sexta', '11:30', '23:00', 1),
(6, 'Sábado', '12:00', '23:00', 1),
(6, 'Domingo', '12:00', '22:30', 1);

INSERT INTO restaurante_caracteristicas (restaurante_id, caracteristica_id) VALUES
(6, 1), (6, 3), (6, 5);

INSERT INTO restaurante_pagamentos (restaurante_id, pagamento_id) VALUES
(6, 1), (6, 2), (6, 3), (6, 4);

INSERT INTO cardapio_itens (restaurante_id, categoria, nome, descricao, preco, disponivel) VALUES
(6, 'pratos', 'Frango com Brócolis', 'Frango macio com molho caseiro', 32.90, 1),
(6, 'pratos', 'Camarão ao Molho', 'Camarões em molho agridoce', 42.90, 1),
(6, 'pratos', 'Pato à Pequim', 'Pato crocante com molho especial', 52.90, 1),
(6, 'bebidas', 'Chá Verde Premium', 'Chá tradicional chinês', 8.90, 1),
(6, 'sobremesas', 'Bolinha de Coco', 'Doce asiático delicado', 9.90, 1);

INSERT INTO avaliacoes (restaurante_id, cliente_id, nome_cliente, rating, comentario, data_criacao) VALUES
(6, 2, 'João Santos', 4, 'Comida chinesa de boa qualidade. Ambiente aconchegante. Recomendo!', '2024-01-30 13:00:00');

-- Restaurante 7: Taj Mahal
INSERT INTO restaurantes (nome, cnpj, categoria, capacidade, descricao, imagem) VALUES
('Taj Mahal', '66.777.888/0001-22', 'Indiana', 65, 'Gastronomia indiana autêntica com especiarias exóticas e receitas milenares. Ambiente elegante com temática oriental. Excelentes opções vegetarianas.', NULL);

INSERT INTO enderecos_restaurantes (restaurante_id, rua, bairro, cidade, estado, cep) VALUES
(7, 'Avenida Paulista', 'Consolação', 'São Paulo', 'SP', '01311-923');

INSERT INTO contatos_restaurantes (restaurante_id, telefone, email, website) VALUES
(7, '(11) 3170-0066', 'reservas@tajmahal.com.br', 'www.tajmahal.com.br');

INSERT INTO horarios_funcionamento (restaurante_id, dia_semana, hora_abertura, hora_fechamento, ativo) VALUES
(7, 'Segunda', '18:00', '23:00', 1),
(7, 'Terça', '18:00', '23:00', 1),
(7, 'Quarta', '18:00', '23:00', 1),
(7, 'Quinta', '18:00', '23:30', 1),
(7, 'Sexta', '18:00', '23:30', 1),
(7, 'Sábado', '18:00', '00:00', 1),
(7, 'Domingo', '18:00', '22:00', 1);

INSERT INTO restaurante_caracteristicas (restaurante_id, caracteristica_id) VALUES
(7, 1), (7, 4), (7, 5);

INSERT INTO restaurante_pagamentos (restaurante_id, pagamento_id) VALUES
(7, 1), (7, 2), (7, 3), (7, 4);

INSERT INTO cardapio_itens (restaurante_id, categoria, nome, descricao, preco, disponivel) VALUES
(7, 'pratos', 'Frango Tikka Masala', 'Frango em molho cremoso de tomate e especiarias', 48.90, 1),
(7, 'pratos', 'Naan Integral', 'Pão indiano tradicional', 12.90, 1),
(7, 'pratos', 'Chana Masala', 'Grão de bico em molho de tomate e especiarias', 32.90, 1),
(7, 'pratos', 'Samosas', 'Pastéis fritos com batata e ervilha', 16.90, 1),
(7, 'bebidas', 'Lassi de Mango', 'Bebida tradicional de iogurte com manga', 14.90, 1),
(7, 'sobremesas', 'Gulab Jamun', 'Bolinhos em calda de açúcar', 18.90, 1);

INSERT INTO avaliacoes (restaurante_id, cliente_id, nome_cliente, rating, comentario, data_criacao) VALUES
(7, 3, 'Ana Costa', 5, 'Que sabor exótico! Frango Tikka Masala perfeito e as samosas crispy. Voltarei com certeza!', '2024-02-02 19:30:00');

-- Restaurante 8: Sabor do Nordeste
INSERT INTO restaurantes (nome, cnpj, categoria, capacidade, descricao, imagem) VALUES
('Sabor do Nordeste', '88.999.000/0001-33', 'Nordestina', 75, 'Autentica culinária nordestina com receitas tradicionais. Baião de dois, acarajé, peixada e mais. Ambiente aconchegante com música ao vivo nos fins de semana.', NULL);

INSERT INTO enderecos_restaurantes (restaurante_id, rua, bairro, cidade, estado, cep) VALUES
(8, 'Rua Pinheiro', 'Boa Vista', 'Recife', 'PE', '50010-180');

INSERT INTO contatos_restaurantes (restaurante_id, telefone, email, website) VALUES
(8, '(81) 3224-2566', 'info@sabordnonordeste.com.br', 'www.sabordnonordeste.com.br');

INSERT INTO horarios_funcionamento (restaurante_id, dia_semana, hora_abertura, hora_fechamento, ativo) VALUES
(8, 'Segunda', '11:00', '22:00', 1),
(8, 'Terça', '11:00', '22:00', 1),
(8, 'Quarta', '11:00', '22:00', 1),
(8, 'Quinta', '11:00', '22:00', 1),
(8, 'Sexta', '11:00', '23:00', 1),
(8, 'Sábado', '11:00', '23:00', 1),
(8, 'Domingo', '11:00', '21:00', 1);

INSERT INTO restaurante_caracteristicas (restaurante_id, caracteristica_id) VALUES
(8, 1), (8, 2), (8, 6);

INSERT INTO restaurante_pagamentos (restaurante_id, pagamento_id) VALUES
(8, 1), (8, 2), (8, 3), (8, 4), (8, 5);

INSERT INTO cardapio_itens (restaurante_id, categoria, nome, descricao, preco, disponivel) VALUES
(8, 'pratos', 'Acarajé', 'Bolinha frita de feijão com camarão', 12.90, 1),
(8, 'pratos', 'Peixada Nordestina', 'Mistura de peixes cozidos com pirarucu', 58.90, 1),
(8, 'pratos', 'Baião de Dois', 'Mistura de milho e feijão com carne seca', 28.90, 1),
(8, 'pratos', 'Caldo de Camarão', 'Mistura aquentadora de camarão', 35.90, 1),
(8, 'bebidas', 'Água de Coco Natural', 'Coco gelado direto do coco', 8.90, 1),
(8, 'sobremesas', 'Tapioca com Goiabada', 'Tapioca quentinha com doce de goiaba', 14.90, 1);

INSERT INTO avaliacoes (restaurante_id, cliente_id, nome_cliente, rating, comentario, data_criacao) VALUES
(8, 1, 'Maria Silva', 5, 'Autêntico! Peixada maravilhosa, acarajé crocante e música ao vivo perfeita!', '2024-02-05 20:00:00'),
(8, 2, 'João Santos', 4, 'Ótima experiência com comida nordestina de verdade. Preço um pouco alto, mas vale!', '2024-02-03 19:30:00');

-- Estados
INSERT INTO estados (sigla, nome) VALUES
('AC','Acre'), ('AL','Alagoas'), ('AP','Amapá'), ('AM','Amazonas'),
('BA','Bahia'), ('CE','Ceará'), ('DF','Distrito Federal'), ('ES','Espírito Santo'),
('GO','Goiás'), ('MA','Maranhão'), ('MT','Mato Grosso'), ('MS','Mato Grosso do Sul'),
('MG','Minas Gerais'), ('PA','Pará'), ('PB','Paraíba'), ('PR','Paraná'),
('PE','Pernambuco'), ('PI','Piauí'), ('RJ','Rio de Janeiro'), ('RN','Rio Grande do Norte'),
('RS','Rio Grande do Sul'), ('RO','Rondônia'), ('RR','Roraima'), ('SC','Santa Catarina'),
('SP','São Paulo'), ('SE','Sergipe'), ('TO','Tocantins');