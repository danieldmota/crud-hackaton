<?php
session_start();
require_once "../config/database.php";
require_once "../model/ReservaModel.php";
require_once __DIR__ . '/../config/auth.php';

// Conexão
$db = new Database();
$conn = $db->conectar();

// Instância do model
$reserva = new ReservaModel($conn);

// Verifica qual ação foi chamada
$action = $_POST['action'] ?? null;

// Criar reserva
if ($action === "create") {

    header("Content-Type: application/json; charset=UTF-8");

    // exigir cliente logado
    if (empty($_SESSION['cliente_id'])) {
        echo json_encode(["success" => false, "error" => "Autenticação necessária", "redirect" => '/crud-hackaton/view/pages/login-cliente.php']);
        exit;
    }

    $data = [
        "cliente_id"        => $_SESSION['cliente_id'],
        "restaurante_id"    => $_POST['restaurant_id'],
        "data_reserva"      => $_POST['date'],
        "horario"           => $_POST['time'],
        "numero_pessoas"    => $_POST['guests'],
        "pedidos_especiais" => $_POST['special_requests'] ?? null,
    ];

    $ok = $reserva->create($data);

    echo json_encode([
        "success" => $ok,
        "message" => $ok ? "Reserva criada com sucesso" : "Erro ao criar reserva"
    ]);

    exit;
}

// Cancelar reserva
if ($action === "delete") {

    // exigir cliente logado
    if (empty($_SESSION['cliente_id'])) {
        header("Location: ../view/pages/login-cliente.php");
        exit;
    }

    $id = $_POST['id'];
    $existing = $reserva->getById($id);
    if (!$existing || $existing['cliente_id'] != $_SESSION['cliente_id']) {
        header("Location: ../view/erro.php?msg=Permissão negada");
        exit;
    }

    if ($reserva->delete($id)) {
        header("Location: ../view/sucesso.php?msg=Reserva deletada");
    } else {
        header("Location: ../view/erro.php?msg=Erro ao deletar");
    }
    exit;
}

header("Location: ../view/erro.php?msg=Ação inválida");
