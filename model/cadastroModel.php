<?php

require_once 'config/database.php';
class RestaurantModel
{
    protected $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function createRestaurant($data)
    {
        try {
            $sql = "INSERT INTO restaurantes (
                        nome, cnpj, categoria, capacidade, descricao, imagem, rua, bairro, cidade, estado, cep, telefone, email, website, owner_name, owner_cpf, owner_email, owner_phone,
                        password
                    ) VALUES ( 
                        :nome, :cnpj, :categoria, :capacidade, :descricao, :imagem, :rua, :bairro, :cidade, :estado, :cep, :telefone, :email, :website, :owner_name, :owner_cpf, :owner_email, :owner_phone, :password
                    )";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':nome' => $data['restaurante_nome'],
                ':cnpj' => $data['cnpj'],
                ':categoria' => $data['categoria'],
                ':capacidade' => $data['capacidade'],
                ':descricao' => $data['descricao'],
                ':imagem' => $data['restaurante_imagem'] ?? null,
                ':rua' => $data['rua'],
                ':bairro' => $data['bairro'],
                ':cidade' => $data['cidade'],
                ':estado' => $data['estado'],
                ':cep' => $data['cep'],
                ':telefone' => $data['telefone'],
                ':email' => $data['email'],
                ':website' => $data['website'],
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT)
            ]);

            return $this->conn->lastInsertId();

        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar restaurante: " . $e->getMessage());
        }
    }

    public function insertSchedule($restauranteId, $dias, $abertura, $fechamento)
    {
        try {
            $sql = "INSERT INTO restaurant_schedule 
                    (restaurante_id, dia, hora_abertura, hora_fechamento)
                    VALUES (:restaurante_id, :dia, :abertura, :fechamento)";

            $stmt = $this->conn->prepare($sql);

            for ($i = 0; $i < count($dias); $i++) {
                $stmt->execute([
                    ':restaurante_id' => $restauranteId,
                    ':dia' => $dias[$i],
                    ':abertura' => $abertura[$i],
                    ':fechamento' => $fechamento[$i],
                ]);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception("Erro ao salvar horários: " . $e->getMessage());
        }
    }

    public function insertFeatures($restauranteId, $features)
    {
        try {
            $sql = "INSERT INTO restaurant_features (restaurante_id, feature)
                    VALUES (:restaurante_id, :feature)";

            $stmt = $this->conn->prepare($sql);

            foreach ($features as $f) {
                $stmt->execute([
                    ':restaurante_id' => $restauranteId,
                    ':feature' => $f
                ]);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception("Erro ao salvar características: " . $e->getMessage());
        }
    }

    public function metodoDePagamento($restauranteId, $methods)
    {
        try {
            $sql = "INSERT INTO restaurant_payment_methods (restaurante_id, metodo)
                    VALUES (:restaurante_id, :metodo)";

            $stmt = $this->conn->prepare($sql);

            foreach ($methods as $m) {
                $stmt->execute([
                    ':restaurante_id' => $restauranteId,
                    ':metodo' => $m
                ]);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception("Erro ao salvar formas de pagamento: " . $e->getMessage());
        }
    }
}

