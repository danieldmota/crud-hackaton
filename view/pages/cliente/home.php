<?php include_once __DIR__ . '/../../components/header.php'; ?>
<?php require_once __DIR__ . '/../../../model/RestauranteModel.php'; ?>

<?php
// Página exclusiva para clientes logados
// Se não estiver logado, redireciona para login
if (empty($_SESSION['cliente_id'])) {
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
    header('Location: ../../pages/login-cliente.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

if (!empty($_SESSION['sucesso'])) {
    $msg = $_SESSION['sucesso'];
    echo "<script>
        showNotification(" . json_encode($msg) . ", 'info');
    </script>";
    unset($_SESSION['sucesso']);
}

$restauranteModel = new RestauranteModel();

// Verificar se há busca/filtro
$texto = $_GET['q'] ?? '';
$cidade = $_GET['cidade'] ?? '';
$caracteristicas = isset($_GET['caracteristicas']) ? (array)$_GET['caracteristicas'] : [];

if (!empty($texto) || !empty($cidade) || !empty($caracteristicas)) {
    $restaurantes = $restauranteModel->buscar($texto, $cidade, $caracteristicas);
} else {
    $restaurantes = $restauranteModel->listarComDetalhes();
}

$cidades = $restauranteModel->getCidades();
$caracteristicasDisponiveis = $restauranteModel->getCaracteristicasDisponiveis();
$placeholderImage = 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1200&q=80';
?>

<link rel="stylesheet" href="../../assets/css/style.css">

<section class="hero-section">
    <div class="container">
        <h1>Encontre o Restaurante Perfeito</h1>
        <p>Descubra os melhores restaurantes e reserve sua mesa com facilidade</p>
        <div style="margin-top: 2rem;">
            <button class="btn btn-primary" style="font-size: 1.2rem; padding: 1rem 3rem;"
                onclick="document.getElementById('searchInput').focus()">
                Começar Busca
            </button>
        </div>
    </div>
</section>

<div class="container">
    <div class="search-section">
        <div class="search-bar">
            <form method="GET" id="searchForm" style="display: flex; gap: 0.5rem; width: 100%;">
                <input type="text" id="searchInput" name="q" class="search-input" 
                    placeholder="🔍 Buscar por nome, cidade ou tipo de comida..."
                    value="<?php echo htmlspecialchars($texto); ?>">
                <button id="searchBtn" type="button" class="search-btn">BUSCAR</button>
            </form>
        </div>

        <div class="filters-container">
            <div class="filter-group">
                <label>Filtrar por:</label>
                <div class="filter-options">
                    <form method="GET" id="filterForm" style="display: contents; align-items: center;">
                        <input type="hidden" name="q" value="<?php echo htmlspecialchars($texto); ?>">
                        <select id="cityFilter" name="cidade" class="filter-chip filter-select">
                            <option value="">Todas as cidades</option>
                            <?php foreach ($cidades as $cid): ?>
                                <option value="<?php echo htmlspecialchars($cid); ?>" <?php echo $cidade === $cid ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cid); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button id="distanceFilter" type="button" class="filter-chip" title="Encontrar restaurantes mais próximos">Mais próximo</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="smart-filters">
            <h3>Filtros Inteligentes</h3>
            <div class="smart-filters-grid">
                <?php foreach ($caracteristicasDisponiveis as $carac): ?>
                    <button type="button" class="smart-filter-item<?php echo in_array((string)$carac['id'], array_map('strval', $caracteristicas)) ? ' active' : ''; ?>" data-id="<?php echo (int)$carac['id']; ?>" 
                        style="<?php echo in_array((string)$carac['id'], array_map('strval', $caracteristicas)) ? 'background: var(--primary-neon); color: white;' : ''; ?>">
                        <span><?php echo htmlspecialchars($carac['nome']); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <section class="restaurants-section">
        <h2 class="section-title">Restaurantes Disponíveis</h2>
        <div class="restaurants-grid" id="restaurantsGrid">
            <?php if (empty($restaurantes)): ?>
                <p style="color: var(--text-secondary); text-align:center; width: 100%;">
                    Nenhum restaurante cadastrado no momento.
                </p>
            <?php else: ?>
                <?php foreach ($restaurantes as $restaurante): ?>
                    <?php
                    $imagem = $restaurante['imagem']
                        ? '../../' . htmlspecialchars($restaurante['imagem'])
                        : $placeholderImage;
                    $descricaoCurta = $restaurante['descricao']
                        ? mb_strimwidth($restaurante['descricao'], 0, 120, '...')
                        : 'Descrição não informada ainda.';
                    $caracteristicas = $restaurante['caracteristicas'];
                    ?>
                    <div class="restaurant-card" data-href="detalhes.php?id=<?php echo $restaurante['id']; ?>">
                        <div class="restaurant-image"
                            style="background-image: url('<?php echo $imagem; ?>');">
                        </div>
                        <div class="restaurant-info">
                            <h3 class="restaurant-name"><?php echo htmlspecialchars($restaurante['nome']); ?></h3>
                            <p class="restaurant-category"><?php echo htmlspecialchars($restaurante['categoria'] ?? 'Categoria não informada'); ?></p>
                            <p class="restaurant-location">📍 <?php echo htmlspecialchars($restaurante['endereco_formatado']); ?></p>
                            <p class="restaurant-description"><?php echo htmlspecialchars($descricaoCurta); ?></p>
                            <?php if (!empty($restaurante['rating_count'])): ?>
                                <?php $avg = number_format((float)($restaurante['rating_medio'] ?? 0), 1); $filled = (int) round($restaurante['rating_medio'] ?? 0); ?>
                                <div class="restaurant-rating">
                                    <span class="stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <?php echo $i <= $filled ? '★' : '☆'; ?>
                                        <?php endfor; ?>
                                    </span>
                                    <span class="rating-text"><?php echo $avg; ?> (<?php echo (int)$restaurante['rating_count']; ?>)</span>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($caracteristicas)): ?>
                                <div class="restaurant-features">
                                    <?php foreach (array_slice($caracteristicas, 0, 3) as $feature): ?>
                                        <span class="feature-badge"><?php echo htmlspecialchars($feature); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <div class="restaurant-actions">
                                <button class="btn btn-primary btn-small"
                                    onclick="event.stopPropagation(); makeReservation(<?php echo $restaurante['id']; ?>)">
                                    💼 Reservar Mesa
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>