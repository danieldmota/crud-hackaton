<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (empty($_SESSION['restaurante_id'])) {
    header('Location: ../view/pages/login-restaurante.php');
    exit();
}

$restauranteId = (int) $_SESSION['restaurante_id'];

try {
    $db = new Database();
    $conn = $db->conectar();

    // coletar campos
    $nome = trim($_POST['restaurant_name'] ?? '');
    $categoria = trim($_POST['category'] ?? '');
    $capacidade = (int) ($_POST['capacity'] ?? 0);
    $descricao = trim($_POST['description'] ?? '');

    $rua = trim($_POST['address'] ?? '');
    $bairro = trim($_POST['neighborhood'] ?? '');
    $cidade = trim($_POST['city'] ?? '');
    $estado = trim($_POST['state'] ?? '');
    $cep = trim($_POST['zipcode'] ?? '');

    $telefone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $website = trim($_POST['website'] ?? '');

    // validar campos mínimos
    if ($nome === '' || $categoria === '' || $capacidade <= 0) {
        $_SESSION['flash_error'] = 'Nome, categoria e capacidade são obrigatórios.';
        header('Location: ../view/pages/restaurante/editar-perfil.php');
        exit();
    }

    // tratar upload de imagem
    $imagemPath = null;
    if (!empty($_FILES['restaurant_image']) && $_FILES['restaurant_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['restaurant_image'];
        $allowed = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($file['type'], $allowed)) {
            $_SESSION['flash_error'] = 'Formato de imagem não suportado.';
            header('Location: ../view/pages/restaurante/editar-perfil.php');
            exit();
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            $_SESSION['flash_error'] = 'Imagem muito grande (máx 5MB).';
            header('Location: ../view/pages/restaurante/editar-perfil.php');
            exit();
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $dir = __DIR__ . '/../uploads/restaurante';
        if (!is_dir($dir)) mkdir($dir, 0755, true);
        $filename = 'rest_' . $restauranteId . '_' . time() . '.' . $ext;
        $dest = $dir . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            $_SESSION['flash_error'] = 'Falha ao salvar imagem.';
            header('Location: ../view/pages/restaurante/editar-perfil.php');
            exit();
        }
        // path público relativo ao projeto
        $imagemPath = '/crud-hackaton/uploads/restaurante/' . $filename;
    }

    // começar transação
    $conn->beginTransaction();

    // Atualizar tabela restaurantes
    $updateSql = "UPDATE restaurantes SET nome = :nome, categoria = :categoria, capacidade = :capacidade, descricao = :descricao";
    if ($imagemPath !== null) {
        $updateSql .= ", imagem = :imagem";
    }
    $updateSql .= " WHERE id = :id";

    $stmt = $conn->prepare($updateSql);
    $stmt->bindValue(':nome', $nome);
    $stmt->bindValue(':categoria', $categoria);
    $stmt->bindValue(':capacidade', $capacidade, PDO::PARAM_INT);
    $stmt->bindValue(':descricao', $descricao);
    if ($imagemPath !== null) $stmt->bindValue(':imagem', $imagemPath);
    $stmt->bindValue(':id', $restauranteId, PDO::PARAM_INT);
    $stmt->execute();

    // Endereço
    $stmt = $conn->prepare('SELECT id FROM enderecos_restaurantes WHERE restaurante_id = :rid LIMIT 1');
    $stmt->execute([':rid' => $restauranteId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $stmt = $conn->prepare('UPDATE enderecos_restaurantes SET rua = :rua, bairro = :bairro, cidade = :cidade, estado = :estado, cep = :cep WHERE restaurante_id = :rid');
        $stmt->execute([
            ':rua' => $rua,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':cep' => $cep,
            ':rid' => $restauranteId
        ]);
    } else {
        $stmt = $conn->prepare('INSERT INTO enderecos_restaurantes (restaurante_id, rua, bairro, cidade, estado, cep) VALUES (:rid, :rua, :bairro, :cidade, :estado, :cep)');
        $stmt->execute([
            ':rid' => $restauranteId,
            ':rua' => $rua,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':cep' => $cep
        ]);
    }

    // Contatos
    $stmt = $conn->prepare('SELECT id FROM contatos_restaurantes WHERE restaurante_id = :rid LIMIT 1');
    $stmt->execute([':rid' => $restauranteId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $stmt = $conn->prepare('UPDATE contatos_restaurantes SET telefone = :telefone, email = :email, website = :website WHERE restaurante_id = :rid');
        $stmt->execute([
            ':telefone' => $telefone,
            ':email' => $email,
            ':website' => $website,
            ':rid' => $restauranteId
        ]);
    } else {
        $stmt = $conn->prepare('INSERT INTO contatos_restaurantes (restaurante_id, telefone, email, website) VALUES (:rid, :telefone, :email, :website)');
        $stmt->execute([
            ':rid' => $restauranteId,
            ':telefone' => $telefone,
            ':email' => $email,
            ':website' => $website
        ]);
    }

    $conn->commit();

    $_SESSION['flash_success'] = 'Perfil atualizado com sucesso.';
    header('Location: ../view/pages/restaurante/editar-perfil.php');
    exit();

} catch (Exception $ex) {
    if (isset($conn) && $conn->inTransaction()) $conn->rollBack();
    $_SESSION['flash_error'] = 'Erro ao atualizar perfil: ' . $ex->getMessage();
    header('Location: ../view/pages/restaurante/editar-perfil.php');
    exit();
}
