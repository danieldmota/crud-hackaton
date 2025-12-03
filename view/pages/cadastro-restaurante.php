<?php include_once __DIR__ . '/../components/header.php'; ?>

<link rel="stylesheet" href="../assets/css/style.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Cadastre seu Restaurante</h1>
        <p style="font-size: 1.3rem;">Junte-se à nossa plataforma e alcance mais clientes</p>
    </div>
</section>

<div class="container">
    <div class="registration-form-container">
        <form id="restaurantRegistrationForm" class="registration-form" enctype="multipart/form-data">
            
            <!-- Dados do Restaurante -->
            <div class="form-section">
                <h3 class="section-title-form">Informações do Restaurante</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="restaurant_name">Nome do Restaurante *</label>
                        <input type="text" id="restaurant_name" name="restaurant_name" required placeholder="Ex: La Bella Italia">
                    </div>
                    
                    <div class="form-group">
                        <label for="cnpj">CNPJ *</label>
                        <input type="text" id="cnpj" name="cnpj" required placeholder="00.000.000/0000-00" maxlength="18">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Categoria *</label>
                        <select id="category" name="category" required>
                            <option value="">Selecione a categoria</option>
                            <option value="italiana">Italiana</option>
                            <option value="japonesa">Japonesa</option>
                            <option value="brasileira">Brasileira</option>
                            <option value="francesa">Francesa</option>
                            <option value="mexicana">Mexicana</option>
                            <option value="asiatica">Asiática</option>
                            <option value="pizzaria">Pizzaria</option>
                            <option value="churrascaria">Churrascaria</option>
                            <option value="fast-food">Fast Food</option>
                            <option value="vegetariana">Vegetariana</option>
                            <option value="vegana">Vegana</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="capacity">Capacidade (número de lugares) *</label>
                        <input type="number" id="capacity" name="capacity" required min="1" placeholder="Ex: 50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Descrição do Restaurante *</label>
                    <textarea id="description" name="description" required rows="4" placeholder="Descreva seu restaurante, especialidades, ambiente..."></textarea>
                </div>

                <div class="form-group">
                    <label for="restaurant_image">Foto do Restaurante</label>
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
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
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
                    foreach($days as $day): 
                    ?>
                    <div class="schedule-row">
                        <div class="schedule-day">
                            <input type="checkbox" id="day_<?php echo strtolower(substr($day, 0, 3)); ?>" name="days[]" value="<?php echo $day; ?>" checked>
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
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="vegetarian">
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
                        <input type="checkbox" name="features[]" value="romantic">
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
                        <input type="checkbox" name="features[]" value="outdoor">
                        <span>Área Externa</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="live-music">
                        <span>Música ao Vivo</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="parking">
                        <span>Estacionamento</span>
                    </label>
                    <label class="feature-checkbox">
                        <input type="checkbox" name="features[]" value="wifi">
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

            <!-- Dados do Proprietário -->
            <div class="form-section">
                <h3 class="section-title-form">Dados do Proprietário/Administrador</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="owner_name">Nome Completo *</label>
                        <input type="text" id="owner_name" name="owner_name" required placeholder="Nome completo">
                    </div>
                    
                    <div class="form-group">
                        <label for="owner_cpf">CPF *</label>
                        <input type="text" id="owner_cpf" name="owner_cpf" required placeholder="000.000.000-00" maxlength="14">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="owner_email">E-mail *</label>
                        <input type="email" id="owner_email" name="owner_email" required placeholder="seu@email.com">
                    </div>
                    
                    <div class="form-group">
                        <label for="owner_phone">Telefone *</label>
                        <input type="tel" id="owner_phone" name="owner_phone" required placeholder="(11) 99999-9999" maxlength="15">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="password">Senha *</label>
                        <input type="password" id="password" name="password" required placeholder="Mínimo 8 caracteres" minlength="8">
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirmar Senha *</label>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Digite novamente" minlength="8">
                    </div>
                </div>
            </div>

            <!-- Termos -->
            <div class="form-section">
                <label class="terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <span>Aceito os <a href="#" style="color: var(--primary-neon);">termos e condições</a> e a <a href="#" style="color: var(--primary-neon);">política de privacidade</a> *</span>
                </label>
            </div>

            <!-- Botão de Envio -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-large">
                    Cadastrar Restaurante
                </button>
                <p style="text-align: center; margin-top: 1rem; color: var(--text-secondary);">
                    Já possui cadastro? <a href="login-restaurante.php" style="color: var(--primary-neon); font-weight: 600;">Fazer login</a>
                </p>
            </div>

        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>
<script>
// Máscaras de input
document.getElementById('cnpj').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 14) {
        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
        e.target.value = value;
    }
});

document.getElementById('owner_cpf').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/^(\d{3})(\d)/, '$1.$2');
        value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1-$2');
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

document.getElementById('phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/^(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    }
});

document.getElementById('owner_phone').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/^(\d{2})(\d)/, '($1) $2');
        value = value.replace(/(\d{5})(\d)/, '$1-$2');
        e.target.value = value;
    }
});

// Validação de senha
document.getElementById('confirm_password').addEventListener('input', function(e) {
    const password = document.getElementById('password').value;
    if (e.target.value !== password) {
        e.target.setCustomValidity('As senhas não coincidem');
    } else {
        e.target.setCustomValidity('');
    }
});

// Submissão do formulário
document.getElementById('restaurantRegistrationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Validar senhas
    const password = formData.get('password');
    const confirmPassword = formData.get('confirm_password');
    
    if (password !== confirmPassword) {
        alert('As senhas não coincidem!');
        return;
    }
    
    // Aqui você faria a requisição AJAX para salvar os dados
    console.log('Dados do formulário:', Object.fromEntries(formData));
    
    // Simular envio
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'CADASTRANDO...';
    submitBtn.disabled = true;
    
    setTimeout(() => {
        alert('Cadastro realizado com sucesso! Aguarde a aprovação.');
        window.location.href = 'login.php';
    }, 2000);
});
</script>

