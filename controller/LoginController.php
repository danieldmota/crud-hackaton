<?php
session_start();
require_once __DIR__ . "/../model/LoginModel.php";

try {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Método inválido para esta requisição");
    }

    // Recebe o tipo de login (cliente ou restaurante)
    $tipo = $_POST['tipo'] ?? '';

    if (empty($tipo)) {
        throw new Exception("Tipo de login inválido.");
    }

    // Controle de bloqueio por tentativas
    if (isset($_SESSION['loginBloqueado']) && time() < $_SESSION['loginBloqueado']) {
        throw new Exception("Muitas tentativas de login.");
    }

    // Credenciais
    $login = trim($_POST['login'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($login) || empty($senha)) {
        throw new Exception("Preencha todos os campos");
    }

    // Remove máscara (de CNPJ/CPF/telefone, se vier com)
    $loginLimpo = preg_replace('/\D/', '', $login);

    $loginModel = new LoginModel();
    $usuarioLogin = null;

    if ($tipo === 'cliente') {

        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("E-mail inválido.");
        }

        $usuarioLogin = $loginModel->loginUsuario($login, $senha);

        if (!$usuarioLogin) {
            throw new Exception("E-mail ou senha incorretos.");
        }

        // Login bem sucedido → setar sessões e redirecionar cliente
        $_SESSION['id'] = $usuarioLogin->id; // compatibilidade legada
        $_SESSION['cliente_id'] = $usuarioLogin->id;
        $_SESSION['cliente_nome'] = $usuarioLogin->nome ?? '';
        $_SESSION['user_type'] = 'cliente';
        $_SESSION['loginTentativas'] = 0;
        $_SESSION['sucesso'] = "Login realizado com sucesso!";
        unset($_SESSION['loginBloqueado']);

        // Redirecionar para a URL de retorno se fornecida
        $redirect = $_POST['redirect'] ?? '';
        if (!empty($redirect)) {
            header('Location: ' . $redirect);
        } else {
            header('Location: ../view/pages/cliente/home.php');
        }
        exit();
    }

    if ($tipo === 'restaurante') {

        if (!preg_match('/^\d{14}$/', $loginLimpo)) {
            throw new Exception("CNPJ inválido.");
        }

        $usuarioLogin = $loginModel->loginRestaurante($loginLimpo, $senha);

        if (!$usuarioLogin) {
            throw new Exception("CNPJ ou senha incorretos.");
        }

        // Login bem sucedido → setar sessões e redirecionar restaurante
        $_SESSION['id'] = $usuarioLogin->id; // compatibilidade legada
        $_SESSION['restaurante_id'] = $usuarioLogin->id;
        $_SESSION['restaurante_nome'] = $usuarioLogin->nome ?? '';
        $_SESSION['user_type'] = 'restaurante';
        $_SESSION['loginTentativas'] = 0;
        $_SESSION['sucesso'] = "Login realizado com sucesso!";
        unset($_SESSION['loginBloqueado']);

        $redirect = $_POST['redirect'] ?? '';
        if (!empty($redirect)) {
            header('Location: ' . $redirect);
        } else {
            header('Location: ../view/pages/restaurante/dashboard.php');
        }
        exit();
    }

    // Se tipo for inválido
    throw new Exception("Tipo de login desconhecido.");

} catch (Exception $e) {

    // Registra tentativa para bloqueio
    $_SESSION['loginTentativas'] = ($_SESSION['loginTentativas'] ?? 0) + 1;

    if ($_SESSION['loginTentativas'] >= 5) {
        $_SESSION['loginBloqueado'] = time() + 300; // 5 minutos
        $_SESSION['loginTentativas'] = 0;
    }

    $_SESSION['erro'] = $e->getMessage();

    // Redireciona conforme o tipo
    if (($_POST['tipo'] ?? '') === 'restaurante') {
        header('Location: ../view/pages/login-restaurante.php');
    } else {
        header('Location: ../view/pages/login-cliente.php');
    }

    exit();
}
?>