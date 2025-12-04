<?php
// Helper de autenticação simples
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requireCliente()
{
    if (empty($_SESSION['cliente_id'])) {
        $current = $_SERVER['REQUEST_URI'] ?? '/crud-hackaton/';
        $loginUrl = '/crud-hackaton/view/pages/login-cliente.php?redirect=' . urlencode($current);
        header('Location: ' . $loginUrl);
        exit();
    }
}

function requireRestaurante()
{
    if (empty($_SESSION['restaurante_id'])) {
        $current = $_SERVER['REQUEST_URI'] ?? '/crud-hackaton/';
        $loginUrl = '/crud-hackaton/view/pages/login-restaurante.php?redirect=' . urlencode($current);
        header('Location: ' . $loginUrl);
        exit();
    }
}

function logoutAndRedirect($target = '/crud-hackaton/')
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Limpar session
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    header('Location: ' . $target);
    exit();
}
