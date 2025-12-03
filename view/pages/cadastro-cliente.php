<?php include_once __DIR__ . '/../components/header.php'; ?>

<link rel="stylesheet" href="../assets/css/style.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Cadastre-se</h1>
        <p style="font-size: 1.3rem;">Junte-se à nossa plataforma e faça reservas mais fácil</p>
    </div>
</section>

<div class="container">
    <div class="registration-form-container">
        <form id="restaurantRegistrationForm" class="registration-form" enctype="multipart/form-data">

            <!-- Dados do Restaurante -->
            <div class="form-section">
                <h3 class="section-title-form">Informações do Cliente</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="restaurant_name">Nome Completo *</label>
                        <input type="text" id="restaurant_name" name="restaurant_name" required
                            placeholder="João Pedro da Silva">
                    </div>

                    <div class="form-group">
                        <label for="cpf">Cpf *</label>
                        <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00"
                            maxlength="14">
                    </div>
                </div>

                <div class="form-group">
                    <label for="restaurant_image">Foto de Perfil</label>
                    <input type="file" id="restaurant_image" name="restaurant_image" accept="image/*"
                        class="file-input">
                    <small style="color: var(--text-secondary); font-size: 0.9rem;">Formatos aceitos: JPG, PNG (máx.
                        5MB)</small>
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
                        <input type="email" id="email" name="email" required placeholder="Joao@mail.com">
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
                    Cadastrar
                </button>
                <p style="text-align: center; margin-top: 1rem; color: var(--text-secondary);">
                    Já possui cadastro? <a href="login-cliente.php" style="color: var(--primary-neon); font-weight: 600;">Fazer login</a>
                </p>
            </div>

        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script src="../../assets/js/main.js"></script>
<script>
    // Máscaras de input

    document.getElementById('cpf').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/^(\d{3})(\d)/, '$1.$2');
            value = value.replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3');
            value = value.replace(/\.(\d{3})(\d)/, '.$1-$2');
            e.target.value = value;
        }
    });

    document.getElementById('zipcode').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 8) {
            value = value.replace(/^(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        }
    });

    document.getElementById('phone').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/^(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        }
    });

    document.getElementById('owner_phone').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/^(\d{2})(\d)/, '($1) $2');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        }
    });

    // Validação de senha
    document.getElementById('confirm_password').addEventListener('input', function (e) {
        const password = document.getElementById('password').value;
        if (e.target.value !== password) {
            e.target.setCustomValidity('As senhas não coincidem');
        } else {
            e.target.setCustomValidity('');
        }
    });

    // Submissão do formulário
    document.getElementById('restaurantRegistrationForm').addEventListener('submit', function (e) {
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