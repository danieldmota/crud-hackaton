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

    /**
     * Busca todos os detalhes de um restaurante específico
     */
    public function getDetalhesCompletos(int $restauranteId): ?array
    {
        // Dados básicos
        $sql = "
            SELECT
                r.id,
                r.nome,
                r.categoria,
                r.descricao,
                r.imagem,
                r.capacidade,
                e.rua,
                e.bairro,
                e.cidade,
                e.estado,
                e.cep,
                c.telefone,
                c.email,
                c.website
            FROM restaurantes r
            LEFT JOIN enderecos_restaurantes e ON e.restaurante_id = r.id
            LEFT JOIN contatos_restaurantes c ON c.restaurante_id = r.id
            WHERE r.id = :id
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $restauranteId, PDO::PARAM_INT);
        $stmt->execute();
        $restaurante = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$restaurante) {
            return null;
        }

        // Horários de funcionamento
        $restaurante['horarios'] = $this->getHorarios($restauranteId);

        // Características
        $restaurante['caracteristicas'] = $this->getCaracteristicas($restauranteId);

        // Formas de pagamento
        $restaurante['pagamentos'] = $this->getPagamentos($restauranteId);

        // Cardápio
        $restaurante['cardapio'] = $this->getCardapio($restauranteId);

        // Avaliações
        $restaurante['avaliacoes'] = $this->getAvaliacoes($restauranteId);

        // Calcular rating médio
        $restaurante['rating_medio'] = $this->calcularRatingMedio($restauranteId);

        return $restaurante;
    }

    private function getHorarios(int $restauranteId): array
    {
        $sql = "
            SELECT dia_semana, hora_abertura, hora_fechamento
            FROM horarios_funcionamento
            WHERE restaurante_id = :id AND ativo = 1
            ORDER BY FIELD(dia_semana, 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo')
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $restauranteId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getCaracteristicas(int $restauranteId): array
    {
        $sql = "
            SELECT c.id, c.nome
            FROM caracteristicas c
            INNER JOIN restaurante_caracteristicas rc ON rc.caracteristica_id = c.id
            WHERE rc.restaurante_id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $restauranteId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getPagamentos(int $restauranteId): array
    {
        $sql = "
            SELECT p.id, p.nome
            FROM formas_pagamento p
            INNER JOIN restaurante_pagamentos rp ON rp.pagamento_id = p.id
            WHERE rp.restaurante_id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $restauranteId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getCardapio(int $restauranteId): array
    {
        $sql = "
            SELECT id, categoria, nome, descricao, preco, imagem, disponivel
            FROM cardapio_itens
            WHERE restaurante_id = :id AND disponivel = 1
            ORDER BY categoria, nome
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $restauranteId, PDO::PARAM_INT);
        $stmt->execute();

        $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Agrupar por categoria
        $cardapio = [];
        foreach ($itens as $item) {
            $categoria = $item['categoria'];
            if (!isset($cardapio[$categoria])) {
                $cardapio[$categoria] = [];
            }
            $cardapio[$categoria][] = $item;
        }

        return $cardapio;
    }

    private function getAvaliacoes(int $restauranteId): array
    {
        $sql = "
            SELECT id, nome_cliente, rating, comentario, data_criacao
            FROM avaliacoes
            WHERE restaurante_id = :id
            ORDER BY data_criacao DESC
            LIMIT 10
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $restauranteId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function calcularRatingMedio(int $restauranteId): float
    {
        $sql = "
            SELECT AVG(rating) as media
            FROM avaliacoes
            WHERE restaurante_id = :id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $restauranteId, PDO::PARAM_INT);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado['media'] ? (float) $resultado['media'] : 0;
    }
}