<?php

require_once __DIR__ . '/../config/database.php';

class ReservaModel
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->conectar();
        // Configurar PDO para lançar exceções
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Cria uma nova reserva no banco de dados
     * @param array $data Dados da reserva
     * @return bool|array Retorna true em caso de sucesso ou array com erro
     */
    public function criarReserva($data)
    {
        try {
            $sql = "INSERT INTO reservas (
                        cliente_id,
                        restaurante_id,
                        data_reserva,
                        horario,
                        numero_pessoas,
                        pedidos_especiais,
                        status
                    ) VALUES (
                        :cliente_id,
                        :restaurante_id,
                        :data_reserva,
                        :horario,
                        :numero_pessoas,
                        :pedidos_especiais,
                        :status
                    )";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':cliente_id', $data['cliente_id']);
            $stmt->bindParam(':restaurante_id', $data['restaurante_id']);
            $stmt->bindParam(':data_reserva', $data['data_reserva']);
            $stmt->bindParam(':horario', $data['horario']);
            $stmt->bindParam(':numero_pessoas', $data['numero_pessoas']);
            $stmt->bindParam(':pedidos_especiais', $data['pedidos_especiais']);
            $stmt->bindParam(':status', $data['status']);

            return $stmt->execute();
        } catch (PDOException $e) {
            return [
                'error' => true,
                'message' => 'Erro ao criar reserva: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Busca reservas de um cliente
     * @param int $clienteId ID do cliente
     * @return array Lista de reservas
     */
    public function buscarReservasPorCliente($clienteId)
    {
        try {
            $sql = "SELECT r.*, rest.nome_empresa 
                    FROM reservas r
                    INNER JOIN restaurantes rest ON r.restaurante_id = rest.id_rest
                    WHERE r.cliente_id = :cliente_id
                    ORDER BY r.data_reserva DESC, r.horario DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':cliente_id', $clienteId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    /**
     * Busca reservas de um restaurante
     * @param int $restauranteId ID do restaurante
     * @return array Lista de reservas
     */
    public function buscarReservasPorRestaurante($restauranteId)
    {
        try {
            $sql = "SELECT r.*, c.nome as nome_cliente, c.telefone, c.email
                    FROM reservas r
                    INNER JOIN clientes c ON r.cliente_id = c.id
                    WHERE r.restaurante_id = :restaurante_id
                    ORDER BY r.data_reserva DESC, r.horario DESC";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':restaurante_id', $restauranteId);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }
}
