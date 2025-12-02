<?php

require_once 'config/database.php';

class loginModel
{
    protected $conn;
    protected $tabela = "usuarios";

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function loginUsuario($email, $senha)
    {
        $sql = "SELECT id, nome, email, senha 
            FROM usuarios 
            WHERE email = :email LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            unset($usuario['senha']);
            return (object) $usuario;
        }

        return false;
    }

    public function loginRestaurante($cnpj, $senha)
    {
        $sql = "SELECT id, nome, cnpj, senha 
            FROM restaurantes 
            WHERE cnpj = :cnpj LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':cnpj', $cnpj);
        $stmt->execute();

        $restaurante = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($restaurante && password_verify($senha, $restaurante['senha'])) {
            unset($restaurante['senha']);
            return (object) $restaurante;
        }

        return false;
    }
}






?>