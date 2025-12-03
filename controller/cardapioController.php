<?php

session_start();

header('Content-Type: application/json; charset=UTF-8');

require_once __DIR__ . '/../model/CardapioModel.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['success' => false, 'error' => 'Método não permitido']);
        exit;
    }

    $restauranteId = isset($_SESSION['id'])
        ? (int) $_SESSION['id']
        : (int) ($_POST['restaurante_id'] ?? 0);

    if ($restauranteId <= 0) {
        throw new Exception('Informe o restaurante que deseja gerenciar.');
    }
    $acao = $_POST['action'] ?? '';

    if (!$acao) {
        throw new Exception('Ação não informada.');
    }

    $model = new CardapioModel();

    switch ($acao) {
        case 'create':
            $payload = validarDadosBasicos($_POST);
            $payload['restaurante_id'] = $restauranteId;
            $payload['imagem'] = salvarImagem($_FILES['item_image'] ?? null);

            $model->criar($payload);
            responderSucesso('Item adicionado com sucesso!');
            break;

        case 'update':
            $itemId = (int) ($_POST['item_id'] ?? 0);
            if ($itemId <= 0) {
                throw new Exception('ID do item inválido.');
            }

            $itemAtual = $model->buscarPorId($itemId, $restauranteId);
            if (!$itemAtual) {
                throw new Exception('Item não encontrado.');
            }

            $payload = validarDadosBasicos($_POST);
            $novaImagem = salvarImagem($_FILES['item_image'] ?? null);

            if ($novaImagem) {
                $payload['imagem'] = $novaImagem;
                removerImagemAntiga($itemAtual['imagem'] ?? null);
            }

            $model->atualizar($itemId, $restauranteId, $payload);
            responderSucesso('Item atualizado com sucesso!');
            break;

        case 'delete':
            $itemId = (int) ($_POST['item_id'] ?? 0);
            if ($itemId <= 0) {
                throw new Exception('ID do item inválido.');
            }

            $itemAtual = $model->buscarPorId($itemId, $restauranteId);
            if (!$itemAtual) {
                throw new Exception('Item não encontrado.');
            }

            $model->excluir($itemId, $restauranteId);
            removerImagemAntiga($itemAtual['imagem'] ?? null);

            responderSucesso('Item removido com sucesso!');
            break;

        default:
            throw new Exception('Ação desconhecida.');
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

function validarDadosBasicos(array $dados): array
{
    $nome = trim($dados['item_name'] ?? '');
    $descricao = trim($dados['description'] ?? '');
    $preco = $dados['price'] ?? '';
    $categoria = $dados['category_select'] ?? '';
    $disponivel = isset($dados['available']) ? 1 : 0;

    if ($nome === '' || $descricao === '' || $preco === '' || $categoria === '') {
        throw new Exception('Preencha todos os campos obrigatórios.');
    }

    if (!is_numeric($preco) || $preco < 0) {
        throw new Exception('Preço inválido.');
    }

    $categoriasValidas = ['pratos', 'bebidas', 'sobremesas'];
    if (!in_array($categoria, $categoriasValidas, true)) {
        throw new Exception('Categoria inválida.');
    }

    return [
        'nome' => $nome,
        'descricao' => $descricao,
        'preco' => number_format((float) $preco, 2, '.', ''),
        'categoria' => $categoria,
        'disponivel' => $disponivel,
        'imagem' => null
    ];
}

function salvarImagem(?array $arquivo): ?string
{
    if (!$arquivo || $arquivo['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if ($arquivo['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Erro ao enviar a imagem.');
    }

    if ($arquivo['size'] > 5 * 1024 * 1024) {
        throw new Exception('A imagem deve ter no máximo 5MB.');
    }

    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'webp'];

    if (!in_array($extensao, $permitidos, true)) {
        throw new Exception('Formato de imagem inválido.');
    }

    $pasta = __DIR__ . '/../uploads/cardapio/';
    if (!is_dir($pasta)) {
        mkdir($pasta, 0777, true);
    }

    $novoNome = uniqid('cardapio_', true) . '.' . $extensao;
    $destino = $pasta . $novoNome;

    if (!move_uploaded_file($arquivo['tmp_name'], $destino)) {
        throw new Exception('Não foi possível salvar a imagem.');
    }

    return 'uploads/cardapio/' . $novoNome;
}

function removerImagemAntiga(?string $caminho): void
{
    if (!$caminho) {
        return;
    }

    $arquivo = __DIR__ . '/../' . $caminho;
    if (is_file($arquivo)) {
        @unlink($arquivo);
    }
}

function responderSucesso(string $mensagem): void
{
    echo json_encode([
        'success' => true,
        'message' => $mensagem
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

