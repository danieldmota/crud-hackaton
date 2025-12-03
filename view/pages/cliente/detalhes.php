<?php
$restaurantId = $_GET['id'] ?? 1;
include_once __DIR__ . '/../../components/header.php';

?>
<?php
if (!isset($restaurantId)) {
    die("Erro: ID do restaurante não definido.");
}
?>

<link rel="stylesheet" href="../../assets/css/style.css">

<div class="container">
    <button class="btn-back" onclick="goBack()">
        Voltar
    </button>
    <div class="restaurant-details">
        <div class="restaurant-header">
            <div class="restaurant-header-content">
                <h1>La Bella Italia</h1>
                <p class="restaurant-category">Culinária Italiana Autêntica</p>
                <div class="restaurant-rating" style="justify-content: center; margin-top: 1rem;">
                    <span class="stars">★★★★★</span>
                    <span class="rating-text" style="color: white;">4.8 (234 avaliações)</span>
                </div>
            </div>
        </div>

        <div class="restaurant-body">
            <div class="details-grid">
                <div>
                    <div class="details-section">
                        <h3>📋 Sobre o Restaurante</h3>
                        <p style="line-height: 1.8; color: var(--text-secondary);">
                            O La Bella Italia oferece uma experiência gastronômica única com pratos autênticos da
                            culinária italiana.
                            Nossa equipe de chefs traz receitas tradicionais passadas de geração em geração, preparadas
                            com ingredientes
                            frescos e selecionados. Ambiente acolhedor e sofisticado, perfeito para jantares românticos,
                            encontros com
                            amigos ou celebrações especiais.
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
                            <div class="menu-item">
                                <h4 class="menu-item-name">Spaghetti Carbonara</h4>
                                <p class="menu-item-description">Massa artesanal com bacon, ovos, queijo parmesão e
                                    pimenta preta</p>
                                <p class="menu-item-price">R$ 45,90</p>
                            </div>
                            <div class="menu-item">
                                <h4 class="menu-item-name">Risotto de Camarão</h4>
                                <p class="menu-item-description">Arroz arbóreo cremoso com camarões frescos e ervas</p>
                                <p class="menu-item-price">R$ 58,90</p>
                            </div>
                            <div class="menu-item">
                                <h4 class="menu-item-name">Pizza Margherita</h4>
                                <p class="menu-item-description">Massa fina, molho de tomate, mussarela de búfala e
                                    manjericão</p>
                                <p class="menu-item-price">R$ 42,90</p>
                            </div>
                            <div class="menu-item">
                                <h4 class="menu-item-name">Lasagna à Bolonhesa</h4>
                                <p class="menu-item-description">Camadas de massa, molho bolonhesa, queijo e bechamel
                                </p>
                                <p class="menu-item-price">R$ 52,90</p>
                            </div>
                            <div class="menu-item">
                                <h4 class="menu-item-name">Osso Buco</h4>
                                <p class="menu-item-description">Vitela cozida lentamente com legumes e gremolata</p>
                                <p class="menu-item-price">R$ 68,90</p>
                            </div>
                            <div class="menu-item">
                                <h4 class="menu-item-name">Tiramisu</h4>
                                <p class="menu-item-description">Sobremesa tradicional italiana com café e mascarpone
                                </p>
                                <p class="menu-item-price">R$ 24,90</p>
                            </div>
                        </div>
                    </div>

                    <div id="reviews" class="tab-content">
                        <h3 style="margin-bottom: 1.5rem;">⭐ Avaliações</h3>
                        <div class="review-card">
                            <div class="review-header">
                                <div>
                                    <div class="reviewer-name">Maria Silva</div>
                                    <div class="review-date">15 de Janeiro, 2024</div>
                                </div>
                                <div class="review-rating">
                                    <span class="stars">★★★★★</span>
                                </div>
                            </div>
                            <p class="review-text">
                                Experiência incrível! A comida estava deliciosa, o ambiente é acolhedor e o atendimento
                                foi impecável.
                                Definitivamente voltarei!
                            </p>
                        </div>
                        <div class="review-card">
                            <div class="review-header">
                                <div>
                                    <div class="reviewer-name">João Santos</div>
                                    <div class="review-date">10 de Janeiro, 2024</div>
                                </div>
                                <div class="review-rating">
                                    <span class="stars">★★★★☆</span>
                                </div>
                            </div>
                            <p class="review-text">
                                Ótimo restaurante! A pizza estava perfeita e o serviço foi rápido. O único ponto
                                negativo foi a espera
                                para conseguir uma mesa, mas valeu a pena.
                            </p>
                        </div>
                        <div class="review-card">
                            <div class="review-header">
                                <div>
                                    <div class="reviewer-name">Ana Costa</div>
                                    <div class="review-date">5 de Janeiro, 2024</div>
                                </div>
                                <div class="review-rating">
                                    <span class="stars">★★★★★</span>
                                </div>
                            </div>
                            <p class="review-text">
                                Melhor restaurante italiano da cidade! O risotto estava divino e o ambiente é perfeito
                                para um jantar
                                romântico. Recomendo muito!
                            </p>
                        </div>
                    </div>

                    <div id="info" class="tab-content">
                        <h3 style="margin-bottom: 1.5rem;">Informações</h3>
                        <div class="details-section">
                            <div class="info-item">
                                <i>📍</i>
                                <div>
                                    <strong>Endereço:</strong><br>
                                    Rua das Flores, 123 - Centro<br>
                                    São Paulo, SP - CEP: 01234-567
                                </div>
                            </div>
                            <div class="info-item">
                                <i>🕐</i>
                                <div>
                                    <strong>Horário de Funcionamento:</strong><br>
                                    Segunda a Quinta: 18:00 - 23:00<br>
                                    Sexta e Sábado: 18:00 - 00:00<br>
                                    Domingo: 12:00 - 22:00
                                </div>
                            </div>
                            <div class="info-item">
                                <i>📞</i>
                                <div>
                                    <strong>Telefone:</strong><br>
                                    (11) 3456-7890
                                </div>
                            </div>
                            <div class="info-item">
                                <i>🌐</i>
                                <div>
                                    <strong>Website:</strong><br>
                                    www.labellaitalia.com.br
                                </div>
                            </div>
                            <div class="info-item">
                                <i>💳</i>
                                <div>
                                    <strong>Formas de Pagamento:</strong><br>
                                    Dinheiro, Cartão de Crédito/Débito, PIX
                                </div>
                            </div>
                            <div class="info-item">
                                <i>🚗</i>
                                <div>
                                    <strong>Estacionamento:</strong><br>
                                    Valet disponível (R$ 15,00)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="reservation-form">
                        <h3 style="margin-bottom: 1.5rem;">Fazer Reserva</h3>
                        <form id="reservationForm" action="index.php?action=store" method="POST"
                            onsubmit="submitReservation(event)">
                            <input type="hidden" name="restaurant_id" value="<?php echo $restaurantId; ?>">

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
                    </div>

                    <div class="details-section" style="margin-top: 2rem;">
                        <h3>Características</h3>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-top: 1rem;">
                            <span class="feature-badge">🥗 Vegetariano</span>
                            <span class="feature-badge">🌳 Área Externa</span>
                            <span class="feature-badge">🅿️ Estacionamento</span>
                            <span class="feature-badge">💕 Romântico</span>
                            <span class="feature-badge">📶 Wi-Fi Grátis</span>
                            <span class="feature-badge">🎵 Música Ambiente</span>
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