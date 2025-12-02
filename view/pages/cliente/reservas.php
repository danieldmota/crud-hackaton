<?php include_once __DIR__ . '/../../components/header.php'; ?>

<link rel="stylesheet" href="../../assets/css/style.css">

<div class="container">
    <button class="btn-back" onclick="goBack()">
        Voltar
    </button>
    <h1 class="section-title" style="margin-bottom: 2rem;">Minhas Reservas</h1>

    <div class="reservations-list" id="reservationsList">
        <!-- Reserva 1 -->
        <div class="reservation-card">
            <div class="reservation-header">
                <div>
                    <h3 class="reservation-restaurant">La Bella Italia</h3>
                    <p style="color: #666; margin-top: 0.5rem;">Culinária Italiana</p>
                </div>
                <span class="reservation-status status-confirmed">Confirmada</span>
            </div>
            <div class="reservation-details">
                <div class="reservation-detail-item">
                    <i>📅</i>
                    <span><strong>Data:</strong> 20 de Janeiro, 2024</span>
                </div>
                <div class="reservation-detail-item">
                    <i>🕐</i>
                    <span><strong>Horário:</strong> 19:30</span>
                </div>
                <div class="reservation-detail-item">
                    <i>👥</i>
                    <span><strong>Pessoas:</strong> 2</span>
                </div>
                <div class="reservation-detail-item">
                    <i>📍</i>
                    <span>Rua das Flores, 123 - São Paulo, SP</span>
                </div>
            </div>
            <div class="reservation-actions">
                <button class="btn btn-secondary" onclick="navigateTo('detalhes.php?id=1')">Ver Detalhes</button>
                <button class="btn btn-primary" onclick="cancelReservation(1)">Cancelar Reserva</button>
            </div>
        </div>

        <!-- Reserva 2 -->
        <div class="reservation-card">
            <div class="reservation-header">
                <div>
                    <h3 class="reservation-restaurant">Sushi Master</h3>
                    <p style="color: #666; margin-top: 0.5rem;">Culinária Japonesa</p>
                </div>
                <span class="reservation-status status-pending">Pendente</span>
            </div>
            <div class="reservation-details">
                <div class="reservation-detail-item">
                    <i>📅</i>
                    <span><strong>Data:</strong> 25 de Janeiro, 2024</span>
                </div>
                <div class="reservation-detail-item">
                    <i>🕐</i>
                    <span><strong>Horário:</strong> 20:00</span>
                </div>
                <div class="reservation-detail-item">
                    <i>👥</i>
                    <span><strong>Pessoas:</strong> 4</span>
                </div>
                <div class="reservation-detail-item">
                    <i>📍</i>
                    <span>Av. Paulista, 456 - São Paulo, SP</span>
                </div>
            </div>
            <div class="reservation-actions">
                <button class="btn btn-secondary" onclick="navigateTo('detalhes.php?id=2')">Ver Detalhes</button>
                <button class="btn btn-primary" onclick="cancelReservation(2)">Cancelar Reserva</button>
            </div>
        </div>

        <!-- Reserva 3 -->
        <div class="reservation-card">
            <div class="reservation-header">
                <div>
                    <h3 class="reservation-restaurant">Churrascaria Gaúcha</h3>
                    <p style="color: #666; margin-top: 0.5rem;">Culinária Brasileira</p>
                </div>
                <span class="reservation-status status-confirmed">Confirmada</span>
            </div>
            <div class="reservation-details">
                <div class="reservation-detail-item">
                    <i>📅</i>
                    <span><strong>Data:</strong> 28 de Janeiro, 2024</span>
                </div>
                <div class="reservation-detail-item">
                    <i>🕐</i>
                    <span><strong>Horário:</strong> 19:00</span>
                </div>
                <div class="reservation-detail-item">
                    <i>👥</i>
                    <span><strong>Pessoas:</strong> 6</span>
                </div>
                <div class="reservation-detail-item">
                    <i>📍</i>
                    <span>Rua Augusta, 789 - São Paulo, SP</span>
                </div>
            </div>
            <div class="reservation-details" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                <div class="reservation-detail-item" style="width: 100%;">
                    <i>💬</i>
                    <span><strong>Pedido Especial:</strong> Mesa perto da área externa, aniversário</span>
                </div>
            </div>
            <div class="reservation-actions">
                <button class="btn btn-secondary" onclick="navigateTo('detalhes.php?id=3')">Ver Detalhes</button>
                <button class="btn btn-primary" onclick="cancelReservation(3)">Cancelar Reserva</button>
            </div>
        </div>
    </div>

    <!-- Estado vazio (comentado - será usado quando não houver reservas) -->
    <!--
    <div class="empty-state">
        <i>📅</i>
        <h3>Nenhuma reserva encontrada</h3>
        <p>Você ainda não fez nenhuma reserva. Que tal explorar nossos restaurantes?</p>
        <a href="home.php" class="btn btn-primary" style="margin-top: 1rem;">Explorar Restaurantes</a>
    </div>
    -->
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>

