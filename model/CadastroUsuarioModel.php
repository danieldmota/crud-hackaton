<?php

require_once __DIR__ . '/../config/database.php';

class CadastroUsuarioModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function Cadastro($data)
    {
        try {
            $sql = "INSERT INTO clientes (
                        nome,
                        cpf,
                        -- foto_perfil,
                        telefone,
                        email,
                        senha
                    ) VALUES (
                        :nome,
                        :cpf,
                        -- :foto_perfil,
                        :telefone,
                        :email,
                        :senha
                    )";

            $stmt = $this->conn->prepare($sql);

            // Preparação de senha com hash seguro
            $senhaHash = password_hash($data['senha'], PASSWORD_BCRYPT);

            $stmt->bindParam(':nome', $data['nome']);
            $stmt->bindParam(':cpf', $data['cpf']);
            // $stmt->bindParam(':foto_perfil', $data['foto_perfil']);
            $stmt->bindParam(':telefone', $data['telefone']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':senha', $senhaHash);

            return $stmt->execute();
        } catch (PDOException $e) {
            return [
                'error' => true,
                'message' => 'Erro ao cadastrar cliente: ' . $e->getMessage()
            ];
        }
    }

    public function checkCpfExists($cpf)
    {
        $sql = "SELECT id FROM clientes WHERE cpf = :cpf LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function checkEmailExists($email)
    {
        $sql = "SELECT id FROM clientes WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }
}
