<?php
$restaurantId = $_GET['id'] ?? 1;
include_once __DIR__ . '/../../components/header.php';

require_once __DIR__ . '/../../../model/RestauranteModel.php';

$restauranteModel = new RestauranteModel();
$restaurante = $restauranteModel->getDetalhesCompletos((int) $restaurantId);

if (!$restaurante) {
    die("Erro: Restaurante não encontrado.");
}

?>
<?php
if (!isset($restaurantId)) {
    die("Erro: ID do restaurante não definido.");
}
?>


<link rel="stylesheet" href="../../assets/css/shared.css">
<link rel="stylesheet" href="../../assets/css/pages/detalhes.css">


<div class="container">
    <button class="btn-back" onclick="goBack()">
        Voltar
    </button>
    <div class="restaurant-details">
        <div class="restaurant-header">
            <div class="restaurant-header-content">
                <h1><?php echo htmlspecialchars($restaurante['nome']); ?></h1>
                <p class="restaurant-category"><?php echo htmlspecialchars($restaurante['categoria']); ?></p>
                <div class="restaurant-rating" style="justify-content: center; margin-top: 1rem;">
                    <span class="stars"><?php
                    $rating = (int) $restaurante['rating_medio'];
                    for ($i = 0; $i < 5; $i++) {
                        echo $i < $rating ? '★' : '☆';
                    }
                    ?></span>
                    <span class="rating-text"
                        style="color: white;"><?php echo number_format($restaurante['rating_medio'], 1, ',', '.'); ?>
                        (<?php echo count($restaurante['avaliacoes']); ?> avaliações)</span>
                </div>
            </div>
        </div>

        <div class="restaurant-body">
            <div class="details-grid">
                <div>
                    <div class="details-section">
                        <h3>📋 Sobre o Restaurante</h3>
                        <p style="line-height: 1.8; color: var(--text-secondary);">
                            <?php echo nl2br(htmlspecialchars($restaurante['descricao'])); ?>
                        </p>
                    </div>

                    <div class="tabs" style="margin-top: 2rem;">
                        <button class="tab active" data-tab="menu">CARDÁPIO</button>
                        <button class="tab" data-tab="reviews">AVALIAÇÕES</button>
                        <button class="tab" data-tab="info">INFORMAÇÕES</button>
                    </div>

                    <div id="menu" class="tab-content active">
                        <h3 style="margin-bottom: 1.5rem;">Cardápio</h3>
                        <div class="menu-grid">
                            <?php foreach ($restaurante['cardapio'] as $categoria => $itens): ?>
                                <?php foreach ($itens as $item): ?>
                                    <div class="menu-item">
                                        <h4 class="menu-item-name"><?php echo htmlspecialchars($item['nome']); ?></h4>
                                        <p class="menu-item-description"><?php echo htmlspecialchars($item['descricao']); ?></p>
                                        <p class="menu-item-price">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                                        </p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div id="reviews" class="tab-content">
                        <h3 style="margin-bottom: 1.5rem;">⭐ Avaliações</h3>
                        <?php if (count($restaurante['avaliacoes']) > 0): ?>
                            <?php foreach ($restaurante['avaliacoes'] as $avaliacao): ?>
                                <div class="review-card">
                                    <div class="review-header">
                                        <div>
                                            <div class="reviewer-name">
                                                <?php echo htmlspecialchars($avaliacao['nome_cliente']); ?></div>
                                            <div class="review-date">
                                                <?php echo date('d \d\e F, Y', strtotime($avaliacao['data_criacao'])); ?></div>
                                        </div>
                                        <div class="review-rating">
                                            <span class="stars">
                                                <?php
                                                for ($i = 0; $i < 5; $i++) {
                                                    echo $i < $avaliacao['rating'] ? '★' : '☆';
                                                }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <p class="review-text">
                                        <?php echo htmlspecialchars($avaliacao['comentario']); ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Nenhuma avaliação disponível.</p>
                        <?php endif; ?>
                    </div>

                    <div id="info" class="tab-content">
                        <h3 style="margin-bottom: 1.5rem;">Informações</h3>
                        <div class="details-section">
                            <div class="info-item">
                                <i>📍</i>
                                <div>
                                    <strong>Endereço:</strong><br>
                                    <?php echo htmlspecialchars($restaurante['rua'] ?? ''); ?><br>
                                    <?php echo htmlspecialchars($restaurante['bairro'] ?? ''); ?><br>
                                    <?php echo htmlspecialchars($restaurante['cidade'] ?? ''); ?>,
                                    <?php echo htmlspecialchars($restaurante['estado'] ?? ''); ?> - CEP:
                                    <?php echo htmlspecialchars($restaurante['cep'] ?? ''); ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <i>🕐</i>
                                <div>
                                    <strong>Horário de Funcionamento:</strong><br>
                                    <?php foreach ($restaurante['horarios'] as $horario): ?>
                                        <?php echo htmlspecialchars($horario['dia_semana']); ?>:
                                        <?php echo date('H:i', strtotime($horario['hora_abertura'])); ?> -
                                        <?php echo date('H:i', strtotime($horario['hora_fechamento'])); ?><br>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <i>📞</i>
                                <div>
                                    <strong>Telefone:</strong><br>
                                    <?php echo htmlspecialchars($restaurante['telefone'] ?? 'Não informado'); ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <i>🌐</i>
                                <div>
                                    <strong>Website:</strong><br>
                                    <?php echo htmlspecialchars($restaurante['website'] ?? 'Não informado'); ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <i>💳</i>
                                <div>
                                    <strong>Formas de Pagamento:</strong><br>
                                    <?php
                                    $pagamentos = array_column($restaurante['pagamentos'], 'nome');
                                    echo !empty($pagamentos) ? htmlspecialchars(implode(', ', $pagamentos)) : 'Não informado';
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="reservation-form">
                        <h3 style="margin-bottom: 1.5rem;">Fazer Reserva</h3>
                        <?php if (empty($_SESSION['cliente_id'])): ?>
                            <p>Para fazer uma reserva é necessário estar logado.</p>
                            <?php
                            $current = $_SERVER['REQUEST_URI'] ?? '/crud-hackaton/';
                            $loginUrl = '/crud-hackaton/view/pages/login-cliente.php?redirect=' . urlencode($current);
                            ?>
                            <a href="<?php echo $loginUrl; ?>" class="btn btn-primary" style="width:100%;">Entrar para
                                Reservar</a>
                        <?php else: ?>
                            <form id="reservationForm" action="../../controller/reservaController.php" method="POST"
                                onsubmit="submitReservation(event)">
                                <input type="hidden" name="restaurant_id" value="<?php echo $restaurantId; ?>">
                                <input type="hidden" name="action" value="create">

                                <div class="form-group">
                                    <label for="date">Data:</label>
                                    <input type="date" id="date" name="date" required min="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="time">Horário:</label>
                                    <select id="time" name="time" required>
                                        <option value="">Selecione um horário</option>
                                        <option value="18:00">18:00</option>
                                        <option value="18:30">18:30</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="guests">Número de Pessoas:</label>
                                    <select id="guests" name="guests" required>
                                        <option value="">Selecione</option>
                                        <option value="1">1 pessoa</option>
                                        <option value="2">2 pessoas</option>
                                        <option value="3">3 pessoas</option>
                                        <option value="4">4 pessoas</option>
                                        <option value="5">5 pessoas</option>
                                        <option value="6">6 pessoas</option>
                                        <option value="7">7 pessoas</option>
                                        <option value="8">8 ou mais pessoas</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="special_requests">Pedidos Especiais (opcional):</label>
                                    <textarea id="special_requests" name="special_requests"
                                        placeholder="Ex: Mesa perto da janela, aniversário, restrições alimentares..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary" style="width: 100%;">CONFIRMAR
                                    RESERVA</button>
                            </form>
                        <?php endif; ?>
                    </div>

                    <div class="details-section" style="margin-top: 2rem;">
                        <h3>Características</h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 1rem;">
                            <?php foreach ($restaurante['caracteristicas'] as $carac): ?>
                                <span class="feature-badge"><?php echo htmlspecialchars($carac['nome']); ?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>
<script>
    // Definir data mínima como hoje
    document.getElementById('date').min = new Date().toISOString().split('T')[0];
</script>