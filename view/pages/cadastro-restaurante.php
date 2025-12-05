<?php
include_once __DIR__ . '/../components/header.php';
include_once __DIR__ . '/../../model/CadastroRestauranteModel.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Mostrar mensagens de sessão (erro / sucesso)
if (!empty($_SESSION['erro'])) {
    echo '<div class="alert alert-error" style="margin:1rem 2rem; padding:1rem; background:#ffe6e6; color:#800;">' . htmlspecialchars($_SESSION['erro']) . '</div>';
    unset($_SESSION['erro']);
}
if (!empty($_SESSION['sucesso'])) {
    echo '<div class="alert alert-success" style="margin:1rem 2rem; padding:1rem; background:#e6ffed; color:#064;">' . htmlspecialchars($_SESSION['sucesso']) . '</div>';
    unset($_SESSION['sucesso']);
}

$model = new CadastroRestauranteModel();

$estados = $model->listarEstados();
$categorias = $model->listarCategorias();
$caracteristicas = $model->caracteristicasDoRestaurante();
$formasPagamento = $model->listarFormasPagamento();

?>

<link rel="stylesheet" href="../assets/css/shared.css">
<link rel="stylesheet" href="../assets/css/pages/forms.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Cadastre seu Restaurante</h1>
        <p style="font-size: 1.3rem;">Junte-se à nossa plataforma e alcance mais clientes</p>
    </div>
</section>

<div class="container">
    <div class="registration-form-container">
        <form id="restaurantRegistrationForm" class="registration-form" enctype="multipart/form-data" method="POST" action="../../controller/CadastroRestauranteController.php">

            <!-- Dados do Restaurante -->
            <div class="form-section">
                <h3 class="section-title-form">Informações do Restaurante</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="restaurant_name">Nome do Restaurante *</label>
                        <input type="text" id="restaurant_name" name="restaurant_name" required
                            placeholder="Ex: La Bella Italia">
                    </div>

                    <div class="form-group">
                        <label for="cnpj">CNPJ *</label>
                        <input type="text" id="cnpj" name="cnpj" required placeholder="00.000.000/0000-00"
                            maxlength="18">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Categoria *</label>
                        <select id="category" name="category" required>
                                <option value="">Selecione a categoria</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <?php /* se o método retornar ['categoria'] (string) ou ['id','nome'] suportamos ambos */ ?>
                                    <?php if (isset($categoria['id']) && isset($categoria['nome'])): ?>
                                        <option value="<?= htmlspecialchars($categoria['nome']) ?>"><?= htmlspecialchars($categoria['nome']) ?></option>
                                    <?php elseif (isset($categoria['categoria'])): ?>
                                        <option value="<?= htmlspecialchars($categoria['categoria']) ?>"><?= htmlspecialchars($categoria['categoria']) ?></option>
                                    <?php else: ?>
                                        <option value="<?= htmlspecialchars($categoria[0] ?? '') ?>"><?= htmlspecialchars($categoria[0] ?? '') ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacidade (número de lugares) *</label>
                        <input type="number" id="capacity" name="capacity" required min="1" placeholder="Ex: 50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Descrição do Restaurante *</label>
                    <textarea id="description" name="description" required rows="4"
                        placeholder="Descreva seu restaurante, especialidades, ambiente..."></textarea>
                </div>

                <div class="form-group">
                    <label for="restaurant_image">Foto do Restaurante</label>
                    <input type="file" id="restaurant_image" name="restaurant_image" accept="image/*"
                        class="file-input">
                    <small style="color: var(--text-secondary); font-size: 0.9rem;">Formatos aceitos: JPG, PNG (máx.
                        5MB)</small>
                </div>
            </div>

            <!-- Endereço -->
            <div class="form-section">
                <h3 class="section-title-form">Endereço</h3>

                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label for="address">Rua/Avenida *</label>
                        <input type="text" id="address" name="address" required placeholder="Ex: Rua das Flores, 123">
                    </div>

                    <div class="form-group">
                        <label for="neighborhood">Bairro *</label>
                        <input type="text" id="neighborhood" name="neighborhood" required placeholder="Ex: Centro">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="city">Cidade *</label>
                        <input type="text" id="city" name="city" required placeholder="Ex: São Paulo">
                    </div>

                    <div class="form-group">
                        <label for="state">Estado *</label>
                        <select id="state" name="state" required>
                            <option value="">Selecione o estado</option>
                            <?php foreach ($estados as $estado): ?>
                                <option value="<?= $estado['sigla'] ?>"><?= $estado['nome'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="zipcode">CEP *</label>
                        <input type="text" id="zipcode" name="zipcode" required placeholder="00000-000" maxlength="9">
                    </div>
                </div>
            </div>

            <!-- Contato -->
            <div class="form-section">
                <h3 class="section-title-form">Contato</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Telefone *</label>
                        <input type="tel" id="phone" name="phone" required placeholder="(11) 99999-9999" maxlength="15">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required placeholder="contato@restaurante.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="website">Website (opcional)</label>
                    <input type="url" id="website" name="website" placeholder="https://www.restaurante.com">
                </div>
            </div>

            <!-- Horários de Funcionamento -->
            <div class="form-section">
                <h3 class="section-title-form">Horários de Funcionamento</h3>

                <div class="schedule-container">
                    <?php
                    $days = ['Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado', 'Domingo'];
                    foreach ($days as $day):
                        ?>
                        <div class="schedule-row">
                            <div class="schedule-day">
                                <input type="checkbox" id="day_<?php echo strtolower(substr($day, 0, 3)); ?>" name="days[]"
                                    value="<?php echo $day; ?>" checked>
                                <label for="day_<?php echo strtolower(substr($day, 0, 3)); ?>"><?php echo $day; ?></label>
                            </div>
                            <div class="schedule-times">
                                <input type="time" name="opening_time[]" class="time-input" value="18:00">
                                <span>às</span>
                                <input type="time" name="closing_time[]" class="time-input" value="23:00">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Características -->
            <div class="form-section">
                <h3 class="section-title-form">Características do Restaurante</h3>

                <div class="features-grid">
                    <?php foreach ($caracteristicas as $feature): ?>
                        <label class="feature-checkbox">
                            <input type="checkbox" name="features[]" value="<?= $feature['id'] ?>">
                            <span><?= $feature['nome'] ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- Formas de Pagamento -->
                <div class="form-section">
                    <h3 class="section-title-form">Formas de Pagamento</h3>

                    <div class="features-grid">
                        <?php foreach ($formasPagamento as $pagamento): ?>
                            <label class="feature-checkbox">
                                <input type="checkbox" name="payment_methods[]" value="<?= $pagamento['id'] ?>">
                                <span><?= $pagamento['nome'] ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Dados do Proprietário -->
                <div class="form-section">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Senha *</label>
                            <input type="password" id="password" name="password" required
                                placeholder="Mínimo 8 caracteres" minlength="8">
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirmar Senha *</label>
                            <input type="password" id="confirm_password" name="confirm_password" required
                                placeholder="Digite novamente" minlength="8">
                        </div>
                    </div>
                </div>
                <!-- Termos -->
                <div class="form-section">
                    <label class="terms-checkbox">
                        <input type="checkbox" id="terms" name="terms" required>
                        <span>Aceito os <a href="#" style="color: var(--primary-neon);">termos e condições</a> e a <a
                                href="#" style="color: var(--primary-neon);">política de privacidade</a> *</span>
                    </label>
                </div>

                <!-- Botão de Envio -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        Cadastrar Restaurante
                    </button>
                    <p style="text-align: center; margin-top: 1rem; color: var(--text-secondary);">
                        Já possui cadastro? <a href="login-restaurante.php"
                            style="color: var(--primary-neon); font-weight: 600;">Fazer login</a>
                    </p>
                </div>

        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/pages/cadastro-restaurante.js"></script>