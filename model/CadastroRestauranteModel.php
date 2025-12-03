<?php

include_once __DIR__ . '/../config/database.php';

class CadastroRestauranteModel
{
    protected $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    // Cadastra o restaurante
    public function cadastrarRestaurante($dados)
    {
        try {
            $sql = "INSERT INTO restaurantes (
                        nome, cnpj, categoria, capacidade, descricao, imagem, senha
                    ) VALUES (
                        :nome, :cnpj, :categoria, :capacidade, :descricao, :imagem, :senha
                    )";

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':nome' => $dados['restaurant_name'],
                ':cnpj' => $dados['cnpj'],
                ':categoria' => $dados['category'],
                ':capacidade' => $dados['capacity'],
                ':descricao' => $dados['description'],
                ':imagem' => $dados['restaurant_image'] ?? null,
                ':senha' => password_hash($dados['password'], PASSWORD_BCRYPT)
            ]);

            return $this->conn->lastInsertId();

        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar restaurante: " . $e->getMessage());
        }
    }

    // Cadastra endereço do restaurante
    public function cadastrarEndereco($restauranteId, $dados)
    {
        try {
            $sql = "INSERT INTO enderecos_restaurantes (
                        restaurante_id, rua, bairro, cidade, estado, cep
                    ) VALUES (
                        :restaurante_id, :rua, :bairro, :cidade, :estado, :cep
                    )";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':restaurante_id' => $restauranteId,
                ':rua' => $dados['address'],
                ':bairro' => $dados['neighborhood'],
                ':cidade' => $dados['city'],
                ':estado' => $dados['state'],
                ':cep' => $dados['zipcode']
            ]);

            return true;

        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar endereço: " . $e->getMessage());
        }
    }

    // Cadastra contato do restaurante
    public function cadastrarContato($restauranteId, $dados)
    {
        try {
            $sql = "INSERT INTO contatos_restaurantes (
                        restaurante_id, telefone, email, website
                    ) VALUES (
                        :restaurante_id, :telefone, :email, :website
                    )";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':restaurante_id' => $restauranteId,
                ':telefone' => $dados['phone'],
                ':email' => $dados['email'],
                ':website' => $dados['website'] ?? null
            ]);

            return true;

        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar contato: " . $e->getMessage());
        }
    }

    // Cadastra horários de funcionamento
    public function cadastrarHorarios($restauranteId, $dias, $abertura, $fechamento)
    {
        try {
            $sql = "INSERT INTO horarios_funcionamento (
                        restaurante_id, dia_semana, hora_abertura, hora_fechamento, ativo
                    ) VALUES (
                        :restaurante_id, :dia, :abertura, :fechamento, :ativo
                    )";

            $stmt = $this->conn->prepare($sql);

            for ($i = 0; $i < count($dias); $i++) {
                $stmt->execute([
                    ':restaurante_id' => $restauranteId,
                    ':dia' => $dias[$i],
                    ':abertura' => $abertura[$i],
                    ':fechamento' => $fechamento[$i],
                    ':ativo' => 1
                ]);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar horários: " . $e->getMessage());
        }
    }
    // Cadastra características do restaurante
    public function cadastrarCaracteristicas($restauranteId, $caracteristicas)
    {
        try {
            $sql = "INSERT INTO restaurante_caracteristicas (
                        restaurante_id, caracteristica_id
                    ) VALUES (
                        :restaurante_id, :caracteristica_id
                    )";

            $stmt = $this->conn->prepare($sql);

            foreach ($caracteristicas as $c) {
                $stmt->execute([
                    ':restaurante_id' => $restauranteId,
                    ':caracteristica_id' => $c
                ]);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar características: " . $e->getMessage());
        }
    }
    // Cadastra formas de pagamento
    public function cadastrarFormasPagamento($restauranteId, $formas)
    {
        try {
            $sql = "INSERT INTO restaurante_pagamentos (
                        restaurante_id, pagamento_id
                    ) VALUES (
                        :restaurante_id, :pagamento_id
                    )";

            $stmt = $this->conn->prepare($sql);

            foreach ($formas as $f) {
                $stmt->execute([
                    ':restaurante_id' => $restauranteId,
                    ':pagamento_id' => $f
                ]);
            }

            return true;

        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar formas de pagamento: " . $e->getMessage());
        }
    }

    // Pega todas as formas de pagamento
    public function listarFormasPagamento()
    {
        $sql = "SELECT * FROM formas_pagamento ORDER BY nome ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pega todas as características
    public function listarCaracteristicas()
    {
        $sql = "SELECT * FROM caracteristicas ORDER BY nome ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pega todos os estados
    public function listarEstados()
    {
        $sql = "SELECT * FROM estados ORDER BY nome ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Pega os pagamentos já cadastrados de um restaurante
    public function pagamentosDoRestaurante($restauranteId)
    {
        $sql = "SELECT pagamento_id FROM restaurante_pagamentos WHERE restaurante_id = :restaurante_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':restaurante_id' => $restauranteId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    // Pega as características já cadastradas de um restaurante
    public function caracteristicasDoRestaurante($restauranteId)
    {
        $sql = "SELECT caracteristica_id FROM restaurante_caracteristicas WHERE restaurante_id = :restaurante_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':restaurante_id' => $restauranteId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
