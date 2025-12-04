# 🍽️ Route2Eat — Sistema de Gestão de Reservas de Restaurantes

O **Route2Eat** tem como objetivo facilitar a vida do turista, permitindo que encontre restaurantes próximos de acordo com seus gostos pessoais, além de possibilitar reservas diretamente na plataforma.

---

## 🚀 Como rodar o projeto

### 1️⃣ Clonar o projeto
Clone o repositório diretamente no diretório `htdocs` do XAMPP:


### 2️⃣ Iniciar serviços
- Abra o **XAMPP**
- Inicie **Apache** e **MySQL**

### 3️⃣ Criar o banco de dados
Execute no **phpMyAdmin** ou MySQL Workbench:

1. O arquivo **tables.sql** → cria banco e tabelas  
2. O arquivo **inserts.sql** → popula dados de teste

### 4️⃣ Acessar o sistema
Abra no navegador:
`http://localhost/crud-hackaton/view/pages`
---

## 🧪 Testes

O sistema possui login separado para **cliente** e **restaurante**.  
Você precisará criar manualmente os cadastros para testar.

### ▶️ Cadastro recomendado para testes pra nao esquecer dps

#### 👤 Cliente  
- **email:** `teste@gmail.com`  
- **senha:** `12345678`

#### 🍽️ Restaurante  
- **CNPJ:** `11111111111111`  
- **senha:** `12345678`

> ⚠️ Restaurante faz login com **CNPJ**, não com email.

---

## 📅 Como testar o fluxo de reserva

1. **Crie um perfil de restaurante**  
   Faça login usando o CNPJ cadastrado.

2. **Crie um perfil de cliente**  
   Faça login usando email e senha.

3. **Realize uma reserva**  
   - Logado como cliente, selecione o restaurante que você cadastrou  
   - Preencha a reserva com data, horário e número de pessoas

4. **Acesse como restaurante**  
   - Entre com o CNPJ e senha  
   - A reserva aparecerá na sua lista pendente  
   - Aceite ou recuse a reserva

---

## 📌 Observações importantes

- Caso ocorra erro ao logar, certifique-se que:
  - A senha foi cadastrada corretamente
  - O usuário está fazendo login no formulário correto (cliente ou restaurante)
- Todos os scripts SQL devem ser executados antes do primeiro acesso