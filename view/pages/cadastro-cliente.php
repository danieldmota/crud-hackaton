<?php include_once __DIR__ . '/../components/header.php'; ?>

<?php
if (!empty($_SESSION['erro'])) {
    echo '<script>alert("' . $_SESSION['erro'] . '");</script>';
    unset($_SESSION['erro']);
}
?>

<link rel="stylesheet" href="../assets/css/shared.css">
<link rel="stylesheet" href="../assets/css/pages/forms.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Cadastre-se</h1>
        <p style="font-size: 1.3rem;">Junte-se à nossa plataforma e faça reservas mais fácil</p>
    </div>
</section>

<div class="container">
    <div class="registration-form-container">
        <form id="restaurantRegistrationForm" class="registration-form" enctype="multipart/form-data" method="POST"
            action="/crud-hackaton/controller/CadastroUsuarioController.php">

            <!-- Dados do Restaurante -->
            <div class="form-section">
                <h3 class="section-title-form">Informações do Cliente</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="restaurant_name">Nome Completo *</label>
                        <input type="text" id="restaurant_name" name="nome" required placeholder="João Pedro da Silva">
                    </div>

                    <div class="form-group">
                        <label for="cpf">Cpf *</label>
                        <input type="text" id="cpf" name="cpf" required placeholder="000.000.000-00" maxlength="14">
                    </div>
                </div>
            </div>


            <!-- Contato -->
            <div class="form-section">
                <h3 class="section-title-form">Contato</h3>

                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Telefone *</label>
                        <input type="tel" id="phone" name="telefone" required placeholder="(11) 99999-9999"
                            maxlength="15">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail *</label>
                        <input type="email" id="email" name="email" required placeholder="Joao@mail.com">
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password">Senha *</label>
                    <input type="password" id="password" name="senha" required placeholder="Mínimo 8 caracteres"
                        minlength="8">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmar Senha *</label>
                    <input type="password" id="confirm_password" name="confirm_senha" required
                        placeholder="Digite novamente" minlength="8">
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
                    Já possui cadastro? <a href="login-cliente.php"
                        style="color: var(--primary-neon); font-weight: 600;">Fazer login</a>
                </p>
            </div>

        </form>
    </div>
</div>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script src="../assets/js/main.js"></script>
<script src="../assets/js/pages/cadastro-cliente.js"></script>