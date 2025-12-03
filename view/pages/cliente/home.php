<?php include_once __DIR__ . '/../../components/header.php'; ?>

<?php
if (!empty($_SESSION['sucesso'])) {
    $msg = $_SESSION['sucesso'];
    echo "<script>
        showNotification(" . json_encode($msg) . ", 'info');
    </script>";
    unset($_SESSION['sucesso']);
}
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
            <!-- Exemplo de restaurantes (será preenchido dinamicamente) -->
            <div class="restaurant-card" data-href="detalhes.php?id=1">
                <div class="restaurant-image"
                    style="background-image: url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                </div>
                <div class="restaurant-info">
                    <h3 class="restaurant-name">La Bella Italia</h3>
                    <p class="restaurant-category">Italiana</p>
                    <p class="restaurant-location">📍 Rua das Flores, 123 - São Paulo, SP</p>
                    <div class="restaurant-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-text">4.8 (234 avaliações)</span>
                    </div>
                    <div class="restaurant-features">
                        <span class="feature-badge">🥗 Vegetariano</span>
                        <span class="feature-badge">🌳 Área Externa</span>
                        <span class="feature-badge">🅿️ Estacionamento</span>
                    </div>
                    <div class="restaurant-actions">
                        <button class="btn btn-primary btn-small"
                            onclick="event.stopPropagation(); makeReservation(1)">Reservar Mesa</button>
                        <button class="btn btn-secondary btn-small" onclick="event.stopPropagation(); viewMenu(1)">Ver
                            Cardápio</button>
                    </div>
                </div>
            </div>

            <div class="restaurant-card" data-href="detalhes.php?id=2">
                <div class="restaurant-image"
                    style="background-image: url('https://images.unsplash.com/photo-1579952363873-27f3bade9f55?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                </div>
                <div class="restaurant-info">
                    <h3 class="restaurant-name">Sushi Master</h3>
                    <p class="restaurant-category">Japonesa</p>
                    <p class="restaurant-location">📍 Av. Paulista, 456 - São Paulo, SP</p>
                    <div class="restaurant-rating">
                        <span class="stars">★★★★☆</span>
                        <span class="rating-text">4.6 (189 avaliações)</span>
                    </div>
                    <div class="restaurant-features">
                        <span class="feature-badge">🌱 Vegano</span>
                        <span class="feature-badge">🚚 Delivery</span>
                        <span class="feature-badge">📶 Wi-Fi</span>
                    </div>
                    <div class="restaurant-actions">
                        <button class="btn btn-primary btn-small"
                            onclick="event.stopPropagation(); makeReservation(2)">Reservar Mesa</button>
                        <button class="btn btn-secondary btn-small" onclick="event.stopPropagation(); viewMenu(2)">Ver
                            Cardápio</button>
                    </div>
                </div>
            </div>

            <div class="restaurant-card" data-href="detalhes.php?id=3">
                <div class="restaurant-image"
                    style="background-image: url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                </div>
                <div class="restaurant-info">
                    <h3 class="restaurant-name">Churrascaria Gaúcha</h3>
                    <p class="restaurant-category">Brasileira</p>
                    <p class="restaurant-location">📍 Rua Augusta, 789 - São Paulo, SP</p>
                    <div class="restaurant-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-text">4.9 (312 avaliações)</span>
                    </div>
                    <div class="restaurant-features">
                        <span class="feature-badge">👨‍👩‍👧‍👦 Família</span>
                        <span class="feature-badge">🎵 Música ao Vivo</span>
                        <span class="feature-badge">🅿️ Estacionamento</span>
                    </div>
                    <div class="restaurant-actions">
                        <button class="btn btn-primary btn-small"
                            onclick="event.stopPropagation(); makeReservation(3)">Reservar Mesa</button>
                        <button class="btn btn-secondary btn-small" onclick="event.stopPropagation(); viewMenu(3)">Ver
                            Cardápio</button>
                    </div>
                </div>
            </div>

            <div class="restaurant-card" data-href="detalhes.php?id=4">
                <div class="restaurant-image"
                    style="background-image: url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');">
                </div>
                <div class="restaurant-info">
                    <h3 class="restaurant-name">Café Parisiense</h3>
                    <p class="restaurant-category">Francesa</p>
                    <p class="restaurant-location">📍 Rua Oscar Freire, 321 - São Paulo, SP</p>
                    <div class="restaurant-rating">
                        <span class="stars">★★★★☆</span>
                        <span class="rating-text">4.7 (156 avaliações)</span>
                    </div>
                    <div class="restaurant-features">
                        <span class="feature-badge">💕 Romântico</span>
                        <span class="feature-badge">🌳 Área Externa</span>
                        <span class="feature-badge">📶 Wi-Fi</span>
                    </div>
                    <div class="restaurant-actions">
                        <button class="btn btn-primary btn-small"
                            onclick="event.stopPropagation(); makeReservation(4)">Reservar Mesa</button>
                        <button class="btn btn-secondary btn-small" onclick="event.stopPropagation(); viewMenu(4)">Ver
                            Cardápio</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>