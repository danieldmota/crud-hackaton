<?php include_once __DIR__ . '/../../components/header.php'; ?>

<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../model/ReservaModel.php';
require_once __DIR__ . '/../../../model/RestauranteModel.php';

// Verifica autenticação do restaurante
if (empty($_SESSION['restaurante_id'])) {
    header('Location: ../../pages/login-restaurante.php');
    exit();
}

$restauranteId = (int) $_SESSION['restaurante_id'];

$db = new Database();
$conn = $db->conectar();
$reservaModel = new ReservaModel($conn);
$restauranteModel = new RestauranteModel();

$reservas = $reservaModel->getByRestaurante($restauranteId);
$detalhes = $restauranteModel->getDetalhesCompletos($restauranteId) ?: [];

// Calcular estatísticas via consultas SQL (mais preciso)
$today = date('Y-m-d');
$currentYear = (int) date('Y');
$currentMonth = (int) date('m');
$reservasHoje = $reservaModel->countByRestauranteOnDate($restauranteId, $today, ['confirmada','confirmado']);
$reservasMes = $reservaModel->countByRestauranteInMonth($restauranteId, $currentYear, $currentMonth, ['confirmada','confirmado']);

$ratingMedio = isset($detalhes['rating_medio']) ? (float)$detalhes['rating_medio'] : 0.0;
?>

<link rel="stylesheet" href="../../assets/css/shared.css">
<link rel="stylesheet" href="../../assets/css/pages/restaurante/dashboard.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Dashboard</h1>
        <p style="font-size: 1.3rem;">Gerencie seu restaurante</p>
    </div>
</section>

<div class="container">
    <div class="dashboard-grid">
        <!-- Estatísticas -->
        <!-- <div class="dashboard-section">
            <h3 class="section-title-form">Estatísticas</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php echo htmlspecialchars($reservasHoje); ?></div>
                    <div class="stat-label">Reservas Hoje</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo htmlspecialchars($reservasMes); ?></div>
                    <div class="stat-label">Reservas Este Mês</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $ratingMedio > 0 ? htmlspecialchars(number_format($ratingMedio, 2)) : '—'; ?></div>
                    <div class="stat-label">Avaliação Média</div>
                </div>
            </div>
        </div> -->

        <!-- Reservas Recentes -->
        

        <!-- Ações Rápidas -->
        <div class="dashboard-section">
            <h3 class="section-title-form">Ações Rápidas</h3>
            <div class="quick-actions">
                <a href="editar-perfil.php" class="action-btn">
                    <span class="action-icon">⚙</span>
                    <span>Editar Perfil</span>
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

