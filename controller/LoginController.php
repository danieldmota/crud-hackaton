<?php
session_start();
require_once __DIR__ . "/../model/loginModel.php";

try {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Método inválido para esta requisição");
    }

    if (isset($_SESSION['loginBloqueado']) && time() < $_SESSION['loginBloqueado']) {
        $restante = $_SESSION['loginBloqueado'] - time();

        throw new Exception("Muitas tentativas de login.");
    }

    $login = trim($_POST['cnpj'] ?? $_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($login) || empty($senha)) {

        throw new Exception("Preencha todos os campos");
    }

    $loginLimpo = preg_replace('/\D/', '', $login);

    $isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);
    $isCnpj = preg_match('/^\d{14}$/', $loginLimpo);

    if (!$isEmail && !$isCnpj) {
        throw new Exception("Informe um email ou CNPJ válido");
    }

    $loginModel = new LoginModel();

    if ($isCnpj) {
        $usuarioLogin = $loginModel->loginRestaurante($loginLimpo, $senha);
    }

    if ($isEmail) {
        $usuarioLogin = $loginModel->loginUsuario($login, $senha);
    }

    if (!$usuarioLogin) {

        $_SESSION['loginTentativas'] = ($_SESSION['loginTentativas'] ?? 0) + 1;

        if ($_SESSION['loginTentativas'] >= 5) {
            $_SESSION['loginBloqueado'] = time() + 300; // 5 minutos
            $_SESSION['loginTentativas'] = 0;
            throw new Exception("Muitas tentativas de login.");
        }

        throw new Exception("Email ou senha incorretos.");
    } else {

        $_SESSION['id'] = $usuarioLogin->id;
        $_SESSION['loginTentativas'] = 0;
        unset($_SESSION['loginBloqueado']);

        header('Location: ../index.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
    header('Location: ../view/pages/login.php');
    exit();
}
?>