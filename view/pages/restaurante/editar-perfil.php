<?php include_once __DIR__ . '/../../components/header.php'; ?>

<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../model/RestauranteModel.php';

// Verifica autenticação do restaurante
if (empty($_SESSION['restaurante_id'])) {
    header('Location: ../../pages/login-restaurante.php');
    exit();
}

$restauranteId = (int) $_SESSION['restaurante_id'];
$restModel = new RestauranteModel();
$detalhes = $restModel->getDetalhesCompletos($restauranteId) ?: [];

// flash messages
$flashSuccess = $_SESSION['flash_success'] ?? null;
$flashError = $_SESSION['flash_error'] ?? null;
unset($_SESSION['flash_success'], $_SESSION['flash_error']);
?>

<link rel="stylesheet" href="../../assets/css/style.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Editar Perfil do Restaurante</h1>
        <p style="font-size: 1.3rem;">Atualize as informações do seu restaurante</p>
    </div>
</section>

<div class="container">
    <button class="btn-back" onclick="goBack()">
        Voltar
    </button>
    <div class="registration-form-container">
        <?php if ($flashSuccess): ?>
            <div class="alert success"><?php echo htmlspecialchars($flashSuccess); ?></div>
        <?php endif; ?>
        <?php if ($flashError): ?>
            <div class="alert error"><?php echo htmlspecialchars($flashError); ?></div>
        <?php endif; ?>

        <form id="editProfileForm" class="registration-form" enctype="multipart/form-data" method="post" action="../../../controller/AtualizarRestauranteController.php">
            
            <!-- Dados do Restaurante -->
            <div class="form-section">
                <h3 class="section-title-form">Informações do Restaurante</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="restaurant_name">Nome do Restaurante *</label>
                        <input type="text" id="restaurant_name" name="restaurant_name" required value="<?php echo htmlspecialchars($detalhes['nome'] ?? ''); ?>" placeholder="Ex: La Bella Italia">
                    </div>
                    
                    <div class="form-group">
                        <label for="cnpj">CNPJ *</label>
                        <input type="text" id="cnpj" name="cnpj" required value="<?php echo htmlspecialchars($detalhes['cnpj'] ?? ''); ?>" placeholder="00.000.000/0000-00" maxlength="18" readonly>
                        <small style="color: var(--text-secondary); font-size: 0.9rem;">CNPJ não pode ser alterado</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Categoria *</label>
                        <select id="category" name="category" required>
                            <?php $cat = strtolower($detalhes['categoria'] ?? ''); ?>
                            <option value="italiana" <?php echo $cat === 'italiana' ? 'selected' : ''; ?>>Italiana</option>
                            <option value="japonesa" <?php echo $cat === 'japonesa' ? 'selected' : ''; ?>>Japonesa</option>
                            <option value="brasileira" <?php echo $cat === 'brasileira' ? 'selected' : ''; ?>>Brasileira</option>
                            <option value="francesa" <?php echo $cat === 'francesa' ? 'selected' : ''; ?>>Francesa</option>
                            <option value="mexicana" <?php echo $cat === 'mexicana' ? 'selected' : ''; ?>>Mexicana</option>
                            <option value="asiatica" <?php echo $cat === 'asiatica' ? 'selected' : ''; ?>>Asiática</option>
                            <option value="pizzaria" <?php echo $cat === 'pizzaria' ? 'selected' : ''; ?>>Pizzaria</option>
                            <option value="churrascaria" <?php echo $cat === 'churrascaria' ? 'selected' : ''; ?>>Churrascaria</option>
                            <option value="fast-food" <?php echo $cat === 'fast-food' ? 'selected' : ''; ?>>Fast Food</option>
                            <option value="vegetariana" <?php echo $cat === 'vegetariana' ? 'selected' : ''; ?>>Vegetariana</option>
                            <option value="vegana" <?php echo $cat === 'vegana' ? 'selected' : ''; ?>>Vegana</option>
                            <option value="outro" <?php echo (!in_array($cat, ['italiana','japonesa','brasileira','francesa','mexicana','asiatica','pizzaria','churrascaria','fast-food','vegetariana','vegana'])) ? 'selected' : ''; ?>>Outro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacidade (número de lugares) *</label>
                        <input type="number" id="capacity" name="capacity" required min="1" value="<?php echo htmlspecialchars($detalhes['capacidade'] ?? ''); ?>" placeholder="Ex: 50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Descrição do Restaurante *</label>
                    <textarea id="description" name="description" required rows="4" placeholder="Descreva seu restaurante, especialidades, ambiente..."><?php echo htmlspecialchars($detalhes['descricao'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="restaurant_image">Foto do Restaurante</label>
                    <div style="margin-bottom: 1rem;">
                        <?php if (!empty($detalhes['imagem'])): ?>
                            <img src="<?php echo htmlspecialchars($detalhes['imagem']); ?>" alt="Foto atual" style="width: 200px; height: 150px; object-fit: cover; border-radius: 12px; border: 2px solid var(--dark-border);">
                        <?php else: ?>
                            <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Foto atual" style="width: 200px; height: 150px; object-fit: cover; border-radius: 12px; border: 2px solid var(--dark-border);">
                        <?php endif; ?>
                    </div>
                    <input type="file" id="restaurant_image" name="restaurant_image" accept="image/*" class="file-input">
                    <small style="color: var(--text-secondary); font-size: 0.9rem;">Formatos aceitos: JPG, PNG (máx. 5MB)</small>
                </div>
            </div>

            <!-- Endereço -->
            <div class="form-section">
                <h3 class="section-title-form">Endereço</h3>
                
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label for="address">Rua/Avenida *</label>
                        <input type="text" id="address" name="address" required value="<?php echo htmlspecialchars($detalhes['rua'] ?? ''); ?>" placeholder="Ex: Rua das Flores, 123">
                    </div>
                    
                    <div class="form-group">
                        <label for="neighborhood">Bairro *</label>
                        <input type="text" id="neighborhood" name="neighborhood" required value="<?php echo htmlspecialchars($detalhes['bairro'] ?? ''); ?>" placeholder="Ex: Centro">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="city">Cidade *</label>
                        <input type="text" id="city" name="city" required value="<?php echo htmlspecialchars($detalhes['cidade'] ?? ''); ?>" placeholder="Ex: São Paulo">
                    </div>
                    
                    <div class="form-group">
                        <label for="state">Estado *</label>
                        <select id="state" name="state" required>
                            <option value="">Selecione o estado</option>
                            <?php 
                            $estados = [
                                'AC' => 'Acre',
                                'AL' => 'Alagoas',
                                'AP' => 'Amapá',
                                'AM' => 'Amazonas',
                                'BA' => 'Bahia',
                                'CE' => 'Ceará',
                                'DF' => 'Distrito Federal',
                                'ES' => 'Espírito Santo',
                                'GO' => 'Goiás',
                                'MA' => 'Maranhão',
                                'MT' => 'Mato Grosso',
                                'MS' => 'Mato Grosso do Sul',
                                'MG' => 'Minas Gerais',
                                'PA' => 'Pará',
                                'PB' => 'Paraíba',
                                'PR' => 'Paraná',
                                'PE' => 'Pernambuco',
                                'PI' => 'Piauí',
                                'RJ' => 'Rio de Janeiro',
                                'RN' => 'Rio Grande do Norte',
                                'RS' => 'Rio Grande do Sul',
                                'RO' => 'Rondônia',
                                'RR' => 'Roraima',
                                'SC' => 'Santa Catarina',
                                'SP' => 'São Paulo',
                                'SE' => 'Sergipe',
                                'TO' => 'Tocantins'
                            ];
                            $estadoAtual = $detalhes['estado'] ?? '';
                            foreach ($estados as $sigla => $nome):
                            ?>
                                <option value="<?php echo $sigla; ?>" <?php echo ($estadoAtual === $sigla) ? 'selected' : ''; ?>><?php echo $nome; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="zipcode">CEP *</label>
                        <input type="text" id="zipcode" name="zipcode" required value="<?php echo htmlspecialchars($detalhes['cep'] ?? ''); ?>" placeholder="00000-000" maxlength="9">
                    </div>
                </div>
            </div>

            <!-- Contato -->
            <div class="form-section">
                <h3 class="section-title-form">Contato</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Telefone *</label>
                        <input type="tel" id="phone" name="phone" required value="<?php echo htmlspecialchars($detalhes['telefone'] ?? ''); ?>" placeholder="(11) 99999-9999" maxlength="15">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($detalhes['email'] ?? ''); ?>" placeholder="contato@restaurante.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="website">Website (opcional)</label>
                    <input type="url" id="website" name="website" value="<?php echo htmlspecialchars($detalhes['website'] ?? ''); ?>" placeholder="https://www.restaurante.com">
                </div>
            </div>

            <!-- Horários de Funcionamento -->
            <div class="form-section">
                <h3 class="section-title-form">Horários de Funcionamento</h3>
                
                <div class="schedule-container">
                    <?php 
                    $days = [
                        'Segunda-feira' => ['18:00', '23:00'],
                        'Terça-feira' => ['18:00', '23:00'],
                        'Quarta-feira' => ['18:00', '23:00'],
                        'Quinta-feira' => ['18:00', '23:00'],
                        'Sexta-feira' => ['18:00', '00:00'],
                        'Sábado' => ['18:00', '00:00'],
                        'Domingo' => ['12:00', '22:00']
                    ];
                    foreach($days as $day => $times): 
                        $dayId = strtolower(substr($day, 0, 3));
                    ?>
                    <div class="schedule-row">
                        <div class="schedule-day">
                            <input type="checkbox" id="day_<?php echo $dayId; ?>" name="days[]" value="<?php echo $day; ?>" checked>
                            <label for="day_<?php echo $dayId; ?>"><?php echo $day; ?></label>
                        </div>
                        <div class="schedule-times">
                            <input type="time" name="opening_time[]" class="time-input" value="<?php echo $times[0]; ?>">
                            <span>às</span>
                            <input type="time" name="closing_time[]" class="time-input" value="<?php echo $times[1]; ?>">
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Características -->
            <div class="form-section">
                <h3 class="section-title-form">Características do Restaurante</h3>
                
                <div class="features-grid">
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="vegetarian" checked>
                        <span>Vegetariano</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="vegan">
                        <span>Vegano</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="gluten-free">
                        <span>Sem Glúten</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="romantic" checked>
                        <span>Romântico</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="family-friendly">
                        <span>Família</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="pet-friendly">
                        <span>Pet Friendly</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="outdoor" checked>
                        <span>Área Externa</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="live-music">
                        <span>Música ao Vivo</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="parking" checked>
                        <span>Estacionamento</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="wifi" checked>
                        <span>Wi-Fi Grátis</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="delivery">
                        <span>Delivery</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="bar">
                        <span>Bar</span>
                    </label>
                </div>
            </div>

            <!-- Formas de Pagamento -->
            <div class="form-section">
                <h3 class="section-title-form">Formas de Pagamento</h3>
                
                <div class="features-grid">
                    <label class="feature-checkbox">
                        <input type="checkbox" name="payment_methods[]" value="cash" checked>
                        <span>Dinheiro</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="payment_methods[]" value="credit-card" checked>
                        <span>Cartão de Crédito</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="payment_methods[]" value="debit-card" checked>
                        <span>Cartão de Débito</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="payment_methods[]" value="pix" checked>
                        <span>PIX</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="payment_methods[]" value="voucher">
                        <span>Vale Alimentação</span>
                    </label>
                </div>
            </div>

            <!-- Botão de Envio -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">
                    Salvar Alterações
                </button>
                <a href="dashboard.php" class="btn btn-secondary" style="margin-left: 1rem;">
                    Cancelar
                </a>
            </div>

        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>
<script>
// Máscaras de input (mesmo código do cadastro)
document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/^(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    }
});

document.getElementById('zipcode').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 8) {
        value = value.replace(/^(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    }
});

// Submissão do formulário
// O formulário faz submit normalmente para o controller (sem interceptação JS)
</script>

