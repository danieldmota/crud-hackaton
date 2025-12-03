<?php
// Configurar headers para JSON e CORS se necessário
header('Content-Type: application/json; charset=utf-8');

session_start();
require_once __DIR__ . '/../model/ReservaModel.php';

// Tratamento de erros do PHP
error_reporting(E_ALL);
ini_set('display_errors', 0);

try {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Método inválido para esta requisição");
    }

    // Verifica se o usuário está logado
    if (!isset($_SESSION['id'])) {
        throw new Exception("Você precisa estar logado para fazer uma reserva.");
    }

    // Campos obrigatórios
    $required = ['restaurant_id', 'date', 'time', 'guests'];

    foreach ($required as $campo) {
        if (empty($_POST[$campo])) {
            throw new Exception("O campo '{$campo}' é obrigatório.");
        }
        if ($campo === 'restaurant_id' && !is_numeric($_POST[$campo])) {
            throw new Exception("ID do restaurante inválido.");
        }
        if ($campo === 'guests' && (!is_numeric($_POST[$campo]) || $_POST[$campo] < 1)) {
            throw new Exception("Número de pessoas inválido.");
        }
    }

    // Validação de data
    $dataReserva = $_POST['date'];
    $dataAtual = date('Y-m-d');
    
    if ($dataReserva < $dataAtual) {
        throw new Exception("A data da reserva não pode ser no passado.");
    }

    // Validação de horário
    $horario = $_POST['time'];
    if (!preg_match('/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/', $horario)) {
        throw new Exception("Horário inválido.");
    }

    // Preparação dos dados
    $reservaModel = new ReservaModel();

    $data = [
        'cliente_id' => $_SESSION['id'],
        'restaurante_id' => (int)$_POST['restaurant_id'],
        'data_reserva' => $dataReserva,
        'horario' => $horario,
        'numero_pessoas' => (int)$_POST['guests'],
        'pedidos_especiais' => !empty($_POST['special_requests']) ? trim($_POST['special_requests']) : null,
        'status' => 'pendente'
    ];

    // Cria a reserva
    $resultado = $reservaModel->criarReserva($data);

    if (is_array($resultado) && isset($resultado['error'])) {
        throw new Exception($resultado['message']);
    }

    if (!$resultado) {
        throw new Exception("Erro ao realizar a reserva. Tente novamente.");
    }

    // Sucesso
    $_SESSION['sucesso'] = "Reserva realizada com sucesso! Aguarde a confirmação do restaurante.";
    
    // Retorna JSON para requisições AJAX
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode([
            'success' => true,
            'message' => 'Reserva realizada com sucesso!'
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    // Redireciona para a página de reservas do cliente
    header("Location: ../view/pages/cliente/reservas.php");
    exit();

} catch (Exception $e) {
    // Log do erro (opcional, para debug)
    error_log("Erro em ReservaController: " . $e->getMessage());

    // Retorna JSON para requisições AJAX
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }

    $_SESSION['erro'] = $e->getMessage();
    
    // Redireciona de volta para a página de detalhes
    $restaurantId = $_POST['restaurant_id'] ?? 1;
    header("Location: ../view/pages/cliente/detalhes.php?id=" . $restaurantId);
    exit();
} catch (Error $e) {
    // Captura erros fatais do PHP
    error_log("Erro fatal em ReservaController: " . $e->getMessage());
    
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => 'Erro interno do servidor. Tente novamente mais tarde.'
        ], JSON_UNESCAPED_UNICODE);
        exit();
    }
    
    $_SESSION['erro'] = 'Erro interno do servidor. Tente novamente mais tarde.';
    $restaurantId = $_POST['restaurant_id'] ?? 1;
    header("Location: ../view/pages/cliente/detalhes.php?id=" . $restaurantId);
    exit();
}
