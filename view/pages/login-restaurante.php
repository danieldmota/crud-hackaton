<?php include_once __DIR__ . '/../components/header.php'; ?>

<link rel="stylesheet" href="../assets/css/shared.css">
<link rel="stylesheet" href="../assets/css/pages/forms.css">
<link rel="stylesheet" href="../assets/css/pages/login.css">

<section class="hero-section" style="padding: 4rem 2rem;">
    <div class="container">
        <h1 style="font-size: 3rem; margin-bottom: 1rem;">Área do Restaurante</h1>
        <p style="font-size: 1.3rem;">Acesse sua conta e gerencie seu restaurante</p>
    </div>
</section>

<div class="container">
    <div class="login-container">
        <div class="login-card">
            <h2 style="font-size: 2rem; margin-bottom: 0.5rem; text-align: center;">Login</h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 2rem;">Entre com suas credenciais
            </p>

            <form action="../../controller/LoginController.php" method="POST" id="loginForm" class="login-form">
                <div class="form-group">
                    <label for="login_email">E-mail ou CNPJ</label>
                    <input type="text" id="login_email" name="login" required placeholder="CNPJ">
                    <input type="hidden" name="tipo" value="restaurante">
                </div>

                <div class="form-group">
                    <label for="login_password">Senha</label>
                    <input type="password" id="login_password" name="senha" required placeholder="Digite sua senha">
                    <a href="#"
                        style="color: var(--primary-neon); font-size: 0.9rem; float: right; margin-top: 0.5rem;">Esqueceu
                        a senha?</a>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1.5rem;">
                    Entrar
                </button>

                <p style="text-align: center; margin-top: 2rem; color: var(--text-secondary);">
                    Não possui cadastro? <a href="cadastro-restaurante.php"
                        style="color: var(--primary-neon); font-weight: 600;">Cadastre seu restaurante</a>
                </p>
            </form>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../components/footer.php'; ?>

<script src="../assets/js/main.js"></script>