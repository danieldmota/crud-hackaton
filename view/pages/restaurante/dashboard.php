<?php include_once __DIR__ . '/../../components/header.php'; ?>

<link rel="stylesheet" href="../../assets/css/style.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Dashboard</h1>
        <p style="font-size: 1.3rem;">Gerencie seu restaurante</p>
    </div>
</section>

<div class="container">
    <div class="dashboard-grid">
        <!-- Estatísticas -->
        <div class="dashboard-section">
            <h3 class="section-title-form">Estatísticas</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value">24</div>
                    <div class="stat-label">Reservas Hoje</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">156</div>
                    <div class="stat-label">Reservas Este Mês</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">4.8</div>
                    <div class="stat-label">Avaliação Média</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">89%</div>
                    <div class="stat-label">Ocupação</div>
                </div>
            </div>
        </div>

        <!-- Reservas Recentes -->
        <div class="dashboard-section">
            <h3 class="section-title-form">Reservas Recentes</h3>
            <div class="reservations-list">
                <div class="reservation-card">
                    <div class="reservation-header">
                        <div>
                            <div class="reservation-restaurant">João Silva</div>
                            <div style="color: var(--text-secondary); font-size: 0.9rem;">2 pessoas</div>
                        </div>
                        <span class="reservation-status status-confirmed">Confirmada</span>
                    </div>
                    <div class="reservation-details">
                        <div class="reservation-detail-item">
                            <span>Hoje às 19:30</span>
                        </div>
                    </div>
                    <div class="reservation-actions">
                        <button class="btn btn-secondary btn-small">Ver Detalhes</button>
                        <button class="btn btn-primary btn-small">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações Rápidas -->
        <div class="dashboard-section">
            <h3 class="section-title-form">Ações Rápidas</h3>
            <div class="quick-actions">
                <a href="editar-perfil.php" class="action-btn">
                    <span class="action-icon">⚙</span>
                    <span>Editar Perfil</span>
                </a>
                <a href="gerenciar-mesa.php" class="action-btn">
                    <span class="action-icon">🪑</span>
                    <span>Gerenciar Mesas</span>
                </a>
                <a href="cardapio.php" class="action-btn">
                    <span class="action-icon">📋</span>
                    <span>Gerenciar Cardápio</span>
                </a>
                <a href="reservas.php" class="action-btn">
                    <span class="action-icon">📅</span>
                    <span>Ver Reservas</span>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>

