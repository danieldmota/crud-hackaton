<?php include_once __DIR__ . '/../../components/header.php'; ?>

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
        <form id="editProfileForm" class="registration-form" enctype="multipart/form-data">
            
            <!-- Dados do Restaurante -->
            <div class="form-section">
                <h3 class="section-title-form">Informações do Restaurante</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="restaurant_name">Nome do Restaurante *</label>
                        <input type="text" id="restaurant_name" name="restaurant_name" required value="La Bella Italia" placeholder="Ex: La Bella Italia">
                    </div>
                    
                    <div class="form-group">
                        <label for="cnpj">CNPJ *</label>
                        <input type="text" id="cnpj" name="cnpj" required value="12.345.678/0001-90" placeholder="00.000.000/0000-00" maxlength="18" readonly style="opacity: 0.7;">
                        <small style="color: var(--text-secondary); font-size: 0.9rem;">CNPJ não pode ser alterado</small>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="category">Categoria *</label>
                        <select id="category" name="category" required>
                            <option value="italiana" selected>Italiana</option>
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
                        <input type="number" id="capacity" name="capacity" required min="1" value="50" placeholder="Ex: 50">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Descrição do Restaurante *</label>
                    <textarea id="description" name="description" required rows="4" placeholder="Descreva seu restaurante, especialidades, ambiente...">O La Bella Italia oferece uma experiência gastronômica única com pratos autênticos da culinária italiana. Nossa equipe de chefs traz receitas tradicionais passadas de geração em geração, preparadas com ingredientes frescos e selecionados.</textarea>
                </div>

                <div class="form-group">
                    <label for="restaurant_image">Foto do Restaurante</label>
                    <div style="margin-bottom: 1rem;">
                        <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" alt="Foto atual" style="width: 200px; height: 150px; object-fit: cover; border-radius: 12px; border: 2px solid var(--dark-border);">
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
                        <input type="text" id="address" name="address" required value="Rua das Flores, 123" placeholder="Ex: Rua das Flores, 123">
                    </div>
                    
                    <div class="form-group">
                        <label for="neighborhood">Bairro *</label>
                        <input type="text" id="neighborhood" name="neighborhood" required value="Centro" placeholder="Ex: Centro">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="city">Cidade *</label>
                        <input type="text" id="city" name="city" required value="São Paulo" placeholder="Ex: São Paulo">
                    </div>
                    
                    <div class="form-group">
                        <label for="state">Estado *</label>
                        <select id="state" name="state" required>
                            <option value="">Selecione o estado</option>
                            <option value="SP" selected>São Paulo</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="PR">Paraná</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="BA">Bahia</option>
                            <option value="GO">Goiás</option>
                            <option value="PE">Pernambuco</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="zipcode">CEP *</label>
                        <input type="text" id="zipcode" name="zipcode" required value="01234-567" placeholder="00000-000" maxlength="9">
                    </div>
                </div>
            </div>

            <!-- Contato -->
            <div class="form-section">
                <h3 class="section-title-form">Contato</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Telefone *</label>
                        <input type="tel" id="phone" name="phone" required value="(11) 3456-7890" placeholder="(11) 99999-9999" maxlength="15">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required value="contato@labellaitalia.com" placeholder="contato@restaurante.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="website">Website (opcional)</label>
                    <input type="url" id="website" name="website" value="https://www.labellaitalia.com.br" placeholder="https://www.restaurante.com">
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
document.getElementById('editProfileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'SALVANDO...';
    submitBtn.disabled = true;
    
    setTimeout(() => {
        alert('Perfil atualizado com sucesso!');
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
        window.location.href = 'dashboard.php';
    }, 1500);
});
</script>

