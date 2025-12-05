<?php 
include_once __DIR__ . '/../../components/header.php';
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../model/ReservaModel.php';

// Verificar se restaurante está logado
if (empty($_SESSION['restaurante_id'])) {
    header('Location: ../../pages/login-restaurante.php');
    exit();
}

$restaurante_id = $_SESSION['restaurante_id'];

// Conectar ao banco e buscar reservas
$db = new Database();
$conn = $db->conectar();
$reservaModel = new ReservaModel($conn);
$reservas = $reservaModel->getByRestaurante($restaurante_id);

// Mapear status para português
$statusMap = [
    'pendente' => 'Pendente',
    'confirmada' => 'Confirmada',
    'cancelada' => 'Cancelada',
    'concluida' => 'Concluída'
];

$statusClassMap = [
    'pendente' => 'status-pending',
    'confirmada' => 'status-confirmed',
    'cancelada' => 'status-cancelled',
    'concluida' => 'status-confirmed'
];
?>

<link rel="stylesheet" href="../../assets/css/shared.css">
<link rel="stylesheet" href="../../assets/css/pages/cliente/reservas.css">
<link rel="stylesheet" href="../../assets/css/pages/restaurante/dashboard.css">

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
                    <div class="filter-chip" data-filter="pendente" onclick="filterReservations('pendente')">Pendentes</div>
                    <div class="filter-chip" data-filter="confirmada" onclick="filterReservations('confirmada')">Confirmadas</div>
                    <div class="filter-chip" data-filter="cancelada" onclick="filterReservations('cancelada')">Canceladas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Reservas -->
    <div class="reservations-list">
        <?php if (empty($reservas)): ?>
            <div style="text-align: center; padding: 3rem 2rem; color: var(--text-secondary);">
                <p style="font-size: 1.2rem;">Ainda não há reservas disponíveis</p>
            </div>
        <?php else: ?>
            <?php foreach ($reservas as $reserva): ?>
                <?php
                $status = strtolower($reserva['status'] ?? 'pendente');
                $statusTexto = $statusMap[$status] ?? 'Pendente';
                $statusClass = $statusClassMap[$status] ?? 'status-pending';
                $dataFormatada = date('d \d\e F \d\e Y', strtotime($reserva['data_reserva']));
                $opacidade = $status === 'cancelada' ? 'opacity: 0.7;' : '';
                ?>
                <div class="reservation-card" data-status="<?php echo htmlspecialchars($status); ?>" style="<?php echo $opacidade; ?>">
                    <div class="reservation-header">
                        <div>
                            <h3 class="reservation-restaurant"><?php echo htmlspecialchars($reserva['cliente_nome'] ?? 'Cliente'); ?></h3>
                            <p style="color: var(--text-secondary); margin-top: 0.5rem;"><?php echo htmlspecialchars($reserva['numero_pessoas']); ?> pessoa(s)</p>
                        </div>
                        <span class="reservation-status <?php echo $statusClass; ?>"><?php echo $statusTexto; ?></span>
                    </div>
                    <div class="reservation-details">
                        <div class="reservation-detail-item">
                            <span><strong>Data:</strong> <?php echo $dataFormatada; ?></span>
                        </div>
                        <div class="reservation-detail-item">
                            <span><strong>Horário:</strong> <?php echo htmlspecialchars($reserva['horario']); ?></span>
                        </div>
                        <div class="reservation-detail-item">
                            <span><strong>Telefone:</strong> <?php echo htmlspecialchars($reserva['cliente_telefone'] ?? 'Não informado'); ?></span>
                        </div>
                        <div class="reservation-detail-item">
                            <span><strong>E-mail:</strong> <?php echo htmlspecialchars($reserva['cliente_email'] ?? 'Não informado'); ?></span>
                        </div>
                    </div>
                    <?php if (!empty($reserva['pedidos_especiais'])): ?>
                        <div class="reservation-details" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--dark-border);">
                            <div class="reservation-detail-item" style="width: 100%;">
                                <span><strong>Observações:</strong> <?php echo htmlspecialchars($reserva['pedidos_especiais']); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="reservation-actions">
                        <?php if ($status === 'pendente'): ?>
                            <button class="btn btn-primary" onclick="confirmReservation(<?php echo $reserva['id']; ?>)">Confirmar</button>
                            <button class="btn btn-secondary" style="background: rgba(255, 68, 68, 0.2); color: #ff4444; border-color: #ff4444;" onclick="cancelReservation(<?php echo $reserva['id']; ?>)">Cancelar</button>
                        <?php elseif ($status === 'confirmada'): ?>
                            <button class="btn btn-secondary" onclick="contactCustomer(<?php echo $reserva['id']; ?>)">Contatar Cliente</button>
                            <button class="btn btn-secondary" style="background: rgba(255, 68, 68, 0.2); color: #ff4444; border-color: #ff4444;" onclick="cancelReservation(<?php echo $reserva['id']; ?>)">Cancelar</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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
            card.style.opacity = card.dataset.status === 'cancelada' ? '0.7' : '1';
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
        // Aqui você faria uma requisição AJAX para confirmar no backend
        alert('Reserva confirmada com sucesso!');
        location.reload();
    }
}

function cancelReservation(id) {
    if (confirm('Tem certeza que deseja cancelar esta reserva?')) {
        // Aqui você faria uma requisição AJAX para cancelar no backend
        alert('Reserva cancelada com sucesso!');
        location.reload();
    }
}

function contactCustomer(id) {
    alert('Abrindo opções de contato para o cliente da reserva #' + id);
}
    function updateReservationStatus(id, action) {
        const formData = new FormData();
        formData.append('reserva_id', id);
        formData.append('action', action);

        fetch('/crud-hackaton/controller/reservaStatusController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification('Erro: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            showNotification('Erro ao atualizar reserva', 'error');
        });
    }

    function confirmReservation(id) {
        if (confirm('Confirmar esta reserva?')) {
            updateReservationStatus(id, 'confirm');
        }
    }

    function cancelReservation(id) {
        if (confirm('Tem certeza que deseja cancelar esta reserva?')) {
            updateReservationStatus(id, 'cancel');
        }
    }

    function contactCustomer(id) {
        alert('Abrindo opções de contato para o cliente da reserva #' + id);
    }
</script>