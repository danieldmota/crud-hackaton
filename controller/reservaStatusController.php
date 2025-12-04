<?php
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/ReservaModel.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método inválido");
    }

    $action = $_POST['action'] ?? '';
    $reserva_id = (int)($_POST['reserva_id'] ?? 0);
    $status = $_POST['status'] ?? '';

    if (empty($reserva_id) || empty($action)) {
        throw new Exception("Parâmetros inválidos");
    }

    // Verificar se é restaurante logado
    if (empty($_SESSION['restaurante_id'])) {
        throw new Exception("Acesso negado: restaurante não autenticado");
    }

    $db = new Database();
    $conn = $db->conectar();
    $reservaModel = new ReservaModel($conn);

    // Buscar a reserva
    $reserva = $reservaModel->getById($reserva_id);
    if (!$reserva) {
        throw new Exception("Reserva não encontrada");
    }

    // Verificar se a reserva pertence ao restaurante logado
    if ($reserva['restaurante_id'] != $_SESSION['restaurante_id']) {
        throw new Exception("Acesso negado: reserva não pertence a este restaurante");
    }

    // Processar ação
    if ($action === 'confirm') {
        $reserva['status'] = 'confirmada';
        $reservaModel->update($reserva);
        
        echo json_encode([
            'success' => true,
            'message' => 'Reserva confirmada com sucesso!',
            'status' => 'confirmada'
        ]);
    } elseif ($action === 'cancel') {
        $reserva['status'] = 'cancelada';
        $reservaModel->update($reserva);
        
        echo json_encode([
            'success' => true,
            'message' => 'Reserva cancelada com sucesso!',
            'status' => 'cancelada'
        ]);
    } else {
        throw new Exception("Ação inválida");
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>
