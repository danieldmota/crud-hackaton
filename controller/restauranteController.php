<?php
session_start();
require_once __DIR__ . '/../model/restauranteModel.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Requisição inválida.");
    }

    $required = [
        'restaurante_nome',
        'cnpj',
        'categoria',
        'capacidade',
        'descricao',
        'rua',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'telefone',
        'email',
        'website',
        'password'
    ];

    foreach ($required as $campo) {
        if (empty($_POST[$campo])) {
            throw new Exception("O campo '{$campo}' é obrigatório.");
        }
    }

    // CNPJ — remove caracteres não numéricos
    $cnpj = preg_replace('/\D/', '', $_POST['cnpj']);
    if (strlen($cnpj) !== 14) {
        throw new Exception("CNPJ inválido.");
    }

    // Email
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Email inválido.");
    }

    // Upload da imagem do restaurante
    $restaurantImage = null;

    if (!empty($_FILES['restaurante_imagem']['name'])) {

        $ext = pathinfo($_FILES['restaurante_imagem']['name'], PATHINFO_EXTENSION);
        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array(strtolower($ext), $permitidas)) {
            throw new Exception("Formato de imagem inválido.");
        }

        $novoNome = uniqid("rest_", true) . "." . $ext;
        $destino = __DIR__ . '/../uploads/' . $novoNome;

        if (!move_uploaded_file($_FILES['restaurante_imagem']['tmp_name'], $destino)) {
            throw new Exception("Erro ao fazer upload da imagem.");
        }

        $restaurantImage = $novoNome;
    }

    $data = [
        'restaurante_nome' => $_POST['restaurante_nome'],
        'cnpj' => $cnpj,
        'categoria' => $_POST['categoria'],
        'capacidade' => $_POST['capacidade'],
        'descricao' => $_POST['descricao'],
        'restaurante_imagem' => $restaurantImage,
        'rua' => $_POST['rua'],
        'bairro' => $_POST['bairro'],
        'cidade' => $_POST['cidade'],
        'estado' => $_POST['estado'],
        'cep' => $_POST['cep'],
        'telefone' => $_POST['telefone'],
        'email' => $_POST['email'],
        'website' => $_POST['website'],
        'password' => $_POST['password']
    ];

    $model = new RestaurantModel();

    $restauranteId = $model->createRestaurant($data);

    // Horários
    if (!empty($_POST['dias']) && !empty($_POST['abertura']) && !empty($_POST['fechamento'])) {
        $model->insertSchedule(
            $restauranteId,
            $_POST['dias'],
            $_POST['abertura'],
            $_POST['fechamento']
        );
    }

    // Características
    if (!empty($_POST['features'])) {
        $model->insertFeatures($restauranteId, $_POST['features']);
    }

    // Métodos de pagamento
    if (!empty($_POST['payment_methods'])) {
        $model->metodoDePagamento($restauranteId, $_POST['payment_methods']);
    }

    $_SESSION['sucesso'] = "Restaurante cadastrado com sucesso!";
    header("Location: ../view/pages/restaurante-sucesso.php");
    exit();

} catch (Exception $e) {

    $_SESSION['erro'] = $e->getMessage();
    header("Location: ../view/pages/restaurante-cadastro.php");
    exit();
}
