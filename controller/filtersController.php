<?php
require_once __DIR__ . '/../model/RestauranteModel.php';

// Configurações de resposta
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '1');
error_reporting(E_ALL);

$cidade = $_GET['cidade'] ?? '';
$restModel = new RestauranteModel();

try {
    if (empty($cidade)) {
        // Retornar todas as características se cidade não informada
        $caracteristicas = $restModel->getCaracteristicasDisponiveis();
    } else {
        $caracteristicas = $restModel->getCaracteristicasPorCidade($cidade);
    }

    echo json_encode(['success' => true, 'caracteristicas' => $caracteristicas], JSON_UNESCAPED_UNICODE);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
