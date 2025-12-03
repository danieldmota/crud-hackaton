<?php
session_start();
require_once __DIR__ . '/../model/CadastroRestauranteModel.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Requisição inválida.");
    }

    // Campos obrigatórios
    $obrigatorios = [
        'restaurant_name',
        'cnpj',
        'category',
        'capacity',
        'description',
        'address',
        'neighborhood',
        'city',
        'state',
        'zipcode',
        'phone',
        'email',
        'password'
    ];

    foreach ($obrigatorios as $campo) {
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

    // Upload da imagem
    $imagemRestaurante = null;
    if (!empty($_FILES['restaurant_image']['name'])) {

        $file = $_FILES['restaurant_image'];

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array(strtolower($ext), $permitidas)) {
            throw new Exception("Formato de imagem inválido.");
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5 MB

        // Valida tamanho
        if ($file['size'] > $maxSize) {
            throw new Exception("Arquivo muito grande. Máximo permitido: 5MB.");
        }

        // Cria pasta se não existir
        $uploadDir = __DIR__ . '/../uploads/restaurantes/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Gera nome único
        $novoNome = uniqid("rest_", true) . "." . $ext;
        $destino = $uploadDir . $novoNome;

        if (!move_uploaded_file($file['tmp_name'], $destino)) {
            throw new Exception("Erro ao fazer upload da imagem.");
        }

        // Salva o caminho relativo no banco
        $imagemRestaurante = 'uploads/restaurantes/' . $novoNome;
    }

    $dadosRestaurante = [
        'restaurant_name' => $_POST['restaurant_name'],
        'cnpj' => $cnpj,
        'category' => $_POST['category'],
        'capacity' => $_POST['capacity'],
        'description' => $_POST['description'],
        'restaurant_image' => $imagemRestaurante,
        'password' => $_POST['password']
    ];

    $model = new CadastroRestauranteModel();
    $restauranteId = $model->cadastrarRestaurante($dadosRestaurante);

    // Endereço
    $dadosEndereco = [
        'address' => $_POST['address'],
        'neighborhood' => $_POST['neighborhood'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'zipcode' => $_POST['zipcode']
    ];
    $model->cadastrarEndereco($restauranteId, $dadosEndereco);

    // Contato
    $dadosContato = [
        'phone' => $_POST['phone'],
        'email' => $_POST['email'],
        'website' => $_POST['website'] ?? null
    ];
    $model->cadastrarContato($restauranteId, $dadosContato);

    // Horários de funcionamento
    $dias = $_POST['days'] ?? [];
    $abertura = $_POST['opening_time'] ?? [];
    $fechamento = $_POST['closing_time'] ?? [];
    if (!empty($dias)) {
        $model->cadastrarHorarios($restauranteId, $dias, $abertura, $fechamento);
    }

    // Características (IDs)
    $caracteristicas = $_POST['features'] ?? [];
    if (!empty($caracteristicas)) {
        $model->cadastrarCaracteristicas($restauranteId, $caracteristicas);
    }

    // Formas de pagamento (IDs)
    $formasPagamento = $_POST['payment_methods'] ?? [];
    if (!empty($formasPagamento)) {
        $model->cadastrarFormasPagamento($restauranteId, $formasPagamento);
    }

    $_SESSION['sucesso'] = "Restaurante cadastrado com sucesso!";
    header("Location: ../view/pages/restaurante-sucesso.php");
    exit();

} catch (Exception $e) {
    $_SESSION['erro'] = $e->getMessage();
    header("Location: ../view/pages/restaurante-cadastro.php");
    exit();
}
?>