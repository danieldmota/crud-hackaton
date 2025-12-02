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

    public function Login($email, $senha)
    {
        $sql = "SELECT id,tipo_perfil, email, senha FROM {$this->tabela} WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            unset($usuario['senha']);
            return (object) $usuario;
        }

        return false;
    }
}






?>