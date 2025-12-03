<?php
declare(strict_types=1);

require_once __DIR__ . '/../model/Reservation.php';

class ReservaController
{
    public function __construct()
    {
        Reservation::connect(); // conecta ao MySQL
    }

    /**
     * Recebe os dados do formulário e salva no banco
     */
    public function store(): void
    {
        // Verifica método HTTP
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(["error" => "Método não permitido"]);
            exit;
        }

        // Sanitização
        $restaurantId = (int)($_POST['restaurant_id'] ?? 0);
        $date = $_POST['date'] ?? null;
        $time = $_POST['time'] ?? null;
        $guests = (int)($_POST['guests'] ?? 0);
        $special = trim($_POST['special_requests'] ?? '');

        if (!$restaurantId || !$date || !$time || !$guests) {
            http_response_code(400);
            echo json_encode(["error" => "Dados incompletos"]);
            exit;
        }

        // Criando objeto Reservation
        $reservation = new Reservation(
            $restaurantId,
            new DateTime($date),
            new DateTime($time),
            $guests,
            $special !== "" ? $special : null
        );

        // Salva no banco
        $reservation->save();

        echo json_encode([
            "success" => true,
            "message" => "Reserva criada com sucesso!"
        ]);
    }
}
