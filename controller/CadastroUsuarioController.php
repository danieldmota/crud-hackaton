<?php
session_start();
require_once __DIR__ . '/../model/CadastroUsuarioModel.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método inválido para esta requisição.");
    }

    // Campos obrigatórios
    $required = ['nome', 'cpf', 'telefone', 'email', 'senha', 'confirm_senha'];

    foreach ($required as $campo) {
        if (empty($_POST[$campo])) {
            throw new Exception("O campo '{$campo}' é obrigatório.");
        }
    }

    // Verificar senhas
    if ($_POST['senha'] !== $_POST['confirm_senha']) {
        throw new Exception("As senhas não coincidem.");
    }

    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
    $telefone = preg_replace('/[^0-9]/', '', $_POST['telefone']);


    $cadastroUsuarioModel = new CadastroUsuarioModel();

    // Verificar CPF
    if ($cadastroUsuarioModel->checkCpfExists($cpf)) {
        throw new Exception("O CPF informado já está cadastrado.");
    }

    // Verificar email
    if ($cadastroUsuarioModel->checkEmailExists($_POST['email'])) {
        throw new Exception("O e-mail informado já está cadastrado.");
    }

    // Upload da foto
    // $fotoPerfil = null;

    // if (!empty($_FILES['restaurant_image']['name'])) {

    //     $file = $_FILES['restaurant_image'];
    //     $allowedTypes = ['image/jpeg', 'image/png'];
    //     $maxSize = 5 * 1024 * 1024;

    //     if ($file['size'] > $maxSize) {
    //         throw new Exception("A foto excede o tamanho máximo de 5MB.");
    //     }

    //     if (!in_array($file['type'], $allowedTypes)) {
    //         throw new Exception("Formato de imagem inválido. Envie JPG ou PNG.");
    //     }

    //     $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    //     $newName = uniqid("cliente_") . "." . $ext;

    //     $uploadDir = __DIR__ . '/../uploads/clientes/';

    //     if (!is_dir($uploadDir)) {
    //         mkdir($uploadDir, 0777, true);
    //     }

    //     $caminhoFinal = $uploadDir . $newName;

    //     if (!move_uploaded_file($file['tmp_name'], $caminhoFinal)) {
    //         throw new Exception("Erro ao enviar a imagem.");
    //     }

    //     $fotoPerfil = "uploads/clientes/" . $newName;
    // }

    // Montagem dos dados
    $data = [
        'nome' => trim($_POST['nome']),
        'cpf' => trim($cpf),
        'telefone' => trim($telefone),
        'email' => trim($_POST['email']),
        'senha' => $_POST['senha'],
        // 'foto_perfil' => $fotoPerfil
    ];

    // Cadastro
    $register = $cadastroUsuarioModel->Cadastro($data);

    if (!$register) {
        throw new Exception("Erro ao realizar o cadastro. Tente novamente.");
    }

    // Sucesso
    $_SESSION['sucesso'] = "Cadastro realizado com sucesso! Você já pode fazer login.";
    header("Location: ../view/pages/login-cliente.php");
    exit();

} catch (Exception $e) {

    $_SESSION['erro'] = $e->getMessage();
    header("Location: ../view/pages/cadastro-cliente.php");
    exit();
}
