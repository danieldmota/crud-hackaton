# CRUD Hackaton — Guia de instalação e execução

Este README descreve passo a passo como configurar e executar o projeto `crud-hackaton` localmente (Windows + XAMPP). As instruções foram escritas para um ambiente de desenvolvimento local usando XAMPP (Apache + MySQL) e PHP com PDO.

**Resumo rápido**

- Requisitos: XAMPP (Apache + MySQL), PHP >= 7.4 (PDO/MySQL habilitado)
- Colocar projeto em `C:\xampp\htdocs\crud-hackaton`
- Importar `config/estrutura.sql` no MySQL
- Ajustar credenciais em `config/database.php`
- Abrir no navegador: `http://localhost/crud-hackaton` e testar `detalhes.php?id=1`

## Passo a passo detalhado

1. Requisitos

- XAMPP (recomendo versão estável atual). Baixe em: https://www.apachefriends.org/
- PHP: certifique-se que sua instalação do XAMPP tem PHP >= 7.4.

2. Copiar o projeto para a pasta do servidor

- Coloque a pasta do projeto dentro da pasta do Apache (ex.: `C:\xampp\htdocs\crud-hackaton`).

3. Verificar o arquivo `config/database.php`

- Abra `config/database.php` e ajuste as credenciais do banco de dados (host, usuário, senha, nome do banco). Exemplo comum em XAMPP:

4. Importar o esquema / dados do banco

- O arquivo com o esquema e dados de teste está em: `config/estrutura.sql`.
- Você pode importar pelo phpMyAdmin:

  - Abra `http://localhost/phpmyadmin`
  - Clique em "Importar" e selecione `config/estrutura.sql`.

- Ou, pela linha de comando PowerShell (exemplo):

```powershell
# Opcional: ajuste o caminho do mysql se não estiver no PATH
# Exemplo com mysql do XAMPP
"C:\xampp\mysql\bin\mysql.exe" -u root -p < "C:\xampp\htdocs\crud-hackaton\config\estrutura.sql"
# Quando solicitado, digite a senha do MySQL (em XAMPP padrão é vazio, apenas pressione Enter).
```

OBS: `estrutura.sql` já contém `CREATE DATABASE route2eat; USE route2eat;` e instruções de INSERT com dados de exemplo.

7. Iniciar o servidor

- Abra o `XAMPP Control Panel` e inicie `Apache` e `MySQL`.

8. Testar a aplicação

- Acesse no navegador:
  - Página principal: `http://localhost/crud-hackaton/view/pages` (ou `index.php` do projeto)
  - Realizar cadastro pra acessar funcionalidades

9. Pontos de verificação / Troubleshooting

- Erro de conexão com banco (PDOException):
  - Verifique `config/database.php` (host, usuário, senha, nome do DB)
  - Verifique se o MySQL está rodando no XAMPP
  - Verifique se `pdo_mysql` está habilitado no `php.ini` e reinicie o Apache
