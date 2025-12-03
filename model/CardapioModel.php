<?php

require_once __DIR__ . '/../config/database.php';

class CardapioModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conectar();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function listarPorRestaurante(int $restauranteId): array
    {
        $sql = "SELECT id, restaurante_id, categoria, nome, descricao, preco, imagem, disponivel
                FROM cardapio_itens
                WHERE restaurante_id = :restaurante_id
                ORDER BY categoria, nome";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':restaurante_id', $restauranteId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarPorId(int $id, int $restauranteId): ?array
    {
        $sql = "SELECT * FROM cardapio_itens WHERE id = :id AND restaurante_id = :restaurante_id LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':restaurante_id', $restauranteId, PDO::PARAM_INT);
        $stmt->execute();

        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        return $item ?: null;
    }

    public function criar(array $data): bool
    {
        $sql = "INSERT INTO cardapio_itens
                    (restaurante_id, categoria, nome, descricao, preco, imagem, disponivel)
                VALUES
                    (:restaurante_id, :categoria, :nome, :descricao, :preco, :imagem, :disponivel)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':restaurante_id', $data['restaurante_id'], PDO::PARAM_INT);
        $stmt->bindValue(':categoria', $data['categoria']);
        $stmt->bindValue(':nome', $data['nome']);
        $stmt->bindValue(':descricao', $data['descricao']);
        $stmt->bindValue(':preco', $data['preco']);
        $stmt->bindValue(':imagem', $data['imagem']);
        $stmt->bindValue(':disponivel', $data['disponivel'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function atualizar(int $id, int $restauranteId, array $data): bool
    {
        $setImagem = isset($data['imagem']) ? ", imagem = :imagem" : "";

        $sql = "UPDATE cardapio_itens SET
                    categoria = :categoria,
                    nome = :nome,
                    descricao = :descricao,
                    preco = :preco,
                    disponivel = :disponivel
                    {$setImagem}
                WHERE id = :id AND restaurante_id = :restaurante_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':categoria', $data['categoria']);
        $stmt->bindValue(':nome', $data['nome']);
        $stmt->bindValue(':descricao', $data['descricao']);
        $stmt->bindValue(':preco', $data['preco']);
        $stmt->bindValue(':disponivel', $data['disponivel'], PDO::PARAM_INT);

        if ($setImagem) {
            $stmt->bindValue(':imagem', $data['imagem']);
        }

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':restaurante_id', $restauranteId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function excluir(int $id, int $restauranteId): bool
    {
        $sql = "DELETE FROM cardapio_itens WHERE id = :id AND restaurante_id = :restaurante_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':restaurante_id', $restauranteId, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

