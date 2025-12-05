<?php
class ReservaModel
{
    private $conn;
    private $table = "reservas";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Criar reserva
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (cliente_id, restaurante_id, data_reserva, horario, numero_pessoas, pedidos_especiais) 
                VALUES (:cliente_id, :restaurante_id, :data_reserva, :horario, :numero_pessoas, :pedidos_especiais)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":cliente_id"        => $data['cliente_id'],
            ":restaurante_id"    => $data['restaurante_id'],
            ":data_reserva"      => $data['data_reserva'],
            ":horario"           => $data['horario'],
            ":numero_pessoas"    => $data['numero_pessoas'],
            ":pedidos_especiais" => $data['pedidos_especiais'] ?? null,
        ]);
    }

    // Buscar todas reservas
    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM {$this->table} ORDER BY data_criacao DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar reservas de um cliente específico com informações do restaurante
    public function getByCliente($clienteId)
    {
        $sql = "
            SELECT rsv.*, rest.nome AS restaurante_nome, rest.categoria AS restaurante_categoria,
                   e.rua, e.bairro, e.cidade, e.estado
            FROM {$this->table} rsv
            LEFT JOIN restaurantes rest ON rest.id = rsv.restaurante_id
            LEFT JOIN enderecos_restaurantes e ON e.restaurante_id = rest.id
            WHERE rsv.cliente_id = :cliente_id
            ORDER BY rsv.data_reserva DESC, rsv.horario DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":cliente_id" => $clienteId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Buscar por ID
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([":id" => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar reserva
    public function update($data)
    {
        $sql = "UPDATE {$this->table}
                SET data_reserva = :data_reserva,
                    horario = :horario,
                    numero_pessoas = :numero_pessoas,
                    pedidos_especiais = :pedidos_especiais,
                    status = :status
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ":id"                => $data['id'],
            ":data_reserva"      => $data['data_reserva'],
            ":horario"           => $data['horario'],
            ":numero_pessoas"    => $data['numero_pessoas'],
            ":pedidos_especiais" => $data['pedidos_especiais'] ?? null,
            ":status"            => $data['status'],
        ]);
    }

    // Deletar reserva
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([":id" => $id]);
    }

    // Buscar reservas de um restaurante específico com informações do cliente
    public function getByRestaurante($restauranteId)
    {
        $sql = "
            SELECT rsv.*, cli.nome AS cliente_nome, cli.email AS cliente_email, cli.telefone AS cliente_telefone
            FROM {$this->table} rsv
            LEFT JOIN clientes cli ON cli.id = rsv.cliente_id
            WHERE rsv.restaurante_id = :restaurante_id
            ORDER BY rsv.data_reserva DESC, rsv.horario DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([":restaurante_id" => $restauranteId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
