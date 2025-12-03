<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

class RestauranteModel
{
    private PDO $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conectar();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Retorna todos os restaurantes com informações básicas prontas para exibição.
     */
    public function listarComDetalhes(): array
    {
        $sql = "
            SELECT
                r.id,
                r.nome,
                r.categoria,
                r.descricao,
                r.imagem,
                e.rua,
                e.bairro,
                e.cidade,
                e.estado,
                e.cep,
                c.telefone,
                c.email,
                GROUP_CONCAT(DISTINCT car.nome ORDER BY car.nome SEPARATOR ',') AS caracteristicas
            FROM restaurantes r
            LEFT JOIN enderecos_restaurantes e ON e.restaurante_id = r.id
            LEFT JOIN contatos_restaurantes c ON c.restaurante_id = r.id
            LEFT JOIN restaurante_caracteristicas rc ON rc.restaurante_id = r.id
            LEFT JOIN caracteristicas car ON car.id = rc.caracteristica_id
            GROUP BY r.id, r.nome, r.categoria, r.imagem, e.rua, e.bairro, e.cidade, e.estado, e.cep, c.telefone, c.email
            ORDER BY r.nome ASC
        ";

        $stmt = $this->conn->query($sql);
        $restaurantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function (array $restaurante) {
            $restaurante['caracteristicas'] = $this->normalizarCaracteristicas($restaurante['caracteristicas'] ?? '');
            $restaurante['imagem'] = $restaurante['imagem'] ?: null;
            $restaurante['endereco_formatado'] = $this->formatarEndereco($restaurante);

            return $restaurante;
        }, $restaurantes);
    }

    private function normalizarCaracteristicas(string $lista): array
    {
        if ($lista === '') {
            return [];
        }

        $items = array_filter(array_map('trim', explode(',', $lista)));

        return array_values($items);
    }

    private function formatarEndereco(array $dados): string
    {
        $partes = array_filter([
            $dados['rua'] ?? null,
            $dados['bairro'] ?? null,
            $dados['cidade'] ?? null ? ($dados['cidade'] . (isset($dados['estado']) ? ', ' . $dados['estado'] : '')) : null
        ]);

        return $partes ? implode(' - ', $partes) : 'Endereço não informado';
    }
}

