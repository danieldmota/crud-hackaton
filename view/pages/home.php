<?php include_once __DIR__ . '/../components/header.php'; ?>
<?php require_once __DIR__ . '/../../model/RestauranteModel.php'; ?>

<?php
$restauranteModel = new RestauranteModel();
$restaurantes = $restauranteModel->listarComDetalhes();
$placeholderImage = 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1200&q=80';
?>

<link rel="stylesheet" href="../assets/css/style.css">

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
            <input type="text" id="searchInput" class="search-input"
                placeholder="🔍 Buscar por nome, cidade ou tipo de comida...">
            <button id="searchBtn" class="search-btn">
                BUSCAR
            </button>
        </div>

        <div class="filters-container">
            <div class="filter-group">
                <label>Filtrar por:</label>
                <div class="filter-options">
                    <div class="filter-chip" data-filter="name">Nome</div>
                    <div class="filter-chip" data-filter="city">Cidade</div>
                    <div class="filter-chip" data-filter="nearest">Mais Próximo</div>
                </div>
            </div>


        </div>

        <div class="smart-filters">
            <h3>Filtros Inteligentes</h3>
            <div class="smart-filters-grid">
                <div class="smart-filter-item" data-filter="vegetarian">
                    <span>Vegetariano</span>
                </div>
                <div class="smart-filter-item" data-filter="vegan">
                    <span>Vegano</span>
                </div>
                <div class="smart-filter-item" data-filter="gluten-free">
                    <span>Sem Glúten</span>
                </div>
                <div class="smart-filter-item" data-filter="spicy">
                    <span>Picante</span>
                </div>
                <div class="smart-filter-item" data-filter="romantic">
                    <span>Romântico</span>
                </div>
                <div class="smart-filter-item" data-filter="family-friendly">
                    <span>Família</span>
                </div>
                <div class="smart-filter-item" data-filter="pet-friendly">
                    <span>Pet Friendly</span>
                </div>
                <div class="smart-filter-item" data-filter="outdoor">
                    <span>Área Externa</span>
                </div>
                <div class="smart-filter-item" data-filter="live-music">
                    <span>Música ao Vivo</span>
                </div>
                <div class="smart-filter-item" data-filter="parking">
                    <span>Estacionamento</span>
                </div>
                <div class="smart-filter-item" data-filter="wifi">
                    <span>Wi-Fi Grátis</span>
                </div>
                <div class="smart-filter-item" data-filter="delivery">
                    <span>Delivery</span>
                </div>
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
                        ? htmlspecialchars($restaurante['imagem'])
                        : $placeholderImage;
                    $descricaoCurta = $restaurante['descricao']
                        ? mb_strimwidth($restaurante['descricao'], 0, 120, '...')
                        : 'Descrição não informada ainda.';
                    $caracteristicas = $restaurante['caracteristicas'];
                    $rating = 4.5; // Placeholder
                    ?>
                    <div class="restaurant-card" data-href="detalhes-publico.php?id=<?php echo $restaurante['id']; ?>">
                        <div class="restaurant-image"
                            style="background-image: url('<?php echo $imagem; ?>');">
                        </div>
                        <div class="restaurant-info">
                            <h3 class="restaurant-name"><?php echo htmlspecialchars($restaurante['nome']); ?></h3>
                            <p class="restaurant-category"><?php echo htmlspecialchars($restaurante['categoria'] ?? 'Categoria não informada'); ?></p>
                            <p class="restaurant-location">📍 <?php echo htmlspecialchars($restaurante['endereco_formatado']); ?></p>
                            <p class="restaurant-description"><?php echo htmlspecialchars($descricaoCurta); ?></p>
                            <div class="restaurant-rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-text">Avaliações disponíveis</span>
                            </div>
                            <?php if (!empty($caracteristicas)): ?>
                                <div class="restaurant-features">
                                    <?php foreach (array_slice($caracteristicas, 0, 3) as $feature): ?>
                                        <span class="feature-badge"><?php echo htmlspecialchars($feature); ?></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            <div class="restaurant-actions">
                                <a href="detalhes-publico.php?id=<?php echo $restaurante['id']; ?>" class="btn btn-secondary btn-small">
                                    Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script src="../assets/js/main.js"></script>