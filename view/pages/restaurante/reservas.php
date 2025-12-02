<?php include_once __DIR__ . '/../../components/header.php'; ?>

<link rel="stylesheet" href="../../assets/css/style.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Reservas do Restaurante</h1>
        <p style="font-size: 1.3rem;">Gerencie todas as reservas do seu restaurante</p>
    </div>
</section>

<div class="container">
    <button class="btn-back" onclick="goBack()">
        Voltar
    </button>
    <!-- Filtros de Reservas -->
    <div class="dashboard-section" style="margin-bottom: 2rem;">
        <div class="filters-container" style="margin: 0;">
            <div class="filter-group">
                <label>Filtrar por:</label>
                <div class="filter-options">
                    <div class="filter-chip active" data-filter="all" onclick="filterReservations('all')">Todas</div>
                    <div class="filter-chip" data-filter="pending" onclick="filterReservations('pending')">Pendentes</div>
                    <div class="filter-chip" data-filter="confirmed" onclick="filterReservations('confirmed')">Confirmadas</div>
                    <div class="filter-chip" data-filter="cancelled" onclick="filterReservations('cancelled')">Canceladas</div>
                </div>
            </div>

            <div class="filter-group">
                <label>Período:</label>
                <select id="periodFilter" class="filter-select" onchange="filterReservations('all')">
                    <option value="today">Hoje</option>
                    <option value="week" selected>Esta Semana</option>
                    <option value="month">Este Mês</option>
                    <option value="all">Todas</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Lista de Reservas -->
    <div class="reservations-list">
        <!-- Reserva Pendente -->
        <div class="reservation-card" data-status="pending">
            <div class="reservation-header">
                <div>
                    <h3 class="reservation-restaurant">Maria Silva</h3>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Mesa 3 - 6 pessoas</p>
                </div>
                <span class="reservation-status status-pending">Pendente</span>
            </div>
            <div class="reservation-details">
                <div class="reservation-detail-item">
                    <span><strong>Data:</strong> Hoje, 20 de Janeiro, 2024</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>Horário:</strong> 20:00</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>Telefone:</strong> (11) 98765-4321</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>E-mail:</strong> maria.silva@email.com</span>
                </div>
            </div>
            <div class="reservation-details" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--dark-border);">
                <div class="reservation-detail-item" style="width: 100%;">
                    <span><strong>Observações:</strong> Aniversário - mesa perto da janela</span>
                </div>
            </div>
            <div class="reservation-actions">
                <button class="btn btn-primary" onclick="confirmReservation(1)">Confirmar</button>
                <button class="btn btn-secondary" onclick="viewReservationDetails(1)">Ver Detalhes</button>
                <button class="btn btn-secondary" style="background: rgba(255, 68, 68, 0.2); color: #ff4444; border-color: #ff4444;" onclick="cancelReservation(1)">Cancelar</button>
            </div>
        </div>

        <!-- Reserva Confirmada -->
        <div class="reservation-card" data-status="confirmed">
            <div class="reservation-header">
                <div>
                    <h3 class="reservation-restaurant">João Santos</h3>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Mesa 2 - 2 pessoas</p>
                </div>
                <span class="reservation-status status-confirmed">Confirmada</span>
            </div>
            <div class="reservation-details">
                <div class="reservation-detail-item">
                    <span><strong>Data:</strong> Hoje, 20 de Janeiro, 2024</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>Horário:</strong> 19:30</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>Telefone:</strong> (11) 97654-3210</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>E-mail:</strong> joao.santos@email.com</span>
                </div>
            </div>
            <div class="reservation-actions">
                <button class="btn btn-secondary" onclick="viewReservationDetails(2)">Ver Detalhes</button>
                <button class="btn btn-secondary" onclick="contactCustomer(2)">Contatar Cliente</button>
                <button class="btn btn-secondary" style="background: rgba(255, 68, 68, 0.2); color: #ff4444; border-color: #ff4444;" onclick="cancelReservation(2)">Cancelar</button>
            </div>
        </div>

        <!-- Reserva Confirmada (outra) -->
        <div class="reservation-card" data-status="confirmed">
            <div class="reservation-header">
                <div>
                    <h3 class="reservation-restaurant">Ana Costa</h3>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Mesa 6 - 8 pessoas</p>
                </div>
                <span class="reservation-status status-confirmed">Confirmada</span>
            </div>
            <div class="reservation-details">
                <div class="reservation-detail-item">
                    <span><strong>Data:</strong> 22 de Janeiro, 2024</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>Horário:</strong> 20:00</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>Telefone:</strong> (11) 96543-2109</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>E-mail:</strong> ana.costa@email.com</span>
                </div>
            </div>
            <div class="reservation-details" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--dark-border);">
                <div class="reservation-detail-item" style="width: 100%;">
                    <span><strong>Observações:</strong> Reunião de negócios - área mais reservada</span>
                </div>
            </div>
            <div class="reservation-actions">
                <button class="btn btn-secondary" onclick="viewReservationDetails(3)">Ver Detalhes</button>
                <button class="btn btn-secondary" onclick="contactCustomer(3)">Contatar Cliente</button>
                <button class="btn btn-secondary" style="background: rgba(255, 68, 68, 0.2); color: #ff4444; border-color: #ff4444;" onclick="cancelReservation(3)">Cancelar</button>
            </div>
        </div>

        <!-- Reserva Cancelada -->
        <div class="reservation-card" data-status="cancelled" style="opacity: 0.7;">
            <div class="reservation-header">
                <div>
                    <h3 class="reservation-restaurant">Pedro Oliveira</h3>
                    <p style="color: var(--text-secondary); margin-top: 0.5rem;">Mesa 1 - 4 pessoas</p>
                </div>
                <span class="reservation-status status-cancelled">Cancelada</span>
            </div>
            <div class="reservation-details">
                <div class="reservation-detail-item">
                    <span><strong>Data:</strong> 18 de Janeiro, 2024</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>Horário:</strong> 19:00</span>
                </div>
                <div class="reservation-detail-item">
                    <span><strong>Cancelado em:</strong> 17/01/2024</span>
                </div>
            </div>
            <div class="reservation-actions">
                <button class="btn btn-secondary" onclick="viewReservationDetails(4)">Ver Detalhes</button>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>
<script>
function filterReservations(status) {
    // Atualizar chips ativos
    document.querySelectorAll('.filter-chip').forEach(chip => {
        chip.classList.remove('active');
    });
    document.querySelector(`[data-filter="${status}"]`).classList.add('active');
    
    // Filtrar cards
    const cards = document.querySelectorAll('.reservation-card');
    cards.forEach(card => {
        if (status === 'all') {
            card.style.display = 'block';
            card.style.opacity = card.dataset.status === 'cancelled' ? '0.7' : '1';
        } else {
            if (card.dataset.status === status) {
                card.style.display = 'block';
                card.style.opacity = '1';
            } else {
                card.style.display = 'none';
            }
        }
    });
}

function confirmReservation(id) {
    if (confirm('Confirmar esta reserva?')) {
        alert('Reserva confirmada com sucesso!');
        location.reload();
    }
}

function cancelReservation(id) {
    if (confirm('Tem certeza que deseja cancelar esta reserva?')) {
        alert('Reserva cancelada com sucesso!');
        location.reload();
    }
}

function viewReservationDetails(id) {
    alert('Detalhes da reserva #' + id);
}

function contactCustomer(id) {
    alert('Abrindo opções de contato para o cliente da reserva #' + id);
}
</script>

