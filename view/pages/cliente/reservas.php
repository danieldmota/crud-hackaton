<?php
// Verificação de autenticação do cliente antes de renderizar qualquer HTML
require_once __DIR__ . '/../../../config/auth.php';
requireCliente();

include_once __DIR__ . '/../../components/header.php';

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../model/ReservaModel.php';

$db = new Database();
$conn = $db->conectar();
$reservaModel = new ReservaModel($conn);

$clienteId = $_SESSION['cliente_id'] ?? null;

?>

<link rel="stylesheet" href="../../assets/css/shared.css">
<link rel="stylesheet" href="../../assets/css/pages/cliente/reservas.css">

<div class="container">
    <button class="btn-back" onclick="goBack()">
        Voltar
    </button>
    <h1 class="section-title" style="margin-bottom: 2rem;">Minhas Reservas</h1>

    <div class="reservations-list" id="reservationsList">
        <?php
        if (!$clienteId) {
            echo '<p>Você precisa estar logado para ver suas reservas.</p>';
        } else {
            $reservas = $reservaModel->getByCliente($clienteId);

            if (empty($reservas)) {
                echo '<div class="empty-state">                    <i>📅</i>                    <h3>Nenhuma reserva encontrada</h3>                    <p>Você ainda não fez nenhuma reserva. Que tal explorar nossos restaurantes?</p>                                    </div>';
            } else {
                foreach ($reservas as $r) {
                    $status = htmlspecialchars($r['status'] ?? 'pendente');
                    $statusClass = $status === 'confirmada' ? 'status-confirmed' : ($status === 'cancelada' ? 'status-cancelled' : 'status-pending');
                    $dataFormatada = date('d \d\e F, Y', strtotime($r['data_reserva']));
                    $horario = date('H:i', strtotime($r['horario']));
                    $endereco = trim(($r['rua'] ?? '') . ($r['bairro'] ? ' - ' . $r['bairro'] : '') . ($r['cidade'] ? ' - ' . $r['cidade'] . ', ' . ($r['estado'] ?? '') : ''));
                    ?>
                    <div class="reservation-card">
                        <div class="reservation-header">
                            <div>
                                <h3 class="reservation-restaurant"><?php echo htmlspecialchars($r['restaurante_nome'] ?? 'Restaurante'); ?></h3>
                                <p style="color: #666; margin-top: 0.5rem;"><?php echo htmlspecialchars($r['restaurante_categoria'] ?? ''); ?></p>
                            </div>
                            <span class="reservation-status <?php echo $statusClass; ?>"><?php echo ucfirst($status); ?></span>
                        </div>
                        <div class="reservation-details">
                            <div class="reservation-detail-item">
                                <i>📅</i>
                                <span><strong>Data:</strong> <?php echo $dataFormatada; ?></span>
                            </div>
                            <div class="reservation-detail-item">
                                <i>🕐</i>
                                <span><strong>Horário:</strong> <?php echo $horario; ?></span>
                            </div>
                            <div class="reservation-detail-item">
                                <i>👥</i>
                                <span><strong>Pessoas:</strong> <?php echo (int)$r['numero_pessoas']; ?></span>
                            </div>
                            <div class="reservation-detail-item">
                                <i>📍</i>
                                <span><?php echo htmlspecialchars($endereco); ?></span>
                            </div>
                        </div>
                        <?php if (!empty($r['pedidos_especiais'])): ?>
                            <div class="reservation-details" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border-color);">
                                <div class="reservation-detail-item" style="width: 100%;">
                                    <i>💬</i>
                                    <span><strong>Pedido Especial:</strong> <?php echo htmlspecialchars($r['pedidos_especiais']); ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="reservation-actions">
                            <a class="btn btn-secondary" href="detalhes.php?id=<?php echo (int)$r['restaurante_id']; ?>">Ver Detalhes</a>
                            <form method="POST" action="../../../controller/reservaController.php" style="display:inline-block; margin-left:0.5rem;" onsubmit="return confirm('Cancelar reserva?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo (int)$r['id']; ?>">
                                <button type="submit" class="btn btn-primary">Cancelar Reserva</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>

</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>

