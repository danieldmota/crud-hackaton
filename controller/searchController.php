<?php
// Endpoint para retornar a grade de restaurantes filtrada (HTML parcial)
// Mostrar erros em desenvolvimento para depuração do AJAX
ini_set('display_errors', '1');
error_reporting(E_ALL);
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/../model/RestauranteModel.php';

try {
    $texto = $_GET['q'] ?? '';
    $cidade = $_GET['cidade'] ?? '';
    $caracteristicas = isset($_GET['caracteristicas']) ? (array)$_GET['caracteristicas'] : [];

    $restauranteModel = new RestauranteModel();
    if (!empty($texto) || !empty($cidade) || !empty($caracteristicas)) {
        $restaurantes = $restauranteModel->buscar($texto, $cidade, $caracteristicas);
    } else {
        $restaurantes = $restauranteModel->listarComDetalhes();
    }

    $placeholderImage = 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1200&q=80';

    // Render partial
    $partial = __DIR__ . '/../view/pages/partials/restaurants_grid.php';
    if (file_exists($partial)) {
        include $partial;
    } else {
        // Fallback: gerar HTML simples
        if (empty($restaurantes)) {
            echo '<p style="color: var(--text-secondary); text-align:center; width: 100%;">Nenhum restaurante cadastrado no momento.</p>';
            exit;
        }

        foreach ($restaurantes as $restaurante) {
            $imagem = $restaurante['imagem'] ? htmlspecialchars($restaurante['imagem']) : $placeholderImage;
            $descricaoCurta = $restaurante['descricao'] ? mb_strimwidth($restaurante['descricao'], 0, 120, '...') : 'Descrição não informada ainda.';
            echo '<div class="restaurant-card" data-href="detalhes-publico.php?id=' . $restaurante['id'] . '">';
            echo '<div class="restaurant-image" style="background-image: url(' . $imagem . ');"></div>';
            echo '<div class="restaurant-info">';
            echo '<h3 class="restaurant-name">' . htmlspecialchars($restaurante['nome']) . '</h3>';
            echo '<p class="restaurant-category">' . htmlspecialchars($restaurante['categoria'] ?? 'Categoria não informada') . '</p>';
            echo '<p class="restaurant-location">📍 ' . htmlspecialchars($restaurante['endereco_formatado']) . '</p>';
            echo '<p class="restaurant-description">' . htmlspecialchars($descricaoCurta) . '</p>';
            echo '</div></div>';
        }
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo '<pre style="color: #ff6b35; background: #111; padding: 1rem;">';
    echo htmlspecialchars($e->getMessage() . "\n" . $e->getTraceAsString());
    echo '</pre>';
}
